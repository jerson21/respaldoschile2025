<?php require_once "vistas/parte_superior.php";

$_SESSION["s_usuario"];
$servername = "localhost";
$username = "cre61650_respaldos21";
$password = "respaldos21/";
$dbname = "cre61650_agenda";

// Función para obtener el último comprobante
function obtenerUltimoComprobante($conn) {
    // Consulta para obtener el último comprobante
    $sql = "SELECT * FROM pedido ORDER BY num_orden DESC LIMIT 1";
    $result = $conn->query($sql);

    // Verificar si hay resultados y devolverlos
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return "ID Comprobante: " . $row["num_orden"] . "<br>"
             . "Fecha: " . $row["fecha_ingreso"] . "<br>"
             . "Cliente: " . $row["rut_cliente"] . "<br>";
        // Agrega aquí el resto de campos que desees mostrar
    } else {
        return "No se encontraron comprobantes.";
    }
}

// Verificar si el formulario ha sido enviado (opcional)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Crear la conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Llamar a la función para obtener el último comprobante
    $ultimoComprobante = obtenerUltimoComprobante($conn);

    // Cerrar la conexión
    $conn->close();

    // Devolver el resultado como una respuesta AJAX
    echo $ultimoComprobante;
    exit(); // Detener la ejecución del script después de enviar la respuesta
}
?>
        <style>
        /* Definir el ancho deseado para el botón */
        .small-btn {
            width: 200px;
            margin-left: 15px;
        }
    </style>

<!--INICIO del cont principal-->
<div class="container">
    <h1>Re-impresion de comprobante</h1>
</div>

    <!-- Mostrar el resultado de la búsqueda -->
    <div id="resultado">
        <!-- El resultado se mostrará aquí -->
        
    </div>

    <!-- Botón para buscar el último comprobante -->

    <button class="form-control btn btn-primary small-btn" id="buscarBtn">Último comprobante</button>



    <!-- Script para buscar el último comprobante mediante AJAX -->
    <script>
        $(document).ready(function() {
            $("#resultado").load(location.href + " #resultado"); // Cargar contenido inicial del div

            $("#buscarBtn").click(function() {
                $.ajax({
                    type: "POST",
                    url: "bd/crud.php",
                    data: {opcion:'ultima_orden'},
                    dataType: "json",
                    success: function(response) {
                        console.log(response); 
                         // Procesar el JSON y mostrar los datos en el div "resultado"
                         var html = "Orden: " + response.orden + "<br>"
                            + "Fecha: " + response.fecha + "<br>"
                            + "Cliente: " + response.cliente + "<br>";
                        // Agrega aquí el resto de campos que desees mostrar del JSON

                        $("#resultado").html(html);
                        window.open('reportes/pedido.php?id='+response.orden, '_blank');

                       

                    },
                    error: function() {
                        $("#resultado").html("Error al buscar el último comprobante.");
                    }
                });
            });
        });
    </script>

<?php require_once "vistas/parte_inferior.php"; ?>