<!-- ESTO ESTA INCRUSTADO EN EL DASHBOARD GENERAL POR ENDE NO DEBE LLEVAR HTML -->
<div class="container">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css">


    <div class="toast-container d-flex justify-content-center align-items-center" style="position: fixed; top: 5%; left: 50%; transform: translate(-50%, -50%); min-height: 100px; z-index: 11">
  <div id="toastRetiro" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header" style="background-color: #D10000; color: white;">
      <i class="fas fa-exclamation-triangle text-warning"></i>
      <strong class="me-auto ms-2">Modulo Retiros</strong>
      <small  >justo ahora</small>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
     Hola! Tienes un pedido que retiran hoy.
    </div>
  </div>
</div>


    <h1>Modulo Pedidos con retiro</h1>
    <button id="btnToggleAlls" class="btn btn-warning btn-sm">Expandir/Colapsar Todos</button>

    <table id="tablapedidos_retir" class="table-striped table-bordered table-condensed" style="width:100%; font-size:0.8rem; ">
        <thead>
            <tr>
                <th></th>
                <th>Orden</th>
                <th>Canal</th>

                <th>Rut Cliente</th>
                <th>Nombre</th>

                <th>Telefono</th>
                <th>Total Pagado</th>
                <th>Forma Pago</th>
                <th>Fecha Retiro</th>
                <th width="140px">Acciones</th>
            </tr>
        </thead>
    </table>
</div>
 







<script type="text/javascript" >
  
        
        var tablapedidos_retir = $('#tablapedidos_retir').DataTable({

            iDisplayLength: 20,
            "ajax": {
                "url": "data/extraer_ordenes.php",
                "type": "POST", // Puedes cambiarlo a GET si prefieres
                "data": function(d) {
                    // Aquí puedes agregar datos adicionales a la petición
                    // Por ejemplo, enviar una variable llamada 'miVariable' con el valor 'miValor'
                    d.modulo = "dashboardretiro";
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
                        return '<strong>' + data + '</strong>';
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
                    "data": "rut_cliente"
                },
                {
                    "data": "nombre"
                },

                {
                    "data": "telefono"
                },
                {
                    "render": function(data, type, full, meta) {
                        return '-';
                    },
                },
                {
                    "data": "mododepago"
                },
                {
                    "data": "detalle_entrega"
                },
                {
                    "render": function(data, type, full, meta) {
                        return '<button type="button" class="btn btn-secondary  btn-sm btnEditarOrden"  style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;" >Editar Orden</button>';
                    },
                },

                // Agrega más columnas según necesites
            ],
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
                [1, 'asc']
            ],
            "rowCallback": function(row, data, index) {
                var fechaDeRetiro = new Date(data['detalle_entrega']);
                var fechaActual = new Date();
                fechaActual.setHours(0, 0, 0, 0);
                var manana = new Date(fechaActual);
                manana.setDate(manana.getDate() + 1);

                // Asegurarse de que los toasts no se muestren múltiples veces
                if (index === 0) { // Solo verifica en la primera fila para evitar múltiples toasts
                    if (fechaDeRetiro >= fechaActual && fechaDeRetiro < manana) {
                        var toastElement = document.getElementById('toastRetiro');
            var toast = new bootstrap.Toast(toastElement);
            toast.show();
                    } else if (fechaDeRetiro >= manana && fechaDeRetiro < new Date(manana.getTime() + 24 * 60 * 60 * 1000)) {
                        // Mostrar toast para retiros de mañana
                        $.toast({
                            heading: '<strong style="font-weight: bold;">Retiro Programado</strong>',
                            text: 'Tienes un pedido que retiran mañana!',
                            icon: 'info',
                            loader: true,
                            bgColor: '#008DF9',
                            loaderBg: '#9EC600',
                            position: 'top-center',
                            stack: false // Cambiado a false para evitar stacking si no es deseado
                        });
                    }
                }
            }

        });

        

        var detallesExpandidos = false;

        $('#btnToggleAlls').on('click', function() {
            // Iterar sobre todas las filas de la tabla
            tablapedidos_retir.rows().every(function() {
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

        $('#tablapedidos_retir tbody').on('click', 'td.dt-control', function() {
            var tr = $(this).closest('tr');
            var row = tablapedidos_retir.row(tr);

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