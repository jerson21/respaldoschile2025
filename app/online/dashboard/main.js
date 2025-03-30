$(document).ready(function () {


  tablapedidosenruta = $("#tablapedidosenruta").DataTable({
    iDisplayLength: 50,
    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent:
          "<div style=' font-size:0.8rem;'><div class='btn-group'><button class='btn btn-primary btnEditar' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Editar</button><button class='btn btn-danger btnBorrar' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;''>Borrar</button></div></div>",
      },
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
  });

  tablatapiceros = $("#tablatapiceros").DataTable({
    iDisplayLength: 50,
    columnDefs: [
      {
        targets: -1,
      },
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
  });

  tablaPersonas = $("#tablaPersonas").DataTable({
    iDisplayLength: 50,
    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent:
          "<div style=' fon-size:0.8rem;'><div class='btn-group'><button class='btn btn-primary btnEditar' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Editar</button><button class='btn btn-danger btnBorrar' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;''>Borrar</button></div></div>",
      },
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
  });

  // TABLA PERSONAS ///////////////////////////
  var tablaPersonas = $("#all-pedidos").DataTable({
    processing: true,
    serverSide: true,
    lengthMenu: [20],
    ajax: {
      url: "bd/crud.php",
      type: "POST",
      data: {
        opcion: 26,
      },
    },
    columns: [
      { data: "id" },
      { data: "rut_cliente" },
      { data: "modelo" },
      { data: "tamano" },
      { data: "alturabase" },
      { data: "tipotela" },
      { data: "color" },
      { data: "direccion" },
      { data: "numero" },
      { data: "comuna" },
      { data: "telefono" },
      { data: "estadopedido" },
      { data: null },
    ],
    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent:
          "<div class='text-center'><div class='btn-group'><button class='btn btn-primary btnEditar'>Editar</button><button class='btn btn-danger btnBorrar'>Borrar</button></div></div>",
        width: "80px",
      },
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
  });

  //TABLA PEDIDOS ////////////////////////////////////////////
  tablapedidos = $("#tabla-pedidos").DataTable({
    iDisplayLength: 50,
    lengthChange: false,
    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent:
          "<div style=' fon-size:0.8rem;'><div class='btn-group'><button class='btn btn-primary btnEditar' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Editar</button><button class='btn btn-danger btnBorrar' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;''>Borrar</button></div></div>",
      },
    ],

    language: {
      lengthMenu: "Mostrar _MENU_ registros",
      zeroRecords: "No se encontraron resultados",
      info: "Mostrando pedidos del _START_ al _END_ de un total de _TOTAL_ pedidos",
      infoEmpty: "Mostrando pedidos del 0 al 0 de un total de 0 pedidos",
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
  });

  //DATATABLE PEDIDOS PARA RETIRO
  tablapedidos_retiro = $("#tabla-pedidos_retiro").DataTable({
    iDisplayLength: 50,
    searching: false,
    lengthChange: false,
    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent:
          "<div style=' font-size:0.8rem;'><div class='btn-group'><button class='btn btn-primary btnEditar' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Editar</button><button class='btn btn-danger btnBorrar' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;''>Borrar</button><button class='btn btn-success btnEntregado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Entregar</button></div></div>",
      },
    ],
    paging: $("#tabla-pedidos_retiro tbody tr").length > 50, // Muestra la paginación solo si hay más de 50 filas en la tabla

    language: {
      lengthMenu: "Mostrar _MENU_ registros",
      zeroRecords: "No se encontraron resultados",
      info: "Mostrando pedidos del _START_ al _END_ de un total de _TOTAL_ pedidos",
      infoEmpty: "Mostrando pedidos del 0 al 0 de un total de 0 pedidos",
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
  });

//TABLA PEDIDOS ELIMINADOS
  tablapedidoseliminados = $("#tabla-pedidos-eliminados").DataTable({
    iDisplayLength: 50,
    columnDefs: [
      {
        targets: -1,
        data: null,
      },
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
  });

// TABLA VALIDAR PAGOS ///////////////////
  tablavalidarpagos = $("#tablavalidarpagos").DataTable({
    iDisplayLength: 50,
    columnDefs: [{}],
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
  });

  $("#btnNuevo").click(function () {
    $("#formPersonas").trigger("reset");
    $(".modal-header").css("background-color", "#1cc88a");
    $(".modal-header").css("color", "white");
    $(".modal-title").text("Nueva Persona");
    $("#modalCRUD").modal("show");
    id = null;
    opcion = 1; //alta
  });

/*
ESTO ESTABA DUPLICADO.    
  $(document).on("click", ".btnEditar", function () {
    console.log("capturado");
    var modalEditarPedido = document.getElementById("modalEditarPedido");
    var inputCampos = modalEditarPedido.querySelectorAll("input");

    // Limpiar los campos de entrada
    inputCampos.forEach(function (input) {
      input.value = "";
    });

    fila = $(this).closest("tr");
    id = fila.find("td:eq(0)").text();
    cant = fila.find("td:eq(0)").text();

    console.log(id);
    // Realizar una consulta a la base de datos utilizando el ID
    $.ajax({
      url: "get_pedido.php",
      type: "post",
      data: { id: id },
      success: function (resultado) {
        var firstKey = Object.keys(resultado)[0];
        var response = resultado[firstKey];
        var etapas = response.etapas;
        var botonPDF = document.querySelector(".botonPDF");

        // Asignar los valores recibidos a los campos correspondientes
        $("#ide").val(response.ide);
        $("#rut").val(response.rut);
        $("#nombre").val(response.nombre);
        $("#ide_webs").show();
        $("#ide_web").val(response.ide_webs);
        $("#costo_envio").val(response.costo_envio);
        $("#totalpagado").val(response.total_pagado);

        if (response.estadopedido === "0") {
          $("#estadopedido").val("En Espera");
        }
        if (response.estadopedido === "1") {
          $("#estadopedido").val("Aceptado");
        }
        if (response.estadopedido === "2") {
          $("#estadopedido").val("Enviado a fabricacion");
        }

        if (response.estadopedido === "5") {
          Swal.fire({
            title: "Pedido en fabricación",
            text: "El pedido se encuentra actualmente en proceso de fabricación. No se pueden realizar modificaciones en este momento.",
            icon: "info",
            confirmButtonText: "Aceptar",
            customClass: { confirmButton: "btn btn-primary" },
          });
          $("#estadopedido").val("Fabricando");
        }

        if (response.estadopedido === "6") {
          Swal.fire({
            title: "Pedido Listo",
            text: "El pedido esta listo. No se pueden realizar modificaciones.",
            icon: "info",
            confirmButtonText: "Aceptar",
            customClass: { confirmButton: "btn btn-primary" },
          });
          $("#estadopedido").val("Pedido Listo");

          $("#modelo").val(response.modelo).prop("disabled", true);
          $("#plazas").val(response.plazas).prop("disabled", true);
          $("#alturabase").val(response.altura).prop("disabled", true);

          $("#detalles_fabricacion").val(response.detalles_fabricacion);
          $("#anclaje").val(response.anclaje).prop("disabled", true);
          $("#tipo_boton").val(response.tipo_boton).prop("disabled", true);
          $("#tela").val(response.tela.toLowerCase()).prop("disabled", true);

          $("#color").val(response.color).prop("disabled", true);

          $("#telefono").val(response.telefono);
          $("#precio").val(response.precio);
          $("#abono").val(response.abono);
          $("#metodo_entrega").val(response.metodo_entrega);
          $("#detalle_entrega").val(response.detalle_entrega);

          if (response.metodo_entrega == "Retiro en tienda") {
            $("#direccion").val(response.direccion).prop("disabled", true);
            $("#dpto").val(response.dpto).prop("disabled", true);
            $("#numero").val(response.numero).prop("disabled", true);
            $("#comuna").val(response.comuna).prop("disabled", true);
          } else {
            $("#direccion").val(response.direccion);
            $("#dpto").val(response.dpto);
            $("#numero").val(response.numero);
            $("#comuna").val(response.comuna);
          }

          $("#comentarios").val(response.comentarios);
        } else {
          $("#modelo").val(response.modelo).prop("disabled", false);
          $("#plazas").val(response.plazas).prop("disabled", false);
          $("#alturabase").val(response.altura).prop("disabled", false);
          $("#detalles_fabricacion")
            .val(response.detalles_fabricacion)
            .prop("disabled", false);
          $("#anclaje").val(response.anclaje).prop("disabled", false);
          $("#tipo_boton").val(response.tipo_boton).prop("disabled", false);
          $("#tela").val(response.tela.toLowerCase()).prop("disabled", false);

          $("#color").val(response.color).prop("disabled", false);
          $("#metodo_entrega").val(response.metodo_entrega);
          $("#fecha_retiro").css("display", "block");
          $("#detalle_entrega").val(response.detalle_entrega);

          $("#telefono").val(response.telefono).prop("disabled", false);
          $("#precio").val(response.precio).prop("disabled", false);
          $("#abono").val(response.abono).prop("disabled", false);
          $("#comentarios").val(response.comentarios).prop("disabled", false);
          $("#tipo_entrega")
            .val(response.metodo_entrega)
            .prop("disabled", false);

          if (response.metodo_entrega == "Retiro en tienda") {
            $("#direccion").val(response.direccion).prop("disabled", true);
            $("#dpto").val(response.dpto).prop("disabled", true);
            $("#numero").val(response.numero).prop("disabled", true);
            $("#comuna").val(response.comuna).prop("disabled", true);
          } else {
            $("#direccion").val(response.direccion).prop("disabled", false);
            $("#dpto").val(response.dpto).prop("disabled", false);
            $("#numero").val(response.numero).prop("disabled", false);
            $("#comuna").val(response.comuna).prop("disabled", false);
          }
        }

        $("#num_orden").val(response.num_orden);

        botonPDF.onclick = function () {
          var url = "reportes/pedido.php?id=" + response.num_orden;
          window.open(url, "_blank");
        };

        $("#vendedor").val(response.vendedor);

        $("#fecha_ingreso").val(response.fecha_ingreso);

        for (var i = 0; i < etapas.length; i++) {
          var fecha = etapas[i].fecha;
          var usuario = etapas[i].usuario;

          //   $("#tela_cortada").val("Cortada el "+fecha+" Por "+usuario);

          var etapa = etapas[i];
          var fecha = etapa.fecha;
          var etapaId = etapa.idEtapa;
          var usuario = etapa.usuario;
          var NombreProceso = etapa.NombreProceso;
          var obs = etapa.obs;

          var container = document.createElement("div");
          container.classList.add("container2");

          var card = document.createElement("div");
          card.classList.add("card");

          var cardBody = document.createElement("div");
          cardBody.classList.add("card-body");
          cardBody.style.display = "flex";
          cardBody.style.flexDirection = "column";

          // Eliminar los elementos existentes en container2
          var detailsContainer = document.getElementById("detailsContainer");

          detailsContainer.innerHTML = "";

          for (var i = 0; i < etapas.length; i++) {
            var label = document.createElement("label");
            label.setAttribute("for", etapas[i].etapaId);
            label.classList.add("col-form-label", "small-text");
            label.innerText =
              etapas[i].NombreProceso +
              ": " +
              etapas[i].fecha +
              " " +
              etapas[i].usuario +
              " " +
              etapas[i].obs;

            cardBody.appendChild(label);
          }

          card.appendChild(cardBody);
          container.appendChild(card);

          var detailsContainer = document.getElementById("detailsContainer");
          detailsContainer.appendChild(container);
        }

        $(".modal-header").css("background-color", "#4e73df");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Pedido");

        // Mostrar el modal
        $("#modalEditarPedido").modal("show");
        //$("#modalEditarPedido_general").modal("show");
      },
      error: function (error) {
        console.log(error);
        // Manejar el error de la consulta a la base de datos
      },
    });

    $(".modal-header .close").click(function () {
      $("#modalEditarPedido").modal("hide");
    });
  });

  */


  var fila; //capturar la fila para editar o borrar el registro
  //botón EDITAR  pedido
  $(document).on("click", ".btnEditar", function () {
    var modalEditarPedido = document.getElementById("modalEditarPedido");
    var inputCampos = modalEditarPedido.querySelectorAll("input");

    // Limpiar los campos de entrada
    inputCampos.forEach(function (input) {
      input.value = "";
    });

    fila = $(this).closest("tr");
    id = fila.find("td:eq(1)").text();
    cant = fila.find("td:eq(0)").text();

    // Realizar una consulta a la base de datos utilizando el ID
    $.ajax({
      url: "get_pedido.php",
      type: "post",
      data: { id: id },
      success: function (resultado) {
        var firstKey = Object.keys(resultado)[0];
        var response = resultado[firstKey];
        var etapas = response.etapas;
        var botonPDF = document.querySelector(".botonPDF");
        // Asignar los valores recibidos a los campos correspondientes
        $("#ide").val(response.ide);
        cargarPagosAsociados(response.num_orden);
        $("#rut").val(response.rut);
        $("#nombre").val(response.nombre);
        $("#ide_webs").show();
        $("#ide_web").val(response.orden_ext); // Verifica este campo, puede que necesites ajustarlo
        $("#costo_envio").val(response.costo_envio);
        $("#totalpagado").val(response.total_pagado);

        if (response.estadopedido === "0") {
          $("#estadopedido").val("En Espera");
        }
        if (response.estadopedido === "1") {
          $("#estadopedido").val("Aceptado");
        }
        if (response.estadopedido === "2") {
          $("#estadopedido").val("Enviado a fabricacion");
        }

        if (response.estadopedido === "5") {
          Swal.fire({
            title: "Pedido en fabricación",
            text: "El pedido se encuentra actualmente en proceso de fabricación. No se pueden realizar modificaciones en este momento.",
            icon: "info",
            confirmButtonText: "Aceptar",
            customClass: { confirmButton: "btn btn-primary" },
          });
          $("#estadopedido").val("Fabricando");
        }

        if (response.estadopedido === "6") {
          Swal.fire({
            title: "Pedido Listo",
            text: "El pedido esta listo. No se pueden realizar modificaciones.",
            icon: "info",
            confirmButtonText: "Aceptar",
            customClass: { confirmButton: "btn btn-primary" },
          });
          $("#estadopedido").val("Pedido Listo");

          $("#modelo").val(response.modelo).prop("disabled", true);
          $("#plazas").val(response.plazas).prop("disabled", true);
          $("#alturabase").val(response.altura).prop("disabled", true);

          $("#detalles_fabricacion").val(response.detalles_fabricacion);
          $("#anclaje").val(response.anclaje).prop("disabled", true);
          $("#tipo_boton").val(response.tipo_boton).prop("disabled", true);
          $("#tela").val(response.tela.toLowerCase()).prop("disabled", true);

          $("#color").val(response.color).prop("disabled", true);

          $("#telefono").val(response.telefono);
          $("#precio").val(response.precio);
          $("#abono").val(response.abono);
          $("#metodo_entrega").val(response.metodo_entrega);
          $("#referencia").val(response.detalle_entrega);
          $("#detalle_entrega").val(response.detalle_entrega);

          if (response.metodo_entrega == "Retiro en tienda") {
            $("#direccion").val(response.direccion).prop("disabled", true);
            $("#dpto").val(response.dpto).prop("disabled", true);
            $("#numero").val(response.numero).prop("disabled", true);
            $("#comuna").val(response.comuna).prop("disabled", true);
          } else {
            $("#direccion").val(response.direccion);
            $("#dpto").val(response.dpto);
            $("#numero").val(response.numero);
            $("#comuna").val(response.comuna);
          }

          $("#comentarios").val(response.comentarios);
        } else {
          $("#modelo").val(response.modelo).prop("disabled", false);
          $("#plazas").val(response.plazas).prop("disabled", false);
          $("#alturabase").val(response.altura).prop("disabled", false);
          $("#detalles_fabricacion")
            .val(response.detalles_fabricacion)
            .prop("disabled", false);
          $("#anclaje").val(response.anclaje).prop("disabled", false);
          $("#tipo_boton").val(response.tipo_boton).prop("disabled", false);
          $("#tela").val(response.tela.toLowerCase()).prop("disabled", false);

          $("#color").val(response.color).prop("disabled", false);
          $("#metodo_entrega").val(response.metodo_entrega);
          $("#fecha_retiro").css("display", "block");
          $("#referencia").val(response.detalle_entrega);
          $("#detalle_entrega").val(response.detalle_entrega);


          $("#telefono").val(response.telefono).prop("disabled", false);
          $("#precio").val(response.precio).prop("disabled", false);
          $("#abono").val(response.abono).prop("disabled", false);
          $("#comentarios").val(response.comentarios).prop("disabled", false);
          $("#tipo_entrega")
            .val(response.metodo_entrega)
            .prop("disabled", false);

          if (response.metodo_entrega == "Retiro en tienda") {
            $("#direccion").val(response.direccion).prop("disabled", true);
            $("#dpto").val(response.dpto).prop("disabled", true);
            $("#numero").val(response.numero).prop("disabled", true);
            $("#comuna").val(response.comuna).prop("disabled", true);
          } else {
            $("#direccion").val(response.direccion).prop("disabled", false);
            $("#dpto").val(response.dpto).prop("disabled", false);
            $("#numero").val(response.numero).prop("disabled", false);
            $("#comuna").val(response.comuna).prop("disabled", false);
          }
        }

        $("#num_orden").val(response.num_orden);

        botonPDF.onclick = function () {
          var url = "reportes/pedido.php?id=" + response.num_orden;
          window.open(url, "_blank");
        };

        $("#vendedor").val(response.vendedor);

        $("#fecha_ingreso").val(response.fecha_ingreso);

        for (var i = 0; i < etapas.length; i++) {
          var fecha = etapas[i].fecha;
          var usuario = etapas[i].usuario;

          //   $("#tela_cortada").val("Cortada el "+fecha+" Por "+usuario);

          var etapa = etapas[i];
          var fecha = etapa.fecha;
          var etapaId = etapa.idEtapa;
          var usuario = etapa.usuario;
          var NombreProceso = etapa.NombreProceso;
          var obs = etapa.obs;

          var container = document.createElement("div");
          container.classList.add("container2");

          var card = document.createElement("div");
          card.classList.add("card");

          var cardBody = document.createElement("div");
          cardBody.classList.add("card-body");
          cardBody.style.display = "flex";
          cardBody.style.flexDirection = "column";

          // Eliminar los elementos existentes en container2
          var detailsContainer = document.getElementById("detailsContainer");

          detailsContainer.innerHTML = "";

          for (var i = 0; i < etapas.length; i++) {
            var label = document.createElement("label");
            label.setAttribute("for", etapas[i].etapaId);
            label.classList.add("col-form-label", "small-text");
            label.innerText =
              etapas[i].NombreProceso +
              ": " +
              etapas[i].fecha +
              " " +
              etapas[i].usuario +
              " " +
              etapas[i].obs;

            cardBody.appendChild(label);
          }

          card.appendChild(cardBody);
          container.appendChild(card);

          var detailsContainer = document.getElementById("detailsContainer");
          detailsContainer.appendChild(container);
        }

        $(".modal-header").css("background-color", "#4e73df");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Pedido");

        // Mostrar el modal
        $("#modalEditarPedido").modal("show");
        //$("#modalEditarPedido_general").modal("show");
      },
      error: function (error) {
        console.log(error);
        // Manejar el error de la consulta a la base de datos
      },
    });

    $(".modal-header .close").click(function () {
      $("#modalEditarPedido").modal("hide");
    });
  });

////////////////// AGREGAR PAGO EN EL MODULO DE AGREGAR PEDIDO AL FINALIZAR 

$(document).on("click", ".btnAddPagoMOD", function () {
  var modalEditarOrden = document.getElementById("modalEditarOrden");
  var id = $(this).data("id");

  // Limpiar los campos de entrada


 // Obtener el RUT actual de la nueva orden

  // Asegurarse de que el selector de búsqueda se reinicie correctamente

  // Oculta el div de buscar pagos
  $("#divBuscarPagos").hide(); // Ajusta el id según sea necesario


  


  cargarPagosAsociados(id); // Asumiendo que esta es una función definida en otra parte

  cargarDatosPedido(id);
  $("#modalEditarOrden").css("z-index", "1100");

  var modalEditarOrden = document.getElementById("modalEditarOrden");
  modalEditarOrden.addEventListener("hidden.bs.modal", function (event) {
    // Código a ejecutar después de que el modal se haya cerrado.
    console.log("Modal cerrado");
    
    $("#example").DataTable().ajax.reload();
  });

  $(document).on("click", "#btnGuardar", function () {
    console.log("Guardando los cambios...");
    // Lógica para guardar los cambios
    $("#modalEditarOrden").modal("hide");

    $("#example").DataTable().ajax.reload();
  });
});


  
  // EDITAR ORDEN //////////////////////////////////////////////////
  $(document).on("click", ".btnEditarOrden", function () {
    var modalEditarOrden = document.getElementById("modalEditarOrden");
    var inputCampos = modalEditarOrden.querySelectorAll("input");

    // Limpiar los campos de entrada
    inputCampos.forEach(function (input) {
      input.value = "";
    });

    var nuevoRut = $("#rutb").val(); // Obtener el RUT actual de la nueva orden

    // Asegurarse de que el selector de búsqueda se reinicie correctamente

    // Oculta el div de buscar pagos
    $("#divBuscarPagos").hide(); // Ajusta el id según sea necesario

    var fila = $(this).closest("tr");
    var id = fila.find("td:eq(1)").text().trim(); // Asegúrate de ajustar el índice según tu tabla
    cargarPagosAsociados(id); // Asumiendo que esta es una función definida en otra parte HAY QUE LLAMARLA*******

    cargarDatosPedido(id);

    var modalEditarOrden = document.getElementById("modalEditarOrden");
    modalEditarOrden.addEventListener("hidden.bs.modal", function (event) {
      // Código a ejecutar después de que el modal se haya cerrado.
      console.log("Modal cerrado");

     // $("#example").DataTable().ajax.reload();
      
    });

    $(document).on("click", "#btnGuardar", function () {
      console.log("Guardando los cambios...");
      // Lógica para guardar los cambios
      $("#modalEditarOrden").modal("hide");

      $("#example").DataTable().ajax.reload();
    });
  });
  
// Obtener la URL actual
const url = new URL(window.location.href);

// Obtener los parámetros de la URL
const params = new URLSearchParams(url.search);

// Obtener el valor de la variable "ruta"

const ruta_cargada = params.get('ruta') || '';

  function cargarDatosPedido(id) {
    console.log("cargando nuevos datos");
    // Realizar una consulta a la base de datos utilizando el ID
    $.ajax({
      url: "rbot/getpedido.php?method=num_orden", // Asegúrate de que la URL es correcta
      type: "post",
      data: { method: "num_orden", id: id, ruta: ruta_cargada },
      dataType: "json",
      success: function (resultado) {
        var pedidos = resultado.pedidos; // Objeto con todos los pedidos
        var totalPrecioTodosLosPedidos = resultado.totalPrecioTodosLosPedidos;
        var total_pagado = resultado.totalPagado;
        var total_precioproductos = resultado.total_precioproductos;

        // Trabajar con el primer pedido como ejemplo
        var firstKey = Object.keys(pedidos)[0];
        var response = pedidos[firstKey];
       // var etapas = response.etapas || [];

       // console.log(response);
        actualizarUIConPedido(
          response,
          total_pagado,
          totalPrecioTodosLosPedidos,
          total_precioproductos
        );

        // Actualizar tabla de pedidos
        actualizarTablaDePedidos(pedidos);

        // Mostrar el modal
        $("#modalEditarOrden").modal("show");
      },
      error: function (error) {
        console.error("Error al obtener los datos del pedido:", error);
      },
    });
  }

  function actualizarUIConPedido(
    pedido,
    total_pagado,
    totalPrecioTodosLosPedidos,
    total_precioproductos
  ) {
    // Asignar valores a campos específicos del formulario/modal
    $("#n_orden").val(pedido.num_orden);
    $("#rutb").val(pedido.cliente.rut);
    $("#nombreb").val(pedido.cliente.nombre);
    $("#lugar_venta").val(pedido.cliente.lugar_venta);
    console.log("aa"+pedido.orden_ext)
    $("#ide_webs").show();
    $("#ide_web").val(pedido.orden_ext); // Verifica este campo, puede que necesites ajustarlo
    $("#costo_envio").val(pedido.costo_envio);
    $("#totalpagado").val(pedido.total_pagado);
    $("#total_productos").val(total_precioproductos);
    $("#total_precio").val(totalPrecioTodosLosPedidos);
    $("#despacho_valor").val(pedido.despacho);
    
    var metododepago = (pedido.mododepago);
    $("#mododepago").val(metododepago.toUpperCase());
    $("#telefono").val(pedido.cliente.telefono);
    $("#fecha_ingresob").val(pedido.fecha_ingreso);
    $("#vendedorb").val(pedido.vendedor);
    $("#referencia").val(pedido.detalle_entrega);

    // Aquí puedes continuar con los demás campos...

    // Ejemplo de manejo de estados
    var estadoPedido = $("#estadopedido");
    switch (pedido.estado_orden) {
      case "0":
        estadoPedido.val("En Proceso");
        break;
      case "1":
        estadoPedido.val("Finalizado");
        break;
      case "2":
        estadoPedido.val("Enviado a fabricación");
        break;
      // Agrega más casos según sea necesario
      default:
        estadoPedido.val("Desconocido");
    }

    // Si necesitas trabajar con etapas, asegúrate de ajustar esta parte según tu estructura de datos
    // Por ejemplo, para mostrar las etapas en algún elemento del DOM
  }

  function actualizarTablaDePedidos(pedidos) {
    var tbody = $("#customTableList tbody");
    tbody.empty(); // Limpiar la tabla antes de agregar los nuevos elementos

    Object.values(pedidos).forEach(function (pedido) {
      // y queremos mostrar todos ellos, iteramos sobre 'detalle_pedidos' también
      pedido.detalle_pedidos.forEach(function (detalle) {
        // Define el botón en función del estado del pedido
        var botonEstado = "";
        switch (detalle.estadopedido) {
          case "1":
            botonEstado =
              '<button type="button" class="btn btn-info btn-sm">Estado 1</button>';
            break;
          case "6":
            botonEstado =
              '<button type="button" class="btn btn-warning btn-sm">Listo</button>';
            break;
          case "7":
            botonEstado =
              '<button type="button" class="btn btn-warning btn-sm">Despacho Iniciado</button>';
            break;
          case "8":
            botonEstado =
              '<button type="button" class="btn btn-success btn-sm">Cargado</button>';
            break;
          case "9":
            botonEstado =
              '<button type="button" class="btn btn-warning btn-sm">Entregado</button>';
            break;
          default:
            botonEstado = "N/A"; // Por defecto, si no es ninguno de los anteriores
        }
        var fila = `<tr>
          <td>${detalle.id}</td>
          <td>${detalle.modelo || "N/A"} ${
          detalle.tamano || "N/A"
        } ${capitalize(detalle.tela || "N/A")} ${capitalize(
          detalle.color || "N/A"
        )}</td>
          <td>${detalle.cantidad || "1"}</td>
          <td>${pedido.cliente.direccion || "N/A"} ${
          pedido.cliente.numero || "N/A"
        } / ${pedido.cliente.dpto || "N/A"}, ${
          pedido.cliente.comuna || "N/A"
        }</td>
          <td>${detalle.precio || "N/A"}</td>
          <td>N/A</td> <!-- Suponiendo que 'Referencia de Pago' no está disponible en el detalle -->
          <td>${pedido.fecha_ingreso || "N/A"}</td>
          <td>${botonEstado}</td>
      </tr>`;
        tbody.append(fila);
      });
    });
  }

  function capitalize(text) {
    return text.charAt(0).toUpperCase() + text.slice(1).toLowerCase();
  }

  // fin editar orden

  //botón EDITAR  PRODUCTO
  $(document).on("click", ".btnEditarProd", function () {
    var modalEditarPedido = document.getElementById("modalEditarPedido");
    var inputCampos = modalEditarPedido.querySelectorAll("input");

    // Limpiar los campos de entrada
    inputCampos.forEach(function (input) {
      input.value = "";
    });

    fila = $(this).closest("tr");
    id = fila.find("td:eq(0)").text();
    cant = fila.find("td:eq(0)").text();

    // Realizar una consulta a la base de datos utilizando el ID

    $.ajax({
      url: "get_pedido.php",
      type: "post",
      data: { id: id },
      success: function (resultado) {
        var firstKey = Object.keys(resultado)[0];
        var response = resultado[firstKey];
        var etapas = response.etapas;
        var botonPDF = document.querySelector(".botonPDF");

        // Asignar los valores recibidos a los campos correspondientes
        $("#ide").val(response.ide);
        $("#rut").val(response.rut);
        $("#nombre").val(response.nombre);
        $("#ide_webs").show();
        $("#ide_web").val(response.orden_ext);
        $("#costo_envio").val(response.costo_envio);
        $("#totalpagado").val(response.total_pagado);
        $("#referencia").val(response.detalle_entrega);

        if (response.estadopedido === "0") {
          $("#estadopedido").val("En Espera");
        }
        if (response.estadopedido === "1") {
          $("#estadopedido").val("Aceptado");
        }
        if (response.estadopedido === "2") {
          $("#estadopedido").val("Enviado a fabricacion");
        }

        if (response.estadopedido === "5") {
          Swal.fire({
            title: "Pedido en fabricación",
            text: "El pedido se encuentra actualmente en proceso de fabricación. No se pueden realizar modificaciones en este momento.",
            icon: "info",
            confirmButtonText: "Aceptar",
            customClass: { confirmButton: "btn btn-primary" },
          });
          $("#estadopedido").val("Fabricando");
        }

        if (response.estadopedido === "6") {
          Swal.fire({
            title: "Pedido Listo",
            text: "El pedido esta listo. No se pueden realizar modificaciones.",
            icon: "info",
            confirmButtonText: "Aceptar",
            customClass: { confirmButton: "btn btn-primary" },
          });
          $("#estadopedido").val("Pedido Listo");

          $("#modelo").val(response.modelo).prop("disabled", true);
          $("#plazas").val(response.plazas).prop("disabled", true);
          $("#alturabase").val(response.altura).prop("disabled", true);

          $("#detalles_fabricacion").val(response.detalles_fabricacion);
          $("#anclaje").val(response.anclaje).prop("disabled", true);
          $("#tipo_boton").val(response.tipo_boton).prop("disabled", true);
          $("#tela").val(response.tela.toLowerCase()).prop("disabled", true);

          $("#color").val(response.color).prop("disabled", true);

          $("#telefono").val(response.telefono);
          $("#precio").val(response.precio);
          $("#abono").val(response.abono);
          $("#metodo_entrega").val(response.metodo_entrega);
          $("#referencia").val(response.detalle_entrega);

          if (response.metodo_entrega == "Retiro en tienda") {
            $("#direccion").val(response.direccion).prop("disabled", true);
            $("#dpto").val(response.dpto).prop("disabled", true);
            $("#numero").val(response.numero).prop("disabled", true);
            $("#comuna").val(response.comuna).prop("disabled", true);
          } else {
            $("#direccion").val(response.direccion);
            $("#dpto").val(response.dpto);
            $("#numero").val(response.numero);
            $("#comuna").val(response.comuna);
          }

          $("#comentarios").val(response.comentarios);
        } else {
          $("#modelo").val(response.modelo).prop("disabled", false);
          $("#plazas").val(response.plazas).prop("disabled", false);
          $("#alturabase").val(response.altura).prop("disabled", false);
          $("#detalles_fabricacion")
            .val(response.detalles_fabricacion)
            .prop("disabled", false);
          $("#anclaje").val(response.anclaje).prop("disabled", false);
          $("#tipo_boton").val(response.tipo_boton).prop("disabled", false);
          $("#tela").val(response.tela.toLowerCase()).prop("disabled", false);

          $("#color").val(response.color).prop("disabled", false);
          $("#metodo_entrega").val(response.metodo_entrega);
          $("#fecha_retiro").css("display", "block");
          $("#referencia").val(response.detalle_entrega);

          $("#telefono").val(response.telefono).prop("disabled", false);
          $("#precio").val(response.precio).prop("disabled", false);
          $("#abono").val(response.abono).prop("disabled", false);
          $("#comentarios").val(response.comentarios).prop("disabled", false);
          $("#tipo_entrega")
            .val(response.metodo_entrega)
            .prop("disabled", false);

          if (response.metodo_entrega == "Retiro en tienda") {
            $("#direccion").val(response.direccion).prop("disabled", true);
            $("#dpto").val(response.dpto).prop("disabled", true);
            $("#numero").val(response.numero).prop("disabled", true);
            $("#comuna").val(response.comuna).prop("disabled", true);
          } else {
            $("#direccion").val(response.direccion).prop("disabled", false);
            $("#dpto").val(response.dpto).prop("disabled", false);
            $("#numero").val(response.numero).prop("disabled", false);
            $("#comuna").val(response.comuna).prop("disabled", false);
          }
        }

        $("#num_orden").val(response.num_orden);

        cargarPagosAsociados(response.num_orden);

        botonPDF.onclick = function () {
          var url = "reportes/pedido.php?id=" + response.num_orden;
          window.open(url, "_blank");
        };

        $("#vendedor").val(response.vendedor);

        $("#fecha_ingreso").val(response.fecha_ingreso);

        for (var i = 0; i < etapas.length; i++) {
          var fecha = etapas[i].fecha;
          var usuario = etapas[i].usuario;

          //   $("#tela_cortada").val("Cortada el "+fecha+" Por "+usuario);

          var etapa = etapas[i];
          var fecha = etapa.fecha;
          var etapaId = etapa.idEtapa;
          var usuario = etapa.usuario;
          var NombreProceso = etapa.NombreProceso;
          var obs = etapa.obs;

          var container = document.createElement("div");
          container.classList.add("container2");

          var card = document.createElement("div");
          card.classList.add("card");

          var cardBody = document.createElement("div");
          cardBody.classList.add("card-body");
          cardBody.style.display = "flex";
          cardBody.style.flexDirection = "column";

          // Eliminar los elementos existentes en container2
          var detailsContainer = document.getElementById("detailsContainer");

          detailsContainer.innerHTML = "";

          for (var i = 0; i < etapas.length; i++) {
            var label = document.createElement("label");
            label.setAttribute("for", etapas[i].etapaId);
            label.classList.add("col-form-label", "small-text");
            label.innerText =
              etapas[i].NombreProceso +
              ": " +
              etapas[i].fecha +
              " " +
              etapas[i].usuario +
              " " +
              etapas[i].obs;
            cardBody.appendChild(label);
          }

          card.appendChild(cardBody);
          container.appendChild(card);

          var detailsContainer = document.getElementById("detailsContainer");
          detailsContainer.appendChild(container);
        }

        $(".modal-header").css("background-color", "#4e73df");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Pedido");

        // Mostrar el modal
        $("#modalEditarPedido").modal("show");
        //$("#modalEditarPedido_general").modal("show");
      },
      error: function (error) {
        console.log(error);
        // Manejar el error de la consulta a la base de datos
      },
    });

    $(".modal-header .close").click(function () {
      $("#modalEditarPedido").modal("hide");
      event.stopPropagation();

    });
  });

  function capitalize(s) {    return s[0].toUpperCase() + s.slice(1);  }


  function capturarSegundoNumero(cadena) {
    // Buscar los números presentes en la cadena
    const numerosEncontrados = cadena.match(/\d+(\.\d+)?/g);
    // Verificar si se encontraron números y si hay al menos dos
    if (numerosEncontrados && numerosEncontrados.length >= 2) {
      // Obtener el segundo número encontrado
      const segundoNumero = parseFloat(numerosEncontrados[1]);
      return segundoNumero;
    }
    return null; // Si no se encontró el segundo número, retorna null o puedes ajustar el valor de retorno según tus necesidades.
  }

  function capturarPrimerNumero(cadena) {
    // Buscar los números presentes en la cadena
    const numerosEncontrados = cadena.match(/\d+(\.\d+)?/g);
    // Verificar si se encontraron números y si hay al menos uno
    if (numerosEncontrados && numerosEncontrados.length >= 1) {
      // Obtener el primer número encontrado
      const primerNumero = parseFloat(numerosEncontrados[0]);
      return primerNumero;
    }
    return null; // Si no se encontró el primer número, retorna null o puedes ajustar el valor de retorno según tus necesidades.
  }

  function convertirCmAMetros(cadena) {// Convertir los centímetros a metros
      var valorMetros = cadena / 100;
    // Mostrar el resultado en el elemento HTML
    return valorMetros;
  }

  //botón EDITAR ESTADO
  $(document).on("click", ".btnEditarestado", function () {
    fila = $(this).closest("tr");
    id = parseInt(fila.find("td:eq(1)").text());
    cant = parseInt(fila.find("td:eq(0)").text());

    rut = fila.find("td:eq(2)").text();
    pais = fila.find("td:eq(3)").text();
    edad = parseInt(fila.find("td:eq(4)").text());

    $("#id").val(id);
    $("#estado").val(pais);
    $("#edad").val(edad);
    opcion = 4; //editar

    $(".modal-header").css("background-color", "#4e73df");
    $(".modal-header").css("color", "white");
    $(".modal-title").text("Editar Estado");
    $("#modalCRUD").modal("show");
  });

  //botón EDITAR ESTADO  NUEVA VERSION
  $(document).on("click", ".btnEditarestado2", function () {
    fila = $(this).closest("tr");
    id = parseInt(fila.find("td:eq(0)").text());
    cant = parseInt(fila.find("td:eq(0)").text());

    rut = fila.find("td:eq(2)").text();
    pais = fila.find("td:eq(3)").text();
    edad = parseInt(fila.find("td:eq(4)").text());

    $("#id").val(id);
    $("#estado").val(pais);
    $("#edad").val(edad);
    opcion = 4; //editar

    $(".modal-header").css("background-color", "#4e73df");
    $(".modal-header").css("color", "white");
    $(".modal-title").text("Editar Estado");
    $("#modalCRUD").modal("show");
  });

  // BOTON PARA PROCEDIMIENTO DE CORTAR TELA //////////////
  $(document).on("click", ".btncortartela", function () {
    id = parseInt($(this).closest("tr").find("td:eq(0)").text());
    tamano = $(this).closest("tr").find("td:eq(1)").text();
    alt = $(this).closest("tr").find("td:eq(2)").text();
    material = $(this).closest("tr").find("td:eq(4)").text();
    color = $(this).closest("tr").find("td:eq(5)").text();

    telaycolor =
      $(this).closest("tr").find("td:eq(4)").text() +
      " " +
      $(this).closest("tr").find("td:eq(5)").text();
    metraje_capturado = $(this).closest("tr").find("td:eq(8)").text();
    metraje = capturarSegundoNumero(metraje_capturado);
    aldobles = capturarPrimerNumero(metraje_capturado);

    telaycolor = capitalize(telaycolor);
    Swal.fire({
      title: "¿Confirma corte de tela?",
      text: tamano + " " + alt + " " + telaycolor,
      showCancelButton: true,
      confirmButtonText: "Sí",
      cancelButtonText: "No",
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          title: "¿Cortó tela adicional?",
          showDenyButton: true,
          text: telaycolor,
          showCancelButton: true,
          confirmButtonText: "Sí",
          denyButtonText: "No",
        }).then((result) => {
          if (result.isConfirmed) {
            Swal.fire({
              title: "Ingrese el metraje adicional",
              html:
                telaycolor +
                "<br>" +
                metraje +
                " Mt o " +
                aldobles +
                " al dobles<hr>" +
                "Razón de corte:<br>" +
                '<label><input type="checkbox" name="razon" value="Altura de base">Altura de base</label>  &nbsp;&nbsp;&nbsp;' +
                '<label><input type="checkbox" name="razon" value="Orejas">Orejas</label>&nbsp;&nbsp;&nbsp;' +
                '<label><input type="checkbox" name="razon" value="Especial">Especial</label> <br>' +
                '<label><input type="checkbox" name="razon" value="Otro">Otro</label><br>' +
                '<input type="text" id="otraRazon" class="custom-input" placeholder="Escriba la razón" style="display: none; margin-bottom:5px; width:180px;">' +
                '<input type="number" id="swal2-input" name="swal2-input" class="custom-input" placeholder="Metraje en cm"><br><div style="font-size:12px; margin-top:15px; background-color:#EBEBEB;padding:7px; border-radius:5px; ">Importante: Debe ser en centimetros y por el metraje total.(No al dobles) </div><br>',
              showCancelButton: true,
              confirmButtonText: "Confirmar",
              cancelButtonText: "Cancelar",

              preConfirm: () => {
                const metrajeAdicional_ingresado =
                  Swal.getPopup().querySelector("#swal2-input").value;
                const metrajeAdicional = convertirCmAMetros(
                  metrajeAdicional_ingresado
                );
                const checkboxes = Swal.getPopup().querySelectorAll(
                  'input[name="razon"]:checked'
                );
                const razonesCorte = Array.from(checkboxes).map(
                  (checkbox) => checkbox.value
                );
                let otraRazon = "";
                if (razonesCorte.length === 0) {
                  Swal.showValidationMessage(
                    "Debes seleccionar al menos una razón de corte"
                  );
                  return false;
                }
                if (razonesCorte.includes("Otro")) {
                  otraRazon = Swal.getPopup().querySelector("#otraRazon").value;
                }
                return { metrajeAdicional, razonesCorte, otraRazon, metraje };
              },
              allowOutsideClick: () => !Swal.isLoading(),
            }).then((result) => {
              if (result.isConfirmed) {
                const { metrajeAdicional, razonesCorte, otraRazon } =
                  result.value;
                // Verificar si se han completado los campos antes de enviar la solicitud AJAX
                if (
                  metrajeAdicional &&
                  (razonesCorte.length > 0 || otraRazon)
                ) {
                  // Realizar la solicitud AJAX o la lógica adecuada para enviar el formulario

                  enviarSolicitudAjax(
                    metrajeAdicional,
                    razonesCorte,
                    otraRazon
                  );
                } else {
                  // No se han completado los campos necesarios, no enviar el formulario
                  // Aquí puedes mostrar un mensaje de error o realizar alguna otra acción
                  console.log("No se han completado los campos necesarios");
                }
              } else if (result.isDismissed) {
                // Usuario canceló, no enviar el formulario
                // Aquí puedes realizar alguna acción o mostrar un mensaje
                console.log("Usuario canceló");
              }
            });

            // Controlador de eventos para mostrar/ocultar el campo de texto adicional
            const otraRazonCheckbox = Swal.getPopup().querySelector(
              'input[name="razon"][value="Otro"]'
            );
            const otraRazonInput = Swal.getPopup().querySelector("#otraRazon");
            otraRazonCheckbox.addEventListener("change", (event) => {
              otraRazonInput.style.display = event.target.checked
                ? "block"
                : "none";
            });
          } else if (result.isDenied) {
            // Usuario negó, no enviar el formulario
            // Aquí puedes realizar alguna acción o mostrar un mensaje
            console.log("Usuario negó");
            enviarSolicitudAjax();
          } else if (result.isDismissed) {
            // Usuario canceló, no enviar el formulario
            // Aquí puedes realizar alguna acción o mostrar un mensaje
            console.log("Usuario canceló");
          }
        });
      } else if (result.isDismissed) {
        // Usuario canceló, no enviar el formulario
        // Aquí puedes realizar alguna acción o mostrar un mensaje
        console.log("Usuario canceló");
      }
    });

    function enviarSolicitudAjax(metrajes, razonesCorte, otraRazon) {
      const data = { opcion: 17, id: id, material: material, color: color };
      if (metrajes) {
        data.metraje = metrajes + metraje;
      } else {
        data.metraje = metraje;
      }
      if (razonesCorte) {
        data.razonesCorte = razonesCorte;
      }
      if (razonesCorte) {
        data.otraRazon = otraRazon;
      }

      $.ajax({
        url: "bd/crud.php",
        type: "POST",
        dataType: "json",
        data: data,
        success: function (data) {
          eval(data);
          location.reload(true);
        },
      });
    }
  });


// BOTÓN PARA PROCEDIMIENTO DE CORTE DE ESTRUCTURA
$(document).on("click", ".btncortaresqueleto", function () {
  // Se capturan los datos de la fila
  const $row = $(this).closest("tr");
  const id = parseInt($row.find("td:eq(0)").text());
  const modelo = $row.find("td:eq(1)").text();
  let tamano = $row.find("td:eq(2)").text().trim();
  const alt = $row.find("td:eq(3)").text();
  let  obs = $row.find("td:eq(4)").text();
  obs = obs.charAt(0).toUpperCase() + obs.slice(1);

  const material = $row.find("td:eq(4)").text();
  const color = $row.find("td:eq(5)").text();
  let telaycolor = material + " " + color;
  // Se asume que existe la función capitalize para poner en mayúscula la primera letra
  telaycolor = capitalize(telaycolor);

  // Se formatea el tamaño
  if (tamano === "1") {
    tamano = "1 plaza";
  } else if (tamano === "2") {
    tamano = "2 plazas";
  }

  // Se captura el metraje; se asume que capturarSegundoNumero está definida
  const metraje_capturado = $row.find("td:eq(8)").text();
  const metraje = capturarSegundoNumero(metraje_capturado);

  // Se muestra el Swal con el detalle y confirmación de corte de tela
  Swal.fire({
    title: "¿Confirma corte de Esqueleto?",
    html: `
      <p><strong>Modelo:</strong> ${modelo}</p>
      <p><strong>Tamaño:</strong> ${tamano} | <strong>Base:</strong> ${alt}</p>
      <p><strong>Observación:</strong> ${obs}</p>
    `,
    icon: "question",
    showCancelButton: true,
    confirmButtonText: "Sí, cortar",
    cancelButtonText: "No, cancelar"
  }).then((result) => {
    if (result.isConfirmed) {
      enviarSolicitudAjax2();
    } else {
      console.log("Corte cancelado");
    }
  });

  // Función para enviar la solicitud AJAX
  function enviarSolicitudAjax2() {
    const data = { opcion: 223, id: id, metraje: 1 };
    $.ajax({
      url: "bd/crud.php",
      type: "POST",
      dataType: "json",
      data: data,
      success: function (response) {
        // Se evalúa el resultado devuelto por el servidor (cuidado con eval, úsalo solo si es seguro)
        eval(response);
        location.reload(true);
      },
      error: function (err) {
        console.error("Error en la solicitud AJAX", err);
      }
    });
  }
});



  // BOTON PARA AGREGAR PEDIDO A TAPICERO 2 
  $(document).on("click", ".btnfelipe", function () {
    id = parseInt($(this).closest("tr").find("td:eq(0)").text());

    Swal.fire({
      title: "¿Está seguro de Agregar a Tapicero 2 el respaldo: " + id + "?",
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Sí, agregar",
      cancelButtonText: "Cancelar",
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "bd/crud.php",
          type: "POST",
          dataType: "json",
          data: { opcion: 15, id: id, id_tapicero: "2" },
          success: function (data) {
            if (data == 1) {
              Swal.fire("Asignado correctamente", "", "success").then(() => {
                location.reload(true);
              });
            } else {
              Swal.fire(
                "Error",
                "Ocurrió un error al asignar el respaldo",
                "error"
              ).then(() => {
                location.reload(true);
              });
            }
          },
          error: function () {
            Swal.fire("Error", "Ocurrió un error en la solicitud", "error");
          },
        });
      }
    });
  });
    // BOTON PARA AGREGAR PEDIDO A TAPICERO 1 
  $(document).on("click", ".btnjaime", function () {
    id = parseInt($(this).closest("tr").find("td:eq(0)").text());

    Swal.fire({
      title: "¿Está seguro de Agregar a Tapicero 1 el respaldo: " + id + "?",
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Sí, agregar",
      cancelButtonText: "Cancelar",
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "bd/crud.php",
          type: "POST",
          dataType: "json",
          data: { opcion: 15, id: id, id_tapicero: "1" },
          success: function (data) {
            if (data == 1) {
              Swal.fire("Asignado correctamente", "", "success").then(() => {
                location.reload(true);
              });
            } else {
              Swal.fire(
                "Error",
                "Ocurrió un error al asignar el respaldo",
                "error"
              ).then(() => {
                location.reload(true);
              });
            }
          },
          error: function () {
            Swal.fire("Error", "Ocurrió un error en la solicitud", "error");
          },
        });
      }
    });
  });
      // BOTON PARA AGREGAR PEDIDO A TAPICERO 3 // ESTE DEBE SER ACTUALIZADO. 
  $(document).on("click", ".btntapicero3", function () {
    id = parseInt($(this).closest("tr").find("td:eq(0)").text());

    var respuesta = confirm(
      "¿Está seguro de Agregar a Tapicero 3 el respaldo: " + id + "?"
    );
    if (respuesta) {
      $.ajax({
        url: "bd/crud.php",
        type: "POST",

        dataType: "json",
        data: { opcion: 15, id: id, id_tapicero: "3" },
        success: function (data) {
          if (data == 1) {
            alert("Asignado correctamente");
          } else {
            location.reload(true);
          }
        },
      });
    }
  });

  // BOTON PARA DESASIGNAR PEDIDO A TRABAJADOR 
  $(document).on("click", ".btndesasignar", function () {
    id = parseInt($(this).closest("tr").find("td:eq(0)").text());

    var respuesta = confirm("¿Está seguro de quitar el respaldo: " + id + "?");
    if (respuesta) {
      $.ajax({
        url: "bd/crud.php",
        type: "POST",

        dataType: "json",
        data: { opcion: 15, id: id, id_tapicero: "0" },
        success: function (data) {
          if (data == 1) {
            alert("Quitado correctamente");
            location.reload(true);
          } else {
            location.reload(true);
          }
        },
      });
    }
  });
  // BOTON PARA TAPICERO 1 CUANDO ESTA SU PEDIDO LISTO, ESTE SE MARCA EN PANTALLA DE PRODUCCIÓN.
  $(document).on("click", ".btnpedidolistojaime", function () {
    detalle = $(this).data("value");
    estadoactual = $(this).data("estado");
    console.log(estadoactual);

    id = parseInt($(this).closest("tr").find("td:eq(0)").text());

    console.log(detalle);

    if (estadoactual === 2) {
      estadopedido = 5;
      mensaje_alert = "¿Comienzo de fabricación: " + id + "?";
      icono = "info";
      titulo = "Fabricación";
    } else if (estadoactual === 5) {
      mensaje_alert = "¿Confirma termino de respaldo: " + id + "?";
      estadopedido = 6;
      detalle = "Confirme término de producto";
      titulo = "Confirmación";
      icono = "info";
    } else if (estadoactual === 6) {
      mensaje_alert = "¿Confirma termino de respaldo: " + id + "?";
      estadopedido = 6;
      detalle = "Confirme término de producto";
      titulo = "Confirmación";
      icono = "info";
    }

    if (estadoactual == 5) {
      detalle = "Producto Terminado";
      icono = "info";
    }

    console.log(estadopedido);
    speechSynthesis.onvoiceschanged = function () {
      var vocesDisponibles = speechSynthesis.getVoices();
      // Ahora intenta seleccionar la voz que quieres usar
      mensaje.voice = vocesDisponibles.find((voice) => voice.gender === "male"); // Ejemplo de cómo buscar por género, si esta propiedad está disponible
      console.log("a", speechSynthesis.getVoices());
    };

    mensaje = new SpeechSynthesisUtterance();
    vocesDisponibles = speechSynthesis.getVoices();

    // Espera a que se carguen las voces si aún no están disponibles
    if (vocesDisponibles.length === 0) {
      speechSynthesis.addEventListener("voiceschanged", function () {
        vocesDisponibles = speechSynthesis.getVoices();
        seleccionarVozHombre();
      });
    } else {
      seleccionarVozHombre();
    }

    function seleccionarVozHombre() {
      // Buscar específicamente la voz de hombre por su nombre
      const vozDeHombre = vocesDisponibles.find(
        (voice) => voice.name === "Google español"
      );

      if (vozDeHombre) {
        mensaje.voice = vozDeHombre; // Asignar la voz encontrada
      } else {
        console.log("No se encontró la voz de hombre específica.");
        // Aquí puedes elegir manejar el caso de no encontrar la voz deseada
      }

      mensaje.rate = 1;
      mensaje.pitch = 1; // Asegúrate de que el pitch esté en el rango [0, 2]
      mensaje.text = detalle; // Asegúrate de que 'detalle' tenga el texto que deseas sintetizar
      speechSynthesis.speak(mensaje);
    }
    mensaje = new SpeechSynthesisUtterance();

    swal
      .fire({
        title: titulo,
        text: mensaje_alert,
        icon: icono,
        showCancelButton: true,
        confirmButtonText: "Confirmar",
        cancelButtonText: "Cancelar",
        customClass: {
          confirmButton: "swal-button--confirm", // Clase para el botón de confirmar
          cancelButton: "swal-button--cancel",
        },
        dangerMode: true,
      })
      .then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "bd/crud.php",
            type: "POST",
            dataType: "json",
            data: {
              opcion: 16,
              id: id,
              id_tapicero: "1",
              estadopedido: estadopedido,
            },
            success: function (data) {
              if (data === 1) {
                swal.fire("Asignado correctamente", "", "success");
              } else {
                location.reload(true);
              }
            },
            error: function () {
              swal.fire("Error al realizar la asignación", "", "error");
            },
          });
        }
      });
  });
    // BOTON PARA TAPICERO 2 CUANDO ESTA SU PEDIDO LISTO, ESTE SE MARCA EN PANTALLA DE PRODUCCIÓN.
  $(document).on("click", ".btnpedidolistofelipe", function () {
    detalle = $(this).data("value");
    estadoactual = $(this).data("estado");
    console.log(estadoactual);

    id = parseInt($(this).closest("tr").find("td:eq(0)").text());

    console.log(detalle);

    if (estadoactual === 2) {
      estadopedido = 5;
      mensaje_alert = "¿Comienzo de fabricación: " + id + "?";
      icono = "info";
      titulo = "Fabricación";
    } else if (estadoactual === 5) {
      mensaje_alert = "¿Confirma termino de respaldo: " + id + "?";
      estadopedido = 6;
      detalle = "Confirme término de producto";
      titulo = "Confirmación";
      icono = "info";
    } else if (estadoactual === 6) {
      mensaje_alert = "¿Confirma termino de respaldo: " + id + "?";
      estadopedido = 6;
      detalle = "Confirme término de producto";
      titulo = "Confirmación";
      icono = "info";
    }

    /*if(estadoactual == 5){
    detalle = "Producto Terminado";
    icono = "info";
    }*/

    console.log(estadopedido);

    speechSynthesis.onvoiceschanged = function () {
      var vocesDisponibles = speechSynthesis.getVoices();
      // Ahora intenta seleccionar la voz que quieres usar
      mensaje.voice = vocesDisponibles.find((voice) => voice.gender === "male"); // Ejemplo de cómo buscar por género, si esta propiedad está disponible
      console.log("a", speechSynthesis.getVoices());
    };

    mensaje = new SpeechSynthesisUtterance();
    vocesDisponibles = speechSynthesis.getVoices();

    // Espera a que se carguen las voces si aún no están disponibles
    if (vocesDisponibles.length === 0) {
      speechSynthesis.addEventListener("voiceschanged", function () {
        vocesDisponibles = speechSynthesis.getVoices();
        seleccionarVozHombre();
      });
    } else {
      seleccionarVozHombre();
    }

    function seleccionarVozHombre() {
      // Buscar específicamente la voz de hombre por su nombre
      const vozDeHombre = vocesDisponibles.find(
        (voice) => voice.name === "Google español"
      );

      if (vozDeHombre) {
        mensaje.voice = vozDeHombre; // Asignar la voz encontrada
      } else {
        console.log("No se encontró la voz de hombre específica.");
        // Aquí puedes elegir manejar el caso de no encontrar la voz deseada
      }

      mensaje.rate = 1;
      mensaje.pitch = 1; // Asegúrate de que el pitch esté en el rango [0, 2]
      mensaje.text = detalle; // Asegúrate de que 'detalle' tenga el texto que deseas sintetizar
      speechSynthesis.speak(mensaje);
    }
    mensaje = new SpeechSynthesisUtterance();

    swal
      .fire({
        title: titulo,
        text: mensaje_alert,
        icon: icono,
        showCancelButton: true,
        confirmButtonText: "Confirmar",
        cancelButtonText: "Cancelar",
        customClass: {
          confirmButton: "swal-button--confirm", // Clase para el botón de confirmar
          cancelButton: "swal-button--cancel",
        },
        dangerMode: true,
      })
      .then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "bd/crud.php",
            type: "POST",
            dataType: "json",
            data: {
              opcion: 16,
              id: id,
              id_tapicero: "1",
              estadopedido: estadopedido,
            },
            success: function (data) {
              if (data === 1) {
                swal.fire("Asignado correctamente", "", "success");
              } else {
                location.reload(true);
              }
            },
            error: function () {
              swal.fire("Error al realizar la asignación", "", "error");
            },
          });
        }
      });
  });
  // BOTON PARA TAPICERO 3 CUANDO ESTA SU PEDIDO LISTO, ESTE SE MARCA EN PANTALLA DE PRODUCCIÓN. DEBE SER ACTUALIZADO********
  $(document).on("click", ".btnpedidolisto3", function () {
    id = parseInt($(this).closest("tr").find("td:eq(0)").text());

    var respuesta = confirm(
      "¿Tapicero 3 Confirma termino de respaldo : " + id + "?"
    );
    if (respuesta) {
      $.ajax({
        url: "bd/crud.php",
        type: "POST",

        dataType: "json",
        data: { opcion: 16, id: id, id_tapicero: "3" },
        success: function (data) {
          if (data == 1) {
            alert("Asignado correctamente");
          } else {
            location.reload(true);
          }
        },
      });
    }
  });

  // BOTON PARA EDITAR PAGO ANTIGUO ****** REVISAR SI FUNCIONA.
  $(function () {
    $(".btnEditarpago").on("click", function () {
      if ($(this).prop("checked")) {
        $('th input[type="checkbox"]').each(function () {
          $(this).prop("checked", true);
          $(this).closest("tr").addClass("active");
        });
      } else {
        $('th input[type="checkbox"]').each(function () {
          $(this).prop("checked", false);
          $(this).closest("tr").removeClass("active");
        });
      }
    });

    $('th[scope="row"] input[type="checkbox"]').on("click", function () {
      if ($(this).closest("tr").hasClass("active")) {
        $(this).closest("tr").removeClass("active");
      } else {
        $(this).closest("tr").addClass("active");
      }
    });
  });
  // BOTON AL HACER CLICK PARA EDITAR PAGO. ANTIGUO
  $(document).on("click", ".btnEditarpago", function () {
    fila = $(this).closest("tr");
    id = parseInt(fila.find("td:eq(0)").text());
    rut = fila.find("td:eq(1)").text();
    pais = fila.find("td:eq(2)").text();
    edad = parseInt(fila.find("td:eq(3)").text());
    monto_apagar = parseInt(fila.find("td:eq(10)").text());
    telefono = parseInt(fila.find("td:eq(8)").text());
    pagado = fila.find("td:eq(11)").text().trim();

    $(this).prop("checked", true);
    $(this).closest("tr").addClass("active");

    $("#id").val(id);
    $("#rut").val(rut);
    $("#montoapagar").val(monto_apagar);
    $("#telefono").val(telefono);
    $("#pagado").val(pagado);

    document.getElementById("buscar_id").style.display = "none";

    $("#resultados").val("");
    $("#resultados2").val("");
    $("#resultados3").val("");
    $("#resultados4").val("");
    $("#resultados5").val("");

    opcion = 7; //editar

    $(".modal-header").css("background-color", "#4e73df");
    $(".modal-header").css("color", "white");
    $(".modal-title").text("Editar Pagos " + id);
    $("#modalCRUD").modal("show");
  });

  //BOTON BORRAR PEDIDO
  $(document).on("click", ".btnBorrar", function () {
    fila = $(this);
    id = parseInt($(this).closest("tr").find("td:eq(1)").text());

    var filas = tablapedidos.row(fila.parents("tr"));
    $(filas.node()).addClass("resaltada"); // Agregar clase CSS 'resaltada' a la fila
    opcion = 3; //borrar
    var respuesta = false;

    Swal.fire({
      title: "Eliminando pedido: " + id,
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Eliminar",
      confirmButtonColor: "#ff0000", // Color rojo
      cancelButtonText: "Cancelar",
      input: "text", // Agregar campo de texto para el motivo de eliminación
      inputPlaceholder: "Motivo de eliminación",
      inputValidator: (value) => {
        if (!value) {
          return "Debe ingresar un motivo de eliminación";
        }
      },
    }).then((result) => {
      if (result.isConfirmed) {
        var motivo = result.value; // Obtener el valor del campo de texto

        respuesta = true;
        $.ajax({
          url: "bd/crud.php",
          type: "POST",
          dataType: "json",
          data: { opcion: opcion, id: id, motivo: motivo }, // Enviar el motivo al archivo CRUD
          success: function () {
            tablapedidos.row(fila.parents("tr")).remove().draw();
            Swal.fire({
              title: "<i class='fas fa-frown'></i> Producto Eliminado",
              text: "El producto se ha eliminado correctamente.",
              icon: "warning",
              showCancelButton: false,
              confirmButtonText: "Aceptar",
              confirmButtonColor: "#ff0000", // Color rojo
              // Habilitar HTML en el título
            });
          },
        });
      }
    });
  });

  //botón BORRAR PRODUCTO NUEVO 2024
  $(document).on("click", ".btnBorrarProd", function () {
    fila = $(this);
    id = parseInt($(this).closest("tr").find("td:eq(0)").text());

    var filas = tablapedidos.row(fila.parents("tr"));
    $(filas.node()).addClass("resaltada"); // Agregar clase CSS 'resaltada' a la fila
    opcion = 3; //borrar
    var respuesta = false;

    Swal.fire({
      title: "Eliminando pedido: " + id,
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Eliminar",
      confirmButtonColor: "#ff0000", // Color rojo
      cancelButtonText: "Cancelar",
      input: "text", // Agregar campo de texto para el motivo de eliminación
      inputPlaceholder: "Motivo de eliminación",
      inputValidator: (value) => {
        if (!value) {
          return "Debe ingresar un motivo de eliminación";
        }
      },
    }).then((result) => {
      if (result.isConfirmed) {
        var motivo = result.value; // Obtener el valor del campo de texto

        respuesta = true;
        $.ajax({
          url: "bd/crud.php",
          type: "POST",
          dataType: "json",
          data: { opcion: opcion, id: id, motivo: motivo }, // Enviar el motivo al archivo CRUD
          success: function () {
            tablapedidos.row(fila.parents("tr")).remove().draw();
            Swal.fire({
              title: "<i class='fas fa-frown'></i> Producto Eliminado",
              text: "El producto se ha eliminado correctamente.",
              icon: "warning",
              showCancelButton: false,
              confirmButtonText: "Aceptar",
              confirmButtonColor: "#ff0000", // Color rojo
              // Habilitar HTML en el título
            });
          },
        });
      }
    });
  });

  //Aceptar compra
// BOTON PARA EDITAR ESTADO DEL PEDIDO.
$("#editarestado").submit(function (e) {
  e.preventDefault();

  var id = $("#id").val(); // ID del pedido
  var nuevoEstado = $("#estado").val(); // Nuevo estado obtenido del formulario

  // Realizar la solicitud AJAX
  $.ajax({
      url: "bd/crud.php",
      type: "POST",
      dataType: "json",
      data: {
          estado: nuevoEstado,
          id: id,
          opcion: opcion // Asegúrate que 'opcion' está definida correctamente en tu contexto
      },
      success: function (data) {
          // Cierra el modal
          $("#modalCRUD").modal("hide");

          // Buscar la fila en la DataTable por ID y actualizarla
          var table = $('hola').DataTable(); // Asegúrate que el ID 'hola' es correcto para tu DataTable
          var fila = table.rows().nodes().to$().find('td:first-child').filter(function() {
              return $(this).text() == id;
          }).closest('tr');

          // Actualizar la columna del estado, asumiendo que está en una posición específica, ej: la segunda columna
          var rowIndex = table.row(fila).index();
          var rowData = table.row(fila).data();
          rowData[9] = nuevoEstado; // Cambia el índice 8 por el índice correcto de la columna de estado en tu caso

          table.row(fila).data(rowData).draw();

          // Opcional: Mostrar un mensaje de confirmación
          Swal.fire({
              title: 'Actualizado',
              text: 'El estado del pedido ha sido actualizado correctamente.',
              icon: 'success'
          });
      },
      error: function (error) {
          console.log(error);
          Swal.fire({
              title: 'Error',
              text: 'No se pudo actualizar el estado del pedido.',
              icon: 'error'
          });
      }
  });
});


  // BOTON PARA EDITAR ESTADO DEL PEDIDO.
  $("#editarestado").submit(function (e) {
    e.preventDefault();

 
    var id = $("#id").val(); // ID del pedido
    var estado = $("#estado").val(); // Nuevo estado obtenido del formulario


    edad = $.trim($("#edad").val());
    $.ajax({
      url: "bd/crud.php",
      type: "POST",
      dataType: "json",
      data: { estado: estado, id: id, opcion: opcion, cant: cant },
      success: function (data) {
        console.log(data);
        var table = $('#hola').DataTable();
        var rowData = table.row(fila).data(); 
        

        id = data[0].id;
        rut_cliente = data[0].rut_cliente;
        modelo = data[0].modelo;
        plazas = data[0].tamano;
        alturabase = data[0].alturabase;
        material = data[0].tipotela;
        color = data[0].color;

        direccion = data[0].direccion;
        numero = data[0].numero;
        comuna = data[0].comuna;
        telefono = data[0].telefono;
        precio = data[0].precio;

        if (data[0].cod_ped_anterior == "") {
          reemitir =
            "<a href='cambio_prod.php?id=" +
            id +
            "'><button class='btn btn-danger' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Re-Emitir</button></a>";
        }

        if (data[0].estadopedido == "1") {
          estadoped =
            "<div class='text-center' ><div class='btn-group'><button class='btn btn-secondary btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Aceptado</button></div>";
        }
        if (data[0].estadopedido == 2) {
          estadoped =
            "<div class='text-center' ><div class='btn-group'><button class='btn btn-warning btnEditarestado' id='parpadea_' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Por Fabricar</button></div>";
        }
        if (data[0].estadopedido == 0) {
          estadoped =
            "<div class='text-center' ><div class='btn-group'><button class='btn btn-warning btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>No Aceptado</button></div>";
        }
        if (data[0].estadopedido == 3) {
          estadoped =
            "<div class='text-center' ><div class='btn-group'><button class='btn btn-info btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Pedido Listo</button></div>";
        }
        if (data[0].estadopedido == 9) {
          estadoped =
            "<div class='text-center' ><div class='btn-group'><button class='btn btn-warning btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Reagendar</button></div>";
        }
        if (opcion == 1) {
          table.row(fila).data(rowData).draw(false); // Actualiza la fila sin redibujar toda la tabla
        } else {
          table.row(fila).data(rowData).draw(false);




        
        }
      },
      error: function () {
        alert("Error cambiando estado");
      },
    });
    
    $("#modalCRUD").modal("hide");
  });

  // BOTON PARA EDITAR PAGO. REVISAR SI SE UTILIZA
  $("#editarpago").submit(function (e) {
    e.preventDefault();
    pago = $("#pago").val();
    pais = $.trim($("#pais").val());
    edad = $.trim($("#edad").val());
    $.ajax({
      url: "bd/crud.php",
      type: "POST",
      dataType: "json",
      data: { pago: pago, id: id, opcion: opcion },
      success: function (data) {
        console.log(data);

        id = data[0].id;
        rut_cliente = data[0].rut_cliente;
        modelo = data[0].modelo;
        plazas = data[0].tamano;
        alturabase = data[0].alturabase;
        material = data[0].tipotela;
        direccion = data[0].direccion + data[0].numero + data[0].comuna;
        modopago = data[0].mododepago;
        nombre = data[0].nombre;
        precio = data[0].precio;
        pagado = data[0].pagado;
        color = data[0].color;
        comuna = data[0].comuna;
        telefono = data[0].telefono;
        estadoped = data[0].estadopedido;
        if (data[0].formadepago == "15") {
          estadoped =
            "<div class='text-center' ><div class='btn-group'><button class='btn btn-success btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Efectivo</button></div>";
        }
        if (data[0].formadepago == 16) {
          estadoped =
            "<div class='text-center' ><div class='btn-group'><button class='btn btn-success btnEditarestado'  style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Debito</button></div>";
        }
        if (data[0].formadepago == 17) {
          estadoped =
            "<div class='text-center' ><div class='btn-group'><button class='btn btn-success btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Credito</button></div>";
        }
        if (data[0].formadepago == 18) {
          estadoped =
            "<div class='text-center' ><div class='btn-group'><button class='btn btn-success btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Transferencia</button></div>";
        }
        if (data[0].formadepago == 19) {
          estadoped =
            "<div class='text-center' ><div class='btn-group'><button class='btn btn-success btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Webpay</button></div>";
        }
        if (data[0].formadepago == "") {
          estadoped =
            "<div class='text-center' ><div class='btn-group'><button class='btn btn-warning btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Por Pagar</button></div>";
        }
        if (data[0].formadepago == 4) {
          estadoped =
            "<div class='text-center' ><div class='btn-group'><button class='btn btn-warning btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Por Pagar</button></div>";
        }

        if (data[0].pagado == 1) {
          pagado =
            "<div class='text-center' ><div class='btn-group'><button class='btn btn-primary' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Pagado</button></div>";
        }

        if (opcion == 1) {
          tablavalidarpagos.row.add([id, nombre, pais, edad]).draw();
        } else {
          tablavalidarpagos
            .row(fila)
            .data([
              id,
              rut_cliente,
              nombre,
              modelo,
              plazas,
              alturabase,
              color,
              direccion,
              telefono,
              modopago,
              precio,
              pagado,
              estadoped,
              ,
            ])
            .draw();
          tablavalidarpagos.row.add
            .data([
              id,
              rut_cliente,
              nombre,
              modelo,
              plazas,
              alturabase,
              color,
              direccion,
              telefono,
              modopago,
              precio,
              pagado,
              estadoped,
              ,
            ])
            .draw();
        }
      },
      error: function () {
        alert("Error cambiando Pago");
      },
    });
    $("#modalCRUD").modal("hide");
  });

  //BOTON PARA EDITAR PEDIDO** REVISAR SI SE UTILIZA.....
  $("#editarpedido").submit(function (e) {
    e.preventDefault();
    // RECIBIMOS TODOS LOS VALORES DEL POPUP QUE ESTA EN EL DASHBOARD
    ide = $("#ide").val();
    rut = $.trim($("#rut").val());
    nombre = $.trim($("#nombre").val());
    telefono = $.trim($("#telefono").val());
    modelo = $.trim($("#modelo").val());
    plazas = $.trim($("#plazas").val());
    tela = $.trim($("#tela").val());
    color = $.trim($("#color").val());
    anclaje = $.trim($("#anclaje").val());
    tipo_boton = $.trim($("#tipo_boton").val());
    metodo_entrega = $.trim($("#metodo_entrega").val());
    detalle_entrega = $.trim($("#detalle_entrega").val());

    detalles_fabricacion = $.trim($("#detalles_fabricacion").val());
    telefono = $.trim($("#telefono").val());
    alturabase = $.trim($("#alturabase").val());
    direccion = $.trim($("#direccion").val());
    num_orden = $.trim($("#num_orden").val());
    abono = $.trim($("#abono").val());

    numero = $.trim($("#numero").val());
    comuna = $.trim($("#comuna").val());
    comentarios = $.trim($("#comentarios").val());
    precio = $.trim($("#precio").val());
    opcion = 0;
    $.ajax({
      url: "bd/crud.php",
      type: "POST",
      dataType: "json",
      data: {
        ide: ide,
        rut: rut,
        nombre: nombre,
        telefono: telefono,
        tipo_boton: tipo_boton,
        detalle_entrega: detalle_entrega,
        metodo_entrega: metodo_entrega,
        anclaje: anclaje,
        detalles_fabricacion: detalles_fabricacion,
        opcion: 5,
        modelo: modelo,
        plazas: plazas,
        tela: tela,
        color: color,
        alturabase: alturabase,
        direccion: direccion,
        numero: numero,
        comuna: comuna,
        precio: precio,
        abono: abono,
        comentarios: comentarios,
      },
      success: function (data) {
        console.log(data);

        id = data[0].id;
        rut_cliente = data[0].rut_cliente;
        modelo = data[0].modelo;
        plazas = data[0].tamano;
        alturabase = data[0].alturabase;
        material = data[0].tipotela;
        color = data[0].color;
        direccion = data[0].direccion;

        numero = data[0].numero;
        comuna = data[0].comuna;
        telefono = data[0].telefono;
        precio = data[0].precio;
        abono = data[0].abono;

        if (data[0].cod_ped_anterior == "") {
          reemitir =
            "<a href='cambio_prod.php?id=" +
            id +
            "'><button class='btn btn-danger' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Re-Emitir</button></a>";
        }

        estadoped = data[0].estadopedido;
        if (data[0].estadopedido == "1") {
          estadoped =
            "<div class='text-center' ><div class='btn-group'><button class='btn btn-secondary btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Aceptado</button></div>";
        }
        if (data[0].estadopedido == 2) {
          estadoped =
            "<div class='text-center' ><div class='btn-group'><button class='btn btn-warning btnEditarestado' id='parpadea' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Por Fabricar</button></div>";
        }
        if (data[0].estadopedido == 6) {
          estadoped =
            "<div class='text-center' ><div class='btn-group'><button class='btn btn-info btnEditarestado' id='parpadea' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>En Fabricacion</button></div>";
        }
        if (data[0].estadopedido == 0) {
          estadoped =
            "<div class='text-center' ><div class='btn-group'><button class='btn btn-warning btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>No Aceptado</button></div>";
        }
        if (data[0].estadopedido == 3) {
          estadoped =
            "<div class='text-center' ><div class='btn-group'><button class='btn btn-info btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Pedido Listo</button></div>";
        }
        if (opcion == 1) {
          tablapedidos.row.add([id, nombre, pais, edad]).draw();
        } else {
          tablapedidos
            .row(fila)
            .data([
              cant,
              id,
              rut_cliente,
              modelo,
              plazas,
              alturabase,
              material,
              color,
              direccion,
              numero,
              comuna,
              telefono,
              precio,
              reemitir,
              estadoped,
              ,
            ])
            .draw();
        }
      },
      error: function () {
        alert("Error cambiando estado");
      },
    });
    $("#example").DataTable().ajax.reload();

    $("#modalEditarPedido").modal("hide");
  });

  //BOTON PARA EDITAR PEDIDO GENERAL.... REVISAR SI SE UTILIZA.
  $("#editarpedido_general").submit(function (e) {
    //funcion para editar pedido del boton todos los pedidos
    e.preventDefault();
    ide = $("#ide").val();

    rut = $.trim($("#rut").val());
    modelo = $.trim($("#modelo").val());
    plazas = $.trim($("#plazas").val());
    tela = $.trim($("#tela").val());
    color = $.trim($("#color").val());
    telefono = $.trim($("#telefono").val());
    alturabase = $.trim($("#alturabase").val());
    direccion = $.trim($("#direccion").val());
    numero = $.trim($("#numero").val());
    comuna = $.trim($("#comuna").val());
    precio = $.trim($("#precio").val());
    $.ajax({
      url: "bd/crud.php",
      type: "POST",
      dataType: "json",
      data: {
        ide: ide,
        rut: rut,
        telefono: telefono,
        opcion: 6,
        modelo: modelo,
        plazas: plazas,
        tela: tela,
        color: color,
        alturabase: alturabase,
        direccion: direccion,
        numero: numero,
        comuna: comuna,
      },
      success: function (data) {
        console.log(data);

        id = data[0].id;
        rut_cliente = data[0].rut_cliente;
        modelo = data[0].modelo;
        plazas = data[0].plazas;
        alturabase = data[0].alturabase;
        material = data[0].tipotela;
        direccion = data[0].direccion;
        numero = data[0].numero;
        comuna = data[0].comuna;
        telefono = data[0].telefono;
        precio = data[0].precio;

        estadoped = data[0].estadopedido;
        if (data[0].estadopedido == "1") {
          estadoped =
            "<div class='text-center' ><div class='btn-group'><button class='btn btn-secondary btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Aceptado</button></div>";
        }
        if (data[0].estadopedido == 2) {
          estadoped =
            "<div class='text-center' ><div class='btn-group'><button class='btn btn-info btnEditarestado' id='parpadea' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>En Fabricacion</button></div>";
        }
        if (data[0].estadopedido == 0) {
          estadoped =
            "<div class='text-center' ><div class='btn-group'><button class='btn btn-warning btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>No Aceptado</button></div>";
        }
        if (data[0].estadopedido == 3) {
          estadoped =
            "<div class='text-center' ><div class='btn-group'><button class='btn btn-info btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Pedido Listo</button></div>";
        }
        if (opcion == 1) {
          tablaPersonas.row.add([id, nombre, pais, edad]).draw();
        } else {
          tablaPersonas
            .row(fila)
            .data([
              id,
              rut_cliente,
              modelo,
              plazas,
              alturabase,
              material,
              color,
              direccion,
              numero,
              comuna,
              telefono,
              ,
              estadoped,
              precio,
              ,
            ])
            .draw();
        }
      },
      error: function () {
        alert("Error cambiando estado");
      },
    });
    $("#modalEditarPedido_general").modal("hide");
  });
});

