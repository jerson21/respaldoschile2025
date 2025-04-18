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
<?php require_once "vistas/parte_superior.php";
include 'bd/conexion.php'; ?>
<style>
    .table-cell-centered {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        /* Asegúrate de que las celdas tengan una altura definida si es necesario */
    }
</style>
<!--INICIO del cont principal-->
<div class="container" style=" max-width: 400rem; width: 200rem; ">
    <h1>Produccion tapiceros</h1>



    <?php


    $objeto1 = new Conexion();
    $conexion = $objeto1->Conectar();
    $consulta = "SELECT * FROM pedido p
                INNER JOIN pedido_detalle d on p.num_orden = d.num_orden 
                INNER JOIN clientes c on p.rut_cliente = c.rut where d.estadopedido = 2 GROUP BY d.ruta_asignada";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();

    $resultados = $resultado->fetchAll(PDO::FETCH_ASSOC);






    //$conexion ->set_charset("utf8");


    ?>


    <div class="container">
        <div class="row">

        </div>
    </div>
    <br>
    <div class="container" style="float:left; padding: 0; ">
        <div class="row">
            <div class="col-lg-12">




                <?php

                // var_dump($resultados);
                foreach ($resultados as $row) {
                    $ruta = $row['ruta_asignada'];
                    $consulta = $conexion->prepare("SELECT fecha FROM rutas WHERE id = :ruta");
                    $consulta->bindParam(":ruta", $ruta, PDO::PARAM_INT);
                    $consulta->execute();


                    $rows = $consulta->fetch(PDO::FETCH_ASSOC);


                    setlocale(LC_TIME, 'es_ES.UTF-8');

                    //$fecha = strftime("%A, %d de %B de %Y", strtotime($rows['fecha'])); DEPRECATED


                    if (!isset($rows['fecha'])) {
                        $fecha = "Fecha no disponible";
                    } else {

                        $fechaObj = DateTime::createFromFormat('Y-m-d', $rows['fecha']);
                        if ($fechaObj !== false) {
                            $dias_semana = array('domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado');
                            $meses = array('', 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');

                            $fecha = $dias_semana[$fechaObj->format('w')] . ', ' . $fechaObj->format('d') . ' de ' . $meses[$fechaObj->format('n')] . ' de ' . $fechaObj->format('Y');
                        }
                    }





                ?>


                    <div class="table-responsive" style="margin:0; width: 100rem;">



                        <table id="tablatapiceross" class="table table-striped table-bordered table-condensed" style="width:100%; font-size:0.8rem; ">
                            <thead class="text-center">
                                <tr>

                                    <?php

                                    if ($ruta == '') {
                                        echo "<div class='alert alert-danger' role='alert' style='margin:0 auto; text-align:center;'>Pedidos sin asignar a ruta</div>";
                                    } else {
                                        echo "<div class='alert alert-warning' role='alert' style='margin:0 auto; text-align:center;'><b>" . $ruta . ".</b> " . $fecha;
                                        "</div>";
                                    }      ?>
                                    <th style="width:2rem;">Id</th>
                                    <th style="width:3rem;">Rut Cliente</th>
                                    <th style="width:7rem;">Modelo</th>
                                    <th style="width:3rem;">Plazas</th>
                                    <th style="width:2rem;">Alt</th>
                                    <th style="width:2rem;">Tela</th>
                                    <th style="width:5rem;">Color</th>
                                    <th style="width:7rem;">Direccion</th>
                                    <th style="width:2rem;">Nº</th>
                                    <th style="width:5rem;">Comuna</th>
                                    <th style="width:3rem;">Detalles</th>
                                    <th style="width:3rem;">Costura</th>

                                    <th style="width:7rem;">Estado Pedido</th>
                                    <th style="width:1rem;">Cliente</th>
                                    <th style="width:4rem;">Tapicero 1</th>
                                    <th style="width:4rem;">Tapicero 2</th>
                                    <th style="width:4rem;">Tapicero 3</th>
                                </tr>
                            </thead>

                            <?php


                            $consulta2 = $conexion->prepare("SELECT * FROM pedido p
                INNER JOIN pedido_detalle d on p.num_orden = d.num_orden 
                LEFT JOIN (SELECT idPedido,fecha ,idProceso, GROUP_CONCAT(idProceso) AS eTapas
                FROM pedido_etapas
                WHERE idProceso != 1
                GROUP BY idPedido) etapas ON d.id = etapas.idPedido
                INNER JOIN clientes c on p.rut_cliente = c.rut where estadopedido = 2 and ruta_asignada = :ruta");
                            $consulta2->bindParam(":ruta", $ruta, PDO::PARAM_INT);
                            $consulta2->execute();





                            while ($dat = $consulta2->fetch(PDO::FETCH_ASSOC)) {

                                $etapas = explode(',', $dat['eTapas']);
                                $existeEtapa1 = in_array('3', $etapas);

                            ?>


                                <tr>


                                    <td style="height:10px; padding: 1px; "><?php echo $dat['id'] ?></td>
                                    <td style="height:10px; padding: 1px; "><?php echo $dat['rut_cliente'] ?></td>




                                    <td style="height:10px; padding: 1px;"><?php echo $dat['modelo']; ?>
                                        <?php if ($dat['anclaje'] == 'si') { ?>
                                            <img width="15" src="img/anclaje.png">
                                        <?php }
                                        if ($dat['anclaje'] == 'patas') { ?>
                                            <img width="15" src="img/patasmadera.jpg">
                                        <?php } ?>
                                        <br>
                                        <span style="font-size: 10px; font-weight: bold; color:red;"><?php echo $dat['comentarios']; ?></span>
                                    </td>
                                    <td style="height:10px; padding: 1px;"><?php echo $dat['tamano'] . "  <b>" . $dat['tipo_boton'] . "</b>"; ?></td>
                                    <td style="height:10px; padding: 1px;"><?php echo $dat['alturabase'] ?></td>
                                    <td style="height:10px; padding: 1px;"><?php echo $dat['tipotela'] ?></td>
                                    <td style="height:10px; padding: 1px;"><?php echo $dat['color'] ?></td>
                                    <td style="height:10px; padding: 1px;"><?php echo $dat['direccion'] ?></td>
                                    <td style="height:10px; padding: 1px;"><?php echo $dat['numero'] ?></td>
                                    <td style="height:10px; padding: 1px;"><?php echo $dat['comuna'] ?></td>
                                    <td style="height:10px; padding: 1px;"><?php echo $dat['detalles_fabricacion'] ?></td>
                                    <?php if ($existeEtapa1) { ?>
                                        <td style="height:10px; padding: 1px; text-align: center;">
                                            <!-- Icono de ticket en azul y más grande -->
                                            <i class="fa-solid fa-check fa-1x" style="color:green;"></i>
                                        </td>
                                    <?php } else { ?>
                                        <td style="height:10px; padding: 1px; text-align: center;">
                                            <!-- Icono de x en rojo y más grande -->
                                            <i class="fas fa-times fa-1x" style="color: red;"></i>
                                        </td>
                                    <?php } ?>


                                    <td style="height:10px; padding: 1px;"><?php if ($dat['estadopedido'] == "1") {
                                                                                echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-secondary btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Aceptado</button></div>";
                                                                            } elseif ($dat['estadopedido'] == "2" && $dat['tapicero_id'] == "" or $dat['tapicero_id'] == "0") {
                                                                                echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-warning btnEditarestado' id='parpadea_' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Por Fabricar</button></div>";
                                                                            } elseif ($dat['estadopedido'] == "2" && $dat['tapicero_id'] > "0") {
                                                                                echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-info btnEditarestado' id='parpadea' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>En Fabricacion</button></div>";
                                                                            } elseif ($dat['estadopedido'] == "0") {
                                                                                echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-warning btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>No Aceptado</button></div>";
                                                                            } elseif ($dat['estadopedido'] == "3") {
                                                                                echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-info btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Pedido Listo</button></div>";
                                                                            } elseif ($dat['estadopedido'] == "9") {
                                                                                echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-warning btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Reagendar</button></div>";
                                                                            } elseif ($dat['estadopedido'] == "4") {
                                                                                echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-warning btnEditarestado' style=' background-color: #FF338A;font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Asignado a Ruta</button></div>";
                                                                            } elseif ($dat['estadopedido'] == "5") {
                                                                                echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-warning btnEditarestado' style=' background-color: #ABFF71;font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Entregado</button></div>";
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



                                    <td style="height:10px; padding: 1px; text-align: center;"><?php if ($dat['confirma'] == "1") { ?>
                                            <button type="button" class="btn btn-info btn-circles btn-sm"></button>
                                        <?php } else { ?>
                                            <button type="button" class="btn btn-danger btn-circles btn-sm"></button>
                                        <?php } ?>
                                    </td>

                                    <?php if ($dat['tapicero_id'] == '' or $dat['tapicero_id'] == '0') { ?>
                                        <td style="height:10px; padding: 1px; text-align: center;"><button type="button" class="btn btn-warning btn-circle btn-sm btnjaime"></button></td>
                                        <td style="height:10px; padding: 1px; text-align: center;"><button type="button" class="btn btn-warning btn-circle btn-sm btnfelipe"></button></td>
                                        <td style="height:10px; padding: 1px; text-align: center;"><button type="button" class="btn btn-warning btn-circle btn-sm btntapicero3"></button></td>

                                    <?php  }
                                    if ($dat['tapicero_id']  == '1') { ?>
                                        <td style="height:10px; padding: 1px; text-align: center;"><button type="button" class="btn btn-success btn-circle btn-sm btndesasignar"></button></td>
                                        <td style="height:10px; padding: 1px; text-align: center;"></td>
                                        <td style="height:10px; padding: 1px; text-align: center;"></td>

                                    <?php  }
                                    if ($dat['tapicero_id']  == '2') { ?>
                                        <td style="height:10px; padding: 1px; text-align: center;"></td>
                                        <td style="height:10px; padding: 1px; text-align: center;"><button type="button" class="btn btn-success btn-circle btn-sm btndesasignar"></td>
                                        <td style="height:10px; padding: 1px; text-align: center;"></td>

                                    <?php  }
                                    if ($dat['tapicero_id']  == '3') { ?>
                                        <td style="height:10px; padding: 1px; text-align: center;"></td>
                                        <td style="height:10px; padding: 1px; text-align: center;"></td>
                                        <td style="height:10px; padding: 1px; text-align: center;"><button type="button" class="btn btn-success btn-circle btn-sm btndesasignar"></td>
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

    <!--Modal para CRUD Editar estado de compra-->
    <div class="modal fade" id="modalCRUD" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editarestado">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="id" class="col-form-label">Cod:</label>
                            <input type="text" class="form-control" id="id" readonly>
                        </div>
                        <div class="form-group">
                            <select name="estado" id="estado" class="form-control">
                                <option value="" disabled selected>Selecciona Estado</option>
                                <option value="1">Aceptar Compra</option>
                                <option value="2">Enviar a Fabricación</option>
                                <option value="3">Pedido Listo</option>
                                <option value="9">Reagendar</option>
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                        <button type="submit" id="btnGuardar" class="btn btn-dark">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Modal para CRUD EDITAR PEDIDO-->
    <div class="modal fade" id="modalEditarPedido" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editarpedido">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="id" class="col-form-label">Cod:</label>
                            <input type="text" class="form-control" id="ide" name="ide" readonly>
                        </div>
                        <div class="form-group">
                            <label for="id" class="col-form-label">Rut:</label>
                            <input type="text" class="form-control" id="rut" name="rut">
                        </div>
                        <div class="row gy-4">
                            <div class="col-lg-4">
                                <label for="modelo" class="col-form-label">Modelo:</label>
                                <input type="text" class="form-control" id="modelo" name="modelo">
                            </div>
                            <div class="col-lg-4">
                                <label for="plazas" class="col-form-label">Plazas:</label>
                                <input type="text" class="form-control" id="plazas" name="plazas">
                            </div>
                            <div class="col-lg-4">
                                <label for="tela" class="col-form-label">Tela:</label>
                                <input type="text" class="form-control" id="tela" name="tela">
                            </div>
                            <div class="col-lg-4">
                                <label for="color" class="col-form-label">Color:</label>
                                <input type="text" class="form-control" id="color" name="color">
                            </div>
                            <div class="col-lg-4">
                                <label for="color" class="col-form-label">Altura:</label>
                                <input type="text" class="form-control" id="alturabase" name="alturabase">
                            </div>
                            <div class="col-lg-4">
                                <label for="color" class="col-form-label">Telefono:</label>
                                <input type="text" class="form-control" id="telefono" name="telefono">
                            </div>
                        </div>
                        <div class="row gy-4">
                            <div class="col-lg-4">
                                <label for="color" class="col-form-label">Direccion:</label>
                                <input type="text" class="form-control" id="direccion" name="direccion">
                            </div>
                            <div class="col-lg-4">
                                <label for="color" class="col-form-label">Num:</label>
                                <input type="text" class="form-control" id="numero" name="numero">
                            </div>
                            <div class="col-lg-4">
                                <label for="color" class="col-form-label">Comuna:</label>
                                <input type="text" class="form-control" id="comuna" name="comuna">
                            </div>
                        </div>



                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                        <button type="submit" id="btnGuardar" class="btn btn-dark">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



</div>
<!--FIN del cont principal-->
<?php require_once "vistas/parte_inferior.php" ?>