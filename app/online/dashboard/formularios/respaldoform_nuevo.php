  <?php  
include("conexion.php");
session_start();
  $num_orden = $_GET["num_orden"];
    
$rut_cliente = "";
$direccion = "";
$telefono = "";
$numero = "";
$dpto = "";
$correo = "";
$instagram = "";
$nombre = "";

  if(!empty($num_orden)){ 
    $strsql = "SELECT * FROM orden where num_orden = $num_orden";
    $rs = mysqli_query($conn, $strsql);
    $total_rows = $rs->num_rows;
    $data = array();   
while( $row=mysqli_fetch_array($rs) ) {
$rut_cliente = $row['rut_cliente'];
$direccion = $row['direccion'];
$telefono = $row['telefono'];
$numero = $row['numero'];
$dpto = $row['dpto'];
$correo = $row['correo'];
$instagram = $row['instagram'];

}

$strsqls = "SELECT * FROM clientes WHERE rut = '$rut_cliente'"; 
    $rss = mysqli_query($conn, $strsqls);
    $total_rows = $rs->num_rows;
    
while($arow=mysqli_fetch_array($rss) ) {

$nombre = $arow['nombre'];

}


}


 ?>
 <div id="a" class="a" >

  <style type="text/css">/* Estilo para el select */
/* Estilo para el select pequeño */
select.form-select-sm {
  height: calc(1.5em + 0.5rem + 2px);
  font-size: 0.875rem;
  padding-top: 0.25rem;
  padding-bottom: 0.25rem;
  border-radius: 0.2rem;
}

/* Estilo para el select grande */
select.form-select-lg {
  height: calc(1.5em + 1rem + 2px);
  font-size: 1.25rem;
  padding-top: 0.5rem;
  padding-bottom: 0.5rem;
  border-radius: 0.3rem;
}

.custom-input {
  font-size: 14px;
  height: 30px;
  border-radius: 5px;
  border: 1px solid #ccc;
  padding: 5px 10px;
}

.custom-input:focus {
  border-color: #007bff;
  box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}


</style>
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&display=swap" rel="stylesheet">

<form  name="formular" id="formular" class="php-email-form" accept-charset="utf-8" method="post" action="">
              <div class="row gy-4" style="margin-top:15px; background-color: white; padding: 30px; border-radius: 5px; border:solid 1px; border-color: #252525;  font-family: 'Open Sans', sans-serif;">

              <div class="row" >
  <div class="col-md-4">
    <label for="modelo" class="form-label fw-bold">Modelo</label>
    <select class="form-select form-select-sm" name="modelo" id="modelo" required>
      <option value="" selected disabled hidden>Seleccionar Modelo</option>
      <optgroup label="Botone">
        <option value="Botone">Botone</option>
        <option value="Botone 3 corridas de botones">Botone 3 corridas de botones</option>
        <option value="Botone 4 corridas de botones">Botone 4 corridas de botones</option>
      </optgroup>
      <optgroup label="Modelo Liso">
        <option value="Liso">Liso</option>
        <option value="Liso Completo mdf">Liso Completo Mdf</option>
        <option value="Liso 1.35">Liso 1.35</option>
        <option value="Liso con costuras">Liso con costuras</option>
        <option value="Liso con costuras 1.35">Liso con costuras 1.35</option>
        <option value="Liso con Orejas">Liso Con Orejas</option>
        <option value="Liso con Orejas y tachas">Liso Con Orejas y Tachas</option>
      </optgroup>
      <optgroup label="Capitone">
        <option value="Capitone">Capitone</option>
        <option value="Capitone orejas">Capitone Con Orejas</option>
        <option value="Capitone orejas y tachas">Capitone Con Orejas y Tachas</option>
      </optgroup>
      <optgroup label="Botone con Orejas">
        <option value="3 corridas de botones orejas">Botone 3 corridas con Orejas</option>
        <option value="4 corridas de botones orejas">Botone 4 corridas con Brazos</option>
      </optgroup>
    </select>
  </div>
  <div class="col-md-4">
    <label for="plazas" class="form-label fw-bold">Seleccionar las plazas</label>
    <select class="form-select form-select-sm" name="plazas" id="plazas" aria-label="Default select example" required>
      <option value="" selected disabled hidden>Seleccionar las plazas</option>
      <option value="1">1 plaza</option>
      <option value="1 1/2">1 1/2</option>
      <option value="Full">Full</option>
      <option value="2">2 Plazas</option>
      <option value="Queen">Queen</option>
      <option value="King">King</option>
      <option value="Super King">Super King</option>
    </select>
  </div>
</div>
<div class="row mt-3">
  <div class="col-md-4">
  <label for="listatelas" class="form-label fw-bold">Seleccionar tipo de tela</label>
  <select id="listatelas" name="listatelas" class="form-select form-select-sm" aria-label="Default select example" required>                  
    <option value="lino">Lino</option>                  
    <option value="felpa">Felpa</option>
    <option value="mosaico">Felpa Mosaico</option>
    <option value="ecocuero">Eco Cuero</option>
  </select>
</div>
<div class="col-md-4" id="select2lista"></div>
  </div>

                
                
                <div class="col-md-4">
                <label for="listatelas" class="form-label fw-bold">Altura de base </label>
                  <select class="form-select form-select-sm" name="alturabase" aria-label="Default select example">
                  <option >Medida Base de respaldo</option>
                  <option value="20">20 cm</option>
                  <option value="25">25 cm</option>
                  <option value="45">45 cm</option>
                  <option value="50">50 cm</option>
                  <option value="55">55 cm</option>
                  <option value="55">56 cm</option>
                  <option value="55">57 cm</option>
                  <option selected value="60">60 cm Estandar</option>
                  <option value="61">61 cm</option>
                  <option value="62">62 cm</option>
                  <option value="63">63 cm</option>
                  <option value="64">64 cm</option>
                  <option value="65">65 cm</option>
                  <option value="66">66 cm</option>
                  <option value="67">67 cm</option>
                  <option value="68">68 cm</option>
                  <option value="69">69 cm</option>
                  <option value="70">70 cm</option>
                  <option value="71">71 cm</option>
                  <option value="72">72 cm</option>
                  <option value="73">73 cm</option>
                  <option value="74">74 cm</option>
                  <option value="75">75 cm</option>
                  <option value="76">76 cm</option>
                  <option value="77">77 cm</option>
                  <option value="78">78 cm</option>
                  <option value="79">79 cm</option>
                  <option value="80">80 cm</option>
                </select>
                <div style="font-size: small">Si mide más de la medida estandar 60 cm, Tiene un costo adicional de $5000 cada 10cm.</div>
                </div>

                <div class="col-md-6" >
                </div>

                <div class="row" style="margin-top:15px; font-family: 'Open Sans', sans-serif; font-size: 14px">
                <div class="col-md-4" >
                <div class="alert alert-info" role="alert" style="height: 15px; line-height: 1px; display: flex;  align-items: center;">
                <i class="bi bi-arrow-down-circle-fill" style=" padding-right: 5px;"> </i>  Indicar tipo de botones aqui
                </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="boton" id="diamante" value="B D">
                    <label class="form-check-label" for="flexRadioDefault1">Botones Diamante</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="boton" id="colores" value="B Color" checked>
                    <label class="form-check-label" for="flexRadioDefault2">Botones de colores </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="boton" id="normales" value="" checked>
                    <label class="form-check-label" for="flexRadioDefault2">Botones Normales</label>
                  </div>
                </div>
                
                <div class="col-md-4" >
                  <div class="alert alert-info" role="alert" style="height: 15px; line-height: 1px;  display: flex;  align-items: center;">
                <i class="bi bi-arrow-down-circle-fill" style=" padding-right: 5px;"> </i>   Indicar Sistema de anclaje
                </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="anclaje" id="anclaje" value="si" checked>
                    <label class="form-check-label" for="flexRadioDefault3"> Con sistema de anclaje </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="anclaje" id="anclaje" value="patas" checked>
                    <label class="form-check-label" for="flexRadioDefault3">Con patas de madera</label>

                </div>
                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="anclaje" id="anclaje" value="no" checked>
                    <label class="form-check-label" for="flexRadioDefault3">Sin sistema de anclaje</label>

                </div>
              </div>
            </div>
                    <div style="color:red;" id="pedidoexistente"></div>


<style type="text/css">


  .progress-bar-wrapper {
  position: relative;
  height: 20px; /* ajusta la altura del contenedor según tus necesidades */
}

.progress {
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  margin: auto;
  height: 100%;
}

.progress-bar {
  width: 0;
  height: 100%;
  background-color: #007bff; /* ajusta el color según tus necesidades */
  transition: width 0.3s ease-in-out;
}
.esse{
  
  margin:0px;
}
</style>


                  <div style="font-size: medium; "><b>DATOS DE CONTACTO Y ENVÍO</b></div>
                  <div class="progress-bar-wrapper">
  <div class="progress-bar" role="progressbar" style=" width: 0;   background-color: #007bff;  transition: width 0.5s ease-in-out;"  value="0" max="100"  ></div>
</div>
                  <div class="col-md-4 esse">

                 
                  <input type="text" name="rut" id="rut" class="form-control custom-input " placeholder="Rut" onkeydown="noPuntoComa(event)" oninput="checkRut(this); updateProgress();" autocomplete="off" value="<?php echo $rut_cliente; ?>" required>
                   <p class="text-info esse"  id="msgerror" style="color:red !important; padding: 0; font-size: 13px;"></p><p class="text-info " style=" padding: 0; font-size: 13px; margin-bottom:10px;" id="msgvalido"></p>
                
                </div>

                <div class="col-md-4 esse" >
                  
                  <input type="text" name="name" id="name" class="form-control custom-input" placeholder="Nombre" onkeyup="updateProgress();" value="<?php echo $nombre; ?>" required>
                  <input type="hidden" name="clienteexisterut" id="clienteexisterut" value="">
                </div>



                <div class="col-md-4 esse">
                  
                  <input type="email" class="form-control custom-input" name="email" id="email" placeholder="Correo" onkeyup="updateProgress();" value="<?php echo $correo; ?>" >
                 
                </div>
                
               
                
                <div class="col-md-4 esse">
                   
                  <input type="text" name="telefono" id="telefono" class="form-control custom-input" placeholder="Telefono" onkeyup="updateProgress();" value="<?php echo $telefono; ?>" required>
                </div>

                <div class="col-md-4 esse">
                  <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyAy1me0GgrNwevFOTCa8MQo2gNNt79JizI"></script>


              <div class="form-group esse">
                
                  
                  <input type="text" name="direccion" id="direccion" class="form-control custom-input" id="search_input" onkeyup="updateProgress();" placeholder="Ingrese Direccion..." value="<?php echo $direccion; ?>" required>
                  <input type="hidden" id="loc_lat" />
                  <input type="hidden" id="loc_long" />
                  <input type="hidden" name="street_number" id="street_number" />

                
              </div>

                </div>
                <div class="col-md-2 esse" >
                
                  <input type="text" class="form-control custom-input" name="numero" id="numero" placeholder="Numero" onkeyup="updateProgress();" value="<?php echo $numero; ?>" required>
                </div>
                <div class="col-md-2 esse">
                 
                  <input type="text" class="form-control custom-input" name="dpto" id="dpto" placeholder="Dpto/casa" onkeyup="updateProgress();" value="<?php echo $dpto; ?>">
                </div>
                
                <?php if($num_orden >= 1) {

                    $sqlcomuna = "SELECT region, comuna FROM pedidos where num_orden = $num_orden";                    
                    $rss3 = mysqli_query($conn, $sqlcomuna);
                    $arow3=mysqli_fetch_array($rss3);
                    $region = $arow3['region'];
                    $comuna = $arow3['comuna'];
                    ?>
                      <div class="col-md-6">
                   <input type="text" class="form-control custom-input" name="regiones"  value="<?php echo $region; ?>">
                 </div>
                 <div class="col-md-6">
                   <input type="text" class="form-control custom-input" name="comunas"  value="<?php echo $comuna; ?>">
                 </div>

                    <?php
                }else{ ?>

              <div class="col-md-6">
                 
                  <select class="form-select form-select-sm" id="regiones" name="regiones"></select>


                </div>

                <div id="comuna" class="col-md-6">

                <select class="form-select form-select-sm" id="comunas" name="comunas" required></select>

                  </div>

              <?php  } ?>
                
                
                <div class="col-md-6">
                  <label class="form-check-label fw-bold" >Lugar de venta</label>
                  <input type="text" class="form-control custom-input" name="instagram" id="instagram" placeholder="Instagram, sala de ventas" value="<?php echo $instagram; ?>">
                </div>
                <div class="col-md-4">
                <label class="form-check-label fw-bold" >Precio</label>
                  <input type="text" class="form-control custom-input" name="precio" placeholder="$" required>
                </div>
                  <div class="col-md-6">
                  Seleccionar Forma de pago
                  <select id="mododepago" name="mododepago" class="form-select form-select-sm" aria-label="Modo de Pago"  required>                  
                  <option value="transferencia">Transferencia</option>                  
                  <option value="efectivo">Efectivo</option>
                  <option value="debito">Debito </option>
                  <option value="credito">Credito</option>
                  <option value="pagado">Pagado</option>
                </select>
                </div>
                <div class="col-md-3">
                  Fecha de entrega estimada
                  <input type="date" name="fecha_entrega" class="form-control custom-input">
                </div>
                <div class="col-md-2">
                  Fecha de ingreso
                  <input type="text" name="fecha_ingreso"  class="form-control custom-input" value="<?php setlocale(LC_ALL,"es_ES"); echo date("j/n/Y"); ?>" readonly>
                </div>
                   <div class="col-md-4">
                      <div class="alert alert-info" role="alert" style="height: 15px; line-height: 1px; display: flex; background-color: #9AFFA1;  align-items: center;">
                <i class="bi bi-arrow-down-circle-fill" style=" padding-right: 5px;"> </i>   Indicar Si el respaldo esta pagado.
                </div>           


                      <select id="pagado" name="pagado" class="form-select form-select-sm" aria-label="Pagado"  required>                  
                      <option value="0" style="background-color: red;">NO PAGADO</option>                  
                      <option value="1" style="background-color: green;">PAGADO</option>                      
                    </select>
                   
                  
                    </div>
                       <div class="col-md-6" style="margin-right: 0;">
                     <div class="alert alert-info" role="alert" style="height: 15px; line-height: 1px; display: flex; background-color: #9AFFA1; align-items: center;">
                <i class="bi bi-arrow-down-circle-fill" style=" padding-right: 5px; "> </i>  Información de pago.
                </div> 
                    <input type="text" class="form-control custom-input" name="id_pago" placeholder="id de comprobante, nombre o rut">
                    </div>

                <div class="col-md-3">
                  
                 Vendedor <input type="text" readonly class="form-control custom-input" name="vendedor" value="<?php  echo  ucfirst($_SESSION['nombre_user']); ?>">
                  
                
                </div>
                 <div class="col-md-6">
                  
                 
                  
                
                </div>
                <div class="col-md-7">
                  <label>Información adicional para fabricación</label>
                  <textarea class="form-control custom-input" name="message" style=" background-color: #EAFCFF;" rows="3" placeholder="Información adicional para la fabricación." ></textarea>
                </div>
                  <div class="col-md-6">
                    <label>Información adicional para la entrega</label>
                  <textarea class="form-control custom-input" name="info_entrega" style=" background-color: #EAFFED;" rows="3" placeholder="Información adicional para la entrega." ></textarea>
                </div>

                <div class="col-md-12 text-center">
                  <input type="hidden" name="num_orden" value="<?php echo $num_orden?>">
                  

                  <button type="submit"  id="botonenviar" class="btn btn-primary">Enviar Datos de compra</button>
                </div>

              </div>
            </form>
</div>


 <script type="text/javascript">
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

                </script>

<script type="text/javascript">
   function establecerVisibilidadImagen(id, visibilidad) {
var img = document.getElementById(id);
img.style.visibility = (visibilidad ? 'visible' : 'hidden');
}


</script>
<script type="text/javascript">
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
</script>
<script type="text/javascript">

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
</script>

<script type="text/javascript">
   
 
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
                   alert("Error seleccionando el tipo de tela");

                }
            });
} 
</script>


<script type="text/javascript">
var RegionesYcomunas = {

  "regiones": [{
      "NombreRegion": "Arica y Parinacota",
      "comunas": ["Arica", "Camarones", "Putre", "General Lagos"]
  },
    {
      "NombreRegion": "Tarapacá",
      "comunas": ["Iquique", "Alto Hospicio", "Pozo Almonte", "Camiña", "Colchane", "Huara", "Pica"]
  },
    {
      "NombreRegion": "Antofagasta",
      "comunas": ["Antofagasta", "Mejillones", "Sierra Gorda", "Taltal", "Calama", "Ollagüe", "San Pedro de Atacama", "Tocopilla", "María Elena"]
  },
    {
      "NombreRegion": "Atacama",
      "comunas": ["Copiapó", "Caldera", "Tierra Amarilla", "Chañaral", "Diego de Almagro", "Vallenar", "Alto del Carmen", "Freirina", "Huasco"]
  },
    {
      "NombreRegion": "Coquimbo",
      "comunas": ["La Serena", "Coquimbo", "Andacollo", "La Higuera", "Paiguano", "Vicuña", "Illapel", "Canela", "Los Vilos", "Salamanca", "Ovalle", "Combarbalá", "Monte Patria", "Punitaqui", "Río Hurtado"]
  },
    {
      "NombreRegion": "Valparaíso",
      "comunas": ["Valparaíso", "Casablanca", "Concón", "Juan Fernández", "Puchuncaví", "Quintero", "Viña del Mar", "Isla de Pascua", "Los Andes", "Calle Larga", "Rinconada", "San Esteban", "La Ligua", "Cabildo", "Papudo", "Petorca", "Zapallar", "Quillota", "Calera", "Hijuelas", "La Cruz", "Nogales", "San Antonio", "Algarrobo", "Cartagena", "El Quisco", "El Tabo", "Santo Domingo", "San Felipe", "Catemu", "Llaillay", "Panquehue", "Putaendo", "Santa María", "Quilpué", "Limache", "Olmué", "Villa Alemana"]
  },
    {
      "NombreRegion": "Región del Libertador Gral. Bernardo O’Higgins",
      "comunas": ["Rancagua", "Codegua", "Coinco", "Coltauco", "Doñihue", "Graneros", "Las Cabras", "Machalí", "Malloa", "Mostazal", "Olivar", "Peumo", "Pichidegua", "Quinta de Tilcoco", "Rengo", "Requínoa", "San Vicente", "Pichilemu", "La Estrella", "Litueche", "Marchihue", "Navidad", "Paredones", "San Fernando", "Chépica", "Chimbarongo", "Lolol", "Nancagua", "Palmilla", "Peralillo", "Placilla", "Pumanque", "Santa Cruz"]
  },
    {
      "NombreRegion": "Región del Maule",
      "comunas": ["Talca", "ConsVtución", "Curepto", "Empedrado", "Maule", "Pelarco", "Pencahue", "Río Claro", "San Clemente", "San Rafael", "Cauquenes", "Chanco", "Pelluhue", "Curicó", "Hualañé", "Licantén", "Molina", "Rauco", "Romeral", "Sagrada Familia", "Teno", "Vichuquén", "Linares", "Colbún", "Longaví", "Parral", "ReVro", "San Javier", "Villa Alegre", "Yerbas Buenas"]
  },
    {
      "NombreRegion": "Región del Biobío",
      "comunas": ["Concepción", "Coronel", "Chiguayante", "Florida", "Hualqui", "Lota", "Penco", "San Pedro de la Paz", "Santa Juana", "Talcahuano", "Tomé", "Hualpén", "Lebu", "Arauco", "Cañete", "Contulmo", "Curanilahue", "Los Álamos", "Tirúa", "Los Ángeles", "Antuco", "Cabrero", "Laja", "Mulchén", "Nacimiento", "Negrete", "Quilaco", "Quilleco", "San Rosendo", "Santa Bárbara", "Tucapel", "Yumbel", "Alto Biobío", "Chillán", "Bulnes", "Cobquecura", "Coelemu", "Coihueco", "Chillán Viejo", "El Carmen", "Ninhue", "Ñiquén", "Pemuco", "Pinto", "Portezuelo", "Quillón", "Quirihue", "Ránquil", "San Carlos", "San Fabián", "San Ignacio", "San Nicolás", "Treguaco", "Yungay"]
  },
    {
      "NombreRegion": "Región de la Araucanía",
      "comunas": ["Temuco", "Carahue", "Cunco", "Curarrehue", "Freire", "Galvarino", "Gorbea", "Lautaro", "Loncoche", "Melipeuco", "Nueva Imperial", "Padre las Casas", "Perquenco", "Pitrufquén", "Pucón", "Saavedra", "Teodoro Schmidt", "Toltén", "Vilcún", "Villarrica", "Cholchol", "Angol", "Collipulli", "Curacautín", "Ercilla", "Lonquimay", "Los Sauces", "Lumaco", "Purén", "Renaico", "Traiguén", "Victoria", ]
  },
    {
      "NombreRegion": "Región de Los Ríos",
      "comunas": ["Valdivia", "Corral", "Lanco", "Los Lagos", "Máfil", "Mariquina", "Paillaco", "Panguipulli", "La Unión", "Futrono", "Lago Ranco", "Río Bueno"]
  },
    {
      "NombreRegion": "Región de Los Lagos",
      "comunas": ["Puerto Montt", "Calbuco", "Cochamó", "Fresia", "FruVllar", "Los Muermos", "Llanquihue", "Maullín", "Puerto Varas", "Castro", "Ancud", "Chonchi", "Curaco de Vélez", "Dalcahue", "Puqueldón", "Queilén", "Quellón", "Quemchi", "Quinchao", "Osorno", "Puerto Octay", "Purranque", "Puyehue", "Río Negro", "San Juan de la Costa", "San Pablo", "Chaitén", "Futaleufú", "Hualaihué", "Palena"]
  },
    {
      "NombreRegion": "Región Aisén del Gral. Carlos Ibáñez del Campo",
      "comunas": ["Coihaique", "Lago Verde", "Aisén", "Cisnes", "Guaitecas", "Cochrane", "O’Higgins", "Tortel", "Chile Chico", "Río Ibáñez"]
  },
    {
      "NombreRegion": "Región de Magallanes y de la AntárVca Chilena",
      "comunas": ["Punta Arenas", "Laguna Blanca", "Río Verde", "San Gregorio", "Cabo de Hornos (Ex Navarino)", "AntárVca", "Porvenir", "Primavera", "Timaukel", "Natales", "Torres del Paine"]
  },
    {
      "NombreRegion": "Región Metropolitana de Santiago",
      "comunas": ["Cerrillos", "Cerro Navia", "Conchalí", "El Bosque", "Estación Central", "Huechuraba", "Independencia", "La Cisterna", "La Florida", "La Granja", "La Pintana", "La Reina", "Las Condes", "Lo Barnechea", "Lo Espejo", "Lo Prado", "Macul", "Maipú", "Ñuñoa", "Pedro Aguirre Cerda", "Peñalolén", "Providencia", "Pudahuel", "Puente Alto", "Quilicura", "Quinta Normal", "Recoleta", "Renca", "San Joaquín", "San Miguel", "San Ramón", "Santiago", "Vitacura", "Pirque", "San José de Maipo", "Colina", "Lampa", "TilTil", "San Bernardo", "Buin", "Calera de Tango", "Paine", "Melipilla", "Alhué", "Curacaví", "María Pinto", "San Pedro", "Talagante", "El Monte", "Isla de Maipo", "Padre Hurtado", "Peñaflor"]
  }]
}


jQuery(document).ready(function () {


  var iRegion = 0;
  var htmlRegion = '<option value="sin-region">Seleccione región</option><option value="sin-region">--</option>';
  var htmlComunas = '<option value="sin-region">Seleccione comuna</option><option value="sin-region">--</option>';

  jQuery.each(RegionesYcomunas.regiones, function () {
    htmlRegion = htmlRegion + '<option value="' + RegionesYcomunas.regiones[iRegion].NombreRegion + '">' + RegionesYcomunas.regiones[iRegion].NombreRegion + '</option>';
    iRegion++;
  });

  jQuery('#regiones').html(htmlRegion);
  jQuery('#comunas').html(htmlComunas);

  jQuery('#regiones').change(function () {
    var iRegiones = 0;
    var valorRegion = jQuery(this).val();
    var htmlComuna = '<option value="sin-comuna">Seleccione comuna</option><option value="sin-comuna">--</option>';
    jQuery.each(RegionesYcomunas.regiones, function () {
      if (RegionesYcomunas.regiones[iRegiones].NombreRegion == valorRegion) {
        var iComunas = 0;
        jQuery.each(RegionesYcomunas.regiones[iRegiones].comunas, function () {
         
          htmlComuna = htmlComuna + '<option value="' + RegionesYcomunas.regiones[iRegiones].comunas[iComunas] + '">' + RegionesYcomunas.regiones[iRegiones].comunas[iComunas] + '</option>';
          iComunas++;
        });
      }
      iRegiones++;
    });
    jQuery('#comunas').html(htmlComuna);
  });
  jQuery('#comunas').change(function () {
    if (jQuery(this).val() == 'sin-region') {
      alert('selecciones Región');
    } else if (jQuery(this).val() == 'sin-comuna') {
      alert('selecciones Comuna');
    }
  });
  jQuery('#regiones').change(function () {
    if (jQuery(this).val() == 'sin-region') {
      alert('selecciones Región');
    }
  });

});
</script>

<script>
var searchInput = 'search_input';

$(document).ready(function () {
    var autocomplete;
    autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {
        types: ['geocode']
    });
        
    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        var near_place = autocomplete.getPlace();
        document.getElementById('loc_lat').value = near_place.geometry.location.lat();
        document.getElementById('loc_long').value = near_place.geometry.location.lng();
                
        document.getElementById('latitude_view').innerHTML = near_place.geometry.location.lat();
        document.getElementById('longitude_view').innerHTML = near_place.geometry.location.lng();
          
    });
});
</script>

<script type="text/javascript"> let autocomplete;
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
} </script>

<script type="text/javascript">
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
             <p><strong>Dirección:</strong> ${$("#direccion").val()} ${$("#numero").val()} ${$("#dpto").val()}</p>
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


        </script>