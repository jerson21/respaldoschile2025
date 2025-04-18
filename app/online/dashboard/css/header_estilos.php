  <!-- Fuentes e íconos -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
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
  <script async defer src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyAy1me0GgrNwevFOTCa8MQo2gNNt79JizI"></script>
  <link rel="stylesheet" type="text/css" href="css/design_respaldoschile.css">

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

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">  <style>
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