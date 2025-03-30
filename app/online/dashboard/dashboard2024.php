<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pedidos</title>
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/staterestore/1.3.0/css/stateRestore.dataTables.min.css"> -->



    <!-- jQuery primero, luego Popper.js, luego Bootstrap JS -->



    <style type="text/css">
        .pointer {
            cursor: pointer;
        }
    </style>

</head>

<body>
    <?php require_once "vistas/parte_superior.php" ?>


    <style type="text/css">
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

        /* Estilo general para reducir el tamaño de las filas de todas las tablas */
    </style>
    <div class="container">
        <h1>Modulo Pedidos Ingresados</h1>
        <button id="btnToggleAll" class="btn btn-warning btn-sm">Expandir/Colapsar Todos</button>
        <div><label>
                <input type="checkbox" id="alwaysExpandDetails" /> Mantener detalles siempre expandidos
            </label></div>


        <table id="example" class="table-striped table-bordered table-condensed" style="width:100%; font-size:0.8rem; ">
            <thead>
                <tr>
                    <th></th>
                    <th>Orden</th>
                    <th>Canal</th>
                    <th>Rut Cliente</th>
                    <th>Nombre</th>
                    <th>Direccion</th>

                    <th style="width:120px">Comuna</th>
                    <th>Telefono</th>
                    <th>Total Pagado</th>
                    <th>Forma Pago</th>
                    <th width="140px">Acciones</th>
                </tr>
            </thead>
        </table>
    </div>
    <script type="text/javascript" class="init">
        $(document).ready(function() {
            // Verifica el estado guardado en el almacenamiento local al cargar la página
            var detallesExpandidos = localStorage.getItem('detallesExpandidos') === 'true';
            $('#alwaysExpandDetails').prop('checked', detallesExpandidos);
            var table = $('#example').DataTable({
                iDisplayLength: 20,
                "ajax": {
                    "url": "data/extraer_ordenes.php",
                    "type": "POST", // Puedes cambiarlo a GET si prefieres
                    "data": function(d) {
                        // Aquí puedes agregar datos adicionales a la petición
                        // Por ejemplo, enviar una variable llamada 'miVariable' con el valor 'miValor'
                        d.modulo = "dashboard";
                    }
                },
                "columns": [{
                        "className": 'dt-control',
                        "orderable": false,
                        "data": null,
                        "defaultContent": '',
                        "render": function() {
                            return '<i class="fa fa-plus-square pointer"  aria-hidden="true"></i>'; // O cualquier ícono que prefieras para expandir
                        },
                        width: "15px"
                    },
                    {
                        "data": "num_orden",
    "render": function(data, type, row) {
        
        output = '<strong> ' + data + '</strong>';
        
        return output;
    }
                    },
                    
                    
                    
                    
                    {
                        "render": function(data, type, row) {
        if (row.orden_ext != "") {
            output = ' <i class="fas fa-shopping-cart" style="color:red;" title="Pedido Tienda"></i>';
            return output;
        }else{
            output = ' ';
            return output;
        }
                    }
                },
                    {
                        "data": "rut_cliente",
                        "render": function(data, type, row) {
                            // Asegúrate de que la URL y el ícono sean correctos
                            // El enlace engloba al rut y al ícono de Instagram
                            // El title del enlace mostrará el valor de Instagram al pasar el mouse por encima
                            return `<a href="http://localhost/respaldoschile/online/dashboard/ver_ordenes_cliente.php?rut=${row.rut}" target="_blank" title="${row.instagram}">${data} <i class="fa fa-instagram"></i></a>`;
                        }
                    },
                    {
                        "data": "nombre"
                    },
                    {
                        "data": null,

                        "render": function(data, type, row) {
                            // Combina los campos "numero" y "comuna"
                            return row.direccion + ' ' + row.numero;
                        }
                    },

                    {
                        "data": "comuna"
                    },
                    {
                        "data": "telefono"
                    },
                    {
                        "render": function(data, type, full, meta) {
                            return '-';
                        }
                    },
                    {
                        "data": "mododepago"
                    },
                    {
                        "render": function(data, type, full, meta) {
                            return '<button type="button" class="btn btn-secondary  btn-sm btnEditarOrden"  style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;" >Editar Orden</button>';
                        },
                    },

                    // Agrega más columnas según necesites
                ],
                "initComplete": function(settings, json) {
                    // Verifica y aplica el estado de los detalles expandidos
                    // después de que la DataTable se haya cargado completamente
                    toggleAllDetails(detallesExpandidos);
                },
                language: {
                    lengthMenu: "Mostrar _MENU_ registros",
                    zeroRecords: "No se encontraron resultados",
                    info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
                    infoFiltered: "(filtrado de un total de _MAX_ registros)",
                    sSearch: "Buscar:",
                    oPaginate: {
                        sFirst: "Primero",
                        sLast: "Último",
                        sNext: "Siguiente",
                        sPrevious: "Anterior",
                    },
                    sProcessing: "Procesando...",
                },
                "order": [
                    [1, 'desc']
                ]
            });




            // Aplica el estado de expansión basado en el almacenamiento local o el checkbox al cargar la página
            toggleAllDetails(detallesExpandidos);

            // Función para expandir o colapsar todos los detalles
            function toggleAllDetails(expand) {
                detallesExpandidos = expand;
                table.rows().every(function() {
                    var tr = $(this.node());
                    var row = table.row(tr);
                    if (expand && !row.child.isShown()) {
                        row.child(format(row.data())).show();
                        tr.addClass('shown');
                    } else if (!expand && row.child.isShown()) {
                        row.child.hide();
                        tr.removeClass('shown');
                    }
                });
            }

            // Evento del botón "Toggle All"
            $('#btnToggleAll').on('click', function() {
                detallesExpandidos = !detallesExpandidos; // Invertir el estado
                toggleAllDetails(detallesExpandidos); // Aplicar el cambio

            });

            // Evento del checkbox para mantener siempre expandidos los detalles
            $('#alwaysExpandDetails').change(function() {
                var isChecked = $(this).is(':checked');
                toggleAllDetails(isChecked);
                localStorage.setItem('detallesExpandidos', isChecked); // Actualiza el estado en el almacenamiento local
            });

            $('#example tbody').on('click', 'tr td.dt-control', function(event) {
    if ($('.modal.show').length === 0) {  // Verifica si hay algún modal abierto
        var tr = $(this).closest('tr');
        var row = table.row(tr);

        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
        } else {
            row.child(format(row.data())).show();
            tr.addClass('shown');
        }
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
                    '<th width="250px">Mensaje Interno</th>' +
                    '<th width="250px">Detalles Fabricacion</th>' +
                    '<th width="150px">Estado</th>' +
                    '<th></th>' +
                    '</tr>' +
                    '</thead>' +
                    '<tbody>' +
                    '<tr>';

                // Generar una columna para cada detalle
                $.each(d.detalles, function(key, value) {

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
                            estadoBoton = "<button class='btn-group btn btn-warning btn-estado btnEditarestado2'>No Aceptado</button>";
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
                            estadoBoton = "<button class='btn btn-success btn-estado btnEditarestado2'>Producto Listo</button>";
                            break;
                        case "7":
                        case "8": // Casos 7 y 19 comparten el mismo botón
                            estadoBoton = "<button class='btn btn-success btn-estado btnEditarestado2'>En Carga</button>";
                            break;
                            case "20": // Casos 7 y 19 comparten el mismo botón
                            estadoBoton = "<button class='btn btn-danger btn-estado btnEditarestado2'>Reemitido</button>";
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
                        '<td>' + value.detalles_fabricacion + '</td>' +
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
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
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
    <?php include("dashboard2024retiros.php"); ?>
    <?php include("modal_validarpagos.php"); ?>
    <?php include("modal_editarpedido.php"); ?>







    <!--FIN del cont principal-->
    <?php require_once "vistas/parte_inferior.php" ?>