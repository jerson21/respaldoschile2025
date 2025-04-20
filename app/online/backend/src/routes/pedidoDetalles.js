const express = require('express');
const router = express.Router({ mergeParams: true });
const ctrl = require('../controllers/pedidoDetallesController');
const { authenticateToken } = require('../middlewares/auth');

/**
 * @openapi
 * /api/pedidos/{pedidoId}/detalles:
 *   get:
 *     summary: Obtener detalles de un pedido.
 *     security:
 *       - bearerAuth: []
 *     parameters:
 *       - in: path
 *         name: pedidoId
 *         schema:
 *           type: string
 *         required: true
 *     responses:
 *       200:
 *         description: Lista de detalles.
 */
router.get('/', authenticateToken, ctrl.getAll);

/**
 * @openapi
 * /api/pedidos/{pedidoId}/detalles/{id}:
 *   get:
 *     summary: Obtener un detalle por ID.
 *     security:
 *       - bearerAuth: []
 *     parameters:
 *       - in: path
 *         name: pedidoId
 *         schema:
 *           type: string
 *         required: true
 *       - in: path
 *         name: id
 *         schema:
 *           type: integer
 *         required: true
 *     responses:
 *       200:
 *         description: Detalle encontrado.
 *       404:
 *         description: Detalle no encontrado.
 */
router.get('/:id', authenticateToken, ctrl.getById);

/**
 * @openapi
 * /api/pedidos/{pedidoId}/detalles:
 *   post:
 *     summary: Crear un nuevo detalle de pedido.
 *     security:
 *       - bearerAuth: []
 *     parameters:
 *       - in: path
 *         name: pedidoId
 *         schema:
 *           type: string
 *         required: true
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema:
 *             type: object
 *             description: Campos del detalle (modelo, precio, etc.)
 *     responses:
 *       201:
 *         description: Detalle creado.
 */
router.post('/', authenticateToken, ctrl.create);

/**
 * @openapi
 * /api/pedidos/{pedidoId}/detalles/{id}:
 *   put:
 *     summary: Actualizar un detalle de pedido.
 *     security:
 *       - bearerAuth: []
 *     parameters:
 *       - in: path
 *         name: pedidoId
 *         schema:
 *           type: string
 *         required: true
 *       - in: path
 *         name: id
 *         schema:
 *           type: integer
 *         required: true
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema:
 *             type: object
 *             description: Campos a actualizar
 *     responses:
 *       200:
 *         description: Detalle actualizado.
 */
router.put('/:id', authenticateToken, ctrl.update);

/**
 * @openapi
 * /api/pedidos/{pedidoId}/detalles/{id}:
 *   delete:
 *     summary: Eliminar un detalle de pedido.
 *     security:
 *       - bearerAuth: []
 *     parameters:
 *       - in: path
 *         name: pedidoId
 *         schema:
 *           type: string
 *         required: true
 *       - in: path
 *         name: id
 *         schema:
 *           type: integer
 *         required: true
 *     responses:
 *       200:
 *         description: Detalle eliminado.
 */
router.delete('/:id', authenticateToken, ctrl.remove);

module.exports = router;