<!DOCTYPE html>
<html>

<head>
  <title>Despachos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


  <style type="text/css">
    .titulo {
      text-align: center;
      margin: 0 auto;
    }
  </style>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    .contenido-central .select-container {
      width: 100%;
      /* Asegura que el contenedor ocupa el espacio disponible */
      max-width: 500px;
      /* Límite máximo para el ancho */
    }

    .contenido-central select.form-select {
      width: 100%;
      overflow-x: hidden;
      /* Oculta cualquier desbordamiento horizontal */
    }

    .contenido-central select.form-select option {
      text-overflow: ellipsis;
      /* Muestra puntos suspensivos si el texto es demasiado largo */
      overflow: hidden;
      /* Evita que el texto desborde */
      white-space: nowrap;
      /* Evita que el texto se envuelva en líneas nuevas */
    }
  </style>
</head>

<body style="background-color: #C90000;">
<div class="container contenido-central">
    <form action="" method="get" class="w-50 d-flex align-items-end">
        <?php
        include("conexion.php");
        $anioActual = date('Y');
        $mesActual = date('m');

        $sql = "SELECT * FROM rutas WHERE YEAR(fecha) = $anioActual AND MONTH(fecha) = $mesActual";
        $result = mysqli_query($conn, $sql);

        $cadena = "<div class='mb-3 me-2 flex-grow-1'><label for='ruta'>Rutas Disponibles</label>
                   <select id='ruta' name='ruta' class='form-select'>
                   <option value='-1'>Seleccionar una ruta</option>";
        while ($ver = mysqli_fetch_row($result)) {
            $fecha = fechaCastellano($ver[2]);
            $idruta = $ver[0];

            $sql2 = "SELECT comuna FROM pedido_detalle WHERE ruta_asignada = $idruta GROUP BY comuna";
            $result2 = mysqli_query($conn, $sql2);

            $comuna = "";
            while ($ver2 = mysqli_fetch_row($result2)) {
                $comuna .= ', ' . $ver2[0];
            }

            $cadena .= '<option value="' . $ver[0] . '">' . $ver[0] . ' - ' . $fecha . ' ' . trim($comuna, ', ') . '</option>';
        }
        $cadena .= "</select></div>";
        echo $cadena;
        ?>

        <button type="submit" class="btn btn-light ms-2">Ingresar</button>
    </form>
</div>

  </div>

  <form action="" method="post" name="formulario-busqueda" id="formulario-busqueda">
    <div class="row gy-4">
      <div class="col-md-1">
        <!-- border-style: none!important; background-color: transparent; -->
        <input type="text"
          style=" width: 50px; height: 0px; outline: none;  "
          name="codigo" id="codigo" autofocus="on" autocomplete="off" onchange="validarsalida()">
      </div>


 

      <script type="text/javascript">
$(document).ready(function() {

  recargarLista();

    // Evento para manejar los cambios y disparar la validación
    $('#codigo').on('change', function() {
        validarsalida(); // Se llama a esta función cuando hay un cambio confirmado en el input
    });

    // Asegurar que el input vuelve a tener el foco después de salir de él
    setTimeout(function() {
        $('#codigo').focus();
    }, 1000); // Ajusta el tiempo según sea necesario
});

function validarsalida() {
    var codigo = $('#codigo').val();
    var ruta = <?php echo json_encode($_GET['ruta'] ?? ''); ?>;

    $.ajax({
        url: "validarsalida.php",
        type: "POST",
        data: { id: codigo, ruta: ruta },
        success: function (response) {
            Swal.fire({
                title: 'Resultado',
                text: response,
                icon: 'success',
                confirmButtonText: 'Ok',
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then((result) => {
                if (result.isConfirmed) {
                    recargarLista(); // Solo recarga la lista si el usuario confirma el SweetAlert
                }
            });
        },
        error: function () {
            Swal.fire({
                title: 'Error!',
                text: 'Ha ocurrido un error en la solicitud.',
                icon: 'error',
                confirmButtonText: 'Cerrar',
                allowOutsideClick: false,
                allowEscapeKey: false
            });
        }
    });
}

function recargarLista() {
    var ruta = <?php echo json_encode($_GET['ruta'] ?? ''); ?>;
    $.ajax({
        type: "POST",
        url: "data.php",
        data: { id: ruta },
        success: function (data) {
            $('#pedido').html(data);
        },
        error: function () {
            alert("Error seleccionando ruta");
        }
    });
}
  
 // setInterval(recargarLista, 6000); 
</script>
    </div>
  </form>
  <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Mostrar Modal
</button> -->
<?php
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



  <div class="titulo" style="    color:white;
">
    <h1>SIGUIENTE PRODUCTO</h1>
  </div>


<!-- setInterval(recargarLista, 6000); -->
  <div id="pedido"
    style="text-align: center; font-size:4rem; background-color: white; border-radius: 10px; margin: 2rem;">


  </div>
  <br>


  <br>

  <div id="pedido" style="text-align: center; font-size:4rem;  border-radius: 10px; margin: 2rem;">
    <?php

    $id_ruta = $_GET['ruta'];
    $strsqlsr = "SELECT * FROM pedido_detalle WHERE ruta_asignada = $id_ruta";
    $rss3 = mysqli_query($conn, $strsqlsr);
    $row_cnt = $rss3->num_rows;



    $strsqls = "SELECT * FROM rutas WHERE id = $id_ruta";
    $rss = mysqli_query($conn, $strsqls);


    while ($arow = mysqli_fetch_array($rss)) {

      echo "Fecha: " . $arow['fecha'] . "<br>Cantidad de productos: " . $row_cnt;

    }


    ?>

  </div>


  <div style="text-align: center; margin:0 auto;">
    <div class="col-md-6" style="margin:0 auto;">

      <div class="showQRCode"></div>
    </div>
  </div>


  </div>



</body>

</html>