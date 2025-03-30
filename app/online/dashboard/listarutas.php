<div id="impresion">

<?php

$conn=mysqli_connect('localhost','cre61650_respaldos21','respaldos21/','cre61650_agenda');

$BD_SERVIDOR = "localhost";
$BD_USUARIO ="cre61650_respaldos21";
$BD_PASSWORD = "respaldos21/";
$BD_NOMBRE = "cre61650_agenda";

$mysqli = new mysqli($BD_SERVIDOR, $BD_USUARIO, $BD_PASSWORD, $BD_NOMBRE);
$conn->set_charset("utf8");





$id = $_POST['id'];   
     
$contador;
	 $sql = "SELECT * FROM pedidos where ruta_asignada = '$id' ORDER BY direccion ASC";
$query = $conn->query($sql);
if ($query->num_rows > 0) {

	echo "<div  style='margin:0 auto; margin-bottom: 3rem;'>
<a href='editar_ordenruta_pruebas.php?id=".$_POST['id']."'' class='btn btn-success'>ORGANIZAR RUTA</a>


</div>";


$output = "";
$output .= "<table class='table table-hover table-striped table-bordered' style='font-size:12px; padding:0px;' cellpadding='0' cellspacing='0'>
<thead>
<tr style=''>
<th>Codigo</th>
<th style='width:8rem; padding: 0;'>Rut Cliente</th>
<th style='width:8rem; padding: 0;'>Modelo</th>
<th style='width:4rem; padding: 0;'>Plazas</th>
<th>Tela</th>
<th style='width:10rem; padding: 0;'>Color</th>
<th style='width:3rem; padding: 0;'>Altura Base</th>
<th style='width:10rem; padding: 0;'>Direccion</th>
<th>Telefono</th>
<th>Instagram</th>
<th>Estado</th>
<th style='width:8rem; padding: 0;'>Borrar</th>
<th style='width:9rem; padding: 0;' >Cliente</>
<th>Notificar</th>
</tr>
</thead>";
while ($row = $query->fetch_assoc()) {


  $id_prod = $row['id'];
  
  if($row['estadopedido'] == '2'){
 $estado = "<a href='informacion_producto.php?id=$id_prod'><img src='img/fabricacion.png' width='25px'></a>";

  }
  if($row['estadopedido'] == '3'){
 $estado = "<a href='informacion_producto.php?id=$id_prod'><img src='img/ok.png' width='25px'></a>";

  }


	$contador = $contador+1;
  $cod = $row['color'];
  $cod = $row['ruta_asignada'];
  $resultado = $mysqli->query("SELECT color FROM colores WHERE id = '$cod'");
$fila = $resultado->fetch_assoc();

$resultadoruta = $mysqli->query("SELECT fecha FROM rutas WHERE id = '$cod'");
$filaruta = $resultadoruta->fetch_assoc();
$fecha_rutar = $filaruta['fecha'];

setlocale(LC_TIME, "spanish");
  $fecha_ruta = strftime("%A, %d de %B de %Y", strtotime( $fecha_rutar));
  $fecha_ruta = strtoupper($fecha_ruta);

if($row['confirma'] ==1){
$confirmacion = "<button class='btn btn-info btn-sm -btn' data-id='{$row['id']}'>Confirmado</button>";
}
else{
$confirmacion = "<button class='btn btn-danger btn-sm -btn' data-id='{$row['id']}'>No Confirmado</button>";
}


$modelo = ucfirst($row['modelo']);
if($row['modelo'] == "Botone 3 corridas de botones")
{
  $modelo = "1.35";
}
$color = $row['color'];
$color = ucfirst(strtolower($color));
$tipotela = ucwords($row['tipotela']);
$idrutas = $row['id'];
$rut = $row['rut_cliente'];
$resultado = $mysqli->query("SELECT * FROM clientes WHERE rut = '$rut'");
$fila = $resultado->fetch_assoc();

$numero_de_orden = $row['num_orden'];
$resultados = $mysqli->query("SELECT * FROM pedidos WHERE num_orden = '$numero_de_orden' order by modelo");
$ordenes_array = array();
while($filas = $resultados->fetch_assoc()){
$pedido.= "-".$filas['modelo']." ".$filas['plazas']." ".$filas['tipotela']." ".$filas['color']." ".$filas['alturabase']."%0A";
$total_pagar +=$filas['precio'];
$ordenes_array[]=$numero_de_orden;
$ordenes_array[$numero_de_orden][1];

}
$nombre = utf8_encode($fila['nombre']);

$fecha_ruta = utf8_encode($fecha_ruta);



  
$mensaje_whatsapp = "<a href='https://api.whatsapp.com/send/?phone=+56{$row['telefono']}&text=Hola {$nombre}👋!%0A%0A Le informamos que su pedido%0A{$pedido}%0A%0A Será entregado este *{$fecha_ruta}*, por RespaldosChile%0ADireccion de Entrega: {$row['direccion']} {$row['numero']} %0ADpto/Casa : {$row['dpto']} %0AComuna: {$row['comuna']} %0ATotal a pagar: $ {$total_pagar} (Si esta pagado omitir esto) %0A%0A*Por favor ingresar en el siguiente link y confirmarnos que puede recibir*👉 %0Ahttps://respaldoschile.cl/cliente_confirma_numorden.php?pedido={$numero_de_orden}%0A%0ASi no le aparece el link debe agregar este numero a sus contactos.%0A*Importante: El producto debe estar pagado para que nuestro despachador se retire del domicilio.*%0A%0A*El horario de entrega se informara mediante un sms al momento de salir a reparto.*' class='btn btn-success' style='height:30px; line-height:15px; font-size:12px;'>Notificar Whatsapp</a>";


$output .= "<tbody>

<tr>
<td>{$row['id']}</td>
<td>{$row['rut_cliente']}</td>
<td>{$modelo}</td>
<td>{$row['plazas']} {$row['tipo_boton']}</td>
<td>{$row['tipotela']}</td>
<td>{$color}</td>
<td>{$row['alturabase']}</td>
<td>{$row['direccion']}  {$row['numero']},{$row['dpto']} ,{$row['comuna']}</td>
<td>{$row['telefono']}</td>
<td>{$fila['instagram']}</td>
<td>{$estado}</td>

<td><button class='btn btn-danger btn-sm borrar-btn' data-id='{$row['id']}'>Borrar de Ruta</button></td>
<td>$confirmacion</td>
<td>{$mensaje_whatsapp}</td>

</tr>
</tbody>";
$pedido = "";
$total_pagar = 0;

}

$output .="</table><br> Cantidad de Productos cargados en ruta: ".$contador;
echo $output;

?>

<br>
 <div class="container">
            <div class="row">
<!-- <div  class="col-2">Despachador Asignado: <br>
Hora de Inicio: <br>
Cantidad de Productos a entregar: <?php echo $contador; ?><br> </div> -->

</div>
</div>
</div>
  <input type="button" onclick="printDiv('impresion')" value="imprimir div" />
<?php
}else{
echo "<h5>Ningún registro fue encontrado</h5>";

}


?>

<script type="text/javascript">
 $(document).on("click",".borrar-btn",function(){ // ELIMINAR PEDIDO DE LA RUTA
 

var id = $(this).data('id');
var element = this;
$.ajax({
url :"deleteidruta.php",
type:"POST",
cache:false,
data:{agregarId:id},
success:function(data){
if (data == 1) {
$(element).closest("tr").fadeOut();

}else{
alert("Error al agregar a ruta");
}
}
});

});
</script>


<script type="text/javascript">
  function printDiv(nombreDiv) {
     var contenido= document.getElementById(nombreDiv).innerHTML;
     var contenidoOriginal= document.body.innerHTML;

     document.body.innerHTML = contenido;

     window.print();

     document.body.innerHTML = contenidoOriginal;
}

</script>