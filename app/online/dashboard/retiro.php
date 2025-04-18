<?php require_once "init.php" ?>
<?php require_once "vistas/parte_superior.php";


?>
 <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
 

        <style>
        /* Definir el ancho deseado para el botón */
        .small-btn {
            width: 200px;
           
        }
    </style>

<!--INICIO del cont principal-->
<div class="container">
    <h1>Buscar Pedido</h1>

    
        <!-- Campo de entrada (input) para el RUT -->
        <input type="text" name="rut" id="rut" value="" placeholder="Rut">
        <button class="form-control btn btn-primary small-btn" id="buscarBtn">Buscar</button>
    </div>



    <!-- Mostrar el resultado de la búsqueda -->
    <div class="container">
        <table id="resultado" class="display">
            <thead>
                <tr>
                    <th>Orden</th>
                    <th>Precio</th>
                    <th>Abono</th>
                    <th>Por Pagar</th>
                    <th>Modelo</th>
                    <th>Tamaño</th>
                    <th>Tipo Tela</th>
                    <th>Color</th>
                    <th>Altura Base</th>
                    <th>Estado</th>
                    <th>Tapicero</th>
                </tr>
            </thead>
            <tbody>
                <!-- Los datos se cargarán mediante DataTables -->
            </tbody>
        </table>
    </div>

    <!-- Script para buscar el último comprobante mediante AJAX -->
    <script>
        $(document).ready(function() {
            var dataTable = $("#resultado").DataTable({
                columns: [
                    { title: "Orden" },
                    { title: "Precio" },
                    { title: "Abono" },
                    { title: "Por Pagar" },
                    { title: "Modelo" },
                    { title: "Tamaño" },
                    { title: "Tipo Tela" },
                    { title: "Color" },
                    { title: "Altura Base" },
                    { title: "Estado" },
                    { title: "Tapicero" }
                ]
            });

            $("#buscarBtn").click(function() {
                var rut = $("#rut").val().trim();  // Obtener el valor del campo "rut"

                $.ajax({
                    type: "POST",
                    url: "bd/crud.php",
                    dataType: "json",
                    data: { opcion: 'buscar_pedidos', rut: rut },

                    success: function(response) {
                        console.log(response);

                        dataTable.clear().draw();

                        response.forEach(function(pedido) {
                            if(pedido.estadopedido < 6){        estado = "En Proceso"; }else{  estado = "Pedido Listo";  }
                            if(pedido.tapicero_id == 1){        tapicero = "Jaime"; }
                         else if(pedido.tapicero_id == 2){        tapicero = "Felipe"; }else{ tapicero = "NO ASIGNADO"; }
                           
                            dataTable.row.add([
                                pedido.num_orden,
                                pedido.precio,
                                pedido.abono,
                                (pedido.precio - pedido.abono),
                                pedido.modelo,
                                pedido.tamano,
                                pedido.tipotela,
                                pedido.color,
                                pedido.alturabase,
                                estado,
                                tapicero,
                                
                                
                            ]).draw();
                        });

                    },
                    error: function() {
                        $("#resultado").html("Error al buscar el último comprobante.");
                    }
                });
            });
        });
    </script>

<?php require_once "vistas/parte_inferior.php"; ?>