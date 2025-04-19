const express = require('express');
const router = express.Router();
const pedidosController = require('../controllers/pedidosController');

/**
 * CRUD routes for 'pedido' entity.
 */
router.get('/', pedidosController.getAllPedidos);
router.get('/:id', pedidosController.getPedidoById);
router.post('/', pedidosController.createPedido);
router.put('/:id', pedidosController.updatePedido);
router.delete('/:id', pedidosController.deletePedido);

module.exports = router;