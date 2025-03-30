<?php include "vistas/parte_superior.php"?>
<style type="text/css">
    ody {
    font-family: Arial;
    font-size: 17px;
    padding: 8px;
}

* {
    box-sizing: border-box;
}

h2 {
    font-size: 40px;
    background: linear-gradient(to left, #660066 0%, #ff3300 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.row {
    display: -ms-flexbox;
    /* IE10 */
    display: flex;
    -ms-flex-wrap: wrap;
    /* IE10 */
    flex-wrap: wrap;
    margin: 0 -16px;
}

.col-25 {
    -ms-flex: 25%;
    /* IE10 */
    flex: 25%;
}

.col-50 {
    -ms-flex: 50%;
    /* IE10 */
    flex: 50%;
}

.col-75 {
    -ms-flex: 75%;
    /* IE10 */
    flex: 75%;
}

.col-25,
.col-50,
.col-75 {
    padding: 0 16px;
}

.container {
    background-color: #f2f2f2;
    padding: 5px 20px 15px 20px;
    border: 1px solid lightgrey;
    border-radius: 3px;
}

input[type=text] {
    width: 100%;
    margin-bottom: 20px;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 3px;
}

label {
    margin-bottom: 10px;
    display: block;
}

.icon-container {
    margin-bottom: 20px;
    padding: 7px 0;
    font-size: 24px;
}



hr {
    border: 1px solid lightgrey;
}

span.price {
    float: right;
    color: grey;
}

/* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other (also change the direction - make the "cart" column go on top) */
@media (max-width: 800px) {
    .row {
        flex-direction: column-reverse;
    }

    .col-25 {
        margin-bottom: 20px;
    }
}
.texto{
    float: right;
    font-weight: bold;
    color: black;
}
</style>
<!--INICIO del cont principal-->

    <h1>Confirmacion de cambio de producto</h1>
    
    
    
 <?php
 if(!isset($_SESSION)) 
    { 
session_start();

 }
 $usuario_activo = $_SESSION['nombre_user'] = $_SESSION["s_usuario"];


include_once 'bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();





?>

<div class="container" >


<div class="row">
    <div class="col-75">

     <?php
     
        $num_orden = $_POST['num_orden'];
        $rut_cliente = $_POST['rut_cliente'];
        $cod_pedidoanterior = $_POST['cod_pedidoanterior'];
        $modelo_nuevo = $_POST['modelo_nuevo'];
        $plazas_nuevo = $_POST['plazas_nuevo'];
        $tipotela_nuevo = $_POST['tipotela_nuevo'];
        $color_nuevo = $_POST['color_nuevo'];
        $alturabase_nuevo = $_POST['alturabase_nuevo'];  
        $direccion_nuevo = $_POST['direccion_nuevo'];
        $numero_nuevo = $_POST['numero_nuevo'];  
        $dpto_nuevo = $_POST['dpto_nuevo'];  
        $telefono_nuevo = $_POST['telefono_nuevo'];     
        $region_nuevo = $_POST['region'];
        $comuna_nuevo = $_POST['comuna_nuevo'];
        $comentarios_nuevo = $_POST['comentarios_nuevo'];
        $precio_nuevo = $_POST['precio'];
        $abono = $_POST['abono'];
        $precio_porpagar = $_POST['por_pagar'];
        $total_porpagar = $precio_nuevo+$precio_porpagar;
        $mododepago_nuevo = $_POST['mododepago'];
        $metodo_entrega = $_POST['metodo_entrega'];
        $detalle_entrega = $_POST['detalle_entrega'];
        $atencion = $_POST['atencion'];
        



         
         
        $boton_nuevo = $_POST['boton_nuevo'];
        $anclaje_nuevo = $_POST['anclaje_nuevo'];
        setlocale(LC_ALL,"es_ES");
        $fecha_ingreso =  date("j/n/Y"); 
        $fecha_entrega = $_POST['fecha_entrega'];
        $instagram = $_POST['instagram'];
        $pagado = $_POST['pagado'];
        $correo = ucfirst($_POST['email']);
         $detalles_fabricacion = ucfirst($_POST['detalles_fabricacion']);



        //SI EL FORMULARIO ES PARA AGREGAR PATAS
  if (isset($_POST['tipo_formulario']) && $_POST['tipo_formulario'] == "patas") {
  $cantidad = $_POST['cantidad'];
  $modelo = "Patas de cama";
  $tipotela = ucfirst($_POST['modelo']);
} else {
  $cantidad = 1;
}
        // SELECT A CLIENTES PARA SOLICITAR LOS DATOS DEL CLIENTE E INGRESARLOS EN LA NUEVA ORDEN
        //GENERAR UN NUEVO NUMERO DE ORDEN .
        //INGRESAR UNA NUEVA ORDEN
        //ASIGNAR ESTADO 100 A ORDEN ANTERIOR
        //ASIGNAR ESTADO 100 A PEDIDO ANTERIOR
        //ASIGNAR RUTA X A PEDIDO ANTERIOR
        //AL PEDIDO ANTERIOR PONERLE PRECIO 0 Y SUMARLE EL PRECIO NUEVO Y TOTAL A PAGAR AL NUEVO PEDIDO


        $conn=mysqli_connect('localhost','cre61650_respaldos21','respaldos21/','cre61650_agenda');
        $BD_SERVIDOR = "localhost";
        $BD_USUARIO ="cre61650_respaldos21";
        $BD_PASSWORD = "respaldos21/";
        $BD_NOMBRE = "cre61650_agenda";
        $mysqli = new mysqli($BD_SERVIDOR, $BD_USUARIO, $BD_PASSWORD, $BD_NOMBRE);
        $conn->set_charset("utf8");
        // TERMINO DE CONEXION


        //GENERAR UN NUEVO NUMERO DE ORDEN .
        $rs = $mysqli->query("SELECT MAX(num_orden) AS num_orden FROM pedido"); // BUSCA EL ULTIMO REGISTRO

        $row = mysqli_fetch_row($rs); 
        $ultimoregistroorden = trim($row[0]);
        $nuevoregistroorden = $ultimoregistroorden+1;

        




        
    if (!$conn->query("INSERT INTO pedido_detalle(num_orden,direccion,numero, dpto, region, comuna, modelo,tamano,alturabase,tipotela, color,precio,abono,tipo_boton,anclaje, comentarios,detalles_fabricacion,fecha_ingreso,pagado,formadepago,metodo_entrega,detalle_entrega,vendedor,estadopedido,ruta_asignada,orden_ruta,confirma,tapicero_id,cod_ped_anterior,atencion,cantidad) VALUES ('$num_orden','$direccion_nuevo','$numero_nuevo','$dpto_nuevo', '$region_nuevo', '$comuna_nuevo', '$modelo_nuevo','$plazas_nuevo','$alturabase_nuevo','$tipotela_nuevo','$color_nuevo','$total_porpagar','$abono','$boton_nuevo','$anclaje_nuevo','$comentarios_nuevo','$detalles_fabricacion','$fecha_ingreso','$pagado','0','$metodo_entrega','$detalle_entrega','$usuario_activo','1','','','','',$cod_pedidoanterior,'$atencion','$cantidad')")){
    echo "Falló el ingreso de datos pedido detalle: (" . $conn->error . ") " . $conn->error;
}
        else{
            $lastid = mysqli_insert_id($conn);
        

            

echo "<div style='margin:0 auto; text-align:center;'>
            Pedido Cambiado con exito<br>
            <b>Se han generado nuevos codigos</b><br>
            Numero de Pedido: ".$lastid."<br>
            Numero de Orden: ".$nuevoregistroorden."<br>
            <img width='30%' src='img/okimg.png'><br> ";       
        

              }


  $obs = "Cambio por codigo ".$cod_pedidoanterior;
        $consulta = "INSERT INTO pedido_etapas (idPedido, idProceso, fecha,usuario,observacion) VALUES('$lastid', '20', now(),'$usuario_activo','$obs') ";     
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

 $obs = "Cambio por codigo ".$lastid;
             $consulta = "INSERT INTO pedido_etapas (idPedido, idProceso, fecha,usuario,observacion) VALUES('$cod_pedidoanterior', '20', now(),'$usuario_activo','$obs') ";     
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 


$sql = "UPDATE pedido_detalle set estadopedido ='20' where id ='$cod_pedidoanterior'";
            if (mysqli_query($conn, $sql)) {
              echo "Pedido Anterior eliminado";
            } else {
              echo "Error eliminando el pedido anterior. por favor informar: " . mysqli_error($conn);
            }

            echo "</div>";



?>

</div>
</div>





<!--FIN del cont principal-->
<?php require_once "vistas/parte_inferior.php"?>