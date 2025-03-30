<?php require_once "vistas/parte_superior.php"?>

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