-- RR_datos.sql
USE `rr_parcial_plp3`;

-- Insertar 10 productos de ejemplo
INSERT INTO rr_products (name, category, price, description, image) VALUE
('Hamburguesa Clásica','Hamburguesas', 850.00, 'Carne, lechuga, tomate, queso', 'hamburguesa.jpg'),
('Papas Fritas','Acompañamientos', 250.00, 'Papas crocantes', 'papas.jpg'),
('Pechuga a la Plancha','Pollo', 750.00, 'Pechuga marinada y grillada', 'pechuga.jpg'),
('Ensalada César','Ensaladas', 620.00, 'Lechuga, pollo, queso parmesano', 'cesar.jpg'),
('Pizza Margarita','Pizzas', 950.00, 'Tomate, mozzarella, albahaca', 'pizza.jpg'),
('Fettuccine Alfredo','Pasta', 880.00, 'Salsa cremosa y parmesano', 'fettuccine.jpg'),
('Sándwich Vegetal','Sándwiches', 540.00, 'Pan integral y vegetales frescos', 'sandwich.jpg'),
('Helado Vainilla','Postres', 220.00, 'Helado artesanal', 'helado.jpg'),
('Bebida Cola 500ml','Bebidas', 180.00, 'Refresco cola', 'cola.jpg'),
('Nuggets Pollo (6)','Pollo', 300.00, 'Crujientes', 'nuggets.jpg');
