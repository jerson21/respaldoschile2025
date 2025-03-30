CREATE TABLE tamanos (
    id_tamano INT AUTO_INCREMENT PRIMARY KEY,
    id_producto BIGINT(20) UNSIGNED,
    tamano VARCHAR(255),
    precio DECIMAL(10, 2),
    FOREIGN KEY (id_producto) REFERENCES productos_venta(id)
);



INSERT INTO tamanos (id_producto, tamano, precio) 
SELECT id, '1 plaza', 0 FROM productos_venta WHERE id_categoria IN ('1', '2', '3', '6');
INSERT INTO tamanos (id_producto, tamano, precio) 
SELECT id, '1.5 plazas', 0 FROM productos_venta WHERE id_categoria IN ('1', '2', '3', '6');
INSERT INTO tamanos (id_producto, tamano, precio) 
SELECT id, '2 plazas', 0 FROM productos_venta WHERE id_categoria IN ('1', '2', '3', '6');
INSERT INTO tamanos (id_producto, tamano, precio) 
SELECT id, 'King', 0 FROM productos_venta WHERE id_categoria IN ('1', '2', '3', '6');
INSERT INTO tamanos (id_producto, tamano, precio) 
SELECT id, 'Super King', 0 FROM productos_venta WHERE id_categoria IN ('1', '2', '3', '6');



CREATE TABLE IF NOT EXISTS productos_materiales (
    id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    modelo VARCHAR(255) NOT NULL,
    tipo_producto VARCHAR(50) NOT NULL,
    espuma INT DEFAULT 0,
    chapon INT DEFAULT 0,
    corchetes INT DEFAULT 0,
    tabla INT DEFAULT 0,
    costura INT DEFAULT 0,
    tafetan INT DEFAULT 0,
    tela INT DEFAULT 0,
    esqueletero INT DEFAULT 0,
    valortapiz INT DEFAULT 0,
    alusa INT DEFAULT 0
);

-- Inserta tamaños y materiales para productos de la categoría '1'
INSERT INTO productos_materiales (modelo, tipo_producto, espuma, chapon, corchetes, tabla, costura, tafetan, tela, esqueletero, valortapiz, alusa)
SELECT modelo, tipo_producto, 5000, 2000, 1000, 3000, 1500, 500, 10000, 2500, 4000, 1000 
FROM productos_venta 
WHERE id_categoria = '1';

-- Inserta tamaños y materiales para productos de la categoría '2'
INSERT INTO productos_materiales (modelo, tipo_producto, espuma, chapon, corchetes, tabla, costura, tafetan, tela, esqueletero, valortapiz, alusa)
SELECT modelo, tipo_producto, 5500, 2200, 1200, 3500, 1700, 700, 11000, 2700, 4200, 1200 
FROM productos_venta 
WHERE id_categoria = '2';

-- Inserta tamaños y materiales para productos de la categoría '3'
INSERT INTO productos_materiales (modelo, tipo_producto, espuma, chapon, corchetes, tabla, costura, tafetan, tela, esqueletero, valortapiz, alusa)
SELECT modelo, tipo_producto, 6000, 2400, 1400, 4000, 1900, 900, 12000, 2900, 4400, 1400 
FROM productos_venta 
WHERE id_categoria = '3';

