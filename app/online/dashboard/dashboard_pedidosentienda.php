
 <?php


$consulta = "SELECT * FROM pedido p 
INNER JOIN pedido_detalle d ON p.num_orden = d.num_orden
INNER JOIN clientes c ON p.rut_cliente = c.rut
WHERE d.estadopedido NOT IN ('100', '404') AND d.metodo_entrega = 'Retiro en tienda' AND (d.ruta_asignada = 0 OR d.ruta_asignada = '') 
ORDER BY p.rut_cliente ASC";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data=$resultado->fetchAll(PDO::FETCH_ASSOC);


$consulta2 = "SELECT * FROM pedido p 
INNER JOIN pedido_detalle d ON p.num_orden = d.num_orden 
INNER JOIN clientes c ON p.rut_cliente = c.rut 
WHERE d.estadopedido NOT IN ('100', '404') AND d.metodo_entrega = 'Retiro en tienda' AND (d.ruta_asignada = 0 OR d.ruta_asignada = '')

GROUP BY d.num_orden HAVING COUNT(d.num_orden) > 0 ORDER BY d.num_orden asc";

$resultado2 = $conexion->prepare($consulta2);
$resultado2->execute();
$data2 = $resultado2->fetchAll(PDO::FETCH_ASSOC);

foreach($data2 as $dat){
    
    $numeros_deorden[] = $dat['num_orden'];
}


     


?>
<div style="margin-top: 100px;"></div>
     <h4> RETIRO EN TIENDA </h4>
                <div class="col-lg-12" >
                    <div class="table-responsive" style="margin:0; width: 100rem;">        
                        <table id="tabla-pedidos_retiro" class="table table-striped table-bordered table-condensed" style="width:100%; font-size:0.8rem; ">
                        <thead class="text-center">
                            <tr>

                                 <th style="width:4rem;">Cant</th>
                                <th style="width:4rem;">Id</th>
                                <th style="width:6rem;">Rut Cliente</th>
                                <th style="width:9rem;">Modelo</th>                                
                                <th style="width:5rem;">Plazas</th>  
                                <th style="max-width:2rem;">Alt</th>
                                <th style="max-width:2rem;">Tela</th>
                                <th style="width:7rem;">Color</th>
                                 <th style="width:9rem;">Fecha Retiro</th>
                                 
                                   <th style="width:7rem;">Telefono</th>
                                <th style="width:5rem;">Precio</th>
                                <th style="width:7rem;">Cod_ped</th>
                                <th style="width:6rem;">Estado Pedido</th>
                                <th style="width:6rem;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php    
                            $contador = 0;                        
                            foreach($data as $dat) { 
                            $contador += 1;                                                       
                            ?>
                            <tr>
            <?php
            $numerodeorden = $dat['num_orden'];
                                           
            $rut = $dat['rut_cliente'];
                                             $consulta = "SELECT instagram FROM clientes where rut = '$rut'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $datt=$resultado->fetchAll(PDO::FETCH_ASSOC);

            foreach ($datt as $rdat) {
               $instagram = $rdat['instagram'];

            }
            if (in_array($numerodeorden, $numeros_deorden)) {
?>


    
                                <?php if($dat['comentarios'] != ''){ ?>
                                     <td style="height:10px; padding: 1px;   background-color: rgba(0, 145, 71, 0.1); "><?php echo $contador;?></td>
                                    <td style="height:10px; padding: 1px; background-color: rgba(0, 145, 71, 0.1);  font-weight: bold;"><abbr title="<?php echo $dat['comentarios']; ?>"><?php echo $dat['id'] ?><img width="15" src="img/notifi.png"></abbr></td>
                                <?php }else{ ?>
                                     <td style="height:10px; padding: 1px;   background-color: rgba(0, 145, 71, 0.1); "><?php echo $contador;?></td>
                                    <td style="height:10px; padding: 1px;   background-color: rgba(0, 145, 71, 0.1); "><?php echo $dat['id'] ?></td>
                                <?php } ?>


                               
                         

                                

                                <td style="height:10px; padding: 1px; background-color: rgba(0, 145, 71, 0.1); "><abbr title="<?php echo $instagram; ?>"><a href="https://www.respaldoschile.cl/intranet/dashboard/ver_ordenes_cliente.php?rut=<?php echo $dat['rut_cliente'] ?>"> <?php echo $dat['rut_cliente'] ?></a></abbr><a href="https://www.instagram.com/<?php echo $instagram;?>"><img width="15" src='img/inst.png'></a></td>


<?php }else{ ?>
                                <td style="height:10px; padding: 1px;   background-color: rgba(0, 145, 71, 0.1); "><?php echo $contador;?></td>
                                <?php if($dat['comentarios'] != ''){ ?>
                                    <td style="height:10px; padding: 1px;   font-weight: bold;"><abbr title="<?php echo $dat['comentarios']; ?>"><?php echo $dat['id'] ?></abbr><img width="15" src="img/notifi.png"></td>
                                <?php }else{ ?>
                                    <td style="height:10px; padding: 1px;   "><?php echo $dat['id'] ?></td>
                                <?php } ?>


                                
                                <td style="height:10px; padding: 1px; "><abbr title="<?php echo $instagram; ?>"><a href="https://www.respaldoschile.cl/intranet/dashboard/ver_ordenes_cliente.php?rut=<?php echo $dat['rut_cliente'] ?>"> <?php echo $dat['rut_cliente'] ?></a></abbr><a href="https://www.instagram.com/<?php echo $instagram;?>"><img width="15" src='img/inst.png'></a></td>
    <?php 
    }



    ?>
                   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>  
                     <script src="  https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.js"></script>  
                 








                     <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.css">
                   <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css">




                 
                                
                                <td style="height:10px; padding: 1px;"><?php echo $dat['modelo']; ?>
                               </td>
                                <td style="height:10px; padding: 1px;"><?php echo $dat['tamano']." ".$dat['tipo_boton']; ?></td> 
                                <td style="height:10px; padding: 1px;"><?php echo $dat['alturabase'] ?></td>
                                <td style="height:10px; padding: 1px;"><?php echo $dat['tipotela'] ?></td>
                                <td style="height:10px; padding: 1px;" ><?php echo $dat['color'] ?></td>
                                <td style="height:10px; padding: 1px;"><?php 
                                  $fechaActual = new DateTime();
                                    $detalleEntrega = new DateTime($dat['detalle_entrega']);
                                    $detalle_entrega_hora =  new DateTime($dat['detalle_entrega']); 
                                    $detalleEntrega->setTime(0, 0, 0);
                                    $manana = new DateTime('tomorrow');

                                    if ($detalleEntrega->format('Y-m-d') === $fechaActual->format('Y-m-d')) {
                                        echo "<span style='color:red;'>RETIRA HOY a las " . $detalle_entrega_hora->format('H:i').'</span>' ?>

                                                  <script type="text/javascript"> //Swal.fire("","Hoy retiran un producto","");

$.toast({
  heading: '<strong style="font-weight: bold;">Retiro Programado</strong>',
  text: 'Tienes un pedido que retiran HOY!',
  icon: 'info',
  loader: true,        // Change it to false to disable loader
  bgColor: '#F90000',
  loaderBg: '#9EC600', // To change the background
  position: 'top-center', // Posiciona el Toast en el centro superior
  stack: 1 // Permite mostrar múltiples Toasts en el mismo costado y en orden
});

</script>
                                        <?php
                                    } elseif ($detalleEntrega->format('Y-m-d') === $manana->format('Y-m-d')) {
                                        echo "RETIRA MAÑANA a las " . $detalle_entrega_hora->format('H:i');?>

                                        <script type="text/javascript"> //Swal.fire("","Hoy retiran un producto","");

$.toast({
  heading: '<strong style="font-weight: bold;">Retiro Programado</strong>',
  text: 'Tienes un pedido que retiran mañana!',
  icon: 'info',
  loader: true,        // Change it to false to disable loader
  bgColor: '#008DF9',
  loaderBg: '#9EC600', // To change the background
  position: 'top-center', // Posiciona el Toast en el centro superior
  stack: 1 // Permite mostrar múltiples Toasts en el mismo costado y en orden
});

</script>

                                        <?php
                                    } else {
                                        echo $dat['detalle_entrega'];
                                    }

                                ?></td>
                               
                                  <td style="height:10px; padding: 1px;"><?php echo $dat['telefono'] ?><?php if($dat['comentarios'] != ''){ ?>
                                <img width="15" src="img/notifi.png">
                            <?php }  if($dat['anclaje'] == 'si'){ ?>
                                        <img width="15" src="img/anclaje.png">
                              <?php } ?></td>
                                <td style="height:10px; padding: 1px;"><?php echo $dat['precio'] ?></td>
                                <td style="height:10px; padding: 1px;">
                                <a href="cambio_prod.php?id=<?php echo $dat['id'];?>"><button class='btn btn-danger' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Re-Emitir</button></a>
                                
                                <?php if($dat['cod_ped_anterior'] != ""){  ?>
                                    <img src="img/cambio.png" width="20">
                                <?php  } ?>
                                
                                </td>
                                <td style="height:10px; padding: 1px;">
                                    <?php 
                                   
                                if($dat['estadopedido'] == "0"){ 
                                    echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-warning btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>No Aceptado</button></div>";
                                }
                               elseif($dat['estadopedido'] == "1"){
                                   echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-secondary btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Aceptado</button></div>";
                                }
                                elseif($dat['estadopedido'] == "2" && $dat['tapicero_id'] != "" or $dat['tapicero_id'] == "0"){
                                    echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-warning btnEditarestado' id='parpadea_' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Por Fabricar</button></div>";
                                }/*elseif( $dat['tapicero_id'] != ""){
                                    echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-info btnEditarestado' id='parpadea' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Asignado</button></div>";
                                }*/
                                 elseif($dat['estadopedido'] == "5"){
                                    echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-success btnEditarestado' id='parpadea' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Fabricando</button></div>";
                                }elseif($dat['estadopedido'] == "2"){
                                    echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-success btnEditarestado' id='parpadea' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Por Fabricar</button></div>";
                                }

                                elseif($dat['estadopedido'] == "6"){
                                    echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-info btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Pedido Listo</button></div>";
                                }
                                 elseif($dat['estadopedido'] == "7"){
                                    echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-warning btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>En carga</button></div>";
                                }
                                elseif($dat['estadopedido'] == "19"){
                                    echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-warning btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Reagendar</button></div>";
                                }
                                
                                elseif($dat['estadopedido'] == "4"){
                                    echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-dark btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Devuelto</button></div>";
                                }
                              
                               



                            ?>

                            </td>   
                                <td style="height:10px; padding: 1px;"></td>
                            </tr>
                            <?php
                                }
                            ?>                                
                        </tbody>        
                       </table>                    
                    </div>
                </div>
       