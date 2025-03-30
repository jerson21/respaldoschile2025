
//CAMBIAR LOS PEDIDOS DESDE PEDIDOS A LA NUEVA TABLA PEDIDO SOLO 1 NUMERO DE ORDEN POR PEDIDO

// Agregar PRODUCTOS
CREATE TABLE productos_venta (
  id_producto bigint(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  modelo varchar(255) COLLATE latin1_swedish_ci NOT NULL,
  id_categoria bigint(20) UNSIGNED,
  FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria)
);


INSERT INTO productos_venta (modelo, id_categoria) VALUES 
    ('Botone', '1'), 
    ('Botone 3 corridas de botones', '1'), 
    ('Botone 4 corridas de botones', '1'), 
    ('Liso', '1'), 
    ('Liso Completo mdf', '1'), 
    ('Liso 1.35', '1'), 
    ('Liso con costuras', '1'), 
    ('Liso con costuras 1.35', '1'), 
    ('Liso con Orejas', '1'), 
    ('Liso con Orejas y tachas', '1'), 
    ('Capitone', '1'), 
    ('Capitone orejas', '1'), 
    ('Capitone orejas y tachas', '1'), 
    ('3 corridas de botones orejas', '1'), 
    ('4 corridas de botones orejas', '1'),
    ('Plastico Polipropileno', '2'),
    ('Cic Madera', '2'),
    ('Madera Alternativo', '2'),
    ('Banqueta Simple', '3'),
    ('Banqueta Baul', '3'),
    ('Banqueta Fierro', '3'),
    ('Pouf Completo', '4'),
    ('Pouf Pata Alta', '4'),   
    ('Colchon Espumix new Basic 800', '5'),
    ('Colchon Espumix e1000 plus', '5'),
    ('Colchon SleepWell kiropractic', '5'),
    ('Colchon SleepWell Titan', '5'),
    ('Colchon SleepWell Luxory', '5'),
    ('Colchon SleepWell EuroTop', '5'),
     ('Poltrona', '6'),
    ('Sofa Br Curvo', '6'),
    ('Sofa Br gaviota', '6'),
    ('Sofa Br cuadrado', '6'),
    ('Living L Cuerpos', '6'),
    ('Chesterfield', '6'),
    ('Living 3 1+1', '6'),
    ('Living Retro', '6'),
    ('Sofa Atenas', '6'),
    ('Sofa Belgrado', '6'),
    ('Sofa Milan', '6'),
    ('Sofa Alaska', '6'),
    ('Sofa Orlando', '6'),
    ('Sofa Sidney', '6'),
    ('Sofa Dallas', '6'),
    ('Sofa Madison', '6'),
    ('Sofa Siena', '6'),
    ('Seccional Elixir(Antiguo L)', '6'),
    ('Seccional Monaco Izquierdo', '6'),
    ('Seccional Monaco Derecho', '6'),
    ('Seccional Dallas Izquierdo', '6'),
    ('Seccional Dallas Derecho', '6');

CREATE TABLE categoria_productos (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` varchar(100) DEFAULT NULL,  
  PRIMARY KEY (`id`)
); 

    INSERT INTO categoria_productos (categoria) VALUES     ('Respaldos de Cama'),     ( 'Patas de cama'),     ('Banquetas'),     ('Colchones'),     ('Sofa');



CREATE TABLE pedido (
  `num_orden` int(11) NOT NULL AUTO_INCREMENT,
  `rut_cliente` varchar(100) DEFAULT NULL,
  `fecha_ingreso` varchar(50) DEFAULT NULL,
  `vendedor` varchar(100) DEFAULT NULL,
  `estado` varchar(30) NOT NULL,
  PRIMARY KEY (`num_orden`)
); 

INSERT INTO Pedido ( num_orden, rut_cliente, fecha_ingreso, estado, vendedor)
SELECT num_orden, rut_cliente, fecha_ingreso, "", vendedor
FROM pedidos
GROUP BY num_orden;

CREATE TABLE pedido_detalle (
   `id` int(11) NOT NULL AUTO_INCREMENT,
  `num_orden` varchar(100) DEFAULT '',
  `direccion` varchar(100) DEFAULT '',
  `numero` varchar(20) DEFAULT '',
  `dpto` varchar(20) DEFAULT '',
  `region` varchar(100) DEFAULT '',
  `comuna` varchar(100) DEFAULT '',
  `modelo` varchar(100) DEFAULT '',
  `tamano` varchar(100) DEFAULT '',
  `alturabase` varchar(100) DEFAULT '',
  `tipotela` varchar(100) DEFAULT '',
  `color` varchar(100) DEFAULT '',
  `precio` varchar(11) DEFAULT '',
  `tipo_boton` varchar(50) DEFAULT '',
  `anclaje` varchar(50) DEFAULT '',
  `comentarios` varchar(255) DEFAULT '',
  `detalles_fabricacion` varchar(100) DEFAULT '',
  `fecha_ingreso` varchar(50) DEFAULT '',
  `ruta_asignada` varchar(11) DEFAULT '',
  `orden_ruta` varchar(50) DEFAULT '',
  `confirma` varchar(11) DEFAULT '',
  `tapicero_id` varchar(11) DEFAULT '',
  `pagado` varchar(11) DEFAULT '',
  `formadepago` varchar(50) DEFAULT '',
  `cod_ped_anterior` varchar(50) DEFAULT '',
  `vendedor` varchar(50) DEFAULT '',
  `estadopedido` varchar(50) DEFAULT '',
  `atencion` int(11)  DEFAULT 0,
  PRIMARY KEY (`id`)
);


INSERT INTO pedido_detalle (id,num_orden,direccion,numero,dpto,region,comuna,modelo,tamano,alturabase,tipotela,color,precio,tipo_boton,anclaje,comentarios,fecha_ingreso,ruta_asignada,orden_ruta,tapicero_id,pagado,formadepago,cod_ped_anterior,vendedor,estadopedido )
SELECT id, num_orden,direccion,numero,dpto,region,comuna,modelo,plazas,alturabase,tipotela,color,precio,tipo_boton,anclaje,comentarios,fecha_ingreso,ruta_asignada,orden_ruta,tapicero_id,pagado,formadepago,cod_ped_anterior,vendedor,estadopedido
FROM pedidos;


CREATE TABLE IF NOT EXISTS `direccion_clientes` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `rut_cliente` varchar(20) DEFAULT '',
  `direccion` varchar(60) DEFAULT '',
  `numero` varchar(20) DEFAULT '',
  `dpto` varchar(20) DEFAULT '',
  `region` varchar(60) DEFAULT '',
  `comuna` varchar(60) DEFAULT '',
  `referencia` varchar(150) DEFAULT '',
  `estado` int(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
)

INSERT INTO direccion_clientes (rut_cliente,direccion,numero,dpto,region,comuna,estado)
SELECT rut_cliente,direccion,numero,dpto,region,comuna,1
FROM pedidos;




CREATE TABLE procesos (
    idProceso INT PRIMARY KEY AUTO_INCREMENT,
    NombreProceso VARCHAR(255),
     `detalle` varchar(100)
);

CREATE TABLE pedido_Etapas (
    idEtapa INT PRIMARY KEY AUTO_INCREMENT,
    idPedido INT,
    idProceso INT,
    fecha DATE,
    usuario VARCHAR(30),
    observacion VARCHAR(100),
    FOREIGN KEY (idPedido) REFERENCES pedido_detalle(id),
    FOREIGN KEY (idProceso) REFERENCES procesos(idProceso)
);


--INSERTAR LOS REGISTROS EN LA TABLA ETAPAS PARA EL CORTE DE TELAS




INSERT INTO `procesos` (`idProceso`, `NombreProceso`, `detalle`) VALUES
(1, 'ACEPTAR PEDIDO', 'PEDIDO ACEPTADO'),
(2, 'ENVIADO A FABRICACIÓN', 'PEDIDO ENVIADO A FABRICACIÓN'),
(3, 'TELA CORTADA', 'CORTE DE TELA REALIZADO'),
(4, 'CORTE Y ARMADO DE ESQUELETO', 'ARMADO DE ESQUELETO'),
(5, 'FABRICANDO', 'COMIENZO DE FABRICACION'),
(6, 'FABRICADO', 'PRODUCTO FABRICADO'),
(7, 'DESPACHO INICIADO', 'EMBALAJE Y DESPACHO'),
(8, 'CARGADO EN CAMION', 'PRODUCTO ESCANEADO Y CARGADO EN CAMION'),
(9, 'PRODUCTO ENTREGADO', 'PRODUCTO ENTREGADO AL CLIENTE'),
(10, 'PRODUCTO DEVUELTO POR ERROR DE FABRICACION', 'PRODUCTO DEVUELTO POR ERROR DE FABRICACION'),
(11, 'DEVUELTO POR DISCONFORMIDAD', 'PRODUCTO DEVUELTO POR DISCONFORMIDAD DEL CLIENTE'),
(12, 'DEVUELTO POR FALLA EN CARGA', 'DEVUELTO POR UNA FALLA EN CARGARLO POR DESPACHADOR'),
(13, 'DEVUELTO POR OTRO MOTIVO', 'MOTIVO ESPECIAL'),
(14, 'PRODUCTO DEVUELTO POR GARANTÍA', 'PRODUCTO DEVUELTO POR GARANTIA'),
(15, 'PRODUCTO DEVUELTO CLIENTE NO CONTESTA', 'PRODUCTO DEVUELTO YA QUE EL CLIENTE NO CONTESTA'),
(16, 'CLIENTE CONFIRMA QUE PUEDE RECIBIR', 'CLIENTE CONFIRMA E INDICA ALGUN DETALLE ADICIONAL'),
(17, 'CLIENTE SOLICITA FACTURA', 'SOLICITUD DE CLIENTE');

--1 - ACEPTAR PEDIDO
/*2 ENVIAR A FABRICACIÓN */
INSERT INTO pedido_etapas (IDPedido, idProceso, Fecha,usuario)
SELECT id, 2, fecha_enviofabricacion,4
FROM pedidos
WHERE fecha_enviofabricacion != '';
/*3  TELA CORTADA*/
INSERT INTO pedido_etapas (IDPedido, idProceso, Fecha,usuario)
SELECT id, 3, CURRENT_DATE,7
FROM pedidos
WHERE tela_cortada = 1;

/*4 - CORTE Y ARMADO DE ESQUELETO*/
/*5 - FABRICANDO*/
INSERT INTO pedido_etapas (IDPedido, idProceso, Fecha,usuario)
SELECT id, 5, fecha_fabricacion,tapicero_id
FROM pedidos
WHERE fecha_fabricacion != '';
/*6 - FABRICADO*/
INSERT INTO pedido_etapas (IDPedido, idProceso, Fecha,usuario)
SELECT id, 6, fecha_fabricacion,tapicero_id
FROM pedidos
WHERE fecha_fabricacion != '';

--7 - DESPACHO INICIADO*/
--8 - CARGADO EN CAMION*/
--9 - PRODUCTO ENTREGADO*/
--10 - PRODUCTO DEVUELTO POR ERROR DE FABRICACIÓN*/
--11 - DEVUELTO POR DISCONFORMIDAD*/
--12 - DEVUELTO POR FALLA EN CARGA
--13 - DEVUELTO POR OTRO MOTIVO
--14 - PRODUCTO DEVUELTO POR GARANTÍA
--15 - PRODUCTO DEVUELTO CLIENTE NO CONTESTA
--16 - CLIENTE CONFIRMA QUE PUEDE RECIBIR
--17 - CLIENTE SOLICITA FACTURA