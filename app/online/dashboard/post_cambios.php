<?php require_once "init.php" ?>
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
include_once 'bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$consulta = "SELECT * FROM gan";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data=$resultado->fetchAll(PDO::FETCH_ASSOC);

if(isset($_POST['id_anterior']))
{
    $id = $_POST['id_anterior'];
}
$consulta2 = "SELECT * FROM pedido_detalle pd INNER JOIN pedido p ON p.num_orden = pd.num_orden INNER JOIN clientes c ON p.rut_cliente = c.rut  where pd.id = $id";

$resultado2 = $conexion->prepare($consulta2);
$resultado2->execute();
$data2 = $resultado2->fetchAll(PDO::FETCH_ASSOC);

foreach($data2 as $dat){
       $num_orden = $dat['num_orden'];
   $rut_cliente = $dat['rut_cliente'];
   $nombre = $dat['nombre'];
   $telefono = $dat['telefono'];
   $direccion = $dat['direccion'];
   $numero = $dat['numero']; // numero direccion
   $telefono = $dat['telefono'];
   $correo = $dat['correo'];
    $comuna = $dat['comuna'];
     $instagram = $dat['instagram'];
   $num_orden = $dat['num_orden'];
   $modelo = $dat['modelo'];
   $plazas = $dat['tamano'];
   $alturabase = $dat['alturabase'];
   $tipo_tela = $dat['tipotela'];
   $color = $dat['color'];
   $precio = $dat['precio'];
   $modopago = $dat['formadepago'];
   $anclaje = $dat['anclaje'];
   $tipo_boton = $dat['tipo_boton'];

}






?>

<div class="container" >


<div class="row">
    <div class="col-75">

        <div class="container" style="background-color:white;">
           <div class="form-row">
    <div class="col-3">
   Rut:
            <input type="text"  class="form-control" value="<?php echo $rut_cliente;?>" readonly>
    </div>
    <div class="col-3">
      Nombre:
            <input type="text"  class="form-control" value="<?php echo $nombre;?>" readonly>
    </div>

</div>


<div class="container" >
<h2>Solicitud de cambio</h2>
<p>Revisa la informacion del cambio de producto.</p>
<div class="row">
    <div class="col-75">

  <div class="container" style="background-color:#E2E2E2;">
     <h1>Pedido Anterior</h1>
           <div class="form-row">
            
    
    <div class="col-3">
   Modelo:
            <input type="text" name=""  class="form-control" value="<?php echo $modelo; ?>" readonly>
    </div>
    <div class="col-1">
      Tamano:
            <input type="text" name="" class="form-control" value="<?php echo $plazas; ?>"readonly>
    </div>
      <div class="col-1">
      Alt B:
            <input type="text" name=""  class="form-control" value="<?php echo $alturabase; ?>"readonly>
    </div>
    <div class="col-1">
      Tela:
            <input type="text" name=""  class="form-control" value="<?php echo $tipo_tela; ?>"readonly>
    </div>
    <div class="col-2">
      Color:
            <input type="text" name="" class="form-control" value="<?php echo $color; ?>"readonly>
    </div>
    <div class="col-2">
      Modo Pago:
            <input type="text" name=""  class="form-control" value="<?php echo $modopago; ?>"readonly>
    </div>
    <div class="col-1">
      Anclaje:
            <input type="text" name="" class="form-control" value="<?php echo $anclaje; ?>" readonly>
    </div>
    <div class="col-1">
      Tipo Boton:
            <input type="text" name="" class="form-control" value="<?php echo $tipo_boton; ?>"readonly>



    </div>
    </div>
  </div>





            <br>

<form method="post" action="post_cambios_recibir.php">
<div class="container" style="background-color:#DAF7A6;">
     <h1>Nuevo Pedido</h1>
           <div class="form-row">
            
        <input type="hidden" id="num_orden" name="num_orden" value="<?php echo $num_orden; ?>">
   <div class="col-3">
   Modelo:
   <input type="text" name="modelo_nuevo" class="form-control" value="<?php echo isset($_POST['modelo_nuevo']) ? $_POST['modelo_nuevo'] : ''; ?>">
</div>
<div class="col-1">
   Plazas:
   <input type="text" name="plazas_nuevo" class="form-control" value="<?php echo isset($_POST['plazas_nuevo']) ? $_POST['plazas_nuevo'] : ''; ?>">
</div>
<div class="col-1">
   Alt B:
   <input type="text" name="alturabase_nuevo" class="form-control" value="<?php echo isset($_POST['alturabase_nuevo']) ? $_POST['alturabase_nuevo'] : ''; ?>">
</div>
<div class="col-1">
   Tela:
   <input type="text" name="tipotela_nuevo" class="form-control" value="<?php echo isset($_POST['listatelas']) ? $_POST['listatelas'] : ''; ?>">
</div>
<div class="col-2">
   Color:
   <input type="text" name="color_nuevo" class="form-control" value="<?php echo isset($_POST['lista2']) ? $_POST['lista2'] : ''; ?>">
</div>
<div class="col-2">
   Modo Pago:
   <input type="text" name="mododepago_nuevo" class="form-control" value="<?php echo isset($_POST['mododepago']) ? $_POST['mododepago'] : ''; ?>">
</div>
<div class="col-1">
   Anclaje:
   <input type="text" name="anclaje_nuevo" class="form-control" value="<?php echo isset($_POST['anclaje']) ? $_POST['anclaje'] : ''; ?>">
</div>
<div class="col-1">
   Tipo Boton:
   <input type="text" name="boton_nuevo" class="form-control" value="<?php echo isset($_POST['boton_nuevo']) ? $_POST['boton_nuevo'] : ''; ?>">
</div>



             <input type="hidden" name="cantidad" value="<?php echo isset($_POST['cantidad']) ? $_POST['cantidad'] : '';  ?>">
            <input type="hidden" name="rut_cliente" value="<?php echo $_POST['rut']; ?>">
            <input type="hidden" name="nombre" value="<?php echo $_POST['nombre']; ?>">
            <input type="hidden" name="email" value="<?php echo $_POST['email']; ?>">
            <input type="hidden" name="telefono_nuevo" value="<?php echo $_POST['telefono']; ?>">
            <input type="hidden" name="cod_pedidoanterior" value="<?php echo $_POST['cod_pedidoanterior']; ?>">
            <input type="hidden" name="direccion_nuevo" value="<?php echo $_POST['direccion']; ?>">  
            <input type="hidden" name="region" value="<?php echo $_POST['region']; ?>">               
            <input type="hidden" name="numero_nuevo" value="<?php echo $_POST['numero']; ?>">
            <input type="hidden" name="comuna_nuevo" value="<?php echo $_POST['comuna']; ?>">
            <input type="hidden" name="dpto_nuevo" value="<?php echo $_POST['dpto']; ?>">
            <input type="hidden" name="instagram" value="<?php echo $_POST['instagram']; ?>">
            <input type="hidden" name="por_pagar" value="<?php echo $_POST['por_pagar']; ?>">
            <input type="hidden" name="precio" value="<?php echo $_POST['precio']; ?>">
            <input type="hidden" name="pagado" value="<?php echo $_POST['pagado']; ?>">
            <input type="hidden" name="mododepago" value="<?php echo $_POST['mododepago']; ?>">
            <input type="hidden" name="comentarios_nuevo" value="<?php echo $_POST['comentarios_nuevo']; ?>">
             <input type="hidden" name="detalles_fabricacion" value="<?php echo $_POST['detalles_fabricacion']; ?>">
             <input type="hidden" name="abono" value="<?php echo $_POST['abono']; ?>">
            <input type="hidden" name="fecha_entrega" value="<?php echo $_POST['fecha_entrega']; ?>">
            <input type="hidden" name="cod_pedidoanterior" value="<?php echo $_POST['cod_pedidoanterior']; ?>">
            <input type="hidden" name="metodo_entrega" value="<?php echo $_POST['metodo_entrega']; ?>">
            <input type="hidden" name="detalle_entrega" value="<?php echo $_POST['detalle_entrega']; ?>">
            <input type="hidden" name="atencion" value="<?php echo $_POST['atencion']; ?>">


            
             

    </div>
    </div>
  </div>
  <div style="margin:0 auto; text-align:center; margin-top:10px;">
<input type="submit" name="submit" class="btn btn-primary" value="Confirmar e ingresar">
<input type="button" class="btn btn-secondary" onclick="history.back();" value="Volver atras">
</div>
  </form>


    </div>
</div>
</div>


<?php 
if(isset($_POST["submit"])){

    echo "hola";
}
?>


<!--FIN del cont principal-->
<?php require_once "vistas/parte_inferior.php"?>