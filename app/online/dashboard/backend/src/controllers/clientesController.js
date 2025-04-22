const model = require('../models/clientesModel');

/**
 * Controller de Clientes: manejadores de peticiones.
 */
async function getAll(req, res) {
  try {
    const clients = await model.getAllClients();
    res.json({ status: 'success', data: clients });
  } catch (error) {
    console.error(error);
    res.status(500).json({ status: 'error', error: 'Error al obtener clientes.' });
  }
}

async function getByRut(req, res) {
  try {
    const client = await model.getClientByRut(req.params.rut);
    if (!client) {
      return res.status(404).json({ status: 'error', error: 'Cliente no encontrado.' });
    }
    res.json({ status: 'success', data: client });
  } catch (error) {
    console.error(error);
    res.status(500).json({ status: 'error', error: 'Error al obtener cliente.' });
  }
}

async function create(req, res) {
  try {
    const { rut, nombre, telefono, correo, instagram } = req.body;
    if (!rut || !nombre) {
      return res.status(400).json({ status: 'error', error: 'Rut y nombre son obligatorios.' });
    }
    await model.createClient({ rut, nombre, telefono, correo, instagram });
    res.status(201).json({ status: 'success', message: 'Cliente creado.' });
  } catch (error) {
    console.error(error);
    res.status(500).json({ status: 'error', error: 'Error al crear cliente.' });
  }
}

async function update(req, res) {
  try {
    const rut = req.params.rut;
    const { nombre, telefono, correo, instagram } = req.body;
    const affected = await model.updateClient(rut, { nombre, telefono, correo, instagram });
    if (affected === 0) {
      return res.status(404).json({ status: 'error', error: 'Cliente no encontrado.' });
    }
    res.json({ status: 'success', message: 'Cliente actualizado.' });
  } catch (error) {
    console.error(error);
    res.status(500).json({ status: 'error', error: 'Error al actualizar cliente.' });
  }
}

async function remove(req, res) {
  try {
    const rut = req.params.rut;
    const affected = await model.deleteClient(rut);
    if (affected === 0) {
      return res.status(404).json({ status: 'error', error: 'Cliente no encontrado.' });
    }
    res.json({ status: 'success', message: 'Cliente eliminado.' });
  } catch (error) {
    console.error(error);
    res.status(500).json({ status: 'error', error: 'Error al eliminar cliente.' });
  }
}

module.exports = { getAll, getByRut, create, update, remove };