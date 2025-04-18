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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejemplo DataTables con Detalles</title>
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/staterestore/1.3.0/css/stateRestore.dataTables.min.css"> -->
    <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.7.0.js"></script>

    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/staterestore/1.3.0/js/dataTables.stateRestore.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <!-- jQuery primero, luego Popper.js, luego Bootstrap JS -->

    <script>
        $(document).ready(function () {
            // Mostrar el overlay de carga
            $('#loading-overlay').show();

            // Aquí puedes hacer la llamada AJAX o cualquier otra operación asíncrona
            // Por simplicidad, utilizaremos un setTimeout para simular una operación de carga
            setTimeout(function () {
                // Suponiendo que la carga ha finalizado, ocultar el overlay
                $('#loading-overlay').hide();
            }, 3000); // Simula un tiempo de carga de 3 segundos
        });
    </script>


</head>

<body>
    <?php require_once "vistas/parte_superior.php" ?>

    <style type="text/css">
        .pointer {
            cursor: pointer;
        }

        .btn-circle {
            font-size: 0.7rem;
            height: 30px;
            width: 30px;
            padding: 5px;
            border-radius: 50%;
            line-height: 12px;
        }

        .btn-margin-right {
            margin-right: 5px;
            /* Ajusta según necesites */
        }

        .table-condensed-custom {
            width: 100%;
            font-size: 0.7rem;
            padding: 1px;
        }

        .bold {
            font-weight: bold;
        }

        .btn-estado {
            font-size: 0.8rem;
            max-height: 1.5rem;
            line-height: 12px;
        }

        /* Clases adicionales para manejar casos específicos, como animaciones */
        .btn-parpadea {
            animation: parpadeo 1s infinite;
        }

        @keyframes parpadeo {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }

            100% {
                opacity: 1;
            }
        }

        .tabless>:not(caption)>*>* {
            padding: 0.5rem 0.5rem;
            color: var(--bs-table-color-state, var(--bs-table-color-type, var(--bs-table-color)));

            border-bottom-width: var(--bs-border-width);
            box-shadow: inset 0 0 0 9999px var(--bs-table-bg-state, var(--bs-table-bg-type, var(--bs-table-accent-bg)));
        }

        #example .fila-pagada {
            background-color: #C9FFCE;
            color: #000;
        }

        #example .fila-abonada {
            background-color: #FFEDC9;
            color: #000;
        }


        .btn-and-progress {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            position: relative;
            padding: 0.375rem 0.75rem;
            /* Ajusta el padding al deseado */
            font-size: 0.8rem;
            line-height: 1.5;
            border-radius: 0.25rem;
            /* Ajusta el radio del borde como en los botones de Bootstrap */
            color: #fff;
            /* Color del texto */
            background-color: #17a2b8;
            /* Color de fondo del botón, ajusta según el tipo de botón */
            border: 1px solid transparent;
            /* Borde del botón */
        }

        .progress-container {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            /* Altura de la barra de carga */
            overflow: hidden;
        }

        .progress-bar {
            width: 100%;
            height: 100%;
            background-color: #fff;
            /* Color de la barra de carga, contraste con el botón */
            animation: progress-animation 2s infinite linear;
        }

        .letra-chica {
            font-size: 11px;
            color: grey;
        }

        @keyframes progress-animation {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }

        .fas.fa-palette {
            color: red;
            /* Color gris, ajusta según necesites */
        }

        .fas.fa-gem {
            color: #17a2b8;
            /* Color azul, ajusta según necesites */
        }
    </style>
    <div style="margin:0 auto;width:400px; margin-bottom: 50px;">
        <form action="" method="GET">
            <?php
            include_once 'bd/conexion.php';
            error_reporting(0);
            $objeto1 = new Conexion();
            $conexion = $objeto1->Conectar();

            $consulta = "SELECT *  from rutas ";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);




            $cadena = "<div style='display: flex; align-items: center; gap: 10px; '>
                <select class='form-select form-select-s'  id='ruta' name='ruta'>
                <option value='-1'>Seleccionar una ruta</option>";
            foreach ($data as $ver) {
                $fecha = $ver['fecha'];
                $idruta = $ver['id'];
                $fecha = fechaCastellano($fecha);



                $consulta2 = "SELECT comuna from pedido_detalle where ruta_asignada = $idruta group by comuna";
                $resultado = $conexion->prepare($consulta2);
                $resultado->execute();
                $data2 = $resultado->fetchAll(PDO::FETCH_ASSOC);


                $comuna = "";

                foreach ($data2 as $ver2) {
                    $comuna .= ', ' . strtoupper($ver2['comuna']);
                }

                if ($ver['id'] == $_GET['ruta']) {
                    $cadena = $cadena . '<option selected="selected" value=' . $ver['id'] . '>' . $ver['id'] . ' - ' . $fecha . '</option>';
                } else {
                    $cadena = $cadena . '<option value=' . $ver['id'] . '>' . $ver['id'] . ' - ' . $fecha . '</option>';
                }

            }
            echo $cadena . "</select> ";
            ?>

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

            $currentRouteId = isset($_GET['ruta']) ? $_GET['ruta'] : (count($data) > 0 ? $data[0]['id'] : -1);


            ?>


            <input class="btn btn-primary" type="submit" value="Consultar">

        </form>

    </div>


    </div>
    <div class="container">

        <div class="d-flex justify-content-center" style="margin-bottom: 15px;">
            <div class="btn-group" role="group" aria-label="Basic example">
                <a href="?ruta=<?php echo max($currentRouteId - 1, 1); ?>" class="btn btn-secondary">RUTA ANTERIOR</a>
                <a href="?ruta=<?php echo $currentRouteId + 1; ?>" class="btn btn-secondary">RUTA SIGUIENTE</a>
                <a href="validar_pagos2024.php" class="btn btn-secondary">VOLVER A PRINCIPAL</a>
            </div>
        </div>
        <div>
            <button id="btnToggleAll" class="btn btn-warning btn-sm">Expandir/Colapsar Todos</button>
        </div>

        <table id="example" class="tabless table-striped table-bordered table-condensed"
            style="width:100%; font-size:0.8rem; " style="width:100%">
            <thead>
                <tr>
                    <th></th>
                    <th>Orden</th>
                    <th>Rut Cliente</th>
                    <th>Nombre</th>
                    <th>Direccion</th>

                    <th style="width:120px">Comuna</th>
                    <th>Telefono</th>
                    <th>Precio - Pagado</th>
                    <th>Forma Pago</th>
                    <th width="140px">Acciones</th>
                </tr>
            </thead>
        </table>
    </div>
    <script type="text/javascript" class="init">
        $(document).ready(function () {
            var ruta = new URLSearchParams(window.location.search).get('ruta');

            var table = $('#example').DataTable({

                "ajax": {
                    "url": "data/obtener_sinpago.php", // URL del script PHP que obtiene los datos
                    "type": "POST", // Método HTTP para la solicitud
                    "data": function (d) {
                        d.ruta = ruta; // Agrega aquí tu variable
                    }
                },
                "paging": false,
                "columns": [
                    {
                        "className": 'dt-control',
                        "orderable": false,
                        "data": null,
                        "defaultContent": '',

                        "render": function () {
                            return '<i class="fa fa-plus-square pointer"  aria-hidden="true"></i>'; // O cualquier ícono que prefieras para expandir
                        },
                        width: "15px"
                    },
                    {
                        "data": "pedido_cliente.num_orden", "render": function (data, type, row) {
                            return '<strong>' + data + '</strong>';
                        }
                    },
                    { "data": "pedido_cliente.rut_cliente" },
                    { "data": "pedido_cliente.nombre_cliente" },
                    {
                        "data": null,

                        "render": function (data, type, row) {
                            // Combina los campos "numero" y "comuna"
                            return row.pedido_cliente.direccion + ' ' + row.pedido_cliente.numero;
                        }
                    },

                    { "data": "pedido_cliente.comuna" },
                    { "data": "pedido_cliente.telefono" },

                    {
                        "data": "pedido_cliente.total_pagado",
                        "render": function (data, type, row) {
                            // Verifica si el total pagado es igual al total precio
                            if (parseFloat(data) === parseFloat(row.pedido_cliente.total_precio)) {
                                // Si son iguales, devuelve el valor de total pagado junto con el icono de verificación
                                return '<span class="letra-chica">' + row.pedido_cliente.total_precio + '</span> - ' + data + ' <i class="fas fa-check-circle"></i>';
                            } else if (parseFloat(data) > 0) {
                                // Si son iguales, devuelve el valor de total pagado junto con el icono de verificación
                                return '<span class="letra-chica">' + row.pedido_cliente.total_precio + '</span> - ' + data + ' <i class="fas fas fa-exclamation-triangle"></i>';
                            } else {
                                // Si no son iguales, devuelve solo el valor de total pagado sin el icono de verificación
                                return '<span class="letra-chica">' + row.pedido_cliente.total_precio + '</span> - 0';
                            }
                        }
                    },// DEBE IR TOTAL PAGADO
                    { "data": "pedido_cliente.mododepago" },
                    {
                        "render": function (data, type, full, meta) {
                            return '<button type="button" class="btn btn-success  btn-sm btnEditarOrden"  style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;" >Ingresar Pagos</button>';
                        },
                    },

                    // Agrega más columnas según necesites
                ],
                "order": [[1, 'asc']],
                "drawCallback": colorearFilas

            });

            var detallesExpandidos = false;

            function colorearFilas() {
                var table = $('#example').DataTable();

                // Recorre todas las filas de la tabla
                table.rows().every(function (rowIdx, tableLoop, rowLoop) {
                    var data = this.data();

                    if (data.pedido_cliente.total_pagado > 0) {
                        //  console.log("aqui hay valores iguales");
                        // Si son iguales, cambia el color de fondo de la fila
                        $(this.node()).attr('class', 'fila-abonada');
                    }

                    // Compara el valor de total_pagado con total_precio
                    if (data.pedido_cliente.total_pagado === data.pedido_cliente.total_precio) {
                        //  console.log("aqui hay valores iguales");
                        // Si son iguales, cambia el color de fondo de la fila
                        $(this.node()).attr('class', 'fila-pagada');
                    }




                });
            }



            $('#btnToggleAll').on('click', function () {
                // Iterar sobre todas las filas de la tabla
                table.rows().every(function () {
                    var row = this;
                    if (!detallesExpandidos) {
                        // Si los detalles no están expandidos, expandir
                        if (!row.child.isShown()) {
                            row.child(format(row.data())).show();
                            $(row.node()).addClass('shown');
                        }
                    } else {
                        // Si los detalles están expandidos, colapsar
                        if (row.child.isShown()) {
                            row.child.hide();
                            $(row.node()).removeClass('shown');
                        }
                    }
                });

                // Invertir el estado de expansión
                detallesExpandidos = !detallesExpandidos;
            });



            $('#example tbody').on('click', 'td.dt-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row(tr);

                if (row.child.isShown()) {
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    row.child(format(row.data())).show();
                    tr.addClass('shown');
                }
            });

            function format(d) {
                // `d` es el objeto de datos original para la fila
                var html = '<table id="hola" name="hola"  class="table table-striped table-bordered table-condensed" style="width:100%; font-size:0.8rem; padding: 1px;">' +
                    '<thead style="font-size:0.7rem;">' +
                    '<tr>' +

                    '<th width="15px">ID</th>' +
                    '<th width="200px">Modelo</th>' +
                    '<th width="100px">Tamaño</th>' +
                    '<th width="90px">Material</th>' +
                    '<th width="90px">Color</th>' +
                    '<th width="60px">Alt Base</th>' +
                    '<th width="60px">Detalles</th>' +
                    // Agrega más títulos de columnas de detalles según necesites
                    '<th width="250px">Comentarios</th>' +
                    '<th width="150px">Estado</th>' +
                    '<th></th>' +
                    '</tr>' +
                    '</thead>' +
                    '<tbody>' +
                    '<tr>';

                // Generar una columna para cada detalle
                $.each(d.detalles, function (key, value) {

                    var tipo_boton = '';
                    switch (value.tipo_boton) {
                        case "":
                            tipo_boton = "";
                            break;
                        case "B Color":
                            tipo_boton = "<i class='fas fa-palette' title='Botones de Colores'></i>";
                            break;
                        case "B D":
                            tipo_boton = "<i class='fas fa-gem' title='Botón Diamante'></i>";
                            break;
                    }

                    var anclaje = '';
                    switch (value.anclaje) {
                        case "no":
                            anclaje = ""; // No se muestra nada
                            break;
                        case "si":
                            // Usa el icono de ancla para representar "sí" tiene anclaje
                            anclaje = "<i class='fas fa-anchor' title='Con Anclaje'></i>";
                            break;
                        case "patas":
                            // Usa el icono de barras paralelas (fas fa-bars) para simbolizar "patas"
                            anclaje = "<i class='fa-solid fa-grip-lines-vertical' title='Patas de madera'></i>";
                            break;
                    }


                    var estadoBoton = ''; // Inicializar la variable para el botón de estado
                    // Aquí iría tu lógica para determinar qué botón mostrar basado en value.estadopedido

                    switch (value.estadopedido) {
                        case "0":
                            estadoBoton = "<button class='btn-group btn btn-warning btn-estado'>No Aceptado</button>";
                            break;
                        case "1":
                            estadoBoton = "<button class='btn btn-secondary btn-estado btnEditarestado2'>Aceptado</button>";
                            break;
                        case "2":
                            estadoBoton = "<button class='btn btn-warning btn-estado btnEditarestado2 btn-parpadea'>Por Fabricar</button>";
                            break;
                        case "5":
                            estadoBoton = `
    <div class="btn-and-progress btn btn-info btn-estado btnEditarestado2 btn-parpadea">Fabricando <div class="progress-container"><div class="progress-bar"></div></div></div>
    `;
                            break;
                        case "6":
                            estadoBoton = "<button class='btn btn-info btn-estado btnEditarestado2'>Producto Listo</button>";
                            break;
                        case "8":
                            estadoBoton = "<button class='btn btn-dark btn-estado btnEditarestado2'>En despacho</button>";
                            break;
                        case "9":
                            estadoBoton = "<button class='btn btn-success btn-estado btnEditarestado2'>Entregado</button>";
                            break;

                        case "19": // Casos 7 y 19 comparten el mismo botón
                            estadoBoton = "<button class='btn btn-warning btn-estado btnEditarestado2'>En Carga</button>";
                            break;
                        default:
                            estadoBoton = "<button class='btn btn-info btn-estado'>Estado Desconocido</button>";
                    }


                    html += '<tr>' +

                        '<td style="font-weight:bold;">' + value.id + '</td>' +
                        '<td>' + value.modelo + '</td>' +
                        '<td>' + value.tamano + '</td>' +
                        '<td>' + value.material + '</td>' +
                        '<td>' + value.color + '</td>' +
                        '<td>' + value.alturabase + '</td>' +
                        '<td>' + tipo_boton + ' ' + anclaje + '</td>' +

                        // Agrega más columnas de detalles según necesites


                        '<td>' + value.comentarios + '</td>' +
                        '<td>' + estadoBoton +
                        '<td>' +
                        '<div class="d-flex justify-content-start">' +
                        '<a href="cambio_prod.php?id=' + value.id + '" title="Reemitir">' +
                        '<button type="button" class="btn btn-danger btn-circle btn-margin-right">' +
                        '<i class="fas fa-redo"></i>' +
                        '</button>' +
                        '</a>' +
                        '<button type="button" class="btn btn-warning btn-circle btn-margin-right btnEditarProd" title="Editar">' +
                        '<i class="fas fa-edit"></i>' +
                        '</button>' +
                        '<button type="button" class="btn btn-secondary btn-circle btnBorrarProd" title="Eliminar">' +
                        '<i class="fas fa-trash"></i>' +
                        '</button>' +
                        '</div>' +
                        '</td>';
                });

                html += '</tr>' +
                    '</tbody></table>';
                return html;
            }
        });


    </script>


    <!--Modal para CRUD Editar estado de compra-->
    <div class="modal fade" id="modalCRUD" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Estado de la Compra</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="editarestado">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="id" class="form-label">Código:</label>
                            <input type="text" class="form-control" id="id" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado:</label>
                            <select name="estado" id="estado" class="form-select">
                                <option value="" disabled selected>Selecciona Estado</option>
                                <option value="1">Aceptar Compra</option>
                                <option value="2">Enviar a Fabricación</option>
                                <option value="6">Producto Listo</option>
                                <option value="19">Reagendar</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-lg"></i> Cancelar
                        </button>
                        <button type="submit" id="btnGuardar" class="btn btn-dark">
                            <i class="bi bi-save"></i> Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <?php include("modal_validarpagos.php"); ?>
    <?php include("modal_editarpedido.php"); ?>
    <!--FIN del cont principal-->
    <?php require_once "vistas/parte_inferior.php" ?>