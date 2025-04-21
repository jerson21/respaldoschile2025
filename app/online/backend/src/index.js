require('dotenv').config();
const express = require('express');
const cors = require('cors');

const app = express();
const port = process.env.PORT || 3000;
// Swagger setup
const swaggerUi = require('swagger-ui-express');
const swaggerJsdoc = require('swagger-jsdoc');
// Swagger definition and options
const swaggerOptions = {
  definition: {
    openapi: '3.0.0',
    info: {
      title: 'RespaldosChile API',
      version: '1.0.0',
      description: 'Documentación de la API para RespaldosChile',
    },
    servers: [
      {
        url: `http://localhost:${port}`,
        description: 'Servidor local',
      },
    ],
    components: {
      securitySchemes: {
        bearerAuth: {
          type: 'http',
          scheme: 'bearer',
          bearerFormat: 'JWT'
        }
      },
      schemas: {
        Cliente: {
          type: 'object',
          properties: {
            rut: { type: 'string' },
            nombre: { type: 'string' },
            telefono: { type: 'string' },
            correo: { type: 'string' },
            instagram: { type: 'string' }
          }
        },
        ClienteInput: {
          type: 'object',
          required: ['rut','nombre'],
          properties: {
            rut: { type: 'string' },
            nombre: { type: 'string' },
            telefono: { type: 'string' },
            correo: { type: 'string' },
            instagram: { type: 'string' }
          }
        },
        Direccion: {
          type: 'object',
          properties: {
            id: { type: 'integer' },
            rut_cliente: { type: 'string' },
            direccion: { type: 'string' },
            numero: { type: 'string' },
            dpto: { type: 'string' },
            region: { type: 'string' },
            comuna: { type: 'string' },
            referencia: { type: 'string' },
            estado: { type: 'integer' }
          }
        },
        DireccionInput: {
          type: 'object',
          required: ['rut_cliente','direccion'],
          properties: {
            rut_cliente: { type: 'string' },
            direccion: { type: 'string' },
            numero: { type: 'string' },
            dpto: { type: 'string' },
            region: { type: 'string' },
            comuna: { type: 'string' },
            referencia: { type: 'string' },
            estado: { type: 'integer' }
          }
        },
        Pedido: {
          type: 'object',
          properties: {
            num_orden: { type: 'integer' },
            rut_cliente: { type: 'string' },
            fecha_ingreso: { type: 'string', format: 'date' },
            despacho: { type: 'string' },
            total_pagado: { type: 'number' },
            vendedor: { type: 'string' },
            metodo_entrega: { type: 'string' },
            estado: { type: 'string' },
            orden_ext: { type: 'string' }
          }
        },
        PedidoInput: {
          type: 'object',
          required: ['rut_cliente','fecha_ingreso','despacho','total_pagado','vendedor','metodo_entrega','estado','orden_ext'],
          properties: {
            rut_cliente: { type: 'string' },
            fecha_ingreso: { type: 'string', format: 'date' },
            despacho: { type: 'string' },
            total_pagado: { type: 'number' },
            vendedor: { type: 'string' },
            metodo_entrega: { type: 'string' },
            estado: { type: 'string' },
            orden_ext: { type: 'string' }
          }
        },
        PedidoDetalle: {
          type: 'object',
          properties: {
            id: { type: 'integer' },
            num_orden: { type: 'integer' },
            direccion: { type: 'string' },
            numero: { type: 'string' },
            dpto: { type: 'string' },
            region: { type: 'string' },
            comuna: { type: 'string' },
            modelo: { type: 'string' },
            tamano: { type: 'string' },
            alturabase: { type: 'string' },
            tipotela: { type: 'string' },
            color: { type: 'string' },
            precio: { type: 'number' },
            abono: { type: 'string' },
            cantidad: { type: 'integer' },
            tipo_boton: { type: 'string' },
            anclaje: { type: 'string' },
            comentarios: { type: 'string' },
            detalles_fabricacion: { type: 'string' },
            fecha_ingreso: { type: 'string', format: 'date-time' },
            pagado: { type: 'string' },
            mododepago: { type: 'string' },
            metodo_entrega: { type: 'string' },
            detalle_entrega: { type: 'string' },
            vendedor: { type: 'string' },
            estadopedido: { type: 'string' },
            ruta_asignada: { type: 'integer' },
            orden_ruta: { type: 'string' },
            confirma: { type: 'string' },
            tapicero_id: { type: 'integer' },
            telalista: {
              type: 'integer',
              description: '1 si la tela está lista (existe etapa 3), 0 si no'
            }
          }
        },
        PedidoDetalleInput: {
          type: 'object',
          properties: {
            direccion: { type: 'string' },
            numero: { type: 'string' },
            dpto: { type: 'string' },
            region: { type: 'string' },
            comuna: { type: 'string' },
            modelo: { type: 'string' },
            tamano: { type: 'string' },
            alturabase: { type: 'string' },
            tipotela: { type: 'string' },
            color: { type: 'string' },
            precio: { type: 'number' },
            abono: { type: 'string' },
            cantidad: { type: 'integer' },
            tipo_boton: { type: 'string' },
            anclaje: { type: 'string' },
            comentarios: { type: 'string' },
            detalles_fabricacion: { type: 'string' },
            fecha_ingreso: { type: 'string', format: 'date-time' },
            pagado: { type: 'string' },
            mododepago: { type: 'string' },
            metodo_entrega: { type: 'string' },
            detalle_entrega: { type: 'string' },
            vendedor: { type: 'string' },
            estadopedido: { type: 'string' }
          }
        },
        Ruta: {
          type: 'object',
          properties: {
            id: { type: 'integer' },
            fecha: { type: 'string', format: 'date' },
            tipo: { type: 'integer' }
          }
        },
        RutaInput: {
          type: 'object',
          required: ['fecha','tipo'],
          properties: {
            fecha: { type: 'string', format: 'date' },
            tipo: { type: 'integer' }
          }
        },
        Pago: {
          type: 'object',
          properties: {
            id: { type: 'integer' },
            num_orden: { type: 'integer' },
            metodo_pago: { type: 'string' },
            id_cartola: { type: 'string' },
            datos_adicionales: { type: 'string' },
            monto: { type: 'number' },
            usuario: { type: 'string' },
            fecha_mov: { type: 'string', format: 'date-time' }
          }
        },
        PagoInput: {
          type: 'object',
          required: ['num_orden','metodo_pago','monto','usuario','fecha_mov'],
          properties: {
            num_orden: { type: 'integer' },
            metodo_pago: { type: 'string' },
            id_cartola: { type: 'string' },
            datos_adicionales: { type: 'string' },
            monto: { type: 'number' },
            usuario: { type: 'string' },
            fecha_mov: { type: 'string', format: 'date-time' }
        }
        },
        // Esquema para agregar etapa de pedido
        PedidoEtapaInput: {
          type: 'object',
          properties: {
            idproceso: {
              type: 'integer',
              description: 'ID del proceso correspondiente a la etapa'
            },
            fecha: {
              type: 'string',
              format: 'date-time',
              description: 'Fecha y hora de la nueva etapa (YYYY-MM-DD HH:MM:SS)'
            }
          },
          required: ['idproceso','fecha']
        }
      }
    }
  },
  apis: ['./src/routes/*.js'],
};
const swaggerSpec = swaggerJsdoc(swaggerOptions);

// Middlewares
// Parse JSON bodies
app.use(express.json());
// Parse URL-encoded bodies (from HTML forms or jQuery.ajax default)
app.use(express.urlencoded({ extended: true }));
// Disable HTTP caching on GET requests to ensure fresh data after updates
app.use((req, res, next) => {
  if (req.method === 'GET') {
    res.set('Cache-Control', 'no-cache, no-store, must-revalidate');
  }
  next();
});
// Enable CORS
app.use(cors());
// Serve API docs
app.use('/api-docs', swaggerUi.serve, swaggerUi.setup(swaggerSpec));

// Ruta para exportar el JSON de Swagger directamente
app.get('/swagger.json', (req, res) => {
  res.setHeader('Content-Type', 'application/json');
  res.send(swaggerSpec);
});
// Rutas
app.use('/api', require('./routes/test'));
// Auth routes
app.use('/api/auth', require('./routes/auth'));
// Pedidos routes
app.use('/api/pedidos', require('./routes/pedidos'));
// Clientes REST
app.use('/api/clientes', require('./routes/clientes'));
// Direcciones de clientes
app.use('/api/direcciones', require('./routes/direcciones'));
// Rutas routes
app.use('/api/rutas', require('./routes/rutas'));
// Tapiceros routes: obtener tapiceros y sus pedidos
app.use('/api/tapiceros', require('./routes/tapiceros'));
// Pagos routes
app.use('/api/pagos', require('./routes/pagos'));

// Ruta raíz opcional
app.get('/', (req, res) => {
  res.json({ message: 'RespaldosChile API', version: '1.0' });
});




// Iniciar servidor HTTP y WebSocket (Socket.io)
const http = require('http');
const server = http.createServer(app);

// Configurar Socket.io
const { Server } = require('socket.io');
const io = new Server(server, {
  cors: {
    origin: '*',
    methods: ['GET', 'POST']
  }
});

// Manejar conexiones WebSocket
io.on('connection', (socket) => {
  console.log('New WebSocket client connected:', socket.id);
  socket.on('joinTapiceroRoom', (tapiceroId) => {
    const room = `tapicero-${tapiceroId}`;
    socket.join(room);
    console.log(`Socket ${socket.id} joined room ${room}`);
  });
  socket.on('disconnect', () => {
    console.log('WebSocket client disconnected:', socket.id);
  });
});

// Hacer io disponible en req.app para controladores
app.set('io', io);

// Iniciar servidor HTTP en lugar de app.listen
server.listen(port, () => {
  console.log(`Server (HTTP + WebSocket) running on port ${port}`);
});