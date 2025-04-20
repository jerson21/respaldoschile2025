const express = require('express');
const router = express.Router();
const detallesRouter = require('./pedidoDetalles');
const { authenticateToken } = require('../middlewares/auth');
const pedidosController = require('../controllers/pedidosController');

/**
 * @openapi
 * /api/pedidos:
 *   get:
 *     summary: Obtiene todos los pedidos.
 *     responses:
 *       200:
 *         description: Lista de pedidos
 *         content:
 *           application/json:
 *             schema:
 *               type: array
 *               items:
 *                 $ref: '#/components/schemas/Pedido'
 *   post:
 *     summary: Crea un nuevo pedido.
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema:
 *             $ref: '#/components/schemas/PedidoInput'
 *     responses:
 *       201:
 *         description: Pedido creado
 *         content:
 *           application/json:
 *             schema:
 *               type: object
 *               properties:
 *                 num_orden:
 *                   type: integer
 * /api/pedidos/{id}:
 *   get:
 *     summary: Obtiene un pedido por ID.
 *     parameters:
 *       - in: path
 *         name: id
 *         schema:
 *           type: integer
 *         required: true
 *         description: ID del pedido
 *     responses:
 *       200:
 *         description: Detalles del pedido
 *         content:
 *           application/json:
 *             schema:
 *               $ref: '#/components/schemas/Pedido'
 *       404:
 *         description: Pedido no encontrado
 *   put:
 *     summary: Actualiza un pedido existente.
 *     parameters:
 *       - in: path
 *         name: id
 *         schema:
 *           type: integer
 *         required: true
 *         description: ID del pedido
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema:
 *             $ref: '#/components/schemas/PedidoInput'
 *     responses:
 *       200:
 *         description: Pedido actualizado
 *         content:
 *           application/json:
 *             schema:
 *               type: object
 *               properties:
 *                 updated:
 *                   type: integer
 *       404:
 *         description: Pedido no encontrado
 *   delete:
 *     summary: Elimina un pedido por ID.
 *     parameters:
 *       - in: path
 *         name: id
 *         schema:
 *           type: integer
 *         required: true
 *         description: ID del pedido
 *     responses:
 *       204:
 *         description: Pedido eliminado
 *       404:
 *         description: Pedido no encontrado
 */
router.get('/', authenticateToken, pedidosController.getAllPedidos);
router.get('/:id', authenticateToken, pedidosController.getPedidoById);
router.post('/', authenticateToken, pedidosController.createPedido);
router.put('/:id', authenticateToken, pedidosController.updatePedido);
router.delete('/:id', authenticateToken, pedidosController.deletePedido);
// Rutas anidadas: detalles de pedido
router.use('/:pedidoId/detalles', detallesRouter);

module.exports = router;