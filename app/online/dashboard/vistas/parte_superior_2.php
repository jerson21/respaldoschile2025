<?php
if(!isset($_SESSION)) 
    { session_start();  }
$_SESSION['nombre_user'] = $_SESSION["s_usuario"];
if($_SESSION["s_usuario"] === null){
    header("Location: ../index.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>RespaldosChile - Dashboard</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="https://www.respaldoschile.cl/assets/img/favicon.png" rel="icon">
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/rowgroup/1.1.3/js/dataTables.rowGroup.min.js"></script>
<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">


  




    <style type="text/css">

    #parpadea {
  
  animation-name: parpadeo;
  animation-duration: 1s;
  animation-timing-function: linear;
  animation-iteration-count: infinite;


  -webkit-animation-name:parpadeo;
  -webkit-animation-duration: 1s;
  -webkit-animation-timing-function: linear;
  -webkit-animation-iteration-count: infinite;
}

@-moz-keyframes parpadeo{  
  0% {   }
  50% { opacity: 0.5; }
  100% {  background-color: #0096FF;}

}

@-webkit-keyframes parpadeo {  
  0% { }
  50% { opacity: 0.5; }
   100% {  background-color: #0096FF;}
}

@keyframes parpadeo {  
  0% {  }
   50% { opacity: 0.5; }
  100% {  background-color: #0096FF;}
}

#parpadea_ {
  
  animation-name: parpadeo_;
  animation-duration: 1s;
  animation-timing-function: linear;
  animation-iteration-count: infinite;


  -webkit-animation-name:parpadeo_;
  -webkit-animation-duration: 1s;
  -webkit-animation-timing-function: linear;
  -webkit-animation-iteration-count: infinite;
}

@-moz-keyframes parpadeo_{  
  0% {   }
  50% { opacity: 0.5; }
  100% {  background-color: #FFCE33;}

}

@-webkit-keyframes parpadeo_ {  
  0% { }
  50% { opacity: 0.5; }
   100% {  background-color: #FFCE33;}
}

@keyframes parpadeo_ {  
  0% {  }
   50% { opacity: 0.5; }
  100% {  background-color: #FFCE33;}
}





</style>

  
 <style type="text/css">

#imagenes img {
    -webkit-transition: all 1s ease; /* Safari and Chrome */
    -moz-transition: all 1s ease; /* Firefox */
    -ms-transition: all 1s ease; /* IE 9 */
    -o-transition: all 1s ease; /* Opera */
    transition: all 1s ease;
}

#imagenes:hover img {
    -webkit-transform:scale(1.5); /* Safari and Chrome */
    -moz-transform:scale(1.5); /* Firefox */
    -ms-transform:scale(1.5); /* IE 9 */
    -o-transform:scale(1.5); /* Opera */
     transform:scale(1.5);
}
</style>
<?php if(isset($_GET['num_orden'])) { $num_orden = $_GET['num_orden'];  } ?>

  <script type="text/javascript">


function mostrar(id) {

    if (id == "respaldo") {
        $("#formularios").load('formularios/respaldoform.php?num_orden=<?php echo $num_orden; ?>');
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
  }
  </script>

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-right" href="index.php">
        <div>
         <!-- <i class="fas fa-laugh-wink"></i> -->
         <img src="img/logoblanco.png" width="60">
         <span style="font-family:Arial, sans-serif"> RespaldosChile</span>
        </div>
       
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
       <?php if($_SESSION["privilegios"] >= "20"){  ?>


      <li class="nav-item active">
        <a class="nav-link" href="dashboard.php">
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
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cog"></i>
          <span>Pedidos</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Metodos:</h6>

            <a class="collapse-item" href="validarpagos.php">Validar Pagos</a>
            
             
            
            <a class="collapse-item" href="agregarpedido.php">Agregar Pedido</a>
            
            <a class="collapse-item" href="todoslospedidos.php">Todos los Pedidos</a>
            <a class="collapse-item" href="pedidoseliminados.php">Pedidos Eliminados</a>
          </div>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo2" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cog"></i>
          <span>Rutas</span>
        </a>
        <div id="collapseTwo2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Metodos:</h6>

            
            <a class="collapse-item" href="crear_rutas.php">Crear Ruta</a>
             <a class="collapse-item" href="rute.php">Route RespaldosChile</a>
            <a class="collapse-item" href="asignar_rutabeta.php">Asignar a Ruta</a>
            
          </div>
        </div>
      </li>
 <?php } ?>


<?php if($_SESSION["privilegios"] == 0){  ?>
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

 <?php if($_SESSION["privilegios"] == 5){  ?>
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
          </div>

           



        </div>
      </li>
 <?php } ?>





<?php if($_SESSION["privilegios"] >= 20){  ?>
       <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo3" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cog"></i>
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

            
            <?php if($_SESSION["privilegios"] >= 20){  ?>

              <a class="collapse-item" href="cortar_telas.php">Cortar Telas</a>
              

            <?php } ?>
          </div>



        </div>
      </li>
 <?php } ?>


      <?php if($_SESSION["privilegios"] >= "20"){  ?>
       <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo5" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cog"></i>
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
          <i class="fas fa-fw fa-cog"></i>
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
    <?php if($_SESSION["privilegios"] >= 21){  ?>

       <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo4" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cog"></i>
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
            <?php if($_SESSION["privilegios"] >= 20 or $_SESSION["privilegios"] ==4){  ?>
       <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo7" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cog"></i>
          <span>Ventas</span>
        </a>
        <div id="collapseTwo7" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Metodos:</h6>

            


              <a class="collapse-item" href="agregarpedido_sala.php">Ventas</a>
               <a class="collapse-item" href="stock.php">Stock</a>

           
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
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $usuario = $_SESSION["s_usuario"];?></span>
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
