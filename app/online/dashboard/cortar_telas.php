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
<style>
    .custom-input {
        width: 150px;
        height: 40px;
        font-size: 15px;
        margin: 0 auto;
    }
    .swal2-content {
        margin-bottom: 20px;
    }
    .swal2-content label {
        display: block;
        margin-bottom: 10px;
    }
    .swal2-content input[type="checkbox"] {
        margin-right: 5px;
    }
    .swal2-content input[type="text"] {
        display: none;
        margin-top: 10px;
        padding: 5px;
        width: 100%;
    }
</style>

<!--INICIO del cont principal-->
<div id="contenido1" style="margin:0 auto; overflow: auto;">
    <div class="container" style="max-width: 100rem; width: 200rem;">
        <h1>Corte de Telas</h1>

        <?php
        // Iniciamos la conexión con PDO mediante la clase Conexion
        require_once "bd/conexion.php";
        $objeto = new Conexion();
        $conexion = $objeto->Conectar();

        // Consulta para obtener pedidos (agrupados por ruta)
        $sql = "SELECT * FROM pedido_detalle pd 
                INNER JOIN pedido_etapas pe ON pd.id = pe.idpedido 
                LEFT JOIN rutas r ON pd.ruta_asignada = r.id 
                WHERE pd.estadopedido = 2 OR pd.estadopedido = 5  
                GROUP BY ruta_asignada 
                ORDER BY r.fecha ASC";
        $stmt = $conexion->query($sql);
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <div>
            <?php
            // Consulta para contar los cortes de tela realizados hoy
            $sql2 = "SELECT * FROM cortes_tela WHERE fecha_hora >= CURDATE() AND fecha_hora < CURDATE() + INTERVAL 1 DAY";
            $stmt2 = $conexion->query($sql2);
            $detalles = $stmt2->fetchAll(PDO::FETCH_ASSOC);
            $rows2 = count($detalles);
            echo "<p>Telas Cortadas Hoy: " . $rows2 . "</p>";
            ?>
            <!-- Botón para mostrar detalles del corte en SweetAlert -->
            <button class="btn btn-primary" id="mostrarDetalles">Ver Registro de corte</button>

            <script>
                document.getElementById('mostrarDetalles').addEventListener('click', function () {
                    var detalles = <?php echo json_encode($detalles); ?>;
                    function capitalizeWords(str) {
                        return str.replace(/\b\w/g, function (char) {
                            return char.toUpperCase();
                        });
                    }
                    var table = '<table class="table table-striped"><thead><tr>' +
                        '<th>#</th><th>ID</th><th>Producto ID</th><th>Detalle</th><th>Metraje del Corte</th>' +
                        '<th>Fecha y Hora</th></tr></thead><tbody>';
                    detalles.forEach(function (detalle, index) {
                        table += '<tr>' +
                            '<td>' + (index + 1) + '</td>' +
                            '<td>' + capitalizeWords(detalle.id.toString()) + '</td>' +
                            '<td>' + capitalizeWords(detalle.producto_id.toString()) + '</td>' +
                            '<td>' + capitalizeWords(detalle.detalle) + '</td>' +
                            '<td>' + capitalizeWords(detalle.metraje_corte.toString()) + '</td>' +
                            '<td>' + capitalizeWords(detalle.fecha_hora) + '</td>' +
                            '</tr>';
                    });
                    table += '</tbody></table>';
                    Swal.fire({
                        title: 'Detalles de Cortes de Tela',
                        html: table,
                        icon: 'info',
                        confirmButtonText: 'Cerrar',
                        width: '50%',
                        customClass: {
                            popup: 'text-left'
                        }
                    });
                });
            </script>
        </div>

        <div class="container">
            <div class="row"></div>
        </div>
        <br>

        <div class="col-lg-4" style="margin:0 auto;">
            <div class="input-group mb-3">
                <input type="text" id="buscadorGeneral" class="form-control" placeholder="Buscar producto..."
                       aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="button-addon2">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="container" style="float:left; padding: 0;">
            <div class="row">
                <div class="col-lg-12">
                    <?php
                    // Recorremos el resultado agrupado por ruta
                    foreach ($resultados as $row) {
                        $ruta = $row['ruta_asignada'];
                        // Consulta para obtener la fecha de la ruta
                        $stmtRuta = $conexion->prepare("SELECT fecha FROM rutas WHERE id = :ruta");
                        $stmtRuta->execute([':ruta' => $ruta]);
                        $rowRuta = $stmtRuta->fetch(PDO::FETCH_ASSOC);
                        setlocale(LC_TIME, 'es_CL.UTF-8');
                        if ($rowRuta && isset($rowRuta['fecha'])) {
                            $fechaa = new DateTime($rowRuta['fecha']);
                            if (class_exists('IntlDateFormatter')) {
                                $formatter = new IntlDateFormatter(
                                    'es_CL',
                                    IntlDateFormatter::FULL,
                                    IntlDateFormatter::NONE,
                                    'America/Santiago',
                                    IntlDateFormatter::GREGORIAN,
                                    "EEEE, d 'de' MMMM 'de' y"
                                );
                                $fecha = $formatter->format($fechaa);
                            } else {
                                $fecha = $fechaa->format('Y-m-d');
                            }
                        } else {
                            $fecha = "";
                        }
                        ?>
                        <div class="table-responsive" style="margin:0; width: 80rem;">
                            <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
                            <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
                            <table id="tablatapiceross" class="table table-striped table-bordered table-condensed" style="width:100%; font-size:0.8rem;">
                                <thead class="text-center">
                                    <tr>
                                        <?php
                                        if ($ruta == '' || $ruta == 0 || $ruta == '{0}') {
                                            echo "<div class='alert alert-danger' role='alert' style='margin:0 auto; text-align:center;'>Pedidos sin asignar a ruta</div>";
                                        } else {
                                            echo "<div class='alert alert-warning' role='alert' style='margin:0 auto; text-align:center;'><b>" . $ruta . ".</b> " . $fecha . "</div>";
                                        }
                                        ?>
                                        <th style="width:2rem;">Id</th>
                                        <th style="width:7rem;">Modelo</th>
                                        <th style="width:2rem;">Tamano</th>
                                        <th style="width:2rem;">Alt</th>
                                        <th style="width:2rem;">Tela</th>
                                        <th style="width:5rem;">Color</th>
                                        <th style="width:6rem;">Observacion</th>
                                        <th style="width:9rem;">Detalle</th>
                                        <th style="width:2rem;">Metraje</th>
                                        <th style="width:5rem;">Estado Pedido</th>
                                        <th style="width:1rem;">Cliente</th>
                                        <th style="width:5rem;">Cortar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Consulta para obtener los detalles de pedidos asignados a la ruta
                                    $stmtDetalles = $conexion->prepare("
                                        SELECT *, pd.id as id, pd.modelo as modelo,
                                        CASE
                                            WHEN pd.tamano = '1' THEN pv.unaplaza
                                            WHEN pd.tamano = '1 1/2' THEN pv.plazaymedia
                                            WHEN pd.tamano = 'full' THEN pv.full
                                            WHEN pd.tamano = '2' THEN pv.dosplazas
                                            WHEN pd.tamano = 'queen' THEN pv.queen
                                            WHEN pd.tamano = 'king' THEN pv.king
                                            WHEN pd.tamano = 'super king' THEN pv.superking
                                            ELSE NULL
                                        END AS metraje
                                        FROM pedido_detalle pd
                                        LEFT JOIN productos_venta pv ON pd.modelo = pv.modelo
                                        LEFT JOIN (
                                            SELECT idPedido, fecha, idProceso, GROUP_CONCAT(idProceso) AS eTapas
                                            FROM pedido_etapas
                                            WHERE idProceso != 1
                                            GROUP BY idPedido
                                        ) etapas ON pd.id = etapas.idPedido
                                        WHERE pd.ruta_asignada = :ruta 
                                          AND (pd.estadopedido = 2 OR pd.estadopedido = 5 OR pd.estadopedido = 6 OR (etapas.idProceso = 6 AND etapas.fecha = CURDATE()))
                                        ORDER BY pd.color, pd.tipotela
                                    ");
                                    $stmtDetalles->execute([':ruta' => $ruta]);
                                    $rowsDetalles = $stmtDetalles->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($rowsDetalles as $dat) {
                                        ?>
                                        <tr>
                                            <td style="height:10px; padding: 1px;"><?php echo $dat['id']; ?></td>
                                            <td style="height:10px; padding: 1px;"><?php echo $dat['modelo']; ?></td>
                                            <td style="height:10px; padding: 1px;"><?php echo $dat['tamano'] . " <b>" . $dat['tipo_boton'] . "</b>"; ?></td>
                                            <td style="height:10px; padding: 1px;"><?php echo $dat['alturabase']; ?></td>
                                            <td style="height:10px; padding: 1px;"><?php echo $dat['tipotela']; ?></td>
                                            <td style="height:10px; padding: 1px;"><?php echo $dat['color']; ?></td>
                                            <td style="height:10px; padding: 1px;"><?php echo $dat['detalles_fabricacion']; ?></td>
                                            <td style="height:15px; padding: 1px;">
                                                <?php
                                                if (!empty($dat['detalle_entrega'])) {
                                                    $detalleEntrega = DateTime::createFromFormat('Y-m-d H:i:s', $dat['detalle_entrega']);
                                                    if ($detalleEntrega) {
                                                        $detalleEntrega->setTime(0, 0, 0);
                                                        $manana = new DateTime('tomorrow');
                                                        if ($detalleEntrega->format('Y-m-d') === (new DateTime())->format('Y-m-d')) {
                                                            echo "<span style='color:red;'>RETIRA HOY a las " . DateTime::createFromFormat('Y-m-d H:i:s', $dat['detalle_entrega'])->format('H:i') . '</span>';
                                                        } elseif ($detalleEntrega->format('Y-m-d') === $manana->format('Y-m-d')) {
                                                            echo "RETIRA MAÑANA a las " . DateTime::createFromFormat('Y-m-d H:i:s', $dat['detalle_entrega'])->format('H:i');
                                                        } else {
                                                            echo $detalleEntrega->format('Y-m-d H:i:s');
                                                        }
                                                    } else {
                                                        echo htmlspecialchars($dat['detalle_entrega']);
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <td style="height:10px; padding: 1px; text-align:center;">
                                                <?php echo "<b>" . ($dat['metraje'] / 2) . "</b> - " . $dat['metraje']; ?>
                                            </td>
                                            <td style="height:10px; padding: 1px;">
                                                <?php
                                                if ($dat['estadopedido'] == "0") {
                                                    echo "<div class='text-center'><div class='btn-group'><button class='btn btn-warning' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>No Aceptado</button></div>";
                                                } elseif ($dat['estadopedido'] == "1") {
                                                    echo "<div class='text-center'><div class='btn-group'><button class='btn btn-secondary' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Aceptado</button></div>";
                                                } elseif ($dat['estadopedido'] == "2" && ($dat['tapicero_id'] == "" || $dat['tapicero_id'] == "0")) {
                                                    echo "<div class='text-center'><div class='btn-group'><button class='btn btn-warning' id='parpadea_' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Por Fabricar</button></div>";
                                                } elseif ($dat['estadopedido'] == "5") {
                                                    echo "<div class='text-center'><div class='btn-group'><button class='btn btn-success' id='parpadea' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Fabricando</button></div>";
                                                } elseif ($dat['estadopedido'] == "2") {
                                                    echo "<div class='text-center'><div class='btn-group'><button class='btn btn-success' id='parpadea' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Por Fabricar</button></div>";
                                                } elseif ($dat['estadopedido'] == "6") {
                                                    echo "<div class='text-center'><div class='btn-group'><button class='btn btn-info' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Pedido Listo</button></div>";
                                                } elseif ($dat['estadopedido'] == "7") {
                                                    echo "<div class='text-center'><div class='btn-group'><button class='btn btn-warning' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>En carga</button></div>";
                                                } elseif ($dat['estadopedido'] == "19") {
                                                    echo "<div class='text-center'><div class='btn-group'><button class='btn btn-warning' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Reagendar</button></div>";
                                                } elseif ($dat['estadopedido'] == "4") {
                                                    echo "<div class='text-center'><div class='btn-group'><button class='btn btn-dark' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Devuelto</button></div>";
                                                }
                                                ?>
                                            </td>
                                            <style type="text/css">
                                                .btn-circle.btn-sm {
                                                    width: 40px;
                                                    height: 40px;
                                                    padding: 6px 0px;
                                                    border-radius: 20px;
                                                    font-size: 8px;
                                                    text-align: center;
                                                }
                                                .btn-circles.btn-sm {
                                                    width: 20px;
                                                    height: 20px;
                                                    padding: 3px 0px;
                                                    border-radius: 20px;
                                                    font-size: 8px;
                                                    text-align: center;
                                                }
                                            </style>
                                            <td style="height:10px; padding: 1px; text-align: center;">
                                                <?php if ($dat['confirma'] == "1") { ?>
                                                    <button type="button" class="btn btn-info btn-circles btn-sm"></button>
                                                <?php } else { ?>
                                                    <button type="button" class="btn btn-danger btn-circles btn-sm"></button>
                                                <?php } ?>
                                            </td>
                                            <?php
                                            $etapas = explode(',', $dat['eTapas']);
                                            $existeEtapa1 = in_array('3', $etapas);
                                            if ($existeEtapa1) { ?>
                                                <td style="height:10px; padding: 1px; text-align: center;">
                                                    <button type="button" class="btn btn-success btn-circle btn-sm btneliminarcorte"></button>
                                                </td>
                                            <?php } else { ?>
                                                <td style="height:10px; padding: 1px; text-align: center;">
                                                    <button type="button" class="btn btn-warning btn-circle btn-sm btncortartela"></button>
                                                </td>
                                            <?php } ?>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#buscadorGeneral').keyup(function () {
                var terminosDeBusqueda = this.value.toLowerCase().trim().split(/\s+/);
                $('table').each(function () {
                    var tablaActual = $(this);
                    tablaActual.find('tbody tr').each(function () {
                        var fila = $(this);
                        var textoFila = fila.text().toLowerCase();
                        var todosTerminosEncontrados = terminosDeBusqueda.every(function (termino) {
                            return textoFila.includes(termino);
                        });
                        fila.toggle(todosTerminosEncontrados);
                    });
                });
            });
        });
    </script>
</div>
<!--FIN del cont principal-->

<?php require_once "vistas/parte_inferior.php" ?>
