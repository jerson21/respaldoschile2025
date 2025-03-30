<?php
header('Content-Type: text/html; charset=utf-8');

$conn = mysqli_connect('localhost', 'cre61650_respaldos21', 'respaldos21/', 'cre61650_agenda');

$BD_SERVIDOR = "localhost";
$BD_USUARIO = "cre61650_respaldos21";
$BD_PASSWORD = "respaldos21/";
$BD_NOMBRE = "cre61650_agenda";

$mysqli = new mysqli($BD_SERVIDOR, $BD_USUARIO, $BD_PASSWORD, $BD_NOMBRE);
$conn->set_charset("utf8");


$modelo = ucfirst($_POST['modelo']);
$plazas = $_POST['plazas'];
$tipotela = $_POST['listatelas'];
$color = $_POST['lista2'];
$alturabase = $_POST['alturabase'];
$nombre = ucfirst($_POST['name']);
$correo = ucfirst($_POST['email']);
$rut = $_POST['rut'];
$telefono = $_POST['telefono'];
$direccion = ucfirst($_POST['direccion']);
$numero = $_POST['numero']; //numero de direccion
$dpto = $_POST['dpto']; //numero de dpto o casa
$region = $_POST['regiones'];
$comuna = $_POST['comunas'];
$mododepago = $_POST['mododepago'];
$comentarios = $_POST['message'];
$instagram = $_POST['instagram'];
$precio = $_POST['precio'];
$numero_orden = $_POST['num_orden'];
$fecha_ingreso = $_POST['fecha_ingreso'];
$fecha_entrega = $_POST['fecha_entrega'];
$clienteexiste = $_POST['clienteexisterut'];
$botones = $_POST['boton'];
$anclaje = $_POST['anclaje'];
$pagado = $_POST['pagado'];
$descomponerdireccion = explode(",", $_POST['direccion']);

//SI EL FORMULARIO ES PARA AGREGAR PATAS
if ($_POST['tipo_formulario'] == "patas") {
  $cantidad = $_POST['cantidad'];
  $modelo = "Patas de cama";
  $tipotela = ucfirst($_POST['modelo']);
} else {
  $cantidad = 1;
}




if ($numero_orden != "") {
  $nuevoregistroorden = $numero_orden;
} else {
  $rs = $mysqli->query("SELECT MAX(num_orden) AS num_orden FROM orden");
  $row = mysqli_fetch_row($rs);
  $ultimoregistroorden = trim($row[0]);
  $nuevoregistroorden = $ultimoregistroorden + 1;
}




$resultado = $mysqli->query("SELECT color FROM colores WHERE id = $color");
$fila = mysqli_fetch_row($resultado);

if (!$conn->query("INSERT INTO pedidos(rut_cliente, modelo, plazas, tipotela, color, alturabase, direccion, numero, dpto,telefono, region,comuna,comentarios,precio,mododepago,num_orden,fecha_ingreso,fecha_entrega,cantidad,pagado,tipo_boton,anclaje) VALUES ('$rut', '$modelo', '$plazas', '$tipotela', '$color', '$alturabase', '$direccion','$numero','$dpto', '$telefono', '$region', '$comuna', '$comentarios','$precio','$mododepago','$nuevoregistroorden','$fecha_ingreso','$fecha_entrega','$cantidad','$pagado','$botones','$anclaje')")) {
  echo "Falló el ingreso de datos: (" . $conn->error . ") " . $conn->error;
} else {
  $lastid = mysqli_insert_id($conn);

  if ($numero_orden != "") { // preguntar si el pedido ya tiene un numero de orden, osea ya tiene pedidos agregados anteriormente

  } else {
    if (!$conn->query("INSERT INTO orden(num_orden, rut_cliente, instagram, telefono,direccion, numero, dpto, comuna,correo) VALUES ('$nuevoregistroorden','$rut', '$instagram', '$telefono', '$direccion','$numero','$dpto', '$comuna','$correo')")) {
      echo "Falló el ingreso de numerodeorden: (" . $conn->error . ") " . $conn->error;
    }
  }


  if ($numero_orden != "") { // preguntar si el pedido ya tiene un numero de orden, osea ya tiene pedidos agregados anteriormente
    // tiene algo
  } else {

    if ($clienteexiste == "") {
      $conn->query("INSERT INTO clientes(rut, nombre, telefono, direccion, numero, dpto, region, comuna, instagram,correo) VALUES ('$rut', '$nombre', '$telefono', '$direccion','$numero','$dpto', '$region', '$comuna', '$instagram','$correo')");
    }




    if ($dpto != '') {
      $numero = $numero . ", Departamento/Casa: " . $dpto;
    }
  }




  echo "              Pedido Ingresado con exito<br>
            Numero de Pedido: " . $lastid . "<br>
            Numero de Orden: " . $nuevoregistroorden . "<br>
            <img width='30%' src='img/okimg.png'>
         
        <div style='text-align:center; margin-bottom:2rem; width:100%;'>
          <a href='agregarpedido.php?num_orden=$nuevoregistroorden' class='btn btn-success btn-sm borrar-btn' style='margin-left: 5px'>Agregar un pedido a la orden anterior</a> 
            
        
        </div>
        <div style='text-align:center;'>        
          <a href='agregarpedido.php' class='btn btn-primary btn-sm borrar-btn' >Agregar un nuevo pedido</a> 
        
        </div>";
}
