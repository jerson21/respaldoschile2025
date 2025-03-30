<?php

?>
<div id="loader" style="display: none;">Cargando...</div>
<table id="data-table" style="display: none;">
  <thead>
    <tr>
      <th>Fecha</th>
      <th>ID</th>
      <th>RUT</th>
      <th>Nombre</th>
      <th>Banco</th>
      <th>Número</th>
      <th>Monto</th>
      <th>Detalle</th>
    </tr>
  </thead>
  <tbody>
    <!-- Los datos se llenarán aquí -->
  </tbody>
</table>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
  $.ajax({
    url: 'https://z21jpv2xb0.execute-api.sa-east-1.amazonaws.com/default/nuevafuncionbanc',
    type: 'POST',
    contentType: 'application/json',
    data: JSON.stringify({
      clave: 'valor', // Asegúrate de reemplazar esto con tus datos reales
    }),
    dataType: 'json',
    beforeSend: function() {
      $('#loader').show();
    },
    success: function(response) {
      console.log('Datos recibidos:', response);
      var data = response.data; // Acceder al array de datos
      var tbody = $('#data-table tbody');
      tbody.empty(); // Limpia el cuerpo de la tabla antes de llenarlo
      
      data.forEach(function(row) {
        var tr = '<tr>';
        row.forEach(function(cell) {
          tr += '<td>' + cell + '</td>';
        });
        tr += '</tr>';
        tbody.append(tr);
      });
      
      $('#data-table').show(); // Mostrar la tabla después de llenarla
    },
    error: function(xhr, status, error) {
      console.error('Error:', error);
      // Aquí manejas el error
    },
    complete: function() {
      $('#loader').hide(); // Asegúrate de ocultar el loader independientemente del resultado
    }
  });
});
</script>