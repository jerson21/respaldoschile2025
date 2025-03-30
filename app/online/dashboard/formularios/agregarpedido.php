<?php require_once "vistas/parte_superior.php"?>
  <style type="text/css">/* Estilo para el select */
/* Estilo para el select pequeño */
select.form-select-sm {
  height: calc(1.5em + 0.5rem + 2px);
  font-size: 0.875rem;
  padding-top: 0.25rem;
  padding-bottom: 0.25rem;
  border-radius: 0.2rem;
}

/* Estilo para el select grande */
select.form-select-lg {
  height: calc(1.5em + 1rem + 2px);
  font-size: 1.25rem;
  padding-top: 0.5rem;
  padding-bottom: 0.5rem;
  border-radius: 0.3rem;
}

.custom-input {
  font-size: 14px;
  height: 30px;
  border-radius: 5px;
  border: 1px solid #ccc;
  padding: 5px 10px;
}

.custom-input:focus {
  border-color: #007bff;
  box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}


</style>
<!--INICIO del cont principal-->
<main id="main">

    <!-- ======= Breadcrumbs ======= -->


    <!-- ======= Portfolio Details Section ======= -->
   

      <section id="contact" class="contact">

      <div class="container" >
        


      


<?php
$_SESSION["s_usuario"];
include("conexion.php");
if(isset($_GET['num_orden'])) {
  $num_orden = $_GET['num_orden'];

  $strsql1 = "SELECT * FROM pedido p
  INNER JOIN pedido_detalle pd = p.num_orden = pd.num_orden
   WHERE p.num_orden = $num_orden";
    $rs2 = mysqli_query($conn, $strsql1);
    $rowfila = mysqli_fetch_array($rs2);
    
  ?>
  <div class="alert alert-success"><p style="margin-bottom:0;">Ingresando un nuevo producto para la orden Nº: <?php echo $num_orden." Cliente ".$rowfila['rut_cliente'];?></p>
<?php 

    $rs2 = mysqli_query($conn, $strsql1);
       
while( $row1=mysqli_fetch_array($rs2) ) {
  echo "<p style='font-size:0.9rem; margin-bottom:0;'>";
echo "<span style='font-size:0.8rem;font-weight: bold;'>".$row1['id'].". </span>";
if(is_numeric($row1['plazas'])){



   echo $modelo = $row1['modelo']." ".$row1['tamano']." Plazas"." Color: ".$row1['color'];

}
elseif
  ($row1['modelo'] == "Patas de cama"){
  echo $modelo = $row1['modelo']." ".$row1['tipotela']." Cantidad : ".$row1['cantidad'];
}else{
  echo $modelo = $row1['modelo']." ".$row1['tamano']." ".ucfirst($row1['tipotela'])." ". $row1['color'];
}

$direccion = $row1['direccion'];
$telefono = $row1['telefono'];
$numero = $row1['numero'];
$dpto = $row1['dpto'];
$correo = $row1['correo'];
$instagram = $row1['instagram'];
echo "</p>";
}

?>

  </div>


  <?php
    



    $strsql = "SELECT * FROM orden where num_orden = $num_orden";
    $rs = mysqli_query($conn, $strsql);
    $total_rows = $rs->num_rows;
    $data = array();   
while( $row=mysqli_fetch_array($rs) ) {
$rut_cliente = $row['rut_cliente'];
$direccion = $row['direccion'];
$telefono = $row['telefono'];
$numero = $row['numero'];
$dpto = $row['dpto'];
$correo = $row['correo'];
$instagram = $row['instagram'];
}
}
 ?>


<div class="col-md-6"  > 
<form action="#" method="post">
   <label> Que producto quieres agregar?</label>
    <select id="status" name="status" class="form-select" onChange="mostrar(this.value)">
      <option value="respaldo" >Seleccionar producto</option>
        <option value="respaldo">Respaldos de Cama</option>
        <option value="colchon">Colchones</option>
        <option value="base">Base de Cama</option>
        <option value="patas">Patas de cama</option>
        <option value="banquetas">Banquetas</option>
        <option value="fundas">Fundas</option>
        <option value="living">Living</option>
        
     </select>
</form>
</div>
<p></p>

<div id="formularios" style="display: none;"> </div>
          




       
        




      </div>
      <div id="fracaso" style=" width: 60rem; margin:0 auto; text-align: center; ">
            
            
        </div>
       
        
    </section>

  </main><!-- End #main --><!-- End #main -->
<!--FIN del cont principal-->

<?php require_once "vistas/parte_inferior.php"?>