<?php
header('Content-Type: text/html; charset=utf-8');

$conn = mysqli_connect('localhost', 'cre61650_respaldos21', 'respaldos21/', 'cre61650_agenda');

$BD_SERVIDOR = "localhost";
$BD_USUARIO = "cre61650_respaldos21";
$BD_PASSWORD = "respaldos21/";
$BD_NOMBRE = "cre61650_agenda";

$mysqli = new mysqli($BD_SERVIDOR, $BD_USUARIO, $BD_PASSWORD, $BD_NOMBRE);
$conn->set_charset("utf8");
$mysqli->set_charset("utf8mb4");

$modelo = isset($_POST['modelo']) ? ucfirst($_POST['modelo']) : "";
$plazas = isset($_POST['plazas']) ? $_POST['plazas'] : "";
$tipotela = isset($_POST['listatelas']) ? $_POST['listatelas'] : "";
$color = isset($_POST['lista2']) ? $_POST['lista2'] : "";
$alturabase = isset($_POST['alturabase']) ? $_POST['alturabase'] : "";
$nombre = isset($_POST['name']) ? ucfirst($_POST['name']) : "";
$correo = isset($_POST['email']) ? ucfirst($_POST['email']) : "";
$rut = isset($_POST['rut']) ? $_POST['rut'] : "";
$telefono = isset($_POST['telefono']) ? $_POST['telefono'] : "";
$numero_orden = isset($_POST['num_orden']) ? $_POST['num_orden'] : "";
$despacho = isset($_POST['despacho']) ? $_POST['despacho'] : "";
$retiro_tienda = isset($_POST['retiro_tienda']) ? $_POST['retiro_tienda'] : "";
$abono = isset($_POST['abono']) ? $_POST['abono'] : "";
$detalle_entrega = isset($_POST['detalle_entrega']) ? $_POST['detalle_entrega'] : "";


//CONSULTAMOS SI VIENE VACIA LA DIRECCION Y LE ASIGNAMOS LOS VALORES DEL ULTIMO REGISTRO CON EL NUMERO DE ORDEN QUE RECIBIMOS.
// si viene con el click de retiro en tienda no se realiza esta consulta.
if ($_POST['street_name'] == "" and $retiro_tienda != "on") {
  $resultado = $mysqli->query("SELECT direccion,numero,dpto,region,comuna FROM pedido_detalle WHERE num_orden = '$numero_orden'");
  $fila = mysqli_fetch_array($resultado);

  $direccion = ucfirst($fila['direccion']);
  $numero =  $fila['numero']; //numero de direccion
  $dpto =  $fila['dpto']; //numero de dpto o casa
  $region =  $fila['region'];
  $comuna =  $fila['comuna'];
} else {
  $direccion = isset($_POST['street_name']) ? ucfirst($_POST['street_name']) : "";
  $numero = isset($_POST['street_number']) ? $_POST['street_number'] : "";
  $dpto = isset($_POST['dpto']) ? $_POST['dpto'] : "";
  $region = isset($_POST['regiones']) ? $_POST['regiones'] : "";
  $comuna = isset($_POST['comunas']) ? $_POST['comunas'] : "";
}

if ($retiro_tienda == "on") {
  $direccion = "Retiro en tienda";
  $detalle = isset($_POST['detalle']) ? $_POST['detalle'] : "";
  $metodo_entrega = "Retiro en tienda";
} else {
  $metodo_entrega = "Despacho";
}

$mododepago = isset($_POST['mododepago']) ? $_POST['mododepago'] : "";
$comentarios = isset($_POST['message']) ? $_POST['message'] : "";
$detalles_fabricacion = isset($_POST['detalles_fabricacion']) ? $_POST['detalles_fabricacion'] : "";

$instagram = isset($_POST['instagram']) ? $_POST['instagram'] : "";
$vendedor = isset($_POST['vendedor']) ? $_POST['vendedor'] : "";
$precio = isset($_POST['precio']) ? $_POST['precio'] : "";

$fecha_ingreso = isset($_POST['fecha_ingreso']) ? $_POST['fecha_ingreso'] : "";
$fecha_entrega = isset($_POST['fecha_entrega']) ? $_POST['fecha_entrega'] : "";
$clienteexiste = isset($_POST['clienteexisterut']) ? $_POST['clienteexisterut'] : "";
$botones = isset($_POST['boton']) ? $_POST['boton'] : "";
$anclaje = isset($_POST['anclaje']) ? $_POST['anclaje'] : "";
$pagado = isset($_POST['pagado']) ? $_POST['pagado'] : "";
$referencia = isset($_POST['referencia']) ? $_POST['referencia'] : "";



$descomponerdireccion = explode(",", $_POST['direccion']);

//SI EL FORMULARIO ES PARA AGREGAR PATAS
if (isset($_POST['tipo_formulario']) && $_POST['tipo_formulario'] == "patas") {

  $cantidad = $_POST['cantidad'];
  $modelo = "Patas de cama";
  $tipotela = ucfirst($_POST['modelo']);
} else {
  $cantidad = 1;
}




if ($numero_orden != "") {
  $nuevoregistroorden = $numero_orden;
} else {
  $rs = $mysqli->query("SELECT MAX(num_orden) AS num_orden FROM pedido");
  $row = mysqli_fetch_row($rs);
  $ultimoregistroorden = trim($row[0]);
  $nuevoregistroorden = $ultimoregistroorden + 1;
}

/*


$resultado = $mysqli->query("SELECT color FROM colores WHERE id = '$color'");
$fila = mysqli_fetch_row($resultado);
// FALTA FILTRAR QUE SI SE ESTA AGREGANDO UN NUEVO PEDIDO A LA ORDEN NO SE VUELVA A INGRESAR UN PEDIDO.

if (!$conn->query("INSERT INTO pedido(rut_cliente, fecha_ingreso,despacho,vendedor,metodo_entrega,estado) VALUES ('$rut', '$fecha_ingreso','$despacho','$vendedor','$metodo_entrega','0')")) {
  echo "Falló el ingreso de datos en pedido: (" . $conn->error . ") " . $conn->error;
}




if (!$conn->query("INSERT INTO pedido_detalle(num_orden,direccion,numero, dpto, region, comuna, modelo,tamano,alturabase,tipotela, color,precio,abono,cantidad,tipo_boton,anclaje, comentarios,detalles_fabricacion,fecha_ingreso,pagado,mododepago,metodo_entrega,detalle_entrega,vendedor,estadopedido,ruta_asignada,orden_ruta,confirma,tapicero_id) VALUES ('$nuevoregistroorden','$direccion','$numero','$dpto', '$region', '$comuna', '$modelo','$plazas','$alturabase','$tipotela','$color','$precio','$abono','$cantidad','$botones','$anclaje','$comentarios','$detalles_fabricacion','$fecha_ingreso','$pagado','$mododepago','$metodo_entrega','$detalle_entrega','$vendedor','0','','','','')")) {
  echo "Falló el ingreso de datos pedido detalle: (" . $conn->error . ") " . $conn->error;
} else {
  $lastid = $conn->insert_id;
}











if ($clienteexiste == "") {
  if (!$conn->query("INSERT INTO clientes(rut, nombre, telefono, instagram,correo) VALUES ('$rut', '$nombre', '$telefono', '$instagram','$correo')")) {
    echo "Falló el ingreso de CLIENTE: (" . $conn->error . ") " . $conn->error;
  }
} else {

  $consulta = "UPDATE clientes SET telefono ='$telefono',nombre='$nombre',correo='$correo'   WHERE rut='$rut' ";
  $resultado = $conn->prepare($consulta);
  $resultado->execute();
}


if (!$conn->query("INSERT INTO direccion_clientes(rut_cliente, direccion, numero, dpto, region, comuna, referencia,estado) VALUES ('$rut', '$direccion','$numero','$dpto', '$region', '$comuna', '$referencia','1')")) {
  echo "Falló el ingreso de direccion nueva para el cliente: (" . $conn->error . ") " . $conn->error;
}


if ($dpto != '') {
  $numero = $numero . ", Departamento/Casa: " . $dpto;
}


*/



echo "
  <script src='https://cdn.jsdelivr.net/npm/sweetalert2@10'></script>
  <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css'>
  <script>
    Swal.fire({
      title: 'Pedido Ingresado con éxito',
      html: `
      <img width='30%' src='img/okimg.png'> `,
      icon: 'success',
      showCancelButton: false,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Finalizar Pedido',
      confirmButtonColor: '#fd7e14',
      cancelButtonText: 'Cerrar',
      showCloseButton: true,
      focusConfirm: false,
      html:
        `Vendedor: " . $vendedor . "<br>
      Numero de Pedido: " . $lastid . "<br>
      Numero de Orden: " . $nuevoregistroorden . "
      <br>
         <div style='text-align: center; margin-bottom: 1.5rem;'>
          <a href='agregarpedido.php?num_orden=" . $nuevoregistroorden . "' class='btn btn-info btn-sm' style='margin-right: 5px;color:white;'>Agregar un pedido a la orden anterior</a>
        </div>
        

        <div style='text-align:center; '>
          <a href='agregarpedido.php' class='btn btn-success btn-sm'>Agregar un nuevo pedido</a>
        </div>
       
        `,
        
      allowOutsideClick: false
    }).then((result) => {
      if (result.isConfirmed) {
        // Aquí puedes realizar la acción de finalización del pedido y enviar el correo
        Swal.fire({
          title: 'Pedido finalizado',
          text: 'El pedido se ha finalizado correctamente',
          icon: 'success',
          html:
        `
        <div style='text-align:center; margin-top: 10px;'>
          <a href='reportes/pedido.php?id=" . $nuevoregistroorden . "' class='btn btn-primary btn-sm'>Imprimir Comprobante</a> 
        </div> `,
          showConfirmButton: true,
          allowOutsideClick: false
        }).then(() => {
          window.location.href = 'finalizar_pedido.php?id=" . $nuevoregistroorden . "';
        });
      }
    });
  </script>";
