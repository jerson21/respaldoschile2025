const express = require('express');
const {
  getAllRutas,
  getRutaById,
  createRuta,
  updateRuta,
  deleteRuta,
  getPedidos,
  assignPedido,
  unassignPedido,
} = require('../controllers/rutasController');

const router = express.Router();

/**
 * @openapi
 * tags:
 *   - name: Rutas
 *     description: Gestión de rutas y asignación de pedidos
 */
// CRUD for rutas
/**
 * @openapi
 * /api/rutas:
 *   get:
 *     summary: Obtener todas las rutas.
 *     tags: [Rutas]
 *     responses:
 *       200:
 *         description: Lista de rutas
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
 *                     $ref: '#/components/schemas/Ruta'
 */
router.get('/', getAllRutas);
/**
 * @openapi
 * /api/rutas/{id}:
 *   get:
 *     summary: Obtener ruta por ID.
 *     tags: [Rutas]
 *     parameters:
 *       - in: path
 *         name: id
 *         schema:
 *           type: integer
 *         required: true
 *         description: ID de la ruta
 *     responses:
 *       200:
 *         description: Datos de la ruta
 *         content:
 *           application/json:
 *             schema:
 *               $ref: '#/components/schemas/Ruta'
 *       404:
 *         description: Ruta no encontrada
 */
router.get('/:id', getRutaById);
/**
 * @openapi
 * /api/rutas:
 *   post:
 *     summary: Crear una nueva ruta.
 *     tags: [Rutas]
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema:
 *             $ref: '#/components/schemas/RutaInput'
 *     responses:
 *       201:
 *         description: Ruta creada
 *         content:
 *           application/json:
 *             schema:
 *               type: object
 *               properties:
 *                 status:
 *                   type: string
 *                 id:
 *                   type: integer
 */
router.post('/', createRuta);
/**
 * @openapi
 * /api/rutas/{id}:
 *   put:
 *     summary: Actualizar una ruta existente.
 *     tags: [Rutas]
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
 *             $ref: '#/components/schemas/RutaInput'
 *     responses:
 *       200:
 *         description: Ruta actualizada
 *       404:
 *         description: Ruta no encontrada
 */
router.put('/:id', updateRuta);
/**
 * @openapi
 * /api/rutas/{id}:
 *   delete:
 *     summary: Eliminar una ruta.
 *     tags: [Rutas]
 *     parameters:
 *       - in: path
 *         name: id
 *         schema:
 *           type: integer
 *         required: true
 *     responses:
 *       200:
 *         description: Ruta eliminada
 *       404:
 *         description: Ruta no encontrada
 */
router.delete('/:id', deleteRuta);

// Sub-resource: pedidos assigned to ruta
/**
 * @openapi
 * /api/rutas/{id}/pedidos:
 *   get:
 *     summary: Obtener pedidos asignados a una ruta.
 *     tags: [Rutas]
 *     parameters:
 *       - in: path
 *         name: id
 *         schema:
 *           type: integer
 *         required: true
 *         description: ID de la ruta
 *     responses:
 *       200:
 *         description: Lista de detalles de pedido asignados
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
router.get('/:id/pedidos', getPedidos);
/**
 * @openapi
 * /api/rutas/{id}/pedidos/{detalleId}:
 *   post:
 *     summary: Asignar un detalle de pedido a la ruta.
 *     tags: [Rutas]
 *     parameters:
 *       - in: path
 *         name: id
 *         schema:
 *           type: integer
 *         required: true
 *       - in: path
 *         name: detalleId
 *         schema:
 *           type: integer
 *         required: true
 *         description: ID del detalle de pedido
 *     responses:
 *       200:
 *         description: Pedido asignado a ruta
 *       404:
 *         description: Ruta o detalle no encontrado
 */
router.post('/:id/pedidos/:detalleId', assignPedido);
/**
 * @openapi
 * /api/rutas/{id}/pedidos/{detalleId}:
 *   delete:
 *     summary: Remover un detalle de pedido de la ruta.
 *     tags: [Rutas]
 *     parameters:
 *       - in: path
 *         name: id
 *         schema:
 *           type: integer
 *         required: true
 *       - in: path
 *         name: detalleId
 *         schema:
 *           type: integer
 *         required: true
 *         description: ID del detalle de pedido
 *     responses:
 *       200:
 *         description: Pedido removido de la ruta
 *       404:
 *         description: Detalle no encontrado
 */
router.delete('/:id/pedidos/:detalleId', unassignPedido);

module.exports = router;