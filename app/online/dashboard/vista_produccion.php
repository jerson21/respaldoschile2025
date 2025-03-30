<?php require_once "vistas/parte_superior.php"?>
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

                           

<script src="https://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript">
$(document).ready(function() {
var pageRefresh = 10000; //5 s
setInterval(function() {
refresh();
}, pageRefresh);
});


  function refresh() { $('#contenido1').load(location.href + " #contenido1"); }
</script>

<!--INICIO del cont principal-->
<div class="container">
    <h1>Producción Tapiceros - Respaldos Chile</h1>
    <div class="alert alert-info">
    <img width="15" src="img/patasmadera.jpg"> Patas de madera -
    <img width="15" src="img/anclaje.png"> Madera interior para anclaje -
    <b> B D </b> Boton Diamante
    </div>
</div>
<div id="contenido1" style="margin:0 auto; text-align: center;">
<div style="background: white; border:solid thin; border-radius: 15px; border-color: #D1D1D1; width:700px; height: 100%; display: inline-block; margin-top: 50px; padding: 5px;">
    <h1>Tapicero 1 </h1>


<table id="tablatapiceross" class="table table-striped table-bordered table-condensed" style="width:100%; font-size:0.8rem; padding: 5px; ">
                        <thead class="text-center">
                            <tr>
<?php
ini_set("default_charset", "UTF-8");
$contadorjaime = 0;
$contadorfelipe = 0;
$BD_SERVIDOR = "localhost";
$BD_USUARIO  = "cre61650_respaldos21";
$BD_PASSWORD = "respaldos21/";
$BD_NOMBRE   = "cre61650_agenda";

$mysqli = new mysqli($BD_SERVIDOR, $BD_USUARIO, $BD_PASSWORD, $BD_NOMBRE);

$mysqli->set_charset("utf8");

?>
<?php echo "<div class='alert alert-success' role='alert' style='margin:0 auto; text-align:center;'>Pedidos en Fabricación</div>"; ?>

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


$currentDate = date('d-m-Y h:i:s a', time());


$resultados = $mysqli->query("SELECT d.*
FROM pedido_detalle d
INNER JOIN pedido_etapas pd ON d.id = pd.idPedido 
WHERE d.tapicero_id = 1 
AND (
    d.estadopedido IN (2, 5) 
   or  (pd.fecha = CURDATE()) and pd.idproceso = 6)
GROUP BY d.id
ORDER BY d.estadopedido DESC, d.color ASC");





while ($dat = mysqli_fetch_array($resultados)) {
     $modeloa = ltrim($dat['modelo']);
     $color = ", ".$dat['color'];
     $plazas = $dat['tamano'];
     $base = ", Base ".$dat['alturabase'];
     $tipo_boton = $dat['tipo_boton'];
     $anclaje = $dat['anclaje'];
     $comentario = "";
     $cortada = "La tela aún no está lista. ";
        if($modeloa == 'Botone'){ $modeloa = "botoné Madrid, "; }
         if($modeloa == 'Botone 4 corridas de botones'){ $modeloa = "botoné 4 corridas de botones, "; }
         if($modeloa == 'Botone 3 corridas de botones'){ $modeloa = "botoné 3 corridas de botones, "; }

        if($modeloa == 'Capitone'){ $modeloa = "capitoné"; }
        if($color == 'CAFE'){ $color = ", café "; }
        
        if($plazas == "1"){ $plazas = "una plaza";}
        if($plazas == "1 1/2"){ $plazas = "una plaza y media";}
        if($plazas == "2"){ $plazas = "2 plazas";}
         if($plazas == "3"){ $plazas = "3 cuerpos"; $base ="";}
         if($plazas == "4"){ $plazas = "4 cuerpos"; $base ="";}
         if($plazas == "Seleccionar las plazas"){ $plazas = ".Consultar tamaño."; $base ="";}
         if($tipo_boton == "B D") {    $tipo_boton = ", Agregar botón Diamante";   }
         if ($anclaje == "si") {  $anclaje = ", Ocupar esqueleto con Madera de anclaje";   }
         if ($anclaje == "patas") { $anclaje = ", Ocupar esqueleto con Patas de madera";    }if($anclaje == "no"){ $anclaje = "";}
         if($dat['alturabase'] == "1.90mt"){ $base = " , Largo uno noventa";}
         if($dat['alturabase'] == "2Mt"){ $base = " , Largo dos metros";}
         if($dat['comentarios'] != "") { $comentario = ". Leer pantalla para ver detalles.";}
         
        $cortada = "";
           


         
         if($dat['modelo'] == "Liso con costuras"){$modeloa = "Liso Costuras Venecia, ";}
         if($dat['modelo'] == "Capitone Con Orejas y Tachas"){$modeloa = "Capitoné Tokio Con Orejas y Tachas, ";}
          if($dat['modelo'] == " Capitone Con Orejas"){$modeloa = "Capitoné Tokio Con Orejas, ";}

    


 $detalle = "Jaime, ".$cortada." Solicitar tela para: ".$modeloa.".  ".$plazas.", ".$dat['tipotela']." ".$color.$base.$tipo_boton."".$anclaje.$comentario; 




    $contadorjaime = $contadorjaime + 1;

    ?>


                            <?php if ($dat['anclaje'] == 'si' or $dat['anclaje'] == 'patas') {?>
                            <tr style="background-color: #FFE8A0; ">
                            <?php }
                              if ($cortada != '') {?>
                            <tr style="background-color: #FFD2D2; ">
                            <?php } else {?>
                                <tr>
                            <?php }?>




                                <td style="height:10px; padding: 1px; "><?php echo $dat['id']; ?></td>





                                      <?php
$tipo_boton = "";
if ($dat['tipo_boton'] == 'B D') {
    $tipo_boton = "Diamante";
?>

<td style="height:10px; line-height: 15px; color:red; font-weight: bold;">
    <?php echo $dat['modelo'] . " " . $tipo_boton; ?>
</td>
                                <?php
} else {
?>
                                    <td style="height:10px; line-height: 15px;">
    <?php
    echo $dat['modelo'] . " " . $tipo_boton;
    if ($dat['anclaje'] == 'si') {
    ?>
        <img width="15" src="img/anclaje.png">
    <?php
    }
    if ($dat['anclaje'] == 'patas') {
    ?>
        <img width="15" src="img/patasmadera.jpg">
    <?php
    }
    ?>
    <br>
    <span style="font-size: 10px; font-weight: bold; color:red;">
        <?php echo $dat['comentarios']; ?>
         <?php echo $dat['detalles_fabricacion']; ?>
  
        
    </span>
</td>

                              <?php
}
?>
<td style="height:10px; line-height: 15px; font-weight: bold; font-size: 15px;">
    <?php echo $dat['tamano'] . $dat['tipo_boton']; ?>
</td>
<?php
if ($dat['alturabase'] != 60) {
?>


                               <td style="height:10px; line-height: 15px; font-weight: bold; font-size: 17px; color:red;">
    <?php echo $dat['alturabase']; ?>
</td>

                                <?php } else
                                 {?>
                                     <td style="height:10px;  line-height: 15px;  font-weight: bold; font-size: 17px; " ><?php echo $dat['alturabase']; ?></td>
                                <?php }?>
                                 <?php if ($dat['tipotela'] == "lino") {?>
                                <td style="height:10px;  line-height: 15px; "><?php echo strtoupper($dat['tipotela']); ?></td>
                                <td style="height:10px;  line-height: 15px;  font-weight: bold; font-size: 17px;" ><?php echo strtoupper($dat['color']); ?></td>
                               <?php } else {?>
                                   <td style="height:10px;  line-height: 15px;font-size: 16px; "><b><u><?php echo strtoupper($dat['tipotela']); ?></u></b></td>
                                   <td style="height:10px;  line-height: 15px;  font-weight: bold; font-size: 17px;" ><u><?php echo strtoupper($dat['color']); ?></u></td>
                                <?php 

                              }?>








                            </td>
                          

                                <td style="height:10px; padding: 1px; text-align: center;">
                                   
     <?php
                                    $boton = "";

                                     if ($dat['estadopedido'] == "2") { // si el estado pedido esta en 2 osea enviado a fabricacion mostrar el 5 que es el color de "fabricando"

                                       $boton = ' <button type="button" class="btn btn-warning btn-circle btn-sm " data-value="'.$detalle.'"  data-estado="2"></button>';

                                     }   if($dat['estadopedido'] == "5") { 

                                        $boton = ' <button type="button" class="btn btn-info btn-circle btn-sm " data-value="'.$detalle.'" data-estado="5"></button>'; 

                                         }
                                    if($dat['estadopedido'] == "6") { $boton = ' <button type="button" class="btn btn-success btn-circle btn-sm " data-value="'.$detalle.'" data-estado="6" ></button>'; }


                                    echo $boton;

                                     ?>



                                </td>










                            </tr>
                           <?php } ?>
                        </tbody>
                       </table>


                       <?php echo "<b>Cantidad: " . $contadorjaime . "</b>"; ?>
</div>


    <div style="background: white; border:solid thin; border-radius: 15px; border-color: #D1D1D1; width:700px; height:100%; display:inline-block;  margin-top: 50px; padding: 5px; ">
        <h1>Felipe</h1>

<table id="tablatapiceross" class="table table-striped table-bordered table-condensed" style="width:100%; font-size:0.8rem; padding: 5px; ">
                        <thead class="text-center">
                            <tr>

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


/*SELECT d.id,d.estadopedido,d.modelo,d.tamano,d.tipotela,d.color,d.alturabase,d.tipo_boton,d.anclaje, etapas.eTapas
FROM pedido_detalle d
LEFT JOIN  (
    SELECT idPedido, GROUP_CONCAT(idProceso) AS eTapas
    FROM pedido_etapas
    WHERE idProceso != 1
    GROUP BY idPedido
) etapas ON d.id = etapas.idPedido
LEFT JOIN pedido_etapas pd ON d.id = pd.idPedido AND pd.idProceso = 6
WHERE d.tapicero_id = 2 
AND (
    d.estadopedido IN (2, 5) OR
    (d.estadopedido = 6 AND  STR_TO_DATE(pd.fecha, '%Y-%m-%d') = CURDATE())
)
GROUP BY d.id
ORDER BY d.estadopedido DESC, d.color ASC
*/


$resultados = $mysqli->query("SELECT d.*
FROM pedido_detalle d
INNER JOIN pedido_etapas pd ON d.id = pd.idPedido 
WHERE d.tapicero_id = 2 
AND (
    d.estadopedido IN (2, 5) 
   or  (pd.fecha = CURDATE()) and pd.idproceso = 6)
GROUP BY d.id
ORDER BY d.estadopedido DESC, d.color ASC");





while ($dat = mysqli_fetch_array($resultados)) {
     $modeloa = ltrim($dat['modelo']);
     $color = ", ".$dat['color'];
     $plazas = $dat['tamano'];
     $base = ", Base ".$dat['alturabase'];
     $tipo_boton = $dat['tipo_boton'];
     $anclaje = $dat['anclaje'];
     $comentario = "";
     $cortada = "La tela aún no está lista. ";
        if($modeloa == 'Botone'){ $modeloa = "botoné Madrid, "; }
         if($modeloa == 'Botone 4 corridas de botones'){ $modeloa = "botoné 4 corridas de botones, "; }
         if($modeloa == 'Botone 3 corridas de botones'){ $modeloa = "botoné 3 corridas de botones, "; }

        if($modeloa == 'Capitone'){ $modeloa = "capitoné"; }
        if($color == 'CAFE'){ $color = ", café "; }
        
        if($plazas == "1"){ $plazas = "una plaza";}
        if($plazas == "1 1/2"){ $plazas = "una plaza y media";}
        if($plazas == "2"){ $plazas = "2 plazas";}
         if($plazas == "3"){ $plazas = "3 cuerpos"; $base ="";}
         if($plazas == "4"){ $plazas = "4 cuerpos"; $base ="";}
         if($plazas == "Seleccionar las plazas"){ $plazas = ".Consultar tamaño."; $base ="";}
         if($tipo_boton == "B D") {    $tipo_boton = ", Agregar botón Diamante";   }
         if ($anclaje == "si") {  $anclaje = ", Ocupar esqueleto con Madera de anclaje";   }
         if ($anclaje == "patas") { $anclaje = ", Ocupar esqueleto con Patas de madera";    }if($anclaje == "no"){ $anclaje = "";}
         if($dat['alturabase'] == "1.90mt"){ $base = " , Largo uno noventa";}
         if($dat['alturabase'] == "2Mt"){ $base = " , Largo dos metros";}
         if($dat['comentarios'] != "") { $comentario = ". Leer pantalla para ver detalles.";}
         
       
        $cortada = "";
           

    


 $detalle = "Felipe, ".$cortada." Solicitar tela para: ".$modeloa.".  ".$plazas.", ".$dat['tipotela']." ".$color.$base.$tipo_boton."".$anclaje.$comentario; 

    $contadorfelipe = $contadorfelipe + 1;
    ?>


                            <?php if ($dat['anclaje'] == 'si' or $dat['anclaje'] == 'patas') {?>
                            <tr style="background-color: #FFE8A0; ">
                            <?php }
                              if ($cortada != '') {?>
                            <tr style="background-color: #FFD2D2; ">
                            <?php } else {?>
                                <tr>
                            <?php }?>




                                <td style="height:10px; padding: 1px; "><?php echo $dat['id']; ?></td>





                                      <?php
$tipo_boton = "";
if ($dat['tipo_boton'] == 'B D') {
    $tipo_boton = "Diamante";
?>

<td style="height:10px; line-height: 15px; color:red; font-weight: bold;">
    <?php echo $dat['modelo'] . " " . $tipo_boton; ?>
</td>
                                <?php
} else {
?>
                                    <td style="height:10px; line-height: 15px;">
    <?php
    echo $dat['modelo'] . " " . $tipo_boton;
    if ($dat['anclaje'] == 'si') {
    ?>
        <img width="15" src="img/anclaje.png">
    <?php
    }
    if ($dat['anclaje'] == 'patas') {
    ?>
        <img width="15" src="img/patasmadera.jpg">
    <?php
    }
    ?>
    <br>
    <span style="font-size: 10px; font-weight: bold; color:red;">
        <?php echo $dat['comentarios']; ?>
         <?php echo $dat['detalles_fabricacion']; ?>
  
        
    </span>
</td>

                              <?php
}
?>
<td style="height:10px; line-height: 15px; font-weight: bold; font-size: 15px;">
    <?php echo $dat['tamano'] . $dat['tipo_boton']; ?>
</td>
<?php
if ($dat['alturabase'] != 60) {
?>


                               <td style="height:10px; line-height: 15px; font-weight: bold; font-size: 17px; color:red;">
    <?php echo $dat['alturabase']; ?>
</td>

                                <?php } else
                                 {?>
                                     <td style="height:10px;  line-height: 15px;  font-weight: bold; font-size: 17px; " ><?php echo $dat['alturabase']; ?></td>
                                <?php }?>
                                 <?php if ($dat['tipotela'] == "lino") {?>
                                <td style="height:10px;  line-height: 15px; "><?php echo strtoupper($dat['tipotela']); ?></td>
                                <td style="height:10px;  line-height: 15px;  font-weight: bold; font-size: 17px;" ><?php echo strtoupper($dat['color']); ?></td>
                               <?php } else {?>
                                   <td style="height:10px;  line-height: 15px;font-size: 16px; "><b><u><?php echo strtoupper($dat['tipotela']); ?></u></b></td>
                                   <td style="height:10px;  line-height: 15px;  font-weight: bold; font-size: 17px;" ><u><?php echo strtoupper($dat['color']); ?></u></td>
                                <?php 

                              }?>








                            </td>
                          

                                <td style="height:10px; padding: 1px; text-align: center;">
                                   
     <?php
                                    $boton = "";

                                     if ($dat['estadopedido'] == "2") { // si el estado pedido esta en 2 osea enviado a fabricacion mostrar el 5 que es el color de "fabricando"

                                       $boton = ' <button type="button" class="btn btn-warning btn-circle btn-sm " data-value="'.$detalle.'"  data-estado="2"></button>';

                                     }   if($dat['estadopedido'] == "5") { 

                                        $boton = ' <button type="button" class="btn btn-info btn-circle btn-sm " data-value="'.$detalle.'" data-estado="5"></button>'; 

                                         }
                                    if($dat['estadopedido'] == "6") { $boton = ' <button type="button" class="btn btn-success btn-circle btn-sm " data-value="'.$detalle.'" data-estado="6" ></button>'; }


                                    echo $boton;

                                     ?>



                                </td>










                            </tr>
                           <?php } ?>
                        </tbody>
                       </table>
 <?php echo "<b>Cantidad: " . $contadorfelipe . "</b>"; ?>
    </div>

</div>

<?php

date_default_timezone_set('America/Santiago');

echo $DateAndTime = date('m-d-Y h:i:s a', time());?>
<!--FIN del cont principal-->


<?php require_once "vistas/parte_inferior.php"?>