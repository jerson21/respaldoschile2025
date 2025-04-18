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
<style type="text/css">
  .fila-par {
    background-color: #f0f0f0;
  }

  .fila-coincidente {
    background-color: rgba(51, 122, 183, 0.5);
    color: black;
  }


  .tabla-corporativa {
    border-collapse: collapse;
    width: 100%;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 10px;
    /* Bordes redondeados */
    background-color: #FFFFFF;
  }

  .tabla-corporativa th,
  .tabla-corporativa td {
    border: 0;
    /* Quitar bordes entre celdas */
    border-bottom: 1px solid #ccc;
    /* Bordes horizontales */
    padding: 1px;
    text-align: center;
  }

  .tabla-corporativa th {
    background-color: #f2f2f2;
    border-top: 1px solid #ccc;
    /* Borde superior para la fila de encabezado */
    border-bottom: 2px solid #ccc;
    /* Borde inferior más grueso */
    font-weight: bold;
  }

  .tabla-corporativa tr:hover {
    background-color: rgba(0, 0, 0, 0.05);
    color: black;
  }

  #tabla-pedidose {
    width: 700px;
    margin-left: 50px;
    margin-right: auto;

  }

  #tabla-disponibles {
    width: 80%;
    margin-left: 50px;
    margin-right: auto;
  }



  .preloader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.8);
    /* Fondo transparente */
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
  }

  .spinner {
    border: 8px solid #f3f3f3;
    border-top: 8px solid #3498db;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    animation: spin 1s linear infinite;
  }

  @keyframes spin {
    0% {
      transform: rotate(0deg);
    }

    100% {
      transform: rotate(360deg);
    }
  }
  .custom-swal .swal2-popup {
  font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
  font-size: 16px;
  max-width: 600px;
  border-radius: 10px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.custom-swal .swal2-title {
  color: #333;
  font-weight: bold;
}

.custom-swal .swal2-content {
  color: #555;
}

.custom-swal .swal2-input {
  border: 1px solid #ddd;
  padding: 10px;
}

.custom-swal .swal2-button {
  background-color: #3085d6;
  color: white;
  border: 0;
  border-radius: 5px;
  padding: 10px 20px;
}

.custom-swal .swal2-cancel {
  background-color: #aaa;
}

.custom-swal .swal2-confirm {
  background-color: #28a745; /* Verde para confirmar */
}

.custom-swal #dashboardButton {
  background-color: #e74c3c; /* Rojo */
  margin-top: 10px;
  padding: 10px;
}
.select-ellipsis {
  width: 250px;           /* O el ancho que quieras */
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">


<!--INICIO del cont principal-->
<div class="container">
  <h1>Route Respaldos Chile</h1>
</div>
<!-- Preloader superpuesto -->
<div class="preloader">
  <div class="spinner"></div>
</div>

<div class="container-fluid"
  style="padding:50px; text-align: center; overflow: auto;  white-space: nowrap; margin:0 auto; background-color: #F5F5F5;">
  <?php
  include ("bd/conexion.php");
  $objeto1 = new Conexion();
  $conexion = $objeto1->Conectar();


  $consulta = $conexion->prepare("SELECT * from rutas where tipo >= 0");
  $consulta->execute();



  $cadena = "<label>Rutas Disponibles</label><br>
           <select class='form-select' id='rutas' name='rutas' style=' margin:0 auto; '>
             <option value='-1'>Seleccionar una ruta</option>";

  $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);

  foreach ($resultados as $ver) {
    $fecha = $ver['fecha'];
    $idruta = $ver['id'];

    if ($ver['fecha'] == "VENDIDOS EN FABRICA") {
      // No hacer nada
    } else {
      $fecha = fechaCastellano($fecha);
    }

    $sql2 = "SELECT comuna FROM pedido_detalle WHERE ruta_asignada = :idruta GROUP BY comuna";
    $stmt2 = $conexion->prepare($sql2);
    $stmt2->bindParam(':idruta', $idruta, PDO::PARAM_INT);
    $stmt2->execute();
    $resultados2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    $comuna = "";

    foreach ($resultados2 as $ver2) {
      $comuna .= ', ' . $ver2['comuna'];
    }

    if ($ver["tipo"] == "3") {
      $cadena .= '<option style="background-color:#E4FEE6;" value=' . $ver['id'] . '>' . 'Productos de Stock </option>';
    } else if ($ver["tipo"] == "1") {
      $cadena .= '<option style="background-color:#E4FEE6;" value=' . $ver['id'] . '>' . 'Sala de ventas </option>';
    } else {
      if (isset($_GET['rutas']) && $ver['id'] == $_GET['rutas']) {
        // Establecer la opción seleccionada
        $cadena .= '<option value=' . $ver['id'] . ' selected>' . $ver['id'] . ' - ' . $fecha . ' ' . $comuna . '</option>';
      } else {
        // Opción normal
        $cadena .= '<option value=' . $ver['id'] . '>' . $ver['id'] . ' - ' . $fecha . ' ' . $comuna . '</option>';
      }
    }
  }

  echo $cadena . "</select><br>";


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




  $confirmacion = "";


  ?>
  <div id="container" style="color:#0076AD;">
    <span style="font-weight: bold;">Fecha de ruta:</span> <span style="color:black;" id="fecha"></span>
    <span style="font-weight: bold; margin-left:20px">Despachador Asignado:</span> <span style="color:black;"
      id="despachador"></span>
    <span style="font-weight: bold; margin-left:20px">Cantidad de productos:</span> <span style="color:black;"
      id="cantidad"></span>
  </div>

  <hr class="my-4">
  <?php echo "<div  style=' margin-bottom: 10px;'>
<a href='editar_ordenruta_pruebas.php?id=" . $_GET['rutas'] . "'' class='btn btn-success' style='color:white; background-color:#00D136;border-color:#00D136;'>ORGANIZAR RUTA <span class='bi bi-geo-alt icono-ruta'></span>
</a></div>"; ?>
  <!-- Agrega un div con un id para mostrar los resultados -->


  <div id="tabla-pedidose" style="background-color: #D1FFFF"></div>
  <hr class="my-4">

  <script>
  $(document).ready(function() {
    $('#rutas').select2({
      width: '200px',        // puedes usar '%', 'px' o 'resolve'
      dropdownAutoWidth: true,
      allowClear: true
    });
  });
</script>


  <!-- Agrega el siguiente código de JavaScript para enviar la solicitud Ajax y procesar los resultados -->
  <script>




    function getParameterByName(name) {
      name = name.replace(/[\[\]]/g, "\\$&");
      var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(window.location.href);
      if (!results) return null;
      if (!results[2]) return '';
      return decodeURIComponent(results[2].replace(/\+/g, " "));
    }


    // CARGAR PEDIDOS EN RUTA.
    pedidos_enruta();



    function pedidos_enruta() {
      $('.preloader').show();

      // Obtener el valor seleccionado del option select
      var filtro = getParameterByName('rutas');

      // Enviar la solicitud Ajax
      $.ajax({
        url: 'rutinas/rutinas_ruta.php',
        type: 'POST',
        data: { rutas: filtro, opcion: "consultar_ruta" },
        dataType: 'json',
        success: function (datos) {
          $('.preloader').hide();

          // Muestra el contenido
          $('.container-fluid').show();


          for (var i = 0; i < datos.length; i++) {
            var fila = datos[i];
            fecha_ruta = fila['fecha_ruta'];
            despachador = fila['despachador'];

          }



          // Procesar los resultados y mostrarlos en la tabla
          var tabla = '<table id="tabla1" class="tabla-corporativa" style="margin-bottom: 30px; text-align:center;">';
          tabla += '<thead><tr><th>Cant</th><th>ID</th><th>RUT Cliente</th><th>Modelo</th><th>Tamano</th><th>Tipo de Tela</th><th>Color</th><th>Dirección de Entrega<th>Telefono</th><th>Instagram</th></th><th>Estado del Pedido</th><th>Confirmación</th><th>Acciones</th><th>Notificar</th></tr></thead><tbody>';
          contador = 0;
          for (var i = 0; i < datos.length; i++) {
            contador += 1;
            var fila = datos[i];
            var estadodelpedido = fila['estadopedido'];
            if (estadodelpedido == "2" || estadodelpedido == "3" || estadodelpedido == "4" || estadodelpedido == "5") {
              var estado = "<span class='btn btn-outline-info btn-sm '>En Fabricacion</span>";
            } else if (estadodelpedido == "6") {
              var estado = "<span class='btn btn-outline-success btn-sm '>Pedido Listo</span>";

            } else if (estadodelpedido == "8") {
              var estado = "<span class='btn btn-outline-warning btn-sm '>En Despacho</span>";
            }
            else {
              var estado = fila['estadopedido'];
            }
            if (fila['confirma'] == 1) {
              var confirmacion = "<span class='btn btn-outline-info btn-sm '>Confirmado</span>";
            } else {
              var confirmacion = "<span class='btn btn-outline-danger btn-sm '>Pendiente</span>";
            }

            /*  $pedido .= "-".$filas['modelo']." ".$filas['plazas']." ".$filas['tipotela']." ".$filas['color']." ".$filas['alturabase']."%0A"; */
            var num_orden = fila['num_orden'];
            var pedido = ""; // declaración de la variable fuera de la función AJAX
            var total = "";



            var direccion = "";
            var fecha = "";

            var editar = '<button class="btn btn-primary btn-sm btnEditar">Editar</button>';

            mensaje_whatsapp = "";



            var fecha = fila['fecha_ruta']; // Fecha en formato "YYYY-MM-DD"
            // Convertir la fecha a objeto Date
            var fechaConvertida = new Date(fecha + 'T00:00:00'); // Convertir la fecha a objeto Date

            // Obtener el día de la semana en mayúscula
            var diaSemana = fechaConvertida.toLocaleDateString('es-CL', { weekday: 'long' });
            diaSemana = diaSemana.charAt(0).toUpperCase() + diaSemana.slice(1);

            // Obtener el día del mes
            var diaMes = fechaConvertida.getDate();

            // Obtener el mes en mayúscula
            var mes = fechaConvertida.toLocaleDateString('es-ES', { month: 'long' });
            mes = mes.charAt(0).toUpperCase() + mes.slice(1);

            // Obtener el año
            var anio = fechaConvertida.getFullYear();

            // Concatenar el resultado final
            var fecha_formateada = diaSemana + ' ' + diaMes + ' de ' + mes + ' ' + anio;





            // <span  class='notificar_img"+num_orden+"' style='cursor:pointer;'><img onclick='notificar("+num_orden+");' src='img/whatsapp.png' width='25px'></span> 
            tabla += "<tr><td>" + contador + "</td><td>" + fila['id'] + "</td><td style='width:30px'>" + fila['rut_cliente'] + "</td><td>" + fila['modelo'] + "</td><td>" + fila['tamano'] + "</td><td>" + fila['tipotela'] + "</td><td>" + fila['color'] + " " + fila['alturabase'] + "</td><td>" + fila['comuna'] + "</td><td>" + fila['telefono'] + "</td><td style='width:30px'>" + fila['instagram'] + "</td><td>" + estado + "</td></td><td>" + confirmacion + "</td><td>" + editar + "<button class='btn btn-danger btn-sm -btn' onclick='eliminar(this)'>Borrar de Ruta</button><button class='btn btn-info btn-sm -btn' onclick='reprogramar(this)'>Reprogramar</button></td><td>";

            var whatsappText = "Hola " + fila['nombre'] + "👋!\n\n";
            whatsappText += "Entregaremos tu pedido este \n*" + fecha_formateada + "* 🚚\n";
            whatsappText += "----------------------------------------------\n\n";
            whatsappText += "📦 *Detalles del pedido:*\n";
            whatsappText += fila['pedido_completo'].replace(/%0A/g, '\n') + "\n\n";
            whatsappText += "🔗 Necesitamos que revises y nos confirmes que puedes recibir tu pedido ingresando en el siguiente enlace:\n";
            whatsappText += "👉 https://respaldoschile.cl/cliente_confirma?r=" + fila['num_orden'] + "-25-2024-aB\n\n";
            whatsappText += "En el enlace encontrarás toda la información de tu pedido y metodo de pago.\n\n";
            whatsappText += "*Importante: El producto debe estar pagado para que nuestro despachador se retire del domicilio.*\n\n";
            whatsappText += "*El horario de entrega se informará mediante un SMS al momento de salir a reparto.*";

            var whatsappLink = "https://api.whatsapp.com/send/?phone=+56" + fila['telefono'] + "&text=" + encodeURIComponent(whatsappText);


            tabla += "<a href='" + whatsappLink + "' class='btn btn-success' target='_blank' style='height:30px; line-height:15px; font-size:12px;'>Notificar Whatsapp</a></td></tr>";
          }
          tabla += '</tbody></table>';
          $('#despachador').html(despachador);


          $('#fecha').html(fecha_ruta);
          $('#cantidad').html(contador);


          $('#tabla-pedidose').html(tabla);



        },
        error: function () {
          alert('Error al obtener los datos');
        }
      });

    }

    function notificar(num_orden) {
      $.ajax({
        type: 'POST',
        url: 'rutinas/enviar_whatsapp.php',
        data: {
          num_orden: num_orden,

        },
        success: function (response) {

          console.log(response); // Imprimir la respuesta del servidor en la consola
          var naves = document.querySelectorAll(".notificar_img" + num_orden);
          for (var i = 0; i < naves.length; i++) {
            naves[i].textContent = 'Notificado';
          }

        },
        error: function (xhr, status, error) {
          console.error(xhr); // Imprimir el error en la consola
        }
      });
    }


  </script>

  <h1>PEDIDOS DISPONIBLES PARA AGREGAR A RUTA</h1>




  <!-- Agrega este código en el lugar donde quieres que aparezca la tabla -->
  <div id="tabla-disponibles">

    <script>

      // Obtener el valor seleccionado del option select
      var filtro = getParameterByName('rutas');


      pedidos_disponibles();



      function pedidos_disponibles() {

        // Enviar la solicitud Ajax
        $.ajax({
          url: 'rutinas/rutinas_ruta.php',
          type: 'POST',
          data: { rutas: filtro, opcion: "consultar_disponibles" },
          dataType: 'json',
          success: function (datos) {
            // Procesar los resultados y mostrarlos en la tabla
            var tabla = '<table id="tabla2" class="tabla-corporativa" style="margin-bottom: 30px;">';
            tabla += '<thead><tr><th>Cant</th><th>ID</th><th>RUT Cliente</th><th>Modelo</th><th>Plazas</th><th>Tipo de Tela</th><th>Color</th><th>Dirección de Entrega<th>Telefono</th><th>Instagram</th></th><th>Estado del Pedido</th><th>Confirmación</th><th>Acciones</th></tr></thead><tbody>';
            contador = 0;
            for (var i = 0; i < datos.length; i++) {
              contador += 1;
              var fila = datos[i];
              var estadodelpedido = fila['estadopedido'];
              if (estadodelpedido == "2" || estadodelpedido == "3" || estadodelpedido == "4" || estadodelpedido == "5") {
                var estado = "<span class='btn btn-outline-info btn-sm '>En Fabricacion</span>";
              } else if (estadodelpedido == "6") {
                var estado = "<span class='btn btn-outline-success btn-sm '>Pedido Listo</span>";
              } else {
                var estado = fila['estadopedido'];
              }
              if (fila['confirma'] == 1) {
                var confirmacion = "<span class='btn btn-info btn-sm -btn'>Confirmado</span>";
              } else {
                var confirmacion = "<span class='btn btn-danger btn-sm -btn'>Pendiente</span>";
              }
              tabla += "<tr><td>" + contador + "</td><td>" + fila['id'] + "</td><td style='width:30px'>" + fila['rut_cliente'] + "</td><td>" + fila['modelo'] + "</td><td>" + fila['tamano'] + "</td><td>" + fila['tipotela'] + "</td><td>" + fila['color'] + " " + fila['alturabase'] + "</td><td>" + fila['comuna'] + "</td><td>" + fila['telefono'] + "</td><td style='width:30px'>" + fila['instagram'] + "</td><td>" + estado + "</td></td><td>" + confirmacion + "</td><td><button class='btn btn-success btn-sm -btn' onclick='agregar(this)'>Agregar a ruta</button></tr>";
            }
            tabla += '</tbody></table>';
            $('#tabla-disponibles').html(tabla);
          },
          error: function () {
            alert('Error al obtener los datos');
          }
        });

      }

    </script>


  </div>






</div>
<div>
  <?php include ("modal_editarpedido.php"); ?>


  </iv>


  <script type="text/javascript">
    // Inicializar DataTables
    // Función para actualizar la tabla 1 según el valor seleccionado en el option select
    function actualizarTabla1() {
      var filtro = document.getElementById("rutas").value;
      var url = "asignacion_ruta.php?rutas=" + encodeURIComponent(filtro);
      window.location.href = url;
    }

    // Event listener para el cambio de valor del option select
    document.getElementById("rutas").addEventListener("change", actualizarTabla1);


    /* $(document).ready(function(){
    $('#tabla1').DataTable({
        "paging": false,
      createdRow: function(row, data) {
        
        // Buscar la fila en la misma tabla
        var tabla = $('#tabla1').DataTable();
        var fila = tabla.rows().eq(0).filter(function(idx) {
          return tabla.cell(idx, 0).data() === data[0]; // Comparar el campo de la fila
        });
    
        // Si se encontró más de una fila coincidente, agregar una clase CSS personalizada
        if (fila.length > 1) {
          $(row).addClass('fila-coincidente');
          $(tabla.row(fila[0]).node()).addClass('fila-coincidente');
        }
      }
    });
    }); */

    $('#tabla2').DataTable({
      "paging": false,
      createdRow: function (row, data) {
        // Buscar la fila en la misma tabla
        var tabla = $('#tabla2').DataTable();
        var fila = tabla.rows().eq(1).filter(function (idx) {
          return tabla.cell(idx, 0).data() === data[0]; // Comparar el campo de la fila
        });

        // Si se encontró más de una fila coincidente, agregar una clase CSS personalizada
        if (fila.length > 1) {
          $(row).addClass('fila-coincidente');
          $(tabla.row(fila[0]).node()).addClass('fila-coincidente');
        }
      }
    });




    // Función para traspasar filas
    function agregar(button) {
      // ELIMINAR LA TABLA 1 DEL DOM 


      var rutaId = getParameterByName('rutas');

      var tr = $(button).closest('tr').clone(); // Clonar la fila
      $(button).closest('tr').remove(); // Eliminar la fila original

      /*            // Buscar la fila coincidente en la misma tabla
                  var tabla = $('#tabla1').DataTable();
                  var filaCoincidente = tabla.rows().eq(1).filter(function(idx) {
                    return tabla.cell(idx, 1).data() === tr.find('td:eq(1)').text(); // Comparar el campo de la fila
                  });


                  // Si se encontró una fila coincidente, agregar la fila clonada debajo de la coincidente
                  if (filaCoincidente.length > 0) {
                    $(tabla.row(filaCoincidente).node()).after(tr);
                  } else {
                    // Si no se encontró ninguna fila coincidente, agregar la fila clonada al final de la tabla
                    $('#tabla1 tbody').append(tr);
                  }


*/
      $(tr).find('button').text('Borrar de ruta'); // Cambiar el texto del botón
      $(tr).find('button').attr('onclick', 'eliminar(this)'); // Cambiar el onclick del botón
      $(tr).find('button').addClass('btn btn-danger');

      // Agregar color momentáneo y animación a la fila clonada
      $(tr).css('background-color', '#ffffcc');
      $(tr).hide().fadeIn(500);
      setTimeout(function () {
        $(tr).css('background-color', '');
      }, 1000); // Cambiar el color de fondo después de 1 segundo




      $.ajax({
        type: 'POST',
        url: 'rutinas/rutinas_ruta.php',
        data: {
          opcion: "agregar",
          id: tr.find('td:eq(1)').text(),
          ruta: rutaId,

        },
        success: function (response) {
          pedidos_enruta();
          console.log(response); // Imprimir la respuesta del servidor en la consola

        },
        error: function (xhr, status, error) {
          console.error(xhr); // Imprimir el error en la consola
        }
      });
    }






    function eliminar(button) {
      var tr = $(button).closest('tr').clone(); // Clonar la fila
      $(button).closest('tr').fadeOut(400, function () { // Animación de desvanecimiento
        $(this).remove(); // Eliminar la fila original después de la animación
      });

      /*
        // Buscar la fila coincidente en la misma tabla
        var tabla = $('#tabla2').DataTable();
        var filaCoincidente = tabla.rows().eq(1).filter(function(idx) {
          return tabla.cell(idx, 1).data() === tr.find('td:eq(1)').text(); // Comparar el campo de la fila
        });
      
        if (filaCoincidente.length > 0) {
          // Si se encontró una fila coincidente, insertar la fila clonada debajo de la coincidente
          var nodoCoincidente = tabla.row(filaCoincidente).node();
          $(nodoCoincidente).after(tr);
        } else {
          // Si no se encontró una fila coincidente, agregar la fila clonada al final de la tabla
          $('#tabla2 tbody').append(tr);
        }
      
        // Animación de resaltado suave en la fila agregada
        $(tr).addClass('fila-agregada');
        setTimeout(function() {
          $(tr).removeClass('fila-agregada');
        }, 1500);
      */
      $(tr).find('button').text('Agregar a Ruta'); // Cambiar el texto del botón
      $(tr).find('button').attr('onclick', 'agregar(this)'); // Cambiar el onclick del botón
      $(tr).find('button').addClass('btn btn-success');
      $.ajax({
        type: 'POST',
        url: 'rutinas/rutinas_ruta.php',
        data: {
          opcion: "eliminar",
          id: tr.find('td:eq(1)').text(),


        },
        success: function (response) {
          pedidos_disponibles();
          console.log(response); // Imprimir la respuesta del servidor en la consola
        },
        error: function (xhr, status, error) {
          console.error(xhr); // Imprimir el error en la consola
        }
      });
    }

    function reprogramar(button) {
  var tr = $(button).closest('tr').clone();
  $(button).closest('tr').fadeOut(400, function () {
    $(this).remove();
  });

  $(tr).find('button').text('Agregar a Ruta');
  $(tr).find('button').attr('onclick', 'agregar(this)');
  $(tr).find('button').addClass('btn btn-success');

  Swal.fire({
    title: 'Información de Reprogramación',
    html: `
    <select id="motivoReprogramacion" class="swal2-input">
      <option value="">Seleccione un motivo</option>
      <option value="no_recibir">📅 Cliente no puede recibir</option>
      <option value="no_terminado">⚙️ Producto no terminado</option>
      <option value="con_falla">🛠️ Producto con falla</option>
      <option value="cancelar">❌ Cancelar producto</option>
    </select>
    <div id="reemitirDiv" style="display:none;">
      <label class="swal2-checkbox" style="display: flex; align-items: center;">
        <input type="checkbox" id="reemitir">
        <span style="margin-left: 5px;">🔄 Reemitir producto</span>
      </label>
    </div>`,
    focusConfirm: false,
    customClass: 'custom-swal',

    preConfirm: () => {
      return {
        motivo: document.getElementById('motivoReprogramacion').value,
        reemitir: document.getElementById('reemitir').checked
      };
    },
    didOpen: () => {
  document.getElementById('motivoReprogramacion').addEventListener('change', function() {
    var motivo = this.value;
    var reemitirDiv = document.getElementById('reemitirDiv');

    // Muestra o oculta el checkbox para reemitir producto según el motivo seleccionado
    if (motivo === 'con_falla') {
      reemitirDiv.style.display = 'block';
      handleProductIssue({ motivo: motivo }); // Llama a la función para manejar la falla del producto
    } else {
      reemitirDiv.style.display = 'none';
    }
    if (motivo === 'cancelar') {
      // Llamamos a la función que maneja la cancelación del producto
      handleCancelProduct();
    }

    // Llama a fetchRutasDisponibles solo si el motivo requiere seleccionar una nueva ruta
    if (['no_recibir', 'no_terminado'].includes(motivo)) {
      fetchRutasDisponibles(motivo);
    }
  });
},
    showCancelButton: true,
    showConfirmButton: false, // Oculta el botón de confirmar

    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      // Puedes agregar aquí un AJAX POST con los resultados si es necesario
    }
  });
}

function fetchRutasDisponibles() {
  $.ajax({
    url: 'rutinas/rutinas_ruta.php',
    type: 'POST',
    data: { opcion: 'ver_rutas' },
    dataType: 'json',
    success: function(datos) {
      var hoy = new Date();
      var mesActual = hoy.getMonth();
      var anoActual = hoy.getFullYear();
      var selectContent = '<option value="">Seleccione una fecha</option>'; // Incluimos una opción predeterminada

      datos.forEach(function(fila) {
        if (fila.id_ruta !== "0") {
          var fecha = new Date(fila.fecha + 'T00:00:00');
          if (fecha.getMonth() === mesActual && fecha.getFullYear() === anoActual) {
            var fechaFinal = fecha.toLocaleDateString('es-CL', {
              weekday: 'long',
              day: 'numeric',
              month: 'long',
              year: 'numeric'
            });
            fechaFinal = fechaFinal.charAt(0).toUpperCase() + fechaFinal.slice(1);
            selectContent += `<option value="${fila.fecha}">${fechaFinal}</option>`;
          }
        }
      });
      Swal.fire({
  title: 'Seleccione una fecha disponible o deje en Dashboard',
  html: `
    <select id="fechaDisponible" class="swal2-input">
      ${selectContent}
    </select>
    <button id="dashboardButton" class="swal2-confirm swal2-styled">      Dejar en Dashboard
    </button>`,
  focusConfirm: false,
  customClass: 'custom-swal',

  showCancelButton: true,
  cancelButtonText: 'Cancelar',
  showConfirmButton: false,
  didOpen: () => {
    document.getElementById('dashboardButton').addEventListener('click', () => {
      Swal.close();
      console.log('Dejado en Dashboard');
      // Aquí puedes llamar a una función que maneje la acción de dejar el pedido en el dashboard
    });
  },
  customClass: {
    popup: 'custom-swal'
  }
});
    }
  });
}

// Función centralizada para manejar el remate de productos defectuosos
function handleDefectiveProduct(detail) {
  console.log('Producto enviado a remate con detalle:', detail);
  // Lógica para registrar el producto defectuoso en la base de datos
  Swal.fire({
    title: 'Producto Asignado a Remate',
    text: 'El producto ha sido asignado al stock de remate.',
    icon: 'success',
    confirmButtonText: 'Ok'
  });
}

function requestProductDefectDetails(callback) {
  Swal.fire({
    title: 'Detalles del Defecto',
    input: 'textarea',
    inputLabel: 'Describa el defecto del producto',
    inputPlaceholder: 'Escribe aquí los detalles del defecto...',
    showCancelButton: true,
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Confirmar y proceder',
    inputValidator: (value) => {
      if (!value) {
        return 'Debe escribir algún detalle sobre el defecto!';
      }
    }
  }).then((result) => {
    if (result.isConfirmed) {
      callback(result.value);
    }
  });
}

function handleProductIssue(options) {
  Swal.fire({
    title: 'Gestión de Producto con Falla',
    text: 'El producto presenta una falla. Describa el defecto para proceder con las opciones.',
    input: 'textarea',
    inputPlaceholder: 'Escribe aquí los detalles del defecto...',
    showCancelButton: true,
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Continuar',
    inputValidator: (value) => {
      if (!value) {
        return 'Debe escribir algún detalle sobre el defecto!';
      }
    }
  }).then((result) => {
    if (result.isConfirmed && result.value) {
      Swal.close();
      presentProductOptions(result.value, options);
    }
  });
}

function presentProductOptions(defectDetail, options) {
  Swal.fire({
    title: 'Opciones de Manejo del Producto',
    html: `
      <p>Detalle del defecto registrado: ${defectDetail}</p>
      <button id="auctionButton" class="swal2-confirm swal2-styled">Enviar a Stock para Remate</button>
      <button id="reissueButton" class="swal2-confirm swal2-styled">Reemitir para Próxima Entrega</button>
    `,
    showCancelButton: true,
    cancelButtonText: 'Cancelar',
    showConfirmButton: false,
    didOpen: () => {
      document.getElementById('auctionButton').addEventListener('click', () => {
        Swal.close();
        handleDefectiveProduct(defectDetail);
      });
      document.getElementById('reissueButton').addEventListener('click', () => {
        Swal.close();
        reissueProductForNextDelivery(options, defectDetail);
      });
    },
    customClass: {
      popup: 'custom-swal'
    }
  });
}

function reissueProductForNextDelivery(options, detail) {
  console.log('Detalle del defecto registrado:', detail);
  console.log('Producto reemitido para próxima entrega');
  // Lógica para programar la reemisión del producto con detalles del defecto
  Swal.fire({
    title: 'Producto Reemitido',
    text: 'Un nuevo producto será enviado en la próxima entrega.',
    icon: 'info',
    confirmButtonText: 'Ok'
  });
}

function handleCancelProduct() {
  Swal.fire({
    title: 'Confirmar Acción para Producto Cancelado',
    text: '¿Está el producto en perfecto estado para dejarlo en stock disponible para venta?',
    icon: 'question',
    showCancelButton: true,
    cancelButtonText: 'No',
    confirmButtonText: 'Sí'
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire({
        title: 'Producto en Stock',
        text: 'El producto está en perfecto estado y ha sido dejado en stock.',
        icon: 'success',
        confirmButtonText: 'Ok'
      });
      // Aquí se agregaría lógica para marcar el producto como disponible en el inventario
    } else {
      requestProductDefectDetails(handleDefectiveProduct); // Reutilizamos la función para solicitar detalles del defecto
    }
  });
}






  </script>

  <!--FIN del cont principal-->

  <?php require_once "vistas/parte_inferior.php" ?>