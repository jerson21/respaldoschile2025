<?php
header('Content-Type: text/html; charset=utf-8');

$conn=mysqli_connect('localhost','cre61650_respaldos21','respaldos21/','cre61650_agenda');

$BD_SERVIDOR = "localhost";
$BD_USUARIO ="cre61650_respaldos21";
$BD_PASSWORD = "respaldos21/";
$BD_NOMBRE = "cre61650_agenda";

$mysqli = new mysqli($BD_SERVIDOR, $BD_USUARIO, $BD_PASSWORD, $BD_NOMBRE);
$conn->set_charset("utf8");


$fecha = $_POST['fecha'];
$tipo_lista = $_POST['tipo_lista'];





if (!$conn->query("INSERT INTO rutas(fecha,tipo) VALUES ('$fecha','$tipo_lista')")){
    echo "Falló el ingreso de ruta: (" . $conn->error . ") " . $conn->error;
}
else {

	echo "1";
}






  ?>

 

  