<?php require_once "init.php" ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pedidos</title>
  

     <!-- Fuentes e íconos -->
<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">  
     <!-- Fuentes e íconos  -->
  <script src="https://kit.fontawesome.com/c5b4401310.js" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="https://www.respaldoschile.cl/assets/img/favicon.png" rel="icon">

  <!-- Estilos principales -->
  <link href="css/sb-admin-2.min.css" rel="stylesheet"> 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <!-- Librerías adicionales -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/flatpickr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/flatpickr.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.all.min.js"></script>

   <!-- <link rel="stylesheet" type="text/css" href="css/design_respaldoschile.css">  -->

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/rowgroup/1.1.3/js/dataTables.rowGroup.min.js"></script>

</head>

<body>
<?php require_once "vistas/parte_superior.php" ?>
<!-- Puedes incluir estilos y scripts externos -->
<style type="text/css">
    .btn-circle.btn-sm {
        width: 40px;
        height: 40px;
        padding: 6px 0px;
        border-radius: 20px;
        font-size: 8px;
        text-align: center;
    }
</style>

<script src="https://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var pageRefresh = 10000; // 10 s
        setInterval(function () {
            refresh();
        }, pageRefresh);
    });

    function refresh() { $('#contenido1').load(location.href + " #contenido1"); }
</script>

<!--INICIO del cont principal-->
<div class="container">
    <h1>Producción Tapiceros - Respaldos Chile</h1>
    <div class="alert alert-info">
        <img width="15" src="img/patasmadera.jpg"> Patas de madera -
        <img width="15" src="img/anclaje.png"> Madera interior para anclaje -
        <b> B D </b> Boton Diamante
    </div>
</div>

<div id="contenido1" style="margin:0 auto; text-align: center;">
    <?php
    // Se incluye la conexión PDO mediante la clase Conexion
    require_once "bd/conexion.php";
    $objeto = new Conexion();
    $conexion = $objeto->Conectar();
    ?>

    <!-- TAPICERO 1 -->
    <div style="background: white; border:solid thin; border-radius: 15px; border-color: #D1D1D1; width:700px; height: auto; display: inline-block; margin-top: 50px; padding: 5px;">
        <h1>Tapicero 1</h1>
        <table id="tablatapiceross" class="table table-striped table-bordered table-condensed" style="width:100%; font-size:0.8rem; padding: 5px;">
            <thead class="text-center">
                <tr>
                    <?php echo "<div class='alert alert-success' role='alert' style='margin:0 auto; text-align:center;'>Pedidos en Fabricación</div>"; ?>
                    <th style="width:2rem;">Id</th>
                    <th style="width:7rem;">Modelo</th>
                    <th style="width:4rem;">Tamaño</th>
                    <th style="width:2rem;">Alt</th>
                    <th style="width:4rem;">Tela</th>
                    <th style="width:7rem;">Color</th>
                    <th style="width:2rem;"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Preparamos la consulta para Tapicero 1 (id = 1)
                $stmt = $conexion->prepare("
                    SELECT d.*, pd.*
                    FROM pedido_detalle d
                    INNER JOIN pedido_etapas pd ON d.id = pd.idPedido 
                    WHERE d.tapicero_id = :tapicero
                      AND (
                          d.estadopedido IN (2, 5) 
                          OR (DATE(pd.fecha) = CURDATE() AND pd.idproceso = 6)
                      )
                    GROUP BY d.id
                    ORDER BY d.estadopedido DESC, d.tamano ASC, d.color ASC
                ");
                $stmt->execute([':tapicero' => 1]);
                $contadorjaime = 0;
                while ($dat = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    // Procesamos y formateamos los datos (convertir modelos, tamaños, colores, etc.)
                    $modeloa = ltrim($dat['modelo']);
                    $color = ", " . $dat['color'];
                    $plazas = $dat['tamano'];
                    $base = ", Base " . $dat['alturabase'];
                    $tipo_boton = $dat['tipo_boton'];
                    $anclaje = $dat['anclaje'];
                    $comentario = "";
                    // Si se requiere mostrar mensaje de "tela no lista"
                    $cortada = "La tela aún no está lista. ";
                    
                    if ($modeloa == 'Botone') { $modeloa = "botoné Madrid, "; }
                    if ($modeloa == 'Botone 4 corridas de botones') { $modeloa = "botoné 4 corridas de botones, "; }
                    if ($modeloa == 'Botone 3 corridas de botones') { $modeloa = "botoné 3 corridas de botones, "; }
                    if ($modeloa == 'Capitone') { $modeloa = "capitoné"; }
                    
                    if ($plazas == "1") { $plazas = "una plaza"; }
                    if ($plazas == "1 1/2") { $plazas = "una plaza y media"; }
                    if ($plazas == "2") { $plazas = "2 plazas"; }
                    if ($plazas == "3") { $plazas = "3 cuerpos"; $base = ""; }
                    if ($plazas == "4") { $plazas = "4 cuerpos"; $base = ""; }
                    if ($plazas == "Seleccionar las plazas") { $plazas = ".Consultar tamaño."; $base = ""; }
                    if ($tipo_boton == "B D") { $tipo_boton = ", Agregar botón Diamante"; }
                    if ($anclaje == "si") { $anclaje = ", Ocupar esqueleto con Madera de anclaje"; }
                    if ($anclaje == "patas") { $anclaje = ", Ocupar esqueleto con Patas de madera"; }
                    if ($anclaje == "no") { $anclaje = ""; }
                    if ($dat['alturabase'] == "1.90mt") { $base = " , Largo uno noventa"; }
                    if ($dat['alturabase'] == "2Mt") { $base = " , Largo dos metros"; }
                    if ($dat['comentarios'] != "") { $comentario = ". Leer pantalla para ver detalles."; }
                    
                    // Se puede quitar el mensaje de tela no lista si no es necesario:
                    $cortada = "";
                    
                    if ($dat['modelo'] == "Liso con costuras") { $modeloa = "Liso Costuras Venecia, "; }
                    if ($dat['modelo'] == "Capitone Con Orejas y Tachas") { $modeloa = "Capitoné Tokio Con Orejas y Tachas, "; }
                    if ($dat['modelo'] == " Capitone Con Orejas") { $modeloa = "Capitoné Tokio Con Orejas, "; }
                    if ($color == 'CAFE') { $color = ", café "; }
                    if ($dat['color'] == 'AZUL PETROLEO') { $color = ", AZUL PETRÓLEO"; }
                    if ($modeloa == "Botone Madrid") { $modeloa = "Botoné Madrid"; }
                    
                    $detalle = $cortada . " Solicitar tela para: " . $modeloa . ". " . $plazas . ", " . $dat['tipotela'] . " " . $color . $base . $tipo_boton . $anclaje . $comentario;
                    
                    $contadorjaime++;
                    ?>
                    <?php
                    // Para cambiar el color de fondo según condiciones:
                    if ($dat['anclaje'] == 'si' || $dat['anclaje'] == 'patas') {
                        echo '<tr style="background-color: #FFE8A0;">';
                    } elseif ($cortada != '') {
                        echo '<tr style="background-color: #FFD2D2;">';
                    } else {
                        echo "<tr>";
                    }
                    ?>
                        <td style="height:10px; padding: 1px;">
                            <?php 
                            echo $dat['id'];
                            if ($dat['confirma'] == "1") {
                                echo ' <button type="button" class="btn btn-success btn-circle btn-sm" style="width:5px; height:5px; padding:0; border-radius:50%;"></button>';
                            } else {
                                echo ' <button type="button" class="btn btn-danger btn-circle btn-sm" style="width:5px; height:5px; padding:0; border-radius:50%;"></button>';
                            }
                            ?>
                        </td>
                        <?php
                        $tipo_botonMostrar = "";
                        if ($dat['tipo_boton'] == 'B D') {
                            $tipo_botonMostrar = "Diamante";
                            echo '<td style="height:10px; line-height:15px; color:red; font-weight:bold;">' . $dat['modelo'] . " " . $tipo_botonMostrar . '</td>';
                        } else {
                            echo '<td style="height:10px; line-height:15px;">';
                            echo $dat['modelo'] . " " . $tipo_botonMostrar;
                            if ($dat['anclaje'] == 'si') { echo '<img width="15" src="img/anclaje.png">'; }
                            if ($dat['anclaje'] == 'patas') { echo '<img width="15" src="img/patasmadera.jpg">'; }
                            echo "<br><span style='font-size:10px; font-weight:bold; color:red;'>" . $dat['comentarios'] . " " . $dat['detalles_fabricacion'] . "</span>";
                            echo '</td>';
                        }
                        ?>
                        <td style="height:10px; line-height:15px; font-weight:bold; font-size:15px;">
                            <?php echo $dat['tamano'] . $dat['tipo_boton']; ?>
                        </td>
                        <?php
                        if ($dat['alturabase'] != 60) {
                            echo '<td style="height:10px; line-height:15px; font-weight:bold; font-size:17px; color:red;">' . $dat['alturabase'] . '</td>';
                        } else {
                            echo '<td style="height:10px; line-height:15px; font-weight:bold; font-size:17px;">' . $dat['alturabase'] . '</td>';
                        }
                        ?>
                        <?php if ($dat['tipotela'] == "lino") { ?>
                            <td style="height:10px; line-height:15px;"><?php echo strtoupper($dat['tipotela']); ?></td>
                            <td style="height:10px; line-height:15px; font-weight:bold; font-size:17px;"><?php echo strtoupper($dat['color']); ?></td>
                        <?php } else { ?>
                            <td style="height:10px; line-height:15px;font-size:16px;"><b><u><?php echo strtoupper($dat['tipotela']); ?></u></b></td>
                            <td style="height:10px; line-height:15px; font-weight:bold; font-size:17px;"><u><?php echo strtoupper($dat['color']); ?></u></td>
                        <?php } ?>
                        <td style="height:10px; padding:1px; text-align:center;">
                            <?php
                            if ($dat['estadopedido'] == "2") {
                                $boton = ' <button type="button" class="btn btn-warning btn-circle btn-sm btnpedidolistofelipe" data-value="' . $detalle . '" data-estado="2"></button>';
                            }
                            if ($dat['estadopedido'] == "5") {
                                $boton = ' <button type="button" class="btn btn-info btn-circle btn-sm btnpedidolistofelipe" data-value="' . $detalle . '" data-estado="5"></button>';
                            }
                            if ($dat['estadopedido'] == "6") {
                                $boton = ' <button type="button" class="btn btn-success btn-circle btn-sm btnpedidolistofelipe" data-value="' . $detalle . '" data-estado="6"></button>';
                            }
                            if ($dat['estadopedido'] == "8") {
                                $boton = ' <i class="fas fa-truck"></i>';
                            }
                            echo $boton;
                            ?>
                        </td>
                    </tr>
                <?php } // fin while tapicero 1 ?>
            </tbody>
        </table>
        <?php echo "<b>Cantidad: " . $contadorjaime . "</b>"; ?>
    </div>

    <!-- TAPICERO 2 -->
    <div style="background: white; border:solid thin; border-radius: 15px; border-color: #D1D1D1; width:700px; height:auto; display:inline-block; margin-top:50px; padding:5px;">
        <h1>Tapicero 2</h1>
        <table id="tablatapiceross" class="table table-striped table-bordered table-condensed" style="width:100%; font-size:0.8rem; padding:5px;">
            <thead class="text-center">
                <tr>
                    <?php echo "<div class='alert alert-success' role='alert' style='margin:0 auto; text-align:center;'>Pedidos en Fabricación</div>"; ?>
                    <th style="width:2rem;">Id</th>
                    <th style="width:7rem;">Modelo</th>
                    <th style="width:4rem;">Tamaño</th>
                    <th style="width:2rem;">Alt</th>
                    <th style="width:4rem;">Tela</th>
                    <th style="width:7rem;">Color</th>
                    <th style="width:2rem;"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt2 = $conexion->prepare("
                    SELECT d.*, pd.*
                    FROM pedido_detalle d
                    INNER JOIN pedido_etapas pd ON d.id = pd.idPedido 
                    WHERE d.tapicero_id = :tapicero
                      AND (
                          d.estadopedido IN (2, 5) 
                          OR (DATE(pd.fecha) = CURDATE() AND pd.idproceso = 6)
                      )
                    GROUP BY d.id
                    ORDER BY d.estadopedido DESC, d.tamano ASC, d.color ASC
                ");
                $stmt2->execute([':tapicero' => 2]);
                $contadorfelipe = 0;
                while ($dat = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                    $modeloa = ltrim($dat['modelo']);
                    $color = ", " . $dat['color'];
                    $plazas = $dat['tamano'];
                    $base = ", Base " . $dat['alturabase'];
                    $tipo_boton = $dat['tipo_boton'];
                    $anclaje = $dat['anclaje'];
                    $comentario = "";
                    $cortada = "";
                    
                    if ($modeloa == 'Botone') { $modeloa = "botoné Madrid, "; }
                    if ($modeloa == 'Botone 4 corridas de botones') { $modeloa = "botoné 4 corridas de botones, "; }
                    if ($modeloa == 'Botone 3 corridas de botones') { $modeloa = "botoné 3 corridas de botones, "; }
                    if ($modeloa == 'Capitone') { $modeloa = "capitoné"; }
                    
                    if ($plazas == "1") { $plazas = "una plaza"; }
                    if ($plazas == "1 1/2") { $plazas = "una plaza y media"; }
                    if ($plazas == "2") { $plazas = "2 plazas"; }
                    if ($plazas == "3") { $plazas = "3 cuerpos"; $base = ""; }
                    if ($plazas == "4") { $plazas = "4 cuerpos"; $base = ""; }
                    if ($plazas == "Seleccionar las plazas") { $plazas = ".Consultar tamaño."; $base = ""; }
                    if ($tipo_boton == "B D") { $tipo_boton = ", Agregar botón Diamante"; }
                    if ($anclaje == "si") { $anclaje = ", Ocupar esqueleto con Madera de anclaje"; }
                    if ($anclaje == "patas") { $anclaje = ", Ocupar esqueleto con Patas de madera"; }
                    if ($anclaje == "no") { $anclaje = ""; }
                    if ($dat['alturabase'] == "1.90mt") { $base = " , Largo uno noventa"; }
                    if ($dat['alturabase'] == "2Mt") { $base = " , Largo dos metros"; }
                    if ($dat['detalles_fabricacion'] != "") { $comentario = ". Leer pantalla para ver detalles."; }
                    
                    $detalle = $cortada . " Solicitar tela para: " . $modeloa . ". " . $plazas . ", " . $dat['tipotela'] . " " . $color . $base . $tipo_boton . $anclaje . $comentario;
                    
                    $contadorfelipe++;
                    // Consulta para saber si existe proceso 3 para el pedido (ejemplo)
                    $stmtProceso = $conexion->prepare("SELECT COUNT(*) AS existeProceso FROM pedido_etapas WHERE idPedido = :idPedido AND idproceso = 3");
                    $stmtProceso->execute([':idPedido' => $dat['id']]);
                    $filaProceso = $stmtProceso->fetch(PDO::FETCH_ASSOC);
                    $telalista = ($filaProceso['existeProceso'] > 0) ? 1 : 0;
                    ?>
                    <?php
                    if ($dat['anclaje'] == 'si' || $dat['anclaje'] == 'patas') {
                        echo '<tr style="background-color: #FFE8A0;">';
                    } elseif ($telalista == 0) {
                        echo '<tr style="background-color: #FFF2F2 !important;">';
                    } else {
                        echo "<tr>";
                    }
                    ?>
                        <td style="height:10px; padding:1px;">
                            <?php 
                            echo $dat['id'];
                            if ($dat['confirma'] == "1") {
                                echo ' <button type="button" class="btn btn-success btn-circle btn-sm" style="width:5px; height:5px; padding:0; border-radius:50%;"></button>';
                            } else {
                                echo ' <button type="button" class="btn btn-danger btn-circle btn-sm" style="width:5px; height:5px; padding:0; border-radius:50%;"></button>';
                            }
                            ?>
                        </td>
                        <?php
                        $tipo_botonMostrar = "";
                        if ($dat['tipo_boton'] == 'B D') {
                            $tipo_botonMostrar = "Diamante";
                            echo '<td style="height:10px; line-height:15px; color:red; font-weight:bold;">' . $dat['modelo'] . " " . $tipo_botonMostrar . '</td>';
                        } else {
                            echo '<td style="height:10px; line-height:15px;">';
                            echo $dat['modelo'] . " " . $tipo_botonMostrar;
                            if ($dat['anclaje'] == 'si') { echo '<img width="15" src="img/anclaje.png">'; }
                            if ($dat['anclaje'] == 'patas') { echo '<img width="15" src="img/patasmadera.jpg">'; }
                            echo "<br><span style='font-size:10px; font-weight:bold; color:red;'>" . $dat['comentarios'] . " " . $dat['detalles_fabricacion'] . "</span>";
                            echo '</td>';
                        }
                        ?>
                        <td style="height:10px; line-height:15px; font-weight:bold; font-size:15px;">
                            <?php echo $dat['tamano'] . $dat['tipo_boton']; ?>
                        </td>
                        <?php
                        if ($dat['alturabase'] != 60) {
                            echo '<td style="height:10px; line-height:15px; font-weight:bold; font-size:17px; color:red;">' . $dat['alturabase'] . '</td>';
                        } else {
                            echo '<td style="height:10px; line-height:15px; font-weight:bold; font-size:17px;">' . $dat['alturabase'] . '</td>';
                        }
                        ?>
                        <?php if ($dat['tipotela'] == "lino") { ?>
                            <td style="height:10px; line-height:15px;"><?php echo strtoupper($dat['tipotela']); ?></td>
                            <td style="height:10px; line-height:15px; font-weight:bold; font-size:17px;"><?php echo strtoupper($dat['color']); ?></td>
                        <?php } else { ?>
                            <td style="height:10px; line-height:15px;font-size:16px;"><b><u><?php echo strtoupper($dat['tipotela']); ?></u></b></td>
                            <td style="height:10px; line-height:15px; font-weight:bold; font-size:17px;"><u><?php echo strtoupper($dat['color']); ?></u></td>
                        <?php } ?>
                        <td style="height:10px; padding:1px; text-align:center;">
                            <?php
                            if ($dat['estadopedido'] == "2") {
                                $boton = ' <button type="button" class="btn btn-warning btn-circle btn-sm btnpedidolistofelipe" data-value="' . $detalle . '" data-estado="2"></button>';
                            }
                            if ($dat['estadopedido'] == "5") {
                                $boton = ' <button type="button" class="btn btn-info btn-circle btn-sm btnpedidolistofelipe" data-value="' . $detalle . '" data-estado="5"></button>';
                            }
                            if ($dat['estadopedido'] == "6") {
                                $boton = ' <button type="button" class="btn btn-success btn-circle btn-sm btnpedidolistofelipe" data-value="' . $detalle . '" data-estado="6"></button>';
                            }
                            if ($dat['estadopedido'] == "8") {
                                $boton = ' <i class="fas fa-truck"></i>';
                            }
                            echo $boton;
                            ?>
                        </td>
                    </tr>
                <?php } // fin while tapicero 2 ?>
            </tbody>
        </table>
        <?php echo "<b>Cantidad: " . $contadorfelipe . "</b>"; ?>
    </div>
</div>

<?php
date_default_timezone_set('America/Santiago');
echo $DateAndTime = date('m-d-Y h:i:s a', time());
?>

<!--FIN del cont principal-->

<?php require_once "vistas/parte_inferior.php" ?>
