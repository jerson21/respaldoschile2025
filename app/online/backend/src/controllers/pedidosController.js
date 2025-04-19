const pedidosModel = require('../models/pedidosModel');
/**
 * Controller for 'pedido' entity.
 */
async function getAllPedidos(req, res) {
  try {
    const pedidos = await pedidosModel.getAll();
    res.json(pedidos);
  } catch (error) {
    console.error(error);
    res.status(500).json({ error: 'Failed to fetch pedidos' });
  }
}
async function getPedidoById(req, res) {
  const { id } = req.params;
  try {
    const pedido = await pedidosModel.getById(id);
    if (!pedido) return res.status(404).json({ error: 'Pedido not found' });
    res.json(pedido);
  } catch (error) {
    console.error(error);
    res.status(500).json({ error: 'Failed to fetch pedido' });
  }
}
async function createPedido(req, res) {
  try {
    const newId = await pedidosModel.create(req.body);
    res.status(201).json({ num_orden: newId });
  } catch (error) {
    console.error(error);
    res.status(500).json({ error: 'Failed to create pedido' });
  }
}
async function updatePedido(req, res) {
  const { id } = req.params;
  try {
    const updated = await pedidosModel.update(id, req.body);
    if (!updated) return res.status(404).json({ error: 'Pedido not found' });
    res.json({ updated });
  } catch (error) {
    console.error(error);
    res.status(500).json({ error: 'Failed to update pedido' });
  }
}
async function deletePedido(req, res) {
  const { id } = req.params;
  try {
    const deleted = await pedidosModel.remove(id);
    if (!deleted) return res.status(404).json({ error: 'Pedido not found' });
    res.status(204).send();
  } catch (error) {
    console.error(error);
    res.status(500).json({ error: 'Failed to delete pedido' });
  }
}
module.exports = { getAllPedidos, getPedidoById, createPedido, updatePedido, deletePedido };