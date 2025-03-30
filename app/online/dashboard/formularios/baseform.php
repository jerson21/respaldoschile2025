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

    <!-- <form name="formular" id="formular" class="php-email-form" accept-charset="utf-8" method="post" action=""> -->
    <div class="row gy-4" style="margin-top:15px; background-color: white; padding: 30px; border-radius: 5px; border:solid 1px; border-color: #252525;  font-family: 'Open Sans', sans-serif;">

        <div class="row">
            <div class="col-md-4">
                <input type="hidden" name="modelo" id="modelo" value="Base de Cama">
                <label for="modelo" class="form-label fw-bold"> Seleccionar las plazas </label>
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

            <div class="col-md-4">
                <label for="modelo" class="form-label fw-bold"> Seleccionar Largo </label>
                <select class="form-select form-select-sm" name="alturabase" id="alturabase" aria-label="Default select example" required>
                    <option value="">Seleccionar Largo</option>
                    <option value="1.90mt">1.90</option>
                    <option value="2Mt">2 Metros</option>



                </select>
            </div>

            <div class="row mt-3">
            </div>
            <div class="col-md-4">
                <label for="modelo" class="form-label fw-bold"> Seleccionar tipo de tela </label>
                <select id="listatelas" name="listatelas" class="form-select form-select-sm" aria-label="Default select example" required>
                    <option value="">Seleccionar</option>
                    <option value="lino">Lino</option>
                    <option value="felpa">Felpa</option>
                    <option value="mosaico">Felpa Mosaico</option>
                    <option value="ecocuero">Eco Cuero</option>
                </select>
            </div>

            <div class="col-md-6" id="select2lista">


            </div><div class="row mt-3">
            </div>
            <div class="col-md-6">

                <label class="form-label fw-bold">Adicional</label>
                <textarea class="form-control custom-input" id="detalles_fabricacion" name="detalles_fabricacion" rows="2" placeholder="Información adicional para la fabricación."></textarea>

            </div>
        </div>



        <div style="color:red;" id="pedidoexistente"></div>







        <?php // include("formulariodatos.php") 
        ?>