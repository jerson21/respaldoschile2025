const model = require('../models/direccionesModel');

/**
 * Controller de Direcciones de clientes.
 */
async function getAll(req, res) {
  try {
    const rut = req.query.rut;
    const addresses = await model.getAllAddresses(rut);
    res.json({ status: 'success', data: addresses });
  } catch (error) {
    console.error(error);
    res.status(500).json({ status: 'error', error: 'Error al obtener direcciones.' });
  }
}

async function getById(req, res) {
  try {
    const id = req.params.id;
    const address = await model.getAddressById(id);
    if (!address) {
      return res.status(404).json({ status: 'error', error: 'Dirección no encontrada.' });
    }
    res.json({ status: 'success', data: address });
  } catch (error) {
    console.error(error);
    res.status(500).json({ status: 'error', error: 'Error al obtener la dirección.' });
  }
}

async function create(req, res) {
  try {
    const fields = req.body;
    const required = ['rut_cliente', 'direccion'];
    for (const f of required) {
      if (!fields[f]) {
        return res.status(400).json({ status: 'error', error: `Campo ${f} es obligatorio.` });
      }
    }
    const id = await model.createAddress(fields);
    res.status(201).json({ status: 'success', message: 'Dirección creada.', id });
  } catch (error) {
    console.error(error);
    res.status(500).json({ status: 'error', error: 'Error al crear la dirección.' });
  }
}

async function update(req, res) {
  try {
    const id = req.params.id;
    const fields = req.body;
    const affected = await model.updateAddress(id, fields);
    if (affected === 0) {
      return res.status(404).json({ status: 'error', error: 'Dirección no encontrada o sin cambios.' });
    }
    res.json({ status: 'success', message: 'Dirección actualizada.' });
  } catch (error) {
    console.error(error);
    res.status(500).json({ status: 'error', error: 'Error al actualizar la dirección.' });
  }
}

async function remove(req, res) {
  try {
    const id = req.params.id;
    const affected = await model.deleteAddress(id);
    if (affected === 0) {
      return res.status(404).json({ status: 'error', error: 'Dirección no encontrada.' });
    }
    res.json({ status: 'success', message: 'Dirección eliminada.' });
  } catch (error) {
    console.error(error);
    res.status(500).json({ status: 'error', error: 'Error al eliminar la dirección.' });
  }
}

module.exports = { getAll, getById, create, update, remove };