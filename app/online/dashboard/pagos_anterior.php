<?php require_once "init.php" ?>
<?php require_once "vistas/parte_superior.php"?>
<?php require_once "bd/conexion.php" ?>

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
        <form method="get" action="pagos.php">
            <input type="hidden" name="id" value="<?php echo $_GET['id'];?>">
            <input type="submit" class="btn btn-success" value="SEMANA ACTUAL">
        </form>
    </div>
</div>
    
<?php 
$first = strtotime('last Sunday -6 days');
$last = strtotime('next sunday -7 days');
$lunespasado = date('Y-m-d', $first);
$domingo_pasado = date('Y-m-d', $last);
?>

<div class="container" id="container">
    <div>
        <span style="font-size: 20px; font-weight: bold;">Planilla de pagos - Respaldos Chile</span> 
        <?php echo "Semana del: ".$lunespasado ." al ".$domingo_pasado."<br><br>"; ?> 
    </div>

<?php 
// Iniciar la conexión a la base de datos usando PDO
$conexion = new Conexion();
$pdo = $conexion->conectar();

$id = isset($_GET['id']) ? $_GET['id'] : 0;
$dias_trabajados = 0;
$total_final = 0;

// Obtener información del tapicero
$query = "SELECT * FROM usuarios WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$tapicero = $stmt->fetch();
$nombre_tapicero = $tapicero['nombres'] . " " . $tapicero['apaterno'];

// Consulta para obtener días trabajados
$query = "SELECT * FROM pedido_detalle pd 
          INNER JOIN pedido_etapas pe ON pd.id = pe.idPedido 
          WHERE pd.tapicero_id = :id 
          AND pe.idProceso = 6 
          AND pe.fecha BETWEEN :fecha_inicio AND :fecha_fin 
          GROUP BY DATE(pe.fecha)";

$stmt = $pdo->prepare($query);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->bindParam(':fecha_inicio', $lunespasado);
$stmt->bindParam(':fecha_fin', $domingo_pasado);
$stmt->execute();

while($rows = $stmt->fetch()) {
    $contador = 0;
    $fecha = $rows['fecha'];

    setlocale(LC_TIME, 'es_CO.UTF-8');
    echo $fechas = "<b>" . strtoupper(strftime("%A, %d de %B de %Y", strtotime($rows['fecha']))) . "</b>";

    $dias_trabajados += 1;

    // Consulta para obtener detalles de los pedidos del día
    $query_detalle = "SELECT * FROM pedido_detalle pd 
                     INNER JOIN pedido_etapas pe ON pd.id = pe.idPedido 
                     WHERE pd.tapicero_id = :id 
                     AND pe.idProceso = 6 
                     AND DATE(pe.fecha) = DATE(:fecha) 
                     GROUP BY pd.id 
                     ORDER BY pd.tamano";

    $stmt_detalle = $pdo->prepare($query_detalle);
    $stmt_detalle->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt_detalle->bindParam(':fecha', $fecha);
    $stmt_detalle->execute();
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
    $total = 0;
    while($row = $stmt_detalle->fetch()) {
        $contador += 1;
        $modelo = $row['modelo'];
        $plazas = $row['tamano'];
        
        // Consulta para obtener el valor de pago
        $query_pago = "SELECT * FROM pago_produccion pp 
                      INNER JOIN productos_venta pv ON pv.id = pp.producto_id 
                      WHERE pv.modelo = :modelo AND pp.tamano = :plazas";
        
        $stmt_pago = $pdo->prepare($query_pago);
        $stmt_pago->bindParam(':modelo', $modelo);
        $stmt_pago->bindParam(':plazas', $plazas);
        $stmt_pago->execute();
        
        $pago = 0;
        if ($stmt_pago->rowCount() > 0) {
            $pago_row = $stmt_pago->fetch();
            $pago = $pago_row['valor_pago'];
            $total += $pago;
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
            <td style="height:10px; padding: 1px;border: 1px solid black;"><?php echo "<b>".$pago."</b>"?></td>
        </tr>
<?php
    }
?>
            </tbody>        
        </table>  
        
        <?php
        echo "Total del dia: $".$total;
        $total_final += $total;
        echo "<br>";
    }

    echo "Días Trabajados: ".$dias_trabajados." - Total Semana: <b>$".$total_final."</b> - Tapicero: ".$nombre_tapicero;
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