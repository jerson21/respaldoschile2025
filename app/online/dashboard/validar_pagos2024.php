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
<?php require_once "vistas/parte_superior.php"; 
include "bd/conexion.php"; ?>

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
</style>


<!--INICIO del cont principal-->
<div class="container py-2">
    <div class="row">
        <div class="col-lg-12">
            <div class="text-center mb-2">
                <h1 class="fw-bold">Gestión de Pagos</h1>
                <p class="lead">Administracion y validación de pagos.</p>
            </div>
        </div>
    </div>
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

    .btn {
        font-size: 12px;
        margin: 2px;
    }
</style>

<div class="container-fluid"
    style="padding-left: 50px; padding-right: 50px; text-align: center; overflow: auto;  white-space: nowrap; margin:0 auto; background-color: #F5F5F5;">

    <div id="tabla-rutas"> </div>

</div>

<script type="text/javascript">
    $(document).ready(function () {
        // Realiza la solicitud AJAX para obtener los datos de las rutas

        // Inicializa DataTable en la tabla



        $.ajax({
            url: 'rutinas/rutinas_ruta.php',
            type: 'POST',
            data: { opcion: 'ver_rutas' },
            dataType: 'json',
            success: function (datos) {
                // Procesar los resultados y mostrarlos en la tabla
                var tabla = '<table id="tabla1" class="tabla-corporativa" style="margin-bottom: 30px;">';
                tabla += '<thead><tr><th>ID</th><th>Sector</th><th>Cantidad de Productos</th><th>Despachador Asignado</th><th>Fecha</th><th>Status</th><th>Acciones</th></tr></thead><tbody>';

                for (var i = 0; i < datos.length; i++) {

                    var fila = datos[i];
                    var id = fila['id_ruta'];
                    var estado = fila['estado_ruta'];
                    if (estado === "0") {
                        var status = '<span class="btn btn-outline-danger btn-sm -btn">NO INICIADA</span>'
                    }
                    if (estado === "1") {
                        var status = '<span class="btn btn-outline-info btn-sm -btn">INICIADA</span>'
                    }
                    if (estado === "200") {
                        var status = '<span class="btn btn-outline-success btn-sm -btn">TERMINADA</span>'
                    }

                    var boton = '<button type="button" class="btn btn-success btn-sm ver-ruta" onclick="redirectToAsignacionRuta(' + id + ')">INGRESAR A RUTA<i class="bi bi-arrow-right-short ms-1"></i></button>';



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


                    tabla += "<tr><td>" + fila['id_ruta'] + "</td><td>" + fila['comuna'] + "</td><td>" + fila['cantidad_prod'] + "</td><td>" + fila['despachador'] + "</td><td>" + fechaFinal + "</td><td>" + status + "</td><td>" + boton + "</td></tr>";
                }

                tabla += '</tbody></table>';
                $('#tabla-rutas').html(tabla);
                $('#tabla1').DataTable({
                    order: [[0, 'desc']], // Ordenar por la primera columna en orden descendente
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
            error: function () {
                alert('Error al obtener los datos');
            }
        });

    });


    function redirectToAsignacionRuta(id) {
        window.location.href = 'validacion_pago.php?ruta=' + id;
    }



</script>

<!--FIN del cont principal-->

<?php require_once "vistas/parte_inferior.php" ?>