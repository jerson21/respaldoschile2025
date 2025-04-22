const express = require('express');
const router = express.Router({ mergeParams: true });
const { body, validationResult } = require('express-validator');
const ctrl = require('../controllers/pedidoDetallesController');
const { authenticateToken } = require('../middlewares/auth');
/**
 * @openapi
 * tags:
 *   - name: PedidoDetalles
 *     description: Gestión de detalles de pedidos
 */

/**
 * @openapi
 * /api/pedidos/{pedidoId}/detalles:
 *   get:
 *     tags: [PedidoDetalles]
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
 *     tags: [PedidoDetalles]
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
 *     tags: [PedidoDetalles]
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
// Validators for creating a detalle de pedido
const createDetailValidators = [
  body('direccion').isString().notEmpty(),
  body('comuna').isString().notEmpty(),
  body('modelo').isString().notEmpty(),
  body('tamano').isString().notEmpty(),
  body('alturabase').isString().notEmpty(),
  body('tipotela').isString().notEmpty(),
  body('color').isString().notEmpty(),
  body('precio').isFloat({ gt: 0 }),
  body('cantidad').isInt({ gt: 0 }),
  body('fecha_ingreso').isString().notEmpty(),
  // opcionales: numero, dpto, region, abono, tipo_boton, anclaje, comentarios, detalles_fabricacion, pagado, mododepago,
  // metodo_entrega, detalle_entrega, vendedor, estadopedido
];
// Validators for updating a detalle (all fields optional)
const updateDetailValidators = [
  body('direccion').optional().isString(),
  body('comuna').optional().isString(),
  body('modelo').optional().isString(),
  body('tamano').optional().isString(),
  body('alturabase').optional().isString(),
  body('tipotela').optional().isString(),
  body('color').optional().isString(),
  body('precio').optional().isFloat({ gt: 0 }),
  body('cantidad').optional().isInt({ gt: 0 }),
  body('fecha_ingreso').optional().isString(),
  // opcionales restantes...
];

// Middleware para enviar errores de validación
function handleValidationErrors(req, res, next) {
  const errors = validationResult(req);
  if (!errors.isEmpty()) {
    return res.status(400).json({ status: 'error', errors: errors.array() });
  }
  next();
}
router.post(
  '/',
  authenticateToken,
  createDetailValidators,
  handleValidationErrors,
  ctrl.create
);
/**
 * @openapi
 * /api/pedidos/{pedidoId}/detalles/reorder:
 *   patch:
 *     tags: [PedidoDetalles]
 *     security:
 *       - bearerAuth: []
 *     summary: Reordena los detalles de un pedido.
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
 *             properties:
 *               ordering:
 *                 type: array
 *                 items:
 *                   type: object
 *                   properties:
 *                     id:
 *                       type: integer
 *                     orden_ruta:
 *                       type: integer
 *     responses:
 *       200:
 *         description: Orden actualizado.
 *       500:
 *         description: Error en servidor.
 */
router.patch('/reorder', authenticateToken, ctrl.reorderDetails);

/**
 * @openapi
 * /api/pedidos/{pedidoId}/detalles/{id}:
 *   put:
 *     tags: [PedidoDetalles]
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
router.put(
  '/:id',
  authenticateToken,
  updateDetailValidators,
  handleValidationErrors,
  ctrl.update
);

/**
 * @openapi
 * /api/pedidos/{pedidoId}/detalles/{id}:
 *   delete:
 *     tags: [PedidoDetalles]
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