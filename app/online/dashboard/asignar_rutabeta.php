<?php require_once "vistas/parte_superior.php"?>

<!--INICIO del cont principal-->
<div class="container">
    <h1>Route Respaldos Chile</h1>
</div>

<div class="container-fluid" style="padding: 1rem; text-align: center; overflow: auto;  white-space: nowrap; margin:0 auto; " >
 
<?php 
include("conexion.php");
// rutas en estado 1 estan terminadas
$sql="SELECT *  from rutas where id > 147 or tipo >= 1";
$conn->set_charset("utf8");

  $result=mysqli_query($conn,$sql);


  $cadena="<label>Rutas Disponibles </label><br> 
       <select class='form-select'   id='rutas' name='rutas' style='width:800px; margin:0 auto; '>
<option value='-1' >Seleccionar una ruta</option> ";
  while ($ver=mysqli_fetch_row($result)) {
    $fecha = $ver[1];
    $idruta = $ver[0];

    if($ver[1] == "VENDIDOS EN FABRICA"){
 
    }
    else
    {
 $fecha = fechaCastellano($fecha);
    }
    
    

  $sql2="SELECT comuna from pedidos where ruta_asignada = $idruta GROUP BY comuna";
  $result2=mysqli_query($conn,$sql2);


 $comuna = "";

  while ($ver2=mysqli_fetch_row($result2)) {
    $comuna .= ', '.$ver2[0];
    
  }



    
    if($ver[6] == "3"){
      $cadena=$cadena.'<option style="background-color:#E4FEE6;" value='.$ver[0].'>'.'Productos de Stock </option>';
    }
    else if($ver[6] == "1"){
      $cadena=$cadena.'<option style="background-color:#E4FEE6;" value='.$ver[0].'>'.'Sala de ventas </option>';
    }
      else{
        $cadena=$cadena.'<option value='.$ver[0].'>'.$ver[0].' - '.$fecha.' '.$comuna.'</option>';
      }
    
  }

  
  echo  $cadena."</select><br><br>";

  function fechaCastellano ($fecha) {
  $fecha = substr($fecha, 0, 10);
  $numeroDia = date('d', strtotime($fecha));
  $dia = date('l', strtotime($fecha));
  $mes = date('F', strtotime($fecha));
  $anio = date('Y', strtotime($fecha));
  $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
  $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
  $nombredia = str_replace($dias_EN, $dias_ES, $dia);
$meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
  $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
  $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
  return $nombredia." ".$numeroDia." de ".$nombreMes." de ".$anio;
}
        ?>

       
        <div id="tablarutas"></div>
<script type="text/javascript">

    
// recargarLista();
$(document).ready(function(){
cargarpedidosDisponibles();
 
    $('#rutas').change(function(){
      cargarrutas();
      cargarpedidosDisponibles();
      

    });
});

function cargarrutas(){

$.ajax({
url :"listarutas.php",
type:"POST",
data:"id=" + $('#rutas').val(),
success:function(r){

$('#tablarutas').html(r);

},
                error:function(){

                   alert("error cargando pedidos en ruta");

                }
});
  }

setInterval(cargarrutas, 3000);




  function cargarpedidosDisponibles(){

$.ajax({
url :"asignarruta_add.php",
type:"POST",
data:"id=" + $('#rutas').val(),
success:function(r){

$('#disponibles').html(r);

},
                error:function(){

                   alert("error cargando pedidos disponibles");

                }
});

  }


    </script>
    <br> 


    PEDIDOS DISPONIBLES PARA AGREGAR A ESTA RUTA


    <div id="disponibles">
      
      


    </div>
</div>
<!--FIN del cont principal-->

<?php require_once "vistas/parte_inferior.php"?>