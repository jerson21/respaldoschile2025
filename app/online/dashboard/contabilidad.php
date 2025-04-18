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

<!--INICIO del cont principal-->


<style type="text/css">
    .register {
        background: -webkit-linear-gradient(left, #3931af, #00c6ff);
        margin-top: 3%;
        padding: 3%;

    }

    .register-left {
        text-align: center;
        color: #fff;
        margin-top: 2%;
    }

    .register-left input {
        border: none;
        border-radius: 1.5rem;
        padding: 2%;
        width: 60%;
        background: #f8f9fa;
        font-weight: bold;
        color: #383d41;
        margin-top: 30%;
        margin-bottom: 3%;
        cursor: pointer;
    }

    .register-right {
        background: #f8f9fa;
        border-top-left-radius: 10% 50%;
        border-bottom-left-radius: 10% 50%;
    }

    .register-left img {
        margin-top: 15%;
        margin-bottom: 5%;
        width: 25%;
        -webkit-animation: mover 2s infinite alternate;
        animation: mover 1s infinite alternate;
    }

    @-webkit-keyframes mover {
        0% {
            transform: translateY(0);
        }

        100% {
            transform: translateY(-20px);
        }
    }

    @keyframes mover {
        0% {
            transform: translateY(0);
        }

        100% {
            transform: translateY(-20px);
        }
    }

    .register-left p {
        font-weight: lighter;
        padding: 12%;
        margin-top: -9%;
    }

    .register .register-form {
        padding: 10%;
        margin-top: 10%;
    }

    .btnRegister {
        float: right;
        margin-top: 10%;
        border: none;
        border-radius: 1.5rem;
        padding: 2%;
        background: #0062cc;
        color: #fff;
        font-weight: 600;
        width: 50%;
        cursor: pointer;
    }

    .register .nav-tabs {
        margin-top: 3%;
        border: none;
        background: #0062cc;
        border-radius: 1.5rem;
        width: 40%;
        float: right;
    }

    .register .nav-tabs .nav-link {
        padding: 2%;
        height: 34px;
        font-weight: 600;
        color: #fff;
        border-top-right-radius: 1.5rem;
        border-bottom-right-radius: 1.5rem;
    }

    .register .nav-tabs .nav-link:hover {
        border: none;
    }

    .register .nav-tabs .nav-link.active {
        width: 120px;
        color: #0062cc;
        border: 2px solid #0062cc;
        border-top-left-radius: 1.5rem;
        border-bottom-left-radius: 1.5rem;
    }

    .register-heading {
        text-align: center;
        margin-top: 8%;
        margin-bottom: -15%;
        color: #495057;
    }
</style>
<?php
include_once 'bd/conexion.php';
$objeto1 = new Conexion();
$conexion = $objeto1->Conectar();

?>
<div class="container register">
    <div class="row">
        <div class="col-md-3 register-left">
            <img src="img/logoblanco.png" width="80" alt="" />
            <h3>Contabilidad</h3>
            <p>Registro de Costos!</p>
            <input type="submit" name="" value="2021" /><br />
        </div>
        <div class="col-md-9 register-right">
            <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                <?php if ($_SESSION["privilegios"] >= "2") { ?>
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                            aria-controls="home" aria-selected="true">Ingresos</a>
                    </li>
                <?php } ?>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                        aria-controls="profile" aria-selected="false">Gastos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="precios-tab" data-toggle="tab" href="#precios" role="tab"
                        aria-controls="precios" aria-selected="false">Precios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="resumen-tab" data-toggle="tab" href="#resumen" role="tab"
                        aria-controls="resumen" aria-selected="false">Resumen</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                    <h3 class="register-heading">Registro de ingresos</h3>


                    <div class="container" id="seleccion" style="padding: 100px;">

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body p-0">
                                        <form action="" method="GET">
                                            <?php


                                            $consulta = "SELECT *  from rutas";
                                            $resultado = $conexion->prepare($consulta);
                                            $resultado->execute();
                                            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);








                                            $cadena = "<label>Rutas Disponibles </label><br> 
      <select  id='ruta' name='ruta'>
<option value='-1'>Seleccionar una ruta</option> ";
                                            foreach ($data as $ver) {
                                                $fecha = $ver['fecha'];
                                                $idruta = $ver['id'];
                                                $fecha = fechaCastellano($fecha);



                                                $consulta2 = "SELECT comuna from pedidos where ruta_asignada = $idruta group by comuna";
                                                $resultado = $conexion->prepare($consulta2);
                                                $resultado->execute();
                                                $data2 = $resultado->fetchAll(PDO::FETCH_ASSOC);


                                                $comuna = "";

                                                foreach ($data2 as $ver2) {
                                                    $comuna .= ', ' . strtoupper($ver2['comuna']);

                                                }
                                                if ($ver['id'] == $_GET['ruta']) {

                                                    $cadena = $cadena . '<option selected="selected" value=' . $ver['id'] . '>' . $ver['id'] . ' - ' . $fecha . '</option>';
                                                } else {
                                                    $cadena = $cadena . '<option value=' . $ver['id'] . '>' . $ver['id'] . ' - ' . $fecha . '</option>';
                                                }

                                            }


                                            echo $cadena . "</select><br><br>";

                                            function fechaCastellano($fecha)
                                            {
                                                $fecha = substr($fecha, 0, 10);
                                                $numeroDia = date('d', strtotime($fecha));
                                                $dia = date('l', strtotime($fecha));
                                                $mes = date('F', strtotime($fecha));
                                                $anio = date('Y', strtotime($fecha));
                                                $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
                                                $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
                                                $nombredia = str_replace($dias_EN, $dias_ES, $dia);
                                                $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                                                $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
                                                $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
                                                return $nombredia . " " . $numeroDia . " de " . $nombreMes . " de " . $anio;
                                            }
                                            ?>
                                            <input type="submit" value="Consultar">
                                        </form>
                                        <br>
                                        <a href="javascript:imprSelec('seleccion')">Imprimir</a>

                                        <script language="Javascript">
                                            function imprSelec(nombre) {
                                                var ficha = document.getElementById(nombre);
                                                var ventimp = window.open(' ', 'popimpr');
                                                ventimp.document.write(ficha.innerHTML);
                                                ventimp.document.close();
                                                ventimp.print();
                                                ventimp.close();
                                            }
                                        </script>

                                        <?php
                                        $objeto = new Conexion();
                                        $conexion = $objeto->Conectar();

                                        $id_ruta = $_GET['ruta'];
                                        $consultar = "SELECT * FROM rutas where id =$id_ruta";
                                        $resultado2 = $conexion->prepare($consultar);
                                        $resultado2->execute();

                                        $data = $resultado2->fetchAll(PDO::FETCH_ASSOC);

                                        foreach ($data as $dat) {
                                            $fecharuta = $dat['fecha'];
                                        }


                                        ?>
                                        <div class="row p-4" style="margin:0 auto; ">Información de Ruta</div>
                                        <hr class="my-5">

                                        <div class="row pb-5 p-5">
                                            <div class="col-md-6">
                                                <p class="font-weight-bold mb-4">Información de Ruta</p>
                                                <p class="mb-1">Fecha: <?php echo $fecharuta; ?></p>

                                                <p class="mb-1">Despachador: <?php $fecha; ?></p>

                                            </div>

                                            <div class="col-md-6 text-right">
                                                <p class="font-weight-bold mb-4">Productos</p>
                                                <p class="mb-1"><span class="text-muted">Cantidad: </span> 20</p>
                                                <p class="mb-1"><span class="text-muted">Debito: </span> 1</p>
                                                <p class="mb-1"><span class="text-muted">Creditos: </span> 5</p>
                                                <p class="mb-1"><span class="text-muted">Efectivos: </span> 3</p>
                                            </div>
                                        </div>

                                        <div class="row p-5">
                                            <div class="col-md-12">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th class="border-0 text-uppercase small font-weight-bold">
                                                                ID</th>
                                                            <th class="border-0 text-uppercase small font-weight-bold">
                                                                Producto</th>
                                                            <th class="border-0 text-uppercase small font-weight-bold">
                                                                Tamaño</th>
                                                            <th class="border-0 text-uppercase small font-weight-bold">
                                                                Cantidad</th>
                                                            <th class="border-0 text-uppercase small font-weight-bold">
                                                                Precio</th>
                                                            <th class="border-0 text-uppercase small font-weight-bold">
                                                                Costo</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <?php
                                                            $costoproduccion = 0;

                                                            $ruta = $_GET['ruta'];

                                                            $consultar = "SELECT * FROM pedido_detalle
                                                            WHERE ruta_asignada = $ruta";
                                                            $resultado2 = $conexion->prepare($consultar);
                                                            $resultado2->execute();

                                                            $data = $resultado2->fetchAll(PDO::FETCH_ASSOC);

                                                            foreach ($data as $dat) {
                                                                echo "<tr>";
                                                                echo "<td>" . $dat['id'] . "</td>";
                                                                echo "<td>" . $dat['modelo'] . "</td>";
                                                                echo "<td>" . $dat['tamano'] . "</td>";
                                                                echo "<td>" . $dat['cantidad'] . "</td>";
                                                                echo "<td>$" . $dat['precio'] . "</td>";
                                                                $modeloaconsultar = $dat['modelo'];
                                                                $plazasaconsultar = $dat['tamano'];
                                                                $consultar3 = "SELECT * FROM gan WHERE modelo = '$modeloaconsultar' and tamano = '$plazasaconsultar' ";
                                                                $resultado3 = $conexion->prepare($consultar3);
                                                                $resultado3->execute();

                                                                $dataar = $resultado3->fetchAll(PDO::FETCH_ASSOC);

                                                                foreach ($dataar as $dts) {
                                                                    echo "<td>" . $dts['costo'] . "</td>";
                                                                    $costoproduccion += $dts['costo'];
                                                                }


                                                                //echo "<td>".$dat['mododepago']."</td>";
                                                            
                                                                echo "</tr>";
                                                                $total += $dat['precio'];
                                                                if ($dat['mododepago'] == "debito" || $dat['mododepago'] == "credito") {
                                                                    $debito += $dat['precio'];

                                                                }
                                                                if ($dat['mododepago'] == "transferencia") {
                                                                    $transferencia += $dat['precio'];

                                                                }
                                                                if ($dat['mododepago'] == "efectivo") {
                                                                    $efectivo += $dat['precio'];

                                                                }

                                                            }
                                                            ?>


                                                            <?php


                                                            $ruta = $_GET['ruta'];
                                                            $objeto = new Conexion();
                                                            $conexion = $objeto->Conectar();
                                                            $consultar = "SELECT * FROM pedido_detalle as p inner join rutas as r on p.ruta_asignada = r.id where MONTH(r.fecha)=MONTH(CURDATE()) and estado = 1 order by mododepago";
                                                            $resultado2 = $conexion->prepare($consultar);
                                                            $resultado2->execute();

                                                            $data = $resultado2->fetchAll(PDO::FETCH_ASSOC);

                                                            foreach ($data as $dat) {
                                                                //echo $dat['fecha'].' '.$dat['precio'].' '.$dat['mododepago'].' <br>';
                                                                $totales += $dat['precio'];
                                                                if ($dat['mododepago'] == "debito" || $dat['mododepago'] == "credito") {
                                                                    $debitos += $dat['precio'];

                                                                }
                                                                if ($dat['mododepago'] == "transferencia") {
                                                                    $transferencias += $dat['precio'];

                                                                }
                                                                if ($dat['mododepago'] == "efectivo") {
                                                                    $efectivos += $dat['precio'];

                                                                }

                                                            }


                                                            ?>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row-reverse bg-dark text-white p-1">
                                            <div class="py-3 px-5 text-right">
                                                <div class="mb-2">Total</div>
                                                <div class="h2 font-weight-light"><?php
                                                setlocale(LC_MONETARY, 'es_CL');
                                                echo number_format($total, 0, ',', '.'); ?></div>
                                            </div>

                                            <div class="py-3 px-4 text-right">
                                                <div class="mb-2">Costo Operacion</div>
                                                <div class="h2 font-weight-light"><?php echo $costoproduccion; ?></div>
                                                <div class="mb-2">Saldo</div>
                                                <div class="h2 font-weight-light">
                                                    <?php echo $saldo = $total - $costoproduccion; ?>
                                                </div>
                                            </div>


                                            <div class="py-3 px-4 text-right">
                                                <div class="mb-2">Transferencias</div>
                                                <div class="h2 font-weight-light"><?php echo $transferencia; ?></div>
                                                <div class="mb-2">Deb / cred</div>
                                                <div class="h2 font-weight-light"><?php echo $debito; ?></div>
                                            </div>

                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php $consultar = "SELECT s_diario FROM usuarios where pago = 'diario'";
                        $resultado2 = $conexion->prepare($consultar);
                        $resultado2->execute();

                        $data = $resultado2->fetchAll(PDO::FETCH_ASSOC);
                        $suma = 0;
                        foreach ($data as $dat) {
                            $suma += $dat['s_diario'];

                        }
                        $bencinatag = 23000;
                        $arriendo = 1750000 / 20;
                        $operacion = 0;
                        ?>
                        <div class="d-flex flex-row-reverse bg-dark text-white p-1">


                            <div class="py-3 px-4 text-right">
                                <div class="mb-2">Sueldos Diarios <?php
                                $operacion += $suma;
                                echo $suma; ?></div>

                            </div>

                            <div class="py-3 px-4 text-right">
                                <div class="mb-2">Bencina y tag <?php
                                $operacion += $bencinatag;
                                echo $bencinatag; ?></div>

                            </div>
                            <div class="py-3 px-4 text-right">
                                <div class="mb-2">Arriendo <?php
                                $operacion += $arriendo;

                                echo number_format($arriendo, 0, ',', '.')
                                    ?></div>

                            </div>

                            <div class="py-3 px-9 text-right">
                                <div class="mb-2">Gasto Logistico</div>
                                <div class="h4 font-weight-light"><?php
                                echo number_format($operacion, 0, ',', '.');
                                ?></div>


                                <div class="h2 font-weight-light">
                                    <?php


                                    ?>
                                    <div class="mb-2">Ganancia <?php
                                    echo number_format($saldo - $operacion, 0, ',', '.')

                                        ?></div>
                                </div>
                            </div>



                        </div>

                        <br>
                        <br>
                        <div style="font-size: 18px; margin:0 auto; text-align: center;"> <span>Total Mes Actual</span>
                        </div>
                        <div class="d-flex flex-row-reverse bg-dark text-white p-2">
                            <div class="py-3 px-6 text-right">
                                <div class="mb-2">Ingreso total del Mes</div>
                                <div class="h2 font-weight-light">




                                </div>
                            </div>

                            <!-- PROCEDIMIENTO PARA CALCULAR TOTALES MENSUALES -->
                            <?php
                            $consultardias = "SELECT * FROM pedido_detalle as p inner join rutas as r on p.ruta_asignada = r.id where MONTH(r.fecha)=MONTH(CURDATE())  group by ruta_asignada";
                            $resultadodias = $conexion->prepare($consultardias);
                            $resultadodias->execute();
                            $total_dias = $resultadodias->fetchColumn();
                            $data = $resultadodias->fetchAll(PDO::FETCH_ASSOC);


                            foreach ($data as $dat) {


                                $total_dias += 1;
                                $dat['ruta_asignada'] . " " . $dat['estado'] . "<br>";

                            }


                            $consultar = "SELECT * FROM pedido_detalle as p inner join rutas as r on p.ruta_asignada = r.id where MONTH(r.fecha)=MONTH(CURDATE()) order by mododepago";
                            $resultado2 = $conexion->prepare($consultar);
                            $resultado2->execute();

                            $data = $resultado2->fetchAll(PDO::FETCH_ASSOC);

                            $diastranscurridos = 0;
                            $costoproducciontotal = 0;
                            $cantidaddeproductos = 0;
                            $totales = 0;
                            foreach ($data as $dat) {

                                $totales += floatval($dat['precio']);

                                $cantidaddeproductos += 1;
                                $modeloaconsultar = $dat['modelo'];
                                $plazasaconsultar = $dat['tamano'];

                                $consultar3 = "SELECT * FROM gan WHERE modelo = '$modeloaconsultar' and tamano = '$plazasaconsultar' ";
                                $resultado3 = $conexion->prepare($consultar3);
                                $resultado3->execute();

                                $dataar = $resultado3->fetchAll(PDO::FETCH_ASSOC);
                                $costoproduccion = 0;
                                foreach ($dataar as $dts) {

                                    $costoproducciontotal += floatval($dts['costo']);
                                }

                            }
                            ?>

                            <div class="py-3 px-4 text-right">
                                <div class="mb-2">Total Gastos
                                    <?php echo $total_total = $costoproducciontotal + $suma * 20; ?>
                                </div>
                                <div class="mb-2"><?php


                                echo number_format($totales); ?></div>

                                <div class="mb-2">Total Ganancia <?php echo $totales - $total_total; ?></div>

                            </div>



                            <div class="py-3 px-1 text-right">
                                <div class="mb-2">Costo Prod Total <?php echo $costoproducciontotal; ?></div>
                                <!-- costo produccion total del mes hasta el dia de hoy -->

                            </div>
                            <div class="py-3 px-4 text-right">
                                <div class="mb-2">Sueldos <?php echo $sueldomensualtotal = $suma * 20; ?></div>


                            </div>

                        </div>



                        <?php





                        $d = new DateTime('first day of this month');

                        echo "Desde el " . $d->format('Y-m-d') . " al " . date('Y-m-d') . "<br>";


                        $d->format('Y-m-d');
                        $dia_actual = date('Y-m-d');

                        function sumasdiasemana($fecha, $dias)
                        {
                            $datestart = strtotime($fecha);
                            $datesuma = 15 * 86400;
                            $diasemana = date('N', $datestart);
                            $totaldias = $diasemana + $dias;
                            $findesemana = intval($totaldias / 5) * 2;
                            $diasabado = $totaldias % 5;
                            if ($diasabado == 6)
                                $findesemana++;
                            if ($diasabado == 0)
                                $findesemana = $findesemana - 2;

                            $total = (($dias + $findesemana) * 86400) + $datestart;
                            return $fechafinal = date('Y-m-d', $total);
                        }
                        $sumarDias = 1;
                        $entre1 = sumasdiasemana(date("Y-m-d"), $sumarDias);
                        $entre1;



                        ?>

                        <?php echo "Productos Entregados " . $cantidaddeproductos;
                        echo "<br>Cantidad de Rutas en el mes " . $total_dias;
                        ?>


                    </div>


                </div>
                <div class="tab-pane fade show" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <h3 class="register-heading">Ingreso de Gastos</h3>
                    <div class="row register-form">
                        <div class="col-md-10">
                            <form method="post" action="ingresar_gastos.php">
                                <div class="form-group">
                                    Monto <input type="text" name="monto" class="form-control" placeholder="$" value=""
                                        autocomplete="no" />
                                </div>

                                <div class="col-md-15">
                                    Detalle<textarea class="form-control" name="detalle" rows="5"></textarea>
                                </div><br>
                                <div class="col-md-6">
                                    <input type="submit" name="ingresar" class="btn btn-primary mb-2" value="ingresar">
                                </div>
                            </form>
                        </div>






                        <!-- <div class="col-md-6">
                                        
                                        
                                        <div class="form-group">
                                            <select class="form-control">
                                                <option class="hidden"  selected disabled>Please select your Sequrity Question</option>
                                                <option>What is your Birthdate?</option>
                                                <option>What is Your old Phone Number</option>
                                                <option>What is your Pet Name?</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="`Answer *" value="" />
                                        </div>
                                        <input type="submit" class="btnRegister"  value="Register"/>
                                    </div> -->


                    </div>

                </div>


                <div class="tab-pane fade show" id="precios" role="tabpanel" aria-labelledby="precios-tab">
                    <h3 class="register-heading">Precios</h3>
                    <div class="row register-form">

                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="border-0 text-uppercase small font-weight-bold">ID</th>
                                    <th class="border-0 text-uppercase small font-weight-bold">Producto</th>
                                    <th class="border-0 text-uppercase small font-weight-bold">1 plaza</th>
                                    <th class="border-0 text-uppercase small font-weight-bold">Full</th>
                                    <th class="border-0 text-uppercase small font-weight-bold">2 plazas</th>
                                    <th class="border-0 text-uppercase small font-weight-bold">Queen</th>
                                    <th class="border-0 text-uppercase small font-weight-bold">King</th>
                                    <th class="border-0 text-uppercase small font-weight-bold">Super King</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php



                                    $objeto = new Conexion();
                                    $conexion = $objeto->Conectar();
                                    $consultar = "SELECT * FROM productos";
                                    $resultado2 = $conexion->prepare($consultar);
                                    $resultado2->execute();

                                    $data = $resultado2->fetchAll(PDO::FETCH_ASSOC);

                                    foreach ($data as $dat) {
                                        echo "<tr>";
                                        echo "<td>" . $dat['id'] . "</td>";
                                        echo "<td>" . $dat['nombre'] . "</td>";
                                        echo "<td>$" . $dat['unaplaza'] . "</td>";
                                        echo "<td>$" . $dat['full'] . "</td>";
                                        echo "<td>$" . $dat['dosplazas'] . "</td>";
                                        echo "<td>$" . $dat['queen'] . "</td>";
                                        echo "<td>$" . $dat['king'] . "</td>";
                                        echo "<td>$" . $dat['superking'] . "</td>";

                                        echo "</tr>";


                                    }
                                    ?>


                            </tbody>
                        </table>



                    </div>
                </div>

                <br>
                <div class="tab-pane fade show" id="resumen" role="tabpanel" aria-labelledby="resumen-tab">
                    <h3 class="register-heading">Resumen de Gastos</h3>
                    <div class="row register-form" style="width: 100%">
                        <div class="col-md-15">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="border-0 text-uppercase small font-weight-bold">ID</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">Detalle</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">Monto</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">Fecha</th>


                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <?php


                                        $consultar = "SELECT * FROM gastos";
                                        $resultado2 = $conexion->prepare($consultar);
                                        $resultado2->execute();

                                        $data = $resultado2->fetchAll(PDO::FETCH_ASSOC);
                                        $suma = 0;
                                        foreach ($data as $dat) {
                                            echo "<tr>";
                                            echo "<td>" . $dat['id'] . "</td>";
                                            echo "<td>" . $dat['detalle'] . "</td>";
                                            echo "<td>$" . $dat['monto'] . "</td>";
                                            $suma += $dat['monto'];
                                            echo "<td>" . $dat['fecha'] . "</td>";


                                            echo "</tr>";


                                        }
                                        ?>


                                </tbody>
                            </table>
                            <?php setlocale(LC_MONETARY, 'es_CL');


                            echo "<b>Total de Gastos $" . number_format($suma) . "</b>"; ?>
                        </div>






                        <!-- <div class="col-md-6">
                                        
                                        
                                        <div class="form-group">
                                            <select class="form-control">
                                                <option class="hidden"  selected disabled>Please select your Sequrity Question</option>
                                                <option>What is your Birthdate?</option>
                                                <option>What is Your old Phone Number</option>
                                                <option>What is your Pet Name?</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="`Answer *" value="" />
                                        </div>
                                        <input type="submit" class="btnRegister"  value="Register"/>
                                    </div> -->


                    </div>

                </div>

            </div>
        </div>
    </div>

</div>
<!--FIN del cont principal-->

<?php require_once "vistas/parte_inferior.php" ?>