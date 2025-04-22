const pool = require('../db');

/**
 * Model for 'ruta' entity.
 */
async function getAll() {
  const [rows] = await pool.query('SELECT * FROM rutas');
  return rows;
}

async function getById(id) {
  const [rows] = await pool.query(
    'SELECT * FROM rutas WHERE id = ?',
    [id]
  );
  return rows[0];
}

async function create(data) {
  const { fecha, tipo } = data;
  const [result] = await pool.query(
    'INSERT INTO rutas (fecha, tipo) VALUES (?, ?)',
    [fecha, tipo]
  );
  return result.insertId;
}

async function update(id, data) {
  const sets = [];
  const values = [];
  for (const [key, value] of Object.entries(data)) {
    sets.push(`${key} = ?`);
    values.push(value);
  }
  if (sets.length === 0) return 0;
  values.push(id);
  const sql = `UPDATE rutas SET ${sets.join(',')} WHERE id = ?`;
  const [result] = await pool.query(sql, values);
  return result.affectedRows;
}

async function remove(id) {
  const [result] = await pool.query(
    'DELETE FROM rutas WHERE id = ?',
    [id]
  );
  return result.affectedRows;
}

// Sub-resource: pedidos assigned to ruta
async function getPedidosByRuta(rutaId) {
  const [rows] = await pool.query(
    'SELECT * FROM pedido_detalle WHERE ruta_asignada = ?',
    [rutaId]
  );
  return rows;
}

async function assignDetalle(rutaId, detalleId) {
  const [result] = await pool.query(
    'UPDATE pedido_detalle SET ruta_asignada = ? WHERE id = ?',
    [rutaId, detalleId]
  );
  return result.affectedRows;
}

async function unassignDetalle(detalleId) {
  const [result] = await pool.query(
    'UPDATE pedido_detalle SET ruta_asignada = 0 WHERE id = ?',
    [detalleId]
  );
  return result.affectedRows;
}

module.exports = {
  getAll,
  getById,
  create,
  update,
  remove,
  getPedidosByRuta,
  assignDetalle,
  unassignDetalle,
};