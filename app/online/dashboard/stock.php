<?php require_once "init.php" ?>
<?php require_once "vistas/parte_superior.php"?>

<!--INICIO del cont principal-->
<div class="container" style=" max-width: 400rem; width: 200rem; ">
    <h1>Pedidos</h1>
    
    
    
 <?php
include_once 'bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$consulta = "SELECT * FROM gan";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data=$resultado->fetchAll(PDO::FETCH_ASSOC);


$consulta2 = "SELECT * FROM pedidos GROUP BY num_orden HAVING COUNT(num_orden) > 1 ORDER BY num_orden asc";

$resultado2 = $conexion->prepare($consulta2);
$resultado2->execute();
$data2 = $resultado2->fetchAll(PDO::FETCH_ASSOC);

foreach($data2 as $dat){
    
    $numeros_deorden[] = $dat['num_orden'];
}


        
     


?>


<div class="container" >
        <div class="row">
            <div class="col-lg-12">            
            <button id="btnNuevo" type="button" class="btn btn-success" data-toggle="modal">Nuevo</button>    
            </div>    
        </div>    
    </div>    
    <br>  
<div class="container" style="float:left; padding: 0; ">
        <div class="row">
                <div class="col-lg-12" >
                    <div class="table-responsive" style="margin:0; ">        
                        <table id="tablatapiceros" class="table table-striped table-bordered table-condensed" style="width:100%; font-size:0.8rem; text-align: center; ">
                        <thead class="text-center">
                            <tr>

                                
                                <th style="width:0.5rem;">Id</th>
                                <th style="width:3rem;">Categoria</th>
                                <th style="width:6rem;">Producto</th>
                                <th style="width:3rem;">Tamaño</th>                                
                                <th style="width:5rem;">Precio</th>  
                                <th style="max-width:2rem;">Precio con descuento</th>
                                <th style="max-width:2rem;">Stock</th> 
                                <th style="max-width:2rem;">Validaciones</th>                               
                            </tr>
                        </thead>
                        <tbody>
                            <?php                            
                            foreach($data as $dat) {                                                        
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

?>


                                    <td style="height:10px;  "><?php echo $dat['cod'] ?></td>
                            

<td style="height:10px;  "><?php echo $dat['subcategoria'] ?></td>
                               
                         

                                

                                <td style="height:10px; padding: 1px; "> <?php echo $dat['modelo'] ?></td>



                               
                              
                                <td style="height:10px;    font-weight: bold;"><?php echo $dat['tamano'] ?>
                              
                               
                               


                                
                                <td style="height:10px; padding: 1px; "> <b><?php echo $dat['venta'] ?></b></td>

                                 <td style="height:10px; padding: 1px; "> <?php echo $dat['venta'] ?></td>
                                  <td style="height:10px; padding: 1px; "> 0</td>
                                  <td style="height:10px; padding: 1px; "> </td>

                                
                                
                                

                             
                                
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
                <div class="col-lg-4">
                <label for="precio" class="col-form-label">Precio:</label>
                <input type="text" class="form-control" id="precio" name="precio">
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