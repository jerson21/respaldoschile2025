<?php
include "../bd/conexion.php";
session_start();

$num_orden = $_GET["num_orden"];

$rut_cliente = "";
$direccion = "";
$telefono = "";
$numero = "";
$comuna = "";
$dpto = "";
$despacho = "";
$correo = "";
$instagram = "";
$nombre = "";

$objeto = new Conexion();
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
    $direccion = $row['direccion'] . " " . $row['numero'] . ", " . $row['comuna'] . ", " . $row['region'];
    $telefono = $row['telefono'];
    $comuna = $row['comuna'];
    $numero = $row['numero'];
    $dpto = $row['dpto'];
    $correo = $row['correo'];
    $despacho = $row['despacho'];
    $instagram = $row['instagram'];

    // Resto del código que utiliza las variables asignadas
  }

  $strsqls = "SELECT * FROM clientes WHERE rut = $rut_cliente";
  $resultado = $conexion->prepare($consulta);
  $resultado->execute();
  $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

  foreach ($data as $arow) {

    $nombre = $arow['nombre'];
  }
}

?>
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

    /*
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

*/

    .input-inside {
      background-color: #A7FFA0;
      /* Cambia el color de fondo cuando está dentro del polígono */
    }

    .input-outside {
      background-color: #FF9191;
      /* Cambia el color de fondo cuando está fuera del polígono */
    }
  </style>




  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&display=swap" rel="stylesheet">

  <!-- <form name="formular" id="formular" class="php-email-form" accept-charset="utf-8" method="post" action=""> -->
  <div class="row gy-4" style="margin-top:15px; background-color: white; padding: 30px; border-radius: 5px; border:solid 1px; border-color: #252525;  font-family: 'Open Sans', sans-serif;">

    <div class="row">
      <div class="col-md-4">
        <label for="modelo" class="form-label fw-bold">Modelo</label>
        <select class="form-select form-select-sm" name="modelo" id="modelo" required>
          <option value="">Seleccionar Modelo</option>
          <?php

          $consulta = "SELECT * FROM productos_venta WHERE id_categoria = 1 ORDER BY id DESC";
          $resultado = $conexion->prepare($consulta);
          $resultado->execute();
          $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

          usort($data, function ($a, $b) {
            return $a['id'] - $b['id'];
          });

          $tipo_producto_actual = '';
          foreach ($data as $row) {
            $tipo_producto = $row['tipo_producto'];
            $categoria = $row['id_categoria'];
            $modelo = $row['modelo'];

            // Verificar si el tipo de producto actual es diferente al tipo de producto del bucle actual
            // Si es diferente, cerrar el grupo anterior y abrir uno nuevo
            if ($tipo_producto != $tipo_producto_actual) {
              // Cerrar el grupo anterior si existe
              if ($tipo_producto_actual != '') {
                echo "</optgroup>";
              }

              // Abrir un nuevo grupo con el tipo de producto actual
              echo "<optgroup label='$tipo_producto'>";

              // Actualizar el tipo de producto actual
              $tipo_producto_actual = $tipo_producto;
            }

            // Generar la etiqueta <option> con el valor del modelo
            echo "<option value='$modelo'>$modelo</option>";
          }

          // Cerrar el último grupo
          echo "</optgroup>";

          ?>
        </select>
      </div>
      <div class="col-md-6">
        <label for="plazas" class="form-label fw-bold">Seleccionar las plazas</label>
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
    </div>
    <div class="row mt-3">
      <div class="col-md-4">
        <label for="listatelas" class="form-label fw-bold">Seleccionar tipo de tela</label>
        <select id="listatelas" name="listatelas" class="form-select form-select-sm" aria-label="Default select example" required>
          <option value="">Selecciona Tela</option>
          <option value="lino">Lino</option>
          <option value="felpa">Felpa</option>
          <option value="mosaico">Felpa Mosaico</option>
          <option value="ecocuero">Eco Cuero</option>
        </select>
      </div>
      <div class="col-md-6" id="select2lista"></div>
    </div>



    <div class="col-md-4">
      <label for="listatelas" class="form-label fw-bold">Altura de base </label>
      <select class="form-select form-select-sm" id="alturabase" name="alturabase" aria-label="Default select example" required>
        <option value="">Medida Base de respaldo</option>
        <option value="20">20 cm</option>
        <option value="25">25 cm</option>
        <option value="45">45 cm</option>
        <option value="50">50 cm</option>
        <option value="55">55 cm</option>
        <option value="55">56 cm</option>
        <option value="55">57 cm</option>
        <option value="60">60 cm Estandar</option>
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
      </select>
      <div style="font-size: small">Si mide más de la medida estandar 60 cm, Tiene un costo adicional de <b>$5000</b> cada
        10cm.</div>
    </div>
    <script>
      $('#alturabase').on('change', function() {

        validarAlturaBase();
      });

      function validarAlturaBase() {
        var alturaBase = $("select[name='alturabase']").val();

        // Si la altura de base seleccionada es 60, pide confirmación al usuario
        if (alturaBase === "60") {
          Swal.fire({
            title: "Altura de Base 60 cm",
            text: "Has seleccionado una altura de base de 60 cm. ¿Deseas continuar con esta selección?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sí, continuar",
            cancelButtonText: "No, cambiar"
          }).then((result) => {
            if (result.isConfirmed) {
              // Si el usuario confirma, ejecuta el callback para continuar el proceso
              //callback(true);
            } else {
              // Si el usuario decide cambiar, enfoca el campo de altura de base
              $("select[name='alturabase']").focus().addClass('is-invalid');
              //  callback(false);
            }
          });
        } else {
          // Si la altura de base no es 60, simplemente continua
          //  callback(true);
        }
      }
    </script>
    <div class="col-md-6">

      <label class="form-label fw-bold">Adicional</label>
      <textarea class="form-control custom-input" id="detalles_fabricacion" name="detalles_fabricacion" rows="2" placeholder="Información adicional para la fabricación."></textarea>

    </div>

    <div class="row" style="margin-top:15px; font-family: 'Open Sans', sans-serif; font-size: 14px">
      <div class="col-md-4">
        <div class="alert alert-info" role="alert" style="height: 15px; line-height: 1px; display: flex;  align-items: center;">
          <i class="bi bi-arrow-down-circle-fill" style=" padding-right: 5px;"> </i> Indicar tipo de botones aqui
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="boton" id="diamante" value="B D">
          <label class="form-check-label" for="flexRadioDefault1">Botones Diamante</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="boton" id="colores" value="B Color" checked>
          <label class="form-check-label" for="flexRadioDefault2">Botones de colores </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="boton" id="normales" value="" checked>
          <label class="form-check-label" for="flexRadioDefault2">Botones Normales</label>
        </div>
      </div>

      <div class="col-md-4">
        <div class="alert alert-info" role="alert" style="height: 15px; line-height: 1px;  display: flex;  align-items: center;">
          <i class="bi bi-arrow-down-circle-fill" style=" padding-right: 5px;"> </i> Indicar Sistema de anclaje
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="anclaje" id="anclaje" value="si" checked>
          <label class="form-check-label" for="flexRadioDefault3"> Con sistema de anclaje </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="anclaje" id="anclaje" value="patas" checked>
          <label class="form-check-label" for="flexRadioDefault3">Con patas de madera</label>

        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="anclaje" id="anclaje" value="no" checked>
          <label class="form-check-label" for="flexRadioDefault3">Sin sistema de anclaje</label>

        </div>
      </div>

      <div class="col-md-4">
        <div class="alert alert-info" role="alert" style="height: 15px; line-height: 1px;  display: flex;  align-items: center;">
          <i class="bi bi-arrow-down-circle-fill" style=" padding-right: 5px;"> </i> Agrega Anclajes?
        </div>
        <input type="radio" id="anclajemetal" name="anclajemetal" value="si">
        <label for="opcionSi">Sí</label><br>

        <input type="radio" id="anclajemetal" name="anclajemetal" value="no" checked>
        <label for="opcionNo">No</label><br>
      </div>
    </div>
    <div style="color:red;" id="pedidoexistente"></div>






    <?php // include("formulariodatos.php") 
    ?>