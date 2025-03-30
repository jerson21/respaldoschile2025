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

  var fila; //capturar la fila para editar o borrar el registro
  $(document).on("click", ".btnEditar", function () {
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

  // EDITAR ORDEN //////////////////////////////////////////////////
  $(document).on("click", ".btnEditarOrden", function () {
    var modalEditarOrden = document.getElementById("modalEditarOrden");
    var inputCampos = modalEditarOrden.querySelectorAll("input");

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
        $("#n_orden").val(response.ide);
        $("#rutb").val(response.rut);
        $("#nombreb").val(response.nombre);
        $("#ide_webs").show();
        $("#ide_web").val(response.ide_webs);
        $("#costo_envio").val(response.costo_envio);
        $("#totalpagado").val(response.total_pagado);
        $("#telefonob").val(response.telefono);
        $("#fecha_ingresob").val(response.fecha_ingreso);
        $("#vendedorb").val(response.vendedor);

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
        $(".modal-title").text("Editar Orden");

        // Mostrar el modal
        $("#modalEditarOrden").modal("show");
        //$("#modalEditarPedido_general").modal("show");
      },
      error: function (error) {
        console.log(error);
        // Manejar el error de la consulta a la base de datos
      },
    });

    $(".modal-header .close").click(function () {
      $("#modalEditarOrden").modal("hide");
    });
  });

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

  function capitalize(s) {
    return s[0].toUpperCase() + s.slice(1);
  }

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

  function convertirCmAMetros(cadena) {
    // Obtener el valor ingresado en centímetros

    // Convertir los centímetros a metros
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

  $(document).on("click", ".btnfelipe", function () {
    id = parseInt($(this).closest("tr").find("td:eq(0)").text());

    Swal.fire({
      title: "¿Está seguro de Agregar a Felipe el respaldo: " + id + "?",
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

  $(document).on("click", ".btnjaime", function () {
    id = parseInt($(this).closest("tr").find("td:eq(0)").text());

    Swal.fire({
      title: "¿Está seguro de Agregar a Jaime el respaldo: " + id + "?",
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

    mensaje = new SpeechSynthesisUtterance();
    vocesDisponibles = speechSynthesis.getVoices();
    mensaje.voice = vocesDisponibles[7];
    mensaje.rate = 1;
    mensaje.text = detalle;
    mensaje.pitch = -1;
    speechSynthesis.speak(mensaje);

    swal
      .fire({
        title: titulo,
        text: mensaje_alert,
        icon: icono,
        buttons: {
          cancel: {
            text: "Cancelar",
            className: "swal-button--cancel",
          },
          confirm: {
            text: "Confirmar", // Corregido: cambiar "OK" por "Confirmar"
            className: "swal-button--confirm swal-button--primary",
          },
        },
        dangerMode: true,
      })
      .then(function (confirmado) {
        if (confirmado) {
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

    if (estadoactual == 5) {
      detalle = "Producto Terminado";
      icono = "info";
    }

    console.log(estadopedido);

    mensaje = new SpeechSynthesisUtterance();
    vocesDisponibles = speechSynthesis.getVoices();
    mensaje.voice = vocesDisponibles[7];
    mensaje.rate = 1;
    mensaje.text = detalle;
    mensaje.pitch = -1;
    speechSynthesis.speak(mensaje);

    swal
      .fire({
        title: titulo,
        text: mensaje_alert,
        icon: icono,
        buttons: {
          cancel: {
            text: "Cancelar",
            className: "swal-button--cancel",
          },
          confirm: {
            text: "Confirmar", // Corregido: cambiar "OK" por "Confirmar"
            className: "swal-button--confirm swal-button--primary",
          },
        },
        dangerMode: true,
      })
      .then(function (confirmado) {
        if (confirmado) {
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
  //TAPICERO 3
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

  //botón BORRAR
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

  $("#aceptarpedido").submit(function (e) {
    e.preventDefault();

    id = parseInt(fila.find("td:eq(1)").text());
    opcion = 4; //borrar
    estado = 1;
    $.ajax({
      url: "bd/crud.php",
      type: "POST",
      dataType: "json",
      data: { estado: estado, id: id, opcion: opcion },
      success: function (data) {
        console.log(data);
        alert(id);
        id = data[0].id;
        rut_cliente = data[0].rut_cliente;
        modelo = data[0].modelo;
        plazas = data[0].plazas;
        alturabase = data[0].alturabase;
        material = data[0].tipotela;
        color = data[0].color;
        comuna = data[0].comuna;
        estadoped = data[0].estadopedido;
        if (estadoped == 1) {
          estadoped =
            "<div class='text-center' ><div class='btn-group'><button class='btn btn-secondary btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Aceptado</button></div>";
        }
        if (estadoped == 2) {
          estadoped =
            "<div class='text-center' ><div class='btn-group'><button class='btn btn-info btnEditarestado' id='parpadea' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>En Fabricacion</button></div>";
        }
        if (estadoped == 0) {
          estadoped =
            "<div class='text-center' ><div class='btn-group'><button class='btn btn-warning btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>No Aceptado</button></div>";
        }
        if (estadoped == 6) {
          estadoped =
            "<div class='text-center' ><div class='btn-group'><button class='btn btn-info btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Pedido Listo</button></div>";
        }
        if (estadoped == 19) {
          estadoped =
            "<div class='text-center' ><div class='btn-group'><button class='btn btn-warning btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Reagendar</button></div>";
        }

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
            comuna,
            estadoped,
            ,
          ])
          .draw();
      },
      error: function () {
        alert("Error cambiando estado");
      },
    });
  });

  $("#editarestado").submit(function (e) {
    e.preventDefault();

    estado = $("#estado").val();

    edad = $.trim($("#edad").val());
    $.ajax({
      url: "bd/crud.php",
      type: "POST",
      dataType: "json",
      data: { estado: estado, id: id, opcion: opcion, cant: cant },
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
          tablaPersonas.row.add([id, nombre, pais, edad]).draw();
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
    $("#modalCRUD").modal("hide");
  });
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
    $("#modalEditarPedido").modal("hide");
  });

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
