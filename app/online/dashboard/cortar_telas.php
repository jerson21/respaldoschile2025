<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "vistas/parte_superior.php";
?>

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
<div id="contenido1" style=" margin:0 auto; overflow: auto;    ">
    <div class="container" style=" max-width: 100rem; width: 200rem; ">
        <h1>Corte de Telas</h1>


        <?php

        $BD_SERVIDOR = "localhost";
        $BD_USUARIO = "cre61650_respaldos21";
        $BD_PASSWORD = "respaldos21/";
        $BD_NOMBRE = "cre61650_agenda";

        $mysqli = new mysqli($BD_SERVIDOR, $BD_USUARIO, $BD_PASSWORD, $BD_NOMBRE);





        $resultado = $mysqli->query("SELECT * FROM pedido_detalle pd INNER JOIN pedido_etapas pe ON pd.id = pe.idpedido LEFT JOIN rutas r ON pd.ruta_asignada = r.id where  pd.estadopedido = 2 or pd.estadopedido = 5  GROUP BY ruta_asignada order by r.fecha ASC");

        $mysqli->set_charset("utf8");


        ?>

        <div>
            <?php
            $resultado2 = $mysqli->query("SELECT * FROM cortes_tela WHERE fecha_hora >= CURDATE() AND fecha_hora < CURDATE() +INTERVAL 1 DAY");

            // Ejecutar la consulta
            // $resultado2 = $mysqli->query("SELECT * FROM cortes_tela WHERE fecha_hora >= DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND fecha_hora < CURDATE()");
            
            // Contar el número de filas
            $rows2 = mysqli_num_rows($resultado2);
            echo "<p>Telas Cortadas Hoy: " . $rows2 . "</p>";
            ?>

            <!-- Botón de Bootstrap para mostrar detalles -->
            <button class="btn btn-primary" id="mostrarDetalles">Ver Registro de corte</button>

            <?php
            // Obtener los detalles en una variable para pasarlos a JavaScript
            $detalles = [];
            if ($rows2 > 0) {
                while ($row = $resultado2->fetch_assoc()) {
                    $detalles[] = $row;
                }
            }
            // Liberar el resultado
            $resultado2->free();
            // Cerrar la conexión
            ?>

            <script>
                document.getElementById('mostrarDetalles').addEventListener('click', function () {
                    // Obtener los detalles desde PHP
                    var detalles = <?php echo json_encode($detalles); ?>;

                    // Función para convertir la primera letra de cada palabra a mayúscula
                    function capitalizeWords(str) {
                        return str.replace(/\b\w/g, function (char) {
                            return char.toUpperCase();
                        });
                    }

                    // Crear la tabla con los detalles
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

                    // Mostrar los detalles en un SweetAlert con tabla
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
            <div class="row">

            </div>

        </div>
        <br>

        <div class="col-lg-4" style="margin:0 auto;">
            <div class="input-group mb-3"> <!-- mb-3 añade un margen en la parte inferior -->
                <input type="text" id="buscadorGeneral" class="form-control" placeholder="Buscar producto..."
                    aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="button-addon2"><i
                            class="fa fa-search"></i></button>
                </div>
            </div>
        </div>
        <div class="container" style="float:left; padding: 0;  ">


            <div class="row">
                <div class="col-lg-12">




                    <?php


                    while ($row = mysqli_fetch_array($resultado)) {
                        $ruta = $row['ruta_asignada'];

                        $resultadosruta = $mysqli->query("SELECT fecha FROM rutas WHERE id = '$ruta'");
                        $rows = mysqli_fetch_assoc($resultadosruta);
                        setlocale(LC_TIME, 'es_CL.UTF-8');

                        // Verifica si la extensión intl está cargada
                        if (extension_loaded('intl')) {
                            if (is_array($rows) && isset($rows['fecha'])) {
                                // Crea un objeto DateTime a partir de la fecha
                                $fechaa = new DateTime($rows['fecha']);

                                // Configura el formato deseado y el idioma
                                $formatter = new IntlDateFormatter(
                                    'es_CL', // Configuración regional para español de Colombia
                                    IntlDateFormatter::FULL, // Formato de fecha completo
                                    IntlDateFormatter::NONE, // Sin formato de tiempo
                                    'America/Santiago', // Zona horaria
                                    IntlDateFormatter::GREGORIAN, // Calendario
                                    'EEEE, d \'de\' MMMM \'de\' y' // Patrón de formato
                                );

                                // Formatea la fecha
                                $fecha = $formatter->format($fechaa);
                            } else {
                                $fecha = ""; // Manejo del caso en el que $rows no es un arreglo o no tiene la clave 'fecha'
                            }
                        } else {
                            if (is_array($rows) && isset($rows['fecha'])) {
                                // Fallback básico si la extensión intl no está cargada
                                $fechaa = new DateTime($rows['fecha']);
                                $fecha = $fecha->format('Y-m-d');
                            } else {
                                $fecha = ""; // Manejo del caso en el que $rows no es un arreglo o no tiene la clave 'fecha'
                            }
                        }

                        





                        ?>


                        <div class="table-responsive" style="margin:0; width: 80rem; ">


                            <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
                            <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
                            <script>

                            </script>

                            <table id="tablatapiceross" class="table table-striped table-bordered table-condensed"
                                style="width:100%; font-size:0.8rem;  ">
                                <thead class="text-center">
                                    <tr>

                                        <?php

                                        if ($ruta == '' or $ruta == 0 or $ruta == '{0}') {
                                            echo "<div class='alert alert-danger' role='alert' style='margin:0 auto; text-align:center;'>Pedidos sin asignar a ruta</div>";
                                        } else {
                                            echo "<div class='alert alert-warning' role='alert' style='margin:0 auto; text-align:center;'><b>" . $ruta . ".</b> " . $fecha;
                                            "</div>";
                                        } ?>
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

                                <?php


                                $resultados = $mysqli->query("SELECT *,pd.id as id,pd.modelo as modelo,
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
       SELECT idPedido,fecha ,idProceso, GROUP_CONCAT(idProceso) AS eTapas
       FROM pedido_etapas
       WHERE idProceso != 1
       GROUP BY idPedido
   ) etapas ON pd.id = etapas.idPedido
   WHERE pd.ruta_asignada = '$ruta' AND (pd.estadopedido = 2 OR pd.estadopedido = 5 OR pd.estadopedido = 6 or (etapas.idProceso = 6 AND etapas.fecha = CURDATE())) 
   ORDER BY pd.color, pd.tipotela");

                                while ($dat = mysqli_fetch_array($resultados)) {






                                    ?>







                                    <tr>





                                        <td style="height:10px; padding: 1px; "><?php echo $dat['id'] ?></td>





                                        <td style="height:10px; padding: 1px;"><?php echo $dat['modelo'] ?></td>
                                        <td style="height:10px; padding: 1px;">
                                            <?php echo $dat['tamano'] . "  <b>" . $dat['tipo_boton'] . "</b>"; ?>
                                        </td>
                                        <td style="height:10px; padding: 1px;"><?php echo $dat['alturabase'] ?></td>
                                        <td style="height:10px; padding: 1px;"><?php echo $dat['tipotela'] ?></td>
                                        <td style="height:10px; padding: 1px;"><?php echo $dat['color'] ?></td>
                                        <td style="height:10px; padding: 1px;"><?php echo $dat['detalles_fabricacion'] ?></td>

                                        <td style="height:15px; padding: 1px;">



                                            <?php
                                            $fechaActual = new DateTime();

                                            if (!empty($dat['detalle_entrega'])) {
                                                // Intentamos crear un objeto DateTime
                                                $detalleEntrega = DateTime::createFromFormat('Y-m-d H:i:s', $dat['detalle_entrega']);
                                                $detalle_entrega_hora = DateTime::createFromFormat('Y-m-d H:i:s', $dat['detalle_entrega']);

                                                // Si la creación del objeto DateTime es exitosa y no hay errores
                                                if ($detalleEntrega && !$detalleEntrega->getLastErrors()['warning_count'] && !$detalleEntrega->getLastErrors()['error_count']) {
                                                    $detalleEntrega->setTime(0, 0, 0);
                                                    $manana = new DateTime('tomorrow');

                                                    if ($detalleEntrega->format('Y-m-d') === $fechaActual->format('Y-m-d')) {
                                                        echo "<span style='color:red;'>RETIRA HOY a las " . $detalle_entrega_hora->format('H:i') . '</span>';
                                                    } elseif ($detalleEntrega->format('Y-m-d') === $manana->format('Y-m-d')) {
                                                        echo "RETIRA MAÑANA a las " . $detalle_entrega_hora->format('H:i');
                                                    } else {
                                                        echo $detalleEntrega->format('Y-m-d H:i:s');
                                                    }
                                                } else {
                                                    // Si no es una fecha válida, tratamos el contenido como texto
                                                    echo htmlspecialchars($dat['detalle_entrega']);
                                                }
                                            } else {
                                                // Aquí puedes definir qué hacer en caso de que el campo esté vacío
                                                //echo "No hay información de entrega disponible.";
                                            }


                                            ?>
                                        </td>

                                        <td style="height:10px; padding: 1px; text-align:center;">
                                            <?php echo "<b>" . ($dat['metraje'] / 2) . "</b> - " . $dat['metraje'] ?>
                                        </td>


                                        <td style="height:10px; padding: 1px;"><?php
                                        if ($dat['estadopedido'] == "0") {
                                            echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-warning ' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>No Aceptado</button></div>";
                                        } elseif ($dat['estadopedido'] == "1") {
                                            echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-secondary ' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Aceptado</button></div>";
                                        } elseif ($dat['estadopedido'] == "2" && $dat['tapicero_id'] == "" or $dat['tapicero_id'] == "0") {
                                            echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-warning ' id='parpadea_' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Por Fabricar</button></div>";
                                        } elseif ($dat['estadopedido'] == "5") {
                                            echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-success ' id='parpadea' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Fabricando</button></div>";
                                        } elseif ($dat['estadopedido'] == "2") {
                                            echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-success ' id='parpadea' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Por Fabricar</button></div>";
                                        } elseif ($dat['estadopedido'] == "6") {
                                            echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-info ' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Pedido Listo</button></div>";
                                        } elseif ($dat['estadopedido'] == "7") {
                                            echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-warning ' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>En carga</button></div>";
                                        } elseif ($dat['estadopedido'] == "19") {
                                            echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-warning ' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Reagendar</button></div>";
                                        } elseif ($dat['estadopedido'] == "4") {
                                            echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-dark ' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Devuelto</button></div>";
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
                                            <td style="height:10px; padding: 1px; text-align: center;"><button type="button"
                                                    class="btn btn-success btn-circle btn-sm btneliminarcorte"></button></td>


                                        <?php } else { ?>
                                            <td style="height:10px; padding: 1px; text-align: center;"><button type="button"
                                                    class="btn btn-warning btn-circle btn-sm btncortartela"></button></td>
                                        <?php } ?>







                                    </tr>
                                    <?php

                                }
                    }
                    ?>
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>


    </div><!-- fin div contenido1 -->


    <script>
        $(document).ready(function () {
            $('#buscadorGeneral').keyup(function () {
                var terminosDeBusqueda = this.value.toLowerCase().trim().split(/\s+/); // Dividir el valor ingresado en términos por cualquier espacio en blanco

                // Iterar sobre cada tabla
                $('table').each(function () {
                    var tablaActual = $(this);

                    // Iterar sobre cada fila de la tabla
                    tablaActual.find('tbody tr').each(function () {
                        var fila = $(this);
                        var textoFila = fila.text().toLowerCase(); // Obtener todo el texto de la fila

                        var todosTerminosEncontrados = terminosDeBusqueda.every(function (termino) { // Comprobar si cada término está presente
                            return textoFila.includes(termino);
                        });

                        // Mostrar u ocultar la fila según si todos los términos fueron encontrados
                        fila.toggle(todosTerminosEncontrados);
                    });
                });
            });
        });
    </script>


</div>
<!--FIN del cont principal-->
<?php require_once "vistas/parte_inferior.php" ?>