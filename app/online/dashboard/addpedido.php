<?php
session_start();
require_once "vistas/parte_superior.php" ?>

<style>
    .form-row {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;

    }

    .form-group {
        padding: 0 5px;
        margin-bottom: 20px;
    }

    .overlay-iframe {
        margin-top: 20px;
    }

    .btn-primary {
        margin-top: 10px;
        /* Ajusta según necesidad para alinear con el input de dirección */
    }

    /* Ajustes para mejorar la responsividad en dispositivos más pequeños */
    @media (max-width: 768px) {
        .form-row {
            flex-direction: column;
        }

        .form-group {
            padding: 0;
        }
    }

    .container2 {
        max-width: 1000px;
        padding-right: calc(var(--bs-gutter-x)* .5);
        padding-left: calc(var(--bs-gutter-x)* .5);
        margin-right: auto;
        margin-left: auto;
        padding: 25px;
        background-color: white;
        /* Contenedor blanco */
        border: 10px solid rgba(255, 255, 255, 0);
        /* Borde blanco transparente */
        box-sizing: border-box;
        /* incluir el borde en el tamaño total del contenedor */
        border-radius: 5px;
        /* redondea las esquinas */

    }

    .outer-border {
        max-width: 1000px;
        margin-right: auto;
        margin-left: auto;
        /* ancho del contenedor + el doble del ancho del borde */
        box-sizing: border-box;
        /* incluir el borde en el tamaño total del contenedor */

        /* alto del contenedor + el doble del ancho del borde */
        border: 10px solid rgba(255, 255, 255, 0.5);
        /* Borde blanco con transparencia */
        border-radius: 5px;
        /* redondea las esquinas */
        top: -10px;
        /* Mueve el contenedor hacia arriba para que el borde inferior esté alineado con el borde del contenedor */
        left: -10px;
        /* Mueve el contenedor hacia la izquierda para que el borde derecho esté alineado con el borde del contenedor */
        right: -25px;
        /* Mueve el contenedor hacia la derecha para que el borde izquierdo esté alineado con el borde del contenedor */
        bottom: -25px;
        margin-bottom: 15px;
    }

    #formular fieldset:not(:first-of-type) {
        display: none;
    }

    .pedido-agregado {
        display: flex;
        justify-content: flex-start;
        /* Alinea el contenido al inicio */
        align-items: flex-start;
        /* Alinea los items al inicio */
        border: 1px solid #e0e0e0;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 8px;
        background-color: #fff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        width: auto;
        /* Ajusta esto según necesites */
        transition: box-shadow 0.3s ease-in-out;
    }


    .pedido-precios {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .pedido-detalle h4,
    .pedido-detalle p,
    .pedido-precios .form-group {
        margin: 2px 0;
    }

    .pedido-detalle h4 {
        font-size: 1.1em;
        color: #333;
    }

    .pedido-detalle p,
    .form-group label {
        font-size: 0.9em;
        color: black;
    }

    .form-group {
        display: flex;
        /* Nuevo */
        align-items: center;
        /* Centra verticalmente el label y el input */
        gap: 10px;
        /* Espacio entre el label y el input */
        margin-bottom: 8px;
        /* Ajuste para el margen */
    }

    .pedido-precios .form-control {
        border-radius: 5px;
        border: 1px solid #ccc;
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
        height: 30px;
        /* Hace los inputs más pequeños */
        padding: 5px;
        font-size: 0.8em;
        transition: border-color 0.3s ease-in-out;
    }

    /* Ajuste adicional para reducir el ancho de los inputs y permitir más control */
    .pedido-precios .form-group {
        width: 80%;
        /* Reducir el ancho de los inputs del precio y envío */
    }

    /* Para no expandir el div a todo el ancho */
    .pedido-agregado {
        max-width: 80%;
        /* Ajusta este valor según prefieras */
    }

    .label {
        white-space: nowrap;
        /* Evita que la etiqueta se divida en líneas */
        overflow: hidden;
        /* Oculta el contenido que excede el ancho del elemento */
        text-overflow: ellipsis;
        /* Muestra puntos suspensivos si el texto es demasiado largo */
    }

    .form-control {
        flex-grow: 1;
        /* Permite que el input ocupe el espacio restante */
    }

    .cerrar-pedido {
        cursor: pointer;
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 5px;
        font-weight: bold;
        color: #333;
        /* Puedes añadir más estilos para hacerlo más atractivo o visible */
    }

    .pedido-agregado {
        position: relative;
        /* Necesario para posicionar absolutamente el botón de cierre */
        /* El resto de tus estilos */
    }

    .pedido-resumen {
        max-width: 400px;
        /* Ajusta esto según tus necesidades */
        margin: 0 auto;
        /* Centra el contenedor */
        padding: 20px;
        /* Espacio interior para que no esté pegado al borde */
        background-color: #f9f9f9;
        /* Fondo ligeramente gris para destacarlo, opcional */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        /* Sombra suave para darle profundidad, opcional */
        border-radius: 5px;
        /* Bordes redondeados, opcional */
    }

    .pedido-despacho,
    .pedido-total {
        margin-bottom: 15px;
        /* Espacio entre los inputs */
    }
</style>
<script>
    document.getElementById("content").style.background = " linear-gradient(135deg, #FFE6CC, #FFD9E5, #FFE5F0, #FFF2F7)";
</script>

<div class="outer-border">
    <div class="container2">
        <h1>Modulo Ingreso Pedidos</h1>


        <div class="progress">
            <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <br>


        <style>
            .input-group-custom {
                position: relative;
                display: flex;
                align-items: center;
                width: 100%;
            }

            .form-control.custom-input {
                padding-right: 30px;
                /* Espacio para los íconos */
            }

            .input-group-custom .fas {
                position: absolute;
                right: 10px;
                display: none;
                /* Ocultar inicialmente los íconos */
            }

            .input-incorrect {
                border: 2px solid red;
                /* O cualquier estilo que prefieras para indicar error */
            }
        </style>
        <form id="formular" novalidate method="post">
            <fieldset>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <div class="input-group-custom">
                            <input type="text" name="rut" id="rut" class="form-control custom-input" placeholder="Rut" onkeydown="noPuntoComa(event)" oninput="checkRut(this);" autocomplete="off" required>
                            <i class="fas fa-check" id="iconoCheck" style="color:green;"></i> <!-- Ícono de check -->
                            <i class="fas fa-times" id="iconoCross" style="color:red;"></i> <!-- Ícono de X -->
                        </div>
                        <!-- <p class="text-info esse" id="msgerror" style="color:red !important; padding: 0; font-size: 13px;"></p>
    <p class="text-info" style="padding: 0; font-size: 13px; margin-bottom:10px;" id="msgvalido"></p> -->
                    </div>

                    <div class="form-group col-md-4">
                        <input type="text" name="name" id="name" class="form-control custom-input" placeholder="Nombre" value="<?php echo isset($nombre) ? $nombre : ''; ?>" required>
                        <input type="hidden" name="clienteexisterut" id="clienteexisterut" value="">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <input type="email" class="form-control custom-input" name="email" id="email" placeholder="Correo" value="<?php echo isset($correo) ? $correo : ''; ?>">

                    </div>

                    <div class="form-group col-md-4">
                        <input type="text" name="telefono" id="telefono" class="form-control custom-input" placeholder="Telefono" value="<?php echo isset($telefono) ? $telefono : ''; ?>" required>
                    </div>
                </div>


                <div class="form-row">
                    <div class="form-group col-md-4">

                        <input type="text" class="form-control custom-input" name="instagram" id="instagram" placeholder="Instagram, sala de ventas" value="<?php echo isset($instagram); ?>" required>
                    </div>
                    <div class="form-group col-md-4">

                        <select id="mododepago" name="mododepago" class="form-select form-select  custom-input" aria-label="Modo de Pago" required>

                            <option value="transferencia">Transferencia</option>
                            <option value="efectivo">Efectivo</option>
                            <option value="debito">Debito </option>
                            <option value="credito">Credito</option>
                            <option value="pagado">Pagado</option>
                        </select>

                    </div>

                </div>
                <!-- SI ES RETIRO EN TIENDA SE SELECCIONA UN CHECKBOX Y SE DESPLIEGA LA FECHA DE RETIRO -->
                <div class="form-row" style="margin-top: 15px; ">

                    <div class="col-md-8">
                        <div class="form-group">

                            <div class="form-check" >
                                <input class="form-check-input" type="checkbox" id="retiro_tienda" name="retiro_tienda">
                                <label class="form-check-label" for="retiro_tienda">
                                    <i class="fas fa-store"></i> Retiro en tienda
                                </label>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6" id="detalleretiro" style="display: none;">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Fecha</span>
                            </div>




                            <input class="form-control form-control-solid ps-12 flatpickr-input active" id="detalle_entrega" name="detalle_entrega" type="text" placeholder="Seleccionar Fecha">

                        </div>
                    </div>

                </div>
                <script>
                    flatpickr('#detalle_entrega', {
                        enableTime: true,
                        minTime: "09:00",
                        maxTime: "18:00",
                        minDate: "today",
                        dateFormat: "Y-m-d H:i",

                        // Otions adicionales de configuración si las necesitas
                    });
                </script>
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/flatpickr.min.css">
                <script src="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/flatpickr.min.js"></script>

                <!-- FIN DE FORMULARIO RETIRO EN TIENDA -->
                <hr>

                <!-- DIV QUE CONTIENE EL MAPA Y DIRECCION, OCULTARLO SI ES RETIRO EN TIENDA -->
                <div id="direccionymapa">
                    <div class="form-row">
                        <!-- Columna para dirección, departamento, y columna del mapa -->
                        <div class="col-md-8">
                            <div class="form-row">
                                <!-- Dirección -->
                                <div class="form-group col-md-9">
                                    <style>
                                        .verificar_button {
                                            cursor: pointer;
                                            /* Cambia el cursor a pointer */
                                        }

                                        .verificar_button:hover i {
                                            color: green !important;
                                            /* Asegura que el color del icono cambie a verde al pasar el mouse */
                                        }
                                    </style>

                                    <div class="input-group">
                                        <input type="text" name="direccion" class="form-control custom-input" id="search_input" placeholder="Ingrese Dirección..." value="" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text" name="verificar_button" id="verificar_button"><i class="fas fa-check verificar_button"></i></span>

                                        </div>

                                        <input type="hidden" id="loc_lat" />
                                        <input type="hidden" id="loc_long" />
                                        <input type="hidden" name="street_name" id="street_name" />
                                        <input type="hidden" name="street_number" id="street_number" />
                                        <input type="hidden" name="comunas" id="comunas" />
                                        <input type="hidden" name="regiones" id="regiones" />
                                        <input type="hidden" name="latitude_view" id="latitude_view" />
                                        <input type="hidden" name="longitude_view" id="longitude_view" />


                                    </div>
                                    <div id="result" style="margin-top: 5px;"></div>
                                </div>
                                <!-- Departamento -->
                                <div class="form-group col-md-3">
                                    <input type="text" class="form-control custom-input" name="dpto" id="dpto" placeholder="Dpto/casa" value="<?php echo isset($dpto); ?>">
                                </div>
                            </div>

                            <!-- Información adicional para la entrega -->
                            <div class="form-group col-md-8">

                                <textarea class="form-control custom-input" name="referencia" style="background-color: 0;" rows="3" placeholder="Información adicional para la entrega."></textarea>
                            </div>
                            <div class="form-group col-md-5">
                                <input type="hidden" readonly class="form-control custom-input" name="vendedor" value="<?php echo ucfirst($_SESSION['nombre_user']); ?>">
                            </div>

                            <?php date_default_timezone_set('America/Santiago');
$DateAndTime = date('Y-m-d h:i:s a', time()); ?>
                            <div class="form-group col-md-5">
                                <input type="hidden" name="fecha_ingreso" class="form-control custom-input" value="<?php setlocale(LC_ALL, "es_ES");
                                                                                                                    echo $DateAndTime ; ?>" readonly>
                            </div>
                        </div>

                        <!-- Columna para el mapa -->
                        <div class="col-md-4">
                            <div class="form-group" style="position: relative;">
                                <div class="overlay-iframe" style="width: 100%; overflow: hidden; margin:0;">
                                    <iframe src="https://www.google.com/maps/d/u/0/embed?mid=1V08qNPJ-nQ8sdKtPSvEUY-fVPT0HrvE&ehbc=2E312F&iwloc=near" width="100%" height="300" style="border: none;"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <input type="button" name="data[password]" class="next btn btn-info" value="Siguiente" />





            </fieldset>


            <!-- SIGUIENTE SECCIÓN -->

            <fieldset>
                <!-- <h2> Paso 2: Agregar detalles personales</h2> -->

                <?php

                include_once '../bd/conexion.php';
                $objeto = new Conexion();
                $conexion = $objeto->Conectar();

                if (isset($_GET['num_orden'])) {
                    $num_orden = $_GET['num_orden'];

                    // Preparar la consulta con PDO
                    $strsql1 = "SELECT * FROM pedido p
                    INNER JOIN pedido_detalle d ON d.num_orden = p.num_orden
                    LEFT JOIN clientes c ON p.rut_cliente = c.rut   
                    WHERE p.num_orden = :num_orden"; // Usar marcadores de nombre en PDO
                    $stmt = $conexion->prepare($strsql1);
                    $stmt->bindParam(':num_orden', $num_orden, PDO::PARAM_INT); // Enlazar el parámetro
                    $stmt->execute();
                    $rowfila = $stmt->fetch(PDO::FETCH_ASSOC); // Obtener el resultado

                    if ($rowfila) {
                        echo "<div class='alert alert-success'>";
                        echo "<p style='margin-bottom:0;'>Ingresando un nuevo producto para la orden Nº: " . htmlspecialchars($num_orden) . " Cliente " . htmlspecialchars($rowfila['rut_cliente']) . "</p>";

                        // Repetir la consulta no es necesario, reutilizar el resultado anterior
                        do {
                            // Tu lógica para manejar los datos aquí...
                        } while ($row1 = $stmt->fetch(PDO::FETCH_ASSOC)); // Continuar obteniendo el resto de las filas
                        echo "</div>";
                    }

                    // Segunda consulta con PDO
                    $strsql = "SELECT * FROM pedido p
                    INNER JOIN clientes c ON p.rut_cliente = c.rut
                    LEFT JOIN pedido_detalle pd ON p.num_orden = pd.num_orden
                    WHERE p.num_orden = :num_orden";
                    $stmt = $conexion->prepare($strsql);
                    $stmt->bindParam(':num_orden', $num_orden, PDO::PARAM_INT);
                    $stmt->execute();

                    $data = array();
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                        $rut_cliente = $row['rut_cliente'];
                        $direccion = $row['direccion'];
                        $telefono = $row['telefono'];
                        $numero = $row['numero'];
                        $dpto = $row['dpto'];
                        $correo = $row['correo'];
                        $instagram = $row['instagram'];
                    }
                }
                ?>


                <div class="col-md-6" style="text-align: center; margin:0 auto;">
                    <label> Que producto quieres agregar?</label>
                    <select id="status" name="status" class="form-select" onChange="mostrar(this.value)">
                        <option value="">Seleccionar producto</option>
                        <option value="respaldo">Respaldos de Cama</option>
                        <option value="colchon">Colchones</option>
                        <option value="base">Base de Cama</option>
                        <option value="velador">Veladores</option>
                        <option value="patas">Patas de cama</option>
                        <option value="banquetas">Banquetas</option>
                        <option value="fundas">Fundas</option>
                        <option value="living">Living</option>

                    </select>

                </div>
                <p></p>
                <main>

                    <div id="formularios" style="display: none; padding:15px; "> </div>
                </main>











                <div id="fracaso" style=" width: 60rem; margin:0 auto; text-align: center; ">


                </div>



                <input type="button" name="previous" class="previous btn btn-default" value="Previo" />
                <input type="button" name="next" class="next btn btn-info" value="Siguiente" />
            </fieldset>
            <fieldset>
                <h2>Detalle de Pedidos</h2>
                <div id="pedidosAgregados">
                    <!-- Los pedidos se generarán dinámicamente aquí -->
                </div>
                <div class="container-fluid">
                    <div class="pedido-resumen">
                        <div class="pedido-abono">
                            <label for="message">Observaciones: </label>
                            <input type="text" class="form-control TotalAbono" name="message" id="message" value="">
                            <!--  <button type="button" class="btn btn-success  btn-sm btnEditarOrden"  style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;" >Ingresar Pagos</button> -->
                        </div>
                        <div class="pedido-despacho">
                            <label for="valorDespacho">Valor Despacho: </label>
                            <input type="number" class="form-control valorDespacho" name="valorDespacho" id="valorDespacho" value="" placeholder="0">
                        </div>
                        <div class="pedido-total">
                            <label for="valorTotal">Valor Total: $</label>
                            <input type="text" class="form-control" id="valorTotal" disabled value="" placeholder="0">
                            <small id="passwordHelpInline" class="text-muted">
                                Suma de todos los precios más despacho.
                            </small>
                            <input type="hidden" name="pedidosJson" id="pedidosJson" value="">

                        </div>
                    </div>
                </div>
                <input type="button" name="previous" class="previous btn btn-default" value="Previo" />
                <input type="submit" name="botonenviar" class="submit btn btn-success" value="Enviar" id="submit_data" />
            </fieldset>
            <fieldset>
                <div id="contenidoDinamico"></div>
            </fieldset>
        </form>
    </div>
</div>


<!--INICIO del cont principal-->

<!--FIN del cont principal-->

<script>
    // Función para mostrar los pedidos agregados en el Paso 3

    let pedidos = [];

    $(document).ready(function() {


        function agregarPedido(pedido) {
            pedidos.push(pedido); // Añade el nuevo pedido al array
        }





        // Ejemplo de cómo se vería un pedido
        function capturarDatosDelPedido() {
            let pedido = {
                producto: $("#modelo").val() ?? "", // Si $("#modelo").val() es undefined, usa "" como predeterminado
                tamano: $("#plazas").val() ?? "",
                material: $("#listatelas").val() ?? "",
                color: $("#lista2").val() ?? "",
                cantidad: $("#cantidad").val() ?? "",
                alturaBase: $("#alturabase").val() ?? "",
                detallesFabricacion: $("#detalles_fabricacion").val() ?? "",
                boton: $('input[name="boton"]:checked').val() ?? "",
                anclaje: $('input[name="anclaje"]:checked').val() ?? "",
                anclajeMetal: $('input[name="anclajemetal"]:checked').val() ?? "",
                precio: 0 // Este valor se establece manualmente, así que su manejo no cambia

                // Agrega más campos según sea necesario
            };
            agregarPedido(pedido);
            mostrarPedidosAgregados();
        }

        $('#pedidosAgregados').on('click', '.cerrar-pedido', function() {
            // Obtener el índice del pedido a eliminar
            const index = $(this).data('index');
            // Elimina el pedido del array
            pedidos.splice(index, 1);
            // Vuelve a renderizar los pedidos actualizados
            mostrarPedidosAgregados();
        });


        function mostrarPedidosAgregados() {
            let pedidosHtml = pedidos.map((pedido, index) => `
            <div class="pedido-agregado">
                        <div class="cerrar-pedido" data-index="${index}">X</div>

            <div class="pedido-detalle">
                <h4>Pedido ${index + 1}</h4>
                <p><b>Producto:</b> ${pedido.producto}  <b>Tamaño:</b> ${pedido.tamano} </p> 
                <p><b>Material:</b>  ${pedido.material} <b>Color:</b> ${pedido.color}</p>
                <p><b>Altura Base:</b>  ${pedido.alturaBase} </p>
                <p><b>Detalles:</b> ${pedido.detallesFabricacion}</p>
            </div>
            <div class="pedido-precios">
            <div class="form-group">
            Valores:
            </div>
                <div class="form-group">
                    <label for="precio-${index}"><b>Precio:</b> </label>
                    <input type="number" class="form-control precio-input" name="precio[${index}]" id="precio-${index}" data-index="${index}"  placeholder="Precio">
                </div>
                <div class="form-group col-md-6">
                <label><b>Cantidad:</b> </label><input class="form-control precio-input" value="${pedido.cantidad}" disabled></input>  
                </div>
            </div>
        </div>
            `).join('');

            document.getElementById('pedidosAgregados').innerHTML = pedidosHtml;

            // Añadir evento change a cada input de precio
            $('.precio-input').on('change', function() {
                let index = $(this).data('index');
                let nuevoPrecio = parseFloat($(this).val()) || 0;
                pedidos[index].precio = nuevoPrecio; // Actualiza el precio en el array
                actualizarValorTotal(); // Recalcula el total
            });

            $('.valorDespacho').on('change', function() {

                actualizarValorTotal(); // Recalcula el total
            });







        }


        function actualizarValorTotal() {
            let total = pedidos.reduce((acc, pedido) => acc + pedido.precio, 0);
            let valorDespacho = parseFloat($('#valorDespacho').val()) || 0;
            total += valorDespacho;
            $('#valorTotal').val(total.toFixed(0)); // Actualiza el input de valor total
        }



        var current = 1,
            current_step, next_step, steps;
        steps = $("fieldset").length;

        $(".next").click(function() {
            current_step = $(this).parent();

            // Si estamos en el paso de los datos del pedido (paso 2, asumiendo que current == 2 es paso 2)
            if (current == 2 && validarPasoActual(current_step)) {
                // Aquí preguntamos si quiere agregar otro pedido o continuar
                swal.fire({
                    title: '¿Desea agregar otro pedido?',
                    text: "Puede agregar más productos a esta orden.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, agregar otro',
                    cancelButtonText: 'No, continuar al siguiente paso'
                }).then((result) => {
                    if (result.isConfirmed) {
                        capturarDatosDelPedido(); // Captura y almacena los datos del pedido actual

                        $("#formularios").hide();
                        $('#status').val('');
                        // Aquí podrías clonar los campos de pedido, resetearlos para una nueva entrada o mostrar un nuevo conjunto de campos
                        // No avanzamos a current++
                    } else {
                        $('#status').val('');
                        $("#formularios").hide();
                        capturarDatosDelPedido();
                        mostrarPedidosAgregados();
                        // El usuario elige continuar al siguiente paso
                        next_step = $(this).parent().next();
                        next_step.show();
                        current_step.hide();
                        setProgressBar(++current);
                    }
                });
            } else if (validarPasoActual(current_step)) {
                // Para cualquier otro paso que no requiera la confirmación especial
                next_step = $(this).parent().next();
                next_step.show();
                current_step.hide();
                setProgressBar(++current);
            } else if (current == 3) {
                console.log("pasa por aqui");
                next_step = $(this).parent().next();
                next_step.show();
                current_step.hide();
                setProgressBar(++current);
            } else {
                // Si no se validan los campos requeridos
                swal.fire("", "Por favor, complete todos los campos requeridos antes de continuar.", "warning");
            }

        });

        // Lógica para manejar el clic en el botón "anterior"
        $(".previous").click(function() {
            current_step = $(this).parent();
            next_step = $(this).parent().prev();
            next_step.show();
            current_step.hide();
            setProgressBar(--current);
        });

        setProgressBar(current);

        function setProgressBar(curStep) {
            var percent = parseFloat(100 / steps) * curStep;
            percent = percent.toFixed();
            $(".progress-bar")
                .css("width", percent + "%")
                .html(percent + "%");
        }

        // Función para validar el paso actual
        function validarPasoActual(step) {
            var isValid = true;

            $(step).find("input[required], select[required], textarea[required]").each(function() {
                if ($(this).val() === "") {
                    isValid = false;
                    // Opcional: resaltar campos no válidos
                    $(this).addClass('is-invalid'); // Añade una clase para indicar visualmente el error
                } else {
                    $(this).removeClass('is-invalid'); // Asegúrate de quitar la clase si el campo es válido
                }
            });

            return isValid;
        }





        // Función para actualizar la barra de progreso

        // Esta parte del código se ejecutará automáticamente cuando la página esté lista.



        $("#formular").on('submit', function(evt) {
            evt.preventDefault(); // Previene el comportamiento por defecto del formulario.
            console.log("enviar");
            // Convertir el array de pedidos a JSON y asignarlo a un input oculto.
            var pedidosJson = JSON.stringify(pedidos);
            $('#pedidosJson').val(pedidosJson);

            // Determinar la dirección basándose en los campos del formulario.
            var direccion = $("#street_name").val() == "" ?
                $("#search_input").val() :
                $("#street_name").val() + " " + $("#street_number").val() + ", " + $("#comunas").val() + " " + $("#dpto").val(); // Evitar el envío tradicional del formulario

            if ($("#formular")[0].checkValidity()) {
                $.ajax({
                    url: "formularios/agregarpedido2024.php",
                    type: "POST",
                    data: $("#formular").serialize(),
                    dataType: "json", // Esperando una respuesta en JSON
                    success: function(res) {
                        var div = document.getElementById('contenidoDinamico');
                        // Creamos un nuevo contenido HTML
                        var nuevoContenido = `
                                                <h2>Pedido Ingresado Con Éxito!</h2>
                                                <p>Tu información ha sido recibida correctamente.</p>
                                                <a href='addpedido.php' class='btn btn-success btn-sm'>Agregar un nuevo pedido</a>
                                            `; // Asignamos el nuevo contenido al div
                        div.innerHTML = nuevoContenido;

                        // Inspeccionar la respuesta
                        if (res.success) {
                            current_step = $("fieldset:visible");
                            next_step = current_step.next("fieldset");
                            if (next_step.length) {
                                current_step.hide();
                                next_step.show();
                                setProgressBar(++current);
                            }


                            Swal.fire({
                                title: 'Pedido Ingresado con éxito',
                                html: `
                            <img width='30%' src='img/okimg.png'><br> `,
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Finalizar Pedido',
                                confirmButtonColor: '#fd7e14',
                                cancelButtonText: 'Cerrar',
                                showCloseButton: true,
                                focusConfirm: false,
                                html:

                                    ` Vendedor: ${res.vendedor}<br>
                            Numero de Pedido: ${res.lastid}<br>
                            Numero de Orden: ${res.nuevoregistroorden}                  <br>
                            
                            <div style='text-align: center; margin-bottom: 1.5rem;'>
                            <button type='button' class='btn btn-success  btn-sm btnAddPagoMOD' data-id='${res.nuevoregistroorden}' style='--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;' >Ingresar Pagos</button>        </div> 
                            

                            <div style='text-align:center; '>
                                <a href='addpedido.php' class='btn btn-success btn-sm'>Agregar un nuevo pedido</a>
                            </div>
                            
                            `,

                                allowOutsideClick: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Aquí puedes realizar la acción de finalización del pedido y enviar el correo
                                    Swal.fire({
                                        title: 'Pedido finalizado',
                                        text: 'El pedido se ha finalizado correctamente',
                                        icon: 'success',
                                        html: `
                            <div style='text-align:center; margin-top: 10px;'>
                                <a href='reportes/pedido.php?id=${res.nuevoregistroorden}' class='btn btn-primary btn-sm'>Imprimir Comprobante</a> 
                            </div> `,
                                        showConfirmButton: true,
                                        allowOutsideClick: false
                                    }).then(() => {
                                        window.location.href = `finalizar_pedido.php?id=${res.nuevoregistroorden}`;

                                    });
                                }
                            });

                            // 
                        } else {
                            var div = document.getElementById('contenidoDinamico');
                            // Creamos un nuevo contenido HTML
                            var nuevoContenido = `
                                                <h2>Error ingresando pedido!</h2>
                                                <p>Vuelva a intentarlo.</p>
                                                <a href='addpedido.php' class='btn btn-success btn-sm'>Agregar un nuevo pedido</a>
                                            `; // Asignamos el nuevo contenido al div
                            div.innerHTML = nuevoContenido;
                            current_step = $("fieldset:visible");
                            next_step = current_step.next("fieldset");
                            if (next_step.length) {
                                current_step.hide();
                                next_step.show();
                                setProgressBar(++current);
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error en AJAX:", status, error);
                    }
                });
            }
        });
    });
</script>















<script>
    function noPuntoComa(event) {

        var e = event || window.event;
        var key = e.keyCode || e.which;

        if (key === 110 || key === 190 || key === 188) {

            e.preventDefault();
        }


    }

    function checkRut(rut) {
        document.getElementById("iconoCheck").style.display = 'none';
        document.getElementById("iconoCross").style.display = 'none';
        // Despejar Puntos
        var valor = rut.value.replace('.', '');
        // Despejar Guión
        valor = valor.replace('-', '');

        // Aislar Cuerpo y Dígito Verificador
        cuerpo = valor.slice(0, -1);
        dv = valor.slice(-1).toUpperCase();

        // Formatear RUN
        rut.value = cuerpo + '-' + dv

        // Si no cumple con el mínimo ej. (n.nnn.nnn)
        if (cuerpo.length < 7) {
            rut.setCustomValidity("RUT Incompleto");
            return false;
        }

        // Calcular Dígito Verificador
        suma = 0;
        multiplo = 2;

        // Para cada dígito del Cuerpo
        for (i = 1; i <= cuerpo.length; i++) {

            // Obtener su Producto con el Múltiplo Correspondiente
            index = multiplo * valor.charAt(cuerpo.length - i);

            // Sumar al Contador General
            suma = suma + index;

            // Consolidar Múltiplo dentro del rango [2,7]
            if (multiplo < 7) {
                multiplo = multiplo + 1;
            } else {
                multiplo = 2;
            }

        }

        // Calcular Dígito Verificador en base al Módulo 11
        dvEsperado = 11 - (suma % 11);

        // Casos Especiales (0 y K)
        dv = (dv == 'K') ? 10 : dv;
        dv = (dv == 0) ? 11 : dv;

        // Validar que el Cuerpo coincide con su Dígito Verificador
        if (dvEsperado != dv) {
            rut.setCustomValidity("RUT Inválido");
            // Oculta el ícono si el RUT no es válido
            document.getElementById("iconoCheck").style.display = 'none';
            document.getElementById("iconoCross").style.display = 'block';
            $("#msgvalido").html("");
            var rut_valido = "si";
            $("#msgerror").html("Rut invalido, por favor verificar antes de ingresar...");
            rut.classList.add('input-incorrect');
            return false;
        }

        // Si todo sale bien, eliminar errores (decretar que es válido)
        rut.setCustomValidity('');
        document.getElementById("iconoCheck").style.display = 'block';
        document.getElementById("iconoCross").style.display = 'none';
        rut.classList.remove('input-incorrect');
        $("#msgvalido").html("Rut valido!");
        $("#msgerror").html("");
        rutcompleto = $("#rut").val();

        consultarCliente(rutcompleto);
        consultarpedidoexistente(rutcompleto);





    }




    function validarRut() {
        var Fn = {
            // Valida el rut con su cadena completa "XXXXXXXX-X"
            validaRut: function(rutCompleto) {
                rutCompleto = rutCompleto.replace("‐", "-");
                if (!/^[0-9]+[-|‐]{1}[0-9kK]{1}$/.test(rutCompleto))
                    return false;
                var tmp = rutCompleto.split('-');
                var digv = tmp[1];
                var rut = tmp[0];
                if (digv == 'K') digv = 'k';

                return (Fn.dv(rut) == digv);
            },
            dv: function(T) {
                var M = 0,
                    S = 1;
                for (; T; T = Math.floor(T / 10))
                    S = (S + T % 10 * (9 - M++ % 6)) % 11;
                return S ? S - 1 : 'k';
            }
        }
        if (Fn.validaRut($("#rut").val())) {
            $("#msgvalido").html("Rut valido!");
            $("#msgerror").html("");
            rutcompleto = $("#rut").val();

            consultarCliente(rutcompleto);
            consultarpedidoexistente(rutcompleto);


        } else {
            $("#msgvalido").html("");
            var rut_valido = "si";
            $("#msgerror").html("Rut invalido, por favor verificar antes de ingresar...");
        }
    }

    function consultarpedidoexistente() {
        var rut = rutcompleto;
        $.ajax({
            url: "formularios/existe_cliente.php",
            type: "POST",
            data: {
                opcion: 2,
                id: rutcompleto
            },
            success: function(data) {
                if (data.trim().length > 0) { // Verifica si 'data' no está vacío
                    $("#pedidoexistente").html(data);

                    Swal.fire({
                        title: 'Pendientes de fabricación',
                        html: data, // Usa la variable 'data' para mostrar el contenido HTML en el Swal
                        width: 900, // Ajusta el ancho según necesites
                        padding: '3em',
                        confirmButtonText: 'Aceptar', // Puedes personalizar el texto del botón de confirmación
                        confirmButtonColor: '#3085d6',
                        icon: 'warning',  // Ajusta el padding según necesites
                        background: '#fff url(/images/trees.png)', // Cambia el fondo si lo deseas
                        backdrop: `
    rgba(0,0,123,0.4)
    url("https://respaldoschile.cl/intranet/dashboard/img/nyan-cat.gif")
    left top
    no-repeat
  ` // Puedes personalizar el fondo del modal aquí
                    }).then((result) => {
                        // Acciones a realizar cuando el usuario cierra el Swal, si es necesario
                    });
                } else {
                    // Aquí puedes manejar el caso cuando 'data' esté vacío, si es necesario
                    console.log("No hay datos para mostrar.");
                }
            },
            error: function() {
                alert("error");
            }
        });
    }




    function consultarCliente(rutcompleto) {
        var rut = rutcompleto;
        $externo = false;

        $.ajax({


            url: "formularios/existe_cliente.php",
            type: "POST",
            data: {
                opcion: 1,
                id: rutcompleto
            },
            success: function(data) {
                const usuarios = JSON.parse(data);
                console.log(data);

                var nombre = usuarios[1];
                var telefono = usuarios[2];
                var correo = usuarios[3];
                var direccion = usuarios[4];
                var numero = usuarios[5];
                var dpto = usuarios[6];
                var instagram = usuarios[7];
                var region = usuarios[8];
                var comuna = usuarios[9];
                //consulta si esque se extrajo desde rutificador.
                var externo = usuarios[10];

                if (usuarios.length === 0) {
                    document.getElementById("name").value = "";
                    document.getElementById("clienteexisterut").value = "";
                    document.getElementById("telefono").value = "";
                    document.getElementById("direccion").value = "";
                    document.getElementById("email").value = "";
                    document.getElementById("numero").value = "";
                    document.getElementById("dpto").value = "";
                    document.getElementById("instagram").value = "";
                    document.getElementById("clienteexisterut").value = "";
                    document.getElementById("comuna").innerHTML = "";
                    document.getElementById("regiones").value = "";

                } else {

                    document.getElementById("name").value = nombre;
                    if($externo == true){
                        document.getElementById("clienteexisterut").value = "si";
                    }else{
                        document.getElementById("clienteexisterut").value = "";
                    }
                    
                    document.getElementById("telefono").value = telefono;

                    document.getElementById("email").value = correo;

                    var direccion_completa = direccion + " " + numero + " " + comuna + " " + region;

                    document.getElementById("search_input").value = direccion_completa;
                    document.getElementById("street_name").value = direccion;

                    document.getElementById("street_number").value = numero;
                    document.getElementById("dpto").value = dpto;
                    document.getElementById("instagram").value = instagram;

                    document.getElementById("comunas").value = comuna;
                    document.getElementById("regiones").value = region;
                }

            },
            error: function() {

                alert("error");

            }

        });

    }
</script>


<script type="text/javascript">
    function establecerVisibilidadImagen(id, visibilidad) {
        var img = document.getElementById(id);
        img.style.visibility = (visibilidad ? 'visible' : 'hidden');
    }
</script>
<script type="text/javascript">
    $('#listatelas').val(1);


    // aqui validamos si recibe el checkbox retiro en tienda
    var retiroTiendaCheckbox = document.getElementById('retiro_tienda');
    var datosDireccionDiv = document.getElementById('direccionymapa');

    retiroTiendaCheckbox.addEventListener('change', function() {
        if (retiroTiendaCheckbox.checked) {
            swal.fire("", "Cliente retira en tienda, debes especificar la fecha de retiro", "success");
            datosDireccionDiv.style.display = 'none';
            detalleretiro.style.display = 'block';
        } else {
            detalleretiro.style.display = 'none';
            datosDireccionDiv.style.display = 'block';
        }
    });

    // recargarLista(); 
    function vincularEventosASelect() {
        console.log("se captura cambio");
        $('#listatelas').change(function() {

            recargarLista();
            recargarListaImg();

        });


        $("#select2lista").change(function() {


        });

        function recargarLista() {
            $.ajax({
                type: "POST",
                url: "formularios/datos.php",
                data: "colores=" + $('#listatelas').val(),

                success: function(r) {

                    $('#select2lista').html(r);

                }
            });
        }

        function recargarListaImg() {

            $.ajax({

                data: "color=" + $('#listatelas').val(),
                url: 'formularios/ajax_colores.php',
                type: 'post',
                datatype: 'html',
                success: function(datahtml) {


                    $("#imagencolor").html(datahtml);


                },
                error: function() {
                    alert("Error seleccionando el tipo de Tela");

                }
            });
        }

    }
</script>



<!-- SCRIPT DE GEOLOCALIZACION -->
<script>
    var poligonoCoordenadas = [{
            lat: -33.4314581,
            lng: -70.7902495
        },
        {
            lat: -33.524328,
            lng: -70.7993944
        },
        {
            lat: -33.6349299,
            lng: -70.7123172
        },
        {
            lat: -33.6352154,
            lng: -70.6007414
        },
        {
            lat: -33.6060619,
            lng: -70.5219445
        },
        {
            lat: -33.5239525,
            lng: -70.524526
        },
        {
            lat: -33.442918,
            lng: -70.519719
        },
        {
            lat: -33.3887578,
            lng: -70.5080475
        },
        {
            lat: -33.3375201,
            lng: -70.5007323
        },
        {
            lat: -33.3512863,
            lng: -70.7005396
        },
        {
            lat: -33.3499957,
            lng: -70.7510067
        },
        {
            lat: -33.3644766,
            lng: -70.7590746
        },
        {
            lat: -33.3960115,
            lng: -70.7760681
        },
        {
            lat: -33.4314581,
            lng: -70.7902495
        }
    ];

    var geocoder = new google.maps.Geocoder();
    var inputElement = document.getElementById('search_input');
    var verificarButton = document.getElementById('verificar_button');

    verificarButton.addEventListener('click', function() {
        var direccion = inputElement.value.trim();
        if (direccion !== '') {
            verificarUbicacion(direccion);
        }
    });

    function puntoDentroPoligono(point, polygon) {
        var x = point.lng;
        var y = point.lat;

        var dentro = false;
        for (var i = 0, j = polygon.length - 1; i < polygon.length; j = i++) {
            var xi = polygon[i].lng;
            var yi = polygon[i].lat;
            var xj = polygon[j].lng;
            var yj = polygon[j].lat;

            var intersecta = ((yi > y) !== (yj > y)) && (x < (xj - xi) * (y - yi) / (yj - yi) + xi);
            if (intersecta) dentro = !dentro;
        }

        return dentro;
    }

    function verificarUbicacion(direccion) {
        geocoder.geocode({
            address: direccion
        }, function(results, status) {
            if (status === google.maps.GeocoderStatus.OK && results.length > 0) {
                var ubicacion = results[0].geometry.location;
                var lat = ubicacion.lat();
                var lng = ubicacion.lng();
                var point = {
                    lat: lat,
                    lng: lng
                };
                var dentroPoligono = puntoDentroPoligono(point, poligonoCoordenadas);
                if (dentroPoligono) {
                    inputElement.classList.remove('input-outside');
                    inputElement.classList.add('input-inside');
                    document.getElementById('result').textContent = 'La ubicación está dentro del rango de precio estandar.';
                } else {
                    inputElement.classList.remove('input-inside');
                    inputElement.classList.add('input-outside');
                    document.getElementById('result').textContent = 'La ubicación está fuera del precio estandar.';
                }
            } else {
                inputElement.classList.remove('input-inside');
                inputElement.classList.add('input-outside');
                document.getElementById('result').textContent = 'No se pudo geocodificar la dirección.';
            }
        });
    }
</script>

<script>
    $(document).ready(function() {
        var input = document.getElementById('search_input');



        var searchInput = document.getElementById('search_input');
        var locLatInput = document.getElementById('loc_lat');
        var locLongInput = document.getElementById('loc_long');
        var streetNumberInput = document.getElementById('street_number');
        var streetNameInput = document.getElementById('street_name');
        var comunaInput = document.getElementById('comunas');
        var regionInput = document.getElementById('regiones');
        var latitudeView = document.getElementById('latitude_view');
        var longitudeView = document.getElementById('longitude_view');

        var autocomplete = new google.maps.places.Autocomplete(searchInput, {
            types: ['geocode']
        });

        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            var place = autocomplete.getPlace();
            locLatInput.value = place.geometry.location.lat();
            locLongInput.value = place.geometry.location.lng();

            var streetNumber = "";
            var streetName = "";
            var comuna = "";
            var region = "";
            for (var i = 0; i < place.address_components.length; i++) {
                var component = place.address_components[i];
                if (component.types.includes('street_number')) {
                    streetNumber = component.short_name;
                } else if (component.types.includes('route')) {
                    streetName = component.long_name;
                } else if (component.types.includes('administrative_area_level_3')) {
                    comuna = component.long_name;
                } else if (component.types.includes('administrative_area_level_1')) {
                    region = component.long_name;
                }
            }
            streetNumberInput.value = streetNumber;
            streetNameInput.value = streetName;
            comunaInput.value = comuna;
            regionInput.value = region;

            latitudeView.textContent = place.geometry.location.lat();
            longitudeView.textContent = place.geometry.location.lng();
        });
    });
</script>



<!-- revisar ya que es algo de autocompletar direccion -->
<script type="text/javascript">
    let autocomplete;
    let address1Field;
    let address2Field;
    let postalField;

    function initAutocomplete() {
        address1Field = document.querySelector("#ship-address");
        address2Field = document.querySelector("#address2");
        postalField = document.querySelector("#postcode");
        // Create the autocomplete object, restricting the search predictions to
        // addresses in the US and Canada.
        autocomplete = new google.maps.places.Autocomplete(address1Field, {
            componentRestrictions: {
                country: ["us", "ca"]
            },
            fields: ["address_components", "geometry"],
            types: ["address"],
        });
        address1Field.focus();
        // When the user selects an address from the drop-down, populate the
        // address fields in the form.
        autocomplete.addListener("place_changed", fillInAddress);
    }

    function fillInAddress() {
        // Get the place details from the autocomplete object.
        const place = autocomplete.getPlace();
        let address1 = "";
        let postcode = "";

        // Get each component of the address from the place details,
        // and then fill-in the corresponding field on the form.
        // place.address_components are google.maps.GeocoderAddressComponent objects
        // which are documented at http://goo.gle/3l5i5Mr
        for (const component of place.address_components) {
            const componentType = component.types[0];

            switch (componentType) {
                case "street_number": {
                    address1 = `${component.long_name} ${address1}`;
                    break;
                }

                case "route": {
                    address1 += component.short_name;
                    break;
                }



                case "postal_code_suffix": {
                    postcode = `${postcode}-${component.long_name}`;
                    break;
                }
                case "locality":
                    document.querySelector("#locality").value = component.long_name;
                    break;

                case "administrative_area_level_1": {
                    document.querySelector("#state").value = component.short_name;
                    break;
                }
                case "country":
                    document.querySelector("#country").value = component.long_name;
                    break;
            }
        }
        address1Field.value = address1;
        postalField.value = postcode;
        // After filling the form with address components from the Autocomplete
        // prediction, set cursor focus on the second address line to encourage
        // entry of subpremise information such as apartment, unit, or floor number.
        address2Field.focus();
    }
</script>
<script>
    function validaForm() {
        // Campos de texto
        if ($("#name").val() == "") {

            $("#name").focus(); // Esta función coloca el foco de escritura del usuario en el campo Nombre directamente.
            $("#name_error").html("Debe ingresar este campo");

            return false;
        }



        // Checkbox


        return true; // Si todo está correcto
    }
</script>
<?php include("modal_validarpagos.php"); ?>
<?php require_once "vistas/parte_inferior.php" ?>