<?php
/*
RR_index.php
Página principal (Menú) de FoodExpress - Proyecto 'FoodExpress'
Prefijo: RR (Ramiro Rivero)

Funcionalidad:
- Muestra productos (obtenidos desde la base de datos `rr_parcial_plp3` / tabla `rr_products`)
- Permite filtrar por categoría (cliente)
- Cada producto tiene botón "Agregar al carrito" que usa JS para manejar carrito dinámico sin recargar
- Contador de items en el header

Nota: Configura la DB en `includes/RR_conexion.php` antes de usar.
*/
require_once __DIR__ . '/includes/RR_conexion.php';

// Obtener categorías y productos
try {
    $stmt = $pdo->query("SELECT DISTINCT category FROM rr_products ORDER BY category");
    $categories = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $stmt = $pdo->query("SELECT * FROM rr_products ORDER BY id");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die('Error al obtener productos: ' . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>FoodExpress - Menú</title>
    <link rel="stylesheet" href="css/RR_estilos.css">
</head>
<body>
    <header class="rr-header">
        <h1>FoodExpress</h1>
        <div class="rr-cart-indicator">Carrito: <span id="rr-cart-count">0</span></div>
    </header>

    <main class="container">
        <section class="filters">
            <button class="rr-filter-btn" data-category="all">Todas</button>
            <?php foreach ($categories as $cat): ?>
                <button class="rr-filter-btn" data-category="<?php echo htmlspecialchars($cat); ?>"><?php echo htmlspecialchars($cat); ?></button>
            <?php endforeach; ?>
        </section>

        <section id="rr-products" class="rr-products">
            <?php foreach ($products as $p): ?>
                <article class="rr-product-card" data-category="<?php echo htmlspecialchars($p['category']); ?>">
                    <img src="RR_assets/images/<?php echo htmlspecialchars($p['image']); ?>" alt="<?php echo htmlspecialchars($p['name']); ?>">
                    <h3><?php echo htmlspecialchars($p['name']); ?></h3>
                    <p class="rr-price">$<?php echo number_format($p['price'],2); ?></p>
                    <p class="rr-desc"><?php echo htmlspecialchars($p['description']); ?></p>
                    <div class="rr-actions">
                        <input type="number" min="1" value="1" class="rr-qty" data-id="<?php echo $p['id']; ?>">
                        <button class="rr-add-btn" data-id="<?php echo $p['id']; ?>" data-name="<?php echo htmlspecialchars($p['name']); ?>" data-price="<?php echo $p['price']; ?>">Agregar</button>
                    </div>
                </article>
            <?php endforeach; ?>
        </section>

        <aside class="rr-cart-panel">
            <h2>Carrito</h2>
            <div id="rr-cart-items"></div>
            <div class="rr-cart-summary">Total: $<span id="rr-cart-total">0.00</span></div>

            <form id="rr-checkout-form" method="POST" action="RR_checkout.php">
                <input type="hidden" name="cart_json" id="rr-cart-json">
                <label>Nombre</label>
                <input type="text" name="customer_name" required>
                <label>Email</label>
                <input type="email" name="customer_email" required>
                <label>Dirección</label>
                <textarea name="customer_address" required></textarea>
                <button type="submit" class="rr-checkout-btn">Confirmar pedido</button>
            </form>
        </aside>

    </main>

    <script src="js/RR_script.js" defer></script>
</body>
</html>
