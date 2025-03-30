<?php

$conn=mysqli_connect('localhost','cre61650_respaldos21','respaldos21/','cre61650_agenda');

$BD_SERVIDOR = "localhost";
$BD_USUARIO ="cre61650_respaldos21";
$BD_PASSWORD = "respaldos21/";
$BD_NOMBRE = "cre61650_agenda";

$mysqli = new mysqli($BD_SERVIDOR, $BD_USUARIO, $BD_PASSWORD, $BD_NOMBRE);
$conn->set_charset("utf8");





$id = $_POST['id'];        


    $sql2 = "SELECT * FROM pedido_detalle where ruta_asignada = 0 and estadopedido IN (2,3,9);";
$querya = $conn->query($sql2);
if ($querya->num_rows > 0) {

$output = "";
$output .= "<table class='table table-hover table-striped table-bordered ' style='padding:0px; font-size:12px;'>
<thead>
<tr style=''>
<th>Cod</th>
<th style='width:8rem;'>Rut Cliente</th>
<th style='width:8rem;'>Modelo</th>
<th style='width:8rem;'>Plazas</th>
<th>Tela</th>
<th style='width:10rem;'>Color</th>
<th style='width:5rem;'>Altura Base</th>
<th style='width:15rem;'>Direccion</th>
<th>Telefono</th>
<th style='width:5rem;'>Instagram</th>
<th style='width:9rem;'>Estado Pedido</th>
<th style='width:1rem;'>Borrar</th>
<th style='width:9rem;'>Rutas</th>
</tr>
</thead>";

while ($row = $querya->fetch_assoc()) {

	$id_prod = $row['id'];

	if($row['estadopedido'] == '2'){
 $estado = "<img src='img/fabricacion.png' width='25px'";

	}
	if($row['estadopedido'] == '3'){
 $estado = "<a href='informacion_producto.php?id=$id_prod'> <img src='img/ok.png' width='25px'> </a>";

	}


  $cod = $row['color'];
  $resultado = $mysqli->query("SELECT color FROM colores WHERE id = '$cod'");
$fila = $resultado->fetch_assoc();

$modelo = ucfirst($row['modelo']);
if($row['modelo'] == "Botone 3 corridas de botones")
{
  $modelo = "1.35";
}
$color = $fila['color'];
$color = ucfirst(strtolower($color));
$tipotela = ucwords($row['tipotela']);

$rut = $row['rut_cliente'];
$resultado = $mysqli->query("SELECT * FROM clientes WHERE rut = '$rut'");
$fila = $resultado->fetch_assoc();

 
$output .= "<tbody>

<tr>
<td>{$row['id']}</td>
<td>{$row['rut_cliente']}</td>
<td>{$modelo}</td>
<td>{$row['plazas']}</td>
<td>{$tipotela}</td>
<td>{$row['color']}</td>
<td>{$row['alturabase']}</td>
<td>{$row['direccion']}  {$row['numero']}, {$row['comuna']}</td>
<td>{$row['telefono']}</td>
<td>{$fila['instagram']}</td>
<td>{$estado}</td>
<td><button class='btn btn-danger btn-sm eliminar-btn' data-id='{$row['id']}'>Eliminar</button></td>
<td><button type='button' class='btn btn-info btn-sm agregar-btn' data-toggle='modal' data-ruta='{$id}' data-id='{$row['id']}' data-target='#exampleModalCenter' data-num_orden='{$row['num_orden']}'>
 Asignar a ruta
</button></td>
</tr>
</tbody>";
}
$output .="</table>";
echo $output;
}else{
echo "<h5>Ningún registro fue encontrado</h5>";
}

?>
<script type="text/javascript">
 $(document).on("click",".agregar-btn",function(){
 
var num_orden = $(this).data('num_orden');
var id = $(this).data('id');
var ruta = $(this).data('ruta');
var element = this;
$.ajax({
url :"addidruta.php",
type:"POST",
cache:false,
data:{agregarId:id,rutaId:ruta,numero_orden:num_orden},
success:function(data){
if (data == 3) {
$(element).closest("tr").fadeOut();

}else{
alert("Error al agregar a rutas"+data);
}
}
});

});
</script>
<script type="text/javascript">
 $(document).on("click",".eliminar-btn",function(){
 

var id = $(this).data('id');
var ruta = $(this).data('ruta');
var element = this;
$.ajax({
url :"eliminarpedido.php",
type:"POST",
cache:false,
data:{agregarId:id},
success:function(data){
if (data == 1) {
$(element).closest("tr").fadeOut();
setInterval(cargarrutas, 3000);
}else{
alert("Error al agregar a ruta");
}
}
});

});
</script>


