<?php require_once "init.php" ?>
<?php require_once "vistas/parte_superior.php"?>

<!--INICIO del cont principal-->
<div class="container">
    <h1>Detalle de Pedido</h1>
</div>



<?php

include_once '../bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();
$id = $_GET['id'];
$consultar = "SELECT * FROM pedidos WHERE id='$id' ";
        $resultado2 = $conexion->prepare($consultar);
        $resultado2->execute();

        $data = $resultado2->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($data as $dat) { 
                $codigo = $dat['id'];
                $rut_cliente = $dat['rut_cliente'];
                 $fecha_ingreso = $dat['fecha_ingreso'];
                $modelo = $dat['modelo'];
                 $tela = $dat['tipotela'];
                  $color = $dat['color'];
                   $altura_base = $dat['alturabase'];
                    $plazas = $dat['plazas'];
                     $comentarios = $dat['comentarios'];
                     $tapicero_id = $dat['tapicero_id'];
                     if($tapicero_id == '1'){ $tapicero = "Jaime"; }  if($tapicero_id == '2'){ $tapicero = "Felipe"; }  if($tapicero_id == '3'){ $tapicero = "Reemplazante"; }
                     $fecha_enviofabricacion = $dat['fecha_enviofabricacion'];
                     $fecha_fabricacion = $dat['fecha_fabricacion'];
                     $ruta_asignada = $dat['ruta_asignada'];
                     $modo_pago =  $dat['mododepago'];
                    $tipo_boton = $dat['tipo_boton'];
                    $anclaje = $dat['anclaje'];

                    if($tipo_boton == "B D"){ $boton = "Boton Diamante"; } if($tipo_boton == "B Color"){ $boton = "Boton Colores"; }
                    if($anclaje == "si"){ $anclaje = "Madera de Anclaje"; } if($anclaje == "patas"){ $anclaje = "Patas de Madera"; }

        }

        ?>

<script type='text/javascript' src='https://code.jquery.com/jquery-1.11.0.js'></script>
<script type='text/javascript' src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
<div class="page-content page-container" id="page-content">
    <div class="padding">
        <div class="row container d-flex justify-content-center">
            <div class="col-lg-8 grid-margin stretch-card">
                <!--form mask starts-->
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Información Detallada</h4>
                        <p class="card-description">Respaldos Chile</p>
                        <form class="forms-sample">
                          <div class="form-group row">
                            <div class="col-3"> <label>Codigo:</label> <input class="form-control" value="<?php echo $codigo; ?>"> </div>
                            <div class="col-4"> <label>Modelo:</label> <input class="form-control" value="<?php echo $modelo; ?>"> </div>
                            <div class="col-4"> <label>Fecha Ingreso:</label> <input class="form-control"  value="<?php echo $fecha_ingreso; ?>"> </div>
                          </div>
                            <div class="form-group row">
                                
                                <div class="col"> <label>Plazas:</label> <input class="form-control" value="<?php echo $plazas; ?>"> </div>
                                <div class="col"> <label>Tela:</label> <input class="form-control" value="<?php echo $tela; ?>"> </div>
                                <div class="col"> <label>Color:</label> <input class="form-control" value="<?php echo $color; ?>"> </div>
                                <div class="col"> <label>Altura base:</label> <input class="form-control" value="<?php echo $altura_base; ?>"> </div>
                            </div>
                            <div class="form-group row">
                                
                                <div class="col-3"> <b> <?php echo $boton; ?> </b></div>
                                <div class="col-3"> <b> <?php echo $anclaje; ?> </b>  </div>
                                <div class="col-3">  </div>
                                
                            </div>

                             <div class="form-group row">
                               <div class="form-group"> <label>Observaciones:</label> <input class="form-control" data-inputmask="'alias': 'currency'" style="text-align: left;" value="<?php echo $comentarios; ?>"> </div>
                             </div>

                            <div class="form-group row">
                              <div class="col"><label>Tapicero:</label> <input class="form-control" id="phone" data-inputmask="'alias': 'phonebe'" value="<?php echo $tapicero; ?>">   </div>
                            <div class="col"><label>Fecha de envío a Fabricación:</label> <input class="form-control" data-inputmask="'alias': 'date','placeholder': '*'" value="<?php echo $fecha_enviofabricacion; ?>">  </div>
                            <div class="col"><label>Fecha de Fabricación:</label> <input class="form-control" id="phone" data-inputmask="'alias': 'phonebe'"value="<?php echo $fecha_fabricacion; ?>">   </div>
                          </div>

                          <div class="form-group row">
                            <h4 class="card-title">Entrega</h4>
                              <div class="col"><label>Ruta Asignada:</label> <input class="form-control" id="phone" data-inputmask="'alias': 'phonebe'" value="<?php echo $ruta_asignada; ?>">   </div>
                            <div class="col"><label>Fecha de entrega:</label> <input class="form-control" data-inputmask="'alias': 'date','placeholder': '*'">  </div>
                            
                          </div>


                          <div class="form-group row">
                            <h4 class="card-title">Pago</h4>
                              <div class="col-4"><label>Modo de pago:</label> <input class="form-control" id="phone" data-inputmask="'alias': 'phonebe'"value="<?php echo $modo_pago; ?>">   </div>
                            
                            
                          </div>



                           
                        </form>
                    </div>
                </div>
                <!--form mask ends-->
            </div>
        </div>
    </div>
    <!--form mask ends-->
</div>
<!--FIN del cont principal-->

<?php require_once "vistas/parte_inferior.php"?>