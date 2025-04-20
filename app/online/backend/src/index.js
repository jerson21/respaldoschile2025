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
// Enable CORS
app.use(cors());
// Serve API docs
app.use('/api-docs', swaggerUi.serve, swaggerUi.setup(swaggerSpec));

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

// Ruta raíz opcional
app.get('/', (req, res) => {
  res.json({ message: 'RespaldosChile API', version: '1.0' });
});

app.listen(port, () => {
  console.log(`Server running on port ${port}`);
});