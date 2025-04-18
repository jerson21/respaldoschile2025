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
<div class="container">
    <h1>Clientes Respaldos Chile</h1>
</div>

 <div class="" style="padding: 1rem; text-align: center;max-width: 300px; " >

<!--    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap5.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.dataTables.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/searchbuilder/1.1.0/css/searchBuilder.dataTables.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
 <link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
   <link href="https://cdn.datatables.net/select/1.3.3/css/select.dataTables.min.css" rel="stylesheet">
   <link href="https://cdn.datatables.net/datetime/1.1.0/css/dataTables.dateTime.min.css" rel="stylesheet">
   <link href="libs/Editor-2.0.4/css/editor.dataTables.min.css" rel="stylesheet">-->
<!-- Referencia a los estilos CSS de DataTables -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/searchbuilder/1.1.0/css/searchBuilder.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.3.3/css/select.dataTables.min.css">

<!-- Referencia a jQuery -->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>

<!-- Referencia a los scripts de DataTables -->
<script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/rowreorder/1.2.8/js/dataTables.rowReorder.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/searchbuilder/1.1.0/js/dataTables.searchBuilder.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>




<div class="container">
  <table id="example" class="display cell-border">
    <thead>
      <tr>
        <th>Nº</th>
        <th>Rut</th>
        <th>Nombre</th>
        <th>Teléfono</th>
        <th>Correo</th>
        
        <th>Instagram</th>
        <th>Eliminar</th>
        <th>Agregar Pedido</th>
        <th>Ver</th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <th>Nº</th>
        <th>Rut</th>
        <th>Nombre</th>
        <th>Teléfono</th>
        <th>Correo</th>
        
        <th>Instagram</th>
        <th>Eliminar</th>
        <th>Agregar Pedido</th>
         <th>Ver</th>
      </tr>
    </tfoot>
  </table>
</div>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/rowreorder/1.2.8/js/dataTables.rowReorder.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/searchbuilder/1.1.0/js/dataTables.searchBuilder.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>

<script type="text/javascript">
  $(document).ready(function() {
    var tabla_usuarios = $('#example').DataTable({
      pageLength: 10,
      dom: 'Bfrtip',
      buttons: [
        {
          extend: 'excel',
          text: 'Exportar a Excel'
        },
        {
          extend: 'pdf',
          text: 'Generar PDF'
        }
      ],
      language: {
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
      ajax: {
        url: "getclientes.php",
        type: "post",
        dataType: "json"
      },
      columns: [
        { data: "num" },
        { data: "rut" },
        { data: "nombre" },
        { data: "telefono" },
        { data: "correo" },        
        { data: "instagram" },
        {
          data: null,
          className: "dt-center",
          defaultContent: '<i class="fa fa-pencil"/>',
          orderable: false
        },
        {
          data: null,
          className: "dt-center",
          defaultContent: '<i class="fa fa-plus"/>',
          orderable: false
        }
        ,
        {
          data: null,
          className: "dt-center",
          defaultContent: '<i class="fa fa-plus"/>',
          orderable: false
        }
      ],
      columnDefs: [
        {
          targets: 7,
          orderable: false,
          render: function(data, type, row, meta) {
            return '<a title="Ver Ordenes" href="ver_ordenes_cliente.php?rut=' + row.rut + '"><img src="img/add.png" width="40" alt="Ver Ordenes" /></a>';
          }
        }
      ],
      initComplete: function() {
        var table = this;

        // Agregar filas hijas al hacer clic en el icono "Agregar Pedido"
        $('#example tbody').on('click', 'td:nth-child(9)', function() {
          var tr = $(this).closest('tr');
          var row = table.row(tr);

          if (row.child.isShown()) {
            // La fila hija ya está visible, ocultarla
            row.child.hide();
            tr.removeClass('shown');
          } else {
            // Obtener las direcciones del cliente desde la API y mostrarlas como fila hija
            $.ajax({
              url: "getdirecciones.php",
              type: "post",
              data: { rut: row.data().rut },
              dataType: "json",
              success: function(response) {
                var direccionesHtml = '<table class="child-table">';
                for (var i = 0; i < response.direcciones.length; i++) {
                  direccionesHtml += '<tr><td>' + response.direcciones[i] + '</td></tr>';
                }
                direccionesHtml += '</table>';

                // Mostrar la fila hija con las direcciones
                row.child(direccionesHtml).show();
                tr.addClass('shown');
              },
              error: function(xhr, status, error) {
                console.log(error);
              }
            });
          }
        });
      }
    });
  });
</script>




<!--FIN del cont principal-->

<?php require_once "vistas/parte_inferior.php"?>