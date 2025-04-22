const express = require('express');
/**
 * @openapi
 * tags:
 *   - name: Direcciones
 *     description: Gestión de direcciones de clientes
 */
const router = express.Router();
const ctrl = require('../controllers/direccionesController');
const { authenticateToken } = require('../middlewares/auth');

/**
 * @openapi
 * /api/direcciones:
 *   get:
 *     summary: Obtener direcciones de clientes.
 *     tags: [Direcciones]
 *     security:
 *       - bearerAuth: []
 *     parameters:
 *       - in: query
 *         name: rut
 *         schema:
 *           type: string
 *         description: Filtrar por RUT de cliente
 *     responses:
 *       200:
 *         description: Lista de direcciones.
 */
router.get('/', authenticateToken, ctrl.getAll);

/**
 * @openapi
 * /api/direcciones/{id}:
 *   get:
 *     summary: Obtener una dirección por ID.
 *     security:
 *       - bearerAuth: []
 *     parameters:
 *       - in: path
 *         name: id
 *         schema:
 *           type: integer
 *         required: true
 *     responses:
 *       200:
 *         description: Dirección encontrada.
 *       404:
 *         description: Dirección no encontrada.
 */
router.get('/:id', authenticateToken, ctrl.getById);

/**
 * @openapi
 * /api/direcciones:
 *   post:
 *     summary: Crear una nueva dirección.
 *     security:
 *       - bearerAuth: []
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema:
 *             type: object
 *             required:
 *               - rut_cliente
 *               - direccion
 *             properties:
 *               rut_cliente:
 *                 type: string
 *               direccion:
 *                 type: string
 *               numero:
 *                 type: string
 *               dpto:
 *                 type: string
 *               region:
 *                 type: string
 *               comuna:
 *                 type: string
 *               referencia:
 *                 type: string
 *               estado:
 *                 type: integer
 *     responses:
 *       201:
 *         description: Dirección creada.
 *       400:
 *         description: Datos inválidos.
 */
router.post('/', authenticateToken, ctrl.create);

/**
 * @openapi
 * /api/direcciones/{id}:
 *   put:
 *     summary: Actualizar una dirección.
 *     security:
 *       - bearerAuth: []
 *     parameters:
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
 *             properties:
 *               direccion:
 *                 type: string
 *               numero:
 *                 type: string
 *               dpto:
 *                 type: string
 *               region:
 *                 type: string
 *               comuna:
 *                 type: string
 *               referencia:
 *                 type: string
 *               estado:
 *                 type: integer
 *     responses:
 *       200:
 *         description: Dirección actualizada.
 *       404:
 *         description: Dirección no encontrada.
 */
router.put('/:id', authenticateToken, ctrl.update);

/**
 * @openapi
 * /api/direcciones/{id}:
 *   delete:
 *     summary: Eliminar una dirección.
 *     security:
 *       - bearerAuth: []
 *     parameters:
 *       - in: path
 *         name: id
 *         schema:
 *           type: integer
 *         required: true
 *     responses:
 *       200:
 *         description: Dirección eliminada.
 *       404:
 *         description: Dirección no encontrada.
 */
router.delete('/:id', authenticateToken, ctrl.remove);

module.exports = router;