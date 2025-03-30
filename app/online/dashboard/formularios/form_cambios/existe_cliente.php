<?php



$id = $_POST['id'];        
$opcion = $_POST['opcion'];
$BD_SERVIDOR = "localhost";
$BD_USUARIO ="cre61650_respaldos21";
$BD_PASSWORD = "respaldos21/";
$BD_NOMBRE = "cre61650_agenda";





$mysqli = new mysqli($BD_SERVIDOR, $BD_USUARIO, $BD_PASSWORD, $BD_NOMBRE);

$mysqli -> set_charset("utf8");






switch($opcion){

	case 1:
$resultado = $mysqli->query("SELECT * FROM clientes where rut ='$id'");

$data = array();
$nestedData=array();
while($row = mysqli_fetch_assoc($resultado)) {
	
	

    $nestedData[] = $row["rut"];
    $nestedData[] = $row["nombre"];
     $nestedData[] = $row["telefono"];
     $nestedData[] = $row["correo"];
    $nestedData[] = $row["direccion"];
    $nestedData[] = $row["numero"];
    $nestedData[] = $row["dpto"];
    $nestedData[] = $row["instagram"];
    $nestedData[] = $row["region"];
    $nestedData[] = $row["comuna"];

$data[] = $nestedData;

}

  $json_data = array(
            "data"            => $nestedData   // total data array
            );
 
echo json_encode($nestedData,JSON_UNESCAPED_UNICODE);


	break;
	case 2:

$resultado = $mysqli->query("SELECT * FROM pedidos where rut_cliente ='$id' and estadopedido <3");


while($row = mysqli_fetch_assoc($resultado)) {
echo "<b><img src='https://respaldoschile.cl/intranet/dashboard/img/fabricacion.png' width='25'> El cliente tiene un pedido en curso</b> Agendado el: ".$row['fecha_ingreso']."<br>Modelo: ".$row['modelo']." Plazas: ".$row['plazas']." Tela: ".$row['tipotela']." Color: ".$row['color'];

}
	break;
	
}





	?>