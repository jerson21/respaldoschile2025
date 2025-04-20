const model = require('../models/pedidoDetalleModel');

/**
 * Controller de detalles de pedido.
 */
async function getAll(req, res) {
  try {
    const pedidoId = req.params.pedidoId;
    const detalles = await model.getAllByOrder(pedidoId);
    res.json({ status: 'success', data: detalles });
  } catch (error) {
    console.error(error);
    res.status(500).json({ status: 'error', error: 'Error al obtener detalles.' });
  }
}

async function getById(req, res) {
  try {
    const id = req.params.id;
    const detalle = await model.getById(id);
    if (!detalle) {
      return res.status(404).json({ status: 'error', error: 'Detalle no encontrado.' });
    }
    res.json({ status: 'success', data: detalle });
  } catch (error) {
    console.error(error);
    res.status(500).json({ status: 'error', error: 'Error al obtener detalle.' });
  }
}

async function create(req, res) {
  try {
    const data = req.body;
    data.num_orden = req.params.pedidoId;
    const id = await model.create(data);
    res.status(201).json({ status: 'success', id });
  } catch (error) {
    console.error(error);
    res.status(500).json({ status: 'error', error: 'Error al crear detalle.' });
  }
}

async function update(req, res) {
  try {
    const id = req.params.id;
    const data = req.body;
    const affected = await model.update(id, data);
    if (!affected) {
      return res.status(404).json({ status: 'error', error: 'Detalle no encontrado.' });
    }
    res.json({ status: 'success', updated: affected });
  } catch (error) {
    console.error(error);
    res.status(500).json({ status: 'error', error: 'Error al actualizar detalle.' });
  }
}

async function remove(req, res) {
  try {
    const id = req.params.id;
    const affected = await model.remove(id);
    if (!affected) {
      return res.status(404).json({ status: 'error', error: 'Detalle no encontrado.' });
    }
    res.json({ status: 'success', message: 'Detalle eliminado.' });
  } catch (error) {
    console.error(error);
    res.status(500).json({ status: 'error', error: 'Error al eliminar detalle.' });
  }
}

module.exports = { getAll, getById, create, update, remove };