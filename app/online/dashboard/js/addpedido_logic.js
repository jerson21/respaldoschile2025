// ------------ INICIO: Variables Globales y Lógica de Pedidos (No depende de Maps) -----------
let pedidos = [];
let geocoder; // Declarar fuera para que sea accesible
let autocomplete; // Declarar fuera para que sea accesible

function agregarPedido(pedido) {
    pedidos.push(pedido); // Añade el nuevo pedido al array
}

function capturarDatosDelPedido() {
    let pedido = {
        producto: $("#modelo").val() ?? "",
        tamano: $("#plazas").val() ?? "",
        material: $("#listatelas").val() ?? "",
        color: $("#lista2").val() ?? "",
        cantidad: $("#cantidad").val() ?? "",
        alturaBase: $("#alturabase").val() ?? "",
        detallesFabricacion: $("#detalles_fabricacion").val() ?? "",
        boton: $('input[name="boton"]:checked').val() ?? "",
        anclaje: $('input[name="anclaje"]:checked').val() ?? "",
        anclajeMetal: $('input[name="anclajemetal"]:checked').val() ?? "",
        precio: 0
    };
    agregarPedido(pedido);
    mostrarPedidosAgregados();
}

function mostrarPedidosAgregados() {
    let pedidosHtml = pedidos.map((pedido, index) => `
    <div class="pedido-agregado">
      <div class="cerrar-pedido" data-index="${index}">X</div>
      <div class="pedido-detalle">
        <h4>Pedido ${index + 1}</h4>
        <p><b>Producto:</b> ${pedido.producto} <b>Tamaño:</b> ${pedido.tamano} </p>
        <p><b>Material:</b> ${pedido.material} <b>Color:</b> ${pedido.color}</p>
        <p><b>Altura Base:</b> ${pedido.alturaBase} </p>
        <p><b>Detalles:</b> ${pedido.detallesFabricacion}</p>
      </div>
      <div class="pedido-precios">
        <div class="form-group">Valores:</div>
        <div class="form-group">
          <label for="precio-${index}"><b>Precio:</b> </label>
          <input type="number" class="form-control precio-input" name="precio[${index}]" id="precio-${index}" data-index="${index}" placeholder="Precio" value="${pedido.precio || ''}">
        </div>
        <div class="form-group col-md-6">
          <label><b>Cantidad:</b> </label><input class="form-control" value="${pedido.cantidad}" disabled></input>
        </div>
      </div>
    </div>
    `).join('');

    document.getElementById('pedidosAgregados').innerHTML = pedidosHtml;

    // Volver a añadir evento change a los inputs de precio CADA VEZ que se redibujan
    $('.precio-input').off('change').on('change', function() { // Usar .off().on() para evitar duplicados
        let index = $(this).data('index');
        let nuevoPrecio = parseFloat($(this).val()) || 0;
        if (pedidos[index]) { // Verificar que el pedido exista en el índice
           pedidos[index].precio = nuevoPrecio; // Actualiza el precio en el array
        }
        actualizarValorTotal(); // Recalcula el total
    });

    // Asegurarse que el evento del despacho también se actualice si es necesario
    // Si #valorDespacho está fuera de la sección que se redibuja, esto puede estar en $(document).ready()
    // $('.valorDespacho').off('change').on('change', function() {
    //    actualizarValorTotal(); // Recalcula el total
    // });

    actualizarValorTotal(); // Actualizar total al mostrar/redibujar
}


function actualizarValorTotal() {
    let totalProductos = pedidos.reduce((acc, pedido) => {
        // Asegurarse que precio y cantidad son números
        const precio = parseFloat(pedido.precio) || 0;
        const cantidad = parseInt(pedido.cantidad) || 1; // Asumir 1 si no hay cantidad o es inválida
        return acc + (precio * cantidad);
    }, 0);

    let valorDespacho = parseFloat($('#valorDespacho').val()) || 0;
    let totalGeneral = totalProductos + valorDespacho;
    $('#valorTotal').val(totalGeneral.toFixed(0)); // Actualiza el input de valor total
}

// ------------ FIN: Lógica de Pedidos -----------


// ------------ INICIO: Código dependiente de jQuery y DOM Ready (No Maps) -----------
$(document).ready(function() {

    // Listener para eliminar pedidos
    $('#pedidosAgregados').on('click', '.cerrar-pedido', function() {
        const index = $(this).data('index');
        pedidos.splice(index, 1);
        mostrarPedidosAgregados(); // Vuelve a renderizar y recalcular
    });

     // Listener para cambio en valor de despacho (si existe fuera de la seccion redibujada)
     $('#valorDespacho').on('change', function() { // Mover aquí si #valorDespacho no se redibuja
        actualizarValorTotal();
     });

    // Lógica de pasos del formulario
    var current = 1,
        current_step, next_step, steps;
    steps = $("fieldset").length;

    $(".next").click(function() {
        current_step = $(this).parent();

        if (current == 2 && validarPasoActual(current_step)) {
            swal.fire({
                title: '¿Desea agregar otro pedido?',
                text: "Puede agregar más productos a esta orden.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, agregar otro',
                cancelButtonText: 'No, continuar'
            }).then((result) => {
                capturarDatosDelPedido(); // Captura siempre los datos del paso actual
                if (result.isConfirmed) {
                    // Limpiar campos del paso 2 para nuevo pedido
                    $("#modelo, #plazas, #listatelas, #lista2, #cantidad, #alturabase, #detalles_fabricacion").val('');
                    // Resetear radios/checkbox si es necesario
                    $('input[name="boton"], input[name="anclaje"], input[name="anclajemetal"]').prop('checked', false);
                     $("#formularios").hide(); // Asumiendo que esto resetea algo visual
                     $('#status').val(''); // Asumiendo que esto resetea algo visual
                    // NO avanzar de paso: current no se incrementa
                    // Quizás enfocar el primer campo del pedido de nuevo
                     $("#modelo").focus();
                } else {
                    // El usuario elige continuar al siguiente paso
                    next_step = current_step.next();
                    next_step.show();
                    current_step.hide();
                    setProgressBar(++current);
                    $("#formularios").hide(); // Asumiendo que esto resetea algo visual
                    $('#status').val(''); // Asumiendo que esto resetea algo visual
                }
            });
        } else if (validarPasoActual(current_step)) {
            // Caso especial para paso 3 o lógica específica
             if (current == 3) {
                console.log("Avanzando desde el paso 3");
                // Asegurar que el valor total está calculado antes de avanzar
                actualizarValorTotal();
            }
            // Avanzar normal
            next_step = current_step.next();
            if (next_step.length) {
                 next_step.show();
                 current_step.hide();
                 setProgressBar(++current);
            } else {
                 console.log("Último paso alcanzado o no hay next_step");
                 // Probablemente aquí se maneja el envío final si no hay más pasos
            }

        } else {
             // Validación fallida
             swal.fire("", "Por favor, complete todos los campos requeridos antes de continuar.", "warning");
        }
    });


    $(".previous").click(function() {
        current_step = $(this).parent();
        next_step = current_step.prev();
        next_step.show();
        current_step.hide();
        setProgressBar(--current);
    });

    setProgressBar(current);

    // Envío del formulario principal
    $("#formular").on('submit', function(evt) {
        evt.preventDefault();
        console.log("Intentando enviar formulario...");

        // Asegurar que el último pedido (si está en paso 2) se capture antes de enviar
        if ($("fieldset:visible").is(current_step) && current == 2) {
             capturarDatosDelPedido(); // Captura el último pedido
        }
        // Asegurar que el valor total está actualizado
        actualizarValorTotal();

        // Convertir el array de pedidos a JSON
        var pedidosJson = JSON.stringify(pedidos);
        $('#pedidosJson').val(pedidosJson); // Asignar a input oculto

        // (Tu lógica AJAX para enviar el formulario...)
        if ($("#formular")[0].checkValidity()) {
             console.log("Formulario válido, enviando AJAX...");
              $.ajax({
                  url: "formularios/agregarpedido2024.php",
                  type: "POST",
                  data: $("#formular").serialize(),
                  dataType: "json",
                  success: function(res) {
                     console.log("Respuesta AJAX:", res);
                     var div = document.getElementById('contenidoDinamico');
                      if (res.success) {
                         var nuevoContenido = `<h2>Pedido Ingresado Con Éxito!</h2><p>Tu información ha sido recibida correctamente.</p><a href='addpedido.php' class='btn btn-success btn-sm'>Agregar un nuevo pedido</a>`;
                         div.innerHTML = nuevoContenido;

                         // Avanzar al último paso visualmente (si existe)
                         current_step = $("fieldset:visible");
                         next_step = current_step.next("fieldset"); // Buscar un fieldset de "éxito"
                         if (next_step.length) {
                             current_step.hide();
                             next_step.show();
                             setProgressBar(++current); // Actualizar barra si hay más pasos
                         }

                         Swal.fire({
                             title: 'Pedido Ingresado con éxito',
                             icon: 'success',
                             confirmButtonText: 'Finalizar Pedido',
                             confirmButtonColor: '#fd7e14',
                             showCloseButton: true,
                             focusConfirm: false,
                              html:` Vendedor: ${res.vendedor}<br>
                                     Numero de Pedido: ${res.lastid}<br>
                                     Numero de Orden: ${res.nuevoregistroorden}<br>
                                    <div style='text-align: center; margin-bottom: 1.5rem; margin-top: 1rem;'>
                                       <button type='button' class='btn btn-success btn-sm btnAddPagoMOD' data-id='${res.nuevoregistroorden}' style='--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;' >Ingresar Pagos</button>
                                    </div>
                                    <div style='text-align:center; '>
                                      <a href='addpedido.php' class='btn btn-success btn-sm'>Agregar un nuevo pedido</a>
                                    </div>`,
                             allowOutsideClick: false
                         }).then((result) => {
                             if (result.isConfirmed) {
                                 Swal.fire({
                                     title: 'Pedido finalizado',
                                     text: 'El pedido se ha finalizado correctamente',
                                     icon: 'success',
                                     html: `<div style='text-align:center; margin-top: 10px;'>
                                              <a href='reportes/pedido.php?id=${res.nuevoregistroorden}' class='btn btn-primary btn-sm' target='_blank'>Imprimir Comprobante</a>
                                           </div> `,
                                     showConfirmButton: true,
                                     allowOutsideClick: false
                                 }).then(() => {
                                      // Opcional: Redireccionar o resetear
                                     // window.location.href = `finalizar_pedido.php?id=${res.nuevoregistroorden}`;
                                     // O quizás simplemente recargar la página de añadir pedido
                                      window.location.href = 'addpedido.php';
                                 });
                             }
                         });

                      } else {
                         // Manejo de error desde el servidor
                         var nuevoContenido = `<h2>Error ingresando pedido!</h2><p>${res.message || 'Vuelva a intentarlo.'}</p><a href='addpedido.php' class='btn btn-success btn-sm'>Reintentar</a>`;
                         div.innerHTML = nuevoContenido;
                         Swal.fire('Error', res.message || 'Ocurrió un error al guardar el pedido.', 'error');
                          // No avanzar de paso en caso de error
                      }
                  },
                  error: function(xhr, status, error) {
                      console.error("Error en AJAX:", status, error, xhr.responseText);
                      Swal.fire('Error de Comunicación', 'No se pudo contactar al servidor. Verifica tu conexión e intenta de nuevo.', 'error');
                      // Mostrar mensaje de error genérico en contenidoDinamico
                      var div = document.getElementById('contenidoDinamico');
                      var nuevoContenido = `<h2>Error de Comunicación!</h2><p>No se pudo enviar la información.</p><a href='addpedido.php' class='btn btn-warning btn-sm'>Reintentar</a>`;
                      div.innerHTML = nuevoContenido;
                  }
              });
          } else {
             console.log("Formulario inválido.");
             Swal.fire('', 'El formulario no es válido. Revisa los campos marcados.', 'error');
          }
    });


    // Lógica Checkbox retiro tienda
    var retiroTiendaCheckbox = document.getElementById('retiro_tienda');
    var datosDireccionDiv = document.getElementById('direccionymapa');
    var detalleRetiroDiv = document.getElementById('detalleretiro'); // Asegúrate que este ID existe

    if (retiroTiendaCheckbox) {
        retiroTiendaCheckbox.addEventListener('change', function() {
            if (retiroTiendaCheckbox.checked) {
                swal.fire("", "Cliente retira en tienda, debes especificar la fecha de retiro", "info");
                if (datosDireccionDiv) datosDireccionDiv.style.display = 'none';
                if (detalleRetiroDiv) detalleRetiroDiv.style.display = 'block';
                 // Hacer campos de dirección NO requeridos
                 $('#search_input, #street_name, #street_number, #comunas, #regiones').prop('required', false);
            } else {
                if (datosDireccionDiv) datosDireccionDiv.style.display = 'block';
                if (detalleRetiroDiv) detalleRetiroDiv.style.display = 'none';
                 // Hacer campos de dirección SI requeridos (si aplica)
                 $('#search_input, #street_name, #street_number, #comunas, #regiones').prop('required', true); // Ajusta según necesidad real
            }
        });
        // Estado inicial al cargar la página
        if (retiroTiendaCheckbox.checked) {
             if (datosDireccionDiv) datosDireccionDiv.style.display = 'none';
             if (detalleRetiroDiv) detalleRetiroDiv.style.display = 'block';
             $('#search_input, #street_name, #street_number, #comunas, #regiones').prop('required', false);
        } else {
             if (datosDireccionDiv) datosDireccionDiv.style.display = 'block';
             if (detalleRetiroDiv) detalleRetiroDiv.style.display = 'none';
              $('#search_input, #street_name, #street_number, #comunas, #regiones').prop('required', true); // Ajusta según necesidad real
        }
    }


    // Lógica Select de Telas y Colores
    vincularEventosASelect(); // Llamar a la función que vincula eventos
    recargarLista(); // Cargar lista inicial de colores si es necesario
    recargarListaImg(); // Cargar imagen inicial si es necesario

});
// ------------ FIN: Código dependiente de jQuery y DOM Ready (No Maps) -----------


// Crear una barra de línea con estilos modernos
let currentStep = 0;
const totalSteps = 5;

function setProgress(step) {
    currentStep = step;
    updateProgressBar();
}

function nextStep() {
    if (currentStep < totalSteps) {
        currentStep++;
        updateProgressBar();
    }
}

function updateProgressBar() {
    const percentage = (currentStep / totalSteps) * 100;
    
    // Actualizar elementos visuales
    document.querySelector('.progress-fill').style.width = `${percentage}%`;
    document.querySelector('.progress-glow').style.width = `${percentage}%`;
    document.querySelector('.progress-percentage').textContent = `${Math.round(percentage)}%`;
    document.querySelector('.progress-steps').textContent = `Step ${currentStep} of ${totalSteps}`;
    
    // Cambiar colores según el progreso
    if (percentage >= 100) {
        document.querySelector('.progress-fill').style.background = 'linear-gradient(90deg, #34c759, #30d158)';
        document.querySelector('.progress-glow').style.background = 'linear-gradient(90deg, rgba(52, 199, 89, 0.5), rgba(48, 209, 88, 0.5))';
        document.querySelector('.progress-percentage').style.color = '#34c759';
    } else {
        document.querySelector('.progress-fill').style.background = 'linear-gradient(90deg, #007aff, #5ac8fa)';
        document.querySelector('.progress-glow').style.background = 'linear-gradient(90deg, rgba(0, 122, 255, 0.5), rgba(90, 200, 250, 0.5))';
        document.querySelector('.progress-percentage').style.color = '';
    }
}

// Para adaptarlo a tu implementación existente
function setProgressBar(curStep) {
    setProgress(curStep);
}

function validarPasoActual(step) {
    var isValid = true;
    // Asegurarse de no validar campos ocultos (como los de dirección si está activo retiro en tienda)
    $(step).find("input:visible[required], select:visible[required], textarea:visible[required]").each(function() {
        var $this = $(this);
        // Quitar espacios en blanco y validar
        if ($this.val().trim() === "") {
             isValid = false;
             $this.addClass('is-invalid').removeClass('is-valid'); // Marcar como inválido
             // Intentar encontrar un div de error asociado
             $this.siblings('.invalid-feedback').show(); // Mostrar mensaje si existe
        } else {
             $this.removeClass('is-invalid').addClass('is-valid'); // Marcar como válido
             $this.siblings('.invalid-feedback').hide(); // Ocultar mensaje si existe
        }
    });

    // Añadir validación específica para RUT si está en el paso actual
     if ($(step).find("#rut").length > 0 && $(step).find("#rut").is(':visible')) {
        if (!checkRutSilent($("#rut")[0])) { // Usar una versión silenciosa si no quieres alertas duplicadas
           isValid = false;
           $("#rut").addClass('is-invalid').removeClass('is-valid');
        } else {
           $("#rut").removeClass('is-invalid').addClass('is-valid');
        }
     }

     // Puedes añadir más validaciones específicas aquí

    return isValid;
}


function noPuntoComa(event) {
    var e = event || window.event;
    var key = e.keyCode || e.which;
    if (key === 110 || key === 190 || key === 188) { // '.', ',', numpad '.'
        e.preventDefault();
    }
}

// Rut Validation Functions (checkRut, validarRut, etc.) - Sin cambios aparentes necesarios
function checkRut(rutInput) { // Recibe el elemento input
    if (!rutInput) return false; // Salir si no hay input
    // Ocultar iconos al inicio de la validación
    $("#iconoCheck, #iconoCross").hide();

    var valor = rutInput.value.replace(/\./g, ''); // Quitar todos los puntos
    valor = valor.replace('-', ''); // Quitar guión
    if (valor.length === 0) {
        rutInput.setCustomValidity(""); // Limpiar validación si está vacío
        $(rutInput).removeClass('is-invalid is-valid');
         $("#msgerror, #msgvalido").html("");
        return false; // No validar si está vacío
    }

    let cuerpo = valor.slice(0, -1);
    let dv = valor.slice(-1).toUpperCase();

    // Formatear mientras escribe (opcional, puede ser conflictivo con la validación)
    // rutInput.value = cuerpo + '-' + dv; // Comentado temporalmente

     if (cuerpo.length < 7) {
         rutInput.setCustomValidity("RUT Incompleto");
         $(rutInput).addClass('is-invalid').removeClass('is-valid');
         $("#msgerror").html("RUT Incompleto");
         $("#msgvalido").html("");
         $("#iconoCross").show();
         return false;
     }

    let suma = 0;
    let multiplo = 2;
    for (let i = 1; i <= cuerpo.length; i++) {
        let index = multiplo * valor.charAt(cuerpo.length - i);
        suma += index;
        multiplo = (multiplo < 7) ? multiplo + 1 : 2;
    }

    let dvEsperado = 11 - (suma % 11);
    dv = (dv == 'K') ? 10 : (dv == '0' ? 11 : parseInt(dv)); // Ajustar para '0'

     if (dvEsperado != dv) {
         rutInput.setCustomValidity("RUT Inválido");
         $(rutInput).addClass('is-invalid').removeClass('is-valid');
         $("#msgerror").html("RUT Inválido");
         $("#msgvalido").html("");
         $("#iconoCross").show();
         return false;
     }

    // RUT Válido
    rutInput.setCustomValidity(''); // Importante limpiar la validación custom
    $(rutInput).removeClass('is-invalid').addClass('is-valid');
    $("#msgerror").html("");
    $("#msgvalido").html("RUT válido!");
    $("#iconoCheck").show();

    // Formatear el valor AHORA que es válido
    rutInput.value = cuerpo.replace(/\B(?=(\d{3})+(?!\d))/g, "") + '-' + (dv == 10 ? 'K' : (dv == 11 ? '0' : dv));


    // Llamar a las consultas AJAX si el RUT es válido
    var rutcompleto = rutInput.value; // Usar el valor formateado
    consultarCliente(rutcompleto);
    consultarpedidoexistente(rutcompleto);

    return true;
}
// Versión silenciosa para validación interna sin cambiar UI tanto
 function checkRutSilent(rutInput) {
     if (!rutInput) return false;
     var valor = rutInput.value.replace(/\./g, '').replace('-', '');
     if (valor.length === 0) return true; // Vacío es "válido" en este contexto
     let cuerpo = valor.slice(0, -1);
     let dv = valor.slice(-1).toUpperCase();
     if (cuerpo.length < 7) return false;
     let suma = 0;
     let multiplo = 2;
     for (let i = 1; i <= cuerpo.length; i++) {
         suma += multiplo * valor.charAt(cuerpo.length - i);
         multiplo = (multiplo < 7) ? multiplo + 1 : 2;
     }
     let dvEsperado = 11 - (suma % 11);
     dv = (dv == 'K') ? 10 : (dv == '0' ? 11 : parseInt(dv));
     return dvEsperado == dv;
 }


// Funciones AJAX (consultarCliente, consultarpedidoexistente) - Sin cambios aparentes necesarios
function consultarpedidoexistente(rutcompleto) {
     if (!rutcompleto) return; // No consultar si no hay RUT
     $.ajax({
         url: "formularios/existe_cliente.php",
         type: "POST",
         data: { opcion: 2, id: rutcompleto },
         success: function(data) {
             if (data && data.trim().length > 0) {
                 $("#pedidoexistente").html(data); // Mostrar en div si existe
                 Swal.fire({
                     title: 'Pedidos Pendientes de Fabricación',
                     html: data,
                     width: 900,
                     icon: 'warning',
                     confirmButtonText: 'Aceptar',
                     confirmButtonColor: '#3085d6',
                     backdrop: `rgba(0,0,123,0.4) url("https://respaldoschile.cl/intranet/dashboard/img/nyan-cat.gif") left top no-repeat` // Ajustar URL si es necesario
                 });
             } else {
                 $("#pedidoexistente").html(""); // Limpiar si no hay pendientes
                 console.log("No hay pedidos pendientes existentes para este RUT.");
             }
         },
         error: function(xhr, status, error) {
             console.error("Error consultando pedidos existentes:", status, error);
             // Podrías mostrar un pequeño mensaje no intrusivo
             // $("#pedidoexistente").html("<small class='text-danger'>Error al consultar pendientes.</small>");
         }
     });
 }


function consultarCliente(rutcompleto) {
     if (!rutcompleto) return; // No consultar si no hay RUT
     $.ajax({
         url: "formularios/existe_cliente.php",
         type: "POST",
         data: { opcion: 1, id: rutcompleto },
         dataType: "json", // Esperar JSON directamente
         success: function(usuarios) { // 'usuarios' ya es un objeto/array JS
             console.log("Datos cliente:", usuarios);
             if (!usuarios || usuarios.length === 0) {
                 // Cliente no encontrado o error en respuesta
                 console.log("Cliente no encontrado en la base de datos.");
                 // Limpiar campos, EXCEPTO el RUT que ya es válido
                 $("#name, #telefono, #email, #search_input, #street_name, #street_number, #dpto, #instagram, #comunas, #regiones").val("");
                 $("#clienteexisterut").val(""); // Indicar que no existe en BD
                  // Podrías activar campos para ingreso manual
                 $("#name").prop('readonly', false); // Permitir editar nombre
             } else {
                 // Cliente encontrado, llenar campos
                 var nombre = usuarios[1] || "";
                 var telefono = usuarios[2] || "";
                 var correo = usuarios[3] || "";
                 var direccion = usuarios[4] || "";
                 var numero = usuarios[5] || "";
                 var dpto = usuarios[6] || "";
                 var instagram = usuarios[7] || "";
                 var region = usuarios[8] || "";
                 var comuna = usuarios[9] || "";
                 var externo = usuarios[10]; // si vino de rutificador

                 $("#name").val(nombre);
                 $("#clienteexisterut").val("si"); // Indicar que sí existe
                 $("#telefono").val(telefono);
                 $("#email").val(correo);
                 $("#street_name").val(direccion);
                 $("#street_number").val(numero);
                 $("#dpto").val(dpto);
                 $("#instagram").val(instagram);

                 // Llenar campos de dirección principal y separados
                 var direccion_completa = `${direccion} ${numero}, ${comuna}, ${region}`.trim().replace(/ ,/g, ',');
                 $("#search_input").val(direccion_completa);

                 // Seleccionar región y comuna (si los IDs coinciden con los valores)
                  $('#regiones').val(region);
                  // Necesitas cargar las comunas correspondientes a la región si es un select dependiente
                  // Esto usualmente requiere otra llamada AJAX o tener los datos pre-cargados
                  // Ejemplo simple (si #comunas es un input de texto):
                  $('#comunas').val(comuna);

                  // Opcional: Hacer campos no editables si vienen de la BD?
                  $("#name").prop('readonly', true); // No permitir editar nombre si ya existe? Depende de tu lógica.
             }
         },
         error: function(xhr, status, error) {
             console.error("Error consultando cliente:", status, error, xhr.responseText);
             // Limpiar campos por si acaso y permitir edición manual
             $("#name, #telefono, #email, #search_input, #street_name, #street_number, #dpto, #instagram, #comunas, #regiones").val("");
             $("#clienteexisterut").val("");
             $("#name").prop('readonly', false);
         }
     });
}

// Funciones Selects dependientes (recargarLista, recargarListaImg) - Sin cambios aparentes
function vincularEventosASelect() {
    $('#listatelas').change(function() {
        recargarLista();
        recargarListaImg();
    });
     // $("#select2lista").change(function() { /* hacer algo al cambiar color? */ });
}

function recargarLista() { // Carga colores según tela
     $.ajax({
         type: "POST",
         url: "formularios/datos.php", // Asumo que este devuelve <option> HTML
         data: { colores: $('#listatelas').val() }, // Mejor enviar como objeto
         success: function(r) {
             $('#select2lista').html(r); // Rellena el select de colores
         },
         error: function(xhr, status, error) {
             console.error("Error cargando lista de colores:", status, error);
             $('#select2lista').html('<option value="">Error al cargar</option>');
         }
     });
 }


function recargarListaImg() { // Carga imagen según tela
     $.ajax({
         data: { color: $('#listatelas').val() }, // ¿No debería ser 'tela' en lugar de 'color'?
         url: 'formularios/ajax_colores.php', // Asumo devuelve <img> HTML
         type: 'post',
         dataType: 'html', // Esperar HTML
         success: function(datahtml) {
             $("#imagencolor").html(datahtml);
         },
         error: function(xhr, status, error) {
             console.error("Error cargando imagen de color:", status, error);
              $("#imagencolor").html('<p class="text-danger">Error al cargar imagen</p>');
         }
     });
 }

// ------------ FIN: Funciones Utilitarias (No Maps) -----------


// ------------ INICIO: Google Maps Geocoding y Polygon Check -----------
var poligonoCoordenadas = [
    { lat: -33.4314581, lng: -70.7902495 }, { lat: -33.524328, lng: -70.7993944 },
    { lat: -33.6349299, lng: -70.7123172 }, { lat: -33.6352154, lng: -70.6007414 },
    { lat: -33.6060619, lng: -70.5219445 }, { lat: -33.5239525, lng: -70.524526 },
    { lat: -33.442918, lng: -70.519719 },  { lat: -33.3887578, lng: -70.5080475 },
    { lat: -33.3375201, lng: -70.5007323 }, { lat: -33.3512863, lng: -70.7005396 },
    { lat: -33.3499957, lng: -70.7510067 }, { lat: -33.3644766, lng: -70.7590746 },
    { lat: -33.3960115, lng: -70.7760681 }, { lat: -33.4314581, lng: -70.7902495 }
];

// Función de verificación dentro/fuera del polígono
function puntoDentroPoligono(point, polygon) {
    var x = point.lng, y = point.lat;
    var dentro = false;
    for (var i = 0, j = polygon.length - 1; i < polygon.length; j = i++) {
        var xi = polygon[i].lng, yi = polygon[i].lat;
        var xj = polygon[j].lng, yj = polygon[j].lat;
        var intersecta = ((yi > y) != (yj > y)) && (x < (xj - xi) * (y - yi) / (yj - yi) + xi);
        if (intersecta) dentro = !dentro;
    }
    return dentro;
}

// Función que usa el Geocoder (necesita que 'geocoder' esté inicializado)
function verificarUbicacion(direccion) {
    var inputElement = document.getElementById('search_input');
    var resultElement = document.getElementById('result');
    if (!geocoder) {
         console.error("Geocoder no inicializado.");
         if(resultElement) resultElement.textContent = 'Error: Servicio de geocodificación no disponible.';
         return;
    }
     if (!resultElement) {
        console.warn("Elemento con ID 'result' no encontrado para mostrar mensaje.");
    }

    geocoder.geocode({ address: direccion }, function(results, status) {
        if (status === google.maps.GeocoderStatus.OK && results && results.length > 0) {
            var ubicacion = results[0].geometry.location;
            var point = { lat: ubicacion.lat(), lng: ubicacion.lng() };
            var dentroPoligono = puntoDentroPoligono(point, poligonoCoordenadas);

            if (inputElement) { // Verificar si el input existe
               $(inputElement).removeClass('input-inside input-outside'); // Limpiar clases previas
               $(inputElement).addClass(dentroPoligono ? 'input-inside' : 'input-outside');
            }
            if (resultElement) { // Verificar si el div de resultado existe
               resultElement.textContent = dentroPoligono ?
                  'La ubicación está dentro del rango de precio estándar.' :
                  'La ubicación está fuera del precio estándar.';
                resultElement.className = dentroPoligono ? 'text-success' : 'text-danger'; // Añadir clases para color
            }
        } else {
            console.error('Geocode falló por: ' + status);
             if (inputElement) $(inputElement).removeClass('input-inside').addClass('input-outside'); // Marcar como fuera si falla
             if (resultElement) {
                 resultElement.textContent = 'No se pudo verificar la dirección. Estado: ' + status;
                 resultElement.className = 'text-danger';
             }
        }
    });
}
// ------------ FIN: Google Maps Geocoding y Polygon Check -----------


// ------------ INICIO: Función de Callback de Google Maps API -----------
// Esta es la función que se llama DESPUÉS de que la API de Maps se cargue
// gracias a &callback=initMap en la URL del script de la API
function initMap() {
    console.log("Google Maps API cargada. Inicializando componentes...");

    // 1. Inicializar Geocoder
    try {
       geocoder = new google.maps.Geocoder();
    } catch (e) {
       console.error("Error inicializando Geocoder:", e);
       // Mostrar error al usuario si es crítico
       $('#result').text("Error al cargar el servicio de direcciones.").addClass('text-danger');
       return; // Detener si falla Geocoder
    }


    // 2. Inicializar Autocomplete para #search_input
    var searchInput = document.getElementById('search_input');
    if (searchInput) {
         try {
             // *** NOTA: Sigue usando el Autocomplete DEPRECADO ***
             // Deberías migrar a PlaceAutocompleteElement cuando sea posible
             // Ver: https://developers.google.com/maps/documentation/javascript/reference/places-widget#PlaceAutocompleteElement
             autocomplete = new google.maps.places.Autocomplete(searchInput, {
                 types: ['geocode'],
                 // Restringir a Chile (opcional pero recomendado)
                 componentRestrictions: { country: 'CL' }
             });

             // Variables para los campos a rellenar (asegúrate que los IDs existen)
             var locLatInput = document.getElementById('loc_lat');
             var locLongInput = document.getElementById('loc_long');
             var streetNumberInput = document.getElementById('street_number');
             var streetNameInput = document.getElementById('street_name');
             var comunaInput = document.getElementById('comunas'); // Puede ser input text o select
             var regionInput = document.getElementById('regiones'); // Puede ser input text o select
             var latitudeView = document.getElementById('latitude_view'); // Para mostrar lat/lng
             var longitudeView = document.getElementById('longitude_view'); // Para mostrar lat/lng

              // Listener para cuando se selecciona una dirección
              google.maps.event.addListener(autocomplete, 'place_changed', function() {
                  var place = autocomplete.getPlace();
                  if (!place || !place.geometry) {
                      console.log("Autocomplete no retornó una geometría para:", searchInput.value);
                      // Podrías limpiar campos o mostrar un aviso
                      return;
                  }

                  // Llenar Lat/Lng (ocultos y visibles)
                  if(locLatInput) locLatInput.value = place.geometry.location.lat();
                  if(locLongInput) locLongInput.value = place.geometry.location.lng();
                  if(latitudeView) latitudeView.textContent = place.geometry.location.lat();
                  if(longitudeView) longitudeView.textContent = place.geometry.location.lng();

                  // Extraer componentes de dirección
                  var streetNumber = "";
                  var streetName = "";
                  var comuna = "";
                  var region = "";
                  if(place.address_components){
                      for (var i = 0; i < place.address_components.length; i++) {
                          var component = place.address_components[i];
                          var componentType = component.types[0];

                          if (componentType === 'street_number') {
                              streetNumber = component.long_name;
                          } else if (componentType === 'route') {
                              streetName = component.long_name;
                          } else if (componentType === 'locality' || componentType === 'administrative_area_level_3') {
                               // 'locality' a veces es la comuna, a veces 'administrative_area_level_3'
                              comuna = component.long_name;
                          } else if (componentType === 'administrative_area_level_1') {
                              region = component.long_name;
                          }
                      }
                  }

                  // Llenar campos del formulario
                  if(streetNameInput) streetNameInput.value = streetName;
                  if(streetNumberInput) streetNumberInput.value = streetNumber;
                  if(comunaInput) comunaInput.value = comuna; // Funciona si es input text
                  if(regionInput) regionInput.value = region; // Funciona si es input text

                  // Si comunaInput o regionInput son <select>, necesitarías buscar la <option>
                  // con el valor correspondiente y seleccionarla. Ejemplo:
                  // $('#comunas option').filter(function() { return $(this).text() == comuna; }).prop('selected', true);
                  // $('#regiones option').filter(function() { return $(this).text() == region; }).prop('selected', true);

                   // Opcional: Verificar si la dirección seleccionada está en el polígono
                   verificarUbicacion(searchInput.value);

                   // Opcional: Validar los campos llenados
                    $(streetNameInput).trigger('change').trigger('blur'); // Disparar eventos para validación si la tienes
                    $(streetNumberInput).trigger('change').trigger('blur');
                    $(comunaInput).trigger('change').trigger('blur');
                    $(regionInput).trigger('change').trigger('blur');


              }); // Fin listener place_changed

         } catch(e) {
             console.error("Error inicializando Autocomplete:", e);
             $(searchInput).prop('placeholder', 'Error al cargar autocompletado');
         }

    } else {
       console.warn("Elemento con ID 'search_input' no encontrado para Autocomplete.");
    }

    // 3. Añadir Listener al botón de verificación AHORA que Geocoder está listo
    var verificarButton = document.getElementById('verificar_button');
    if (verificarButton && searchInput) { // Asegurar que ambos existen
        verificarButton.addEventListener('click', function() {
            var direccion = searchInput.value.trim();
            if (direccion !== '') {
                verificarUbicacion(direccion);
            } else {
                 // Indicar que se necesita una dirección
                 var resultElement = document.getElementById('result');
                 if(resultElement) resultElement.textContent = 'Por favor, ingrese una dirección para verificar.';
                 $(searchInput).addClass('is-invalid'); // Marcar campo como inválido
            }
        });
    } else {
         console.warn("No se encontró el botón 'verificar_button' o el input 'search_input' para añadir el listener.");
    }

    // --- Código COMENTADO para el SEGUNDO Autocomplete (US/CA) ---
    // Si necesitas esto, descomenta y asegúrate que los IDs (#ship-address, etc.) existen
    /*
    let address1Field = document.querySelector("#ship-address");
    let address2Field = document.querySelector("#address2");
    let postalField = document.querySelector("#postcode");

    if (address1Field) {
        try {
             let autocomplete2 = new google.maps.places.Autocomplete(address1Field, {
                 componentRestrictions: { country: ["us", "ca"] },
                 fields: ["address_components", "geometry"],
                 types: ["address"],
             });
             // address1Field.focus(); // Puede ser molesto si no es el campo principal
             autocomplete2.addListener("place_changed", function() {
                 fillInAddress(autocomplete2, address1Field, address2Field, postalField);
             });
        } catch(e) {
             console.error("Error inicializando el SEGUNDO Autocomplete:", e);
        }
    } else {
         console.log("Elemento #ship-address no encontrado para el segundo autocomplete.");
    }
    */

    console.log("Inicialización de componentes de Google Maps completada.");

} // ------------ FIN: Función initMap() -----------


// --- Código COMENTADO para la función del SEGUNDO Autocomplete (US/CA) ---
/*
function fillInAddress(autocompleteInstance, addr1Field, addr2Field, postField) {
     const place = autocompleteInstance.getPlace();
     if (!place || !place.address_components) {
         console.warn("fillInAddress: No place data received.");
         return;
     }

     let address1 = "";
     let postcode = "";

     for (const component of place.address_components) {
         const componentType = component.types[0];
         switch (componentType) {
             case "street_number":
                 address1 = `${component.long_name} ${address1}`;
                 break;
             case "route":
                 address1 += component.short_name;
                 break;
             case "postal_code":
                 postcode = component.long_name; // Asignar código postal principal
                 break;
             case "postal_code_suffix":
                 postcode = `${postcode}-${component.long_name}`;
                 break;
             case "locality":
                 // Asumiendo que tienes <input id="locality">
                 if(document.querySelector("#locality")) document.querySelector("#locality").value = component.long_name;
                 break;
             case "administrative_area_level_1":
                  // Asumiendo que tienes <input id="state">
                 if(document.querySelector("#state")) document.querySelector("#state").value = component.short_name;
                 break;
             case "country":
                  // Asumiendo que tienes <input id="country">
                 if(document.querySelector("#country")) document.querySelector("#country").value = component.long_name;
                 break;
         }
     }
     if (addr1Field) addr1Field.value = address1.trim();
     if (postField) postField.value = postcode;
     if (addr2Field) addr2Field.focus(); // Foco en la segunda línea de dirección
 }
 */

 // --- FIN CÓDIGO COMENTADO ---