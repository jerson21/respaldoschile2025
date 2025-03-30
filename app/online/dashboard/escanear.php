<?php require_once "vistas/parte_superior.php"?>



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
      input: 'text',
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
        const metraje = result.value;
        callback(metraje);
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
        codigoBarras: codigoBarras, opcion: "escanear_bodega"
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
  function enviarDatos(codigoBarras, metraje, sector, callback) {
    $.ajax({
      url: "bd/crud.php",
      type: "POST",
      dataType: "json",
      data: {
        opcion: "escanear_bodega",
        codigo_escaneado: codigoBarras,
        metraje: metraje,
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
        if (data) {
          const nombreProducto = data.nombre;
          solicitarSector(nombreProducto, (sector) => {
            solicitarMetraje((metraje) => {
              enviarDatos(codigoBarras, metraje, sector, (success) => {
                if (success) {
                  Swal.fire({
                    icon: 'success',
                    text: 'Operación exitosa',
                    showConfirmButton: false, // No mostrar el botón de confirmación
                    timer: 2000, // Mostrar el aviso por 2 segundos
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
            text: 'No se pudo obtener los datos del producto'
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