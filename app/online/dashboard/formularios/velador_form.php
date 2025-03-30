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
  <style type="text/css">
    /* Estilo para el select */
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






    .input-inside {
      background-color: #A7FFA0;
      /* Cambia el color de fondo cuando está dentro del polígono */
    }

    .input-outside {
      background-color: #FF9191;
      /* Cambia el color de fondo cuando está fuera del polígono */
    }
  </style>

  <!-- <form  name="formular" id="formular" class="php-email-form" accept-charset="utf-8" method="post" action=""> -->
  <div class="row gy-4" style="margin-top:15px; background-color: white; padding: 30px; border-radius: 5px; border:solid 1px; border-color: #252525;  font-family: 'Open Sans', sans-serif;">

    <div class="row">

      <div class="col-md-5">
        Seleccionar Modelo
        <select class="form-select form-select-sm" name="modelo" id="modelo" aria-label="Default select example" required>
          <option value="">Seleccionar Modelo</option>
          <option value="Velador 2 Cajones">Velador 2 Cajones</option>
          <option value="Velador 3 Cajones">3 Cajones</option>



        </select>
      </div>

      <div class="col-md-6">
        Seleccionar medidas (Alto x ancho x fondo)
        <select class="form-select form-select-sm" name="plazas" id="plazas" aria-label="Default select example" required>
          <option value="">Seleccionar Medidas</option>.
          <option value="60x50x40">60x40x40</option>
          <option value="60x50x40">60x50x40</option>
          <option value="60x50x45">60x50x45</option>
          <option value="60x45x40">60x45x40</option>
          <option value="65x45x40">65x45x40</option>

          <option value="60x50x40">70x40x40</option>
          <option value="70x45x40">70x45x40</option>
          <option value="70x50x40">70x50x40</option>




        </select>
      </div>

     

      <div class="col-md-4">
        Seleccionar tipo de acabado
        <select id="listatelas" name="listatelas" class="form-select form-select-sm" aria-label="Default select example" required>
          <option value="">Seleccionar</option>
          <option value="Albayalde">Albayalde</option>
          <option value="Unicolor">Unicolor</option>

        </select>
      </div>

      <div class="col-md-4" id="">
        Seleccionar Color
        <select id="lista2" name="lista2" class="form-select form-select-sm" aria-label="Default select example" required>
          <option value="">Seleccionar Color</option>
          <option value="BLANCO">BLANCO</option>
          <option value="NEGRO">NEGRO</option>
          <option value="GRIS">GRIS</option>
          <option value="ROSADO">ROSADO</option>

        </select>

      </div>
      <div class="row mt-3">
            </div>
      <div class="col-md-6">
    
  <label class="form-label fw-bold">Adicional</label>
  <textarea class="form-control custom-input" id="detalles_fabricacion" name="detalles_fabricacion"  rows="2" placeholder="Información adicional para la fabricación."></textarea>

      </div>
    </div>





    <div style="color:red;" id="pedidoexistente"></div>
    <?php // include("formulariodatos.php") 
    ?>