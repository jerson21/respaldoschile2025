<?php require_once "init.php" ?>
<?php require_once "vistas/parte_superior.php"?>

<!--INICIO del cont principal-->
<div class="container">
    <h1>Ordenes de entrega por cliente Respaldos Chile</h1>
</div>

<?php
// Incluir el archivo de conexión utilizando la clase Conexion
require_once 'bd/conexion.php';

// Obtener el RUT del cliente con validación
$rut = isset($_GET['rut']) ? $_GET['rut'] : '';

// Validar que el RUT no esté vacío
if (empty($rut)) {
    echo "<div class='alert alert-danger'>RUT no proporcionado</div>";
    exit;
}

try {
    // Inicializar la conexión usando la clase Conexion
    $objeto = new Conexion();
    $conexion = $objeto->Conectar();
    
    // Consulta para obtener las órdenes del cliente
    $query = "SELECT *, count(pd.id) as cantidad_prod 
              FROM pedido p 
              INNER JOIN pedido_detalle pd ON p.num_orden = pd.num_orden 
              WHERE rut_cliente = :rut 
              GROUP BY p.num_orden";
    
    $stmt = $conexion->prepare($query);
    $stmt->bindParam(':rut', $rut, PDO::PARAM_STR);
    $stmt->execute();
?>

<div style="margin:0 auto; text-align: center;">
    <div style="background: white; border:solid thin; border-radius: 15px; border-color: #D1D1D1; width:700px; height: 100%; display: inline-block; margin-top: 50px; padding: 5px;">
        <table id="tablatapiceross" class="table table-striped table-bordered table-condensed" style="width:100%; font-size:0.8rem; padding: 5px;">
            <thead class="text-center">
                <tr>
                    <th style="width:2rem;">Id</th>
                    <th style="width:5rem;">Rut</th>
                    <th style="width:15rem;">Direccion</th>
                    <th style="width:15rem;">Fecha de Entrega</th>
                    <th style="width:5rem;">Cantidad de Productos</th>
                    <th>Agregar un producto</th>
                </tr>
            </thead>
            <tbody>
            <?php
            // Verificar si hay resultados
            if ($stmt->rowCount() > 0) {
                // Recorrer los resultados
                while ($dat = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $ruta_asignada = $dat['ruta_asignada'];
                    $cantidad_prod = $dat['cantidad_prod'];
                    $numero_orden = $dat['num_orden'];
                    
                    // Obtener la fecha de entrega de la ruta asignada
                    $fecha = "Por asignar";
                    
                    if (!empty($ruta_asignada)) {
                        $query_ruta = "SELECT fecha FROM rutas WHERE id = :ruta_id";
                        $stmt_ruta = $conexion->prepare($query_ruta);
                        $stmt_ruta->bindParam(':ruta_id', $ruta_asignada, PDO::PARAM_INT);
                        $stmt_ruta->execute();
                        
                        if ($stmt_ruta->rowCount() > 0) {
                            $row_ruta = $stmt_ruta->fetch(PDO::FETCH_ASSOC);
                            $fecha_db = $row_ruta['fecha'];
                            
                            if (!empty($fecha_db)) {
                                setlocale(LC_TIME, 'es_CO.UTF-8');
                                $fecha = strftime("%A, %d de %B de %Y", strtotime($fecha_db));
                            }
                        }
                    }
            ?>
                <tr>
                    <td style="height:10px; padding: 1px;"><?php echo $numero_orden; ?></td>
                    <td style="height:10px; padding: 1px;"><?php echo $dat['rut_cliente']; ?></td>
                    <td style="height:10px; padding: 1px;"><?php echo $dat['direccion']." ".$dat['numero']." ".$dat['comuna']; ?></td>
                    <td style="height:10px; padding: 1px;"><?php echo $fecha; ?></td>
                    <td style="height:10px; padding: 1px;"><?php echo $cantidad_prod; ?></td>
                    <td style="height:10px; padding: 1px;">
                        <a title="Ver Ordenes" href="agregarpedido.php?num_orden=<?php echo $numero_orden; ?>">
                            <img src='img/add.png' width='40' alt='Ver Ordenes' />
                        </a>
                    </td>
                </tr>
            <?php
                }
            } else {
                // No hay órdenes para este cliente
                echo "<tr><td colspan='6' class='text-center'>No se encontraron órdenes para este cliente</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<?php
} catch (PDOException $e) {
    echo "<div class='alert alert-danger'>Error en la consulta: " . $e->getMessage() . "</div>";
}
?>

<!--FIN del cont principal-->

<?php require_once "vistas/parte_inferior.php"?>