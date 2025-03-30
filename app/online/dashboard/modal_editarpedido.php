  <style type="text/css">
    .container2 {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      /* 2 columnas */
    }

    .card {
      border: 1px solid #ccc;
      margin: 0;
      padding: 2px;
    }

    .card-body {
      margin: 0;
      padding: 0px;
      /* Eliminar el margen interno del card-body */
    }

    .card-body label {
      margin-bottom: 0px;
      padding: 0;
      /* Ajustar el espacio entre etiquetas */
    }

    .resaltada {
      background-color: yellow !important;
      /* Cambia el color de fondo de la fila resaltada */
      font-weight: bold;
      /* Cambia el estilo de fuente de la fila resaltada */
      /* Agrega cualquier otro estilo adicional según tus necesidades */
    }
  </style>

  <!--Modal para CRUD EDITAR PEDIDO-->
  <div class="modal fade " id="modalEditarPedido" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog centered modal-xl" role="document">
      <div class="modal-content" style="border-bottom-right-radius: 25px;">

        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>

        <form id="editarpedido">
          <div class="modal-body">
            <div id="header_modal" style="background-color: #F2F2F2; padding: 15px; border-radius: 5px; font-size: 14px;">
              <div class="row gy-2">
                <div class="col-lg-1">
                  <label for="ide" class="col-form-label small-text">Cod:</label>
                  <input type="text" class="form-control form-control-sm small-input small-text" id="ide" name="ide" disabled>
                </div>
                <div class="col-lg-1" name="ide_webs" id="ide_webs" style="display:none;">
                  <label for="ide_web" class="col-form-label small-text">CodWeb:</label>
                  <input type="text" class="form-control form-control-sm small-input small-text" style="background-color:#F1FFD5;" id="ide_web" name="ide_web" disabled>
                </div>
                <div class="col-lg-1">
                  <label for="ide" class="col-form-label small-text">Orden:</label>
                  <input type="text" class="form-control form-control-sm small-input small-text" id="num_orden" name="num_orden" disabled>
                </div>
                <div class="col-lg-2">
                  <label for="ide" class="col-form-label small-text">Fecha Ingreso:</label>
                  <input type="text" class="form-control form-control-sm small-input small-text" id="fecha_ingreso" name="fecha_ingreso" disabled>
                </div>
                <div class="col-lg-2">
                  <label for="ide" class="col-form-label small-text">Vendedor:</label>
                  <input type="text" class="form-control form-control-sm small-input small-text" id="vendedor" name="vendedor" disabled>
                </div>
                <div class="col-lg-2">
                  <label for="ide" class="col-form-label small-text">Estado del producto:</label>
                  <input type="text" class="form-control form-control-sm small-input small-text" id="estadopedido" name="estadopedido" disabled>
                </div>
                <div class="col-lg-3" style="background-color: #FFE4E4; border-radius: 5px;padding: 5px; text-align: center;">
                  <label for="ide" class="col-form-label small-text">Este Producto Tiene un reclamo abierto</label>

                  <button type="button" class="btn btn-primary btn-sm" id="reclamo" onclick="cerrarcaso()">Agregar Solucion</button>


                </div>


              </div>



              <div class="row gy-4">
                <div class="col-lg-4">
                  <label for="rut" class="col-form-label">Rut:</label>
                  <input type="text" class="form-control form-control-sm" id="rut" name="rut" disabled>
                </div>
                <div class="col-lg-4">
                  <label for="nombre" class="col-form-label">Nombre:</label>
                  <input type="text" class="form-control form-control-sm" id="nombre" name="nombre">
                </div>
                <style type="text/css">
                  .telefono-container {
                    position: relative;
                  }

                  .telefono-container img {
                    position: absolute;
                    top: 50%;
                    transform: translateY(-50%);
                    left: calc(100% + 2px);
                  }
                </style>
                <div class="col-lg-3">
                  <label for="telefono" class="col-form-label">Telefono:</label>
                  <div class="telefono-container">
                    <input type="text" class="form-control form-control-sm" id="telefono" name="telefono">
                    <a href="#" id="whatsapp-link" target="_blank">
                      <img src="img/whatsapp.png" alt="WhatsApp" width="50" id="whatsapp" data-toggle="tooltip" data-placement="right" title="Puedes hablarle al whatsapp">
                    </a>
                  </div>
                </div>
                <script>
                  // Obtener el elemento del campo de teléfono
                  var telefonoInput = document.getElementById("telefono");

                  // Obtener el elemento del enlace de WhatsApp
                  var whatsappLink = document.getElementById("whatsapp-link");

                  // Agregar un evento de clic al enlace de WhatsApp
                  whatsappLink.addEventListener("click", function(event) {
                    // Obtener el número de teléfono del campo de entrada
                    var telefono = telefonoInput.value;

                    // Construir la URL del enlace de WhatsApp con el número de teléfono
                    var url = "https://api.whatsapp.com/send/?phone=+56" + telefono + "&text=Hola! te escribimos de respaldos chile ";

                    // Establecer la URL del enlace de WhatsApp
                    whatsappLink.href = url;
                  });
                </script>
              </div><br>
              <hr>
              <div class="row gy-4">
                <div class="col-lg-4">
                  <label for="modelo" class="col-form-label">Modelo:</label>
                  <input type="text" class="form-control form-control-sm" id="modelo" name="modelo">
                </div>
                <div class="col-lg-4">
                  <label for="plazas" class="col-form-label">Tamano:</label>
                  <input type="text" class="form-control form-control-sm" id="plazas" name="plazas">
                </div>
                <div class="col-lg-3">
                  <label for="alturabase" class="col-form-label">Altura:</label>
                  <input type="text" class="form-control form-control-sm" id="alturabase" name="alturabase">
                </div>

              </div>
              <div class="row gy-4">
                <div class="col-lg-2">

                  <label for="tela" class="col-form-label">Material:</label>
                  <select class="form-control form-control-sm" id="tela" name="tela">
                    <option value="lino">Lino</option>
                    <option value="felpa">Felpa</option>
                    <option value="ecocuero">Eco Cuero</option>
                    <option value="asturias">Asturias</option>
                    <option value="mosaico">Felpa Mosaico</option>
                    <option value="albayalde">Albayalde</option>
                    <option value="unicolor">Unicolor</option>

                  </select>

                </div>
                <div class="col-lg-2">
                  <label for="color" class="col-form-label">Color:</label>
                  <input type="text" class="form-control form-control-sm" id="color" name="color">
                </div>
                <div class="col-lg-2">
                  <label for="anclaje" class="col-form-label">Anclaje:</label>
                  <select class="form-control form-control-sm" id="anclaje" name="anclaje">
                    <option value="no">Sin Anclaje</option>
                    <option value="">Sin Anclaje</option>
                    <option value="patas">Patas</option>
                    <option value="si">Madera Anclaje</option>
                  </select>
                </div>
                <div class="col-lg-2">
                  <label for="tipo_boton" class="col-form-label">Tipo Boton:</label>
                  <select class="form-control form-control-sm" id="tipo_boton" name="tipo_boton">
                    <option value="">Botones normales</option>
                    <option value="B D">Boton Diamante</option>
                    <option value="B Color">Boton de color</option>


                  </select>
                </div>
                <div class="col-lg-2">
                  <label for="metodo_entrega" class="col-form-label">Tipo Entrega:</label>
                  <select class="form-control form-control-sm" id="metodo_entrega" name="metodo_entrega">
                    <option value="Despacho">Despacho a domicilio</option>
                    <option value="Retiro en tienda">Retiro en tienda</option>



                  </select>
                </div>
                <div class="col-lg-2" id="fecha_retiro" style="display: none;">
                  <label for="metodo_entrega" class="col-form-label">Fecha :</label>
                  <input class="form-control form-control-sm ps-12 flatpickr-input active" id="detalle_entrega" style="background-color: #FFFFFF;" name="detalle_entrega" type="text" placeholder="Seleccionar Fecha">

                </div>

                <script type="text/javascript">
                  flatpickr('#detalle_entrega', {
                    enableTime: true,
                    minTime: "09:00",
                    maxTime: "18:00",
                    minDate: "today",
                    dateFormat: "Y-m-d H:i",

                    // Otions adicionales de configuración si las necesitas
                  });


                  $(document).ready(function() {
                    $('#metodo_entrega').on('change', function() {
                      var selectedOption = $(this).val();
                      if (selectedOption == "Despacho") {
                        document.getElementById('fecha_retiro').style.display = "none";

                        $("#direccion").prop("disabled", false);
                        $("#dpto").prop("disabled", false);
                        $("#numero").prop("disabled", false);
                        $("#comuna").prop("disabled", false);
                      } else {
                        document.getElementById('fecha_retiro').style.display = "block";
                        $("#direccion").prop("disabled", true);
                        $("#dpto").prop("disabled", true);
                        $("#numero").prop("disabled", true);
                        $("#comuna").prop("disabled", true);
                      }
                    });
                  });
                </script>


                <div class="col-lg-3">
                  <label for="precio" class="col-form-label">Precio:</label>
                  <input type="text" class="form-control form-control-sm" id="precio" name="precio">
                </div>
                <!--   <div class="col-lg-2">
                  <label for="abono" class="col-form-label">Abono:</label>
                  <input type="text" class="form-control form-control-sm" id="abono" name="abono" onchange="calcularPorPagarTermino();">
                </div>
                <div class="col-lg-2">
                  <label for="costo_envio" class="col-form-label">Costo Despacho:</label>
                  <input type="text" class="form-control form-control-sm" id="costo_envio" name="costo_envio">
                </div>
                <div class="col-lg-2" id="totalpagadodiv">

                  <label for="totalpagado" class="col-form-label">Total Pagado:</label>
                  <input type="text" class="form-control form-control-sm" id="totalpagado" name="totalpagado" disabled>
                </div>
                <div id="loadingIndicator" class="col-lg-4" style="display: none; padding: 20px;text-align: center;">
                  <img src="https://media.tenor.com/On7kvXhzml4AAAAj/loading-gif.gif" width="20" alt="Cargando...">
                </div>

                <div class="col-lg-3" id="calculoporpagar" style="display: none;">

                  <label for="porpagar" class="col-form-label">Por Pagar:</label>
                  <input type="text" class="form-control form-control-sm" id="porpagar" name="porpagar" disabled>
                </div>
 -->

                <script type="text/javascript">
                  function calcularPorPagarTermino() {

                    // Obtener los valores de los campos "precio" y "abono"
                    var precio = parseFloat($("#precio").val());
                    var abono = parseFloat($("#abono").val());

                    if (isNaN(abono)) {
                      // Si el valor de "abono" no es numérico, mostrar el precio en el campo "porpagar"
                      $("#porpagar").val(precio);
                    } else {
                      // Calcular el resultado de la resta
                      var porPagar = precio - abono;

                      // Actualizar el valor del campo "porpagar"

                      $("#porpagar").val(porPagar);

                    }

                  }


                  $(document).ready(function() {
                    function mostrarCargando() {
                      $("#calculoporpagar").hide(); // Mostrar el GIF de carga
                      $("#loadingIndicator").show(); // Mostrar el GIF de carga



                    }

                    // Función para ocultar el GIF de carga
                    function ocultarCargando() {
                      $("#loadingIndicator").hide();
                      $("#calculoporpagar").show(); // Ocultar el GIF de carga
                    }
                    // Función para calcular y actualizar el campo "porpagar"
                    function calcularPorPagar() {

                      mostrarCargando();
                      // Obtener los valores de los campos "precio" y "abono"
                      var precio = parseFloat($("#precio").val());
                      var abono = parseFloat($("#abono").val());
                      var costo_envio = parseFloat($("#costo_envio").val());
                      if (isNaN(abono)) {
                        // Si el valor de "abono" no es numérico, mostrar el precio en el campo "porpagar"
                        $("#porpagar").val(precio);
                      } else {
                        // Calcular el resultado de la resta
                        var porPagar = precio + costo_envio - abono;

                        // Actualizar el valor del campo "porpagar"

                        $("#porpagar").val(porPagar);

                      }
                      setTimeout(ocultarCargando, 800);
                    }
                    $('[data-toggle="tooltip"]').tooltip();





                    // Vincular eventos al abrir el modal
                    function abrirModal() {
                      $('#whatsapp').tooltip('show');
                      setTimeout(function() {
                        $('#whatsapp').tooltip('hide');
                      }, 3000);
                      // Llamar a la función para calcular y actualizar el campo "porpagar"
                      calcularPorPagar();

                    }

                    // Vincular eventos al cerrar el modal
                    function cerrarModal() {


                    }

                    // Desvincular eventos antes de volver a vincularlos
                    $('#modalEditarPedido').off('shown.bs.modal', abrirModal);
                    $('#modalEditarPedido').off('hide.bs.modal', cerrarModal);

                    // Vincular eventos al abrir y cerrar el modal
                    $('#modalEditarPedido').on('shown.bs.modal', abrirModal);
                    $('#modalEditarPedido').on('hide.bs.modal', cerrarModal);




                  });
                </script>



              </div><br>
              <hr>
              <div class="row gy-6">

                <div class="col-lg-4">
                  <label for="direccion" class="col-form-label">Direccion:</label>
                  <input type="text" class="form-control form-control-sm" id="direccion" name="direccion">
                </div>
                <div class="col-lg-2">
                  <label for="numero" class="col-form-label">Num:</label>
                  <input type="text" class="form-control form-control-sm" id="numero" name="numero">
                </div>
                <div class="col-lg-2">
                  <label for="dpto" class="col-form-label">Dpto:</label>
                  <input type="text" class="form-control form-control-sm" id="dpto" name="dpto">
                </div>
                <div class="col-lg-4">
                  <label for="comuna" class="col-form-label">Comuna:</label>
                  <input type="text" class="form-control form-control-sm" id="comuna" name="comuna">
                </div>
                <div class="col-lg-4">
                  <label for="Referencia" class="col-form-label">Referencia de entrega: <small style="color:Red; font-size: 9px;">NUEVO</small></label>
                  <input type="text" class="form-control form-control-sm" id="referencia" name="referencia" placeholder="Detalle indicado por cliente para entrega.">
                </div>
              </div>





              <div class="row gy-2">
                <div class="col-lg-8">
                  <label for="comentarios" class="col-form-label">Observaciones internas:</label>
                  <input type="text" class="form-control form-control-sm" id="comentarios" name="comentarios">
                </div>
                <div class="col-lg-8">
                  <label for="comentarios" class="col-form-label">Detalles para fabricación:</label>
                  <input type="text" class="form-control form-control-sm" id="detalles_fabricacion" name="detalles_fabricacion">
                </div>
              </div>

              <div style="margin-bottom: 5px;margin-top: 10px;">
                <button type="button" class="btn btn-primary" id="toggleDetailsBtn" onclick="toggleDetails()">Mostrar detalles</button>
                <script type="text/javascript">
                  var num_orden = $("#num_orden").val();
                </script>
                <button type="button" id="botonPDF" class="btn btn-success botonPDF">Generar PDF</button>
                <br><br>
                <small class="text-muted">*El costo de despacho se visualizará en cada pedido, pero se trata de un único cargo que cubre la totalidad del pedido, no individualmente por cada artículo.</small>
              </div>
              <div style="background-color: white; padding: 10px; border-radius:5px; margin-top: 20px; overflow-x: auto;">
                                        <h5>Pagos Asociados</h5>
                                        <table class="table table-bordered table-hover table-striped table-sm" id="paymentTable">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Id</th>
                                                    <th scope="col">Fecha</th>
                                                    <th scope="col">Rut</th>
                                                    <th scope="col">Nombre</th>
                                                    <th scope="col">Banco</th>
                                                    <th scope="col">Cuenta Origen</th>
                                                    <th scope="col">Monto</th>
                                                    <th scope="col">Detalle</th>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Se llenará dinámicamente -->
                                            </tbody>
                                        </table>
                                    </div>
              <div id="detailsContainer" style="display: none; font-size: 14px; ">
                <!-- Aquí se agregarán los detalles de forma dinámica -->
              </div>
            </div>

            <script type="text/javascript">
              function toggleDetails() {
                var detailsContainer = document.getElementById("detailsContainer");
                var toggleBtn = document.getElementById("toggleDetailsBtn");

                if (detailsContainer.style.display === "none") {
                  detailsContainer.style.display = "block";
                  toggleBtn.innerText = "Ocultar Detalles";
                } else {
                  detailsContainer.style.display = "none";
                  toggleBtn.innerText = "Mostrar Detalles";
                }
              }
            </script>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
            <button type="submit" id="btnGuardar" class="btn btn-dark">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>


  <!-- EDITAR ORDEEEEEEEEEEEEEEN -->






  <style type="text/css">
    #customTableList {

      border-collapse: collapse;
      font-family: "Segoe UI", Arial, sans-serif;
      font-size: 0.75rem;
    }

    #customTableList th,
    #customTableList td {
      border: 1px solid #dee2e6;
      /* bordes para cada celda */
      padding: .5rem;
      /* espaciado dentro de cada celda */
      text-align: left;
      /* Alineación del texto a la izquierda */
    }

    #customTableList thead th {
      background-color: #f2f2f2;
      /* Color de fondo para los encabezados */
      position: sticky;
      /* Para que el encabezado sea fijo en el scroll */
      top: 0;
      /* Posición fija en la parte superior */
    }

    #customTableList tbody tr:hover {
      background-color: #e9ecef;
      /* Color de fondo al pasar el mouse */
    }

    /* Estilos para zebra striping */
    #customTableList tbody tr:nth-of-type(odd) {
      background-color: #f8f9fa;
      /* Filas de color claro */
    }

    #customTableList tbody tr:nth-of-type(even) {
      background-color: #e9ecef;
      /* Filas de color oscuro */
    }
  </style>


  <!--Modal para CRUD EDITAR ORDEN-->


  <div class="modal fade" id="modalEditarPedido" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
      <div class="modal-content microsoft-style">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">EDITAR ORDEN</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form id="editarpedido">
          <div class="modal-body">
            <div id="header_modal" style="background-color: #F2F2F2; padding: 15px; border-radius: 5px; font-size: 14px;">
              <div class="row gy-2">

                <div class="col-lg-1" name="ide_webs" id="ide_webs" style="display:none;">
                  <label for="ide_web" class="col-form-label small-text">CodWeb:</label>
                  <input type="text" class="form-control form-control-sm small-input small-text" style="background-color:#F1FFD5;" id="ide_web" name="ide_web" disabled>
                </div>
                <div class="col-lg-1">
                  <label for="ide" class="col-form-label small-text">Orden:</label>
                  <input type="text" class="form-control form-control-sm small-input small-text" id="n_orden" name="n_orden" disabled>
                </div>
                <div class="col-lg-2">
                  <label for="ide" class="col-form-label small-text">Fecha Ingreso:</label>
                  <input type="text" class="form-control form-control-sm small-input small-text" id="fecha_ingresob" name="fecha_ingresob" disabled>
                </div>
                <div class="col-lg-2">
                  <label for="ide" class="col-form-label small-text">Vendedor:</label>
                  <input type="text" class="form-control form-control-sm small-input small-text" id="vendedorb" name="vendedorb" disabled>
                </div>
                <div class="col-lg-2">
                  <label for="ide" class="col-form-label small-text">Estado de la orden:</label>
                  <input type="text" class="form-control form-control-sm small-input small-text" id="estadopedido" name="estadopedido" disabled>
                </div>
                <div class="col-lg-3" style="background-color: #FFE4E4; border-radius: 5px;padding: 5px; text-align: center;">
                  <label for="ide" class="col-form-label small-text">Esta Orden Tiene un reclamo abierto</label>

                  <button type="button" class="btn btn-primary btn-sm" id="reclamo" onclick="cerrarcaso()">Agregar Solucion</button>


                </div>


              </div>



              <div class="row gy-4">
                <div class="col-lg-4">
                  <label for="rut" class="col-form-label">Rut:</label>
                  <input type="text" class="form-control form-control-sm" id="rutb" name="rutb" disabled>
                </div>
                <div class="col-lg-4">
                  <label for="nombre" class="col-form-label">Nombre:</label>
                  <input type="text" class="form-control form-control-sm" id="nombreb" name="nombreb">
                </div>
                <style type="text/css">
                  .telefono-container {
                    position: relative;
                  }

                  .telefono-container img {
                    position: absolute;
                    top: 50%;
                    transform: translateY(-50%);
                    left: calc(100% + 2px);
                  }
                </style>
                <div class="col-lg-2">
                  <label for="telefono" class="col-form-label">Telefono:</label>
                  <div class="telefono-container">
                    <input type="text" class="form-control form-control-sm" id="telefonob" name="telefonob">
                    <a href="#" id="whatsapp-link" target="_blank">
                      <img src="img/whatsapp.png" alt="WhatsApp" width="40" id="whatsapp" data-toggle="tooltip" data-placement="right" title="Puedes hablarle al whatsapp">
                    </a>
                  </div>
                </div>

              </div>








              <div class="row gy-4">
                <div class="col-lg-2">
                  <label for="precio" class="col-form-label">Total:</label>
                  <input type="text" class="form-control form-control-sm" id="precio" name="precio">
                </div>


                <div class="col-lg-2" id="totalpagadodiv">

                  <label for="totalpagado" class="col-form-label">Total Pagado:</label>
                  <input type="text" class="form-control form-control-sm" id="totalpagado" name="totalpagado" disabled>
                </div>
                <div id="loadingIndicator" class="col-lg-4" style="display: none; padding: 20px;text-align: center;">
                  <img src="https://media.tenor.com/On7kvXhzml4AAAAj/loading-gif.gif" width="20" alt="Cargando...">
                </div>

                <div class="col-lg-3" id="calculoporpagar" style="display: none;">

                  <label for="porpagar" class="col-form-label">Por Pagar:</label>
                  <input type="text" class="form-control form-control-sm" id="porpagar" name="porpagar" disabled>
                </div>




              </div>

              <div style="margin-top: 15px; width: 90%;">
                <div class="" style="background-color:white;  padding: 10px; border-radius:5px; ">
                  <h5>Detalle de la Orden</h5>
                  <table class="table table-bordered table-hover table-striped table-sm" id="customTableList">

                    <thead>
                      <tr>
                        <th scope="col">ID Producto</th>
                        <th scope="col">Producto</th>
                        <th scope="col">Cant</th>
                        <th scope="col">Direccion de entrega</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Referencia Pago</th>
                        <th scope="col">Fecha entrega</th>
                        <th scope="col">Estado</th>

                      </tr>
                    </thead>
                    <tbody>
                      <!-- Filas de Ejemplo -->
                      <tr>
                        <td>0123</td>
                        <td>Respaldo de cama</td>
                        <td>1</td>
                        <td>Av Gabriela 02861,dpto 21, La Pintana, Santiago</td>
                        <td>65000</td>
                        <td>00001</td>
                        <td>01/01/2024</td>
                        <td>Entregado</td>
                      </tr>
                      <tr>
                        <td>0123</td>
                        <td>Respaldo de cama</td>
                        <td>1</td>
                        <td>Av Gabriela 02861, La Pintana, Santiago</td>
                        <td>65000</td>
                        <td>00001</td>
                        <td>01/01/2024</td>
                        <td>Entregado</td>

                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>


              <div style="margin-top: 15px; width: 90%;">
                <!-- Detalle de pagos TableList -->
                <div class="" style="background-color:white;  padding: 10px; border-radius:5px; ">
                  <h5>Detalle de Pagos</h5>
                  <table class="table table-bordered table-hover table-striped table-sm" id="customTableList">

                    <thead>
                      <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Monto</th>
                        <th scope="col">Método</th>
                        <th scope="col">Referencia</th>
                      </tr>
                    </thead>
                    <tbody>
                      <!-- Filas de Ejemplo -->
                      <tr>
                        <td>00001</td>
                        <td>01/01/2024</td>
                        <td>$1000</td>
                        <td>Transferencia</td>
                        <td>Ref123456</td>
                      </tr>
                      <tr>
                        <td>00002</td>
                        <td>02/01/2024</td>
                        <td>$500</td>
                        <td>Tarjeta de Crédito</td>
                        <td>Ref654321</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>

         



              <div class="row gy-2">
                <div class="col-lg-8">
                  <label for="comentarios" class="col-form-label">Observaciones internas:</label>
                  <input type="text" class="form-control form-control-sm" id="comentarios" name="comentarios">
                </div>

              </div>

              <div style="margin-bottom: 5px;margin-top: 10px;">
                <button type="button" class="btn btn-primary" id="toggleDetailsBtn" onclick="toggleDetails()">Mostrar detalles</button>
                <script type="text/javascript">
                  var num_orden = $("#num_orden").val();
                </script>
                <button type="button" id="botonPDF" class="btn btn-success botonPDF">Generar PDF</button>
                <br><br>
                <small class="text-muted">*MENSAJE INFORMATIVO:.</small>
              </div>

              <div id="detailsContainer" style="display: none; font-size: 14px; ">
                <!-- Aquí se agregarán los detalles de forma dinámica -->
              </div>

             
            </div>


          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
            <button type="submit" id="btnGuardar" class="btn btn-dark">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script type="text/javascript">


function cargarPagosAsociados(numOrden) {
                                        $.ajax({
                                            url: 'rbot/buscarPagos.php', // La URL de tu servidor que devuelve los pagos asociados
                                            type: 'GET',
                                            data: {
                                                criterio: "por_n_orden",
                                                valor: numOrden
                                            },
                                            dataType: 'json',
                                            success: function(pagos) {
                                                var tabla = $('#paymentTable tbody');
                                                tabla.empty(); // Limpiar la tabla antes de agregar nuevos datos
                                                pagos.forEach(function(pago) {
                                                    var fila = `<tr>
                                <td>${pago.id_mostrar}</td>
                                <td>${pago.fecha}</td>
                                <td>${pago.rut}</td>
                                <td>${pago.nombre}</td>
                                <td>${pago.banco}</td>
                                <td>${pago.numero}</td>
                                <td>${pago.monto}</td>
                                <td>${pago.detalle}</td>
                                <td><button type="button" onclick="desasociarPago(this, ${pago.id}, ${pago.id_cartola})" class="btn btn-danger btn-sm">Desasociar</button></td>
                            </tr>`;
                                                    tabla.append(fila);
                                                });
                                            },
                                            error: function() {
                                                console.error('Error al obtener los pagos asociados');
                                            }
                                        });
                                    }



    function calcularPorPagarTermino() {

      // Obtener los valores de los campos "precio" y "abono"
      var precio = parseFloat($("#precio").val());
      var abono = parseFloat($("#abono").val());

      if (isNaN(abono)) {
        // Si el valor de "abono" no es numérico, mostrar el precio en el campo "porpagar"
        $("#porpagar").val(precio);
      } else {
        // Calcular el resultado de la resta
        var porPagar = precio - abono;

        // Actualizar el valor del campo "porpagar"

        $("#porpagar").val(porPagar);

      }

    }


    $(document).ready(function() {
      function mostrarCargando() {
        $("#calculoporpagar").hide(); // Mostrar el GIF de carga
        $("#loadingIndicator").show(); // Mostrar el GIF de carga



      }

      // Función para ocultar el GIF de carga
      function ocultarCargando() {
        $("#loadingIndicator").hide();
        $("#calculoporpagar").show(); // Ocultar el GIF de carga
      }
      // Función para calcular y actualizar el campo "porpagar"
      function calcularPorPagar() {

        mostrarCargando();
        // Obtener los valores de los campos "precio" y "abono"
        var precio = parseFloat($("#precio").val());
        var abono = parseFloat($("#abono").val());
        var costo_envio = parseFloat($("#costo_envio").val());
        if (isNaN(abono)) {
          // Si el valor de "abono" no es numérico, mostrar el precio en el campo "porpagar"
          $("#porpagar").val(precio);
        } else {
          // Calcular el resultado de la resta
          var porPagar = precio + costo_envio - abono;

          // Actualizar el valor del campo "porpagar"

          $("#porpagar").val(porPagar);

        }
        setTimeout(ocultarCargando, 800);
      }
      $('[data-toggle="tooltip"]').tooltip();





      // Vincular eventos al abrir el modal
      function abrirModal() {
        $('#whatsapp').tooltip('show');
        setTimeout(function() {
          $('#whatsapp').tooltip('hide');
        }, 3000);
        // Llamar a la función para calcular y actualizar el campo "porpagar"
        calcularPorPagar();

      }

      // Vincular eventos al cerrar el modal
      function cerrarModal() {


      }

      // Desvincular eventos antes de volver a vincularlos
      $('#modalEditarPedido').off('shown.bs.modal', abrirModal);
      $('#modalEditarPedido').off('hide.bs.modal', cerrarModal);

      // Vincular eventos al abrir y cerrar el modal
      $('#modalEditarPedido').on('shown.bs.modal', abrirModal);
      $('#modalEditarPedido').on('hide.bs.modal', cerrarModal);




    });
  </script>


  <script type="text/javascript">
    function toggleDetails() {
      var detailsContainer = document.getElementById("detailsContainer");
      var toggleBtn = document.getElementById("toggleDetailsBtn");

      if (detailsContainer.style.display === "none") {
        detailsContainer.style.display = "block";
        toggleBtn.innerText = "Ocultar Detalles";
      } else {
        detailsContainer.style.display = "none";
        toggleBtn.innerText = "Mostrar Detalles";
      }
    }
  </script>

  <script>
    // Obtener el elemento del campo de teléfono
    var telefonoInput = document.getElementById("telefonob");

    // Obtener el elemento del enlace de WhatsApp
    var whatsappLink = document.getElementById("whatsapp-link");

    // Agregar un evento de clic al enlace de WhatsApp
    whatsappLink.addEventListener("click", function(event) {
      // Obtener el número de teléfono del campo de entrada
      var telefono = telefonoInput.value;

      // Construir la URL del enlace de WhatsApp con el número de teléfono
      var url = "https://api.whatsapp.com/send/?phone=+56" + telefono + "&text=Hola! te escribimos de respaldos chile ";

      // Establecer la URL del enlace de WhatsApp
      whatsappLink.href = url;
    });
  </script>