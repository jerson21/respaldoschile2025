const express = require('express');
const { authenticateToken } = require('../middlewares/auth');
const { getTapiceros, getPedidosByTapicero, getTareasByTapicero, assignTapicero, unassignTapicero } = require('../controllers/tapicerosController');

/**
 * @openapi
 * tags:
 *   - name: Tapiceros
 *     description: Gestión de tapiceros y sus pedidos
 */
const router = express.Router();

/**
 * @openapi
 * /api/tapiceros:
 *   get:
 *     summary: Obtener lista de tapiceros con pedidos asignados.
 *     tags: [Tapiceros]
 *     security:
 *       - bearerAuth: []
 *     responses:
 *       200:
 *         description: Lista de IDs de tapiceros.
 *         content:
 *           application/json:
 *             schema:
 *               type: object
 *               properties:
 *                 status:
 *                   type: string
 *                 data:
 *                   type: array
 *                   items:
 *                     type: string
 */
router.get('/', authenticateToken, getTapiceros);

/**
 * @openapi
 * /api/tapiceros/{tapiceroId}/pedidos:
 *   get:
 *     summary: Obtener pedidos asignados a un tapicero.
 *     tags: [Tapiceros]
 *     security:
 *       - bearerAuth: []
 *     parameters:
 *       - in: path
 *         name: tapiceroId
 *         schema:
 *           type: string
 *         required: true
 *         description: ID del tapicero o 'unassigned'.
 *     responses:
 *       200:
 *         description: Lista de detalles de pedido.
 *         content:
 *           application/json:
 *             schema:
 *               type: object
 *               properties:
 *                 status:
 *                   type: string
 *                 data:
 *                   type: array
 *                   items:
 *                     $ref: '#/components/schemas/PedidoDetalle'
 */
router.get('/:tapiceroId/pedidos', authenticateToken, getPedidosByTapicero);
/**
 * @openapi
 * /api/tapiceros/{tapiceroId}/tareas:
 *   get:
 *     summary: Obtener tareas (detalles con última etapa) para un tapicero
 *     tags: [Tapiceros]
 *     security:
 *       - bearerAuth: []
 *     parameters:
 *       - in: path
 *         name: tapiceroId
 *         schema:
 *           type: string
 *         required: true
 *         description: ID del tapicero o 'unassigned'
 *     responses:
 *       200:
 *         description: Lista de detalles de pedido con su última etapa
 *         content:
 *           application/json:
 *             schema:
 *               type: object
 *               properties:
 *                 status:
 *                   type: string
 *                 data:
 *                   type: array
 *                   items:
 *                     type: object
 */
router.get('/:tapiceroId/tareas', authenticateToken, getTareasByTapicero);

/**
 * @openapi
 * /api/tapiceros/{tapiceroId}/pedidos/{pedidoId}:
 *   put:
 *     summary: Asignar un pedido a un tapicero y registrar etapa de fabricación.
 *     tags: [Tapiceros]
 *     security:
 *       - bearerAuth: []
 *     parameters:
 *       - in: path
 *         name: tapiceroId
 *         schema:
 *           type: string
 *         required: true
 *         description: ID del tapicero.
 *       - in: path
 *         name: pedidoId
 *         schema:
 *           type: string
 *         required: true
 *         description: ID del detalle de pedido.
 *     responses:
 *       200:
 *         description: Asignación exitosa.
 *         content:
 *           application/json:
 *             schema:
 *               type: object
 *               properties:
 *                 status:
 *                   type: string
 *       400:
 *         description: Error de asignación.
 *       500:
 *         description: Error interno.
 */
router.put('/:tapiceroId/pedidos/:pedidoId', authenticateToken, assignTapicero);

/**
 * @openapi
 * /api/tapiceros/{tapiceroId}/pedidos/{pedidoId}:
 *   delete:
 *     summary: Desasignar un tapicero de un pedido.
 *     tags: [Tapiceros]
 *     security:
 *       - bearerAuth: []
 *     parameters:
 *       - in: path
 *         name: tapiceroId
 *         schema:
 *           type: string
 *         required: true
 *         description: ID del tapicero (ignored).
 *       - in: path
 *         name: pedidoId
 *         schema:
 *           type: string
 *         required: true
 *         description: ID del detalle de pedido.
 *     responses:
 *       200:
 *         description: Desasignación exitosa.
 *       400:
 *         description: Error de desasignación.
 *       500:
 *         description: Error interno.
 */
router.delete('/:tapiceroId/pedidos/:pedidoId', authenticateToken, unassignTapicero);

module.exports = router;