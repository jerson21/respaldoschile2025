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
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">  -->
 <style>
        /* Basic styles for demonstration if SB Admin CSS isn't linked */
        body { font-family: 'Inter', sans-serif; }

        /* Logo Animation */
        @keyframes mover {
            0% { transform: translateY(0); }
            100% { transform: translateY(-10px); }
        }
        .logo-animation {
            margin-top: 20%;
            width: 35%;
            animation: mover 1s infinite alternate;
        }

        /* Disabled Link Style */
        .disabled-link {
            pointer-events: none; /* Disable click and other mouse events */
            color: grey !important; /* Change color to look disabled, !important might be needed to override Bootstrap */
            cursor: not-allowed; /* Change cursor */
            position: relative; /* Needed for the pseudo-element positioning */
        }

        .disabled-link:hover::after {
            content: "En Proceso";
            position: absolute;
            left: 100%; /* Position to the right of the link */
            top: 50%; /* Center vertically */
            transform: translateY(-50%);
            margin-left: 10px; /* Space between link and tooltip */
            background-color: black;
            color: white;
            padding: 3px 8px;
            border-radius: 5px;
            font-size: 0.8em;
            white-space: nowrap; /* Prevent text wrapping */
            z-index: 10; /* Ensure tooltip is above other elements */
        }

        /* Add other necessary styles from SB Admin or your custom CSS */
    </style>
          <link rel="stylesheet" href="css/css_addpedido.css"> 

     <style>
        /* Estilo mínimo para asegurar layout básico */
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column; /* Ayuda si el contenido es corto y quieres footer abajo */
        }
        .main-wrapper {
             display: flex;
             flex-grow: 1;
        }
        .content-area {
            flex-grow: 1;
            display: flex;
            flex-direction: column; /* Para manejar topbar y main content verticalmente */
            overflow-x: auto; /* Permite scroll horizontal si el contenido es muy ancho */
        }
         main {
            flex-grow: 1; /* Hace que el contenido principal ocupe el espacio restante */
        }
         /* Ajuste para que el collapse no empuje el contenido del sidebar */
        .sidebar-nav .collapse .nav-link {
            padding-left: 1.5rem; /* Ajusta según necesidad */
        }
         /* Estilo para el indicador de dropdown en sidebar */
        .sidebar-nav .nav-link .fa-chevron-down {
             transition: transform 0.2s ease-in-out;
        }
        .sidebar-nav .nav-link[aria-expanded="true"] .fa-chevron-down {
            transform: rotate(180deg);
        }
        .badge-notification {
             position: absolute;
             top: -5px;
             right: -5px;
             padding: .25em .5em;
             font-size: .65em;
        }

    </style>

</head>

<body>
<?php require_once "vistas/parte_superior.php" ?>

<script>
    document.getElementById("content").style.background = " linear-gradient(135deg, #FFE6CC, #FFD9E5, #FFE5F0, #FFF2F7)";
</script>

<div class="outer-border">
    <div class="container2">
        <h1>Modulo Ingreso Pedidos</h1>

       <style> .progress-container {
            position: relative;
            margin-bottom: 10px;
        }
        
        .progress-track {
            position: relative;
            height: 12px;
            background: rgba(0, 0, 0, 0.06);
            border-radius: 12px;
            overflow: hidden;
            backdrop-filter: blur(20px);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
        }
        
        .progress-fill {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, #007aff, #5ac8fa);
            border-radius: 12px;
            transition: width 0.7s cubic-bezier(0.25, 1, 0.5, 1);
        }
        
        .progress-glow {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 0%;
            filter: blur(5px);
            background: linear-gradient(90deg, rgba(0, 122, 255, 0.5), rgba(90, 200, 250, 0.5));
            border-radius: 12px;
            transition: width 0.7s cubic-bezier(0.25, 1, 0.5, 1);
        }
        
        .progress-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 16px;
        }
        
        .progress-percentage {
            font-size: 22px;
            font-weight: 600;
            letter-spacing: -0.5px;
            color: #1d1d1f;
            transition: color 0.3s ease;
        }
        
        .progress-steps {
            font-size: 15px;
            color: #86868b;
            letter-spacing: -0.2px;
        }
        
        .progress-label {
            position: absolute;
            left: 0;
            font-size: 17px;
            font-weight: 500;
            color: #1d1d1f;
            transition: 0.3s ease;
            opacity: 0.8;
        }
         /* Dark mode support */
         @media (prefers-color-scheme: dark) {
            body {
                background-color: #1a1a1a;
                color: #f5f5f7;
            }
            
            .progress-track {
                background: rgba(255, 255, 255, 0.1);
            }
            
            .progress-percentage {
                color: #f5f5f7;
            }
            
            .progress-label {
                color: #f5f5f7;
            }
        }
        </style>
  <div class="progress-container">
      
            <div class="progress-track">
                <div class="progress-glow"></div>
                <div class="progress-fill"></div>
            </div>
            
        </div>

        <br>


        <style>
            .input-group-custom {
                position: relative;
                display: flex;
                align-items: center;
                width: 100%;
            }

            .form-control.custom-input {
                padding-right: 30px;
                /* Espacio para los íconos */
            }

            .input-group-custom .fas {
                position: absolute;
                right: 10px;
                display: none;
                /* Ocultar inicialmente los íconos */
            }

            .input-incorrect {
                border: 2px solid red;
                /* O cualquier estilo que prefieras para indicar error */
            }
        </style>
        <form id="formular" novalidate method="post">
            <fieldset>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <div class="input-group-custom">
                            <input type="text" name="rut" id="rut" class="form-control custom-input" placeholder="Rut" onkeydown="noPuntoComa(event)" oninput="checkRut(this);" autocomplete="off" required>
                            <i class="fas fa-check" id="iconoCheck" style="color:green;"></i> <!-- Ícono de check -->
                            <i class="fas fa-times" id="iconoCross" style="color:red;"></i> <!-- Ícono de X -->
                        </div>
                        <!-- <p class="text-info esse" id="msgerror" style="color:red !important; padding: 0; font-size: 13px;"></p>
    <p class="text-info" style="padding: 0; font-size: 13px; margin-bottom:10px;" id="msgvalido"></p> -->
                    </div>

                    <div class="form-group col-md-4">
                        <input type="text" name="name" id="name" class="form-control custom-input" placeholder="Nombre" value="<?php echo isset($nombre) ? $nombre : ''; ?>" required>
                        <input type="hidden" name="clienteexisterut" id="clienteexisterut" value="">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <input type="email" class="form-control custom-input" name="email" id="email" placeholder="Correo" value="<?php echo isset($correo) ? $correo : ''; ?>">

                    </div>

                    <div class="form-group col-md-4">
                        <input type="text" name="telefono" id="telefono" class="form-control custom-input" placeholder="Telefono" value="<?php echo isset($telefono) ? $telefono : ''; ?>" required>
                    </div>
                </div>


                <div class="form-row">
                    <div class="form-group col-md-4">

                        <input type="text" class="form-control custom-input" name="instagram" id="instagram" placeholder="Instagram, sala de ventas" value="<?php echo isset($instagram); ?>" required>
                    </div>
                    <div class="form-group col-md-4">

                        <select id="mododepago" name="mododepago" class="form-select form-select  custom-input" aria-label="Modo de Pago" required>

                            <option value="transferencia">Transferencia</option>
                            <option value="efectivo">Efectivo</option>
                            <option value="debito">Debito </option>
                            <option value="credito">Credito</option>
                            <option value="pagado">Pagado</option>
                        </select>

                    </div>

                </div>
                <!-- SI ES RETIRO EN TIENDA SE SELECCIONA UN CHECKBOX Y SE DESPLIEGA LA FECHA DE RETIRO -->
                <div class="form-row" style="margin-top: 15px; ">

                    <div class="col-md-8">
                        <div class="form-group">

                            <div class="form-check" >
                                <input class="form-check-input" type="checkbox" id="retiro_tienda" name="retiro_tienda">
                                <label class="form-check-label" for="retiro_tienda">
                                    <i class="fas fa-store"></i> Retiro en tienda
                                </label>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6" id="detalleretiro" style="display: none;">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Fecha</span>
                            </div>




                            <input class="form-control form-control-solid ps-12 flatpickr-input active" id="detalle_entrega" name="detalle_entrega" type="text" placeholder="Seleccionar Fecha">

                        </div>
                    </div>

                </div>
                <script>
                    flatpickr('#detalle_entrega', {
                        enableTime: true,
                        minTime: "09:00",
                        maxTime: "18:00",
                        minDate: "today",
                        dateFormat: "Y-m-d H:i",

                        // Otions adicionales de configuración si las necesitas
                    });
                </script>
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/flatpickr.min.css">
                <script src="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/flatpickr.min.js"></script>

                <!-- FIN DE FORMULARIO RETIRO EN TIENDA -->
                <hr>

                <!-- DIV QUE CONTIENE EL MAPA Y DIRECCION, OCULTARLO SI ES RETIRO EN TIENDA -->
                <div id="direccionymapa">
                    <div class="form-row">
                        <!-- Columna para dirección, departamento, y columna del mapa -->
                        <div class="col-md-8">
                            <div class="form-row">
                                <!-- Dirección -->
                                <div class="form-group col-md-9">
                                    <style>
                                        .verificar_button {
                                            cursor: pointer;
                                            /* Cambia el cursor a pointer */
                                        }

                                        .verificar_button:hover i {
                                            color: green !important;
                                            /* Asegura que el color del icono cambie a verde al pasar el mouse */
                                        }
                                    </style>

                                    <div class="input-group">
                                        <input type="text" name="direccion" class="form-control custom-input" id="search_input" placeholder="Ingrese Dirección..." value="" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text" name="verificar_button" id="verificar_button"><i class="fas fa-check verificar_button"></i></span>

                                        </div>

                                        <input type="hidden" id="loc_lat" />
                                        <input type="hidden" id="loc_long" />
                                        <input type="hidden" name="street_name" id="street_name" />
                                        <input type="hidden" name="street_number" id="street_number" />
                                        <input type="hidden" name="comunas" id="comunas" />
                                        <input type="hidden" name="regiones" id="regiones" />
                                        <input type="hidden" name="latitude_view" id="latitude_view" />
                                        <input type="hidden" name="longitude_view" id="longitude_view" />


                                    </div>
                                    <div id="result" style="margin-top: 5px;"></div>
                                </div>
                                <!-- Departamento -->
                                <div class="form-group col-md-3">
                                    <input type="text" class="form-control custom-input" name="dpto" id="dpto" placeholder="Dpto/casa" value="<?php echo isset($dpto); ?>">
                                </div>
                            </div>

                            <!-- Información adicional para la entrega -->
                            <div class="form-group col-md-8">

                                <textarea class="form-control custom-input" name="referencia" style="background-color: 0;" rows="3" placeholder="Información adicional para la entrega."></textarea>
                            </div>
                            <div class="form-group col-md-5">
                                <input type="hidden" readonly class="form-control custom-input" name="vendedor" value="<?php echo ucfirst($_SESSION['nombre_user']); ?>">
                            </div>

                            <?php date_default_timezone_set('America/Santiago');
$DateAndTime = date('Y-m-d h:i:s a', time()); ?>
                            <div class="form-group col-md-5">
                                <input type="hidden" name="fecha_ingreso" class="form-control custom-input" value="<?php setlocale(LC_ALL, "es_ES");
                                                                                                                    echo $DateAndTime ; ?>" readonly>
                            </div>
                        </div>

                        <!-- Columna para el mapa -->
                        <div class="col-md-4">
                            <div class="form-group" style="position: relative;">
                                <div class="overlay-iframe" style="width: 100%; overflow: hidden; margin:0;">
                                    <iframe src="https://www.google.com/maps/d/u/0/embed?mid=1V08qNPJ-nQ8sdKtPSvEUY-fVPT0HrvE&ehbc=2E312F&iwloc=near" width="100%" height="300" style="border: none;"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <input type="button" name="data[password]" class="next btn btn-info" value="Siguiente" />





            </fieldset>


            <!-- SIGUIENTE SECCIÓN -->

            <fieldset>
                <!-- <h2> Paso 2: Agregar detalles personales</h2> -->

                <?php

                include_once '../bd/conexion.php';
                $objeto = new Conexion();
                $conexion = $objeto->Conectar();

                if (isset($_GET['num_orden'])) {
                    $num_orden = $_GET['num_orden'];

                    // Preparar la consulta con PDO
                    $strsql1 = "SELECT * FROM pedido p
                    INNER JOIN pedido_detalle d ON d.num_orden = p.num_orden
                    LEFT JOIN clientes c ON p.rut_cliente = c.rut   
                    WHERE p.num_orden = :num_orden"; // Usar marcadores de nombre en PDO
                    $stmt = $conexion->prepare($strsql1);
                    $stmt->bindParam(':num_orden', $num_orden, PDO::PARAM_INT); // Enlazar el parámetro
                    $stmt->execute();
                    $rowfila = $stmt->fetch(PDO::FETCH_ASSOC); // Obtener el resultado

                    if ($rowfila) {
                        echo "<div class='alert alert-success'>";
                        echo "<p style='margin-bottom:0;'>Ingresando un nuevo producto para la orden Nº: " . htmlspecialchars($num_orden) . " Cliente " . htmlspecialchars($rowfila['rut_cliente']) . "</p>";

                        // Repetir la consulta no es necesario, reutilizar el resultado anterior
                        do {
                            // Tu lógica para manejar los datos aquí...
                        } while ($row1 = $stmt->fetch(PDO::FETCH_ASSOC)); // Continuar obteniendo el resto de las filas
                        echo "</div>";
                    }

                    // Segunda consulta con PDO
                    $strsql = "SELECT * FROM pedido p
                    INNER JOIN clientes c ON p.rut_cliente = c.rut
                    LEFT JOIN pedido_detalle pd ON p.num_orden = pd.num_orden
                    WHERE p.num_orden = :num_orden";
                    $stmt = $conexion->prepare($strsql);
                    $stmt->bindParam(':num_orden', $num_orden, PDO::PARAM_INT);
                    $stmt->execute();

                    $data = array();
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                        $rut_cliente = $row['rut_cliente'];
                        $direccion = $row['direccion'];
                        $telefono = $row['telefono'];
                        $numero = $row['numero'];
                        $dpto = $row['dpto'];
                        $correo = $row['correo'];
                        $instagram = $row['instagram'];
                    }
                }
                ?>


                <div class="col-md-6" style="text-align: center; margin:0 auto;">
                    <label> Que producto quieres agregar?</label>
                    <select id="status" name="status" class="form-select" onChange="mostrar(this.value)">
                        <option value="">Seleccionar producto</option>
                        <option value="respaldo">Respaldos de Cama</option>
                        <option value="colchon">Colchones</option>
                        <option value="base">Base de Cama</option>
                        <option value="velador">Veladores</option>
                        <option value="patas">Patas de cama</option>
                        <option value="banquetas">Banquetas</option>
                        <option value="fundas">Fundas</option>
                        <option value="living">Living</option>

                    </select>

                </div>
                <p></p>
                <main>

                    <div id="formularios" style="display: none; padding:15px; "> </div>
                </main>











                <div id="fracaso" style=" width: 60rem; margin:0 auto; text-align: center; ">


                </div>



                <input type="button" name="previous" class="previous btn btn-default" value="Previo" />
                <input type="button" name="next" class="next btn btn-info" value="Siguiente" />
            </fieldset>
            <fieldset>
                <h2>Detalle de Pedidos</h2>
                <div id="pedidosAgregados">
                    <!-- Los pedidos se generarán dinámicamente aquí -->
                </div>
                <div class="container-fluid">
                    <div class="pedido-resumen">
                        <div class="pedido-abono">
                            <label for="message">Observaciones: </label>
                            <input type="text" class="form-control TotalAbono" name="message" id="message" value="">
                            <!--  <button type="button" class="btn btn-success  btn-sm btnEditarOrden"  style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;" >Ingresar Pagos</button> -->
                        </div>
                        <div class="pedido-despacho">
                            <label for="valorDespacho">Valor Despacho: </label>
                            <input type="number" class="form-control valorDespacho" name="valorDespacho" id="valorDespacho" value="" placeholder="0">
                        </div>
                        <div class="pedido-total">
                            <label for="valorTotal">Valor Total: $</label>
                            <input type="text" class="form-control" id="valorTotal" disabled value="" placeholder="0">
                            <small id="passwordHelpInline" class="text-muted">
                                Suma de todos los precios más despacho.
                            </small>
                            <input type="hidden" name="pedidosJson" id="pedidosJson" value="">

                        </div>
                    </div>
                </div>
                <input type="button" name="previous" class="previous btn btn-default" value="Previo" />
                <input type="submit" name="botonenviar" class="submit btn btn-success" value="Enviar" id="submit_data" />
            </fieldset>
            <fieldset>
                <div id="contenidoDinamico"></div>
            </fieldset>
        </form>
    </div>
</div>


<!--INICIO del cont principal-->

<!--FIN del cont principal-->





<script src="js/addpedido_logic.js"></script>


<script
  loading="async"
  src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyAy1me0GgrNwevFOTCa8MQo2gNNt79JizI&callback=initMap">
</script>
<?php include("modal_validarpagos.php"); ?>
<?php require_once "vistas/parte_inferior.php" ?>