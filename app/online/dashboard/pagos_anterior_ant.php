<?php require_once "vistas/parte_superior.php"?>

<!--INICIO del cont principal-->

<input type="button" onclick="printDiv('container')" value="imprimir div" /><br><br>

    <div class="row" style="margin:0 auto; text-align: center; ">
    <div class="col-1">
     <form method="get" action="">
    <input type="hidden" name="id" value="1">
       <input type="submit" class="btn btn-primary" value="Jaime">

   </form>
    </div>
    <div class="col-1">
    <form method="get" action="">
    <input type="hidden" name="id" value="2">
       <input type="submit" class="btn btn-primary" value="Felipe">

   </form>
</div>
       <div class="col-1">
 <form method="get" action="https://www.respaldoschile.cl/intranet/dashboard/pagos.php">
     <input type="hidden" name="id" value="<?php echo $_GET['id'];?>">
       <input type="submit" class="btn btn-success" value="SEMANA ACTUAL">

   </form>


   
    </div>
</div>
    
<?php 
$first = strtotime('last Sunday -12 days');
$last = strtotime('next sunday -14 days');
$lunespasado = date('Y-m-d', $first);

$domingo_pasado = date('Y-m-d', $last);




?>


<div class="container" id="container">
    <div><span style="font-size: 20px; font-weight: bold;">Planilla de pagos - Respaldos Chile</span> <?php echo "Semana del: ".$lunespasado ." al ".$domingo_pasado."<br><br>"; ?> </div>



<?php 



$id = $_GET['id'];        
$opcion = $_POST['opcion'];
$BD_SERVIDOR = "localhost";
$BD_USUARIO ="cre61650_respaldos21";
$BD_PASSWORD = "respaldos21/";
$BD_NOMBRE = "cre61650_agenda";





$mysqli = new mysqli($BD_SERVIDOR, $BD_USUARIO, $BD_PASSWORD, $BD_NOMBRE);

$mysqli -> set_charset("utf8");


$resultadoas = $mysqli->query("SELECT * FROM usuarios WHERE id='$id'");
	$rowss = mysqli_fetch_assoc($resultadoas);
$nombre_tapicero = $rowss['nombres']." ".$rowss['apaterno'];







 $resultadoa = $mysqli->query("SELECT * FROM pedido_detalle pd INNER JOIN pedido_etapas pe ON pd.id = pe.idPedido WHERE pd.tapicero_id =$id and pe.idProceso = 6 AND  pe.fecha BETWEEN '$lunespasado' and '$domingo_pasado' GROUP BY DATE(pe.fecha)");
    while($rows = mysqli_fetch_assoc($resultadoa)) {
$contador=0;
$fecha = $rows['fecha'];


setlocale(LC_TIME, 'es_CO.UTF-8');

echo $fechas =  "<b>".strtoupper(strftime("%A, %d de %B de %Y", strtotime($rows['fecha'])))."</b>";




$dias_trabajados+=1;


    $resultado = $mysqli->query("SELECT * FROM pedido_detalle pd INNER JOIN pedido_etapas pe ON pd.id = pe.idPedido WHERE pd.tapicero_id= $id AND pe.idProceso = 6 and DATE(pe.fecha) = DATE('$fecha') GROUP BY pd.id ORDER BY pd.tamano");
?>
    <div class="table-responsive" style="margin:0;  ">  
   


                        <table id="tablatapiceross" class="table table-striped table-bordered table-condensed" style=" font-size:0.8rem; ">
                        <thead class="text-center">
                            <tr>
                                <th style="width:1rem;">Nº</th>
                                <th style="width:1rem;">Id</th>
                                <th style="width:5rem;">Modelo</th>
                                                               
                                <th style="width:1rem;">Plazas</th>  
                                <th style="width:1rem;">Alt</th>
                                <th style="width:1rem;">Tela</th>
                                <th style="width:2rem;">Color</th>
                                <th style="width:2rem;">Fabricacion</th>
                                <th style="width:1rem;">Pago</th>
                          
                            </tr>
                        </thead>


<?php
    while($row = mysqli_fetch_assoc($resultado)) {

        $contador+=1;
        
            $modelo = $row['modelo'];
        $plazas = $row['tamano'];
        
        
        $resultado2 = $mysqli->query("SELECT * FROM pago_produccion pp INNER JOIN productos_venta pv ON pv.id = pp.producto_id WHERE pv.modelo = '$modelo' AND pp.tamano = '$plazas'");
        
        if ($resultado2) {
            if (mysqli_num_rows($resultado2) > 0) {
                while ($rowe = mysqli_fetch_assoc($resultado2)) {
                     
                    $pago = $rowe['valor_pago']; 
                    $total+= $rowe['valor_pago'];
        
                }
            } else {
                // No hay resultados, puedes mostrar un mensaje o realizar alguna otra acción
                $pago = 0;
                 $total+=0;
                
            }
        } 
        
        /*
        
        
        if($plazas == "1" || $plazas == "1 1/2"){
            if($modelo == "Botone"){    }
            if($modelo == "Liso"){ $pago = 4000; $total+=4000;  }
            if($modelo == "Liso 1.35"){ $pago = 5000; $total+=5000;  }
            if($modelo == "Liso con costuras"){ $pago = 4000; $total+=4000; }
            if($modelo == "Liso con costuras 1.35"){ $pago = 5000; $total+=5000; }
            if($modelo == "Liso con Orejas"){ $pago = 7000; $total+=7000; }  //revisar
            if($modelo == "Liso con Orejas y tachas"){ $pago = 8000; $total+=8000; } //revisar   
            if($modelo == "Capitone"){  $pago = 10000; $total+=10000;   }
            if($modelo == "Capitone orejas"){ $pago = 14000; $total+=14000; }
            if($modelo == "Capitone orejas y tachas"){ $pago = 16000; $total+=16000; }
            if($modelo == "Botone 3 corridas de botones"){  $pago = 5000; $total+=5000; }
            if($modelo == "Botone 4 corridas de botones"){  $pago = 7000; $total+=7000; }
            if($modelo == "Base de Cama"){  $pago = 4000; $total+=4000; }
        
            
        }
        
        if($modelo == "Banqueta Simple"){
        
        $pago = 5000; $total+=5000;
        
            }
        
            if($modelo == "Banqueta Baul"){
        
        if($plazas == "120 cm x 45cm"){  $pago = 9000; $total+=9000; }
        if($plazas == "Seleccionar las plazas"){  $pago = 9000; $total+=9000; }
        
            }
        
             if($modelo == "Pouf Completo"){
        
          $pago = 3000; $total+=3000; 
        
            }
        
            if($modelo == "Poltrona"){
        
          $pago = 9000; $total+=9000; 
        
            }
        
              if($modelo == "Sofa Br Curvo" || $modelo == "Sofa Br cuadrado" ){
        
        if($plazas == "2"){  $pago = 18000; $total+=18000; }
        
            }
        
        
             if($modelo == "Living L Cuerpos"){
        
        if($plazas == "4"){  $pago = 20000; $total+=20000; }
        
            }
         if($modelo == "Living 3 1+1"){
        
          $pago = 25000; $total+=25000; 
        
            }
            if($modelo == "Sofa Atenas"){
        
          $pago = 23000; $total+=23000; 
        
            }
        
             if($modelo == "Seccional Monaco Derecho"){
        
          $pago = 20000; $total+=20000; 
        
            }
        
        
        
        
        if($plazas == "2" || $plazas == "Full" || $plazas == "Queen"){
            if($modelo == "Botone"){ $pago = 5000;  $total+=5000;}
            if($modelo == "Liso"){ $pago = 5000; $total+=5000;  }
            if($modelo == "Liso 1.35"){ $pago = 6000; $total+=6000;  }
            if($modelo == "Liso con costuras"){ $pago = 5000; $total+=5000; }
            if($modelo == "Liso con costuras 1.35"){ $pago = 6000; $total+=6000; }
            if($modelo == "Liso con Orejas"){ $pago = 7000; $total+=7000; }
            if($modelo == "Liso con Orejas y tachas"){ $pago = 9000; $total+=9000; }
            if($modelo == "Capitone orejas"){ $pago = 22000; $total+=22000; }
            if($modelo == "Capitone orejas y tachas"){ $pago = 20000; $total+=20000; }
            if($modelo == "Capitone"){  $pago = 15000;  $total+=15000;}
            if($modelo == "Botone 3 corridas de botones"){  $pago = 6000; $total+=6000; }
            if($modelo == "Botone 4 corridas de botones"){  $pago = 9000; $total+=9000; }
            if($modelo == "Base de Cama"){  $pago = 6000; $total+=6000; }
        
        }
        
        if($plazas == "King" || $plazas == "Super King"){
            if($modelo == "Botone"){ $pago = 6000;  $total+=6000; }
            if($modelo == "Liso"){ $pago = 6000;    $total+=6000;   }
            if($modelo == "Liso 1.35"){ $pago = 7000; $total+=7000;  }
            if($modelo == "Liso con costuras"){ $pago = 6000;       $total+=6000;}
            if($modelo == "Liso con costuras 1.35"){ $pago = 7000; $total+=7000; }
             if($modelo == "Liso con Orejas"){ $pago = 8000; $total+=8000; }
            if($modelo == "Capitone"){  $pago = 18000;  $total+=18000;  }
             if($modelo == "Capitone orejas y tachas"){ $pago = 25000; $total+=25000; }
             if($modelo == "Capitone orejas"){ $pago = 22000; $total+=22000; }
            if($modelo == "Botone 3 corridas de botones"){  $pago = 7000;   $total+=7000;   }
            if($modelo == "Botone 4 corridas de botones"){  $pago = 10000;  $total+=10000;  }
            if($modelo == "Base de Cama"){  $pago = 7000; $total+=7000; }
        }
        
        
        if($plazas == "45"){
        
        if($modelo == "Poltrona"){  $pago = 9000; $total+=9000; }
             }
        
        */
             ?>
        
             
        <tr>
        
        
        
                                       
                                        
                                        <td style="height:10px; padding: 1px;border: 1px solid black; "><?php echo $contador ?></td>
                                        <td style="height:10px; padding: 1px;border: 1px solid black; "><?php echo $row['id'] ?></td>                       
                                        
                                        <td style="height:10px; padding: 1px;border: 1px solid black;"><?php echo "<b>".$row['modelo']."</b>" ?></td>
                                        <td style="height:10px; padding: 1px;border: 1px solid black;"><?php echo "<b>".$row['tamano']."</b>" ?></td> 
                                        <td style="height:10px; padding: 1px;border: 1px solid black;"><?php echo $row['alturabase'] ?></td>
                                        <td style="height:10px; padding: 1px;border: 1px solid black;"><?php echo $row['tipotela'] ?></td>
                                        <td style="height:10px; padding: 1px;border: 1px solid black;" ><?php echo $row['color'] ?></td>
                                        <td style="height:10px; padding: 1px;border: 1px solid black;"><?php echo $row['fecha'] ?></td>
                                        <td style="height:10px; padding: 1px;border: 1px solid black;"><?php echo "<b>".$pago."</b>"?></td>
                                       
                                       
                                        
                                       
        
        
        
                                  </tr>
                                          
                                   
        <?php
            
        
        
        
        }
        ?>
          </tbody>        
                               </table>  
        
                               <?php
        echo "Total del dia: $".$total;
        $total_final+=$total;
        $total = 0;
        
        echo "<br>";
        











}





echo "Días Trabajados: ".$dias_trabajados." - Total Semana: <b>$".$total_final."</b> - Tapicero: ".$nombre_tapicero;

?>
</div></div>
<script type="text/javascript">
	function printDiv(nombreDiv) {
     var contenido= document.getElementById(nombreDiv).innerHTML;
     var contenidoOriginal= document.body.innerHTML;

     document.body.innerHTML = contenido;

     window.print();

     document.body.innerHTML = contenidoOriginal;
}

</script>

<!--FIN del cont principal-->

<?php require_once "vistas/parte_inferior.php"?>