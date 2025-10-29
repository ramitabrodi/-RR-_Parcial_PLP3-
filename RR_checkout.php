<?php
/*
RR_checkout.php
Procesamiento del formulario de checkout.
Funcionalidad:
- Recibe POST con: customer_name, customer_email, customer_address, cart_json
- Valida y sanitiza datos
- Calcula totales en servidor y guarda en las tablas rr_orders y rr_order_items
- Devuelve una confirmación simple

NOTA: requiere la base de datos importada y `includes/RR_conexion.php` configurado.
*/
require_once __DIR__ . '/includes/RR_conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: RR_index.php');
    exit;
}

$customer_name = trim($_POST['customer_name'] ?? '');
$customer_email = trim($_POST['customer_email'] ?? '');
$customer_address = trim($_POST['customer_address'] ?? '');
$cart_json = $_POST['cart_json'] ?? '';

// Validaciones básicas
if (empty($customer_name) || !filter_var($customer_email, FILTER_VALIDATE_EMAIL) || empty($cart_json)) {
    die('Datos inválidos. Por favor vuelve y completa correctamente el formulario.');
}

$cart = json_decode($cart_json, true);
if (!is_array($cart) || count($cart) === 0) die('Carrito vacío.');

// Calcular total en servidor (y validar precios desde la BD)
$total = 0.0;
$items = [];
try {
    $pdo->beginTransaction();

    // Para cada artículo validar precio actual
    $stmt = $pdo->prepare('SELECT id, price FROM rr_products WHERE id = :id');
    foreach ($cart as $id => $it) {
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) throw new Exception('Producto no encontrado: ' . $id);
        $price = (float)$row['price'];
        $qty = (int)$it['qty'];
        if ($qty <= 0) throw new Exception('Cantidad inválida para producto ' . $id);
        $sub = $price * $qty;
        $items[] = ['id' => $id, 'price' => $price, 'qty' => $qty, 'subtotal' => $sub];
        $total += $sub;
    }

    // Insertar orden
    $stmt = $pdo->prepare('INSERT INTO rr_orders (customer_name, customer_email, customer_address, total, created_at) VALUES (:name,:email,:addr,:total, NOW())');
    $stmt->execute([':name'=>$customer_name, ':email'=>$customer_email, ':addr'=>$customer_address, ':total'=>$total]);
    $orderId = $pdo->lastInsertId();

    // Insertar items
    $stmtItem = $pdo->prepare('INSERT INTO rr_order_items (order_id, product_id, price, qty, subtotal) VALUES (:order_id,:product_id,:price,:qty,:subtotal)');
    foreach ($items as $it) {
        $stmtItem->execute([':order_id'=>$orderId, ':product_id'=>$it['id'], ':price'=>$it['price'], ':qty'=>$it['qty'], ':subtotal'=>$it['subtotal']]);
    }

    $pdo->commit();
} catch (Exception $e) {
    $pdo->rollBack();
    die('Error al procesar el pedido: ' . $e->getMessage());
}

// Limpiar carrito en cliente: envia una página simple con script para limpiar sessionStorage
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Pedido confirmado</title>
    <link rel="stylesheet" href="css/RR_estilos.css">
</head>
<body>
    <main style="padding:20px;">
        <h1>Gracias, <?php echo htmlspecialchars($customer_name); ?>!</h1>
        <p>Tu pedido (ID <?php echo $orderId; ?>) fue registrado. Total: $<?php echo number_format($total,2); ?></p>
        <p>Se envió una confirmación a <?php echo htmlspecialchars($customer_email); ?> (simulado).</p>
        <a href="RR_index.php">Volver al menú</a>
    </main>

    <script>
        // Limpiar carrito (cliente)
        sessionStorage.removeItem('rr_cart_v1');
    </script>
</body>
</html>
