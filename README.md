# RR_Parcial_PLP3 — FoodExpress (Ramiro Rivero)

Proyecto de ejemplo para el examen PLP III — FoodExpress (Sistema de pedidos online).

Estructura creada:

- `RR_index.php` — Página principal (menú y carrito)
- `RR_admin.php` — Panel administrativo mínimo (crear / listar / eliminar productos)
- `RR_checkout.php` — Procesamiento del pedido y guardado en BD
- `css/RR_estilos.css` — Estilos (mobile-first)
- `js/RR_script.js` — Lógica del carrito (documentado al inicio)
- `includes/RR_conexion.php` — Conexión PDO a MySQL (configurar credenciales)
- `database/RR_estructura.sql` — Estructura de BD (exportar/importar)
- `database/RR_datos.sql` — Datos de ejemplo (10 productos)

Instalación rápida (XAMPP en Windows):

1. Copia la carpeta al directorio de XAMPP: por ejemplo `C:\xampp\htdocs\Parcial_PLP3`.
2. Abre phpMyAdmin o la consola MySQL e importa `database/RR_estructura.sql` y luego `database/RR_datos.sql`.
3. Ajusta las credenciales en `includes/RR_conexion.php` (usuario/clave).
4. Abre en el navegador: `http://localhost/Parcial_PLP3/RR_index.php`

Notas:
- Los assets de imágenes se esperan en `RR_assets/images/` (usa los nombres indicados en `RR_datos.sql`).
- El admin no tiene autenticación fuerte — si lo vas a usar en producción protege el acceso.

Requisitos implementados (resumen):
- Nivel 2: Carrito dinámico (agregar/eliminar sin recarga, subtotales, validación, contador)
- Nivel 3: Backend en PHP con conexión a MySQL, guardado de pedidos en `rr_orders` y `rr_order_items`, CRUD mínimo de productos
- Nivel 4: Diseño mobile-first, paleta de colores, tipografía del sistema, 3 breakpoints y transiciones suaves
