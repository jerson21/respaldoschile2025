<?php require_once "vistas/parte_superior.php"?>

<!--INICIO del cont principal-->
<div class="container" style=" max-width: 400rem; width: 200rem; ">
    <h1>Pedidos</h1>
    <style>.btn-encarga {
  color: #fff;
  background-color: #FF9E00; /* Cambia este valor al color deseado */
  border-color: #FF9E00; /* Cambia este valor al color deseado */
} </style>

    
 <?php
include_once 'bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$consulta = "SELECT * FROM pedido p 
INNER JOIN pedido_detalle d ON p.num_orden = d.num_orden
INNER JOIN clientes c ON p.rut_cliente = c.rut
ORDER BY  d.id desc LIMIT 2000";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data=$resultado->fetchAll(PDO::FETCH_ASSOC);


$consulta2 = "SELECT * from pedido_detalle 
GROUP BY num_orden
HAVING COUNT(num_orden) > 1";

$resultado2 = $conexion->prepare($consulta2);
$resultado2->execute();
$data2 = $resultado2->fetchAll(PDO::FETCH_ASSOC);

foreach($data2 as $dat){
    
    $numeros_deorden[] = $dat['num_orden'];
}


     


?>


<div class="container" >

        <div class="row">
             
        </div>    
    </div>    
    <br>  
<div class="container" style="float:left; padding: 0; ">




        <div class="row">
                <div class="col-lg-12" >
                    <div class="table-responsive" style="margin:0; width: 100rem;">        
                        <table id="tabla-pedidos" class="table table-striped table-bordered table-condensed" style="width:100%; font-size:0.8rem; ">
                        <thead class="text-center">
                            <tr>

                                 <th style="width:10px;">Cant</th>
                                <th style="width:4rem;">Id</th>
                                <th style="width:6rem;">Rut Cliente</th>
                                <th style="width:10rem;">Modelo</th>                                
                                <th style="width:5rem;">Plazas</th>  
                                <th style="max-width:2rem;">Alt</th>
                                <th style="max-width:2rem;">Tela</th>
                                <th style="width:7rem;">Color</th>
                                 <th style="width:9rem;">Direccion</th>
                                  <th style="width:2rem;">Nº</th>
                                   <th style="width:7rem;">Comuna</th>
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
                                     <td style="height:10px;    "><?php echo $contador;?></td>
                                    <td style="height:10px; padding: 1px; background-color: rgba(0, 145, 71, 0.1);  font-weight: bold;"><abbr title="<?php echo $dat['comentarios']; ?>"><?php echo $dat['id'] ?><img width="15" src="img/notifi.png"></abbr></td>
                                <?php }else{ ?>
                                     <td style="height:10px; padding: 1px;   background-color: rgba(0, 145, 71, 0.1); "><?php echo $contador;?></td>
                                    <td style="height:10px; padding: 1px;   background-color: rgba(0, 145, 71, 0.1); "><?php echo $dat['id'] ?></td>
                                <?php } ?>


                               
                         

                                

                                <td style="height:10px; padding: 1px; background-color: rgba(0, 145, 71, 0.1); "><abbr title="<?php echo $instagram; ?>"><a href="ver_ordenes_cliente.php?rut=<?php echo $dat['rut_cliente'] ?>"> <?php echo $dat['rut_cliente'] ?></a></abbr><a href="https://www.instagram.com/<?php echo $instagram;?>"><img width="15" src='img/inst.png'></a></td>


<?php }else{ ?>
                                <td style="height:10px; padding: 1px;    "><?php echo $contador;?></td>
                                <?php if($dat['comentarios'] != ''){ ?>
                                    <td style="height:10px; padding: 1px;   font-weight: bold;"><abbr title="<?php echo $dat['comentarios']; ?>"><?php echo $dat['id'] ?></abbr><img width="15" src="img/notifi.png"></td>
                                <?php }else{ ?>
                                    <td style="height:10px; padding: 1px;   "><?php echo $dat['id'] ?></td>
                                <?php } ?>


                                
                                <td style="height:10px; padding: 1px; "><abbr title="<?php echo $instagram; ?>"><a href="ver_ordenes_cliente.php?rut=<?php echo $dat['rut_cliente'] ?>"> <?php echo $dat['rut_cliente'] ?></a></abbr><a href="https://www.instagram.com/<?php echo $instagram;?>"><img width="15" src='img/inst.png'></a></td>
    <?php 
    }


    ?>
                                
                                
                                <td style="height:10px; padding: 1px;"><?php echo $dat['modelo']; ?>
                               </td>
                                <td style="height:10px; padding: 1px;"><?php echo $dat['tamano']." ".$dat['tipo_boton']; ?></td> 
                                <td style="height:10px; padding: 1px;"><?php echo $dat['alturabase'] ?></td>
                                <td style="height:10px; padding: 1px;"><?php echo $dat['tipotela'] ?></td>
                                <td style="height:10px; padding: 1px;" ><?php echo $dat['color'] ?></td>
                                <td style="height:10px; padding: 1px;"><?php echo $dat['direccion'] ?></td>
                                 <td style="height:10px; padding: 1px;" ><?php echo $dat['numero'] ?></td>
                                  <td style="height:10px; padding: 1px;" ><?php echo $dat['comuna'] ?></td>
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
                                elseif($dat['estadopedido'] == "2" && $dat['tapicero_id'] == "" or $dat['tapicero_id'] == "0"){
                                    echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-warning btnEditarestado' id='parpadea_' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Por Fabricar</button></div>";
                                }
                                 elseif($dat['estadopedido'] == "5"){
                                    echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-success btnEditarestado' id='parpadea' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Fabricando</button></div>";
                                }
                                 elseif($dat['estadopedido'] == "2"){
                                    echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-success btnEditarestado' id='parpadea' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Por Fabricar</button></div>";
                                }

                                elseif($dat['estadopedido'] == "6"){
                                    echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-info btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Pedido Listo</button></div>";
                                }
                                 elseif($dat['estadopedido'] == "8"){
                                    echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-encarga btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>En carga</button></div>";
                                }
                                elseif($dat['estadopedido'] == "19"){
                                    echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-warning btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Reagendar</button></div>";
                                }
                                
                                elseif($dat['estadopedido'] == "4"){
                                    echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-dark btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Devuelto</button></div>";
                                }
                                elseif($dat['estadopedido'] == "404"){
                                    echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-danger' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Eliminado</button></div>";
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


        </div>  



    </div>  

    <!-- MOSTRAR PRODUCTOS QUE RETIRAN EN FABRICA -->


      
<!--Modal para CRUD Editar estado de compra-->
<div class="modal fade" id="modalCRUD" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
        <form id="editarestado">    
            <div class="modal-body">
                <div class="form-group">
                <label for="id" class="col-form-label">Cod:</label>
                <input type="text" class="form-control" id="id" readonly>
                </div>
                <div class="form-group">
                <select name="estado" id="estado" class="form-control" >
                    <option value="" disabled selected>Selecciona Estado</option>
                    <option value="1">Aceptar Compra</option>
                    <option value="2">Enviar a Fabricación</option>
                    <option value="6">Pedido Listo</option>
                    <option value="19">Reagendar</option>
                  </select>
                </div>                
                            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                <button type="submit" id="btnGuardar" class="btn btn-dark">Guardar</button>
            </div>
        </form>    
        </div>
    </div>
</div>  

<!-- Modal -->



<?php include("modal_editarpedido.php"); ?>
      
    
    
</div>
<!--FIN del cont principal-->
<?php require_once "vistas/parte_inferior.php"?>