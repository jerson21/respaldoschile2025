<?php require_once "init.php" ?>
<?php require_once "vistas/parte_superior.php"?>

<!--INICIO del cont principal-->

<h1>Validar Pagos de Pedidos</h1>
    <div class="row mt-5"> 
            <div class="col-sm-12 col-md-5 subir"> 
                <form enctype="multipart/form-data" action="rutinas/subirarchivo.php" method="POST"> 
                    <input type="hidden" name="MAX_FILE_SIZE" value="300000000" /> 
                    <h5><i class="fa fa-file"></i> Seleccione la cartola a subir: </h5> 
                    <hr/>
                    <input name="fichero_usuario" type="file" accept=".xls,.xlsx" />
                    <button class="btn btn-success mt-2" type="submit"><i class="fa fa-upload"></i> Subir Cartola</button> 
                </form> 
            </div>

            <div class="col-sm-12 col-md-5  archivos"> 
                <h5><i class="fa fa-archive "></i> Cartolas cargadas al servidor</h5> 
                <hr/> 
                <?php $carpeta = glob('leerpagos/libro1.xls'); 
                echo "<table class='table-responsive' border='1'>"; 
                echo "<tr>
                <th>
                <h6>Nombre de Cartola</h6>
                </th> 
                
                 <th>
                <h6>Fecha</h6>
                </th>
                </tr>";
                foreach($carpeta as $archivo){
                    $fecha = filemtime($archivo);

                    $porciones = explode("/", $archivo);
                    echo "<tr>";
                    echo "<td>" . $porciones[1].  "</td>";
                    echo "<td>"  .date("Y-m-d H:i:s", $fecha) . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                ?>
            </div>
        </div><br>
<div style="padding: 5px;">
    
    <div class="row" style="width:600px;">
        <label style="font-weight:bold">Rutas Disponibles </label>
        <div class="col">
    <form action="" method="GET">
    <?php 
                        include_once 'bd/conexion.php';
                        error_reporting(0);
                        $objeto1 = new Conexion();
                        $conexion = $objeto1->Conectar();

                        $consulta = "SELECT *  from rutas ";
                        $resultado = $conexion->prepare($consulta);
                        $resultado->execute();
                        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);


$cadena=" 
      <select class='form-select form-select-s' style='width:400px;' id='ruta' name='ruta' >
<option value='-1'>Seleccionar una ruta</option> ";
  foreach ($data as $ver) {
    $fecha = $ver['fecha'];
    $idruta = $ver['id'];
    $fecha = fechaCastellano($fecha);

    

$consulta2 = "SELECT comuna from pedido_detalle where ruta_asignada = $idruta group by comuna";
$resultado = $conexion->prepare($consulta2);
$resultado->execute();
$data2=$resultado->fetchAll(PDO::FETCH_ASSOC);


 $comuna = "";

            foreach ($data2 as $ver2) {    $comuna .= ', '.strtoupper($ver2['comuna']);  }

        if($ver['id'] == $_GET['ruta']){    $cadena=$cadena.'<option selected="selected" value='.$ver['id'].'>'.$ver['id'].' - '.$fecha.'</option>';}
        else{    $cadena=$cadena.'<option value='.$ver['id'].'>'.$ver['id'].' - '.$fecha.'</option>';}
            
    }  
  echo  $cadena."</select> <br><br>";
  ?>
</div>
  <?php

                              function fechaCastellano ($fecha) {
                              $fecha = substr($fecha, 0, 10);
                              $numeroDia = date('d', strtotime($fecha));
                              $dia = date('l', strtotime($fecha));
                              $mes = date('F', strtotime($fecha));
                              $anio = date('Y', strtotime($fecha));
                              $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
                              $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
                              $nombredia = str_replace($dias_EN, $dias_ES, $dia);
                            $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                              $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
                              $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
                              return $nombredia." ".$numeroDia." de ".$nombreMes." de ".$anio;
                            }
        ?>

        <div class="col">
<input class="btn btn-primary"  type="submit" value="Consultar">
</div>
</div>
        </form>
    





<!-- 

    <form action="" method="post">
     <input type="submit" class="btn btn-warning" value="Validación Manual">
     <input type="hidden"  name="ruta_" value="<?php echo $_GET['ruta'] ?>">
        </form>

-->

 <?php

if(isset($_POST['ruta_'])){
    $ruta_ = $_POST['ruta_'];

    if($ruta_ != 0){
    $consulta = "UPDATE pedidos SET estadopedido='4' WHERE ruta_asignada='$ruta_'";    // ACTUALIZA A 4 NUMERO QUE INDICA PEDIDO DESPACHADO  
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

echo '<script language="javascript">alert("Ruta Escaneada");</script>';
}
else{
echo '<script language="javascript">alert("Por favor Seleccione Ruta");</script>';

}

}

 





$numero_ruta = $_GET['ruta'];
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$consulta = "SELECT * FROM pedido p INNER JOIN clientes c ON p.rut_cliente = c.rut
INNER JOIN pedido_detalle pd ON pd.num_orden = p.num_orden where ruta_asignada = $numero_ruta ORDER BY modelo";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data=$resultado->fetchAll(PDO::FETCH_ASSOC);


$consulta2 = "SELECT * FROM pedido p INNER JOIN clientes c ON p.rut_cliente = c.rut
INNER JOIN pedido_detalle pd ON pd.num_orden = p.num_orden GROUP BY p.num_orden HAVING COUNT(p.num_orden) > 1 ORDER BY p.num_orden asc";

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
<div class="container" style="float:left; padding: 15px;   ">
        <div class="row">
                <div class="col-lg-12" >
                    <div class="table-responsive" style="margin:0; width: 100rem;">        
                        <table id="tablavalidarpagos" class="table table-striped custom-table" style="width:100%; font-size:0.8rem; ">
                        <thead class="text-center">
                            <tr>

                           
                                <th style="max-width:1rem; ">Id</th>
                                <th style="width:3rem;">Rut Cliente</th>
                                <th style="max-width:5rem;">Nombre</th>
                                <th style="width:7rem;">Modelo</th>                                
                                <th style="max-width:2rem;">Plazas</th>  
                                <th style="max-width:1rem;">Alt</th>
                                
                                <th style="width:4rem;">Color</th>
                                 <th style="width:10rem;">Direccion</th>
                                  <th style="width:2rem;">Telefono</th>
                                   <th style="width:3rem;">Modo Pago</th>
                                   <th style="width:1rem;">Precio</th>
                                   <th style="width:1rem;">Pagado</th>
                                
                                <th style="width:6rem;">Estado Pedido</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php                            
                            foreach($data as $dat) {                                                        
                            ?>
                            <tr>
<?php
$numerodeorden = $dat['num_orden'];
$style = "";
    if($dat['pagado'] == "1"){ $style = "background-color:#ADFFAD;";}
if (in_array($numerodeorden, $numeros_deorden)) { ?>
                                
                                <td style="height:10px; padding: 1px; background-color: rgba(0, 145, 71, 0.1); <?= $style ?>" title="Numero de orden tiene mas de un pedido"><?php echo $dat['id']; ?></td>
                                <td style="height:10px; padding: 1px; background-color: rgba(0, 145, 71, 0.1);<?= $style ?>" title="Numero de orden tiene mas de un pedido"><?php echo $dat['rut_cliente']; ?></td>
<?php }else{

    ?>
                               
                                
                                <td style="height:10px; padding: 1px; <?= $style ?>"><?php echo $dat['id']; ?></td>
                                <td style="height:10px; padding: 1px; <?= $style ?>"><?php echo $dat['rut_cliente']; ?></td>

<?php }


?>
                                
                                 <td style="height:10px; padding: 1px; font-weight: bold;<?= $style ?>"><?php echo $dat['nombre'] ?></td>
                                <td style="height:10px; padding: 1px;<?= $style ?>"><?php echo $dat['modelo'] ?></td>
                                <td style="height:10px; padding: 1px;<?= $style ?>"><?php echo $dat['tamano'] ?></td> 
                                <td style="height:10px; padding: 1px;<?= $style ?>"><?php echo $dat['alturabase'] ?></td>
                               
                                <td style="height:10px; padding: 1px;<?= $style ?>" ><?php echo $dat['color'] ?></td>
                                <td style="height:10px; padding: 1px;<?= $style ?>"><?php echo $dat['direccion']; ?> <?php echo $dat['numero']; ?> , <?php echo $dat['comuna']; ?></td>
                                 <td style="height:10px; padding: 1px;<?= $style ?>" ><?php echo $dat['telefono'] ?></td>
                                  <td style="height:12px; padding: 1px;<?= $style ?>" ><?php echo $dat['mododepago'] ?></td>
                                  <td style="height:10px; padding: 1px; font-weight:bold;<?= $style ?>">$<?php echo $dat['precio'] ?></td>
                                  <td style="height:10px; padding: 1px;<?= $style ?>">
                                  <?php if($dat['pagado'] == "1"){
                                   echo "<div class='text-center' ><div class='btn-group' ><button class='btn btn-primary'  style='font-size:0.8rem;max-height:1.5rem; line-height:12px;$'>Pagado</button></div>";
                                }elseif($dat['pagado'] != "1"){
                                    echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-danger' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>No Pagado</button></div>";
                                     }

                                     ?>


                              </td>

                                
                                <td style="height:10px; padding: 1px;"><?php 





                                if($dat['formadepago'] == "15"){
                                    echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-success btnEditarpago' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Efectivo</button></div>";
                                }
                                elseif($dat['formadepago'] == "16"){
                                    echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-success btnEditarpago' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Debito</button></div>";
                                }
                                elseif($dat['formadepago'] == "17"){
                                    echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-success btnEditarpago' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Credito</button></div>";
                                }
                                elseif($dat['formadepago'] == "18"){
                                    echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-success btnEditarpago' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Transferencia</button></div>";
                                }
                                elseif($dat['formadepago'] == "19"){
                                    echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-success btnEditarpago' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Transferencia</button></div>";
                                }
                                elseif($dat['formadepago'] == "4"){
                                    echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-warning btnEditarpago' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Por Pagar</button></div>";
                                }
                                elseif($dat['formadepago'] == "pagado"){
                                    echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-success btnEditarpago' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>pagado</button></div>";
                                }

                                elseif($dat['formadepago'] == "" or $dat['formadepago']== 0){
                                    echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-warning btnEditarpago' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Por Pagar</button></div>";
                                }






                            ?></td>   
                                
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
        <form id="editarpago">    
            <div class="modal-body">

                <div class="form-group">
                    <input type="hidden" class="form-control" id="montoapagar" name="montoapagar" readonly>
                    <div class="form-group row">
    <label for="id" class="col-sm-2 col-form-label">Cod:</label>
    <div class="col-sm-6">
        <input type="text" class="form-control" id="id" name="id" readonly>
        <input type="hidden" class="form-control" id="telefono" name="telefono" readonly>
        <input type="hidden" class="form-control" id="pagado" name="pagado" readonly>
    </div>
    <div class="col-sm-4">
        <a href="#" id="whatsapp-link" target="_blank">
            <img src="img/whatsapp.png" alt="WhatsApp" width="50" id="whatsapp" data-toggle="tooltip" data-placement="right" title="Puedes hablarle al whatsapp">
        </a>
    </div>
</div>
           

<script>

    
    // Obtener el elemento del campo de teléfono
    var telefonoInput = document.getElementById("telefono");
    var pagadoInput = document.getElementById("pagado");

   
    
    // Obtener el elemento del enlace de WhatsApp
    var whatsappLink = document.getElementById("whatsapp-link");
    
    // Agregar un evento de clic al enlace de WhatsApp
    whatsappLink.addEventListener("click", function(event) {
        
        // Obtener el número de teléfono del campo de entrada
        var telefono = telefonoInput.value;
        var pagado = pagadoInput.value;
        if(pagado === "Pagado"){
        texto = "&text=¡Gracias por su compra! ¿Todo bien con su pedido? 😊🎁";
    }else{
        texto = "&text=Hola!";
    }
        
        // Construir la URL del enlace de WhatsApp con el número de teléfono
        var url = "https://api.whatsapp.com/send/?phone=+56" + telefono + texto;
        
        
        // Establecer la URL del enlace de WhatsApp
        whatsappLink.href = url;
    });
</script>

                 <input type="hidden" class="form-control" id="rut" name="rut" readonly>
                </div>
                <div class="form-group">
                <select name="pago" id="pago" class="form-control" >
                    <option value=""  selected>Selecciona Pago</option>
                    <option value="15">Efectivo</option>
                    <option value="16">Debito</option>
                    <option value="17">Credito</option>
                    <option value="18">Transferencia</option>
                    <option value="19">Webpay</option>
                    <option value="4">Por Pagar</option>
                  </select>
                </div>  
                <hr>              
                      <div style=" display:inline-block;    color:#444;    border:1px solid #CCC;    background:#DDD;    box-shadow: 0 0 5px -1px rgba(0,0,0,0.2);    cursor:pointer;    vertical-align:middle;    max-width: 150px;    padding: 5px;    text-align: center;" onclick="consultar();"> Consultar Pago </div> 
                        <hr>
                      <script type="text/javascript">  
                              
                    
                                
                            </script>

                       <div class="form-group row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Fecha</label>
                         <div class="col-sm-9"> <input type="text" class="form-control" id="resultados" name="resultados" readonly> </div>
                         <label for="staticEmail" class="col-sm-3 col-form-label">Nombre</label>
                       <div class="col-sm-9"> <input type="text" class="form-control" id="resultados2" name="resultados2" readonly></div>
                       <label for="staticEmail" class="col-sm-3 col-form-label">Monto</label>
                        <div class="col-sm-9"> <input type="text" class="form-control" id="resultados3" name="resultados3" readonly></div>
                        <label for="staticEmail" class="col-sm-3 col-form-label">Banco</label>
                        <div class="col-sm-9">  <input type="text" class="form-control" id="resultados4" name="resultados4" readonly></div>
                        <label for="staticEmail" class="col-sm-3 col-form-label">Codigo</label>
                        <div class="col-sm-9">  <input type="text" class="form-control" id="resultados5" name="resultados5" readonly></div>
                      </div>
 <hr> 
                      <div id="buscar_id" style="display:none">
                        
                          
                          
                            <label>  Buscar por id de transacción:</label><br>
                           <input id="id_transaccion" type="text" onchange="consultarporId(this)" size="25" placeholder="Ingresa aqui los ultimos digitos">            
                       
                
                        

                        </div>
<hr>
                          <div id="buscar_cuenta" style="display:none">
                         
                           <label>   Buscar por Nº cuenta:</label>
                          
                           <input id="numero_cuenta" type="text" onchange="consultarporNumeroCuenta(this)"  placeholder="Ingresa numero">            
                       
                
                        

                        </div>
<hr>
<div id="buscar_nombre" style="display:none">
                         
                           <label>   Buscar por Nombre:</label>
                          
                           <input id="nombre" type="text" onchange="consultarporNombre(this)"  placeholder="Ingresa Nombre">            
                       
                  
                        

                        </div>
<hr>



                       

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>

                <button type="submit" id="btnGuardar"  class="btn btn-dark">Guardar</button>
            </div>
        </form>    
        </div>


    </div>
</div>  

<script type="text/javascript">
    function consultar(){ 
                          rut_consulta= document.getElementById('rut').value;
                          montoapagar= document.getElementById('montoapagar').value;
                            
                    

                    let rut = rut_consulta;

                     let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = 'leerpagos/?rut='+rut+'&monto='+montoapagar; 
       
        request.open("POST",ajaxUrl,true);
        request.send();
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                let objData = JSON.parse(request.responseText);
                if(objData.nombre)
                {

                  
                                $("#resultados").val(objData.fecha);
                                $("#resultados2").val(objData.nombre);
                                $("#resultados3").val(objData.monto);
                                $("#resultados4").val(objData.banco);
                                $("#resultados5").val(objData.id_transferencia);

                                if(objData.nombre === "NO EXISTEN PAGOS"){

                                    document.getElementById('buscar_id').style.display = "block";
                                     document.getElementById('buscar_cuenta').style.display = "block";
                                      document.getElementById('buscar_nombre').style.display = "block";
                                }
                               
                }else{
                    swal("Error", objData.msg , "error");
                }
            }
         }

          }

          document.addEventListener("DOMContentLoaded", function() {
              document.getElementById("enviar_id").addEventListener('submit', consultarporId); 
            });


     function consultarporId(id_transaccion){ 
                        
                         var id_transaccion = document.getElementById('id_transaccion').value;
                    

                    let rut = rut_consulta;

                     let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = 'leerpagos/porid.php?id='+id_transaccion; 
       
        request.open("POST",ajaxUrl,true);
        request.send();
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                let objData = JSON.parse(request.responseText);
                if(objData.nombre)
                {

                  
                                $("#resultados").val(objData.fecha);
                                $("#resultados2").val(objData.nombre);
                                $("#resultados3").val(objData.monto);
                                $("#resultados4").val(objData.banco);
                                $("#resultados5").val(objData.id_transferencia);

                                if(objData.nombre === "NO EXISTEN PAGOS"){

                                    document.getElementById('buscar_id').style.display = "block";
                                }
                               
                }else{
                    swal("Error", objData.msg , "error");
                }
            }
         }

          }

          function consultarporNumeroCuenta(id_transaccion){ 
                        
                         var id_transaccion = document.getElementById('numero_cuenta').value;
                    

                    let rut = rut_consulta;

                     let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = 'leerpagos/pornumero.php?id='+id_transaccion; 
       
        request.open("POST",ajaxUrl,true);
        request.send();
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                let objData = JSON.parse(request.responseText);
                if(objData.nombre)
                {

                  
                                $("#resultados").val(objData.fecha);
                                $("#resultados2").val(objData.nombre);
                                $("#resultados3").val(objData.monto);
                                $("#resultados4").val(objData.banco);
                                $("#resultados5").val(objData.id_transferencia);

                                if(objData.nombre === "NO EXISTEN PAGOS"){

                                    document.getElementById('buscar_id').style.display = "block";
                                }
                               
                }else{
                    swal("Error", objData.msg , "error");
                }
            }
         }

          }

function consultarporNombre(id_transaccion){ 
                        
                         var id_transaccion = document.getElementById('nombre').value;
                    

                    let rut = rut_consulta;

                     let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = 'leerpagos/pornombre.php?rut='+id_transaccion; 
       
        request.open("POST",ajaxUrl,true);
        request.send();
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                let objData = JSON.parse(request.responseText);
                if(objData.nombre)
                {

                  
                                $("#resultados").val(objData.fecha);
                                $("#resultados2").val(objData.nombre);
                                $("#resultados3").val(objData.monto);
                                $("#resultados4").val(objData.banco);
                                $("#resultados5").val(objData.id_transferencia);

                                if(objData.nombre === "NO EXISTEN PAGOS"){

                                    document.getElementById('buscar_id').style.display = "block";
                                }
                               
                }else{
                    swal("Error", objData.msg , "error");
                }
            }
         }

          }






                
            


</script>
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
                <label for="color" class="col-form-label">Precio:</label>
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