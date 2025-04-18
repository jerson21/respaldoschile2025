<?php require_once "init.php" ?>
<?php require_once "vistas/parte_superior.php"?>

<!--INICIO del cont principal-->

<input type="button" onclick="printDiv('container')" value="imprimir div" /><br><br>

<div class="row" style="margin:0 auto; text-align: center; ">
    <div class="col-1">
        <form method="get" action="">
            <input type="hidden" name="id" value="1">
            <input type="submit" class="btn btn-primary" value="Jaime">
        </form>
    </div>
    <div class="col-1">
        <form method="get" action="">
            <input type="hidden" name="id" value="2">
            <input type="submit" class="btn btn-primary" value="Felipe">
        </form>
    </div>
    <div class="col-1">
        <form method="get" action="https://www.respaldoschile.cl/intranet/dashboard/pagos.php">
            <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">
            <input type="submit" class="btn btn-success" value="SEMANA ACTUAL">
        </form>
    </div>
</div>
    
<?php 
// Calcular fechas para la semana anterior
$first = strtotime('last Sunday -12 days');
$last = strtotime('next sunday -14 days');
$lunespasado = date('Y-m-d', $first);
$domingo_pasado = date('Y-m-d', $last);
?>

<div class="container" id="container">
    <div>
        <span style="font-size: 20px; font-weight: bold;">Planilla de pagos - Respaldos Chile</span> 
        <?php echo "Semana del: ".$lunespasado ." al ".$domingo_pasado."<br><br>"; ?> 
    </div>

<?php 
// Incluir el archivo de conexión
require_once 'bd/conexion.php';

// Inicializar variables
$id = isset($_GET['id']) ? $_GET['id'] : 0;
$dias_trabajados = 0;
$total_final = 0;

// Validar que el ID sea numérico
if (!is_numeric($id)) {
    echo "<div class='alert alert-danger'>ID de upholsterer inválido</div>";
    exit;
}

try {
    // Inicializar la conexión usando la clase Conexion
    $objeto = new Conexion();
    $conexion = $objeto->Conectar();
    
    // Obtener información del tapicero
    $stmt_tapicero = $conexion->prepare("SELECT * FROM usuarios WHERE id = :id");
    $stmt_tapicero->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt_tapicero->execute();
    $rowss = $stmt_tapicero->fetch(PDO::FETCH_ASSOC);
    
    if (!$rowss) {
        echo "<div class='alert alert-warning'>No se encontró información del tapicero</div>";
        exit;
    }
    
    $nombre_tapicero = $rowss['nombres'] . " " . $rowss['apaterno'];
    
    // Consulta para obtener los días trabajados en el rango de fechas
    $stmt_dias = $conexion->prepare("SELECT * FROM pedido_detalle pd 
                                    INNER JOIN pedido_etapas pe ON pd.id = pe.idPedido 
                                    WHERE pd.tapicero_id = :id 
                                    AND pe.idProceso = 6 
                                    AND pe.fecha BETWEEN :fecha_inicio AND :fecha_fin 
                                    GROUP BY DATE(pe.fecha)");
    
    $stmt_dias->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt_dias->bindParam(':fecha_inicio', $lunespasado, PDO::PARAM_STR);
    $stmt_dias->bindParam(':fecha_fin', $domingo_pasado, PDO::PARAM_STR);
    $stmt_dias->execute();
    
    // Recorrer cada día trabajado
    while($rows = $stmt_dias->fetch(PDO::FETCH_ASSOC)) {
        $contador = 0;
        $total = 0;
        $fecha = $rows['fecha'];
        
        // Configurar la localización para mostrar fechas en español
        setlocale(LC_TIME, 'es_CO.UTF-8');
        
        // Mostrar la fecha formateada
        echo "<b>" . strtoupper(strftime("%A, %d de %B de %Y", strtotime($rows['fecha']))) . "</b>";
        
        // Incrementar el contador de días trabajados
        $dias_trabajados += 1;
        
        // Consulta para obtener los pedidos del día
        $stmt_pedidos = $conexion->prepare("SELECT * FROM pedido_detalle pd 
                                          INNER JOIN pedido_etapas pe ON pd.id = pe.idPedido 
                                          WHERE pd.tapicero_id = :id 
                                          AND pe.idProceso = 6 
                                          AND DATE(pe.fecha) = DATE(:fecha) 
                                          GROUP BY pd.id 
                                          ORDER BY pd.tamano");
        
        $stmt_pedidos->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt_pedidos->bindParam(':fecha', $fecha, PDO::PARAM_STR);
        $stmt_pedidos->execute();
?>
    <div class="table-responsive" style="margin:0;">
        <table id="tablatapiceross" class="table table-striped table-bordered table-condensed" style="font-size:0.8rem;">
            <thead class="text-center">
                <tr>
                    <th style="width:1rem;">Nº</th>
                    <th style="width:1rem;">Id</th>
                    <th style="width:5rem;">Modelo</th>
                    <th style="width:1rem;">Plazas</th>
                    <th style="width:1rem;">Alt</th>
                    <th style="width:1rem;">Tela</th>
                    <th style="width:2rem;">Color</th>
                    <th style="width:2rem;">Fabricacion</th>
                    <th style="width:1rem;">Pago</th>
                </tr>
            </thead>
            <tbody>
<?php
        // Procesar cada pedido del día
        while($row = $stmt_pedidos->fetch(PDO::FETCH_ASSOC)) {
            $contador++;
            $modelo = $row['modelo'];
            $plazas = $row['tamano'];
            
            // Obtener el valor de pago para este producto
            $stmt_pago = $conexion->prepare("SELECT * FROM pago_produccion pp 
                                          INNER JOIN productos_venta pv ON pv.id = pp.producto_id 
                                          WHERE pv.modelo = :modelo AND pp.tamano = :tamano");
            
            $stmt_pago->bindParam(':modelo', $modelo, PDO::PARAM_STR);
            $stmt_pago->bindParam(':tamano', $plazas, PDO::PARAM_STR);
            $stmt_pago->execute();
            
            $pago = 0;
            
            if ($stmt_pago->rowCount() > 0) {
                $rowe = $stmt_pago->fetch(PDO::FETCH_ASSOC);
                $pago = $rowe['valor_pago'];
                $total += $rowe['valor_pago'];
            }
?>
            <tr>
                <td style="height:10px; padding: 1px;border: 1px solid black;"><?php echo $contador ?></td>
                <td style="height:10px; padding: 1px;border: 1px solid black;"><?php echo $row['id'] ?></td>
                <td style="height:10px; padding: 1px;border: 1px solid black;"><?php echo "<b>".$row['modelo']."</b>" ?></td>
                <td style="height:10px; padding: 1px;border: 1px solid black;"><?php echo "<b>".$row['tamano']."</b>" ?></td>
                <td style="height:10px; padding: 1px;border: 1px solid black;"><?php echo $row['alturabase'] ?></td>
                <td style="height:10px; padding: 1px;border: 1px solid black;"><?php echo $row['tipotela'] ?></td>
                <td style="height:10px; padding: 1px;border: 1px solid black;"><?php echo $row['color'] ?></td>
                <td style="height:10px; padding: 1px;border: 1px solid black;"><?php echo $row['fecha'] ?></td>
                <td style="height:10px; padding: 1px;border: 1px solid black;"><?php echo "<b>".$pago."</b>" ?></td>
            </tr>
<?php
        }
?>
            </tbody>
        </table>

<?php
        echo "Total del dia: $" . number_format($total, 0, ',', '.');
        $total_final += $total;
        echo "<br>";
    }

    // Mostrar el resumen final
    echo "Días Trabajados: " . $dias_trabajados . " - Total Semana: <b>$" . number_format($total_final, 0, ',', '.') . "</b> - Tapicero: " . $nombre_tapicero;

} catch (PDOException $e) {
    echo "<div class='alert alert-danger'>Error en la consulta: " . $e->getMessage() . "</div>";
}
?>
</div>
</div>

<script type="text/javascript">
function printDiv(nombreDiv) {
    var contenido = document.getElementById(nombreDiv).innerHTML;
    var contenidoOriginal = document.body.innerHTML;
    
    document.body.innerHTML = contenido;
    window.print();
    document.body.innerHTML = contenidoOriginal;
}
</script>

<!--FIN del cont principal-->

<?php require_once "vistas/parte_inferior.php"?>