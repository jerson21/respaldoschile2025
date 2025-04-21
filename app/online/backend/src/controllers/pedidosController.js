const pedidosModel = require('../models/pedidosModel');
const pool = require('../db');
/**
 * Controller for 'pedido' entity.
 */
async function getAllPedidos(req, res) {
  try {
    const pedidos = await pedidosModel.getAll();
    res.json({ status: 'success', data: pedidos });
  } catch (error) {
    console.error(error);
    res.status(500).json({ error: 'Failed to fetch pedidos' });
  }
}
async function getPedidoById(req, res) {
  const { id } = req.params;
  try {
    const pedido = await pedidosModel.getById(id);
    if (!pedido) return res.status(404).json({ status: 'error', error: 'Pedido no encontrado.' });
    res.json({ status: 'success', data: pedido });
  } catch (error) {
    console.error(error);
    res.status(500).json({ error: 'Failed to fetch pedido' });
  }
}
async function createPedido(req, res) {
  try {
    const newId = await pedidosModel.create(req.body);
    res.status(201).json({ status: 'success', num_orden: newId });
  } catch (error) {
    console.error(error);
    res.status(500).json({ error: 'Failed to create pedido' });
  }
}
async function updatePedido(req, res) {
  const { id } = req.params;
  try {
    const updated = await pedidosModel.update(id, req.body);
    if (!updated) return res.status(404).json({ status: 'error', error: 'Pedido no encontrado.' });
    res.json({ status: 'success', updated });
  } catch (error) {
    console.error(error);
    res.status(500).json({ error: 'Failed to update pedido' });
  }
}
async function deletePedido(req, res) {
  const { id } = req.params;
  try {
    const deleted = await pedidosModel.remove(id);
    if (!deleted) return res.status(404).json({ status: 'error', error: 'Pedido no encontrado.' });
    res.json({ status: 'success', message: 'Pedido eliminado.' });
  } catch (error) {
    console.error(error);
    res.status(500).json({ error: 'Failed to delete pedido' });
  }
}
/**
 * Asigna una ruta a todos los detalles de un pedido y actualiza estado a "3".
 * POST /api/pedidos/:id/asignar-ruta
 */
async function assignRouteToOrder(req, res) {
  const pedidoId = req.params.id;
  const { rutaId } = req.body;
  if (rutaId === undefined) {
    return res.status(400).json({ status: 'error', error: 'Falta el campo rutaId' });
  }
  try {
    const conn = await pool.getConnection();
    try {
      await conn.beginTransaction();
      const [r1] = await conn.query(
        'UPDATE pedido_detalle SET ruta_asignada = ? WHERE num_orden = ?',
        [rutaId, pedidoId]
      );
      const [r2] = await conn.query(
        'UPDATE pedidos SET estado = ? WHERE num_orden = ?',
        ['3', pedidoId]
      );
      await conn.commit();
      conn.release();
      res.json({ status: 'ok', updatedDetails: r1.affectedRows, updatedOrder: r2.affectedRows });
    } catch (err) {
      await conn.rollback();
      conn.release();
      console.error('Error assignRouteToOrder:', err);
      res.status(500).json({ status: 'error', error: err.message });
    }
  } catch (err) {
    console.error('Error al conectar a la BD:', err);
    res.status(500).json({ status: 'error', error: 'Error de conexión a la base de datos' });
  }
}
/**
 * PATCH /api/pedidos/:id/estado
 * Actualiza solo el campo 'estado' de un pedido.
 */
async function updatePedidoEstado(req, res) {
  const { id } = req.params;
  const { estado } = req.body;
  if (estado === undefined) {
    return res.status(400).json({ status: 'error', error: 'Falta el campo estado' });
  }
  try {
    // Actualizar estado en la tabla correcta 'pedidos'
    const [result] = await pool.query(
      'UPDATE pedidos SET estado = ? WHERE num_orden = ?',
      [estado, id]
    );
    // Devolver número de filas afectadas
    res.json(result.affectedRows);
  } catch (error) {
    console.error('Error updatePedidoEstado:', error);
    res.status(500).json({ status: 'error', error: 'Error al actualizar estado' });
  }
}
/**
 * POST /api/pedidos/:id/etapa
 * Inserta una nueva etapa en pedido_etapas.
 */
async function createPedidoEtapa(req, res) {
  const { id } = req.params;
  const { idproceso, fecha } = req.body;
  if (idproceso === undefined || fecha === undefined) {
    return res.status(400).json({ status: 'error', error: 'Faltan datos de la etapa' });
  }
  try {
    // Insertar nueva etapa en la tabla 'pedido_etapas'
    const [result] = await pool.query(
      'INSERT INTO pedido_etapas (idPedido, idproceso, fecha) VALUES (?, ?, ?)',
      [id, idproceso, fecha]
    );
    res.status(201).json(result.insertId);
  } catch (error) {
    console.error('Error createPedidoEtapa:', error);
    res.status(500).json({ status: 'error', error: 'Error al insertar etapa' });
  }
}
module.exports = {
  getAllPedidos,
  getPedidoById,
  createPedido,
  updatePedido,
  deletePedido,
  assignRouteToOrder,
  updatePedidoEstado,
  createPedidoEtapa
};