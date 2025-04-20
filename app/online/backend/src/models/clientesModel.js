const pool = require('../db');

/**
 * Modelo de Clientes: funciones para acceder a la tabla clientes.
 */
async function getAllClients() {
  const [rows] = await pool.query(
    'SELECT rut, nombre, telefono, correo, instagram FROM clientes'
  );
  return rows;
}

async function getClientByRut(rut) {
  const [rows] = await pool.query(
    'SELECT rut, nombre, telefono, correo, instagram FROM clientes WHERE rut = ?',
    [rut]
  );
  return rows[0];
}

async function createClient({ rut, nombre, telefono, correo, instagram }) {
  const [result] = await pool.query(
    'INSERT INTO clientes (rut, nombre, telefono, correo, instagram) VALUES (?, ?, ?, ?, ?)',
    [rut, nombre, telefono, correo, instagram]
  );
  return result.insertId;
}

async function updateClient(rut, { nombre, telefono, correo, instagram }) {
  const [result] = await pool.query(
    'UPDATE clientes SET nombre = ?, telefono = ?, correo = ?, instagram = ? WHERE rut = ?',
    [nombre, telefono, correo, instagram, rut]
  );
  return result.affectedRows;
}

async function deleteClient(rut) {
  const [result] = await pool.query(
    'DELETE FROM clientes WHERE rut = ?',
    [rut]
  );
  return result.affectedRows;
}

module.exports = {
  getAllClients,
  getClientByRut,
  createClient,
  updateClient,
  deleteClient,
};