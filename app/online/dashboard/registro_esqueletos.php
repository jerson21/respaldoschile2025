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
<div class="container">
    <h1>Registro Esqueletos</h1>
</div>
<style type="text/css">
	@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap');

body {
    background: #F5F1EE;
    font-family: 'Roboto', sans-serif
}

.card {
    width: 250px;
    border-radius: 10px
}

.card-img-top {
    border-top-right-radius: 10px;
    border-top-left-radius: 10px
}

span.text-muted {
    font-size: 12px
}

small.text-muted {
    font-size: 8px
}

h5.mb-0 {
    font-size: 1rem
}

small.ghj {
    font-size: 9px
}

.mid {
    background: #ECEDF1
}

h6.ml-1 {
    font-size: 13px
}

small.key {
    text-decoration: underline;
    font-size: 9px;
    cursor: pointer
}

.btn-danger {
    color: #FFCBD2
}

.btn-danger:focus {
    box-shadow: none
}

small.justify-content-center {
    font-size: 9px;
    cursor: pointer;
    text-decoration: underline
}

@media screen and (max-width:600px) {
    .col-sm-4 {
        margin-bottom: 50px
    }
}
</style>

<div class="container-fluid d-flex justify-content-center">
    <div class="row mt-5">
        
<div class="col-sm-4">
            <div class="card" > <div style="margin:0 auto;"><img src="img/respaldos.jpg" class="card-img-top"  style="width: 120px;height: 120px; text-align: center;" ></div>
            	<span style="text-align: center;"><h6>Respaldos de Cama</h6></span>
                <div class="card-body pt-0 px-0" >
                    
                    <hr class="mt-2 mx-3">
                    <div class="d-flex flex-row justify-content-between px-3 pb-4">
                        <div class="d-flex flex-column" style="line-height: 30px;">
                        <form id="respaldos">
						  <div class="form-group row">
						    <label for="staticEmail" class="col-sm-5 col-form-label">Plazas</label>
						    <div class="col-sm-7">
						      <select class="form-control"  id="plazas" required>
                           		<option value="">Seleccione</option>
                           	<option value="1">1 Plaza</option>
                           	<option value="1 1/2">1 1/2</option>
                           	<option value="Full">Full</option>
                           	<option value="2">2 Plazas</option>
                           	<option value="Queen">Queen </option>
                           	<option value="King">King</option>
                           	<option value="Super King">Super King</option>

                           </select>

						    </div>
						  </div>
						  <div class="form-group row">
						    <label  class="col-sm-5 col-form-label">Cantidad</label>
						    <div class="col-sm-7">
						      <input name="cantidad" id="cantidad" type="number" class="form-control" required>

						    </div>
						  </div>

						  <div class="form-group row">
						    <label for="staticEmail" class="col-sm-5 col-form-label">Alt Base</label>
						    <div class="col-sm-7">
						      <input  type="number" class="form-control" name="alturabase" id="alturabase" value="60" required>

						    </div>
						  </div>


						</form> 
                    	</div>                       
                    </div>

                    
                    

                     
                    <div class="mx-3 mt-3 mb-2"><button type="submit" class="btn btn-danger btn-block" id="btn-enviar-respaldo"><small>INGRESAR</small></button></div> <small class="d-flex justify-content-center text-muted">*RespaldosChile</small>
                </div>
            </div>
        </div>




        <div class="col-sm-4">
            <div class="card" > <img src="img/basedecama.jpg" class="card-img-top" width="100%">
            	<span style="text-align: center;"><h6>Bases de Cama</h6></span>
                <div class="card-body pt-0 px-0" >
                    
                    <hr class="mt-2 mx-3">
                    <div class="d-flex flex-row justify-content-between px-3 pb-4">
                        <div class="d-flex flex-column" style="line-height: 30px;">
                        <form>
						  <div class="form-group row">
						    <label for="staticEmail" class="col-sm-5 col-form-label">Plazas</label>
						    <div class="col-sm-7">
						      <select class="form-control" name="plazas">
                           		<option value="">Seleccione</option>
                           	<option value="1">1 Plaza</option>
                           	<option value="1 1/2">1 1/2</option>
                           	<option value="Full">Full</option>
                           	<option value="2">2 Plazas</option>
                           	<option value="Queen">Queen </option>
                           	<option value="King">King</option>
                           	<option value="Super King">Super King</option>

                           </select>

						    </div>
						  </div>
						  <div class="form-group row">
						    <label for="staticEmail" class="col-sm-5 col-form-label">Cantidad</label>
						    <div class="col-sm-7">
						      <input  type="number" class="form-control">

						    </div>
						  </div>

						  <div class="form-group row">
						    <label for="staticEmail" class="col-sm-5 col-form-label">Alt Base</label>
						    <div class="col-sm-7">
						      <input  type="number" class="form-control" name="alturabase" value="60">

						    </div>
						  </div>


						</form> 








                        	</div>
                       
                    </div>

                    
                    

                     
                    <div class="mx-3 mt-3 mb-2"><button type="button" class="btn btn-danger btn-block" onclick="bases()"><small>INGRESAR</small></button></div> <small class="d-flex justify-content-center text-muted">*RespaldosChile</small>
                </div>
            </div>
        </div>


        <div class="col-sm-4">
            <div class="card"> <div style="margin:0 auto;"><img src="img/pouff.jpg" class="card-img-top"  style="width: 120px;height: 120px; text-align: center;" ></div>
            	<span style="text-align: center;"><h6>Puff</h6></span>
                <div class="card-body pt-0 px-0" >
                    
                    <hr class="mt-2 mx-3">
                    <div class="d-flex flex-row justify-content-between px-3 pb-4">
                        <div class="d-flex flex-column" style="line-height: 30px;">
                        <form>
						  <div class="form-group row">
						    <label for="staticEmail" class="col-sm-5 col-form-label">Plazas</label>
						    <div class="col-sm-7">
						      <select class="form-control" name="plazas">
                           		<option value="">Seleccione</option>
                           	<option value="1">1 Plaza</option>
                           	<option value="1 1/2">1 1/2</option>
                           	<option value="Full">Full</option>
                           	<option value="2">2 Plazas</option>
                           	<option value="Queen">Queen </option>
                           	<option value="King">King</option>
                           	<option value="Super King">Super King</option>

                           </select>

						    </div>
						  </div>
						  <div class="form-group row">
						    <label for="staticEmail" class="col-sm-5 col-form-label">Cantidad</label>
						    <div class="col-sm-7">
						      <input  type="number" class="form-control">

						    </div>
						  </div>

						  <div class="form-group row">
						    <label for="staticEmail" class="col-sm-5 col-form-label">Largo</label>
						    <div class="col-sm-7">
						      <input  type="number" class="form-control" name="largobase" value="60">

						    </div>
						  </div>


						</form> 








                        	</div>
                       
                    </div>

                    
                    

                     
                    <div class="mx-3 mt-3 mb-2"><button type="button" class="btn btn-danger btn-block" onclick="pouff()"><small>INGRESAR</small></button></div> <small class="d-flex justify-content-center text-muted">*RespaldosChile</small>
                </div>
            </div>
        </div>




       
     
    </div>
</div>
Resumen de Ingresos:</br>
<div id="resumen"></div>

<script type="text/javascript">

	$(document).ready(function(){
    $(document).on("click","#btn-enviar-respaldo",function () {

    	if (($("#cantidad").val() == "") || ($("#plazas").val()  == "")) {  //COMPRUEBA CAMPOS VACIOS
    alert("Los campos no pueden quedar vacios");
    return true;
}

        var cantidad = $("#cantidad").val();
        var plazas = $("#plazas").val();
      	 var alturabase = $("#alturabase").val();
        var ejemplo = "Respaldo de cama: Plazas: "+ plazas+" Altura Base: "+alturabase+ " Cantidad: <b>"+cantidad+ "</b><br>";

         $("#respaldos")[0].reset();

          
          $("#resumen").append(ejemplo);

    });
});



	function respaldosdecama(){

		plazas = $('input:text[name=plazas]').val();
		cantidad = $('input:text[name=cantidad]').val();
alert("Respaldos de cama"+ cantidad);




	}

	function bases(){
alert("Bases de Cama");

	}

	function pouff(){
alert("Pouf");

	}

</script>
<!--FIN del cont principal-->

<?php require_once "vistas/parte_inferior.php"?>