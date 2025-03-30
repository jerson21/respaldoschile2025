<?php require_once "vistas/parte_superior.php"?>

<!--INICIO del cont principal-->


<style type="text/css">
	.register{
    background: -webkit-linear-gradient(left, #3931af, #00c6ff);
    margin-top: 3%;
    padding: 3%;

}
.register-left{
    text-align: center;
    color: #fff;
    margin-top: 4%;
}
.register-left input{
    border: none;
    border-radius: 1.5rem;
    padding: 2%;
    width: 60%;
    background: #f8f9fa;
    font-weight: bold;
    color: #383d41;
    margin-top: 30%;
    margin-bottom: 3%;
    cursor: pointer;
}
.register-right{
    background: #f8f9fa;
    border-top-left-radius: 10% 50%;
    border-bottom-left-radius: 10% 50%;
}
.register-left img{
    margin-top: 15%;
    margin-bottom: 5%;
    width: 25%;
    -webkit-animation: mover 2s infinite  alternate;
    animation: mover 1s infinite  alternate;
}
@-webkit-keyframes mover {
    0% { transform: translateY(0); }
    100% { transform: translateY(-20px); }
}
@keyframes mover {
    0% { transform: translateY(0); }
    100% { transform: translateY(-20px); }
}
.register-left p{
    font-weight: lighter;
    padding: 12%;
    margin-top: -9%;
}
.register .register-form{
    padding: 10%;
    margin-top: 10%;
}
.btnRegister{
    float: right;
    margin-top: 10%;
    border: none;
    border-radius: 1.5rem;
    padding: 2%;
    background: #0062cc;
    color: #fff;
    font-weight: 600;
    width: 50%;
    cursor: pointer;
}
.register .nav-tabs{
    margin-top: 3%;
    border: none;
    background: #0062cc;
    border-radius: 1.5rem;
    width: 28%;
    float: right;
}
.register .nav-tabs .nav-link{
    padding: 2%;
    height: 34px;
    font-weight: 600;
    color: #fff;
    border-top-right-radius: 1.5rem;
    border-bottom-right-radius: 1.5rem;
}
.register .nav-tabs .nav-link:hover{
    border: none;
}
.register .nav-tabs .nav-link.active{
    width: 120px;
    color: #0062cc;
    border: 2px solid #0062cc;
    border-top-left-radius: 1.5rem;
    border-bottom-left-radius: 1.5rem;
}
.register-heading{
    text-align: center;
    margin-top: 8%;
    margin-bottom: -15%;
    color: #495057;
}
</style>
<div class="container register">
                <div class="row">
                    <div class="col-md-3 register-left">
                        <img src="img/logoblanco.png" width="80" alt=""/>
                        <h3>Contabilidad</h3>
                        <p>Registro de Costos!</p>
                        <input type="submit" name="" value="2021"/><br/>
                    </div>
                    <div class="col-md-9 register-right">
                        <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                            <?php if($_SESSION["privilegios"] >= "2"){  ?>
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Ingresos</a>
                            </li>
                        <?php } ?>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Gastos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="precios-tab" data-toggle="tab" href="#precios" role="tab" aria-controls="precios" aria-selected="false">Precios</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="resumen-tab" data-toggle="tab" href="#resumen" role="tab" aria-controls="resumen" aria-selected="false">Resumen</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                                <h3 class="register-heading">Registro de ingresos</h3>


                                <div class="container" style="padding: 100px;">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-0">
                	<form action="" method="GET">
                	<?php 
include_once 'bd/conexion.php';
$objeto1 = new Conexion();
$conexion = $objeto1->Conectar();

$consulta = "SELECT *  from rutas";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data=$resultado->fetchAll(PDO::FETCH_ASSOC);





  


  $cadena="<label>Rutas Disponibles </label><br> 
      <select  id='ruta' name='ruta'>
<option value='-1'>Seleccionar una ruta</option> ";
  foreach ($data as $ver) {
    $fecha = $ver['fecha'];
    $idruta = $ver['id'];
    $fecha = fechaCastellano($fecha);

    

  $consulta2 = "SELECT comuna from pedidos where ruta_asignada = $idruta group by comuna";
$resultado = $conexion->prepare($consulta2);
$resultado->execute();
$data2=$resultado->fetchAll(PDO::FETCH_ASSOC);


 $comuna = "";

   foreach ($data2 as $ver2) {
    $comuna .= ', '.strtoupper($ver2['comuna']);
    
  }
if($ver['id'] == $_GET['ruta']){

	$cadena=$cadena.'<option selected="selected" value='.$ver['id'].'>'.$ver['id'].' - '.$fecha.'</option>';
}
else{
	$cadena=$cadena.'<option value='.$ver['id'].'>'.$ver['id'].' - '.$fecha.'</option>';
}
    
  }

  
  echo  $cadena."</select><br><br>";

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
<input type="submit" value="Consultar">
        </form>
        <br>
                    
 <div class="row p-3" style="margin:0 auto; ">Información de Ruta</div>
                    <hr class="my-5">

                    <div class="row pb-5 p-5">
                        <div class="col-md-6">
                            <p class="font-weight-bold mb-4">Información de Ruta</p>
                            <p class="mb-1">Fecha: <?php $fecha; ?></p>
                            
                            <p class="mb-1">Despachador:  <?php $fecha; ?></p>
                            
                        </div>

                        <div class="col-md-6 text-right">
                            <p class="font-weight-bold mb-4">Productos</p>
                            <p class="mb-1"><span class="text-muted">Cantidad: </span> 20</p>
                            <p class="mb-1"><span class="text-muted">Debito: </span> 1</p>
                            <p class="mb-1"><span class="text-muted">Creditos: </span> 5</p>
                            <p class="mb-1"><span class="text-muted">Efectivos: </span> 3</p>
                        </div>
                    </div>

                    <div class="row p-5">
                        <div class="col-md-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="border-0 text-uppercase small font-weight-bold">ID</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">Producto</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">Tamaño</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">Cantidad</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">Precio</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">Modo Pago</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                    	<?php 
                                    	

                                    	$ruta = $_GET['ruta'];
                                    	$objeto = new Conexion();
$conexion = $objeto->Conectar();
                                    	$consultar = "SELECT * FROM pedidos WHERE ruta_asignada = $ruta";
        $resultado2 = $conexion->prepare($consultar);
        $resultado2->execute();

        $data = $resultado2->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($data as $dat) { 
                echo "<tr>";
                echo "<td>".$dat['id']."</td>";
                echo "<td>".$dat['modelo']."</td>";
               	echo "<td>".$dat['plazas']."</td>";
              	echo "<td>".$dat['cantidad']."</td>";
              	echo "<td>$".$dat['precio']."</td>";
              	echo "<td>".$dat['mododepago']."</td>";
                
                echo "</tr>";
                $total +=$dat['precio'];
                if($dat['mododepago'] == "debito" || $dat['mododepago'] == "credito"){
                	$debito +=$dat['precio'];

                }
                if($dat['mododepago'] == "transferencia"){
                	$transferencia +=$dat['precio'];

                }
                if($dat['mododepago'] == "efectivo"){
                	$efectivo +=$dat['precio'];

                }

        }
        ?>
                  

                  <?php 
                                        

                                        $ruta = $_GET['ruta'];
                                        $objeto = new Conexion();
$conexion = $objeto->Conectar();
                                        $consultar = "SELECT * FROM pedidos as p inner join rutas as r on p.ruta_asignada = r.id where MONTH(r.fecha)=MONTH(CURDATE()) order by mododepago";
        $resultado2 = $conexion->prepare($consultar);
        $resultado2->execute();

        $data = $resultado2->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($data as $dat) { 
               //echo $dat['fecha'].' '.$dat['precio'].' '.$dat['mododepago'].' <br>';
                $totales +=$dat['precio'];
                if($dat['mododepago'] == "debito" || $dat['mododepago'] == "credito"){
                    $debitos +=$dat['precio'];

                }
                if($dat['mododepago'] == "transferencia"){
                    $transferencias +=$dat['precio'];

                }
                if($dat['mododepago'] == "efectivo"){
                    $efectivos +=$dat['precio'];

                }

        }
        ?>                     
                                        
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="d-flex flex-row-reverse bg-dark text-white p-4">
                        <div class="py-3 px-5 text-right">
                            <div class="mb-2">Total</div>
                            <div class="h2 font-weight-light"><?php 
setlocale(LC_MONETARY, 'es_CL');
echo money_format('%i', $total) ?></div>
                        </div>

                        <div class="py-3 px-4 text-right">
                            <div class="mb-2">Efectivos</div>
                            <div class="h2 font-weight-light"><?php echo $efectivo; ?></div>
                        </div>

                        <div class="py-3 px-4 text-right">
                            <div class="mb-2">Transferencias</div>
                            <div class="h2 font-weight-light"><?php echo $transferencia; ?></div>
                        </div>
                        <div class="py-3 px-4 text-right">
                            <div class="mb-2">Deb / cred</div>
                            <div class="h2 font-weight-light"><?php echo $debito; ?></div>
                        </div>
                    </div>

                   
                </div>
            </div>
        </div>
    </div>
   <br><div style="font-size: 18px; margin:0 auto; text-align: center;"> <span >Total Mes Actual</span></div>
 <div class="d-flex flex-row-reverse bg-dark text-white p-5">
                        <div class="py-3 px-5 text-right">
                            <div class="mb-2">Total</div>
                            <div class="h2 font-weight-light"><?php 
setlocale(LC_MONETARY, 'es_CL');
echo money_format('%i', $totales) ?></div>
                        </div>

                        <div class="py-3 px-4 text-right">
                            <div class="mb-2">Efectivos <?php echo $efectivos; ?></div>
                           
                        </div>

                        <div class="py-3 px-4 text-right">
                            <div class="mb-2">Transferencias <?php echo $transferencias; ?></div>
                            
                        </div>
                        <div class="py-3 px-4 text-right">
                            <div class="mb-2">Deb / cred <?php echo $debitos; ?></div>
                            
                        </div>

                    </div>


    <div class="text-light mt-5 mb-5 text-center small">by : <a class="text-light" target="_blank" href="http://totoprayogo.com"></a></div>

</div>


                            </div>
                            <div class="tab-pane fade show" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <h3  class="register-heading">Ingreso de Gastos</h3>
                                <div class="row register-form">
                                    <div class="col-md-10">
                                        <form method="post" action="ingresar_gastos.php">
                                        <div class="form-group">
                                           Monto <input type="text" name="monto" class="form-control" placeholder="$" value="" autocomplete="no" />
                                        </div>
                                        
                                         <div class="col-md-15">
                                            Detalle<textarea class="form-control" name="detalle" rows="5"></textarea>
                                         </div><br>
                                        <div class="col-md-6">
                                        <input type="submit" name="ingresar" class="btn btn-primary mb-2" value="ingresar">
                                        </div>
                                    </form>
                                    </div>

                                 
                                        

                                       
                                 
                                    <!-- <div class="col-md-6">
                                        
                                        
                                        <div class="form-group">
                                            <select class="form-control">
                                                <option class="hidden"  selected disabled>Please select your Sequrity Question</option>
                                                <option>What is your Birthdate?</option>
                                                <option>What is Your old Phone Number</option>
                                                <option>What is your Pet Name?</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="`Answer *" value="" />
                                        </div>
                                        <input type="submit" class="btnRegister"  value="Register"/>
                                    </div> -->

                                     
                                </div>

                            </div>


								<div class="tab-pane fade show" id="precios" role="tabpanel" aria-labelledby="precios-tab">
                                <h3  class="register-heading">Precios</h3>
                                <div class="row register-form">
                                   
                                    <table class="table">
                                <thead>
                                    <tr>
                                        <th class="border-0 text-uppercase small font-weight-bold">ID</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">Producto</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">1 plaza</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">Full</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">2 plazas</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">Queen</th>
                                         <th class="border-0 text-uppercase small font-weight-bold">King</th>
                                          <th class="border-0 text-uppercase small font-weight-bold">Super King</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <?php 
                                        

                                        
                                        $objeto = new Conexion();
$conexion = $objeto->Conectar();
                                        $consultar = "SELECT * FROM productos";
        $resultado2 = $conexion->prepare($consultar);
        $resultado2->execute();

        $data = $resultado2->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($data as $dat) { 
                echo "<tr>";
                echo "<td>".$dat['id']."</td>";
                echo "<td>".$dat['nombre']."</td>";
                echo "<td>$".$dat['unaplaza']."</td>";
                echo "<td>$".$dat['full']."</td>";
                echo "<td>$".$dat['dosplazas']."</td>";
                echo "<td>$".$dat['queen']."</td>";
                echo "<td>$".$dat['king']."</td>";
                echo "<td>$".$dat['superking']."</td>";
                
                echo "</tr>";
              

        }
        ?>
                                       
                                        
                                </tbody>
                            </table>



                                </div>
                            </div>

<br>
                             <div class="tab-pane fade show" id="resumen" role="tabpanel" aria-labelledby="resumen-tab">
                                <h3  class="register-heading">Resumen de Gastos</h3>
                                <div class="row register-form" style="width: 100%">
                                    <div class="col-md-15">
                                      <table class="table">
                                <thead>
                                    <tr>
                                        <th class="border-0 text-uppercase small font-weight-bold">ID</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">Detalle</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">Monto</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">Fecha</th>
                                        
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <?php                                        

                                    
                                        $consultar = "SELECT * FROM gastos";
        $resultado2 = $conexion->prepare($consultar);
        $resultado2->execute();

        $data = $resultado2->fetchAll(PDO::FETCH_ASSOC);
        $suma = 0;
        foreach($data as $dat) { 
                echo "<tr>";
                echo "<td>".$dat['id']."</td>";
                echo "<td>".$dat['detalle']."</td>";
                echo "<td>$".$dat['monto']."</td>";
                $suma+=$dat['monto'];
                echo "<td>".$dat['fecha']."</td>";
                
                
                echo "</tr>";
              

        }
        ?>
                                       
                                        
                                </tbody>
                            </table>

                                       
                                 
                                    <!-- <div class="col-md-6">
                                        
                                        
                                        <div class="form-group">
                                            <select class="form-control">
                                                <option class="hidden"  selected disabled>Please select your Sequrity Question</option>
                                                <option>What is your Birthdate?</option>
                                                <option>What is Your old Phone Number</option>
                                                <option>What is your Pet Name?</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="`Answer *" value="" />
                                        </div>
                                        <input type="submit" class="btnRegister"  value="Register"/>
                                    </div> -->

                                     
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

            </div>
<!--FIN del cont principal-->
 <?php setlocale(LC_MONETARY, 'es_CL');

                                  
                                  echo "<b>Total de Gastos $".number_format($suma)."</b>"; ?>  
                                    </div>

                                 
                                     
<?php 
$id = 1;
$BD_SERVIDOR = "localhost";
$BD_USUARIO ="cre61650_respaldos21";
$BD_PASSWORD = "respaldos21/";
$BD_NOMBRE = "cre61650_agenda";





$mysqli = new mysqli($BD_SERVIDOR, $BD_USUARIO, $BD_PASSWORD, $BD_NOMBRE);

$mysqli -> set_charset("utf8");

while ($id < 3){
    $dias_trabajados=0;
    $total_final=0;
$resultadoas = $mysqli->query("SELECT * FROM usuarios WHERE id='$id'");

    $rowss = mysqli_fetch_assoc($resultadoas);
$resultadoa = $mysqli->query("SELECT * FROM pedidos where tapicero_id =$id and  MONTH(fecha_fabricacion)=MONTH(CURDATE()) GROUP BY DATE(fecha_fabricacion)");
    while($rows = mysqli_fetch_assoc($resultadoa)) {
$contador=0;
$fecha = $rows['fecha_fabricacion'];

setlocale(LC_TIME, 'es_CO.UTF-8');


$resultadoas = $mysqli->query("SELECT * FROM usuarios WHERE id='$id'");
    $rowss = mysqli_fetch_assoc($resultadoas);
$nombre_tapicero = $rowss['nombres']." ".$rowss['apaterno'];
 $fechas =  "<b>".strtoupper(strftime("%A, %d de %B de %Y", strtotime($rows['fecha_fabricacion'])))."</b>";
$dias_trabajados+=1;



$resultado = $mysqli->query("SELECT * FROM pedidos where tapicero_id=$id and DATE(fecha_fabricacion) = DATE('$fecha') ORDER BY plazas");

while($row = mysqli_fetch_assoc($resultado)) {

$contador+=1;

    $modelo = $row['modelo'];
$plazas = $row['plazas'];

if($plazas == "1" || $plazas == "1 1/2"){
    if($modelo == "Botone"){ $pago = 4000; $total+=4000;    }
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


if($plazas == "2" || $plazas == "Full" || $plazas == "Queen"){
    if($modelo == "Botone"){ $pago = 5000;  $total+=5000;}
    if($modelo == "Liso"){ $pago = 5000; $total+=5000;  }
    if($modelo == "Liso 1.35"){ $pago = 6000; $total+=6000;  }
    if($modelo == "Liso con costuras"){ $pago = 5000; $total+=5000; }
    if($modelo == "Liso con costuras 1.35"){ $pago = 6000; $total+=6000; }
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
    if($modelo == "Capitone"){  $pago = 18000;  $total+=18000;  }
     if($modelo == "Capitone orejas y tachas"){ $pago = 25000; $total+=25000; }
     if($modelo == "Capitone orejas"){ $pago = 22000; $total+=22000; }
    if($modelo == "Botone 3 corridas de botones"){  $pago = 7000;   $total+=7000;   }
    if($modelo == "Botone 4 corridas de botones"){  $pago = 10000;  $total+=10000;  }
    if($modelo == "Base de Cama"){  $pago = 7000; $total+=7000; }
}

}
$total_final+=$total;
$total = 0;

}

$sumasueldos+= $total_final;
echo "Días Trabajados: ".$dias_trabajados." - Total Semana: <b>$".$total_final."</b> - Tapicero: ".$nombre_tapicero.'<br>';

$id+=1;
}
echo 'Sueldos Tapiceros= '.$sumasueldos;

$resultado = $mysqli->query("SELECT * FROM gastos where MONTH(fecha)=MONTH(CURDATE())");

while($row = mysqli_fetch_assoc($resultado)) {


                
                $sumas+=$row['monto'];
                
                
                
               
              

        }
        echo '<br> Gastos del mes: '.$sumas;
?>
<?php require_once "vistas/parte_inferior.php"?>