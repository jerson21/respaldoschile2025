<?php
include "../bd/conexion.php";
session_start();

$num_orden = $_GET["num_orden"];

$rut_cliente = "";
$direccion   = "";
$telefono    = "";
$numero      = "";
$comuna      = "";
$dpto        = "";
$correo      = "";
$instagram   = "";
$nombre      = "";

$objeto   = new Conexion();
$conexion = $objeto->Conectar();

if (!empty($num_orden)) {

  $consulta = "SELECT * FROM pedido p
    INNER JOIN clientes c ON p.rut_cliente = c.rut
     LEFT JOIN pedido_detalle pd ON p.num_orden = pd.num_orden
    WHERE p.num_orden = $num_orden";

  $resultado = $conexion->prepare($consulta);
  $resultado->execute();
  $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

  foreach ($data as $row) {
    $rut_cliente = $row['rut_cliente'];
    $direccion   = $row['direccion'] . " " . $row['numero'] . ", " . $row['comuna'] . ", " . $row['region'];
    $telefono    = $row['telefono'];
    $comuna      = $row['comuna'];
    $numero      = $row['numero'];
    $dpto        = $row['dpto'];
    $correo      = $row['correo'];
    $instagram   = $row['instagram'];

    // Resto del código que utiliza las variables asignadas
  }

  $strsqls   = "SELECT * FROM clientes WHERE rut = $rut_cliente";
  $resultado = $conexion->prepare($consulta);
  $resultado->execute();
  $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

  foreach ($data as $arow) {

    $nombre = $arow['nombre'];
  }
}

?>
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&display=swap" rel="stylesheet">


<div id="a" class="a">

  <!-- <form name="formular" id="formular" class="php-email-form" accept-charset="utf-8" method="post" action=""> -->
  <div class="row gy-4" style="margin-top:15px; background-color: white; padding: 30px; border-radius: 5px; border:solid 1px; border-color: #252525;  font-family: 'Open Sans', sans-serif;">

    <div class="row">

      <div class="col-md-6">
        Seleccionar Modelo
        <select class="form-select form-select-sm" name="modelo" id="modelo" aria-label="Default select example" required>
          <option value="">Seleccionar Modelo</option>
          <option value="Sofa Br Curvo">Sofa brazo curvo</option>
          <option value="Sofa Br gaviota">Sofa Brazo gaviota</option>
          <option value="Sofa Br cuadrado">Sofa Brazo cuadrado</option>
          <option value="Living L Cuerpos">Living L</option>
          <option value="Chesterfield">Chesterfield</option>
          <option value="Living 3 1+1">Living 3 1+1</option>
          <option value="Living Retro">Living Retro</option>
          <option style="color: blue; font-weight: bold;" disabled>Nuevos Modelos</option>
          <option value="Sofa Atenas">Sofa Atenas</option>
          <option value="Sofa Belgrado">Sofa Belgrado</option>
          <option value="Sofa Milan">Sofa Milan</option>
          <option value="Sofa Alaska">Sofa Alaska</option>
          <option value="Sofa Orlando">Sofa Orlando</option>
          <option value="Sofa Sidney">Sofa Sidney</option>
          <option value="Sofa Dallas">Sofa Dallas</option>
          <option value="Sofa Madison">Sofa Madison</option>
          <option value="Sofa Siena">Sofa Siena</option>

          <option value="Seccional Elixir">Seccional Elixir(Antiguo L)</option>
          <option value="Seccional Monaco Izquierdo">Seccional Monaco Izquierdo</option>
          <option value="Seccional Monaco Izquierdo">Seccional Monaco Derecho</option>
          <option value="Seccional Monaco Izquierdo">Seccional Monaco Izquierdo</option>
          <option value="Seccional Monaco Izquierdo">Seccional Monaco Derecho</option>
          <option value="Seccional Dallas Izquierdo">Seccional Dallas Izquierdo</option>
          <option value="Seccional Dallas Izquierdo">Seccional Dallas Derecho</option>
          <option value="Seccional Dallas Izquierdo">Seccional Dallas Izquierdo</option>
          <option value="Seccional Dallas Izquierdo">Seccional Dallas Derecho</option>





        </select>
      </div>

      <div class="col-md-6">
        Seleccionar Cuerpos
        <select class="form-select form-select-sm" name="plazas" id="plazas" aria-label="Default select example" required>
          <option value="">Seleccionar Cuerpos</option>
          <option value="1">1 Cuerpo</option>
          <option value="2">2 Cuerpos</option>
          <option value="3">3 Cuerpos</option>
          <option value="4">4 Cuerpos</option>
          <option value="5">5 Cuerpos</option>
          <option value="6">6 Cuerpos</option>
          <option value="7">7 Cuerpos</option>
        </select>
      </div>



      <div class="col-md-6">
        Seleccionar tipo de tela
        <select id="listatelas" name="listatelas" class="form-select form-select-sm" aria-label="Default select example" required>
          <option value="">Seleccionar Tela</option>
          <option value="lino">Lino</option>
          <option value="felpa">Felpa</option>
          <option value="mosaico">Felpa Mosaico</option>
          <option value="ecocuero">Eco Cuero</option>
          <option value="asturias">Asturias</option>
        </select>
      </div>

      <div class="col-md-6" id="select2lista">


      </div>


      <div class="col-md-6">
        Seleccionar Altura
        <select class="form-select form-select-sm" name="alturabase" id="alturabase" aria-label="Default select example">

          <option selected value="60">80 cm Estandar</option>
          <option value="61">90 cm</option>
          <option value="62">100 cm</option>

        </select>

      </div>

    </div>
    <div class="row mt-3">
    </div>
    <div class="col-md-6">

      <label class="form-label fw-bold">Adicional</label>
      <textarea class="form-control custom-input" id="detalles_fabricacion" name="detalles_fabricacion" rows="2" placeholder="Información adicional para la fabricación."></textarea>

    </div>
  </div>


  <div style="color:red;" id="pedidoexistente"></div>
  <?php //include("formulariodatos.php") 
  ?>