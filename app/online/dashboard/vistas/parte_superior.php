<?php
if (!isset($_SESSION)) {
  session_start();
}

$_SESSION['nombre_user'] = $_SESSION["s_usuario"];



if ($_SESSION["s_usuario"] === null) {

  header("Location: ../index.php");
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>RespaldosChile - Dashboard</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <script src="https://kit.fontawesome.com/c5b4401310.js" crossorigin="anonymous"></script>

  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="https://www.respaldoschile.cl/assets/img/favicon.png" rel="icon">


  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">



  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/flatpickr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/flatpickr.min.js"></script>


  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.all.min.js"></script>

  <script async defer src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyAy1me0GgrNwevFOTCa8MQo2gNNt79JizI"></script>

  <link rel="stylesheet" type="text/css" href="css/design_respaldoschile.css">



  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

  <script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/rowgroup/1.1.3/js/dataTables.rowGroup.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.all.min.js"></script>


  <style type="text/css">
    #parpadea {

      animation-name: parpadeo;
      animation-duration: 1s;
      animation-timing-function: linear;
      animation-iteration-count: infinite;


      -webkit-animation-name: parpadeo;
      -webkit-animation-duration: 1s;
      -webkit-animation-timing-function: linear;
      -webkit-animation-iteration-count: infinite;
    }

    @-moz-keyframes parpadeo {
      0% {}

      50% {
        opacity: 0.5;
      }

      100% {
        background-color: #0096FF;
      }

    }

    @-webkit-keyframes parpadeo {
      0% {}

      50% {
        opacity: 0.5;
      }

      100% {
        background-color: #0096FF;
      }
    }

    @keyframes parpadeo {
      0% {}

      50% {
        opacity: 0.5;
      }

      100% {
        background-color: #0096FF;
      }
    }

    #parpadea_ {

      animation-name: parpadeo_;
      animation-duration: 1s;
      animation-timing-function: linear;
      animation-iteration-count: infinite;


      -webkit-animation-name: parpadeo_;
      -webkit-animation-duration: 1s;
      -webkit-animation-timing-function: linear;
      -webkit-animation-iteration-count: infinite;
    }

    @-moz-keyframes parpadeo_ {
      0% {}

      50% {
        opacity: 0.5;
      }

      100% {
        background-color: #FFCE33;
      }

    }

    @-webkit-keyframes parpadeo_ {
      0% {}

      50% {
        opacity: 0.5;
      }

      100% {
        background-color: #FFCE33;
      }
    }

    @keyframes parpadeo_ {
      0% {}

      50% {
        opacity: 0.5;
      }

      100% {
        background-color: #FFCE33;
      }
    }


    .subir {
      border: 1px solid #7F9EEE;
      padding: 20px;
      width: auto;
      border-radius: 15px;
      min-height: 150px;
      margin: auto;
      background: #C0E1F9;
      margin-bottom: 5px;
    }

    .archivos {
      border: 1px solid #89EA53;
      padding: 10px;
      width: auto;
      min-height: 150px;
      border-radius: 15px;
      margin: auto;
      background: #CCF8B4;
    }
  </style>


  <style type="text/css">
    #imagenes img {
      -webkit-transition: all 1s ease;
      /* Safari and Chrome */
      -moz-transition: all 1s ease;
      /* Firefox */
      -ms-transition: all 1s ease;
      /* IE 9 */
      -o-transition: all 1s ease;
      /* Opera */
      transition: all 1s ease;
    }

    #imagenes:hover img {
      -webkit-transform: scale(1.5);
      /* Safari and Chrome */
      -moz-transform: scale(1.5);
      /* Firefox */
      -ms-transform: scale(1.5);
      /* IE 9 */
      -o-transform: scale(1.5);
      /* Opera */
      transform: scale(1.5);
    }

    @-webkit-keyframes mover {
      0% {
        transform: translateY(0);
      }

      100% {
        transform: translateY(-15px);
      }
    }

    @keyframes mover {
      0% {
        transform: translateY(0);
      }

      100% {
        transform: translateY(-15px);
      }
    }
  </style>
  <?php
  $num_orden = "";

  if (isset($_GET['num_orden'])) {
    $num_orden = $_GET['num_orden'];
  } ?>

  <script type="text/javascript">
    function mostrar(id) {
      // SE DEBEN VINCULAR LOS EVENTOS Y FUNCIONES YA QUE ES DINAMICA LA CARGA DEL FORMULARIO. 
      if (id == "respaldo") {
        $("#formularios").load('formularios/respaldoform.php?num_orden=<?php echo $num_orden; ?>', function() {
          // Esta función callback se ejecuta después de que el contenido se ha cargado
          $("#formularios").show();
          vincularEventosASelect();
        });

      }
      if (id == "colchon") {
        $("#formularios").load('formularios/colchonform.php?num_orden=<?php echo $num_orden; ?>', function() {
          // Esta función callback se ejecuta después de que el contenido se ha cargado
          $("#formularios").show();
          vincularEventosASelect();
        });

      
      }
      if (id == "base") {
        $("#formularios").load('formularios/baseform.php?num_orden=<?php echo $num_orden; ?>', function() {
          // Esta función callback se ejecuta después de que el contenido se ha cargado
          $("#formularios").show();
          vincularEventosASelect();
        });

      }
      if (id == "patas") {
        $("#formularios").load('formularios/patasform.php?num_orden=<?php echo $num_orden; ?>', function() {
          // Esta función callback se ejecuta después de que el contenido se ha cargado
          $("#formularios").show();
          vincularEventosASelect();
        });

      }
      if (id == "respaldo2") {
        $("#formularios").load('formularios/respaldoform2.php?num_orden=<?php echo $num_orden; ?>', function() {
          // Esta función callback se ejecuta después de que el contenido se ha cargado
          $("#formularios").show();
          vincularEventosASelect();
        });

      }
      if (id == "banquetas") {
        $("#formularios").load('formularios/banquetaform.php?num_orden=<?php echo $num_orden; ?>', function() {
          // Esta función callback se ejecuta después de que el contenido se ha cargado
          $("#formularios").show();
          vincularEventosASelect();
        });

      }
      if (id == "fundas") {
        $("#formularios").load('formularios/fundasform.php?num_orden=<?php echo $num_orden; ?>', function() {
          // Esta función callback se ejecuta después de que el contenido se ha cargado
          $("#formularios").show();
          vincularEventosASelect();
        });

      }
      if (id == "living") {
        $("#formularios").load('formularios/livingform.php?num_orden=<?php echo $num_orden; ?>', function() {
          // Esta función callback se ejecuta después de que el contenido se ha cargado
          $("#formularios").show();
          vincularEventosASelect();
        });

      }
      if (id == "velador") {
        $("#formularios").load('formularios/velador_form.php?num_orden=<?php echo $num_orden; ?>', function() {
          // Esta función callback se ejecuta después de que el contenido se ha cargado
          $("#formularios").show();
          vincularEventosASelect();
        });

      }
      if (id == "") {

        $("#formularios").hide();
      }


    }

    function mostrarprod(id) {

      if (id == "respaldo") {
        $("#formularios").load('administracion/formagregarcosto.php?num_orden=<?php echo $num_orden; ?>');
        $("#formularios").show();
      }
      if (id == "colchon") {
        $("#formularios").load('formularios/colchonform.php?num_orden=<?php echo $num_orden; ?>');
        $("#formularios").show();
      }
      if (id == "base") {
        $("#formularios").load('formularios/baseform.php?num_orden=<?php echo $num_orden; ?>');
        $("#formularios").show();
      }
      if (id == "patas") {
        $("#formularios").load('formularios/patasform.php?num_orden=<?php echo $num_orden; ?>');
        $("#formularios").show();
      }
      if (id == "respaldo2") {
        $("#formularios").load('formularios/respaldoform2.php?num_orden=<?php echo $num_orden; ?>');
        $("#formularios").show();
      }
      if (id == "banquetas") {
        $("#formularios").load('formularios/banquetaform.php?num_orden=<?php echo $num_orden; ?>');
        $("#formularios").show();
      }
      if (id == "fundas") {
        $("#formularios").load('formularios/fundasform.php?num_orden=<?php echo $num_orden; ?>');
        $("#formularios").show();
      }
      if (id == "living") {
        $("#formularios").load('formularios/livingform.php?num_orden=<?php echo $num_orden; ?>');
        $("#formularios").show();
      }
      if (id == "velador") {
        $("#formularios").load('formularios/velador_form.php?num_orden=<?php echo $num_orden; ?>');
        $("#formularios").show();
      }
    }
  </script>

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-dark p-1 sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-right" href="index.php">
        <div>
          <!-- <i class="fas fa-laugh-wink"></i> -->


          <img style="  margin-top: 20%;  width: 35%;  -webkit-animation: mover 2s infinite alternate;
  animation: mover 1s infinite alternate;
" src="img/logoblanco.png" width="80">

          <span class="text-warning" style="font-family: 'Montserrat', sans-serif;"> RespaldosChile</span>
        </div>

      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <?php if ($_SESSION["privilegios"] >= "20") { ?>


        <li class="nav-item active">
          <a class="nav-link" href="dashboard2024.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
        </li>



        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
          Interface
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo10" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fa-solid fa-cube text-success"></i>

            <span>BODEGA</span>
          </a>
          <div id="collapseTwo10" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">

              <a class="collapse-item" href="productos.php">Ver Stock</a>
              <a class="collapse-item" href="escanear.php">Ingresar Producto</a>
              <a class="collapse-item" href="escanear_telas.php">Ingresar Telas</a>
              <a class="collapse-item" href="esc_stock_telas.php">Ingresar costuras</a>



              <a class="collapse-item" href="mover.php">Mover de Lugar</a>


            </div>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fa fa-bars text-warning" aria-hidden="true"></i>

            <span>Pedidos</span>
          </a>
          <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">


            <!--  <a class="collapse-item" href="validarpagos.php">Validar Pagos</a>-->
              <a class="collapse-item" href="validar_pagos2024.php">Validar Pagos</a>



          <!--  <a class="collapse-item" href="agregarpedido.php">Agregar Pedido</a>      -->
              <a class="collapse-item" href="addpedido.php">Agregar Pedido</a>

              <a class="collapse-item" href="todoslospedidos.php">Todos los Pedidos</a>
              <a class="collapse-item" href="pedidoseliminados.php">Pedidos Eliminados</a>
            </div>
          </div>
        </li>
<style>.disabled-link {
    pointer-events: none;  /* Deshabilita clic y otros eventos del mouse */
    color: grey;  /* Cambia el color para dar aspecto de desactivado */
}

.disabled-link:hover::after {
    content: "En Proceso";
    position: absolute;
    left: 100%;  /* Ajusta según necesidad */
    top: 0;  /* Ajusta según necesidad */
    background-color: black;
    color: white;
    padding: 5px;
    border-radius: 5px;
    white-space: nowrap;  /* Evita que el texto se rompa en varias líneas */
} </style>
      <!--   <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo15" aria-expanded="true" aria-controls="collapseTwo15">
            <i class="fa fa-asterisk   text-warning" aria-hidden="true"></i>

            <span>Stock Telas</span>
          </a>
          <div id="collapseTwo15" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">


              <a class="collapse-item" href="validar_pagos2024.php">Ver Stock</a>



              <a class="collapse-item" href="addpedido.php">Agregar Stock</a>

             
            </div>
          </div>
        </li> -->
        <li class="nav-item">
    <a class="nav-link disabled-link" href="#" aria-expanded="false">
        <i class="fa fa-asterisk text-warning" aria-hidden="true"></i>
        <span>Stock Telas</span>
    </a>
    <div id="collapseTwo15" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="validar_pagos2024.php">Ver Stock</a>
            <a class="collapse-item" href="addpedido.php">Agregar Stock</a>
        </div>
    </div>
</li>


         <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo9" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fa fa-cubes text-info" aria-hidden="true"></i>

          <span>Stock Productos</span>
          </a>
          <div id="collapseTwo9" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">


            <a class="collapse-item" href="stock_productos.php">Ingresar Producto</a>
            <a class="collapse-item" href="stock_productos.php">Ver Stock</a>
            <a class="collapse-item" href="vender_stock.php">Venta Stock</a>




          </div>
          </div>
        </li> 




        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo2" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fa fa-location-arrow text-warning" aria-hidden="true"></i>

            <span>Rutas</span>
          </a>
          <div id="collapseTwo2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Metodos:</h6>


              <a class="collapse-item" href="crear_rutas.php">Crear Ruta</a>
              <a class="collapse-item" href="seleccionar_ruta.php">Ver Rutas</a>

              <!-- <a class="collapse-item" href="asignacion_ruta.php">Asignar a Ruta</a> -->

            </div>
          </div>
        </li>
      <?php } ?>


      <?php if ($_SESSION["privilegios"] == 0) { ?>
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo3" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Produccion</span>
          </a>
          <div id="collapseTwo3" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Metodos:</h6>




              <a class="collapse-item" href="produccion_tapiceros.php">Ver Produccion</a>

            </div>





          </div>
        </li>
      <?php } ?>

      <?php if ($_SESSION["privilegios"] == 5) { ?>
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo3" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Produccion</span>
          </a>
          <div id="collapseTwo3" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Metodos:</h6>




              <a class="collapse-item" href="vista_produccion.php">Ver Produccion</a>
              <a class="collapse-item" href="cortar_telas.php">Cortar Telas</a>
              <a class="collapse-item" href="cortar_estructuras.php">Cortar Esqueletos</a>
            </div>





          </div>
        </li>
      <?php } ?>





      <?php if ($_SESSION["privilegios"] >= 20) { ?>
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo3" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog text-warning"></i>
            <span>Produccion</span>
          </a>
          <div id="collapseTwo3" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Metodos:</h6>


              <a class="collapse-item" href="registro_esqueletos.php">Ingreso Esqueletos</a>
              <a class="collapse-item" href="prod_tapiceros.php">Asignar Produccion</a>


              <a class="collapse-item" href="produccion_tapiceros.php">Ver Produccion</a>
            </div>

            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Telas:</h6>

              <a class="collapse-item" href="metraje.php">Ver Metrajes</a>
              <?php if ($_SESSION["privilegios"] >= 20) { ?>

                <a class="collapse-item" href="cortar_telas.php">Cortar Telas</a>
                <a class="collapse-item" href="cortar_estructuras.php">Cortar Esqueletos</a>



              <?php } ?>
            </div>



          </div>
        </li>
      <?php } ?>


      <?php
      /* SECCION DE STARKEN */
      if ($_SESSION["privilegios"] >= 20) { ?>
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo8" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fa fa-location-arrow  text-success"></i>
            <span>Starken</span><span style="font-size: 9px; margin-top:0; color:RED;"> </span>
          </a>
          <div id="collapseTwo8" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Funciones:</h6>


              <a class="collapse-item" href="consultastarken.php">Cotizar envío</a>
              <a class="collapse-item" href="consultastarken.php">Consulta Segumiento</a>
              <a class="collapse-item" href="consultastarken.php">Ingresar Orden</a>
            </div>





          </div>
        </li>
      <?php } ?>





      <?php if ($_SESSION["privilegios"] >= "20") { ?>
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo5" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fa fa-address-book text-warning" aria-hidden="true"></i>

            <span>Clientes</span>
          </a>
          <div id="collapseTwo5" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Metodos:</h6>


              <a class="collapse-item" href="verclientes.php">Clientes</a>

            </div>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo6" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fa fa-bullseye text-warning" aria-hidden="true"></i>


            <span>Colores</span>
          </a>
          <div id="collapseTwo6" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Metodos:</h6>


              <a class="collapse-item" href="agregar_colores.php">Agregar Colores</a>

            </div>
          </div>
        </li>
      <?php } ?>
      <?php if ($_SESSION["privilegios"] >= 21) { ?>
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo411" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fa fa-book text-warning" aria-hidden="true"></i>
            <span>Costos</span>
          </a>
          <div id="collapseTwo411" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Metodos:</h6>




              <a class="collapse-item" href="productos_inventario.php">Costos Produccion</a>


            </div>







          </div>
        </li>



        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo4" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fa fa-book text-warning" aria-hidden="true"></i>
            <span>Contabilidad</span>
          </a>
          <div id="collapseTwo4" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Metodos:</h6>




              <a class="collapse-item" href="contabilidad.php">Contabilidad</a>
              <a class="collapse-item" href="pagos.php">Pagos</a>


            </div>







          </div>
        </li>
      <?php } ?>
      <?php if ($_SESSION["privilegios"] >= 20 or $_SESSION["privilegios"] == 4) { ?>
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo7" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fa fa-keyboard text-warning" aria-hidden="true"></i>
            <span>Ventas</span>
          </a>
          <div id="collapseTwo7" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Metodos:</h6>




              <a class="collapse-item" href="agregarpedido_sala.php">Ventas</a>
              <a class="collapse-item" href="stock.php">Stock</a>
              <a class="collapse-item" href="reimprimir.php">Re-impirmir</a>
              <a class="collapse-item" href="retiro.php">Retiro</a>


            </div>







          </div>
        </li>
      <?php } ?>




      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>



          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>

            <!-- Nav Item - Alerts -->

            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <span class="badge badge-danger badge-counter">3+</span>
              </a>
              <!-- Dropdown - Alerts -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                  Notificaciones
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-primary">
                      <i class="fas fa-file-alt text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">Mayo, 2022</div>
                    <span class="font-weight-bold">Mantener Lugar de trabajo limpio!</span>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-success">
                      <i class="fas fa-donate text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 7, 2019</div>
                    $290.29 has been deposited into your account!
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-warning">
                      <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 2, 2019</div>
                    Spending Alert: We've noticed unusually high spending for your account.
                  </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
              </div>
            </li>

            <!-- Nav Item - Messages -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <!-- Counter - Messages -->
                <span class="badge badge-danger badge-counter">7</span>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                  Centro de Mensajes
                </h6>

                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="img/chapon.jpg" alt="">
                    <div class="status-indicator bg-success"></div>
                  </div>
                  <div class="font-weight-bold">
                    <div class="text-truncate">Verificar Chapon.</div>
                    <div class="small text-gray-500">Diciembre</div>
                  </div>
                </a>



                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="img/espuma.jpg" alt="">
                    <div class="status-indicator"></div>
                  </div>
                  <div>
                    <div class="text-truncate">Verificar Espuma</div>
                    <div class="small text-gray-500">Todas las densidades</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="img/tafetan.jpg" alt="">
                    <div class="status-indicator bg-warning"></div>
                  </div>
                  <div>
                    <div class="text-truncate">Verificar Tafetan</div>
                    <div class="small text-gray-500"></div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="img/corchetes.jpg" alt="">
                    <div class="status-indicator bg-success"></div>
                  </div>
                  <div>
                    <div class="text-truncate">Verificar Corchetes</div>
                    <div class="small text-gray-500">71 12 - 14 45</div>
                  </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
              </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                  <?php echo $usuario = $_SESSION["s_usuario"]; ?>
                </span>
                <!--                <img class="img-profile rounded-circle" src="https://source.unsplash.com/QAB-WJcbgJk/60x60">-->
                <img class="img-profile rounded-circle" src="img/user.png">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Settings
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                  Activity Log
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Cerrar Sesión
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->