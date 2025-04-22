const pool = require('../db');

/**
 * Handler de prueba para verificar que la API funciona y la base de datos responde.
 */
async function test(req, res) {
  try {
    const [rows] = await pool.query('SELECT 1 + 1 AS result');
    res.json({ message: 'API is working', dbTest: rows[0].result });
  } catch (error) {
    console.error(error);
    res.status(500).json({ error: 'Database error' });
  }
}

module.exports = { test };