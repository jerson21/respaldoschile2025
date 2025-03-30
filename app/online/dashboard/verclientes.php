<?php require_once "vistas/parte_superior.php"?>

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