const pagosModel = require('../models/pagosModel');

/**
 * Controller for 'pago' entity.
 */
// Campos permitidos para crear/actualizar pagos
const ALLOWED_FIELDS = [
  'num_orden',
  'metodo_pago',
  'id_cartola',
  'datos_adicionales',
  'monto',
  'usuario',
  'fecha_mov'
];

async function getAllPagos(req, res) {
  try {
    const pagos = await pagosModel.getAll();
    res.json({ status: 'success', data: pagos });
  } catch (error) {
    console.error(error);
    res.status(500).json({ status: 'error', error: 'Failed to fetch pagos' });
  }
}

async function getPagoById(req, res) {
  const { id } = req.params;
  try {
    const pago = await pagosModel.getById(id);
    if (!pago) return res.status(404).json({ status: 'error', error: 'Pago no encontrado.' });
    res.json({ status: 'success', data: pago });
  } catch (error) {
    console.error(error);
    res.status(500).json({ status: 'error', error: 'Failed to fetch pago' });
  }
}

async function createPago(req, res) {
  try {
    // Construir objeto con campos permitidos
    const data = {};
    ALLOWED_FIELDS.forEach(key => {
      if (req.body[key] !== undefined) data[key] = req.body[key];
    });
    const id = await pagosModel.create(data);
    res.status(201).json({ status: 'success', id });
  } catch (error) {
    console.error(error);
    res.status(500).json({ status: 'error', error: 'Failed to create pago' });
  }
}

async function updatePago(req, res) {
  const { id } = req.params;
  try {
    const data = {};
    ALLOWED_FIELDS.forEach(key => {
      if (req.body[key] !== undefined) data[key] = req.body[key];
    });
    const affected = await pagosModel.update(id, data);
    if (!affected) return res.status(404).json({ status: 'error', error: 'Pago no encontrado.' });
    res.json({ status: 'success', updated: affected });
  } catch (error) {
    console.error(error);
    res.status(500).json({ status: 'error', error: 'Failed to update pago' });
  }
}

async function deletePago(req, res) {
  const { id } = req.params;
  try {
    const affected = await pagosModel.remove(id);
    if (!affected) return res.status(404).json({ status: 'error', error: 'Pago no encontrado.' });
    res.json({ status: 'success', message: 'Pago eliminado.' });
  } catch (error) {
    console.error(error);
    res.status(500).json({ status: 'error', error: 'Failed to delete pago' });
  }
}

module.exports = {
  getAllPagos,
  getPagoById,
  createPago,
  updatePago,
  deletePago
};