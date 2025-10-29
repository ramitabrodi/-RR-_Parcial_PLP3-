<?php

require_once __DIR__ . '/includes/RR_conexion.php';

// Crear producto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
	$name = trim($_POST['name']);
	$category = trim($_POST['category']);
	$price = floatval($_POST['price']);
	$description = trim($_POST['description']);
	$image = trim($_POST['image']);
	$stmt = $pdo->prepare('INSERT INTO rr_products (name, category, price, description, image) VALUES (:name,:category,:price,:desc,:image)');
	$stmt->execute([':name' => $name, ':category' => $category, ':price' => $price, ':desc' => $description, ':image' => $image]);
	header('Location: RR_admin.php');
	exit;
}

// Eliminar
if (isset($_GET['delete'])) {
	$id = intval($_GET['delete']);
	$stmt = $pdo->prepare('DELETE FROM rr_products WHERE id = :id');
	$stmt->execute([':id' => $id]);
	header('Location: RR_admin.php');
	exit;
}

$stmt = $pdo->query('SELECT * FROM rr_products ORDER BY id');
$products = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>RR - Admin Productos</title>
	<link rel="stylesheet" href="css/RR_estilos.css">
</head>

<body>
	<main style="padding:12px;">
		<h1>Panel Admin - Productos</h1>
		<section>
			<h2>Agregar producto</h2>
			<form method="POST">
				<input type="hidden" name="action" value="create">
				<label>Nombre</label><input name="name" required>
				<label>Categoría</label><input name="category" required>
				<label>Precio</label><input name="price" type="number" step="0.01" required>
				<label>Descripción</label><input name="description">
				<label>Imagen (nombre de archivo)</label><input name="image" value="placeholder.jpg">
				<button type="submit">Crear</button>
			</form>
		</section>

		<section>
			<h2>Listado</h2>
			<table border="1" cellpadding="6">
				<thead>
					<tr>
						<th>ID</th>
						<th>Nombre</th>
						<th>Cat</th>
						<th>Precio</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($products as $p): ?>
						<tr>
							<td><?php echo $p['id']; ?></td>
							<td><?php echo htmlspecialchars($p['name']); ?></td>
							<td><?php echo htmlspecialchars($p['category']); ?></td>
							<td><?php echo number_format($p['price'], 2); ?></td>
							<td><a href="RR_admin.php?delete=<?php echo $p['id']; ?>" onclick="return confirm('Eliminar?')">Eliminar</a></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</section>
	</main>
</body>

</html>