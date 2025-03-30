var http = require('https');
var socketIo = require('socket.io');

// Crear un servidor HTTP básico
var server = http.createServer(function(req, res) {
    res.writeHead(200, {'Content-Type': 'text/plain'});
    var message = 'It worksss!\n',
        version = 'NodeJS ' + process.versions.node + '\n',
        response = [message, version].join('\n');
    res.end(response);
});

// Adjuntar Socket.IO al servidor HTTP
var io = socketIo(server, {
    cors: {
        origin: "*", // Permite todas las origins, ajusta según tus necesidades
        methods: ["GET", "POST"], // Métodos HTTP permitidos
        allowedHeaders: ["my-custom-header"], // Headers permitidos
        credentials: true // Permite cookies / headers de autorización
    }
});

// Configurar la escucha de eventos de conexión de Socket.IO
io.on('connection', function(socket) {
    console.log('Un cliente se ha conectado');

    // Ejemplo: Escuchar eventos personalizados, como 'chat message'
    socket.on('chat message', function(msg) {
        console.log('Mensaje: ' + msg);
        // Emitir el mensaje a todos los clientes conectados
        io.emit('chat message', msg);
    });

    // Detectar cuando un usuario se desconecta
    socket.on('disconnect', function() {
        console.log('Un usuario se ha desconectado');
    });
});

// Definir el puerto y arrancar el servidor
var PORT = process.env.PORT || 3000;
server.listen(PORT, function() {
    console.log(`Servidor corriendo enn https://localhost:${PORT}/`);
});
