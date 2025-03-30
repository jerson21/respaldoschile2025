$(document).ready(function() {
    // ...

    // Manejo del escaneo de códigos de barras
    $("#escanear").click(function() {
        // Mostrar el contenedor de video como un popup
        $("#video-container").css("display", "block");
        // Configuración de QuaggaJS
        Quagga.init({
            inputStream: {
                name: "Live",
                type: "LiveStream",
                target: document.querySelector("#video-container"),
                constraints: {
                    facingMode: "environment" // Utiliza la cámara trasera para escanear códigos
                }
            },
            decoder: {
                readers: ["ean_reader"] // Especifica el tipo de código de barras a escanear (EAN)
            }
        }, function(err) {
            if (err) {
                console.error("Error al iniciar Quagga: " + err);
                return;
            }
            Quagga.start();
        });

        // Manejo del evento de detección del código de barras escaneado
        Quagga.onDetected(function(result) {
            var codigo = result.codeResult.code;

            // Actualizar el div con el resultado del escaneo
            $("#resultado-escaneo").text("Código escaneado: " + codigo);

            // Envío del código escaneado al servidor mediante AJAX
            $.ajax({
                url: "guardar_codigo.php",
                type: "POST",
                data: { codigo: codigo },
                success: function(response) {
                    // Actualizar el estado de la interfaz después de guardar el código
                    alert("Código guardado correctamente");
                }
            });

            // Detener Quagga después de escanear el código
            Quagga.stop();
        });
    });
});