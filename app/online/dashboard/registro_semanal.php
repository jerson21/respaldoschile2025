<?php require_once "init.php" ?>
<?php require_once "vistas/parte_superior.php"?>

<!--INICIO del cont principal-->
<div class="container" style=" max-width: 400rem; width: 200rem; ">
    <h1>Produccion tapiceros</h1>
    
    
    
 <?php

$BD_SERVIDOR = "localhost";
$BD_USUARIO ="cre61650_respaldos21";
$BD_PASSWORD = "respaldos21/";
$BD_NOMBRE = "cre61650_agenda";

$mysqli = new mysqli($BD_SERVIDOR, $BD_USUARIO, $BD_PASSWORD, $BD_NOMBRE);



$resultado = $mysqli->query("SELECT * FROM pedidos where tapicero_id = 1 ");

$mysqli -> set_charset("utf8");


?>


<div class="container" >
        <div class="row">
              
        </div>    
    </div>    
    <br>  
<div class="container" style="float:left; padding: 0; ">
        <div class="row">
                <div class="col-lg-12" >
                    
                 

    
    <?php 

    
    while($row = mysqli_fetch_array($resultado))
{ 
    $ruta = $row['ruta_asignada'];

$resultadosruta = $mysqli->query("SELECT fecha FROM rutas where id = $ruta");
    $rows = mysqli_fetch_assoc($resultadosruta);
setlocale(LC_TIME, 'es_CO.UTF-8');

  $fecha = strftime("%A, %d de %B de %Y", strtotime($rows['fecha']));

     ?>


     <div class="table-responsive" style="margin:0; width: 100rem; ">  
   


                        <table id="tablatapiceross" class="table table-striped table-bordered table-condensed" style="width:100%; font-size:0.8rem; ">
                        <thead class="text-center">
                            <tr>

                                 <?php 

    if($ruta == '0'){
        echo "<div class='alert alert-danger' role='alert' style='margin:0 auto; text-align:center;'>Pedidos sin asignar a ruta</div>";
    }else{
        echo "<div class='alert alert-warning' role='alert' style='margin:0 auto; text-align:center;'><b>".$ruta.".</b> ".$fecha;"</div>";
    }      ?>
                                <th style="width:2rem;">Id</th>
                                <th style="width:3rem;">Rut Cliente</th>
                                <th style="width:7rem;">Modelo</th>                                
                                <th style="width:3rem;">Plazas</th>  
                                <th style="width:2rem;">Alt</th>
                                <th style="width:2rem;">Tela</th>
                                <th style="width:5rem;">Color</th>
                                 <th style="width:7rem;">Direccion</th>
                                  <th style="width:2rem;">Nº</th>
                                   <th style="width:5rem;">Comuna</th>
                                   <th style="width:3rem;">Telefono</th>
                                
                                <th style="width:7rem;">Estado Pedido</th>
                                <th style="width:1rem;">Cliente</th>
                                <th style="width:4rem;">Jaime</th>
                                <th style="width:4rem;">Felipe</th>
                            </tr>
                        </thead>

                        <?php
   

    $resultados = $mysqli->query("SELECT * FROM pedidos where tapicero_id = 1 ");

    while($dat = mysqli_fetch_array($resultados))
    {
        
    




?>


                    
                        
                                             
                                        
                            
                            <tr>



                               
                                
                                <td style="height:10px; padding: 1px; "><?php echo $dat['id'] ?></td>
                                <td style="height:10px; padding: 1px; "><?php echo $dat['rut_cliente'] ?></td>


                                
                                
                                <td style="height:10px; padding: 1px;"><?php echo $dat['modelo'] ?></td>
                                <td style="height:10px; padding: 1px;"><?php echo $dat['plazas'] ?></td> 
                                <td style="height:10px; padding: 1px;"><?php echo $dat['alturabase'] ?></td>
                                <td style="height:10px; padding: 1px;"><?php echo $dat['tipotela'] ?></td>
                                <td style="height:10px; padding: 1px;" ><?php echo $dat['color'] ?></td>
                                <td style="height:10px; padding: 1px;"><?php echo $dat['direccion'] ?></td>
                                 <td style="height:10px; padding: 1px;" ><?php echo $dat['numero'] ?></td>
                                  <td style="height:10px; padding: 1px;" ><?php echo $dat['comuna'] ?></td>
                                  <td style="height:10px; padding: 1px;"><?php echo $dat['telefono'] ?></td>
                                
                                <td style="height:10px; padding: 1px;"><?php if($dat['estadopedido'] == "1"){
                                   echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-secondary btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Aceptado</button></div>";
                                }elseif($dat['estadopedido'] == "2"){
                                    echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-info btnEditarestado' id='parpadea' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>En Fabricacion</button></div>";
                                }elseif($dat['estadopedido'] == "0"){ 
                                    echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-warning btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>No Aceptado</button></div>";
                                }
                                elseif($dat['estadopedido'] == "3"){
                                    echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-info btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Pedido Listo</button></div>";
                                }
                                elseif($dat['estadopedido'] == "9"){
                                    echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-warning btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Reagendar</button></div>";
                                }
                                elseif($dat['estadopedido'] == "4"){
                                    echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-warning btnEditarestado' style=' background-color: #FF338A;font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Asignado a Ruta</button></div>";
                                }
                                 elseif($dat['estadopedido'] == "5"){
                                    echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-warning btnEditarestado' style=' background-color: #ABFF71;font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Entregado</button></div>";
                                }



                            ?>
                                
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
                                .btn-circles.btn-sm {
                                    width: 20px;
                                    height: 20px;
                                    padding: 3px 0px;
                                    border-radius: 20px;
                                    font-size: 8px;
                                    text-align: center;
                                }
                                
                            </style>



                            <td style="height:10px; padding: 1px; text-align: center;"><?php if($dat['confirma'] == "1"){ ?>
                                <button type="button" class="btn btn-info btn-circles btn-sm"></button>
                                <?php } else{ ?>
                                    <button type="button" class="btn btn-danger btn-circles btn-sm"></button>
                                <?php } ?>
                            </td>
                            
                                <?php if($dat['tapicero_id'] == '' or $dat['tapicero_id'] == '0'){ ?>
                                <td style="height:10px; padding: 1px; text-align: center;"><button type="button" class="btn btn-warning btn-circle btn-sm btnjaime"></button></td>
                                 <td style="height:10px; padding: 1px; text-align: center;"><button type="button" class="btn btn-warning btn-circle btn-sm btnfelipe"></button></td>

                              <?php  }if($dat['tapicero_id']  == '1'){ ?>
                            <td style="height:10px; padding: 1px; text-align: center;"><button type="button" class="btn btn-success btn-circle btn-sm btndesasignar"></button></td>
                            <td style="height:10px; padding: 1px; text-align: center;"></td>
                                 <?php  }if($dat['tapicero_id']  == '2'){ ?>
                            <td style="height:10px; padding: 1px; text-align: center;"></button></td>
                            <td style="height:10px; padding: 1px; text-align: center;"><button type="button" class="btn btn-success btn-circle btn-sm btndesasignar"></td>
                                <?php } ?>
                            </tr>
                           <?php 

     } }
                            ?>                                
                        </tbody>        
                       </table>                    
                    </div>

                    
                </div>
        </div>  
    </div>    
      
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
                    <option value="3">Pedido Listo</option>
                    <option value="9">Reagendar</option>
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

<!--Modal para CRUD EDITAR PEDIDO-->
<div class="modal fade" id="modalEditarPedido" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
        <form id="editarpedido">    
            <div class="modal-body">
                <div class="form-group">
                <label for="id" class="col-form-label">Cod:</label>
                <input type="text" class="form-control" id="ide" name="ide" readonly>
                </div>
                <div class="form-group">
                <label for="id" class="col-form-label">Rut:</label>
                <input type="text" class="form-control" id="rut" name="rut">
                </div>
                <div class="row gy-4">
                    <div class="col-lg-4">
                <label for="modelo" class="col-form-label">Modelo:</label>
                <input type="text" class="form-control" id="modelo" name="modelo">
                </div>
                <div class="col-lg-4">
                <label for="plazas" class="col-form-label">Plazas:</label>
                <input type="text" class="form-control" id="plazas" name="plazas">
                </div>
                <div class="col-lg-4">
                <label for="tela" class="col-form-label">Tela:</label>
                <input type="text" class="form-control" id="tela" name="tela">
                </div>
                    <div class="col-lg-4">
                <label for="color" class="col-form-label">Color:</label>
                <input type="text" class="form-control" id="color" name="color">
                </div>
                <div class="col-lg-4">
                <label for="color" class="col-form-label">Altura:</label>
                <input type="text" class="form-control" id="alturabase" name="alturabase">
                </div>
                <div class="col-lg-4">
                <label for="color" class="col-form-label">Telefono:</label>
                <input type="text" class="form-control" id="telefono" name="telefono">
                </div>
                </div> 
                 <div class="row gy-4">
                <div class="col-lg-4">
                <label for="color" class="col-form-label">Direccion:</label>
                <input type="text" class="form-control" id="direccion" name="direccion">
                </div>
                <div class="col-lg-4">
                <label for="color" class="col-form-label">Num:</label>
                <input type="text" class="form-control" id="numero" name="numero">
                </div>
                <div class="col-lg-4">
                <label for="color" class="col-form-label">Comuna:</label>
                <input type="text" class="form-control" id="comuna" name="comuna">
                </div>
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
      
    
    
</div>
<!--FIN del cont principal-->
<?php require_once "vistas/parte_inferior.php"?>