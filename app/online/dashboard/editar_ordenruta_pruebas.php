<?php require_once "vistas/parte_superior.php" ?>



<!-- Vendor CSS Files -->

<meta content="width=device-width, initial-scale=1.0" name="viewport">


<link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
<link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

<!-- Template Main CSS File -->
<link href="assets/css/style.css" rel="stylesheet">
<link
  href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
  rel="stylesheet">


<?php



$conn = mysqli_connect('localhost', 'cre61650_respaldos21', 'respaldos21/', 'cre61650_agenda');


$id_ruta = $_GET['id'];

$strsql = "SELECT * FROM rutas where id = $id_ruta";
$rs = mysqli_query($conn, $strsql);


while ($row = mysqli_fetch_array($rs)) {
  $fecha_ruta = $row['fecha'];
  $despachador = $row['despachador'];
  $estado = $row['estado'];
} ?>

<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">  -->
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

  .tablaArrastrable tbody tr {
    cursor: all-scroll !important;
  }
</style>

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





  .reordered {
    color: blue;
  }



  @media print {
    @page {
      size: landscape legal;

      size: 1008pt 612pt;
    }
  }

  @media print {

    .col-sm-1,
    .col-sm-2,
    .bold-column,
    h1 {
      display: none;
    }


  }

  .col-sm-2 {
    width: 30%;
  }

  .col-sm-1 {
    width: 35%;
  }

  .bold-column {
    font-weight: bold !important;
  }

  .preloader {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: rgba(255, 255, 255, 0.8);
    /* Fondo transparente */
    padding: 20px;
    border-radius: 10px;
    z-index: 9999;
  }

  /* Puedes agregar estilos adicionales al spinner según tus preferencias */
  .preloader::after {
    content: '';
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
</style>


<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap5.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" />
<link rel="stylesheet" type="text/css"
  href="https://cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.dataTables.min.css" />
<link rel="stylesheet" type="text/css"
  href="https://cdn.datatables.net/searchbuilder/1.1.0/css/searchBuilder.dataTables.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/select/1.3.3/css/select.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/datetime/1.1.0/css/dataTables.dateTime.min.css" rel="stylesheet">
<link href="libs/Editor-2.0.4/css/editor.dataTables.min.css" rel="stylesheet">

<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<!-- <script type="text/javascript"  src="https://cdn.datatables.net/1.10.25/js/dataTables.dataTables.min.js"></script> -->
<script type="text/javascript"
  src="https://cdn.datatables.net/rowreorder/1.2.8/js/dataTables.rowReorder.min.js"></script>
<script type="text/javascript"
  src="https://cdn.datatables.net/searchbuilder/1.1.0/js/dataTables.searchBuilder.min.js"></script>
<script type="text/javascript"
  src="https://editor.datatables.net/extensions/Editor/js/dataTables.editor.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>

<script type="text/javascript" language="javascript"
  src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script type="text/javascript" language="javascript"
  src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" language="javascript"
  src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript"
  src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript"
  src="https://cdn.datatables.net/buttons/1.5.3/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript"
  src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script type="text/javascript" language="javascript"
  src="https://cdn.datatables.net/rowgroup/1.1.3/js/dataTables.rowGroup.min.js"></script>



<!-- ======= Header ======= -->


<main id="main">

  <!-- ======= Breadcrumbs ======= -->


  <!-- ======= Portfolio Details Section ======= -->

  <div style="text-align: center;"> <span style="font-size: 30px;">ORDEN CRONOLOGICO DE RUTA </span>
    <h4>SE DEBE INICIAR RUTA Y ENVIAR A TEAM CIRCUIT</h4>
  </div>

  <div class="preloader" id="preloader">Asignando orden...</div>
  <script type="text/javascript">
    function asignarorden() {
      document.getElementById('preloader').style.display = 'block';

      var id_ruta = <?php echo $_GET['id']; ?>;
      $.ajax({
        url: "asignarordencronologico.php",
        type: "POST",
        data: {
          id: id_ruta
        },
        success: function (r) {
          setTimeout(function () {
            // Oculta el preloader después de la asignación de orden
            document.getElementById('preloader').style.display = 'none';

            // Puedes agregar aquí cualquier lógica adicional después de la asignación de orden si es necesario
          }, 2000);

        },
        error: function () {
          document.getElementById('preloader').style.display = 'none';

          alert("error asignando orden de ruta");

        }
      });
    }

    function iniciarruta() {
      var id_ruta = <?php echo $_GET['id']; ?>;
      $.ajax({
        url: "rutinas/iniciarruta.php",
        type: "POST",
        data: {
          id: id_ruta
        },
        success: function (r) {
          alert("Ruta Iniciada");
          location.reload();
        },
        error: function () {

          alert("error asignando orden de ruta");

        }
      });
    }

    function finalizarruta() {
      var id_ruta = <?php echo $_GET['id']; ?>;
      $.ajax({
        url: "rutinas/finalizarruta.php",
        type: "POST",
        data: {
          id: id_ruta
        },
        success: function (r) {
          alert("Ruta Finalizada")
          location.reload();

        },
        error: function () {

          alert("error asignando orden de ruta");

        }
      });
    }

    function imprimirFirmas() {
      var id_ruta = <?php echo $_GET['id']; ?>;
      $.ajax({
        url: "firmas/reporte.php",
        type: "POST",
        data: {
          id: id_ruta
        },
        success: function (r) {



        },
        error: function () {

          alert("error asignando orden de ruta");

        }
      });
    }
  </script>



  <div class="container-fluids" style="padding: 5px; text-align: center;">
    <div style="margin:0 auto; ">
      <form id="asignarorden" method="POST">

        <input type="submit" onclick="asignarorden()" class='btn btn-success btn-sm agregar-btn'
          value="Asignar Orden a ruta ">
        <?php if ($estado == 1) { ?>
          <input type="submit" onclick="finalizarruta()" class='btn btn-warning btn-sm agregar-btn'
            value="Finalizar Ruta">

        <?php } else { ?>
          <input type="submit" onclick="iniciarruta()" class='btn btn-info btn-sm agregar-btn' value="Iniciar Ruta">
        <?php } ?>
        <a href="firmas/reporte.php?id=<?php echo $_GET['id']; ?>" class='btn btn-success btn-sm agregar-btn'
          target="_blank">
          IMPRIMIR REPORTE
        </a>
        <button id="enviarBtns" class='btn btn-info btn-sm agregar-btn'>
    ENVIAR A TEAM CIRCUIT
</button>
<button id="obtenerOrdenBtn" class='btn btn-warning btn-sm'>
    OBTENER ORDEN
</button>
<script>
document.getElementById('enviarBtns').addEventListener('click', function(event) {
    event.preventDefault();  // Esto evita que el botón realice cualquier acción predeterminada, como enviar un formulario.
    const rutaId = "<?php echo $_GET['id']; ?>";  // Asegúrate de que el ID se está obteniendo correctamente.

    // Muestra SweetAlert para informar que el proceso ha comenzado
    Swal.fire({
        title: 'Enviando datos...',
        text: 'Por favor, espera mientras se procesa la solicitud.',
        icon: 'info',
        allowOutsideClick: false,
        showConfirmButton: false,
        willOpen: () => {
            Swal.showLoading();
        }
    });

    // Realiza la solicitud AJAX
    fetch('../../teamcircuit/pruebas_teamcircuit.php?opcion=enviar_ruta&id_ruta=' + rutaId, {
        method: 'GET'  // Puedes cambiar a POST si es necesario, y ajustar el backend.
    })
    .then(response => response.json())  // Asegúrate de que el servidor responde con JSON.
    .then(data => {
        Swal.close();  // Cierra el SweetAlert de carga.
        // Muestra un SweetAlert de éxito o error dependiendo de la respuesta
        if (data.success) {
          Swal.fire({
                title: 'Enviado!',
                html: 'Ruta enviada exitosamente.<br><br><strong>Instrucciones:<br></strong> Ordena la ruta en Circuit y luego vuelve aquí y presiona "Obtener Orden".',
                icon: 'success'
            });
        } else {
            Swal.fire(
                'Error!',
                'Hubo un problema al enviar los datos. ' + data.message,
                'error'
            );
        }
    })
    .catch(error => {
        Swal.fire(
            'Error!',
            'Hubo un error en la solicitud: ' + error.toString(),
            'error'
        );
    });
});
</script>

<script>document.getElementById('obtenerOrdenBtn').addEventListener('click', function(event) {
    event.preventDefault();  // Evita que el botón realice cualquier acción predeterminada.
    const rutaId = "<?php echo $_GET['id']; ?>";  // Asegúrate de que el ID se está obteniendo correctamente.

    // Muestra SweetAlert para informar que el proceso ha comenzado
    Swal.fire({
        title: 'Obteniendo Orden...',
        text: 'Por favor, espera mientras se procesa la solicitud.',
        icon: 'info',
        allowOutsideClick: false,
        showConfirmButton: false,
        willOpen: () => {
            Swal.showLoading();
        }
    });

    // Realiza la solicitud AJAX
    fetch('../../teamcircuit/pruebas_teamcircuit.php?opcion=consultar_position&id_ruta=' + rutaId, {
        method: 'GET'  // Ajusta a POST si es necesario según el backend.
    })
    .then(response => response.json())  // Asegúrate de que el servidor responde con JSON.
    .then(data => {
        Swal.close();  // Cierra el SweetAlert de carga.
        // Muestra un SweetAlert de éxito o error dependiendo de la respuesta
        if (data.success) {
            Swal.fire(
                '¡Completado!',
                'Orden obtenida exitosamente.',
                'success'
            );
            // Aquí es donde recargas el DataTable
            $('#example1').DataTable().ajax.reload(null, false);  // false indica que no resetea la paginación
        } else {
            Swal.fire(
                '¡Error!',
                'Hubo un problema al obtener los datos. ' + data.message,
                'error'
            );
        }
    })
    .catch(error => {
        Swal.close();
        Swal.fire(
            '¡Error!',
            'Hubo un error en la solicitud: ' + error.toString(),
            'error'
        );
    });
});
</script>

      </form>
    </div>
    <!-- <div id="result">
        Event result:
    </div> -->
    <table id="example1" class="tabla-corporativa">
      <thead>
        <tr>
          <th>Nº</th>
          <th>Orden</th>
          <th>ID</th>
          <th>Rut Cliente</th>

          <th>Modelo</th>
          <th>Tamano</th>
          <th>Color</th>


          <th>Direccion</th>

          <th>Telefono</th>
          <th>Lugar Venta</th>

          <th>Precio</th>
          <th>E</th>
          <th>Detalles</th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <th>Nº</th>
          <th>Orden</th>
          <th>ID</th>
          <th>Rut Cliente</th>

          <th>Modelo</th>
          <th>Tamano</th>
          <th>Color</th>


          <th>Direccion</th>

          <th>Telefono</th>
          <th>Lugar Venta</th>

          <th>Precio</th>
          <th>E</th>

          <th>Comentarios</th>
        </tr>
      </tfoot>
    </table>


    <script type="text/javascript">
      // use a global for the submit and return data rendering in the examples

      $(document).ready(function () {
        var idruta = <?php echo $_GET['id']; ?>;

        var tabla_usuarios = $('#example1').DataTable({
          iDisplayLength: 50,
          bAutoWidth: true,
          dom: 'Bfrtip',

          buttons: [

            {
              extend: 'print',
              text: 'Imprimir Ruta',

              exportOptions: {

                columns: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                title: ''
              },

              messageBottom: 'www.RespaldosChile.cl',
              customize: function (window) {
                $(window.document.body).children().eq(0).after('<div style="text-align:center; margin-top:0;"><img src="https://www.respaldoschile.cl/img/logorespaldos.png" width="150px"></div><div style="text-align:left;float:left;"> Numero de Ruta:<b> <?php echo $_GET['id']; ?> </b>  &nbsp;&nbsp; Despachador Asignado: <b><?php echo $despachador; ?></b> &nbsp;&nbsp; Fecha de ruta: <b> <?php echo $fecha_ruta; ?></b></div><div style="text-align:right;font-weight:bold;">Patas Cargadas: ______ &nbsp;Productos Cargados: ______</div>');
                var $table = $(window.document.body).find('table').first();
                $table.find('th:nth-child(11), td:nth-child(11)').css('font-weight', 'bold');
                var $table = $(window.document.body).find('table').first();
                $table.find('th:nth-child(5), td:nth-child(5)').css('font-weight', 'bold');


              },

            },


            {
              extend: 'excel',
              text: 'Exportar a excel'
            },
            {
              extend: 'pdf',
              text: 'Generar PDF'
            },




          ],
          columnDefs: [{
            targets: 10, // Columna 11 (índice 10)
            createdCell: function (td, cellData, rowData, row, col) {
              $(td).addClass('bold-column');
            }
          }],

          "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
              "sFirst": "Primero",
              "sLast": "Último",
              "sNext": "Siguiente",
              "sPrevious": "Anterior"
            }
          },

          "ajax": {
            url: "rutajson2_editarruta.php",
            type: "post",
            data: {
              "id": idruta,
              "opcion": "editar_orden"
            },
            "columns": [{
              "data": "orden"
            },
            {
              "data": "num_orden"
            },
            {
              "data": "id"
            },
            {
              "data": "rut_cliente"
            },
            {
              "data": "modelo"
            },
            {
              "data": "plazas"
            },
            {
              "data": "tipotela"
            },

            {
              "data": "alturabase"
            },
            {
              "data": "direccion"
            },

            {
              "data": "telefono"
            },
            {
              "data": "instagram"
            },
            {
              "data": "mododepago"
            },
            {
              "data": "precio"
            },
            {
              "data": "detalles_fabricacion"
            },


            {
              data: null,
              className: "dt-center editor-edit",
              defaultContent: '<i class="fa fa-pencil"/>',
              orderable: false
            },


            ]
          },
          select: true,

          rowReorder: {
            selector: "td:first-child",
            dataSrc: 0,
          },






          initComplete: function () {


            this.api().columns([3, 4, 5]).every(function () {
              var column = this;
              var select = $('<select><option value=""></option></select>')
                .appendTo($(column.footer()).empty())
                .on('change', function () {
                  var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val()
                  );

                  column
                    .search(val ? '^' + val + '$' : '', true, false)
                    .draw();
                });

              column.data().unique().sort().each(function (d, j) {
                select.append('<option value="' + d + '">' + d + '</option>')
              });
            })
          }

        });
        //tabla_usuarios.columns( [0] ).visible( false );

        tabla_usuarios.on("row-reorder", function (e, diff, edit) {
          var result = 'Reorder started on row: ' + edit.triggerRow.data()[0] + '<br>';

          for (var i = 0, ien = diff.length; i < ien; i++) {
            var rowData = tabla_usuarios.row(diff[i].node).data();

            result += rowData[2] + ' se actualizo a la posicion ' +
              diff[i].newData + ' (was ' + diff[i].oldData + ')<br>';
            var nuevoordenvar = diff[i].newData;
            actualizarorden();
          }

          function actualizarorden() {
            $.ajax({
              url: 'actualizarorden.php',

              type: "POST",
              data: {
                id: rowData[2],
                nuevoorden: nuevoordenvar
              },


              success: function (response) {
                if (response == 1) {
                  alert(_TOTAL_registros);

                }

              }
            })
          }



          //$('#result').html('Event result:<br>'+result);

          // Actualizamos en BD


        });


      });



      // GetUserList() ;

      // Obtener lista de usuarios
      function GetUserList() {
        return $.ajax({
          url: 'rutajson.php',
          type: 'GET',
          success: function (response) {
            const usuarios = JSON.parse(response);
            console.log(usuarios); //<-aqui hago un console para ver lo que devuelve
            usuarios.forEach(user => {
              tabla_usuarios.row.add({
                "id": user.id,
                "rut_cliente": user.rut_cliente,
                "modelo": user.modelo,
                "plazas": user.tamano,
                "tipotela": user.tipotela,
                "color": user.color,
                "alturabase": user.alturabase,
                "direccion": user.direccion,
                "telefono": user.telefono

              }).draw();
            })
          }
        });
      }
    </script>




  </div>





  <!-- Bootstrap core JavaScript-->

  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>



  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- código propio JS -->
  <script type="text/javascript" src="main.js"></script>





  </body>

  </html>