const pool = require('../db');

/**
 * Modelo de detalles de pedido.
 */
async function getAllByOrder(num_orden) {
  const [rows] = await pool.query(
    'SELECT * FROM pedido_detalle WHERE num_orden = ?',
    [num_orden]
  );
  return rows;
}

async function getById(id) {
  const [rows] = await pool.query(
    'SELECT * FROM pedido_detalle WHERE id = ?',
    [id]
  );
  return rows[0];
}

async function create(data) {
  // Extraer campos relevantes
  const columns = [];
  const placeholders = [];
  const values = [];
  for (const [key, value] of Object.entries(data)) {
    columns.push(key);
    placeholders.push('?');
    values.push(value);
  }
  const sql = `INSERT INTO pedido_detalle (${columns.join(',')}) VALUES (${placeholders.join(',')})`;
  const [result] = await pool.query(sql, values);
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
  const sql = `UPDATE pedido_detalle SET ${sets.join(',')} WHERE id = ?`;
  const [result] = await pool.query(sql, values);
  return result.affectedRows;
}

async function remove(id) {
  const [result] = await pool.query(
    'DELETE FROM pedido_detalle WHERE id = ?',
    [id]
  );
  return result.affectedRows;
}

module.exports = { getAllByOrder, getById, create, update, remove };