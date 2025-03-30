<?php require_once "vistas/parte_superior.php"?>
<style type="text/css">
    ody {
    font-family: Arial;
    font-size: 17px;
    padding: 8px;
}

* {
    box-sizing: border-box;
}

h2 {
    font-size: 40px;
    background: linear-gradient(to left, #660066 0%, #ff3300 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.row {
    display: -ms-flexbox;
    /* IE10 */
    display: flex;
    -ms-flex-wrap: wrap;
    /* IE10 */
    flex-wrap: wrap;
    margin: 0 -16px;
}

.col-25 {
    -ms-flex: 25%;
    /* IE10 */
    flex: 25%;
}

.col-50 {
    -ms-flex: 50%;
    /* IE10 */
    flex: 50%;
}

.col-75 {
    -ms-flex: 75%;
    /* IE10 */
    flex: 75%;
}

.col-25,
.col-50,
.col-75 {
    padding: 0 16px;
}

.container {
    background-color: #f2f2f2;
    padding: 5px 20px 15px 20px;
    border: 1px solid lightgrey;
    border-radius: 3px;
}

input[type=text] {
    width: 100%;
    margin-bottom: 20px;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 3px;
}

label {
    margin-bottom: 10px;
    display: block;
}

.icon-container {
    margin-bottom: 20px;
    padding: 7px 0;
    font-size: 24px;
}

.btn {
    background: linear-gradient(to left, #99ccff 0%, #003399 100%);
    color: black;
    padding: 12px;
    margin: 10px 0;
    border: none;
    width: 100%;
    border-radius: 3px;
    cursor: pointer;
    font-size: 20px;
}

.btn:hover {
    background: linear-gradient(to left, #003399 0%, #99ccff 100%);
}

a {
    color: #2196F3;
}

hr {
    border: 1px solid lightgrey;
}

span.price {
    float: right;
    color: grey;
}

/* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other (also change the direction - make the "cart" column go on top) */
@media (max-width: 800px) {
    .row {
        flex-direction: column-reverse;
    }

    .col-25 {
        margin-bottom: 20px;
    }
}
.texto{
    float: right;
    font-weight: bold;
    color: black;
}
.label-margin{
        margin: 0;
    color: ;
}
</style>
<!--INICIO del cont principal-->

    <h1>Cambio de Producto</h1>
    
    
    
 <?php
include_once 'bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$consulta = "SELECT * FROM gan";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data=$resultado->fetchAll(PDO::FETCH_ASSOC);

if(isset($_GET['id']))
{
    $id = $_GET['id'];
}
$consulta2 = "SELECT p.num_orden,p.rut_cliente,c.*,pd.* FROM pedido_detalle pd INNER JOIN pedido p ON p.num_orden = pd.num_orden INNER JOIN clientes c ON p.rut_cliente = c.rut  where pd.id = $id";

$resultado2 = $conexion->prepare($consulta2);
$resultado2->execute();
$data2 = $resultado2->fetchAll(PDO::FETCH_ASSOC);

foreach($data2 as $dat){
         $nombre = $dat['nombre'];
         $telefono = $dat['telefono'];
   $rut_cliente = $dat['rut_cliente'];

   $direccion = $dat['direccion'];
   $numero = $dat['numero']; // numero direccion
   $dpto = $dat['dpto'];
   $telefono = $dat['telefono'];
   $correo = $dat['correo'];
    $comuna = $dat['comuna'];
     $instagram = $dat['instagram'];
   $num_orden = $dat['num_orden'];
   $modelo = $dat['modelo'];
   $plazas = $dat['tamano'];
   $alturabase = $dat['alturabase'];
   $tipo_tela = $dat['tipotela'];
   $color = $dat['color'];
   $precio = $dat['precio'];
   $comentarios = $dat['comentarios'];
      $detalle_fabricacion = $dat['detalles_fabricacion'];
      $detalle_entrega = $dat['detalle_entrega'];
      $atencion = $dat['atencion'];
         
          $anclaje = $dat['anclaje'];
   
   $pagado = $dat['pagado'];
    $precio = $dat['precio'];
    $abono = $dat['abono'];
       $mododepago = $dat['formadepago'];
        $region = $dat['region'];
        $fecha_entrega = $dat['detalle_entrega'];
        $retiro_tienda = $dat['metodo_entrega'];



}






?>

<script type="text/javascript">
function mostrar2(id) {

    if (id == "respaldo") {
        $("#formularios").load('formularios/form_cambios/respaldoform.php?num_orden=<?php echo $num_orden; ?>');
        $("#formularios").show();
    }
  if (id == "colchon") {
        $("#formularios").load('formularios/form_cambios/colchonform.php?num_orden=<?php echo $num_orden; ?>');
        $("#formularios").show();
    }
    if (id == "base") {
       $("#formularios").load('formularios/form_cambios/baseform.php?num_orden=<?php echo $num_orden; ?>');
        $("#formularios").show();
    }
    if (id == "patas") {
        $("#formularios").load('formularios/form_cambios/patasform.php?num_orden=<?php echo $num_orden; ?>');
        $("#formularios").show();
    }
    if (id == "respaldo2") {
        $("#formularios").load('formularios/form_cambios/respaldoform2.php?num_orden=<?php echo $num_orden; ?>');
        $("#formularios").show();
    }
     if (id == "banquetas") {
        $("#formularios").load('formularios/form_cambios/banquetaform.php?num_orden=<?php echo $num_orden; ?>');
        $("#formularios").show();
    }
    if (id == "fundas") {
        $("#formularios").load('formularios/form_cambios/fundasform.php?num_orden=<?php echo $num_orden; ?>');
        $("#formularios").show();
    }
    if (id == "living") {
        $("#formularios").load('formularios/form_cambios/livingform.php?num_orden=<?php echo $num_orden; ?>');
        $("#formularios").show();
    }
  }</script>


<div class="container" >
<h2>Pedido Actual</h2>
<p>Aca debes ingresar el nuevo pedido.</p>
<div class="row">
    <div class="col-75">
        <div class="container">
            <form  name="cambio" id="cambio" class="php-email-form" accept-charset="utf-8" method="post" action="post_cambios.php">
                <input type="hidden" name="id_anterior" value="<?php echo $_GET['id'];?>">
                       <input type="hidden" id="cod_pedidoanterior" name="cod_pedidoanterior" placeholder="" value="<?php echo $_GET['id']; ?>">
                         <input type="hidden" id="atencion" name="atencion" placeholder="" value="<?php echo $atencion; ?>">



                <div class="row" >
                    <div class="col-50" style="padding-bottom:0;">
                        <h3>Cliente</h3>

                         <div class="row">
                            <div class="col-50">
                               <label for="rut" class="label-margin"><i class="fa fa-user"></i> Rut</label>
                                 <input type="text" id="rut" name="rut" class="form-control-sm" style=" background-color: #ccc; margin:0;" value="<?php echo $rut_cliente; ?>" readonly> 
                            </div>
                            <div class="col-50">
                                 <label for="nombre" class="label-margin"><i class="fa fa-user"></i> Nombre</label>
                        <input type="text" class="form-control-sm" id="nombre" name="nombre" placeholder="Ravi Raushan" style="margin:0;" value="<?php echo $nombre; ?>" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-50">
                              <label for="email" class="label-margin"><i class="fa fa-envelope"></i> Email</label>
                         <input type="text" class="form-control-sm"id="email" name="email" style="margin:0;" value="<?php echo $correo; ?>">
                            </div>
                            <div class="col-50">
                               
                        <label for="telefono" class="label-margin"><i class="fa fa-phone"></i> Telefono</label>
                        <input type="text" class="form-control-sm"id="telefono" name="telefono" style="margin:0;" placeholder="" value="<?php echo $telefono; ?>">
                            </div>
                        </div>
 <?php echo $retiro_tienda; ?>

<div class="form-group" style="margin-top: 15px;">
   <div class="col-md-15">
      <div class="form-group">
         <div class="col-md-12" >
           
           <select class="form-select" id="metodo_entrega" name="metodo_entrega">
    <option value="Retiro en tienda" <?php if ($retiro_tienda === 'Retiro en tienda') echo 'selected'; ?>>Retiro en tienda</option>
    <option value="Despacho" <?php if ($retiro_tienda === 'Despacho') echo 'selected'; ?>>Despacho</option>
</select>
         </div>
      </div>
   </div>
   <div class="col-md-12" id="detalleretiro" style="<?php if ($retiro_tienda === 'Retiro en tienda') echo 'display: block;'; else echo 'display: none;'; ?>">
      <div class="input-group">
         <div class="input-group-prepend">
            <span class="input-group-text">Fecha</span>
         </div>
         <input class="form-control form-control-solid ps-12 flatpickr-input active" id="detalle_entrega" name="detalle_entrega" type="text" placeholder="Seleccionar Fecha" <?php if ($retiro_tienda === 'Retiro en tienda') echo 'value="' . $detalle_entrega . '"'; ?> >
      </div>
   </div>
</div>
                        
                <script>
    flatpickr('#detalle_entrega', {
        enableTime: true,
        minTime: "09:00",
    maxTime: "18:00",
        minDate: "today",
        dateFormat: "Y-m-d H:i",
       
        // Otions adicionales de configuración si las necesitas
    });
             


 var retiroTiendaSelect = document.getElementById('retiro_tienda');
var detalleretiro = document.getElementById('detalleretiro');


retiroTiendaSelect.addEventListener('change', function() {
  if (retiroTiendaSelect.value === 'Retiro en tienda') {
    swal.fire("", "Cliente retira en tienda, debes especificar la fecha de retiro", "success");

    detalleretiro.style.display = 'block';
  } else {
    detalleretiro.style.display = 'none';
   
  }
});
                       
</script>            

                      
                 


                       <div id="dat">
                       </div>

                        <label for="direccion" class="label-margin"><i class="fa fa-address-card-o"></i> Direccion</label>
                         <input type="text" class="form-control-sm" id="direccion" name="direccion" style="margin:0;" placeholder="" value="<?php echo $direccion; ?>">

                         <div class="row">
                            <div class="col-50">
                                <label for="numero" class="label-margin">Numero</label>
                                <input type="text" class="form-control-sm"id="numero" name="numero" style="margin:0;" placeholder="" value="<?php echo $numero; ?>">
                            </div>
                            <div class="col-50">
                                <label for="dpto" class="label-margin">Dpto/casa</label>
                                <input type="text" class="form-control-sm"id="dpto" name="dpto" placeholder="" style="margin:0;" value="<?php echo $dpto; ?>">
                            </div>
                        </div>
                         <div class="row">
                            <div class="col-50">
                        <label for="direccion" class="label-margin"><i class="fa fa-address-card-o"></i> Region</label>
                         <input type="text" class="form-control-sm" id="region" name="region" style="margin:0;" placeholder="" value="<?php echo $region; ?>">
                           </div>
                         <div class="col-50">
                        <label for="comuna" class="label-margin"><i class="fa fa-institution" class="label-margin"></i> Comuna</label>
                               <input type="text" class="form-control-sm" id="comuna" name="comuna" placeholder="" style="margin:0;" value="<?php echo $comuna; ?>">
                          </div>
                        </div>
         


                            <div class="row">
                            <div class="col-50">
                        
                                 <label for="instagram" class="label-margin">Canal de Contacto</label>
                                <input type="text" class="form-control-sm"id="instagram" name="instagram" placeholder="814111" style="margin:0;" value="<?php echo $instagram; ?>">
                            </div>
                          
                         <div class="col-50">
                            <!-- Poner otro input -->
                              </div>
                            </div>
                                
                 

                        <div class="row">
                           <div class="col-50">
                                 <label for="abono" class="label-margin">Precio</label>
                                 <input type="text" class="form-control-sm"id="precio" name="precio"  style="margin:0;" value="<?php echo $precio; ?>">
                            </div>
                            <div class="col-50">
                                 <label for="abono" class="label-margin">Abono</label>
                                 <input type="text" class="form-control-sm"id="abono" name="abono"  style="margin:0;" value="<?php echo $abono; ?>">
                            </div>
                        </div>


                         <div class="row">
                         <div class="col-50">
                                 <label for="pagado" class="label-margin">¿Producto Pagado?</label>


                         <select id="pagado" name="pagado" class="form-select" aria-label="Pagado" required>                  
                              <option value="0" style="background-color: red;" <?php if($pagado == '0') echo 'selected'; ?>>NO PAGADO</option>                  
                              <option value="1" style="background-color: green;" <?php if($pagado == '1') echo 'selected'; ?>>PAGADO</option>                              
                            </select>
                            </div>
                            <div class="col-50">
                                Forma de pago
                            <select id="mododepago" name="mododepago" class="form-select" aria-label="Modo de Pago" required>  
                              <option value="transferencia" <?php if($mododepago == 'transferencia') echo 'selected'; ?>>Transferencia</option>                  
                              <option value="efectivo" <?php if($mododepago == 'efectivo') echo 'selected'; ?>>Efectivo</option>
                              <option value="debito" <?php if($mododepago == 'debito') echo 'selected'; ?>>Debito</option>
                              <option value="credito" <?php if($mododepago == 'credito') echo 'selected'; ?>>Credito</option>
                            </select>
                            </div>
                        </div>



                          
                         

                              
                               
                                <?php if($pagado == "1") {?>
                                    <div class="alert alert-warning" role="alert" style=" font-size: 14px; padding:0; margin:0;"><i class="fa fa-warning"></i> <b>Importante: </b> El producto ya esta pagado. Indicar total por pagar.<br>-Poner 0 si no debe nada</div>
                               
                              
                                <input type="text" class="form-control-sm"id="por_pagar" name="por_pagar" placeholder="0" style="margin:0;" value="0">


                            <?php  }else { ?>
                                <input type="hidden" class="form-control-sm"id="por_pagar" name="por_pagar" placeholder="0" style="margin:0;" value="0">
                            <?php  } ?>
                         

                            
                        
                            
                            Fecha de entrega estimada o programada
                            <input type="date" name="fecha_entrega" class="form-control-sm" value="<?php echo date('Y-m-d', strtotime($fecha_entrega)); ?>">
                
                            <label for="pagado" class="label-margin">Tienes que agregar un detalle a fabricacion?</label>                        
                            <div >
                            <textarea class="form-control" name="detalles_fabricacion" rows="6" placeholder="Información adicional para la entrega."><?php echo $detalle_fabricacion ?></textarea>
                            </div>
                            <label for="pagado" class="label-margin">Tienes que agregar un comentario interno?</label>                        
                            <div >
                            <textarea class="form-control" name="comentarios_nuevo" rows="6" placeholder="Información adicional para la entrega."><?php echo $comentarios ?></textarea>
                            </div>


                        
                        
                        
                       
                    </div>



                    <div class="col-50">
                        <h3>Pedido Nuevo</h3>
                        <label for="fname">Ingresa todo nuevo</label>
                        
                           <label> Que producto quieres agregar?</label>
                            <select id="status" name="status" class="form-select" onChange="mostrar2(this.value)">
                              <option value="respaldo" >Seleccionar producto</option>
                                <option value="respaldo">Respaldos de Cama</option>
                                <option value="colchon">Colchones</option>
                                <option value="base">Base de Cama</option>
                                <option value="patas">Patas de cama</option>
                                <option value="banquetas">Banquetas</option>
                                <option value="fundas">Fundas</option>
                                <option value="living">Living</option>
                               
                             </select>
                        


                        <div id="formularios" style="display: none;"> </div>


                       
                    </div>

                </div>
                
                 <button type="submit"  id="botonenviar" class="btn btn-primary">Enviar Datos de compra</button>
               

              
            </form>
            </form>
        </div>
    </div>
    <div class="col-25">
        <div class="container" style="background-color: #CCE2FF;">
            <h4>Pedido Anterior </h4>
            <p>Modelo: <span class="texto"><?php echo $modelo; ?></span></p>
            <p>Plazas: <span class="texto"><?php echo $plazas; ?></span></p>
            <p>Altura Base: <span class="texto" ><?php echo $alturabase; ?></span></p>
            <p>Anclaje: <span class="texto" ><?php echo $anclaje; ?></span></p>
            <p>Material: <span class="texto" ><?php echo ucfirst($tipo_tela); ?></span></p>
            <p>Color: <span class="texto" ><?php echo $color; ?></span></p>
            
            <hr>
            <p>Total <span class="Precio" style="color:black"><b>$<?php echo $precio; ?></b></span></p>
        </div>
    </div>
</div>
    

<!--FIN del cont principal-->
<?php require_once "vistas/parte_inferior.php"?>