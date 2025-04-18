<?php require_once "init.php" ?>
<?php require_once "vistas/parte_superior.php"?>

<!--INICIO del cont principal-->
<div class="container">
    <h1>Ingreso de stock Telas Respaldos Chile</h1>
</div>

<div style=" width: 80%; margin:0 auto;">
<table id="example" class="table table-striped table-bordered" ">
  <thead>
    <tr>
      <th scope="col" style="width:4rem;">#</th>
      <th scope="col">Modelo</th>
      
      
        <th scope="col">Acciones</th>
    </tr>
  </thead>
  <tbody>
    <tr>

    	<?php
    	include_once 'bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

    	$consulta = "SELECT * FROM stock_telas group by modelo";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$datt=$resultado->fetchAll(PDO::FETCH_ASSOC);

foreach($datt as $dat) { 

 ?>
      <th scope="row"><?php echo $dat['id']; ?></th>
      <td><?php echo $dat['modelo']; ?></td>
        <td><a href="stock_a.php?modelo=<?php echo $dat['modelo']; ?>" class="btn btn-primary">Ver Stock</a></td>
     
    </tr>
   

   <?php } ?>
  </tbody>
</table>
<!--FIN del cont principal-->
<script type="text/javascript">$(document).ready(function() {
    $('#example').DataTable();
} );</script>

</div>
<?php require_once "vistas/parte_inferior.php"?>