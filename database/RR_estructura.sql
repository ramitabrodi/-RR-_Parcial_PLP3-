-- Crear nuevo usuario específico para la aplicación
CREATE USER IF NOT EXISTS 'rr_user'@'localhost' IDENTIFIED BY 'rr123456';
GRANT ALL PRIVILEGES ON rr_parcial_plp3.* TO 'rr_user'@'localhost';
FLUSH PRIVILEGES;