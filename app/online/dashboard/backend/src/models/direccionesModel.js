const pool = require('../db');

/**
 * Modelo de Direcciones de clientes.
 */
async function getAllAddresses(rut) {
  if (rut) {
    const [rows] = await pool.query(
      'SELECT id, rut_cliente, direccion, numero, dpto, region, comuna, referencia, estado FROM direccion_clientes WHERE rut_cliente = ?',
      [rut]
    );
    return rows;
  }
  const [rows] = await pool.query(
    'SELECT id, rut_cliente, direccion, numero, dpto, region, comuna, referencia, estado FROM direccion_clientes'
  );
  return rows;
}

async function getAddressById(id) {
  const [rows] = await pool.query(
    'SELECT id, rut_cliente, direccion, numero, dpto, region, comuna, referencia, estado FROM direccion_clientes WHERE id = ?',
    [id]
  );
  return rows[0];
}

async function createAddress({ rut_cliente, direccion, numero, dpto, region, comuna, referencia, estado }) {
  const [result] = await pool.query(
    'INSERT INTO direccion_clientes (rut_cliente, direccion, numero, dpto, region, comuna, referencia, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?)',
    [rut_cliente, direccion, numero, dpto, region, comuna, referencia, estado || 1]
  );
  return result.insertId;
}

async function updateAddress(id, fields) {
  const keys = [];
  const values = [];
  for (const [k, v] of Object.entries(fields)) {
    keys.push(`${k} = ?`);
    values.push(v);
  }
  if (keys.length === 0) return 0;
  values.push(id);
  const sql = `UPDATE direccion_clientes SET ${keys.join(', ')} WHERE id = ?`;
  const [result] = await pool.query(sql, values);
  return result.affectedRows;
}

async function deleteAddress(id) {
  const [result] = await pool.query(
    'DELETE FROM direccion_clientes WHERE id = ?',
    [id]
  );
  return result.affectedRows;
}

module.exports = {
  getAllAddresses,
  getAddressById,
  createAddress,
  updateAddress,
  deleteAddress,
};