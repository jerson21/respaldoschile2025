const pool = require('../db');

/**
 * Model for 'pedido' entity.
 */
async function getAll() {
  const [rows] = await pool.query('SELECT * FROM pedido');
  return rows;
}

async function getById(id) {
  const [rows] = await pool.query(
    'SELECT * FROM pedido WHERE num_orden = ?',
    [id]
  );
  return rows[0];
}

async function create(data) {
  const {
    rut_cliente,
    fecha_ingreso,
    despacho,
    total_pagado,
    vendedor,
    metodo_entrega,
    estado,
    orden_ext
  } = data;
  const [result] = await pool.query(
    'INSERT INTO pedido (rut_cliente, fecha_ingreso, despacho, total_pagado, vendedor, metodo_entrega, estado, orden_ext) VALUES (?, ?, ?, ?, ?, ?, ?, ?)',
    [rut_cliente, fecha_ingreso, despacho, total_pagado, vendedor, metodo_entrega, estado, orden_ext]
  );
  return result.insertId;
}

async function update(id, data) {
  const {
    rut_cliente,
    fecha_ingreso,
    despacho,
    total_pagado,
    vendedor,
    metodo_entrega,
    estado,
    orden_ext
  } = data;
  const [result] = await pool.query(
    'UPDATE pedido SET rut_cliente = ?, fecha_ingreso = ?, despacho = ?, total_pagado = ?, vendedor = ?, metodo_entrega = ?, estado = ?, orden_ext = ? WHERE num_orden = ?',
    [rut_cliente, fecha_ingreso, despacho, total_pagado, vendedor, metodo_entrega, estado, orden_ext, id]
  );
  return result.affectedRows;
}

async function remove(id) {
  const [result] = await pool.query(
    'DELETE FROM pedido WHERE num_orden = ?',
    [id]
  );
  return result.affectedRows;
}

module.exports = { getAll, getById, create, update, remove };