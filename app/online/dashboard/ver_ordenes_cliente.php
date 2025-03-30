<?php require_once "vistas/parte_superior.php"?>

<!--INICIO del cont principal-->
<div class="container">
    <h1>Ordenes de entrega por cliente Respaldos Chile</h1>
</div>

<?php  $rut = $_GET['rut']; 
$BD_SERVIDOR = "localhost";
$BD_USUARIO ="cre61650_respaldos21";
$BD_PASSWORD = "respaldos21/";
$BD_NOMBRE = "cre61650_agenda";

$mysqli = new mysqli($BD_SERVIDOR, $BD_USUARIO, $BD_PASSWORD, $BD_NOMBRE);





$mysqli -> set_charset("utf8");

  




$resultados = $mysqli->query("SELECT  *,count(pd.id) as cantidad_prod FROM pedido p INNER JOIN pedido_detalle pd ON p.num_orden = pd.num_orden WHERE rut_cliente = '$rut' group by p.num_orden");
?>
<div style="margin:0 auto; text-align: center;">
<div style="background: white; border:solid thin; border-radius: 15px; border-color: #D1D1D1; width:700px; height: 100%; display: inline-block; margin-top: 50px; padding: 5px;">

<table id="tablatapiceross" class="table table-striped table-bordered table-condensed" style="width:100%; font-size:0.8rem; padding: 5px; ">
                        <thead class="text-center">
                            <tr><th style="width:2rem;">Id</th>
                                <th style="width:5rem;">Rut</th>
                                <th style="width:15rem;">Direccion</th>                                
                                <th style="width:15rem;">Fecha de Entrega</th>  
                                <th style="width:5rem;">Cantidad de Productos</th>
                                
                                <th>Agregar un producto</th>
                                 
                            </tr>
                        </thead>
                         <tr>



                               
                                
                               
                                <?php
    while($dat = mysqli_fetch_array($resultados))
    {
$ruta_asignada = $dat['ruta_asignada'];
$cantidad_prod = $dat['cantidad_prod'];
?>

 <td style="height:10px; padding: 1px; "><?php echo $numero_orden = $dat['num_orden']; ?></td>
  <td style="height:10px; padding: 1px; "><?php echo $dat['rut_cliente']; ?></td>


  <?php 



$rs = $mysqli->query("SELECT * FROM rutas WHERE id = '$ruta_asignada'");

if ($rs) {
  if ($rs->num_rows > 0) {
    while ($row = mysqli_fetch_array($rs)) {
      $fecha = $row['fecha'];
    }
    
    if ($fecha != "") {
      setlocale(LC_TIME, 'es_CO.UTF-8');
      $fecha = strftime("%A, %d de %B de %Y", strtotime($fecha));
    } else {
      $fecha = "Por asignar";
    }
  } else {
    $fecha = "Por asignar";
  }
} else {
  $fecha = "Por asignar";
}

?>
 <td style="height:10px; padding: 1px; "><?php echo $dat['direccion']." ".$dat['numero']." ".$dat['comuna']; ?></td>
 <td style="height:10px; padding: 1px; "><?php echo $fecha; ?></td>
<td style="height:10px; padding: 1px; "><?php  echo $cantidad_prod; ?></td>
<td style="height:10px; padding: 1px; "><a title="Ver Ordenes" href="agregarpedido.php?num_orden=<?php echo $numero_orden; ?>" ><img src='img/add.png' width='40' alt='Ver Ordenes' /></a></td>
</tr>

<?php
    }




  ?>



                            
                                        
</table> 
</div>
</div>

                            	
<!--FIN del cont principal-->

<?php require_once "vistas/parte_inferior.php"?>