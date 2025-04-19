require('dotenv').config();
const express = require('express');

const app = express();
const port = process.env.PORT || 3000;

// Middlewares
app.use(express.json());

// Rutas
app.use('/api', require('./routes/test'));
// Pedidos routes
app.use('/api/pedidos', require('./routes/pedidos'));

// Ruta raíz opcional
app.get('/', (req, res) => {
  res.json({ message: 'RespaldosChile API', version: '1.0' });
});

app.listen(port, () => {
  console.log(`Server running on port ${port}`);
});