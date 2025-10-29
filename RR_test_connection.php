<?php
/* RR_test_connection.php
   Comprueba conexión PDO a MySQL probando localhost y 127.0.0.1.
   Úsalo abriendo en el navegador: http://localhost/Parcial_PLP3/RR_test_connection.php
*/

$db_name = 'rr_parcial_plp3';
$db_user = 'root';
$db_pass = '';
$hosts = ['127.0.0.1', 'localhost'];

$result = [];
foreach ($hosts as $h) {
    try {
        $dsn = "mysql:host={$h};dbname={$db_name};charset=utf8mb4";
        $pdo = new PDO($dsn, $db_user, $db_pass, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
        $result[$h] = "OK - conectó correctamente usando host={$h}";
    } catch (PDOException $e) {
        $result[$h] = "ERROR ({$e->getCode()}): " . $e->getMessage();
    }
}

?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>RR - Test conexión</title>
</head>
<body style="font-family:system-ui,Segoe UI,Roboto,Arial;padding:16px;">
    <h1>Test de conexión a MySQL</h1>
    <p>Usuario probado: <strong><?php echo htmlspecialchars($db_user); ?></strong> | Contraseña vacía</p>
    <ul>
        <?php foreach ($result as $host => $msg): ?>
            <li><strong><?php echo htmlspecialchars($host); ?></strong>: <?php echo htmlspecialchars($msg); ?></li>
        <?php endforeach; ?>
    </ul>
    <hr>
    <p>Si ambos fallan:</p>
    <ol>
      <li>Verifica en XAMPP Control Panel que MySQL esté "Running" (verde).</li>
      <li>Abre <a href="/phpmyadmin">http://localhost/phpmyadmin</a> e intenta entrar con usuario <code>root</code> (sin contraseña).</li>
      <li>Si phpMyAdmin funciona y test falla, intenta reemplazar en <code>includes/RR_conexion.php</code> el host <code>127.0.0.1</code> por <code>localhost</code> o viceversa.</li>
    </ol>
</body>
</html>
