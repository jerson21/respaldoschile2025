const express = require('express');
const { body, validationResult } = require('express-validator');
const { authenticateToken } = require('../middlewares/auth');
const pagosController = require('../controllers/pagosController');

const router = express.Router();
/**
 * @openapi
 * tags:
 *   - name: Pagos
 *     description: CRUD de pagos
 */

// Validators for pagos
const createPagoValidators = [
  body('num_orden').isInt().withMessage('num_orden must be an integer'),
  body('metodo_pago').isString().notEmpty().withMessage('metodo_pago is required'),
  body('monto').isNumeric().withMessage('monto must be a number'),
  body('usuario').isString().notEmpty().withMessage('usuario is required'),
  body('fecha_mov').isISO8601().withMessage('fecha_mov must be a valid datetime'),
  body('id_cartola').optional().isString(),
  body('datos_adicionales').optional().isString()
];
const updatePagoValidators = [
  body('num_orden').optional().isInt(),
  body('metodo_pago').optional().isString(),
  body('monto').optional().isNumeric(),
  body('usuario').optional().isString(),
  body('fecha_mov').optional().isISO8601(),
  body('id_cartola').optional().isString(),
  body('datos_adicionales').optional().isString()
];

// Middleware to handle validation errors
function handleValidationErrors(req, res, next) {
  const errors = validationResult(req);
  if (!errors.isEmpty()) {
    return res.status(400).json({ status: 'error', errors: errors.array() });
  }
  next();
}

/**
 * @openapi
 * /api/pagos:
 *   get:
 *     tags: [Pagos]
 *     security:
 *       - bearerAuth: []
 *     summary: Obtiene todos los pagos.
 *     responses:
 *       200:
 *         description: Lista de pagos
 *   post:
 *     tags: [Pagos]
 *     security:
 *       - bearerAuth: []
 *     summary: Crea un nuevo pago.
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema:
 *             type: object
 *             properties:
 *               num_orden:
 *                 type: integer
 *               metodo_pago:
 *                 type: string
 *               id_cartola:
 *                 type: string
 *               datos_adicionales:
 *                 type: string
 *               monto:
 *                 type: number
 *               usuario:
 *                 type: string
 *               fecha_mov:
 *                 type: string
 *                 format: date-time
 *     responses:
 *       201:
 *         description: Pago creado
 */
router.get('/', authenticateToken, pagosController.getAllPagos);
/**
 * @openapi
 * /api/pagos/{id}:
 *   get:
 *     summary: Obtener pago por ID.
 *     tags: [Pagos]
 *     security:
 *       - bearerAuth: []
 *     parameters:
 *       - in: path
 *         name: id
 *         schema:
 *           type: integer
 *         required: true
 *         description: ID del pago
 *     responses:
 *       200:
 *         description: Detalles del pago
 *         content:
 *           application/json:
 *             schema:
 *               $ref: '#/components/schemas/Pago'
 *       404:
 *         description: Pago no encontrado
 */
router.get('/:id', authenticateToken, pagosController.getPagoById);
router.post(
  '/',
  authenticateToken,
  createPagoValidators,
  handleValidationErrors,
  pagosController.createPago
);
/**
 * @openapi
 * /api/pagos/{id}:
 *   put:
 *     summary: Actualizar un pago existente.
 *     tags: [Pagos]
 *     security:
 *       - bearerAuth: []
 *     parameters:
 *       - in: path
 *         name: id
 *         schema:
 *           type: integer
 *         required: true
 *         description: ID del pago
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema:
 *             $ref: '#/components/schemas/PagoInput'
 *     responses:
 *       200:
 *         description: Pago actualizado
 *       404:
 *         description: Pago no encontrado
 */
router.put(
  '/:id',
  authenticateToken,
  updatePagoValidators,
  handleValidationErrors,
  pagosController.updatePago
);
/**
 * @openapi
 * /api/pagos/{id}:
 *   delete:
 *     summary: Eliminar un pago.
 *     tags: [Pagos]
 *     security:
 *       - bearerAuth: []
 *     parameters:
 *       - in: path
 *         name: id
 *         schema:
 *           type: integer
 *         required: true
 *         description: ID del pago
 *     responses:
 *       200:
 *         description: Pago eliminado
 *       404:
 *         description: Pago no encontrado
 */
router.delete('/:id', authenticateToken, pagosController.deletePago);

module.exports = router;