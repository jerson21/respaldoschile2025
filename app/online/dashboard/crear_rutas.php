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

<!--INICIO del cont principal-->
<main id="main" >

   <div class="container">
    <h1>Crear Ruta</h1>
</div>

    <!-- ======= Portfolio Details Section ======= -->
   

      

      <div class="container-fluid" style="padding: 5rem; text-align: center;" >
<div class="rutss">
<h1>Procedimiento para crear Rutas</h1>

<br>
        <form id="crearRutaForm" name="crearRutaForm">
  <div class="mb-3" style="margin:0 auto; ">
    <label for="input fecha" class="form-label">Fecha</label>
    <input id="fecha" name="fecha" type="date">
    <div id="emailHelp" class="form-text">Debes seleccionar la fecha de la ruta a crear.</div>
<div class="mb-2" style="margin:0 auto; width: 30%; ">Tipo de Lista
    <select id="tipo_lista" name="tipo_lista" class="form-select" aria-label="Pagado"  required>                  
                  <option value="0" >Ruta Simple</option>                  
                  <option value="2" >Sala de ventas</option>
                  <option value="3" >Productos Stock</option>
                  
                </select>
              </div>
  </div>
  <div class="mb-3">
    
  </div>
  
  
  <button type="submit" class="btn btn-primary">Crear Ruta</button>
</form>
</div>
<script type="text/javascript">
  
$(document).ready( function() {   // Esta parte del código se ejecutará automáticamente cuando la página esté lista.
    $("#crearRutaForm").on('submit', function(evt){    // Con esto establecemos la acción por defecto de nuestro botón de enviar.
      evt.preventDefault();  
                                      // Primero validará el formulario.
            $.post("rutinas/ruta_add.php",$("#crearRutaForm").serialize(),function(res){
                $(".rutss").fadeOut("slow");   // Hacemos desaparecer el div "formulario" con un efecto fadeOut lento.
                if(res == 1){
                  $("#exito").delay(500).fadeIn("slow");                    
                          // Si hemos tenido éxito, hacemos aparecer el div "exito" con un efecto fadeIn lento tras un delay de 0,5 segundos.
                
                } else {
                    $("#fracaso").delay(500).fadeIn("slow");
                    $("#fracaso").html(res);

                        // Si no, lo mismo, pero haremos aparecer el div "fracaso"
                }
            });
        
    });    
});


</script>

</div>

<div id="exito" style=" width: 100%; margin:0 auto; padding: 5rem; text-align: center; display:none;">
            <br>Los datos de su ruta han sido creados con éxito.
            <br>
            <img width="15%" src="img/okimg.png"><br>
        </div>

<div id="fracaso" style=" width: 50rem; margin:0 auto; text-align: center; display:none">
            Se ha producido un error durante el envío de datos.
        </div>
  </main><!-- End #main -->
<!--FIN del cont principal-->

<?php require_once "vistas/parte_inferior.php"?>