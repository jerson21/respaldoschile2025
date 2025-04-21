const {
  getDistinctTapiceros,
  getAllByTapicero,
  getTareasByTapicero: modelGetTareasByTapicero,
  update: updateDetalle,
  addEtapaDetalle
} = require('../models/pedidoDetalleModel');

/**
 * Controlador para obtener tapiceros con pedidos.
 */
async function getTapiceros(req, res) {
  try {
    const rows = await getDistinctTapiceros();
    // Mapear tapicero_id nulo a 'unassigned'
    const ids = rows.map(r => (
      r.tapicero_id === null ? 'unassigned' : r.tapicero_id
    ));
    res.json({ status: 'success', data: ids });
  } catch (error) {
    console.error('Error al obtener tapiceros:', error);
    res.status(500).json({ status: 'error', error: 'Error al obtener tapiceros.' });
  }
}

/**
 * Controlador para obtener detalles de pedido por tapicero.
 */
async function getPedidosByTapicero(req, res) {
  try {
    let { tapiceroId } = req.params;
    // Ajustar tapicero sin asignar
    if (tapiceroId === 'unassigned') tapiceroId = null;
    const detalles = await getAllByTapicero(tapiceroId);
    res.json({ status: 'success', data: detalles });
  } catch (error) {
    console.error(`Error al obtener pedidos de tapicero ${req.params.tapiceroId}:`, error);
    res.status(500).json({ status: 'error', error: 'Error al obtener pedidos por tapicero.' });
  }
}
/**
 * Controlador para obtener tareas (detalles con última etapa) por tapicero.
 */
async function getTareasByTapicero(req, res) {
  try {
    let { tapiceroId } = req.params;
    if (tapiceroId === 'unassigned') tapiceroId = null;
    const tareas = await modelGetTareasByTapicero(tapiceroId);
    // Logging the number of tasks returned for debugging
    console.log(`[${new Date().toISOString()}] GET /api/tapiceros/${req.params.tapiceroId}/tareas → items=`, tareas.length);
    res.json({ status: 'success', data: tareas });
  } catch (error) {
    console.error(`Error al obtener tareas de tapicero ${req.params.tapiceroId}:`, error);
    res.status(500).json({ status: 'error', error: 'Error al obtener tareas por tapicero.' });
  }
}

/**
 * Controlador para asignar un tapicero a un pedido y registrar etapa de fabricación.
 */
async function assignTapicero(req, res) {
  try {
    const { tapiceroId, pedidoId } = req.params;
    // Asignar tapicero
    const assigned = await updateDetalle(pedidoId, { tapicero_id: tapiceroId });
    if (!assigned) {
      return res.status(400).json({ status: 'error', error: 'No se pudo asignar tapicero' });
    }
    // Registrar etapa FABRICANDO (idProceso = 5)
    await addEtapaDetalle(pedidoId, 5);
    // Emitir evento para notificar a clientes en tiempo real
    try {
      const io = req.app.get('io');
      io.emit('pedidoUpdated', { pedidoId: pedidoId, tapiceroId, action: 'assigned' });
    } catch (e) {
      console.error('Error emitiendo evento WebSocket:', e);
    }
    res.json({ status: 'success' });
  } catch (error) {
    console.error(`Error asignando tapicero a pedido ${req.params.pedidoId}:`, error);
    res.status(500).json({ status: 'error', error: 'Error interno al asignar tapicero.' });
  }
}

/**
 * Controlador para desasignar el tapicero de un pedido.
 */
async function unassignTapicero(req, res) {
  try {
    const { pedidoId } = req.params;
    const updated = await updateDetalle(pedidoId, { tapicero_id: null });
    if (!updated) {
      return res.status(400).json({ status: 'error', error: 'No se pudo desasignar tapicero' });
    }
    // Emitir evento para notificar a clientes en tiempo real
    try {
      const io = req.app.get('io');
      io.emit('pedidoUpdated', { pedidoId: pedidoId, action: 'unassigned' });
    } catch (e) {
      console.error('Error emitiendo evento WebSocket:', e);
    }
    res.json({ status: 'success' });
  } catch (error) {
    console.error(`Error desasignando tapicero de pedido ${req.params.pedidoId}:`, error);
    res.status(500).json({ status: 'error', error: 'Error interno al desasignar tapicero.' });
  }
}

module.exports = {
  getTapiceros,
  getPedidosByTapicero,
  getTareasByTapicero,
  assignTapicero,
  unassignTapicero
};