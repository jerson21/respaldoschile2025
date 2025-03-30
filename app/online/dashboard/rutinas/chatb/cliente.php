<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Título de la página</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<input id="usuario">Nombre</input>
   <input id="message">Mensaje</input>
    <div><button onclick="send()">Enviar</button></div>
     
    <div>
        <ul id="messageList"></ul>
    </div>
        <script type="text/javascript" src="signalr.js"></script>
 
   <script type="text/javascript">




 function sendMessage(user, message) {
  const connection = new signalR.HubConnectionBuilder()
    .withUrl("https://serverhuellero.azurewebsites.net/chatHub")
    .configureLogging(signalR.LogLevel.Information)
    .build();

  connection.start()
    .then(() => {
      console.log("SignalR Connected.");
      return connection.invoke("SendMessage", user, message);
    })
    .then(() => {
      console.log(`Mensaje enviado a ${user}: ${message}`);
      return connection.stop();
    })
    .then(() => {
      console.log("SignalR Disconnected.");
    })
    .catch((err) => {
      console.log(err);
    });
}

sendMessage("user1", "Hola mundo!");





sendMessage("algo","algo");
    </script>
    
</body>
</html>
