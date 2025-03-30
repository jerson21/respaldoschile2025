<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat WebSocket - Estilo WhatsApp</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }
        #chat {
    display: flex;
    flex-direction: column;
    background-color: #fff;
    box-shadow: 0 0 5px rgba(0,0,0,0.2);
    margin: 20px auto;
    width: 90%;
    max-width: 600px;
    padding: 10px;
    height: 400px;
    overflow-y: scroll;
}

.message {
    display: flex;
    flex-direction: column;
    margin: 5px;
    padding: 10px;
    border-radius: 10px;
    max-width: 70%;
    margin-bottom: 10px;
}

.sent {
    align-self: flex-end;
    background-color: #dcf8c6; /* Verde para mensajes enviados */
}

.received {
    align-self: flex-start;
    background-color: #f0f0f0; /* Gris para mensajes recibidos */
}

.input-section {
    display: flex;
    padding: 10px;
    position: fixed;
    bottom: 0;
    left: 20px;
    right: 20px;
    background-color: #fff;
}

.input-section input, .input-section button {
    height: 40px;
}

.input-section input {
    flex: 1;
    margin-right: 10px;
    border: 1px solid #ccc;
    border-radius: 20px;
}

.input-section button {
    width: 100px;
    border-radius: 20px;
    border: none;
    background-color: #4CAF50;
    color: white;
}
        .input-section button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Whatsapp- Respaldos Chile</h2>
    <div id="chat"></div>
    <div class="input-section">
        <input type="text" id="messageInput" placeholder="Escribe un mensaje..." autocomplete="off" onkeypress="handleKeyPress(event)" />
        <button onclick="sendMessage()">Enviar</button>
    </div>
    <script>
        const wsUrl = 'wss://on563ghir4.execute-api.sa-east-1.amazonaws.com/production';
        let webSocket;

        function connect() {
            webSocket = new WebSocket(wsUrl);

            webSocket.onopen = function(event) {
                console.log("Conexión WebSocket abierta.");
            };


            function getBotResponse(input) {
    // Convierte el texto a minúsculas para la comparación.
    const lowerCaseInput = input.toLowerCase();

    // Define respuestas basadas en frases clave específicas.
    const phraseResponses = [
    { phrase: "no puedo recibir", response: "¿hay alguna alternativa de entrega como dejar el paquete en conserjería o con algún vecino?" },
    { phrase: "dejar en conserjería",  response: "Perfecto, dejaremos tu paquete en conserjería. Por favor, asegúrate de avisarles." },
    { phrase: "vecino puede recibir",   response: "Entendido, podemos entregar tu paquete a un vecino. Por favor, proporciona el número del departamento o casa y el nombre de la persona que lo recibirá."  },
    { phrase: "puedo recibir desde las", response: "¡Perfecto! Hemos actualizado tu horario de entrega. Te enviaremos una confirmación pronto." },
    { phrase: "datos de transferencia", response: "Por supuesto, los datos para la transferencia son: Banco X, Cuenta Nº 123456789, Titular ABC. Por favor, envía el comprobante una vez hecho el pago." },
    { phrase: "cómo puedo seguir mi entrega", response: "Puedes seguir tu entrega en tiempo real en nuestro sitio web en la sección 'Mis Pedidos'." },
    { phrase: "cuándo llegará mi pedido", response: "Tu pedido está en camino y debería llegar en la fecha estimada que te proporcionamos. ¿Te gustaría el enlace para seguir tu entrega?" },
    { phrase: "quiero cambiar la dirección de entrega", response: "Para cambiar la dirección de entrega, por favor comunicate con tu vendedor." },
    { phrase: "necesito ayuda con mi pedido", response: "Claro, ¿podrías proporcionarme tu rut?" },
    { phrase: "mi pedido no ha llegado", response: "Lamentamos el retraso. Vamos a revisar el estado de tu pedido y te informaremos lo antes posible." },
    { phrase: "quiero cancelar mi pedido", response: "Entendido, para procesar la cancelación necesitamos confirmar algunos detalles. Por favor, contáctanos directamente." },
    { phrase: "hay un problema con mi pedido", response: "Lo siento mucho. ¿Podrías decirnos exactamente qué problema estás experimentando?" },
    { phrase: "cómo puedo realizar un pedido", response: "Hacer un pedido es fácil. Solo visita nuestro sitio web, elige los productos que deseas y sigue el proceso de checkout." },
    { phrase: "aceptan devoluciones", response: "Sí, aceptamos devoluciones dentro de los 30 días posteriores a la entrega, siempre que el producto esté en su condición original." },
    { phrase: "cómo puedo pagar", response: "Ofrecemos varias formas de pago: tarjeta de crédito, PayPal, y transferencia bancaria." },
    { phrase: "tiempo de entrega", response: "El tiempo de entrega varía según la ubicación. Normalmente, el envío toma de 3 a 5 días laborables." },
    { phrase: "dónde está mi factura", response: "Tu factura fue enviada a tu correo electrónico. Si no la encuentras, por favor verifica tu carpeta de spam o contáctanos." },
    { phrase: "quiero dar de baja el servicio", response: "Sentimos oír eso. Para dar de baja el servicio, por favor contáctanos directamente para asistirte mejor." },
    { phrase: "tienen ofertas especiales", response: "¡Sí! Regularmente tenemos ofertas especiales y descuentos. Mantente atento a nuestro sitio web o suscríbete a nuestro boletín." },
    { phrase: "puedo cambiar mi pedido", response: "Dependiendo del estado de tu pedido, es posible hacer cambios. Contáctanos lo antes posible para más detalles." },
    { phrase: "qué garantía ofrecen", response: "Todos nuestros productos vienen con una garantía de satisfacción de 30 días. Si no estás satisfecho, puedes devolverlo sin costo alguno." },
    { phrase: "tienen servicio al cliente", response: "Sí, tenemos un equipo dedicado al servicio al cliente listo para ayudarte. Puedes contactarnos a través de nuestro sitio web o por teléfono." },
    // Añade más frases y respuestas según sea necesario...
];

    // Intenta encontrar una respuesta que coincida con una frase completa.
    for (let i = 0; i < phraseResponses.length; i++) {
        if (lowerCaseInput.includes(phraseResponses[i].phrase)) {
            return phraseResponses[i].response;
        }
    }

    // Respuestas para palabras clave individuales si no se encontró ninguna frase completa.
    const wordResponses = {
        "hola": "¡Hola! ¿Cómo puedo ayudarte hoy?",
        "ayuda": "Claro, cuéntame más sobre cómo puedo asistirte.",
        // Añade más palabras clave y respuestas según sea necesario...
    };

    const words = lowerCaseInput.match(/\b(\w+)\b/g);
    if (words) {
        for (const word of words) {
            if (word in wordResponses) {
                return wordResponses[word];
            }
        }
    }

    // Respuesta por defecto si no se reconoce ninguna intención.
    return "No estoy seguro de haber entendido bien. ¿Podrías ser más específico o darme más detalles?";
}


webSocket.onmessage = function(event) {
    console.log("Mensaje recibido: ", event.data);
    const data = JSON.parse(event.data);

    // Asegúrate de que estás tratando con un mensaje entrante
    if (data.action === "sendMessage" && data.data && data.data.message) {
        const msgData = data.data.message;
        const messageBody = msgData.body;
        const outgoing = msgData.outgoing; // Si es true, es un mensaje que el usuario envió
        const createdAt = new Date(msgData.created_at);
        const timeString = createdAt.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

        displayMessage(messageBody, outgoing ? 'sent' : 'received', timeString);

        // Si el mensaje no es saliente, es decir, es un mensaje entrante, obtenemos una respuesta del bot.
        if (!outgoing) {
            const botResponse = getBotResponse(messageBody);
           // displayMessage(botResponse, 'received', timeString);

          /*  // Suponiendo que también deseas enviar la respuesta del bot a Facebook, harías una petición POST a send-message.php.
            fetch('/send-message.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ message: botResponse }),
            })
            .then(response => response.json())
            .then(data => {
                console.log('Respuesta del bot enviada a través de send-message.php:', data);
            })
            .catch((error) => {
                console.error('Error al enviar la respuesta del bot:', error);
            }); */
        }
    }
};


            webSocket.onclose = function(event) {
                console.log("Conexión WebSocket cerrada. Intentando reconectar...");
                setTimeout(connect, 1000); // Intenta reconectar automáticamente
            };

            webSocket.onerror = function(event) {
                console.error("Error en WebSocket: ", event);
            };
        }

        function sendMessage() {
    const messageInput = document.getElementById("messageInput");
    const message = messageInput.value.trim();

    if (!message) {
        alert("Por favor, escribe un mensaje.");
        return;
    }

            const now = new Date();
            const timeString = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
           // displayMessage(message, 'sent', timeString); // Muestra el mensaje enviado

            // Aquí deberías incluir la hora en el mensaje si es necesario
            const messageData = {
                message: message,
                // time: timeString, // Descomentar si quieres enviar la hora al servidor
            };

            fetch('/send-message.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(messageData),
            })
            .then(response => response.json())
            .then(data => {
                console.log('Mensaje enviado:', data);
                displayMessage(message + ' ' + timeString, 'sent'); // Incluye la hora al mostrar el mensaje
            })
            .catch((error) => {
                console.error('Error:', error);
            });

            messageInput.value = ''; // Limpia el campo después de enviar
        }

        function handleKeyPress(event) {
            // Detectar la tecla Enter sin mantener presionada la tecla Shift
            if (event.keyCode === 13 && !event.shiftKey) {
                event.preventDefault(); // Prevenir el salto de línea
                sendMessage();
            }
        }

        function displayMessage(message, type, timeString) {
        const chatDiv = document.getElementById("chat");
        const messageElement = document.createElement("div");
        const messageBody = document.createElement("span");
        const messageTime = document.createElement("div");

        messageElement.classList.add("message", type); // Aplica la clase basada en el tipo de mensaje
        messageBody.textContent = message;
        messageTime.textContent = timeString;
        messageTime.style.fontSize = "0.75em";
        messageTime.style.marginTop = "5px";

        if (type === 'sent') {
            messageElement.style.textAlign = 'right';
            messageElement.style.backgroundColor = "#dcf8c6"; // Color de fondo para mensajes enviados
        } else {
            messageElement.style.textAlign = 'left';
            messageElement.style.backgroundColor = "#f0f0f0"; // Color de fondo para mensajes recibidos
        }

        messageElement.appendChild(messageBody);
        messageElement.appendChild(messageTime);
        chatDiv.appendChild(messageElement);
        chatDiv.scrollTop = chatDiv.scrollHeight; // Desplaza al último mensaje
    }


        window.onload = connect;
    </script>
</body>
</html>
