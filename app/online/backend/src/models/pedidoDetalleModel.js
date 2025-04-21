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
/**
 * Actualiza el orden de ruta (orden_ruta) de un detalle de pedido.
 * @param {number} id - ID del detalle de pedido
 * @param {number} ordenRuta - Nuevo valor de orden_ruta
 * @returns {Promise<number>} Filas afectadas
 */
async function updateOrden(id, ordenRuta) {
  const [result] = await pool.query(
    'UPDATE pedido_detalle SET orden_ruta = ? WHERE id = ?',
    [ordenRuta, id]
  );
  return result.affectedRows;
}
/**
 * Obtener detalles de pedido asignados a un tapicero.
 * @param {number|null|string} tapiceroId - ID del tapicero o 'unassigned'/null.
 * @returns {Promise<Array>} Detalles de pedido.
 */
async function getAllByTapicero(tapiceroId) {
  let rows;
  if (tapiceroId === null || tapiceroId === 'unassigned') {
    [rows] = await pool.query(
      'SELECT * FROM pedido_detalle WHERE tapicero_id IS NULL'
    );
  } else {
    [rows] = await pool.query(
      'SELECT * FROM pedido_detalle WHERE tapicero_id = ?',
      [tapiceroId]
    );
  }
  return rows;
}
/**
 * Obtener lista de tapiceros distintos de los pedidos.
 * @returns {Promise<Array>} Array de objetos con propiedad tapicero_id.
 */
async function getDistinctTapiceros() {
  const [rows] = await pool.query(
    'SELECT DISTINCT tapicero_id FROM pedido_detalle'
  );
  return rows;
}
/**
 * Registrar una nueva etapa para un detalle de pedido.
 * @param {number} idPedido - ID del detalle de pedido
 * @param {number} idproceso - ID del proceso (etapa)
 * @returns {Promise<number>} ID de la nueva etapa
 */
async function addEtapaDetalle(idPedido, idproceso) {
  const [result] = await pool.query(
    'INSERT INTO pedido_etapas (idPedido, idproceso, fecha) VALUES (?, ?, NOW())',
    [idPedido, idproceso]
  );
  return result.insertId;
}
/**
 * Obtener tareas (detalles con su última etapa) para un tapicero.
 * Incluye detalle de pedido y su última etapa, filtrado por estado o etapa del día.
 * @param {number|null|string} tapiceroId - ID del tapicero o 'unassigned'/null
 * @returns {Promise<Array>} Array de filas con campos de pedido_detalle y pedido_etapas
 */
async function getTareasByTapicero(tapiceroId) {
  // Construir SQL para filtrar tapicero
  let sql = `
    SELECT
      d.*,
      CASE WHEN EXISTS (
        SELECT 1 FROM pedido_etapas pe
        WHERE pe.idPedido = d.id
          AND pe.idproceso = 3
      ) THEN 1 ELSE 0 END AS telalista
    FROM pedido_detalle d
    JOIN (
      SELECT idPedido, MAX(fecha) AS max_fecha
      FROM pedido_etapas
      GROUP BY idPedido
    ) ult ON ult.idPedido = d.id
    JOIN pedido_etapas pd ON pd.idPedido = ult.idPedido AND pd.fecha = ult.max_fecha
    WHERE`;
  const params = [];
  if (tapiceroId === null || tapiceroId === 'unassigned') {
    sql += ` d.tapicero_id IS NULL`;
  } else {
    sql += ` d.tapicero_id = ?`;
    params.push(tapiceroId);
  }
  sql += ` AND (
      d.estadopedido IN (2, 5)
      OR (d.estadopedido = 6 AND DATE(pd.fecha) = CURDATE())
    )
    ORDER BY d.estadopedido DESC, d.tamano ASC, d.color ASC`;
  // Logging SQL and parameters for debugging stale reads
  console.debug(`[${new Date().toISOString()}] SQL getTareasByTapicero →`, sql.trim(), params);
  const [rows] = await pool.query(sql, params);
  console.debug(`[${new Date().toISOString()}] getTareasByTapicero rows returned=`, rows.length);
  return rows;
}

module.exports = {
  getAllByOrder,
  getById,
  create,
  update,
  remove,
  updateOrden,
  getAllByTapicero,
  getDistinctTapiceros,
  addEtapaDetalle,
  getTareasByTapicero
};