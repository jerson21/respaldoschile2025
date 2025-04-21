const pool = require('../db');

/**
 * Model for 'pago' entity.
 */
async function getAll() {
  const [rows] = await pool.query('SELECT * FROM pagos');
  return rows;
}

async function getById(id) {
  const [rows] = await pool.query(
    'SELECT * FROM pagos WHERE id = ?',
    [id]
  );
  return rows[0];
}

async function create(data) {
  const {
    num_orden,
    metodo_pago,
    id_cartola,
    datos_adicionales,
    monto,
    usuario,
    fecha_mov
  } = data;
  const [result] = await pool.query(
    'INSERT INTO pagos (num_orden, metodo_pago, id_cartola, datos_adicionales, monto, usuario, fecha_mov) VALUES (?, ?, ?, ?, ?, ?, ?)',
    [num_orden, metodo_pago, id_cartola || null, datos_adicionales || null, monto, usuario, fecha_mov]
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
  const sql = `UPDATE pagos SET ${sets.join(',')} WHERE id = ?`;
  const [result] = await pool.query(sql, values);
  return result.affectedRows;
}

async function remove(id) {
  const [result] = await pool.query(
    'DELETE FROM pagos WHERE id = ?',
    [id]
  );
  return result.affectedRows;
}

module.exports = { getAll, getById, create, update, remove };