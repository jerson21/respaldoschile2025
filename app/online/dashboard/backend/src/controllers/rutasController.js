const rutasModel = require('../models/rutasModel');

/**
 * Controller for 'ruta' entity.
 */
async function getAllRutas(req, res) {
  try {
    const rutas = await rutasModel.getAll();
    res.json({ status: 'success', data: rutas });
  } catch (error) {
    console.error(error);
    res.status(500).json({ status: 'error', error: 'Failed to fetch rutas' });
  }
}

async function getRutaById(req, res) {
  const { id } = req.params;
  try {
    const ruta = await rutasModel.getById(id);
    if (!ruta) return res.status(404).json({ status: 'error', error: 'Ruta no encontrada.' });
    res.json({ status: 'success', data: ruta });
  } catch (error) {
    console.error(error);
    res.status(500).json({ status: 'error', error: 'Failed to fetch ruta' });
  }
}

async function createRuta(req, res) {
  const { fecha, tipo } = req.body;
  if (!fecha || !tipo) {
    return res.status(400).json({ status: 'error', error: 'Fields fecha and tipo are required.' });
  }
  try {
    const id = await rutasModel.create({ fecha, tipo });
    res.status(201).json({ status: 'success', id });
  } catch (error) {
    console.error(error);
    res.status(500).json({ status: 'error', error: 'Failed to create ruta' });
  }
}

async function updateRuta(req, res) {
  const { id } = req.params;
  try {
    const affected = await rutasModel.update(id, req.body);
    if (!affected) return res.status(404).json({ status: 'error', error: 'Ruta no encontrada.' });
    res.json({ status: 'success', updated: affected });
  } catch (error) {
    console.error(error);
    res.status(500).json({ status: 'error', error: 'Failed to update ruta' });
  }
}

async function deleteRuta(req, res) {
  const { id } = req.params;
  try {
    const affected = await rutasModel.remove(id);
    if (!affected) return res.status(404).json({ status: 'error', error: 'Ruta no encontrada.' });
    res.json({ status: 'success', message: 'Ruta eliminada.' });
  } catch (error) {
    console.error(error);
    res.status(500).json({ status: 'error', error: 'Failed to delete ruta' });
  }
}

// Sub-resource: pedidos assigned to ruta
async function getPedidos(req, res) {
  const { id } = req.params;
  try {
    const pedidos = await rutasModel.getPedidosByRuta(id);
    res.json({ status: 'success', data: pedidos });
  } catch (error) {
    console.error(error);
    res.status(500).json({ status: 'error', error: 'Failed to fetch pedidos for ruta' });
  }
}

async function assignPedido(req, res) {
  const { id, detalleId } = req.params;
  try {
    const affected = await rutasModel.assignDetalle(id, detalleId);
    if (!affected) return res.status(404).json({ status: 'error', error: 'Detalle no encontrado o ruta inválida.' });
    res.json({ status: 'success', message: 'Pedido asignado a ruta.' });
  } catch (error) {
    console.error(error);
    res.status(500).json({ status: 'error', error: 'Failed to assign pedido to ruta' });
  }
}

async function unassignPedido(req, res) {
  const { detalleId } = req.params;
  try {
    const affected = await rutasModel.unassignDetalle(detalleId);
    if (!affected) return res.status(404).json({ status: 'error', error: 'Detalle no encontrado.' });
    res.json({ status: 'success', message: 'Pedido removido de ruta.' });
  } catch (error) {
    console.error(error);
    res.status(500).json({ status: 'error', error: 'Failed to remove pedido from ruta' });
  }
}

module.exports = {
  getAllRutas,
  getRutaById,
  createRuta,
  updateRuta,
  deleteRuta,
  getPedidos,
  assignPedido,
  unassignPedido,
};