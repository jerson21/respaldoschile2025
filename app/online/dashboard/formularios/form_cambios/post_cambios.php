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

.btn {
    background: linear-gradient(to left, #99ccff 0%, #003399 100%);
    color: black;
    padding: 12px;
    margin: 10px 0;
    border: none;
    width: 100%;
    border-radius: 3px;
    cursor: pointer;
    font-size: 20px;
}

.btn:hover {
    background: linear-gradient(to left, #003399 0%, #99ccff 100%);
}

a {
    color: #2196F3;
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

    <h1>Cambio de Producto</h1>
    
    
    
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
$consulta2 = "SELECT * FROM pedidos where id = $id";

$resultado2 = $conexion->prepare($consulta2);
$resultado2->execute();
$data2 = $resultado2->fetchAll(PDO::FETCH_ASSOC);

foreach($data2 as $dat){
    
   $rut_cliente = $dat['rut_cliente'];
   $num_orden = $dat['num_orden'];
   $modelo = $dat['modelo'];
   $plazas = $dat['plazas'];
   $alturabase = $dat['alturabase'];
   $tipo_tela = $dat['tipotela'];
   $color = $dat['color'];
   $precio = $dat['precio'];
}


$consulta3 = "SELECT * FROM clientes where rut = '$rut_cliente'";

$resultado3 = $conexion->prepare($consulta3);
$resultado3->execute();
$data3 = $resultado3->fetchAll(PDO::FETCH_ASSOC);

foreach($data3 as $dat){
    
   $nombre = $dat['nombre'];
   $telefono = $dat['telefono'];
   $direccion = $dat['direccion'];
   $numero = $dat['numero']; // numero direccion
   $telefono = $dat['telefono'];
   $correo = $dat['correo'];
    $comuna = $dat['comuna'];
     $instagram = $dat['instagram'];
}




?>



<div class="container" >
<h2>Pedido Actual</h2>
<p>Aca debes ingresar el nuevo pedido.</p>
<div class="row">
    <div class="col-75">
        <div class="container">
            <?php
echo $nombre = $_POST['nombre'];

echo $modelo = $_POST['modelo'];

?>

    </div>
</div>
</div>

</div>

<!--FIN del cont principal-->
<?php require_once "vistas/parte_inferior.php"?>