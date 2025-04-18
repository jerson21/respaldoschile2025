<?php require_once "init.php" ?>
<?php require_once "vistas/parte_superior.php" ?>

<!--INICIO del cont principal-->

<input type="button" onclick="printDiv('container')" value="imprimir div" /><br><br>

<div class="row" style="margin:0 auto; text-align: center;">
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
        <form method="get" action="pagos_anterior.php">
            <input type="hidden" name="id" value="<?php if (isset($_GET['id'])) { echo $_GET['id']; } ?>">
            <input type="submit" class="btn btn-secondary" value="SEMANA ANTERIOR">
        </form>
    </div>
</div>

<div class="container" id="container">
    <div>
        <span style="font-size: 20px; font-weight: bold;">Planilla de pagos - Respaldos Chile</span>
        <?php
            echo "Semana del: " . date('Y-m-d', strtotime('monday this week')) . " al " . date('Y-m-d', strtotime('friday this week')) . "<br><br>";
        ?>
    </div>

    <?php
    if (isset($_GET['id'])) {
        // Convertir a entero para evitar inyección SQL
        $id = (int) $_GET['id'];

        // Se incluye el archivo de conexión PDO
        require_once "bd/conexion.php"; // Se espera que este archivo cree la variable $conexion (instancia de PDO)
        $objeto = new Conexion();
        $conexion = $objeto->Conectar();
        $pago = 0;
        $total = 0;
        $total_final = 0;

        // Obtener información del usuario
        $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $rowss = $stmt->fetch(PDO::FETCH_ASSOC);
        $nombre_tapicero = $rowss['nombres'] . " " . $rowss['apaterno'];

        $dias_trabajados = 0;

        // Consulta para obtener las fechas (días trabajados) para la semana actual
        $stmt2 = $conexion->prepare("SELECT * FROM pedido_detalle pd 
                                     INNER JOIN pedido_etapas pe ON pd.id = pe.idPedido 
                                     WHERE pd.tapicero_id = :id 
                                       AND pe.idProceso = 6 
                                       AND YEARWEEK(DATE_FORMAT(pe.fecha, '%Y-%m-%d'), 1) = YEARWEEK(CURDATE(), 1) 
                                     GROUP BY DATE(pe.fecha)");
        $stmt2->execute([':id' => $id]);

        while ($rows = $stmt2->fetch(PDO::FETCH_ASSOC)) {
            $contador = 0;
            $fecha = $rows['fecha'];
            setlocale(LC_TIME, 'es_CO.UTF-8');
            echo "<b>" . strtoupper(strftime("%A, %d de %B de %Y", strtotime($fecha))) . "</b><br>";

            $dias_trabajados++;

            // Consulta para obtener los pedidos del día actual
            $stmt3 = $conexion->prepare("SELECT * FROM pedido_detalle pd 
                                         INNER JOIN pedido_etapas pe ON pd.id = pe.idPedido 
                                         WHERE pd.tapicero_id = :id 
                                           AND pe.idProceso = 6 
                                           AND DATE(pe.fecha) = DATE(:fecha) 
                                         GROUP BY pd.id 
                                         ORDER BY pd.tamano");
            $stmt3->execute([':id' => $id, ':fecha' => $fecha]);
            ?>
            <div class="table-responsive" style="margin:0;">
                <table id="tablatapiceross" class="table table-striped table-bordered table-condensed" style="font-size:0.8rem;">
                    <thead class="text-center">
                        <tr>
                            <th style="width:1rem;">Nº</th>
                            <th style="width:1rem;">Id</th>
                            <th style="width:5rem;">Modelo</th>
                            <th style="width:1rem;">Tamano</th>
                            <th style="width:1rem;">Alt</th>
                            <th style="width:1rem;">Tela</th>
                            <th style="width:2rem;">Color</th>
                            <th style="width:2rem;">Fabricacion</th>
                            <th style="width:1rem;">Pago</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    while ($row = $stmt3->fetch(PDO::FETCH_ASSOC)) {
                        $contador++;
                        $modelo = $row['modelo'];
                        $plazas = $row['tamano'];

                        // Consulta para obtener el pago correspondiente al modelo y tamano
                        $stmt4 = $conexion->prepare("SELECT * FROM pago_produccion pp 
                                                     INNER JOIN productos_venta pv ON pv.id = pp.producto_id 
                                                     WHERE pv.modelo = :modelo AND pp.tamano = :plazas");
                        $stmt4->execute([':modelo' => $modelo, ':plazas' => $plazas]);
                        $pagos = $stmt4->fetchAll(PDO::FETCH_ASSOC);
                        if ($pagos && count($pagos) > 0) {
                            foreach ($pagos as $rowe) {
                                $pago = $rowe['valor_pago'];
                                $total += $rowe['valor_pago'];
                            }
                        } else {
                            $pago = 0;
                            $total += 0;
                        }
                        ?>
                        <tr>
                            <td style="height:10px; padding: 1px; border: 1px solid black;"><?php echo $contador ?></td>
                            <td style="height:10px; padding: 1px; border: 1px solid black;"><?php echo $row['id'] ?></td>
                            <td style="height:10px; padding: 1px; border: 1px solid black;"><?php echo "<b>" . $row['modelo'] . "</b>" ?></td>
                            <td style="height:10px; padding: 1px; border: 1px solid black;"><?php echo "<b>" . $row['tamano'] . "</b>" ?></td>
                            <td style="height:10px; padding: 1px; border: 1px solid black;"><?php echo $row['alturabase'] ?></td>
                            <td style="height:10px; padding: 1px; border: 1px solid black;"><?php echo $row['tipotela'] ?></td>
                            <td style="height:10px; padding: 1px; border: 1px solid black;"><?php echo $row['color'] ?></td>
                            <td style="height:10px; padding: 1px; border: 1px solid black;"><?php echo $row['fecha'] ?></td>
                            <td style="height:10px; padding: 1px; border: 1px solid black;"><?php echo "<b>" . $pago . "</b>" ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <?php
            echo "Total del dia: $" . $total . "<br>";
            $total_final += $total;
            $total = 0;
        }

        echo "Días Trabajados: " . $dias_trabajados . " - Total Semana: <b>$" . $total_final . "</b> - Tapicero: " . $nombre_tapicero;
    }
    ?>
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

<?php require_once "vistas/parte_inferior.php" ?>
