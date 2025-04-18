<?php require_once "init.php" ?>
<?php require_once "vistas/parte_superior.php"?>

<!--INICIO del cont principal-->
<div class="container">
    <h1>Stock Modelo <?php echo $_GET['modelo']; ?></h1>
</div>

<div style=" width: 80%; margin:0 auto;">
<table id="example" class="table table-striped table-bordered" ">
  <thead>
    <tr>
      <th scope="col" style="width:4rem;">#</th>
      <th scope="col">Modelo</th>
       <th scope="col">Tela</th>
      <th scope="col">Color</th>
      <th scope="col">Cantidad</th>
        <th scope="col">Acciones</th>
    </tr>
  </thead>
  <tbody>
    <tr>

    	<?php
    	include_once 'bd/conexion.php';
    	$modelo = $_GET['modelo'];
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$consulta = "SELECT * FROM colores";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$datts=$resultado->fetchAll(PDO::FETCH_ASSOC);

foreach($datts as $dater) {

$color = $dater['color']; ?>


<th scope="row"><?php echo $dater['id']; ?></th>
      <td><?php echo $modelo; ?></td>
      <td><?php  ?></td>
      <td><?php echo $dater['color']; ?></td>
      <td><?php  ?></td>
        <td><a href="" class="btn btn-success">Agregar</a></td>
     
    </tr>
   
 <?php 
    	$consulta = "SELECT * FROM stock_telas where modelo = '$modelo' and color = '$color'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$datt=$resultado->fetchAll(PDO::FETCH_ASSOC);




      

     } ?>
  </tbody>
</table>
<!--FIN del cont principal-->
<script type="text/javascript">$(document).ready(function() {
    $('#example').DataTable();
} );</script>
<?php


  


 

?>
</div>
<?php require_once "vistas/parte_inferior.php"?>