<?php require_once "init.php" ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pedidos</title>
  

     <!-- Fuentes e íconos -->
<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">  
     <!-- Fuentes e íconos  -->
  <script src="https://kit.fontawesome.com/c5b4401310.js" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="https://www.respaldoschile.cl/assets/img/favicon.png" rel="icon">

  <!-- Estilos principales -->
  <link href="css/sb-admin-2.min.css" rel="stylesheet"> 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <!-- Librerías adicionales -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/flatpickr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/flatpickr.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.all.min.js"></script>

   <!-- <link rel="stylesheet" type="text/css" href="css/design_respaldoschile.css">  -->

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/rowgroup/1.1.3/js/dataTables.rowGroup.min.js"></script>

</head>

<body>
<?php require_once "vistas/parte_superior.php" ?>


    <h1>Bodega</h1>
    


 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
<div class="container-fluid" style="padding:50px; text-align: center; overflow: auto;  white-space: nowrap; margin:0 auto; background-color: #F5F5F5;" >


  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
<!-- <script>
  // Función para mostrar SweetAlert y solicitar el código de barras
  function solicitarCodigoBarras(callback) {
    Swal.fire({
      title: 'Escanear Producto',
      text: 'Ingrese el código de barras del producto',
      input: 'text',
      inputPlaceholder: 'Código de barras',
      showCancelButton: true,
      confirmButtonText: 'Siguiente &rarr;',
      allowOutsideClick: false,
      allowEscapeKey: false,
      inputValidator: (value) => {
        if (!value) {
          return 'Debe ingresar el código de barras';
        }
      }
    }).then((result) => {
      if (result.isConfirmed) {
        const codigoBarras = result.value;
        callback(codigoBarras);
      }
    });
  }

  // Función para mostrar SweetAlert y solicitar el sector
  function solicitarSector(callback) {

    Swal.fire({
      title: 'Ubicación del Producto',
      text: 'Ingrese el sector donde se ubicará el producto',
      input: 'text',
      inputPlaceholder: 'Sector',
      showCancelButton: true,
      confirmButtonText: 'Siguiente &rarr;',
      allowOutsideClick: false,
      allowEscapeKey: false,
      inputValidator: (value) => {
        if (!value) {
          return 'Debe ingresar el sector';
        }
      }
    }).then((result) => {
      if (result.isConfirmed) {
        const sector = result.value;
        callback(sector);
      }
    });
  }

  // Función para escanear el producto y solicitar el sector
  function escanearProducto() {
    solicitarCodigoBarras((codigoBarras) => {
      solicitarSector((sector) => {
        // Mostrar mensaje de éxito
        Swal.fire('Producto Escaneado', `El producto con código de barras ${codigoBarras} se ubicará en ${sector}`, 'success');

        // Enviar datos mediante AJAX
        enviarDatos(codigoBarras, sector);

        // Volver a escanear otro producto
        escanearProducto();
      });
    });
  }

  // Función para enviar datos mediante AJAX
  function enviarDatos(codigoBarras, sector) {
    // Realizar la petición AJAX aquí
    // Puedes utilizar la función fetch() u otras bibliotecas como Axios o jQuery.ajax()
    // Ejemplo de petición AJAX utilizando fetch():
    $.ajax({
      url: "bd/crud.php",
      type: "POST",
      dataType: "json",
      data: { opcion: "escanear_bodega", codigo_escaneado: codigoBarras, sector: sector },
      success: function (data) {
        if (data == 1) {
          Swal.fire({
            icon: 'success',
            text: 'Ingresado correctamente',
           }).then(() => {
    escanearProducto();
  });


        }  if (data == 2) {
          Swal.fire({
            icon: 'success',
            text: 'Actualizado correctamente',
          }).then(() => {
    escanearProducto();
  });
}
        
      }
    });
  }

  // Llamar a la función para escanear el primer producto
  escanearProducto();
</script> -->

<script>
  // Función para mostrar SweetAlert y solicitar el código de barras
  function solicitarCodigoBarras(callback) {
    Swal.fire({
      title: 'Escanear Producto',
      text: 'Ingrese el código de barras del producto',
      input: 'text',
      inputPlaceholder: 'Código de barras',
      showCancelButton: true,
      confirmButtonText: 'Siguiente &rarr;',
      allowOutsideClick: false,
      allowEscapeKey: false,
      inputValidator: (value) => {
        if (!value) {
          return 'Debe ingresar el código de barras';
        }
      }
    }).then((result) => {
      if (result.isConfirmed) {
        const codigoBarras = result.value;
        callback(codigoBarras);
      }
    });
  }

  // Función para mostrar SweetAlert y solicitar el sector
  function solicitarSector(producto, callback) {
    Swal.fire({
      title: 'Ubicación del Producto',
      html: `Ingrese el sector donde se ubicará el producto:<br><strong>${producto}</strong>`,
      input: 'text',
      inputPlaceholder: 'Sector',
      showCancelButton: true,
      confirmButtonText: 'Siguiente &rarr;',
      allowOutsideClick: false,
      allowEscapeKey: false,
      inputValidator: (value) => {
        if (!value) {
          return 'Debe ingresar el sector';
        }
      }
    }).then((result) => {
      if (result.isConfirmed) {
        const sector = result.value;
        callback(sector);
      }
    });
  }

  // Función para mostrar SweetAlert y solicitar el metraje
  function solicitarMetraje(callback) {
    Swal.fire({
      title: 'Metraje del Producto',
      text: 'Ingrese el metraje del producto',
      input: 'number',
      inputPlaceholder: 'Metraje',
      showCancelButton: true,
      confirmButtonText: 'Siguiente &rarr;',
      allowOutsideClick: false,
      allowEscapeKey: false,
      inputValidator: (value) => {
        if (!value) {
          return 'Debe ingresar el metraje';
        }
      }
    }).then((result) => {
      if (result.isConfirmed) {
        const cantidad = result.value;
        callback(cantidad);
      }
    });
  }

  // Función para obtener los datos del producto mediante AJAX
  function obtenerDatosProducto(codigoBarras, callback) {
    $.ajax({
      url: 'bd/crud.php',
      method: 'POST',
      dataType: 'json',
      data: {
        codigo_escaneado: codigoBarras, opcion: "leer_codigo"
      },
      success: function(data) {
        callback(data);
        
      },
      error: function() {
        callback(null);
      }
    });
  }

  // Función para enviar datos mediante AJAX
  function enviarDatos(codigoBarras, cantidad, sector, callback) {
    $.ajax({
      url: "bd/crud.php",
      type: "POST",
      dataType: "json",
      data: {
        opcion: "escanear_bodega",
        codigo_escaneado: codigoBarras,
        cantidad: cantidad,
        sector: sector
      },
      success: function(data) {
        if (data == 1) {
          callback(true);
        } else if (data == 2) {
          callback(true);
        } else {
          callback(false);
        }
      },
      error: function() {
        callback(false);
      }
    });
  }

  // Función para escanear el producto y solicitar el sector
  function escanearProducto() {
  solicitarCodigoBarras((codigoBarras) => {
    obtenerDatosProducto(codigoBarras, (data) => {
      if (data && data.length > 0) {
        const fila = data[0];
        const nombreProducto = fila.producto + ' ' + fila.material + ' ' + fila.detalle;
        solicitarSector(nombreProducto, (sector) => {
          solicitarMetraje((cantidad) => {
            enviarDatos(codigoBarras, cantidad, sector, (success) => {
              if (success) {
                Swal.fire({
                  icon: 'success',
                  text: 'Operación exitosa',
                  showConfirmButton: false,
                  timer: 2000,
                }).then(() => {
                  escanearProducto();
                });
              } else {
                Swal.fire({
                  icon: 'error',
                  text: 'Error al realizar la operación'
                }).then(() => {
                  escanearProducto();
                });
              }
            });
          });
        });
      } else {
        Swal.fire({
          icon: 'error',
          text: 'No se encontró el producto'
        }).then(() => {
          escanearProducto();
        });
      }
    });
  });
}

  // Llamar a la función para escanear el producto
  escanearProducto();
</script>










</div>
    






<?php require_once "vistas/parte_inferior.php"?>