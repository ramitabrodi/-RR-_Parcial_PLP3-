<?php
// Configuración mínima para XAMPP
$pdo = new PDO(
    "mysql:host=localhost;dbname=rr_parcial_plp3",
    "root",
    "",
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
);

try {
    // Opciones PDO específicas para XAMPP
    $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",
        // Forzar autenticación nativa de MySQL
        PDO::MYSQL_ATTR_LOCAL_INFILE => true,
        PDO::ATTR_EMULATE_PREPARES => false
    );

    // Conexión usando el controlador MySQL nativo
    $pdo = new PDO(
        "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4",
        $db_user,
        $db_pass,
        $options
    );
    
} catch (PDOException $e) {
    die('Error de conexión: ' . $e->getMessage());
}

try {
	$pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass, [
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	]);
} catch (PDOException $e) {
	die('Conexión fallida: ' . $e->getMessage());
}
