const express = require('express');
/**
 * @openapi
 * tags:
 *   - name: Clientes
 *     description: Gestión de clientes
 */
const router = express.Router();
const clientesController = require('../controllers/clientesController');
const { authenticateToken } = require('../middlewares/auth');

/**
 * @openapi
 * /api/clientes:
 *   get:
 *     summary: Obtener todos los clientes.
 *     tags: [Clientes]
 *     security:
 *       - bearerAuth: []
 *     responses:
 *       200:
 *         description: Lista de clientes.
 */
router.get('/', authenticateToken, clientesController.getAll);

/**
 * @openapi
 * /api/clientes/{rut}:
 *   get:
 *     summary: Obtener un cliente por RUT.
 *     tags: [Clientes]
 *     security:
 *       - bearerAuth: []
 *     parameters:
 *       - in: path
 *         name: rut
 *         schema:
 *           type: string
 *         required: true
 *     responses:
 *       200:
 *         description: Cliente encontrado.
 *       404:
 *         description: Cliente no encontrado.
 */
router.get('/:rut', authenticateToken, clientesController.getByRut);

/**
 * @openapi
 * /api/clientes:
 *   post:
 *     summary: Crear un nuevo cliente.
 *     tags: [Clientes]
 *     security:
 *       - bearerAuth: []
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema:
 *             type: object
 *             required:
 *               - rut
 *               - nombre
 *             properties:
 *               rut:
 *                 type: string
 *               nombre:
 *                 type: string
 *               telefono:
 *                 type: string
 *               correo:
 *                 type: string
 *               instagram:
 *                 type: string
 *     responses:
 *       201:
 *         description: Cliente creado.
 *       400:
 *         description: Datos inválidos.
 */
router.post('/', authenticateToken, clientesController.create);

/**
 * @openapi
 * /api/clientes/{rut}:
 *   put:
 *     summary: Actualizar un cliente.
 *     tags: [Clientes]
 *     security:
 *       - bearerAuth: []
 *     parameters:
 *       - in: path
 *         name: rut
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
 *               nombre:
 *                 type: string
 *               telefono:
 *                 type: string
 *               correo:
 *                 type: string
 *               instagram:
 *                 type: string
 *     responses:
 *       200:
 *         description: Cliente actualizado.
 *       404:
 *         description: Cliente no encontrado.
 */
router.put('/:rut', authenticateToken, clientesController.update);

/**
 * @openapi
 * /api/clientes/{rut}:
 *   delete:
 *     summary: Eliminar un cliente.
 *     tags: [Clientes]
 *     security:
 *       - bearerAuth: []
 *     parameters:
 *       - in: path
 *         name: rut
 *         schema:
 *           type: string
 *         required: true
 *     responses:
 *       200:
 *         description: Cliente eliminado.
 *       404:
 *         description: Cliente no encontrado.
 */
router.delete('/:rut', authenticateToken, clientesController.remove);

module.exports = router;