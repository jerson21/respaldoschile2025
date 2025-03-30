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
          <option value="Funda Lisa">Funda Lisa</option>
          <option value="Funda Costura Simple">Funda Lisa Costura Simple</option>
          <option value="Funda Costura Doble">Funda Lisa Costura Doble</option>
          <option value="Funda Costura Doble con Amarras">Funda Lisa Costura Doble con amarras</option>

        </select>
      </div>

      <div class="col-md-6">
        Seleccionar las plazas
        <select class="form-select form-select-sm" name="plazas" id="plazas" aria-label="Default select example" required>
          <option value="">Seleccionar las plazas</option>
          <option value="1">1 plaza</option>
          <option value="1 1/2">1 1/2</option>
          <option value="Full">Full</option>
          <option value="2">2 Plazas</option>
          <option value="Queen">Queen</option>
          <option value="King">King</option>
          <option value="Super King">Super King</option>
        </select>
      </div>



      <div class="col-md-6">
        Seleccionar tipo de tela
        <select id="listatelas" name="listatelas" class="form-select form-select-sm" aria-label="Default select example" required>
          <option value="">Seleccionar</option>
          <option value="lino">Lino</option>
          <option value="felpa">Felpa</option>
          <option value="mosaico">Felpa Mosaico</option>
          <option value="ecocuero">Eco Cuero</option>
        </select>
      </div>

      <div class="col-md-6" id="select2lista">


      </div>


      <div class="col-md-6">

        <select class="form-select form-select-sm" name="alturabase" id="alturabase" aria-label="Default select example">
          <option>Altura Funda</option>
          <option value="20">20 cm</option>
          <option value="25">25 cm</option>
          <option value="45">45 cm</option>
          <option value="50">50 cm</option>
          <option value="55">55 cm</option>
          <option selected value="60">60 cm Estandar</option>
          <option value="61">61 cm</option>
          <option value="62">62 cm</option>
          <option value="63">63 cm</option>
          <option value="64">64 cm</option>
          <option value="65">65 cm</option>
          <option value="66">66 cm</option>
          <option value="67">67 cm</option>
          <option value="68">68 cm</option>
          <option value="69">69 cm</option>
          <option value="70">70 cm</option>
          <option value="71">71 cm</option>
          <option value="72">72 cm</option>
          <option value="73">73 cm</option>
          <option value="74">74 cm</option>
          <option value="75">75 cm</option>
          <option value="76">76 cm</option>
          <option value="77">77 cm</option>
          <option value="78">78 cm</option>
          <option value="79">79 cm</option>
          <option value="80">80 cm</option>
          <option value="80">85 cm</option>
          <option value="80">90 cm</option>
          <option value="80">100 cm</option>
          <option value="80">120 cm</option>
          <option value="80">135 cm</option>
          <option value="80">150 cm</option>
          <option value="80">155 cm</option>
          <option value="80">160 cm</option>
        </select>
        <div style="font-size: small"></div>
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
  <?php // include("formulariodatos.php") 
  ?>