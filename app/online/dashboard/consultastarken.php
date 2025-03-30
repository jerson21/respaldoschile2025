<?php require_once "vistas/parte_superior.php"?>

<?php
/*
error_reporting(E_ALL);
ini_set('display_errors', '1');
include "bd/conexion.php";
// Obtener datos de la API
$url = "https://apiprod.starkenpro.cl/agency/agencyDls/localidades";
$response = file_get_contents($url);
$data = json_decode($response, true)["data"];

$objeto1 = new Conexion();
$conexion = $objeto1->Conectar();

foreach ($data as $row) {
    $comuna = $row['COMUNA'];

    // Verificar si la comuna ya existe en la base de datos
    $consulta_existencia = "SELECT COUNT(*) as cantidad FROM agencias WHERE comuna = '$comuna'";
    $resultado_existencia = $conexion->query($consulta_existencia);
    $fila_existencia = $resultado_existencia->fetch(PDO::FETCH_ASSOC);

    if ($fila_existencia['cantidad'] > 0) {
        // La comuna ya existe, entonces hacemos un UPDATE
        $sql = "UPDATE agencias 
                SET AGENCODIGO = '".$row['AGENCODIGO']."',
                    DESCRIPCION = '".$row['DESCRIPCION']."',
                    CIUDREGION = '".$row['CIUDREGION']."',
                    CIUDCODIGO = '".$row['CIUDCODIGO']."',
                    COMUCODIGO = '".$row['COMUCODIGO']."',
                    ciudad = '".$row['CIUDAD']."',
                    comunastarken = '".$row['COMUNA']."',
                    TIPO_ENTREGA = '".$row['TIPO_ENTREGA']."'
                WHERE comuna = '$comuna'";
    } else {
        // La comuna no existe, entonces hacemos un INSERT
       $sql = "INSERT INTO agencias (idstarken, AGENCODIGO, DESCRIPCION, CIUDREGION, CIUDCODIGO, COMUCODIGO, comunastarken, ciudad, TIPO_ENTREGA) 
        SELECT '".$row['ID']."', '".$row['AGENCODIGO']."', '".$row['DESCRIPCION']."', '".$row['CIUDREGION']."', '".$row['CIUDCODIGO']."', '".$row['COMUCODIGO']."', '".$row['COMUNA']."', '".$row['CIUDAD']."', '".$row['TIPO_ENTREGA']."'
        FROM dual
        WHERE NOT EXISTS (SELECT 1 FROM agencias WHERE idstarken = '".$row['ID']."')";
    }

    try {
        if ($conexion->query($sql) === TRUE) {
            echo "Datos insertados o actualizados correctamente";
        } else {
            throw new Exception("Error al insertar o actualizar datos: " . $conexion->error);
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    $stmt = $conexion->query($sql);
if (!$stmt) {
    echo "Error de ejecución de la consulta: " . $conexion->errorInfo()[2];
}
}*/
 ?>
<!--INICIO del cont principal-->
<div class="container">
    <h1>Cotizador de Envios</h1>
</div>

<div class="container-fluid" style="padding: 1rem; text-align: center; overflow: auto;  white-space: nowrap; margin:0 auto; " >


 <?php

/*
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://gateway.starken.cl/externo/integracion/tracking/orden-flete/of/979967790',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'api-key: def67c5e3ad0527b7a876fb3231d009b',
    'Authorization: Bearer 25ed8eca-3fb3-4fd6-8a14-9b149ab56689'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo "Consulta de seguimiento: <br><pre>";
echo $response;
echo "</pre>";


//REGIONES 


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://apiprod.starkenpro.cl/agency/region',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_POSTFIELDS =>'{"entrega":"AGENCIA","tipoServicio":"NORMAL","codigoAgenciaDestino":1763,"codigoAgenciaOrigen":281,"rutCliente":"","codigoTipoPago":1,"codigoCiudadOrigen":1,"codigoCiudadDestino":1,"rutDestinatario":"","encargos":[{"tipoEncargo":"29","alto":"120","ancho":"15","largo":"200","kilos":"13"}]}',
  CURLOPT_HTTPHEADER => array(
    'api-key: def67c5e3ad0527b7a876fb3231d009b',
    'Content-Type: application/json',
    'Authorization: Bearer 25ed8eca-3fb3-4fd6-8a14-9b149ab56689'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo " Consulta de regiones: <br><pre>";
print_r($response);
echo " </pre>";













// COTIZACIÓN

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://apiprod.starkenpro.cl/quote/caja-tarifa/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{"entrega":"AGENCIA","tipoServicio":"NORMAL","codigoAgenciaDestino":1763,"codigoAgenciaOrigen":281,"rutCliente":"","codigoTipoPago":1,"codigoCiudadOrigen":1,"codigoCiudadDestino":1,"rutDestinatario":"","encargos":[{"tipoEncargo":"29","alto":"120","ancho":"15","largo":"150","kilos":"13"}]}',
  CURLOPT_HTTPHEADER => array(
    'api-key: def67c5e3ad0527b7a876fb3231d009b',
    'encargos: [{"tipoEncargo":"29","alto":"120","ancho":"15","largo":"150","kilos":"13"}]',
    'Content-Type: application/json',
    'Authorization: Bearer 25ed8eca-3fb3-4fd6-8a14-9b149ab56689'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo "Consulta de cotización: <br> <pre>";
print_r($response);
echo " </pre>";




// CONSULTA TIPO DE ENTREGA

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://apiprod.starkenpro.cl/emision/tipo-entrega',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'api-key: def67c5e3ad0527b7a876fb3231d009b',
    'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6MzkxMzU1LCJuYW1lIjoicmVzcGFsZG9zIGNoaWxlIHNwYSIsInJ1biI6Ijc3MTg2MDMxMSIsIm1hc3Rlcl9pZCI6bnVsbCwiYXBwbGljYXRpb24iOnsiaWQiOjIsIm5hbWUiOiJTdGFya2VuIFBybyIsImNvZGUiOiJQUk8ifSwicm9sZSI6eyJpZCI6MSwiY29kZSI6IlVTRVIiLCJuYW1lIjoiVVNVQVJJTyJ9LCJpYXQiOjE2ODEyMTk0MDEsImV4cCI6MTY4MTIzMDIwMX0.xHAL21ELK7O7hOQ7JNWwvvnq8auJVRi-p1IWhmUEdII'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo "Consulta de tipo de entrega: <br> <pre>";
print_r($response);
echo " </pre>";




$curl = curl_init();
$calle = 'callenueva3706';
$ciudad = 'santiago';
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://geocode.search.hereapi.com/v1/geocode?maxresults=4&apiKey=97eELw7yGj5u1ZbVF3Xqw0INRBVVEVZqO_8x3dFSipY&qq=country=Chile;city='.$ciudad.';street='.$calle.'&api-key=97eELw7yGj5u1ZbVF3Xqw0INRBVVEVZqO_8x3dFSipY',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_POSTFIELDS => array('entrega' => 'Agencia','tipoServicio' => 'NORMAL','codigoAgenciaDestino' => '1763','codigoAgenciaOrigen' => '281','rutCliente' => '','codigoTipoPago' => '1','codigoCiudadOrigen' => '1','codigoCiudadDestino' => '1','rutDestinatario' => ''),
  CURLOPT_HTTPHEADER => array(
    'api-key: def67c5e3ad0527b7a876fb3231d009b'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo "Consulta de tipo de entrega: <br> <pre>";
print_r($response);
echo " </pre>";
*/
?>
</div>

<!-- CSS de Select2 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">

<!-- jQuery (asegúrate de incluirlo antes de Select2) -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- JavaScript de Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<style>
        .card {
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
            transition: 0.3s;
            border-radius: 5px; /* Bordes redondeados */
        }
        .card:hover {
            box-shadow: 0 8px 16px 0 rgba(0,0,0,0.3);
        }
        .card-header {
            font-size: 16px; /* Tamaño del texto */
        }
        .form-group {
            margin-bottom: 15px;
        }
        .select2-container--default .select2-selection--single {
            height: 38px; /* Altura adecuada para el contenido */
            line-height: 38px; /* Centrado vertical del texto */
            border: 1px solid #ccc; /* Borde más claro y uniforme */
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 38px; /* Asegura que el texto esté centrado verticalmente */
            color: #555; /* Color de texto más oscuro para mejor lectura */
            padding-left: 8px; /* Padding para que el texto no toque el borde */
        }
        .select2-container .select2-selection--single .select2-selection__arrow {
            height: 36px; /* Altura del ícono de flecha */
        }
        body {
            color: #333; /* Color del texto */
            background-color: #f4f4f4; /* Color de fondo */
        }

       /* Estilo para difuminar el contenido */
.blur-effect {
    filter: blur(4px);
}

/* Asegura que el contenedor principal no tenga difuminado */
#mainContainer {
    filter: none !important;
}
    </style>

<div class="container mt-5"  id="mainContainer">
  <form id="miFormulario">
        <div class="form-group">
          
            <input type="hidden" class="form-control" name="selected" value="CGR" required>
        </div>

          <div class="form-row">

            <!-- Campo Origen -->
            <div class="form-group col-md-4">
                <label for="origen">Origen:</label>
                <input type="text" class="form-control col-md-12" name="origen" value="Santiago" disabled>
            </div>

            <!-- Campo Destino -->
            <div class="form-group col-md-4">
                <label for="destino">Destino:</label>
                <select class="form-control col-md-12" name="destino" required id="selectDestino">
                <!-- Opciones se llenarán dinámicamente con datos de la base de datos -->
</select>
<script>    </script>
            </div>

        </div>
        <div class="form-row">

        <div class="form-group">
            <label for="alto">Alto:</label>
            <input type="text" class="form-control form-control-sm col-6 " name="alto" value="120" required>
        </div>

        <div class="form-group">
            <label for="ancho">Ancho:</label>
            <input type="text" class="form-control form-control-sm col-6" name="ancho" value="15" required>
        </div>

        <div class="form-group">
            <label for="largo">Largo:</label>
            <input type="text" class="form-control form-control-sm col-6" name="largo" value="150" required>
        </div>

         <div class="form-group">
            <label for="peso">Peso:</label>
            <input type="text" class="form-control form-control-sm col-6" name="peso" value="14" required>
        </div>


 </div>
        <div class="form-group">
            <h4>Lugar de Entrega</h4>
            <div class="form-check">
                <input type="radio" class="form-check-input" name="lugar" value="DOM" id="domEntrega" checked>
                <label class="form-check-label" for="domEntrega">Entrega en domicilio</label>
            </div>
            <div class="form-check">
                <input type="radio" class="form-check-input" name="lugar" value="OFI"  id="ofiEntrega">
                <label class="form-check-label" for="ofiEntrega">Entrega en oficina</label>
            </div>
        </div>

        

        <!-- <div class="form-group">
            <label for="telefono">Teléfono:</label>
            <input type="text" class="form-control" name="telefono" value="971257977" required>
        </div>
-->
<button type="button" class="btn btn-primary" onclick="enviarFormulario()"><i class="fas fa-paper-plane"></i> Cotizar Envío</button>
    </form>
    <div id="starken"><div class="container mt-5">
    <!-- Div de Resultado -->

<div class="d-flex flex-row" id="resultado">

<div class="card border-primary mb-4 mr-3" style="width: 22rem;">
<div class="card-header bg-primary text-white">PRECIO PULLMANCARGO </div>
<div class="card-body text-primary">
            <p class="card-text pullmango-title"></p>

            <!-- Otros datos del resultado -->
        </div>
        <div class="card-body text-secondary pullmango-tarifa"> Tarifa Referencial</div>
        </div>

        <div class="card border-primary mb-4 mr-3" style="width: 22rem;">
        <div class="card-header bg-success text-white">PRECIO STARKEN</div>
        <div class="card-body text-success">
            <p class="card-text hereapi-title"></p>
            <!-- Otros datos del resultado -->
        </div>
        <div class="card-body text-secondary hereapi-tarifa"> Tarifa Referencial</div>
    </div>

</div>

</div></div>
    
</div>



<script>
$(document).ready(function() {
    // Función para inicializar el Select2 y cargar datos inicialmente
    function inicializarSelectDestino() {
        $('#selectDestino').select2({
            placeholder: 'Seleccione una comuna...',
            width: '100%',  // Asegura que el select tome el ancho completo del contenedor
            ajax: {
                url: 'obtener_origenes.php',  // Nombre del archivo PHP que obtendrá los datos de la BD
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    // Envía el término de búsqueda al servidor
                    return {
                        term: params.term // término de búsqueda que el usuario está escribiendo en el input
                    };
                },
                processResults: function (data) {
                    // Transforma los datos del formato de la respuesta a un formato que entiende Select2
                    return {
                        results: data.map(item => ({
                            id: item.id,  // Asume que cada objeto tiene un 'id'
                            text: item.comuna  // Asume que el servidor devuelve 'comuna'
                        }))
                    };
                },
                cache: true
            }
        });
    }

    // Llamar a la función para inicializar el select de destino cuando la página está lista
    inicializarSelectDestino();

    // Función para llenar dinámicamente las opciones del select al cargar la página
    function llenarOrigenes() {
        $.ajax({
            type: "GET",
            url: "obtener_origenes.php",  // Esta llamada debería retornar todas las comunas inicialmente
            success: function(response) {
                // Parsear la respuesta JSON
                var data = JSON.parse(response);

                // Llenar las opciones del select
                var select = $("select[name='destino']");
                select.empty();
                $.each(data, function(index, value) {
                    select.append(new Option(value.comuna, value.id));
                });

                // Si necesitas añadir agencodigo a un input, actualiza el input aquí
                $("input[name='agencodigo']").val(data[0]?.agencodigo);

                // No necesitas aplicar Select2 aquí nuevamente si ya lo hiciste en la inicialización
            },
            error: function(error) {
                console.error("Error en la solicitud AJAX: " + error);
            }
        });
    }

    // Llamar a la función para llenar las opciones al cargar la página
    llenarOrigenes();

});




function enviarFormulario() {
    var formData = $("#miFormulario").serialize();

    // Capturar los valores individuales para mostrar en el alert
    var alto = $('input[name="alto"]').val();
    var ancho = $('input[name="ancho"]').val();
    var largo = $('input[name="largo"]').val();
    var peso = $('input[name="peso"]').val();

    $.ajax({
        type: "POST",
        url: "recibir_datos_pullman.php",
        data: formData,
        dataType: "json",
        success: function(response) {
            Swal.fire({
                title: 'Resultado de Cotización',
                html: `
                    <h4 style="text-align: center;">Comuna de Destino: ${$('#selectDestino option:selected').text()}</h4>
                    <div><strong>Dimensiones y Peso:</strong></div>
                    <p>Alto: ${alto} cm, Ancho: ${ancho} cm, Largo: ${largo} cm, Peso: ${peso} kg</p>
                    <div style="display: flex; justify-content: space-around; padding: 20px;">
                        <div style="background-color: #007BFF; color: white; padding: 20px; border-radius: 10px; width: 45%; box-shadow: 0 4px 8px rgba(0,123,255,0.3);">
                            <h5>Pullmancargo</h5>
                            <p><strong>Precio:</strong> $${response.pullmango.precioTotal}</p>
                            <p><strong>Detalle:</strong> ${response.pullmango.mensaje}</p>
                            <p><strong>Tarifa Referencial:</strong> Sí</p>
                        </div>
                        <div style="background-color: #28A745; color: white; padding: 20px; border-radius: 10px; width: 45%; box-shadow: 0 4px 8px rgba(40,167,69,0.3);">
                            <h5>Starken</h5>
                            <p><strong>Precio:</strong> $${response.hereapi.tarifa}</p>
                            <p><strong>Días Aproximados de Entrega:</strong> ${response.hereapi.diasEntrega}</p>
                            <p><strong>Tarifa Referencial:</strong> Sí</p>
                        </div>
                    </div>
                `,
                icon: 'info',
                confirmButtonText: 'Aceptar',
                width: '800px'
            });
        },
        error: function(error) {
            Swal.fire({
                title: 'Error',
                text: 'No se pudo obtener la información de la cotización',
                icon: 'error',
                confirmButtonText: 'Cerrar'
            });
        }
    });
}



function mostrarRespuesta(response) {
    // Extraer datos específicos de la respuesta combinada
    var pullmangoData = response.pullmango;
    var hereapiData = response.hereapi;

    // Actualizar el contenido de las tarjetas con los datos
    $(".pullmango-title").text(pullmangoData.titulo);
    $(".pullmango-tarifa").html(`<h5 class="card-title">Precio: ${pullmangoData.precioTotal}</h5><p class="card-text">${pullmangoData.mensaje}</p>
      <p class="card-text" style="text-align:center;">Tarifa Referencial</p>`);

    $(".hereapi-title").text(hereapiData.titulo);
    $(".hereapi-tarifa").html(`<h5 class="card-title">Precio: ${hereapiData.tarifa}</h5><p class="card-text">Dias aprox: ${hereapiData.diasEntrega}</p>
    <p class="card-text" style="text-align:center;">Tarifa Referencial</p>`);

    // Mostrar el div de resultado
    $("#resultado").show();
}
</script>

<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verificar si se ha enviado un formulario
   $selected = $_POST["selected"];
    $origen = $_POST["origen"];
    $destino = $_POST["destino"];
    $pago = "PED";
    $alto = $_POST["alto"];
    $ancho = $_POST["ancho"];
    $largo = $_POST["largo"];    
    $lugar = $_POST["lugar"];
    $peso = $_POST["peso"];
    $telefono = $_POST["telefono"];
    // Agregar otros campos aquí

    // Crear datos para la solicitud cURL
   $data = array(
        "selected" => $selected,
        "origen" => $origen,
        "destino" => $destino,
        "pago" => $pago,
        "alto" => $alto,
        "ancho" => $ancho,
        "largo" => $largo,       
        "lugar" => $lugar,
        "peso" => $peso,
        "telefono" => $telefono
    );

    $data_string = json_encode($data);

    // Realizar la solicitud cURL
    $curl = curl_init();
    
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://www.pullmango.cl/api/cotizar',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $data_string,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);

    // Mostrar la respuesta de la API
    echo "Respuesta de la API: " . $response;
}

?>
<!--FIN del cont principal-->

