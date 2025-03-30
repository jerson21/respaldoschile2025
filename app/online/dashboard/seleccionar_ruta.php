<?php require_once "vistas/parte_superior.php";
include "bd/conexion.php";?>

<style type="text/css">.fila-par {
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
  border-radius: 10px; /* Bordes redondeados */
  background-color: #FFFFFF;
}

.tabla-corporativa th,
.tabla-corporativa td {
  border: 0; /* Quitar bordes entre celdas */
  border-bottom: 1px solid #ccc; /* Bordes horizontales */
  padding: 1px;
  text-align: center;
}

.tabla-corporativa th {
  background-color: #f2f2f2;
  border-top: 1px solid #ccc; /* Borde superior para la fila de encabezado */
  border-bottom: 2px solid #ccc; /* Borde inferior más grueso */
  font-weight: bold;
}

.tabla-corporativa tr:hover {
  background-color: rgba(0, 0, 0, 0.05);
  color:black;
} </style>


<!--INICIO del cont principal-->
<div class="container" >
    <h1>Rutas Respaldos Chile</h1>
</div>

<style type="text/css">
.badge-light-warning {
    color: var(--bs-warning);
    background-color: var(--bs-warning-light);
}
.badge {
    display: inline-flex;
    align-items: center;
}
.btn{
  font-size: 12px;
  margin: 2px;
}
</style>

<div class="container-fluid" style="padding: 50px; text-align: center; overflow: auto;  white-space: nowrap; margin:0 auto; background-color: #F5F5F5;">
 
 <div id="tabla-rutas"> </div>

</div>

<script type="text/javascript">
$(document).ready(function() {
  // Realiza la solicitud AJAX para obtener los datos de las rutas

   // Inicializa DataTable en la tabla



  $.ajax({
    url: 'rutinas/rutinas_ruta.php',
    type: 'POST',
    data: {  opcion: 'ver_rutas' },
    dataType: 'json',
    success: function(datos) {
      // Procesar los resultados y mostrarlos en la tabla
      var tabla = '<table id="tabla1" class="tabla-corporativa" style="margin-bottom: 30px;">';
      tabla += '<thead><tr><th>ID</th><th>Sector</th><th>Cantidad de Productos</th><th>Despachador Asignado</th><th>Fecha</th>            <th style="display:none;">Fecha ISO</th><th>Status</th><th>Acciones</th></tr></thead><tbody>';

  for (var i = 0; i < datos.length; i++) {

        var fila = datos[i];
        var id = fila['id_ruta'];
        var estado = fila['estado_ruta']; 
        if(estado === "0"){
           var status = '<span class="btn btn-outline-danger btn-sm -btn">NO INICIADA</span>'
        }
        if(estado === "1"){
           var status = '<span class="btn btn-outline-info btn-sm -btn">INICIADA</span>'
        }   
        if(estado === "200"){
           var status = '<span class="btn btn-outline-success btn-sm -btn">TERMINADA</span>'
        }    
    
var boton = '<button type="button" class="btn btn-success btn-sm ver-ruta" onclick="redirectToAsignacionRuta(' + id + ')">ASIGNAR PEDIDOS<i class="bi bi-arrow-right-short ms-1"></i></button>';

     
       
var fecha = fila['fecha']; // Fecha en formato "YYYY-MM-DD"
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
var fechaFinal = diaSemana + ' ' + diaMes + ' de ' + mes + ' ' + anio;

        
    tabla += "<tr><td>" +  fila['id_ruta'] + "</td><td>" +(fila['id_ruta'] === '33' ? 'Retiros y vendidos en Fabrica' : fila['comuna'])   + "</td><td>" + fila['cantidad_prod'] + "</td><td>" + fila['despachador'] + "</td><td>" + fechaFinal  + "</td><td style='display:none;'>" + fecha  + "</td><td>" + status + "</td><td>" + boton + "</td></tr>";
 }

  tabla += '</tbody></table>';
  $('#tabla-rutas').html(tabla);
  $('#tabla1').DataTable({
    order: [[5, 'desc']], // Ordenar por la primera columna en orden descendente
    iDisplayLength: 25, // Número de filas a mostrar por página
    language: {
        lengthMenu: "Mostrar _MENU_ Registros por página",
        zeroRecords: "No se encontraron resultados",
        info: "Mostrando página _PAGE_ de _PAGES_",
        infoEmpty: "No hay registros disponibles",
        infoFiltered: "(filtrado de _MAX_ registros totales)",
        search: "Buscar:",
        paginate: {
            first: "Primero",
            last: "Último",
            next: "Siguiente",
            previous: "Anterior"
        },
        processing: "Procesando...",
    }
});
     

},
error: function() {
  alert('Error al obtener los datos');
}
});

    });


  function redirectToAsignacionRuta(id) {
  window.location.href = 'asignacion_ruta.php?rutas=' + id;
}

    
   
</script>

<!--FIN del cont principal-->

<?php require_once "vistas/parte_inferior.php"?>