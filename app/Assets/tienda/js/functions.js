$(".js-select2").each(function () {
  $(this).select2({
    minimumResultsForSearch: 20,
    dropdownParent: $(this).next(".dropDownSelect2"),
  });
});

$(".parallax100").parallax100();

$(".gallery-lb").each(function () {
  // the containers for all your galleries
  $(this).magnificPopup({
    delegate: "a", // the selector for gallery item
    type: "image",
    gallery: {
      enabled: true,
    },
    mainClass: "mfp-fade",
  });
});

$(".js-addwish-b2").on("click", function (e) {
  e.preventDefault();
});

$(".js-addwish-b2").each(function () {
  var nameProduct = $(this).parent().parent().find(".js-name-b2").html();
  $(this).on("click", function () {
    Swal.fire({
      title: nameProduct,
      text: "¡Se agregó al carrito!",
      icon: "success",
      confirmButtonText: "Aceptar",
    });
    //$(this).addClass('js-addedwish-b2');
    //$(this).off('click');
  });
});

$(".js-addwish-detail").each(function () {
  var nameProduct = $(this)
    .parent()
    .parent()
    .parent()
    .find(".js-name-detail")
    .html();

  $(this).on("click", function () {
    Swal.fire({
      title: nameProduct,
      text: "¡Se agregó al carrito!",
      icon: "success",
      confirmButtonText: "Aceptar",
    });

    $(this).addClass("js-addedwish-detail");
    $(this).off("click");
  });
});

/*---------------------------------------------*/

$(".js-addcart-detail").each(function () {
  let nameProduct = $(this)
    .parent()
    .parent()
    .parent()
    .parent()
    .find(".js-name-detail")
    .html();
  let cant = 1;

  $(this).on("click", function () {
    let id = this.getAttribute("id");
    if (document.querySelector("#cant-product")) {
      cant = document.querySelector("#cant-product").value;
    }
    if (this.getAttribute("pr")) {
      cant = this.getAttribute("pr");
    }
    var altura_base = "";

    var e = document.getElementById("color");
    if ($(e).length) {
      var color = e.options[e.selectedIndex].text;
    }
    var e = document.getElementById("tamano");
    if ($(e).length) {
      var tamano = e.options[e.selectedIndex].text;
    }
    var e = document.getElementById("tipo_tela");
    if ($(e).length) {
      var tipo_tela = e.options[e.selectedIndex].text;
    }
    var e = document.getElementById("altura_base");
    if ($(e).length) {
      var value = e.value;
      var altura_base = e.options[e.selectedIndex].text;
    }
    var e = document.getElementById("altura_base");
    if ($(e).length) {
      var value = e.value;
      var precio_alturabase = e.options[e.selectedIndex].value;
    }
    stock = document.querySelector("#stock").value;
    var e = document.getElementById("tamano");
    if ($(e).length) {
      var precio_tamano = e.options[e.selectedIndex].value;
    }

    descuento = $("#tamano :selected").attr("data-descuento");
    var te = "Elegir una opción";

    if (isNaN(cant) || cant < 1) {
      Swal.fire({
        icon: "error",
        title: "La cantidad debe ser mayor o igual que 1",
        confirmButtonText: "Aceptar",
      });
      return;
    }

    if (tamano == te) {
      Swal.fire({
        icon: "error",
        title: "Debe elegir un tamaño",
        confirmButtonText: "Aceptar",
      });
      return;
    }

    if (tipo_tela == te) {
      Swal.fire({
        icon: "error",
        title: "Debe elegir un tipo de Material",
        confirmButtonText: "Aceptar",
      });
      return;
    }

    if (color == te) {
      Swal.fire({
        icon: "error",
        title: "Debe elegir un Color",
        confirmButtonText: "Aceptar",
      });
      return;
    }

    if (tamano == "") {
      Swal.fire({
        icon: "error",
        title: "Debe elegir un tamaño",
        confirmButtonText: "Aceptar",
      });
      return;
    }
    var max_prod = Number(document.getElementById("cant-product").max);

    let cantidad_encarrito = 0;
    let total = 0;

    cantes = document.querySelectorAll(".cantCarrito");

    cantides = document.querySelector("#column-4");
    const el1 = document.querySelector('[data-id="data-notify"]');

    cantes.forEach((element) => {
      cantidad_encarrito = element.getAttribute("data-notify");
    });

    if (document.getElementById("producto-cantidad" + id)) {
      var plant = document.getElementById("producto-cantidad" + id);
      var cantidad_decarro = plant.getAttribute("data-value"); // Consulta la cantidad actual en el carrito del producto por id
    }

    total = parseInt(cantidad_encarrito) + parseInt(cant);
    console.log("CANTIDAD EN CARRO DE ESTE PRODUCTO" + cantidad_decarro);
    console.log("TOTAL DE PRODUCTOS EN CARRO" + total);
    console.log("Stock del producto" + stock);
    console.log("Cantidad a agregar" + cant);

    var cantidad_decarro = parseInt(cantidad_decarro);
    var cant = parseInt(cant);
    var stock = parseInt(stock);

    //	if(cantidad_decarro == null || cantidad_decarro == undefined){

    if (cant > stock) {
      Swal.fire({
        icon: "error",
        title: "Supera el stock",
        confirmButtonText: "Aceptar",
      });
      return;
    }
    //	}

    if (parseInt(cantidad_decarro + cant) > parseInt(stock)) {
      console.log(
        "la cantidad del carro es " +
          cantidad_decarro +
          " y quieres agregar" +
          cant +
          " Supera el stock que es" +
          stock
      );

      Swal.fire({
        icon: "error",
        title: "Supera el stock",
        confirmButtonText: "Aceptar",
      });
      return;
    }

    let request = window.XMLHttpRequest
      ? new XMLHttpRequest()
      : new ActiveXObject("Microsoft.XMLHTTP");
    let ajaxUrl = base_url + "/Tienda/addCarrito";
    let formData = new FormData();
    formData.append("id", id);
    formData.append("cant", cant);
    formData.append("color", color);
    formData.append("tamano", tamano);
    formData.append("stock", stock);
    formData.append("precio_tamano", precio_tamano - descuento);
    formData.append("precio_alturabase", precio_alturabase);
    formData.append("tipo_tela", tipo_tela);
    formData.append("altura_base", altura_base);
    request.open("POST", ajaxUrl, true);
    request.send(formData);
    request.onreadystatechange = function () {
      if (request.readyState != 4) return;
      if (request.status == 200) {
        let objData = JSON.parse(request.responseText);
        if (objData.status) {
          document.querySelector("#productosCarrito").innerHTML =
            objData.htmlCarrito; //agrega cantidad al carrito
          //document.querySelectorAll(".cantCarrito")[0].setAttribute("data-notify",objData.cantCarrito);
          //document.querySelectorAll(".cantCarrito")[1].setAttribute("data-notify",objData.cantCarrito);
          const cants = document.querySelectorAll(".cantCarrito");
          cants.forEach((element) => {
            element.setAttribute("data-notify", objData.cantCarrito);
          });
          Swal.fire({
            title: "Se ha agregado el producto al carrito!",
            text: "Producto agregado al carrito",
            type: "success",
            showCancelButton: true,
            // Background color of the "Confirm"-button. The default color is #3085d6
            confirmButtonColor: "LightSeaGreen",
            // Background color of the "Cancel"-button. The default color is #aaa
            cancelButtonColor: "Crimson",
            confirmButtonText: "Finalizar Compra",
            cancelButtonText: "Seguir comprando",
          }).then((result) => {
            if (result.value) {
              window.location = base_url + "/carrito";
            }
          });
        } else {
          Swal.fire({
            icon: "error",
            text: objData.msg,
            confirmButtonText: "Aceptar",
          });
        }
      }
      return false;
    };
  });
});

$(".js-pscroll").each(function () {
  $(this).css("position", "relative");
  $(this).css("overflow", "hidden");
  var ps = new PerfectScrollbar(this, {
    wheelSpeed: 1,
    scrollingThreshold: 1000,
    wheelPropagation: false,
  });

  $(window).on("resize", function () {
    ps.update();
  });
});

/*==================================================================
[ +/- num product ]*/
$(".btn-num-product-down").on("click", function () {
  let numProduct = Number($(this).next().val());
  let idpr = this.getAttribute("idpr");

  if (numProduct > 1)
    $(this)
      .next()
      .val(numProduct - 1);
  let cant = $(this).next().val();

  if (idpr != null) {
    fntUpdateCant(idpr, cant);
  }
});

$(".btn-num-product-up").on("click", function () {
  let numProduct = Number($(this).prev().val());
  let idpr = this.getAttribute("idpr");

  var max_prod = Number(document.getElementById("cant-product").max);

  console.log(max_prod);
  if (numProduct < max_prod || numProduct == 100) {
    $(this)
      .prev()
      .val(numProduct + 1);
  }

  let cant = $(this).prev().val();
  let id = this.getAttribute("cant-product");

  if (idpr != null) {
    fntUpdateCant(idpr, cant);
  }
});

//Actualizar producto
if (document.querySelector(".num-product")) {
  let inputCant = document.querySelectorAll(".num-product");
  inputCant.forEach(function (inputCant) {
    inputCant.addEventListener("keyup", function () {
      let idpr = this.getAttribute("idpr");
      let cant = this.value;
      if (idpr != null) {
        console.log(idpr);
        fntUpdateCant(idpr, cant);
      }
    });
  });
}

function number_format(number, decimals, dec_point, thousands_sep) {
  // Strip all characters but numerical ones.
  number = (number + "").replace(/[^0-9+\-Ee.]/g, "");
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = typeof thousands_sep === "undefined" ? "," : thousands_sep,
    dec = typeof dec_point === "undefined" ? "." : dec_point,
    s = "",
    toFixedFix = function (n, prec) {
      var k = Math.pow(10, prec);
      return "" + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : "" + Math.round(n)).split(".");
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || "").length < prec) {
    s[1] = s[1] || "";
    s[1] += new Array(prec - s[1].length + 1).join("0");
  }
  return s.join(dec);
}

$("#tamano").change(function () {
  var a = $("select[id=tamano]").val(); //seleccionamos el id del tamaño seleccionado
  var combo = document.getElementById("tamano"); // seleccionar el texto del select
  var selected = combo.options[combo.selectedIndex].text; // seleccionar el texto del select

  if (document.querySelector("#id_prod")) {
    id_prod = document.querySelector("#id_prod").text; //recibimos el valor del id del producto actual
  }
  medida = "";
  descuento = $("#tamano :selected").attr("data-descuento");
  categoria = $("#tamano :selected").attr("data-categoria");
  console.log(descuento);
  if (categoria == "Colchones") {
    if (selected == "1 plaza") {
      medida = "1 plaza: 90 cm de ancho";
    }
    if (selected == "1 1/2") {
      medida = "1 1/2 plazas: 105 cm de ancho";
    }
    if (selected == "Full") {
      medida = "Full: 135 cm de ancho";
    }
    if (selected == "2 plazas") {
      medida = "2 plazas: 150 cm de ancho";
    }
    if (selected == "queen") {
      medida = "Queen: 160 cm de ancho";
    }
    if (selected == "king") {
      medida = "King: 180 cm de ancho";
    }
    if (selected == "Super King") {
      medida = "Super King: 200 cm de ancho";
    }
  }
  if (categoria == "Respaldos de cama") {
    if (selected == "1 plaza") {
      medida = "1 plaza: 90 cm de largo";
    }
    if (selected == "1 1/2") {
      medida = "1 1/2 plaza: 105 cm de largo";
    }
    if (selected == "Full") {
      medida = "Full: 135 cm de largo";
    }
    if (selected == "2 plazas") {
      medida = "2 plazas: 150 cm de largo";
    }
    if (selected == "queen") {
      medida = "Queen: 160 cm de largo";
    }
    if (selected == "king") {
      medida = "King: 180 cm de largo";
    }
    if (selected == "Super King") {
      medida = "Super King: 200 cm de largo";
    }
  }

  document.querySelector("#medidas").innerHTML = medida;
  formateado = Intl.NumberFormat("es-CL", {
    style: "currency",
    currency: "CLP",
    maximumFractionDigits: "0",
  }).format(a);

  document.querySelector("#precioportamano").innerHTML = Intl.NumberFormat(
    "es-CL",
    { style: "currency", currency: "CLP", maximumFractionDigits: "0" }
  ).format(a - descuento); // asignamos a la variable precio total el valor del producto en el tamaño indicado.
  document.querySelector("#precioportamano_descuento").innerHTML = formateado;
  if (descuento != 0) {
    document.querySelector("#descuento_activo").classList.remove("notblock");
  } else {
    document.querySelector("#descuento_activo").classList.add("notblock");
  }
  console.log(a);
});

$("#altura_base").change(function () {
  var a = $("select[id=altura_base]").val(); //seleccionamos el id de la altura seleccionada
  if (document.querySelector("#id_prod")) {
    id_prod = document.querySelector("#id_prod").text;
  }

  if (a == "0") {
    precio_base = "Gratis";
  } else {
    precio_base = "$" + a;
  }

  Swal.fire({
    title: precio_base,
    text: "Cambio el valor de altura",
    icon: "success",
    confirmButtonText: "Aceptar",
  });

  document.querySelector("#precio_alturabase").value =
    "Altura Base: " +
    Intl.NumberFormat("es-CL", {
      style: "currency",
      currency: "CLP",
      maximumFractionDigits: "0",
    }).format(a);
});

$("#tipo_tela").change(function () {
  var id_prod = $("#id_prod").val();

  var id = $(this).find(":selected").text();

  ajaxUrl = base_url + "/Tienda/getColorese/" + id;

  var valor = "";
  $select = document.querySelector("#color");

  $.ajax({
    type: "POST",
    data: { idprod: id_prod },
    contentType: "application/json; charset=utf-8",
    dataType: "json",

    url: ajaxUrl,
    success: function (data) {
      for (let i = 0; i < data.length; i++) {
        //option = document.createElement('option');
        //option.value = data[i]['id'];
        //option.text = data[i]['color'];

        //$select.appendChild(option);

        valor =
          valor +
          "<option value=" +
          data[i]["id"] +
          ">" +
          data[i]["color"] +
          "</option>";
      }

      valordefecto = '<option value="">Elegir una opción</option>';
      document.querySelector("#color").innerHTML = valordefecto + valor;
    },
    error: function (jqXHR, exception) {
      var msg = "";
      if (jqXHR.status === 0) {
        msg = "Not connect.\n Verify Network.";
      } else if (jqXHR.status == 404) {
        msg = "Requested page not found. [404]";
      } else if (jqXHR.status == 500) {
        msg = "Internal Server Error [500].";
      } else if (exception === "parsererror") {
        msg = "Requested JSON parse failed.";
      } else if (exception === "timeout") {
        msg = "Time out error.";
      } else if (exception === "abort") {
        msg = "Ajax request aborted.";
      } else {
        msg = "Uncaught Error.\n" + jqXHR.responseText;
      }
      alert(msg);
    },
  });
});

/*


if(document.querySelector("#tamano")){
	$(this).on('change', function(){

		let idpr = this.getAttribute('tamano');

	
	console.log(idpr);
	 }
)}


$(document).ready(function(){
document.getElementById('tamano').onchange = function() {
	
	if(document.querySelector('#id_prod')){
		e = document.querySelector('#cant-product').value;
	}


	
	
	var index = this.selectedIndex;
	var inputText = this.children[index].innerHTML.trim();
	console.log(e);
	
 }

  })
   */
function checkRut(rut) {
  // Despejar Puntos

  var valor = rut.replace(".", "");
  // Despejar Guión
  valor = valor.replace(/-/g, "");

  var input = document.getElementById("txtRut");

  // Aislar Cuerpo y Dígito Verificador
  cuerpo = valor.slice(0, -1);
  dv = valor.slice(-1).toUpperCase();

  // Formatear RUN
  rut = cuerpo + "-" + dv;

  // Si no cumple con el mínimo ej. (n.nnn.nnn)
  if (cuerpo.length < 7) {
    input.style = "border: 3px solid yellow;";
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
  dv = dv == "K" ? 10 : dv;
  dv = dv == 0 ? 11 : dv;

  // Validar que el Cuerpo coincide con su Dígito Verificador
  if (dvEsperado != dv) {
    input.style = "border: 3px solid red;";
    return false;
  }

  // Si todo sale bien, eliminar errores (decretar que es válido)
  input.style = "border: 3px solid green;";
}
if (document.querySelector("#formDireccion")) {
  let formDireccion = document.querySelector("#formDireccion");
  formDireccion.onsubmit = function (e) {
    e.preventDefault();
    let direccion = document.querySelector("#txtDireccion").value;
    let dirNumero = document.querySelector("#txtDirNumero").value;
    let dirDepto = document.querySelector("#txtDirDpto").value;
    let dirRegion = document.querySelector("#regiones").value;
    let dirComuna = document.querySelector("#comunas").value;
    let instrucciones = document.querySelector("#instrucciones").value;

    divLoading.style.display = "flex";

    let request = window.XMLHttpRequest
      ? new XMLHttpRequest()
      : new ActiveXObject("Microsoft.XMLHTTP");
    let ajaxUrl = base_url + "/Tienda/agregarDireccion";
    let formData = new FormData();
    formData.append("direccion", direccion);
    formData.append("dirNumero", dirNumero);
    formData.append("dirDepto", dirDepto);
    formData.append("dirRegion", dirRegion);
    formData.append("dirComuna", dirComuna);
    formData.append("instrucciones", instrucciones);

    request.open("POST", ajaxUrl, true);
    request.send(formData);
    request.onreadystatechange = function () {
      if (request.readyState != 4) return;
      if (request.status == 200) {
        let objData = JSON.parse(request.responseText);
        if (objData.status) {
          window.location.reload(true);
        } else {
          Swal.fire({
            icon: "error",
            text: objData.msg,
            confirmButtonText: "Aceptar",
          });
        }
      }

      divLoading.style.display = "none";
      return false;
    };
  };
}

if (document.querySelector("#formulariodireccion")) {
  let formRegister = document.querySelector("#formulariodireccion");
  formRegister.onsubmit = function (e) {
    e.preventDefault();
    let datos = document.querySelector("#datos").value;
    let retiro = document.querySelector("#retiroenlatienda").value;
    document.getElementById("iddireccionselect").value = "1";
    console.log("valor" + retiro);
    seleccionadireccion = $("input:checkbox[name=iddireccion]:checked").val();

    if (retiro == "0") {
      if (seleccionadireccion === undefined) {
        Swal.fire({
          title: "Atención",
          text: "Debe seleccionar despacho",
          icon: "error",
          confirmButtonText: "Aceptar",
        });
        return false;
      } else {
        document.getElementById("iddireccionselect").value =
          seleccionadireccion;
      }
    }

    formRegister.submit();
  };
}

if (document.querySelector("#formRegister")) {
  let formRegister = document.querySelector("#formRegister");
  formRegister.onsubmit = function (e) {
    e.preventDefault();
    let strNombre = document.querySelector("#txtNombre").value;
    let strApellido = document.querySelector("#txtApellido").value;
    let strEmail = document.querySelector("#txtEmailCliente").value;
    let intTelefono = document.querySelector("#txtTelefono").value;
    let rut = document.querySelector("#txtRut").value;
    console.log(rut);
    console.log(intTelefono.length);

    if (intTelefono.length != 9) {
      Swal.fire({
        title: "Atención",
        text: "Debe ingresar un teléfono válido.",
        icon: "error",
        confirmButtonText: "Aceptar",
      });
      return false;
    }

    var rute = checkRut(rut);

    if (rute == false) {
      Swal.fire({
        title: "Atención",
        text: "Rut inválido.",
        icon: "error",
        confirmButtonText: "Aceptar",
      });
      return false;
    }

    if (
      strApellido == "" ||
      strNombre == "" ||
      strEmail == "" ||
      intTelefono == "" ||
      rut == ""
    ) {
      Swal.fire({
        title: "Atención",
        text: "Todos los campos son obligatorios.",
        icon: "error",
        confirmButtonText: "Aceptar",
      });
      return false;
    }

    let elementsValid = document.getElementsByClassName("valid");
    for (let i = 0; i < elementsValid.length; i++) {
      if (elementsValid[i].classList.contains("is-invalid")) {
        Swal.fire({
          title: "Atención",
          text: "Por favor verifique los campos en rojo.",
          icon: "error",
          confirmButtonText: "Aceptar",
        });
        return false;
      }
    }
    divLoading.style.display = "flex";
    let request = window.XMLHttpRequest
      ? new XMLHttpRequest()
      : new ActiveXObject("Microsoft.XMLHTTP");
    let ajaxUrl = base_url + "/Tienda/registro";
    let formData = new FormData(formRegister);
    request.open("POST", ajaxUrl, true);
    request.send(formData);
    request.onreadystatechange = function () {
      if (request.readyState == 4 && request.status == 200) {
        let objData = JSON.parse(request.responseText);
        if (objData.status) {
          window.location.reload(false);
        } else {
			Swal.fire({
				icon: "error", // Tipo de icono
				title: "Error", // Título de la alerta
				text: objData.msg, // Mensaje de la alerta
				confirmButtonText: "Aceptar", // Texto del botón de confirmación
				footer: objData.msg === "¡Atención! el rut ya existe, ingrese a su cuenta." ? '<a href="https://www.respaldoschile.cl/login">Ingresar a mi cuenta</a>' : null
			  });
        }
      }
      divLoading.style.display = "none";
      return false;
    };
  };
}

function abrir(metodo) {
  if (metodo == "despacho") {
    document.querySelector("#direccion").classList.remove("notblock");
    document.querySelector("#despachoadomicilio").classList.add("actiontr");
    document.querySelector("#retiroentienda").classList.remove("actiontr");
    document.querySelector("#retiroenlocal").classList.add("notblock");
    document.getElementById("retiroenlatienda").value = "0";
    comuna = $("input:checkbox[name=seleccionar]:checked").val().toLowerCase();

    document.getElementById("retiroenlatienda").value = "0";
  }
  if (metodo == "retiro") {
    document.getElementById("retiroenlatienda").value = "1";
    document.querySelector("#costoenvio").innerText = "0";
    document.querySelector("#direccion").classList.add("notblock");
    document.querySelector("#retiroentienda").classList.add("actiontr");
    document.querySelector("#despachoadomicilio").classList.remove("actiontr");
    document.getElementById("retiro").value = "retiro";
    document.querySelector("#retiroenlocal").classList.remove("notblock");
    document.getElementById("iddireccionselect").value = "1";
    console.log("algo");
    document.querySelector("#mensj").innerHTML =
      "El envio se descontará en la proxima pagina";
    valor_envio = document.querySelector("#costoenvio").innerText = "0";
    comuna = "retiro";
  }
  let request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  let ajaxUrl = base_url + "/Tienda/cons_precioDir";
  let formData = new FormData();
  formData.append("comuna", comuna);
  request.open("POST", ajaxUrl, true);
  request.send(formData);
  request.onreadystatechange = function () {
    if (request.readyState != 4) return;
    if (request.status == 200) {
      let objData = JSON.parse(request.responseText);
      if (objData.precio) {
        valor_envio = document.querySelector("#costoenvio").value =
          objData.precio["precio"];
        if (objData.precio["precio"] == "1") {
          let timerInterval;
        }
      }
    }
  };
}

if (document.querySelectorAll(".aplicar")) {
  function aplicarDescuento(coddescuentos) {
    let coddescuento = document.querySelector("#cod_descuento").value;

    console.log(coddescuento);
    let c = this.value;
    divLoading.style.display = "flex";

    let request = window.XMLHttpRequest
      ? new XMLHttpRequest()
      : new ActiveXObject("Microsoft.XMLHTTP");
    let ajaxUrl = base_url + "/Tienda/consultarTotal";
    let formData = new FormData();
    //let comuna = document.querySelector("#direcomuna").value;
    formData.append("coddescuento", coddescuento);

    request.open("POST", ajaxUrl, true);
    request.send(formData);
    request.onreadystatechange = function () {
      if (request.readyState != 4) return;
      if (request.status == 200) {
        let objData = JSON.parse(request.responseText);
        if (objData.preciodescuento == 404) {
          console.log(coddescuento);

          Swal.fire({
            icon: "error", // Tipo de icono
            title: "Error", // Título de la alerta
            text: "El cupon aplica para montos mayores a $40.000", // Mensaje de la alerta
            confirmButtonText: "Aceptar", // Texto del botón de confirmación
          });
        } else if (objData.preciodescuento > 0) {
          Swal.fire({
            title: "Cupón de descuento aplicado",
            text: "$" + objData.preciodescuento,
            icon: "success",
            confirmButtonText: "Aceptar",
          });
          console.log(objData.preciodescuento);
          document.getElementById("descuento").innerHTML =
            objData.preciodescuento;
          document.getElementById("totaal").innerHTML = objData.subtotales;
          document.querySelector("#cod_descuento").disabled = true;
          document.querySelector("#aplicar").disabled = true;
          document.querySelector("#nombrecupon").value = objData.nombrecupon;
          document.querySelector("#cupon").classList.remove("notblock");
        } else {
          console.log(coddescuento);
          Swal.fire({
            icon: "error",
            title: "Cupón inválido o expirado",
            confirmButtonText: "Aceptar",
          });
        }
      }
      divLoading.style.display = "none";
      return false;
    };
  }
}

if (document.querySelector(".methodpago")) {
  let optmetodo = document.querySelectorAll(".methodpago");
  optmetodo.forEach(function (optmetodo) {
    optmetodo.addEventListener("click", function () {
      if (this.value == "Paypal") {
        document.querySelector("#divpaypal").classList.remove("notblock");
        document.querySelector("#divtipopago").classList.add("notblock");
        //document.querySelector("#depositobancario").classList.add("notblock");
      } else {
        document.querySelector("#divpaypal").classList.add("notblock");
        document.querySelector("#divtipopago").classList.remove("notblock");
        //document.querySelector("#depositobancario").classList.remove("notblock");
      }
    });
  });
}

function fntdelItem(element) {
  //Option 1 = Modal
  //Option 2 = Vista Carrito
  let option = element.getAttribute("op");
  let idpr = element.getAttribute("idpr");
  if (option == 1 || option == 2) {
    let request = window.XMLHttpRequest
      ? new XMLHttpRequest()
      : new ActiveXObject("Microsoft.XMLHTTP");
    let ajaxUrl = base_url + "/Tienda/delCarrito";
    let formData = new FormData();
    formData.append("id", idpr);
    formData.append("option", option);
    request.open("POST", ajaxUrl, true);
    request.send(formData);
    request.onreadystatechange = function () {
      if (request.readyState != 4) return;
      if (request.status == 200) {
        let objData = JSON.parse(request.responseText);
        if (objData.status) {
          if (option == 1) {
            document.querySelector("#productosCarrito").innerHTML =
              objData.htmlCarrito;
            const cants = document.querySelectorAll(".cantCarrito");
            cants.forEach((element) => {
              element.setAttribute("data-notify", objData.cantCarrito);
            });
          } else {
            element.parentNode.parentNode.remove();
            document.querySelector("#subTotalCompra").innerHTML =
              objData.subTotal;
            document.querySelector("#totalCompra").innerHTML = objData.total;

            if (document.querySelectorAll("#tblCarrito tr").length == 1) {
              window.location.href = base_url;
            }
          }
        } else {
          Swal.fire({
            icon: "error",
            text: objData.msg,
            confirmButtonText: "Aceptar",
          });
        }
      }
      return false;
    };
  }
}

function fntUpdateCant(pro, cant) {
  if (cant <= 0) {
    document.querySelector("#btnComprar").classList.add("notblock");
  } else {
    document.querySelector("#btnComprar").classList.remove("notblock");
    let request = window.XMLHttpRequest
      ? new XMLHttpRequest()
      : new ActiveXObject("Microsoft.XMLHTTP");
    let ajaxUrl = base_url + "/Tienda/updCarrito";
    let formData = new FormData();
    formData.append("id", pro);
    formData.append("cantidad", cant);
    request.open("POST", ajaxUrl, true);
    request.send(formData);
    request.onreadystatechange = function () {
      if (request.readyState != 4) return;
      if (request.status == 200) {
        let objData = JSON.parse(request.responseText);
        if (objData.status) {
          let colSubtotal = document.getElementsByClassName(pro)[0];
          colSubtotal.cells[4].textContent = objData.totalProducto;
          document.querySelector("#subTotalCompra").innerHTML =
            objData.subTotal;
          document.querySelector("#totalCompra").innerHTML = objData.total;
        } else {
          Swal.fire({
            icon: "error",
            text: objData.msg,
            confirmButtonText: "Aceptar",
          });
        }
      }
    };
  }
  return false;
}

/* if(document.querySelector("#regiones")){
	let direccion = document.querySelector("regiones");
	regiones.addEventListener('click', function(){
		let dir = this.value;
		fntViewPago();
	});
}

if(document.querySelector("#comunas")){
	let ciudad = document.querySelector("#comunas");
	ciudad.addEventListener('click', function(){
		let c = this.value;
		fntViewPago();
	});
}
if(document.querySelector("#txtDireccion")){
	let direccion = document.querySelector("#txtDireccion");
	direccion.addEventListener('keyup', function(){
		let c = this.value;
		fntViewPago();
	});
}

if(document.querySelector("#txtDirNumero")){
	let dirnumero = document.querySelector("#txtDirNumero");
	dirnumero.addEventListener('keyup', function(){
		let c = this.value;
		fntViewPago();
	});
}*/
/**
 * Cambia el precio del envío basado en la comuna seleccionada.
 * 
 * @param {string} valor - El valor de la comuna seleccionada.
 */
function cambiarprecio(element) {
  // Desmarcar todos los checkboxes excepto el seleccionado
  let checkboxes = document.querySelectorAll('.direccion-checkbox');
  checkboxes.forEach(function(checkbox) {
      if (checkbox !== element) {
          checkbox.checked = false;
          // Restar el precio de envío del total si había un precio almacenado en data-precio
          if (checkbox.dataset.precio) {
              let precioAnterior = parseFloat(checkbox.dataset.precio) || 0;
              actualizarTotalCompra(precioAnterior, true);
              checkbox.dataset.precio = "";
          }
      }
  });

  let direccionId = element.value;

  // Si el checkbox está deseleccionado
  if (!element.checked) {
      let precioAnterior = parseFloat(element.dataset.precio) || 0;
      actualizarTotalCompra(precioAnterior, true);
      actualizarPrecio(0);
      element.dataset.precio = "";
      return;
  }

  // Si ya se ha calculado el precio, usar el valor almacenado en data-precio
  if (element.dataset.precio) {
      let precio = parseFloat(element.dataset.precio);
      actualizarPrecio(precio);
      actualizarTotalCompra(precio, false);
  } else {
      // Inicializar el valor del costo de envío a 0
      document.querySelector("#costoenvio").innerText = "0";

      // Crear la solicitud AJAX
      let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
      let ajaxUrl = base_url + "/Tienda/cons_precioDir";
      let formData = new FormData();
      formData.append("comuna", direccionId);

      request.open("POST", ajaxUrl, true);
      request.send(formData);

      request.onreadystatechange = function () {
          if (request.readyState != 4) return;
          if (request.status == 200) {
              let objData = JSON.parse(request.responseText);
              if (objData.precio) {
                  let valordeenvio = parseFloat(objData.precio["precio"]);
                  element.dataset.precio = valordeenvio; // Almacenar el precio en data-precio
                  actualizarPrecio(valordeenvio);
                  actualizarTotalCompra(valordeenvio, false);

                  if (objData.precio["envio_loc"] == "region") {
                      mostrarInformacionEnvio(objData.precio["comuna"]);
                  }
              } else {
                  Swal.fire({
                      icon: "error",
                      text: objData.precio,
                      confirmButtonText: "Aceptar"
                  });
              }
          }
      };
  }
}

function actualizarPrecio(precio) {
  document.querySelector("#costoenvio").innerText = precio;
}

function mostrarInformacionEnvio(comuna) {
  Swal.fire({
      title: "Información de Envío",
      html: `La comuna seleccionada es <b>${comuna}</b>. <br><br> Ten en cuenta que <strong>todo envío se realiza por pagar</strong>, lo cual significa que el costo del envío será determinado y cobrado por la empresa de transporte al momento de la entrega.<br><img width='70' src='https://jumpseller.cl/generated/images/support/starken/starkenlogo-480-9a8eee34a.webp'><img width='70' src='https://www.pullmango.cl/img/logo_cargo_go.png'><img width='70' src='https://www.respaldoschile.cl/Assets/images/147.-Cruz-del-Sur.webp'><img width='50' src='https://www.respaldoschile.cl/Assets/images/Logo.ico'><br> <b>Todo envío es por pagar</b>`,
      footer: 'Puede continuar con su compra y luego consultar el valor a un ejecutivo',
      showConfirmButton: true,
      confirmButtonText: "Acepto que debo cotizar valor de envio",
      allowOutsideClick: false,
      allowEscapeKey: false,
      allowEnterKey: false
  }).then((result) => {
      if (result.isConfirmed) {
          document.querySelector("#costoenvio").innerText = "Por pagar";
          console.log("El usuario confirmó el mensaje");
      }
  });
}

function actualizarTotalCompra(precio, reset) {
  let totalElement = document.querySelector("#totalcompra");
  if (totalElement) {
      let total = parseFloat(totalElement.value);
      let nuevoTotal = reset ? total - precio : total + precio;
      totalElement.value = nuevoTotal.toFixed(0);
      console.log("Nuevo total: " + nuevoTotal);
  }
}



if (document.querySelector("#iddireccion")) {
  let opt = document.querySelector("#iddireccion");
  opt.addEventListener("click", function () {
    let opcion = this.checked;
    if (opcion) {
      document.querySelector("#iddireccion").classList.remove("notblock");
    } else {
    }
  });
}

if (document.querySelector("#seleccionar")) {
  /*

	let seleccionar = document.querySelector("#seleccionar");

	
	
	comuna =  $('input:checkbox[name=seleccionar]:checked').val().toLowerCase();




valor_envio = document.querySelector("#costoenvio").value = "0";
	let request = (window.XMLHttpRequest) ? 
	                    new XMLHttpRequest() : 
	                    new ActiveXObject('Microsoft.XMLHTTP');
			let ajaxUrl = base_url+'/Tienda/cons_precioDir';
			let formData = new FormData();
		    formData.append('comuna',comuna);	   	
		   	request.open("POST",ajaxUrl,true);
		    request.send(formData);
		    request.onreadystatechange = function(){
		    	if(request.readyState != 4) return;
		    	if(request.status == 200){
		    		let objData = JSON.parse(request.responseText);
		    		if(objData.precio){
		    			valor_envio = document.querySelector("#costoenvio").value = objData.precio['precio'];
		    			if(objData.precio['precio'] == "1"){
		    				let timerInterval
Swal.fire({
  title: 'Precio de despacho',
  html: 'El costo de envío a '+$('input:checkbox[name=seleccionar]:checked').val()+ ' se debe consultar a la agencia',
  footer: '<a href="">Puede continuar con su compra y luego consultar el valor a un ejecutivo</a>',
  timer: 6000,
  timerProgressBar: true,
  didOpen: () => {
    Swal.showLoading()
    const b = Swal.getHtmlContainer().querySelector('b')
    timerInterval = setInterval(() => {
      b.textContent = Swal.getTimerLeft()
    }, 100)
  },
  willClose: () => {
    clearInterval(timerInterval)
  }
}).then((result) => {
  /* Read more about handling dismissals below */
  /* if (result.dismiss === Swal.DismissReason.timer) {
    console.log('I was closed by the timer')
  }
})
		    			}
		    			else{ if(document.querySelector("#costoenvio")){
		 	
						 	if(document.querySelector("#totalcompra")){
						 	total = document.querySelector("#totalcompra").value;
						 	total_costo = suma=parseFloat(total)+parseFloat(valor_envio);
						 	 document.querySelector("#totalcompra").value = total_costo;
						 	 }
						 	 }}
		    			
				    		}else{
				    			swal("", objData.precio , "error");
				    		}
				    	}
		    	
            	
		    }



	
	
	

		

		 
		

		
	
	//swal(comuna, "Complete datos de envío" , "error");
			document.querySelector('#divMetodoPago').classList.remove("notblock");
	
	*/
}

if (document.querySelector("#loaddeprueba")) {
}

if (document.querySelector("#condiciones")) {
  let opt = document.querySelector("#condiciones");
  opt.addEventListener("click", function () {
    let opcion = this.checked;
    if (opcion) {
      document
        .querySelector("#metodosdepagoenlinea")
        .classList.remove("notblock");
    } else {
    }
  });
}

function fntViewPago() {
  let regiones = document.querySelector("#regiones").value;
  let ciudad = document.querySelector("#comunas").value;
  let direccion = document.querySelector("#txtDireccion").value;
  let dirnumero = document.querySelector("#txtDirNumero").value;

  if (direccion == "" || dirnumero == "") {
    document.querySelector("#divMetodoPago").classList.add("notblock");
  } else {
    document.querySelector("#divMetodoPago").classList.remove("notblock");
  }
}

function agregarVenta() {
  let dir = document.querySelector("#direvalue").value;
  //	let numero = document.querySelector("#direnumero").value;
  //	 let dpto = document.querySelector("#diredpto").value;
  //	 let region = document.querySelector("#direregion").value;
  //   let comuna = document.querySelector("#direcomuna").value;
  //   let referencia = document.querySelector("#direreferencia").value;

  let iddireccionselect = document.querySelector("#iddireccionselect").value;

  let inttipopago = document.querySelector("#listtipopago").value;
  if (dir == "" || comuna == "" || inttipopago == "") {
    Swal.fire({
      icon: "error",
      title: "Complete datos de envío",
      confirmButtonText: "Aceptar",
    });
    return;
  } else {
    // Muestra un elemento de carga en la pantalla
divLoading.style.display = "flex";

// Crea un objeto XMLHttpRequest, compatible con navegadores antiguos que utilizan ActiveXObject
let request = window.XMLHttpRequest 
  ? new XMLHttpRequest() 
  : new ActiveXObject("Microsoft.XMLHTTP");

// Define la URL para la solicitud AJAX
let ajaxUrl = base_url + "/Tienda/procesarVenta";

// Crea un objeto FormData para enviar datos en la solicitud POST
let formData = new FormData();
// Añade campos al FormData, actualmente comentados (puedes descomentar y añadir si es necesario)
// formData.append('direccion', dir);
// formData.append('numero', numero);
// formData.append('dpto', dpto);
// formData.append('region', region);
// formData.append('comuna', comuna);

// Añade el campo 'iddireccionselect' al FormData
formData.append("iddireccionselect", iddireccionselect);

// Añade el campo 'inttipopago' al FormData
formData.append("inttipopago", inttipopago);

// Configura la solicitud AJAX como POST y abre la conexión
request.open("POST", ajaxUrl, true);

// Envía el FormData con la solicitud
request.send(formData);

// Define una función para manejar los cambios en el estado de la solicitud
request.onreadystatechange = function () {
  // Si la solicitud no está completa, no hacer nada
  if (request.readyState != 4) return;

  // Si la solicitud fue exitosa
  if (request.status == 200) {
    // Parsear la respuesta JSON
    let objData = JSON.parse(request.responseText);

    // Si el estado de la respuesta es exitoso
    if (objData.status) {
      // Redirige al usuario a la página de confirmación de pedido
      window.location = base_url + "/tienda/confirmarpedido?ord="+objData.orden;
    } else {
      // Muestra un mensaje de error utilizando SweetAlert
      Swal.fire({
        icon: "error",
        text: objData.msg,
        confirmButtonText: "Aceptar",
      });
    }
  }

  // Oculta el elemento de carga en la pantalla
  divLoading.style.display = "none";
  return false;
    };
  }
}

if (document.querySelector("#btnComprar")) {
  // Aca se asignan y guardan los valores de direccion.
  let btnPago = document.querySelector("#btnComprar");

  btnPago.addEventListener(
    "click",
    function () {
      if (validar() == false) {
        Swal.fire({
          icon: "success",
          title: "Debe aceptar términos y condiciones",
          confirmButtonText: "Aceptar",
        });
      } else {
        // let dir = document.querySelector("#direvalue").value;
        //let numero = document.querySelector("#direnumero").value;
        //let dpto = document.querySelector("#diredpto").value;
        //let region = document.querySelector("#direregion").value;
        //let comuna = document.querySelector("#direcomuna").value;
        //let referencia = document.querySelector("#direreferencia").value;
        let iddireccionselect =
          document.querySelector("#iddireccionselect").value;

        let inttipopago = document.querySelector("#listtipopago").value;
        if (inttipopago == "" || inttipopago == "") {
          Swal.fire({
            icon: "error",
            title: "Complete datos de envío",
            confirmButtonText: "Aceptar",
          });
          return;
        } else {
          divLoading.style.display = "flex";
          let request = window.XMLHttpRequest
            ? new XMLHttpRequest()
            : new ActiveXObject("Microsoft.XMLHTTP");
          let ajaxUrl = base_url + "/Tienda/procesarVenta";
          let formData = new FormData();
          // formData.append('direccion',dir);
          //	formData.append('numero',numero);
          //	formData.append('dpto',dpto);
          // formData.append('region',region);
          //	formData.append('comuna',comuna);
          formData.append("iddireccionselect", iddireccionselect);
          //	formData.append('referencia',referencia);

          formData.append("inttipopago", inttipopago);
          request.open("POST", ajaxUrl, true);
          request.send(formData);
          request.onreadystatechange = function () {
            if (request.readyState != 4) return;
            if (request.status == 200) {
              let objData = JSON.parse(request.responseText);
              if (objData.status) {
                window.location = base_url + "/tienda/confirmarpedido?orden="+objData.orden;
              } else {
                if (
                  (objData.msg =
                    "No es posible procesar el pedido, uno de los productos bajo su stock disponible. Vuelva al carrito para revisar el detalle")
                ) {
                  Swal.fire({
                    title: "Hubo un error en la transacción",
                    text: "No es posible procesar el pedido, uno de los productos bajo su stock disponible!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Volver al carrito",
                  }).then((result) => {
                    if (result.isConfirmed) {
                      window.location = base_url + "/carrito/procesarpago";
                    }
                  });
                } else {
                  Swal.fire({
                    icon: "error",
                    text: objData.msg,
                    confirmButtonText: "Aceptar",
                  });
                }
              }
            }
            divLoading.style.display = "none";
            return false;
          };
        }
      }
    },
    false
  );
}

if (document.querySelector("#frmSuscripcion")) {
  let frmSuscripcion = document.querySelector("#frmSuscripcion");
  frmSuscripcion.addEventListener(
    "submit",
    function (e) {
      e.preventDefault();

      let nombre = document.querySelector("#nombreSuscripcion").value;
      let email = document.querySelector("#emailSuscripcion").value;

      if (nombre == "") {
        Swal.fire({
          icon: "error",
          title: "El nombre es obligatorio.",
          confirmButtonText: "Aceptar",
        });
        return false;
      }

      if (!fntEmailValidate(email)) {
        Swal.fire({
          icon: "error",
          title: "El email no es válido.",
          confirmButtonText: "Aceptar",
        });
        return false;
      }

      divLoading.style.display = "flex";
      let request = window.XMLHttpRequest
        ? new XMLHttpRequest()
        : new ActiveXObject("Microsoft.XMLHTTP");
      let ajaxUrl = base_url + "/Tienda/suscripcion";
      let formData = new FormData(frmSuscripcion);
      request.open("POST", ajaxUrl, true);
      request.send(formData);
      request.onreadystatechange = function () {
        if (request.readyState != 4) return;
        if (request.status == 200) {
          let objData = JSON.parse(request.responseText);
          if (objData.status) {
            Swal.fire({
              icon: "success",
              text: objData.msg,
              confirmButtonText: "Aceptar",
            });
            document.querySelector("#frmSuscripcion").reset();
          } else {
            Swal.fire({
              icon: "error",
              text: objData.msg,
              confirmButtonText: "Aceptar",
            });
          }
        }
        divLoading.style.display = "none";
        return false;
      };
    },
    false
  );
}

if (document.querySelector("#frmContacto")) {
  let frmContacto = document.querySelector("#frmContacto");
  frmContacto.addEventListener(
    "submit",
    function (e) {
      e.preventDefault();

      let nombre = document.querySelector("#nombreContacto").value;
      let email = document.querySelector("#emailContacto").value;
      let mensaje = document.querySelector("#mensaje").value;

      if (nombre == "") {
        Swal.fire({
          icon: "error",
          title: "El nombre es obligatorio",
          confirmButtonText: "Aceptar",
        });
        return false;
      }

      if (!fntEmailValidate(email)) {
        Swal.fire({
          icon: "error",
          title: "El email no es válido.",
          confirmButtonText: "Aceptar",
        });

        return false;
      }

      if (mensaje == "") {
        Swal.fire({
          icon: "error",
          title: "Por favor escribe el mensaje.",
          confirmButtonText: "Aceptar",
        });
        return false;
      }

      divLoading.style.display = "flex";
      let request = window.XMLHttpRequest
        ? new XMLHttpRequest()
        : new ActiveXObject("Microsoft.XMLHTTP");
      let ajaxUrl = base_url + "/Tienda/contacto";
      let formData = new FormData(frmContacto);
      request.open("POST", ajaxUrl, true);
      formData.append("emailcopia", "contacto@respaldoschile.cl");
      request.send(formData);
      request.onreadystatechange = function () {
        if (request.readyState != 4) return;
        if (request.status == 200) {
          let objData = JSON.parse(request.responseText);
          if (objData.status) {
            Swal.fire({
              icon: "success",
              text: objData.msg,
              confirmButtonText: "Aceptar",
            });
            document.querySelector("#frmContacto").reset();
          } else {
            Swal.fire({
              icon: "error",
              text: objData.msg,
              confirmButtonText: "Aceptar",
            });
          }
        }
        divLoading.style.display = "none";
        return false;
      };
    },
    false
  );
}
