<?php
 $dotenv_path = __DIR__ . '/../../../../.env';
 $dotenv = parse_ini_file($dotenv_path);

// Configuración de conexión a la base de datos
$config = [
    'db_host' => $dotenv['DB_HOST'],     // Cambia esto a tu host de base de datos
    'db_name' => $dotenv['DB_NAME'], // Nombre de la base de datos
    'db_user' => $dotenv['DB_USER'],     // Usuario de la base de datos
    'db_pass' => $dotenv['DB_PASS']   // Contraseña del usuario
];

// Función para conectar a la base de datos
function conectarDB($config) {
    try {
        $dsn = "mysql:host={$config['db_host']};dbname={$config['db_name']};charset=utf8mb4";
        $opciones = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        
        $pdo = new PDO($dsn, $config['db_user'], $config['db_pass'], $opciones);
        return $pdo;
    } catch (PDOException $e) {
        // En producción, es mejor no mostrar el error exacto
        die("Error de conexión a la base de datos: " . $e->getMessage());
    }
}

// Función para obtener gastos recientes
function obtenerGastosRecientes($db, $limite = 5) {
    try {
        $sql = "SELECT g.id_gasto, g.fecha, g.descripcion, g.monto, c.nombre as categoria, 
                c.color, c.icono, CONCAT(e.nombre, ' ', e.apellido) as responsable
                FROM gastos g
                JOIN categorias_gastos c ON g.id_categoria = c.id_categoria
                JOIN empleados e ON g.id_responsable = e.id_empleado
                ORDER BY g.fecha DESC
                LIMIT :limite";
                
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Error en obtenerGastosRecientes: " . $e->getMessage());
        return [];
    }
}

// Función para obtener distribución de gastos por categoría
function obtenerDistribucionGastos($db) {
    try {
        $sql = "SELECT c.nombre, c.color, SUM(g.monto) as total
                FROM gastos g
                JOIN categorias_gastos c ON g.id_categoria = c.id_categoria
                WHERE YEAR(g.fecha) = YEAR(CURRENT_DATE)
                GROUP BY g.id_categoria
                ORDER BY total DESC";
                
        $stmt = $db->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Error en obtenerDistribucionGastos: " . $e->getMessage());
        return [];
    }
}

// Función para obtener productos con más detalles
function obtenerProductos($db) {
    try {
        $sql = "SELECT id_producto, nombre, costo_unitario, precio_venta, stock,
                (precio_venta - costo_unitario) as ganancia,
                ROUND(((precio_venta - costo_unitario) / precio_venta * 100), 1) as margen
                FROM productos
                WHERE activo = TRUE
                ORDER BY margen DESC";
                
        $stmt = $db->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Error en obtenerProductos: " . $e->getMessage());
        return [];
    }
}

// Función para obtener evolución de costos
function obtenerEvolucionCostos($db) {
    try {
        $sql = "SELECT DATE_FORMAT(fecha, '%b') as mes, 
                AVG(costo_nuevo) as costo_promedio
                FROM historial_costos
                WHERE fecha >= DATE_SUB(CURRENT_DATE, INTERVAL 6 MONTH)
                GROUP BY YEAR(fecha), MONTH(fecha)
                ORDER BY fecha";
                
        $stmt = $db->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Error en obtenerEvolucionCostos: " . $e->getMessage());
        return [];
    }
}

// Función para obtener datos de nómina
function obtenerNomina($db, $mes, $anio) {
    try {
        $sql = "SELECT n.id_nomina, CONCAT(e.nombre, ' ', e.apellido) as empleado, 
                d.nombre as departamento, e.cargo, n.sueldo_base, n.extras, n.total,
                e.id_empleado
                FROM nomina n
                JOIN empleados e ON n.id_empleado = e.id_empleado
                JOIN departamentos d ON e.id_departamento = d.id_departamento
                WHERE MONTH(n.fecha_nomina) = :mes AND YEAR(n.fecha_nomina) = :anio
                ORDER BY n.total DESC";
                
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':mes', $mes, PDO::PARAM_INT);
        $stmt->bindParam(':anio', $anio, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Error en obtenerNomina: " . $e->getMessage());
        return [];
    }
}

// Función para obtener resumen de nómina
function obtenerResumenNomina($db, $mes, $anio) {
    try {
        $sql = "SELECT SUM(sueldo_base) as total_base, 
                SUM(extras) as total_extras,
                SUM(bonos) as total_bonos,
                SUM(deducciones) as total_deducciones,
                SUM(total) as total_nomina
                FROM nomina
                WHERE MONTH(fecha_nomina) = :mes AND YEAR(fecha_nomina) = :anio";
                
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':mes', $mes, PDO::PARAM_INT);
        $stmt->bindParam(':anio', $anio, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch();
    } catch (PDOException $e) {
        error_log("Error en obtenerResumenNomina: " . $e->getMessage());
        return [];
    }
}

// Función para registrar un nuevo gasto
function registrarGasto($db, $datos) {
    try {
        $sql = "INSERT INTO gastos (fecha, descripcion, monto, id_categoria, id_responsable, notas)
                VALUES (:fecha, :descripcion, :monto, :id_categoria, :id_responsable, :notas)";
                
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':fecha', $datos['fecha']);
        $stmt->bindParam(':descripcion', $datos['descripcion']);
        $stmt->bindParam(':monto', $datos['monto']);
        $stmt->bindParam(':id_categoria', $datos['id_categoria'], PDO::PARAM_INT);
        $stmt->bindParam(':id_responsable', $datos['id_responsable'], PDO::PARAM_INT);
        $stmt->bindParam(':notas', $datos['notas']);
        $stmt->execute();
        
        return $db->lastInsertId();
    } catch (PDOException $e) {
        error_log("Error en registrarGasto: " . $e->getMessage());
        return false;
    }
}

// Función para obtener un gasto específico
function obtenerGasto($db, $id_gasto) {
    try {
        $sql = "SELECT g.*, c.nombre as categoria_nombre, CONCAT(e.nombre, ' ', e.apellido) as responsable_nombre
                FROM gastos g
                JOIN categorias_gastos c ON g.id_categoria = c.id_categoria
                JOIN empleados e ON g.id_responsable = e.id_empleado
                WHERE g.id_gasto = :id_gasto";
                
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id_gasto', $id_gasto, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch();
    } catch (PDOException $e) {
        error_log("Error en obtenerGasto: " . $e->getMessage());
        return false;
    }
}

// Función para actualizar un gasto
function actualizarGasto($db, $id_gasto, $datos) {
    try {
        $sql = "UPDATE gastos SET 
                fecha = :fecha, 
                descripcion = :descripcion, 
                monto = :monto, 
                id_categoria = :id_categoria, 
                id_responsable = :id_responsable, 
                notas = :notas
                WHERE id_gasto = :id_gasto";
                
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':fecha', $datos['fecha']);
        $stmt->bindParam(':descripcion', $datos['descripcion']);
        $stmt->bindParam(':monto', $datos['monto']);
        $stmt->bindParam(':id_categoria', $datos['id_categoria'], PDO::PARAM_INT);
        $stmt->bindParam(':id_responsable', $datos['id_responsable'], PDO::PARAM_INT);
        $stmt->bindParam(':notas', $datos['notas']);
        $stmt->bindParam(':id_gasto', $id_gasto, PDO::PARAM_INT);
        
        return $stmt->execute();
    } catch (PDOException $e) {
        error_log("Error en actualizarGasto: " . $e->getMessage());
        return false;
    }
}

// Función para actualizar un producto
function actualizarProducto($db, $id_producto, $datos) {
    try {
        $sql = "UPDATE productos SET 
                nombre = :nombre, 
                descripcion = :descripcion, 
                costo_unitario = :costo_unitario, 
                precio_venta = :precio_venta, 
                stock = :stock
                WHERE id_producto = :id_producto";
                
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':nombre', $datos['nombre']);
        $stmt->bindParam(':descripcion', $datos['descripcion']);
        $stmt->bindParam(':costo_unitario', $datos['costo_unitario']);
        $stmt->bindParam(':precio_venta', $datos['precio_venta']);
        $stmt->bindParam(':stock', $datos['stock'], PDO::PARAM_INT);
        $stmt->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);
        
        $resultado = $stmt->execute();
        
        // Si el costo ha cambiado, registrar en el historial
        if ($resultado && $datos['costo_anterior'] != $datos['costo_unitario']) {
            $sql_historial = "INSERT INTO historial_costos 
                           (id_producto, fecha, costo_anterior, costo_nuevo, razon_cambio) 
                           VALUES 
                           (:id_producto, CURRENT_DATE, :costo_anterior, :costo_nuevo, :razon_cambio)";
                           
            $stmt_historial = $db->prepare($sql_historial);
            $stmt_historial->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);
            $stmt_historial->bindParam(':costo_anterior', $datos['costo_anterior']);
            $stmt_historial->bindParam(':costo_nuevo', $datos['costo_unitario']);
            $stmt_historial->bindParam(':razon_cambio', $datos['razon_cambio']);
            $stmt_historial->execute();
        }
        
        return $resultado;
    } catch (PDOException $e) {
        error_log("Error en actualizarProducto: " . $e->getMessage());
        return false;
    }
}

// Función para obtener todas las categorías de gastos
function obtenerCategoriasGastos($db) {
    try {
        $sql = "SELECT * FROM categorias_gastos WHERE activo = TRUE ORDER BY nombre";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Error en obtenerCategoriasGastos: " . $e->getMessage());
        return [];
    }
}

// Función para obtener todos los empleados activos
function obtenerEmpleados($db) {
    try {
        $sql = "SELECT id_empleado, CONCAT(nombre, ' ', apellido) as nombre_completo 
                FROM empleados 
                WHERE activo = TRUE 
                ORDER BY nombre, apellido";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Error en obtenerEmpleados: " . $e->getMessage());
        return [];
    }
}

// Función para obtener un producto específico
function obtenerProducto($db, $id_producto) {
    try {
        $sql = "SELECT * FROM productos WHERE id_producto = :id_producto";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch();
    } catch (PDOException $e) {
        error_log("Error en obtenerProducto: " . $e->getMessage());
        return false;
    }
}

// Función para obtener el historial de costos de un producto
function obtenerHistorialCostos($db, $id_producto) {
    try {
        $sql = "SELECT h.*, p.nombre as producto_nombre
                FROM historial_costos h
                JOIN productos p ON h.id_producto = p.id_producto
                WHERE h.id_producto = :id_producto
                ORDER BY h.fecha DESC";
                
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Error en obtenerHistorialCostos: " . $e->getMessage());
        return [];
    }
}

// Función para obtener datos de presupuesto vs gastado
function obtenerComparativaPresupuesto($db) {
    try {
        $sql = "SELECT 
                c.nombre as categoria,
                SUM(g.monto) as gastado,
                (SELECT monto_anual/12 FROM presupuestos WHERE categoria = c.nombre LIMIT 1) as presupuesto_mensual
                FROM gastos g
                JOIN categorias_gastos c ON g.id_categoria = c.id_categoria
                WHERE MONTH(g.fecha) = MONTH(CURRENT_DATE) AND YEAR(g.fecha) = YEAR(CURRENT_DATE)
                GROUP BY g.id_categoria";
                
        $stmt = $db->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Error en obtenerComparativaPresupuesto: " . $e->getMessage());
        return [];
    }
}