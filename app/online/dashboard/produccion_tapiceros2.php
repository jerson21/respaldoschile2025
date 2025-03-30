<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>RespaldosChile - Dashboard</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/rowgroup/1.1.3/js/dataTables.rowGroup.min.js"></script>
<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">


  

<script type="text/javascript">
  function actualizar(){location.reload(true);}
//Función para actualizar cada 4 segundos(4000 milisegundos)
  setInterval("actualizar()",20000);
</script>

<!--INICIO del cont principal-->
<div class="container">
    <h1>Producción Tapiceros - Respaldos Chile</h1>
</div>
<div style="margin:0 auto; text-align: center;">
<div style="background: white; border:solid thin; border-radius: 15px; margin:15px; border-color: #D1D1D1; width:500px; float: left; padding: 5px;">
	<h1>Jaime</h1>


<table id="tablatapiceross" class="table table-striped table-bordered table-condensed" style="width:100%; font-size:0.8rem; padding: 5px; ">
                        <thead class="text-center">
                            <tr>
<?php

$BD_SERVIDOR = "localhost";
$BD_USUARIO ="cre61650_respaldos21";
$BD_PASSWORD = "respaldos21/";
$BD_NOMBRE = "cre61650_agenda";

$mysqli = new mysqli($BD_SERVIDOR, $BD_USUARIO, $BD_PASSWORD, $BD_NOMBRE);





$mysqli -> set_charset("utf8");


?>

                                 <?php 

   
        echo "<div class='alert alert-success' role='alert' style='margin:0 auto; text-align:center;'>Pedidos en Fabricación</div>"; ?>
    
                                <th style="width:2rem;">Id</th>
                                
                                <th style="width:7rem;">Modelo</th>                                
                                <th style="width:4rem;">Plazas</th>  
                                <th style="width:2rem;">Alt</th>
                                <th style="width:4rem;">Tela</th>
                                <th style="width:7rem;">Color</th>
                                <th style="width:2rem;"></th>
                                 
                            </tr>
                        </thead>

                        <?php
   

    $resultados = $mysqli->query("SELECT * FROM pedidos where tapicero_id = 1 and (estadopedido =2 or to_days(fecha_fabricacion) = to_days(now())) ORDER BY estadopedido desc,color asc");

    while($dat = mysqli_fetch_array($resultados))
    {
        
    $contadorjaime = $contadorjaime+1;




?>


                    
                        
                                             
                                        
                            
                            <tr>



                               
                                
                                <td style="height:10px; padding: 1px; "><?php echo $dat['id']; ?></td>
                                


                                
                                
                                <td style="height:10px; line-height: 15px;  "><?php echo $dat['modelo']; ?></td>
                                <td style="height:10px;  line-height: 15px;  font-weight: bold; font-size: 15px;" ><?php echo $dat['plazas']; ?></td> 
                                <?php if($dat['alturabase'] != 60){ ?>
                                 <td style="height:10px;  line-height: 15px;  font-weight: bold; font-size: 17px; color:red;" ><?php echo $dat['alturabase']; ?></td>
                                <?php } else{ ?>
                                     <td style="height:10px;  line-height: 15px;  font-weight: bold; font-size: 17px; " ><?php echo $dat['alturabase']; ?></td>
                                <?php } ?>
                                <td style="height:10px;  line-height: 15px; "><?php echo strtoupper($dat['tipotela']); ?></td>
                                <td style="height:10px;  line-height: 15px;  font-weight: bold; font-size: 17px;" ><?php echo strtoupper($dat['color']); ?></td>
                              



                           
                                
                            </td>   
                            <style type="text/css">
                                
                                
                                .btn-circle.btn-sm {
                                    width: 40px;
                                    height: 40px;
                                    padding: 6px 0px;
                                    border-radius: 20px;
                                    font-size: 8px;
                                    text-align: center;
                                }
                                
                            </style>
                                
                                <td style="height:10px; padding: 1px; text-align: center;">
                                	<?php if($dat['fecha_fabricacion'] != ''){ ?>

                                		<button type="button" class="btn btn-success btn-circle btn-sm btnpedidolistojaime"></button>

                                	<?php } else { ?>
                                	<button type="button" class="btn btn-warning btn-circle btn-sm btnpedidolistojaime"></button>
                                <?php } ?>
                                 
                                </td>
                                 

                              
                            </tr>
                           <?php 

     } 
                            ?>                                
                        </tbody>        
                       </table> 
                       <?php echo $contadorjaime; ?>
</div>
	<div style="background: white; border:solid thin; border-radius: 15px; border-color: #D1D1D1; width:500px; height:100%; float: left; margin:15px; padding: 5px; ">
		<h1>Felipe</h1>

<table id="tablatapiceross" class="table table-striped table-bordered table-condensed" style="width:100%; font-size:0.8rem; padding: 5px; ">
                        <thead class="text-center">
                            <tr>
<?php

$BD_SERVIDOR = "localhost";
$BD_USUARIO ="cre61650_respaldos21";
$BD_PASSWORD = "respaldos21/";
$BD_NOMBRE = "cre61650_agenda";

$mysqli = new mysqli($BD_SERVIDOR, $BD_USUARIO, $BD_PASSWORD, $BD_NOMBRE);





$mysqli -> set_charset("utf8");


?>

                                 <?php 

   
        echo "<div class='alert alert-success' role='alert' style='margin:0 auto; text-align:center;'>Pedidos en Fabricación</div>"; ?>
    
                                <th style="width:2rem;">Id</th>
                              
                               <th style="width:7rem;">Modelo</th>                                
                                <th style="width:4rem;">Plazas</th>  
                                <th style="width:2rem;">Alt</th>
                                <th style="width:4rem;">Tela</th>
                                <th style="width:7rem;">Color</th>
                                <th style="width:2rem;"></th>
                                 
                            </tr>
                        </thead>

                        <?php
   

    $resultados = $mysqli->query("SELECT * FROM pedidos where tapicero_id = 2 and (estadopedido =2 or to_days(fecha_fabricacion) = to_days(now())) ORDER BY estadopedido desc,color asc");

    while($dat = mysqli_fetch_array($resultados))
    {
         $contadorfelipe = $contadorfelipe+1;
    




?>


                    
                        
                                             
                                        
                            
                            <tr>



                               
                                
                                <td style="height:10px; padding: 1px; "><?php echo $dat['id'] ?></td>
                                


                                
                                
                      <td style="height:10px; line-height: 15px;  "><?php echo $dat['modelo']; ?></td>
                                <td style="height:10px;  line-height: 15px;  font-weight: bold; font-size: 15px;" ><?php echo $dat['plazas']; ?></td> 
                                <?php if($dat['alturabase'] != 60){ ?>
                                 <td style="height:10px;  line-height: 15px;  font-weight: bold; font-size: 17px; color:red;" ><?php echo $dat['alturabase']; ?></td>
                                <?php } else{ ?>
                                     <td style="height:10px;  line-height: 15px;  font-weight: bold; font-size: 17px; " ><?php echo $dat['alturabase']; ?></td>
                                <?php } ?>
                                <td style="height:10px;  line-height: 15px; "><?php echo strtoupper($dat['tipotela']); ?></td>
                                <td style="height:10px;  line-height: 15px;  font-weight: bold; font-size: 17px;" ><?php echo strtoupper($dat['color']); ?></td>


                           
                                
                            </td>   
                            <style type="text/css">
                                
                                
                                .btn-circle.btn-sm {
                                    width: 40px;
                                    height: 40px;
                                    padding: 6px 0px;
                                    border-radius: 20px;
                                    font-size: 8px;
                                    text-align: center;
                                }
                                
                            </style>
                                
                                <td style="height:10px; padding: 1px; text-align: center;">
                                	<?php if($dat['fecha_fabricacion'] != ''){ ?>

                                		<button type="button" class="btn btn-success btn-circle btn-sm btnpedidolistofelipe"></button>

                                	<?php } else { ?>
                                	<button type="button" class="btn btn-warning btn-circle btn-sm btnpedidolistofelipe"></button>
                                <?php } ?>



                                 

                              
                            </tr>
                           <?php 

     } 
                            ?>                                
                        </tbody>        
                       </table> 
 <?php echo $contadorfelipe; ?>
	</div>
<div style="background: white; border:solid thin; border-radius: 15px; border-color: #D1D1D1; width:500px; height:100%; float: left;  margin:15px; padding: 5px; ">
        <h1>Tapicero 3</h1>

<table id="tablatapiceross" class="table table-striped table-bordered table-condensed" style="width:100%; font-size:0.8rem; padding: 5px; ">
                        <thead class="text-center">
                            <tr>
<?php

$BD_SERVIDOR = "localhost";
$BD_USUARIO ="cre61650_respaldos21";
$BD_PASSWORD = "respaldos21/";
$BD_NOMBRE = "cre61650_agenda";

$mysqli = new mysqli($BD_SERVIDOR, $BD_USUARIO, $BD_PASSWORD, $BD_NOMBRE);





$mysqli -> set_charset("utf8");


?>

                                 <?php 

   
        echo "<div class='alert alert-success' role='alert' style='margin:0 auto; text-align:center;'>Pedidos en Fabricación</div>"; ?>
    
                                <th style="width:2rem;">Id</th>
                              
                               <th style="width:7rem;">Modelo</th>                                
                                <th style="width:4rem;">Plazas</th>  
                                <th style="width:2rem;">Alt</th>
                                <th style="width:4rem;">Tela</th>
                                <th style="width:7rem;">Color</th>
                                <th style="width:2rem;"></th>
                                 
                            </tr>
                        </thead>

                        <?php
   

    $resultados = $mysqli->query("SELECT * FROM pedidos where tapicero_id = 3 and (estadopedido =2 or to_days(fecha_fabricacion) = to_days(now())) ORDER BY estadopedido desc,color asc");

    while($dat = mysqli_fetch_array($resultados))
    {
         $contador3 = $contador3+1;
    




?>


                    
                        
                                             
                                        
                            
                            <tr>



                               
                                
                                <td style="height:10px; padding: 1px; "><?php echo $dat['id'] ?></td>
                                


                                
                                
                      <td style="height:10px; line-height: 15px;  "><?php echo $dat['modelo']; ?></td>
                                <td style="height:10px;  line-height: 15px;  font-weight: bold; font-size: 15px;" ><?php echo $dat['plazas']; ?></td> 
                                <?php if($dat['alturabase'] != 60){ ?>
                                 <td style="height:10px;  line-height: 15px;  font-weight: bold; font-size: 17px; color:red;" ><?php echo $dat['alturabase']; ?></td>
                                <?php } else{ ?>
                                     <td style="height:10px;  line-height: 15px;  font-weight: bold; font-size: 17px; " ><?php echo $dat['alturabase']; ?></td>
                                <?php } ?>
                                <td style="height:10px;  line-height: 15px; "><?php echo strtoupper($dat['tipotela']); ?></td>
                                <td style="height:10px;  line-height: 15px;  font-weight: bold; font-size: 17px;" ><?php echo strtoupper($dat['color']); ?></td>


                           
                                
                            </td>   
                            <style type="text/css">
                                
                                
                                .btn-circle.btn-sm {
                                    width: 40px;
                                    height: 40px;
                                    padding: 6px 0px;
                                    border-radius: 20px;
                                    font-size: 8px;
                                    text-align: center;
                                }
                                
                            </style>
                                
                                <td style="height:10px; padding: 1px; text-align: center;">
                                    <?php if($dat['fecha_fabricacion'] != ''){ ?>

                                        <button type="button" class="btn btn-success btn-circle btn-sm btnpedidolisto3"></button>

                                    <?php } else { ?>
                                    <button type="button" class="btn btn-warning btn-circle btn-sm btnpedidolisto3"></button>
                                <?php } ?>



                                 

                              
                            </tr>
                           <?php 

     } 
                            ?>                                
                        </tbody>        
                       </table> 
 <?php echo $contador3; ?>
    </div>

</div>
</div>
<div style=" clear: left;" >

<?php 


date_default_timezone_set('America/Santiago');



 echo $DateAndTime = date('m-d-Y h:i:s a', time());  ?>
<!--FIN del cont principal-->
</div>
<?php require_once "vistas/parte_inferior.php"?>