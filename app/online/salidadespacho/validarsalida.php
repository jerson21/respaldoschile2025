<?php 
include('conexion.php');
$id = $_POST['id'];
$ruta = $_POST['ruta'];

include_once 'conexion2.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();


 $sql="SELECT * from pedido_detalle where id = $id";

  $result2=mysqli_query($conn,$sql);




  while ($ver2=mysqli_fetch_array($result2)) {
  	
    $modelo = $ver2['modelo'];
    $plazas = $ver2['tamano'];
    $tela = $ver2['tipotela'];
    $color = $ver2['color'];
    $base = $ver2['alturabase'];
    $comentarios = $ver2['detalles_fabricacion'];

    
  }

//INICIAR RUTA PARA INDICAR QUE ESTA EN RUTA AL DOMICILIO.
  $strsqls = "SELECT * FROM pedido_detalle WHERE ruta_asignada = $ruta and estadopedido <= 6 ORDER by orden_ruta DESC LIMIT 1";
    $rss = mysqli_query($conn, $strsqls);
   $row_cnt = $rss->num_rows;
    
while($arow=mysqli_fetch_array($rss) ) {

 $ruta_porleer = $arow['id'];

}

if($id == $ruta_porleer){

  $obs= "escaneado ok";
        
  date_default_timezone_set('America/Santiago');
  $DateAndTime = date('d-m-Y h:i:s a', time());
 

 $consulta = "INSERT INTO pedido_etapas (idPedido, idProceso, fecha,usuario,observacion) VALUES('$id', 8, '$DateAndTime',3,'$obs') "; 
 $conn->query($consulta) or die("Error: ".mysqli_error($conn)); 

$query = "UPDATE pedido_detalle SET estadopedido='8' WHERE id = $id";
$conn->query($query) or die("Error: ".mysqli_error($conn)); 

echo "Pedido ".$id."\n Saliendo a despacho Modelo:".$modelo." \n Plazas:".$plazas."\n Tela: ".$tela."\n  Color:".$color."\n Altura Base: ".$base."\n Detalles: ".$comentarios;

}
else{
	echo "Hola!: se espera leer el pedido codigo: ".$ruta_porleer;
}
 
 ?>