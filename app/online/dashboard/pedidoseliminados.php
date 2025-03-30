<?php require_once "vistas/parte_superior.php"?>

<!--INICIO del cont principal-->
<div class="container" style=" max-width: 400rem; width: 200rem;">
    <h1>Pedidos Eliminados</h1>
    
    
    
 <?php
include_once 'bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$consulta = "SELECT * FROM eliminados ORDER BY fecha desc";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data=$resultado->fetchAll(PDO::FETCH_ASSOC);


$consulta2 = "SELECT * FROM pedido_detalle GROUP BY num_orden HAVING COUNT(num_orden) > 1 ORDER BY num_orden asc";

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
                        <table id="tabla-pedidos-eliminados" class="table table-striped table-bordered table-condensed" style="width:100%; font-size:0.8rem; ">
                        <thead class="text-center">
                            <tr>

                                
                                <th style="width:2rem;">Id</th>
                                <th style="width:6rem;">Rut Cliente</th>
                                <th style="width:15rem;">Modelo</th>                                
                                <th style="width:6rem;">Tamano</th>  
                                <th style="max-width:2rem;">Alt</th>
                                <th style="max-width:0.5rem;">Tela</th>
                                <th style="width:7rem;">Color</th>
                                 <th style="width:15rem;">Direccion</th>
                                  
                                   <th style="width:5rem;">Telefono</th>
                                <th style="width:4rem;">Precio</th>
                                
                                <th style="width:5rem;">Estado Pedido</th>
                                <th style="width:12rem;">Motivo</th>
                                   <th style="width:9rem;">Fecha</th>
                                    <th style="width:4rem;">Usuario</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php                            
                            foreach($data as $dat) {                                                        
                            ?>
                            <tr>
<?php
$numerodeorden =  $numeros_deorden;

if (in_array($numerodeorden, $numeros_deorden)) { ?>
                                
                                <td style="height:10px; padding: 1px; background-color: rgba(0, 145, 71, 0.1);"><?php echo $dat['id'] ?></td>
                                <td style="height:10px; padding: 1px; background-color: rgba(0, 145, 71, 0.1);"><?php echo $dat['rut_cliente'] ?></td>
<?php }else{?>
                               
                                
                                <td style="height:10px; padding: 1px; "><?php echo $dat['id'] ?></td>
                                <td style="height:10px; padding: 1px; "><?php echo $dat['rut_cliente'] ?></td>
<?php }


?>
                                
                                
                                <td style="height:10px; padding: 1px;"><?php echo $dat['modelo'] ?></td>
                                <td style="height:10px; padding: 1px;"><?php echo $dat['plazas'] ?></td> 
                                <td style="height:10px; padding: 1px;"><?php echo $dat['alturabase'] ?></td>
                                <td style="height:10px; padding: 1px;"><?php echo $dat['tipotela'] ?></td>
                                <td style="height:10px; padding: 1px;" ><?php echo $dat['color'] ?></td>
                                <td style="height:10px; padding: 1px;"><?php echo $dat['direccion']." ".$dat['numero'].", ".$dat['comuna'] ?></td>
                            

                                  <td style="height:10px; padding: 1px;"><?php echo $dat['telefono'] ?></td>
                                    <td style="height:10px; padding: 1px;"><?php echo $dat['precio'] ?></td>
                                
                                <td style="height:10px; padding: 1px;"><button class='btn btn-danger' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Eliminado</button></td> 
                                  <td style="height:10px; padding: 1px;"><?php echo $dat['motivo'] ?></td>  
                                   <td style="height:10px; padding: 1px;"><?php echo $dat['fecha'] ?></td>  
                                    <td style="height:10px; padding: 1px;"><?php echo $dat['usuario'] ?></td>
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