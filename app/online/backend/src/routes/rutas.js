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

// CRUD for rutas
router.get('/', getAllRutas);
router.get('/:id', getRutaById);
router.post('/', createRuta);
router.put('/:id', updateRuta);
router.delete('/:id', deleteRuta);

// Sub-resource: pedidos assigned to ruta
router.get('/:id/pedidos', getPedidos);
router.post('/:id/pedidos/:detalleId', assignPedido);
router.delete('/:id/pedidos/:detalleId', unassignPedido);

module.exports = router;