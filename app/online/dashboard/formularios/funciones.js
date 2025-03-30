
function updateProgress() {
  // Define la cantidad total de campos o secciones en tu formulario
  var total = 8;
  // Calcula cuántos campos o secciones se han completado
  var completed = 0;
  if (document.getElementById("rut").value !== "") {
    completed++;
  }
  if (document.getElementById("name").value !== "") {
    completed++;
  }
  if (document.getElementById("email").value !== "") {
    completed++;
  }
  if (document.getElementById("telefono").value !== "") {
    completed++;
  }
  if (document.getElementById("direccion").value !== "") {
    completed++;
  }
  if (document.getElementById("numero").value !== "") {
    completed++;
  }
if (document.getElementById("dpto").value !== "") {
    completed++;
  }

  if (document.getElementById("comunas").value !== "") {
    completed++;
  }
  // Calcula el porcentaje completado
  var percent = (completed / total) * 100;
  // Actualiza el ancho de la barra de progreso
  document.querySelector(".progress-bar").style.width = percent + "%";
  // Agrega el porcentaje completado en el aria-valuenow del elemento
  document.querySelector(".progress-bar").setAttribute("aria-valuenow", percent);
}




                  function noPuntoComa(event) {

                      var e = event || window.event;
                      var key = e.keyCode || e.which;

                      if ( key === 110 || key === 190 || key === 188 ) {

                         e.preventDefault();
                      }


                  }

                  function checkRut(rut) {
    // Despejar Puntos
    var valor = rut.value.replace('.','');
    // Despejar Guión
    valor = valor.replace('-','');

    // Aislar Cuerpo y Dígito Verificador
    cuerpo = valor.slice(0,-1);
    dv = valor.slice(-1).toUpperCase();

    // Formatear RUN
    rut.value = cuerpo + '-'+ dv

    // Si no cumple con el mínimo ej. (n.nnn.nnn)
    if(cuerpo.length < 7) { rut.setCustomValidity("RUT Incompleto"); return false;}

    // Calcular Dígito Verificador
    suma = 0;
    multiplo = 2;

    // Para cada dígito del Cuerpo
    for(i=1;i<=cuerpo.length;i++) {

        // Obtener su Producto con el Múltiplo Correspondiente
        index = multiplo * valor.charAt(cuerpo.length - i);

        // Sumar al Contador General
        suma = suma + index;

        // Consolidar Múltiplo dentro del rango [2,7]
        if(multiplo < 7) { multiplo = multiplo + 1; } else { multiplo = 2; }

    }

    // Calcular Dígito Verificador en base al Módulo 11
    dvEsperado = 11 - (suma % 11);

    // Casos Especiales (0 y K)
    dv = (dv == 'K')?10:dv;
    dv = (dv == 0)?11:dv;

    // Validar que el Cuerpo coincide con su Dígito Verificador
    if(dvEsperado != dv) { rut.setCustomValidity("RUT Inválido");  $("#msgvalido").html("");
                  var rut_valido = "si";
                      $("#msgerror").html("Rut invalido, por favor verificar antes de ingresar..."); return false; }

    // Si todo sale bien, eliminar errores (decretar que es válido)
    rut.setCustomValidity('');
     $("#msgvalido").html("Rut valido!");
                      $("#msgerror").html("");
                  rutcompleto = $("#rut").val();

                  consultarCliente(rutcompleto);
                  consultarpedidoexistente(rutcompleto);





}




                  function validarRut(){
                    var Fn = {
                    // Valida el rut con su cadena completa "XXXXXXXX-X"
                    validaRut : function (rutCompleto) {
                      rutCompleto = rutCompleto.replace("‐","-");
                      if (!/^[0-9]+[-|‐]{1}[0-9kK]{1}$/.test( rutCompleto ))
                        return false;
                      var tmp   = rutCompleto.split('-');
                      var digv  = tmp[1];
                      var rut   = tmp[0];
                      if ( digv == 'K' ) digv = 'k' ;

                      return (Fn.dv(rut) == digv );
                    },
                    dv : function(T){
                      var M=0,S=1;
                      for(;T;T=Math.floor(T/10))
                        S=(S+T%10*(9-M++%6))%11;
                      return S?S-1:'k';
                    }
                  }
                  if (Fn.validaRut( $("#rut").val() )){
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

                  function consultarpedidoexistente(){
                    var rut = rutcompleto;
                    $.ajax({

                  url :"formularios/existe_cliente.php",
                  type:"POST",
                  data:{opcion:2,id:rutcompleto},
                  success:function(data){

                   $("#pedidoexistente").html(data);

                  },
                                  error:function(){

                                     alert("error");

                                  }
                  });
                  }




                    function consultarCliente(rutcompleto){
                      var rut = rutcompleto;


                      $.ajax({


                    url :"formularios/existe_cliente.php",
                    type:"POST",
                    data:{opcion:1,id:rutcompleto},
                    success:function(data){
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

                    if (usuarios.length === 0) {
                    document.getElementById("name").value="";
                    document.getElementById("telefono").value="";
                    document.getElementById("direccion").value="";
                    document.getElementById("email").value="";
                    document.getElementById("numero").value="";
                    document.getElementById("dpto").value="";
                    document.getElementById("instagram").value="";
                    document.getElementById("clienteexisterut").value="";
                    document.getElementById("comuna").innerHTML="";
                    document.getElementById("regiones").value="";

                    }else{

                    document.getElementById("name").value=nombre;
                    document.getElementById("telefono").value=telefono;
                    document.getElementById("direccion").value=direccion;
                    document.getElementById("email").value=correo;
                    document.getElementById("numero").value=numero;
                    document.getElementById("dpto").value=dpto;
                    document.getElementById("instagram").value=instagram;
                    document.getElementById("clienteexisterut").value="si";
                    document.getElementById("comuna").innerHTML="<input type='text'  name='comunas' class='form-control' value='"+comuna+"'>";
                    document.getElementById("regiones").value=region;
                    }

                    },
                                    error:function(){

                                       alert("error");

                                    }

                    });

                    }

               


   function establecerVisibilidadImagen(id, visibilidad) {
var img = document.getElementById(id);
img.style.visibility = (visibilidad ? 'visible' : 'hidden');
}




  $(document).ready(function(){
    $('#listatelas').val(1);




// recargarLista();

    $('#listatelas').change(function(){
      recargarLista();
      recargarListaImg();

    });

     $("#select2lista").change(function(){


     });
  })




  function recargarLista(){
    $.ajax({
      type:"POST",
      url:"formularios/datos.php",
      data:"colores=" + $('#listatelas').val(),

      success:function(r){

        $('#select2lista').html(r);

      }
    });
  }





      function recargarListaImg(){

      $.ajax({

                data: "color=" + $('#listatelas').val(),
                url:   'formularios/ajax_colores.php',
                type:  'post',
                datatype: 'html',
                success:function (datahtml) {


                    $("#imagencolor").html(datahtml);


                },
                error:function(){
                   alert("Error seleccionando el tipo de Tela");

                }
            });
}


    var poligonoCoordenadas = [
      { lat: -33.4314581, lng: -70.7902495 },
      { lat: -33.524328, lng: -70.7993944 },
      { lat: -33.6349299, lng: -70.7123172 },
      { lat: -33.6352154, lng: -70.6007414 },
      { lat: -33.6060619, lng: -70.5219445 },
      { lat: -33.5239525, lng: -70.524526 },
      { lat: -33.442918, lng: -70.519719 },
      { lat: -33.3887578, lng: -70.5080475 },
      { lat: -33.3375201, lng: -70.5007323 },
      { lat: -33.3512863, lng: -70.7005396 },
      { lat: -33.3499957, lng: -70.7510067 },
      { lat: -33.3644766, lng: -70.7590746 },
      { lat: -33.3960115, lng: -70.7760681 },
      { lat: -33.4314581, lng: -70.7902495 }
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
      geocoder.geocode({ address: direccion }, function(results, status) {
        if (status === google.maps.GeocoderStatus.OK && results.length > 0) {
var ubicacion = results[0].geometry.location;
var lat = ubicacion.lat();
var lng = ubicacion.lng();
var point = { lat: lat, lng: lng };
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

$(document).ready(function () {



    var searchInput = document.getElementById('search_input');
    var locLatInput = document.getElementById('loc_lat');
    var locLongInput = document.getElementById('loc_long');
    var streetNumberInput = document.getElementById('street_number');
    var streetNameInput = document.getElementById('street_name');
    var comunaInput = document.getElementById('comuna');
    var regionInput = document.getElementById('region');
    var latitudeView = document.getElementById('latitude_view');
    var longitudeView = document.getElementById('longitude_view');

    var autocomplete = new google.maps.places.Autocomplete(searchInput, {
        types: ['geocode']
    });

    google.maps.event.addListener(autocomplete, 'place_changed', function () {
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
            } else if (component.types.includes('locality')) {
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
    componentRestrictions: { country: ["us", "ca"] },
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

function validaForm(){
    // Campos de texto
    if($("#name").val() == ""){

        $("#name").focus();       // Esta función coloca el foco de escritura del usuario en el campo Nombre directamente.
        $("#name_error").html("Debe ingresar este campo");

        return false;
    }



    // Checkbox


    return true; // Si todo está correcto
}


$(document).ready(function() {
  // Esta parte del código se ejecutará automáticamente cuando la página esté lista.
  $("#formular").on('submit', function(evt) {
    evt.preventDefault();

    // Verifica si la altura de base es de 60 cm
    const altura = $("select[name='alturabase']").val();

    if (altura === "60") {
      Swal.fire({
        title: "¿Está seguro de mantener la altura base estándar de 60 cm?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#47B416",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, mantener",
        cancelButtonText: "No, cambiar",

      }).then((result) => {
        if (result.isConfirmed) {
          // Si se confirma la alerta, se muestra el resumen del formulario
          const resumen = `<div style=" display: inline-block;    margin-right: 10px;  vertical-align: top;  text-align: left;">
 <style>
    div > p {
      margin: 0;
    }
  </style>
            <p><strong>Modelo:</strong> ${$("#modelo").val()}</p>
            <p><strong>Plazas:</strong> ${$("#plazas").val()}</p>
             <p><strong>Altura de base:</strong> ${altura} cm</p>
            <p><strong>Tipo de tela:</strong> ${$("#listatelas").val()}</p>
            <p><strong>Color:</strong> ${$("#lista2").val()}</p>
             <p><strong>Dirección:</strong> ${$("#street_name").val()} ${$("#street_number").val()} ${$("#comunas").val()} ${$("#dpto").val()}</p>
             <br>
             <p><strong>Se envíara un correo al cliente luego de confirmar.</strong></p>
            </div>

          `;

          Swal.fire({
            title: "Por favor, confirme que los datos sean correctos:",
            icon: "info",
            html: resumen,
            showCancelButton: true,
            confirmButtonColor: "#47B416",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sí, confirmar",
            cancelButtonText: "No, cancelar",
            width: "50%",

          }).then((result) => {
            if (result.isConfirmed) {
              // Si se confirma la alerta, se valida el formulario
              if ($("#formular")[0].checkValidity()) {
                // Si el formulario es válido, se envía
                $.post("formularios/agregarpedidobeta.php", $("#formular").serialize(), function(res) {
                  $(".container").fadeOut("slow");
                  if (res == 1) {
                    $('#exito').html(res);
                    $("#exito").delay(500).fadeIn("slow");
                  } else {
                    $("#fracaso").delay(500).fadeIn("slow");
                    $("#fracaso").html(res);
                  }
                });
              }
            }
          });
        }
      });
    } else {
      // Si la altura de base no es de 60 cm, se valida el formulario y se envía
      if ($("#formular")[0].checkValidity()) {
        $.post("formularios/agregarpedidobeta.php", $("#formular").serialize(), function(res) {
          $(".container").fadeOut("slow");
          if (res == 1) {
            $('#exito').html(res);
            $("#exito").delay(500).fadeIn("slow");
          } else {
            $("#fracaso").delay(500).fadeIn("slow");
            $("#fracaso").html(res);
          }
        });
      }
    }
  });
});


      