const express = require('express');
/**
 * @openapi
 * tags:
 *   - name: Pedidos
 *     description: Gestión de pedidos
 */
const router = express.Router();
const detallesRouter = require('./pedidoDetalles');
const { authenticateToken } = require('../middlewares/auth');
const pedidosController = require('../controllers/pedidosController');

/**
 * @openapi
 * /api/pedidos:
 *   get:
 *     tags: [Pedidos]
 *     security:
 *       - bearerAuth: []
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
 *     tags: [Pedidos]
 *     security:
 *       - bearerAuth: []
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
 *     tags: [Pedidos]
 *     security:
 *       - bearerAuth: []
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
 *     tags: [Pedidos]
 *     security:
 *       - bearerAuth: []
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
 *     tags: [Pedidos]
 *     security:
 *       - bearerAuth: []
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

/**
 * @openapi
 * /api/pedidos/{id}/asignar-ruta:
 *   post:
 *     tags: [Pedidos]
 *     security:
 *       - bearerAuth: []
 *     summary: Asigna una ruta a todos los detalles de un pedido y actualiza su estado a "3".
 *     parameters:
 *       - in: path
 *         name: id
 *         schema:
 *           type: integer
 *         required: true
 *         description: Número de orden del pedido.
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema:
 *             type: object
 *             properties:
 *               rutaId:
 *                 type: integer
 *     responses:
 *       200:
 *         description: Asignación completada.
 *         content:
 *           application/json:
 *             schema:
 *               type: object
 *               properties:
 *                 status:
 *                   type: string
 *                 updatedDetails:
 *                   type: integer
 *                 updatedOrder:
 *                   type: integer
 *       400:
 *         description: Faltan datos.
 *       500:
 *         description: Error en servidor.
 */
router.post('/:id/asignar-ruta', authenticateToken, pedidosController.assignRouteToOrder);
  /**
   * @openapi
   * /api/pedidos/{id}/estado:
   *   patch:
   *     tags: [Pedidos]
   *     security:
   *       - bearerAuth: []
   *     summary: Actualizar el estado de un pedido (5 = finalizado, 6 = anulado)
   *     parameters:
   *       - in: path
   *         name: id
   *         schema:
   *           type: integer
   *         required: true
   *         description: ID del pedido a actualizar
   *     requestBody:
   *       description: Nuevo estado del pedido
   *       required: true
   *       content:
   *         application/json:
   *           schema:
   *             type: object
   *             properties:
   *               estado:
   *                 type: integer
   *                 description: Código del estado (5=finalizado,6=anulado)
   *             required:
   *               - estado
   *     responses:
   *       "200":
   *         description: Número de filas afectadas
   *         content:
   *           application/json:
   *             schema:
   *               type: integer
   *               example: 1
   */
router.patch('/:id/estado', authenticateToken, pedidosController.updatePedidoEstado);
  /**
   * @openapi
   * /api/pedidos/{id}/etapa:
   *   post:
   *     tags: [Pedidos]
   *     security:
   *       - bearerAuth: []
   *     summary: Agregar una nueva etapa a un pedido
   *     parameters:
   *       - in: path
   *         name: id
   *         schema:
   *           type: integer
   *         required: true
   *         description: ID del pedido al que se le agrega la etapa
   *     requestBody:
   *       description: Datos de la etapa a insertar
   *       required: true
   *       content:
   *         application/json:
   *           schema:
   *             $ref: '#/components/schemas/PedidoEtapaInput'
   *     responses:
   *       "201":
   *         description: ID del nuevo registro insertado
   *         content:
   *           application/json:
   *             schema:
   *               type: integer
   *               example: 42
   */
router.post('/:id/etapa', authenticateToken, pedidosController.createPedidoEtapa);
// Rutas anidadas: detalles de pedido
router.use('/:pedidoId/detalles', detallesRouter);

module.exports = router;