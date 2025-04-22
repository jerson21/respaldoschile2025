const pool = require('../db');
const bcrypt = require('bcryptjs');
const jwt = require('jsonwebtoken');

/**
 * Autentica un usuario y retorna un token JWT.
 */
async function login(req, res) {
  const { usuario, password } = req.body;
  if (!usuario || !password) {
    return res.status(400).json({ status: 'error', error: 'Usuario o contraseña no enviados.' });
  }
  try {
    const [rows] = await pool.query('SELECT * FROM usuarios WHERE usuario = ?', [usuario]);
    if (rows.length === 0) {
      return res.status(401).json({ status: 'error', error: 'Usuario o contraseña incorrectos.' });
    }
    const user = rows[0];
    // Compatibilidad con hashes PHP $2y$ cambiando al prefijo $2a$ si es necesario
    let hash = user.password;
    if (hash.startsWith('$2y$')) {
      hash = '$2a$' + hash.slice(4);
    }
    const match = await bcrypt.compare(password, hash);
    if (!match) {
      return res.status(401).json({ status: 'error', error: 'Usuario o contraseña incorrectos.' });
    }
    const token = jwt.sign(
      { usuario: user.usuario, privilegios: user.privilegios },
      process.env.JWT_SECRET || 'secret',
      { expiresIn: '1h' }
    );
    return res.json({ status: 'success', redirect: '/dashboard/', token });
  } catch (error) {
    console.error(error);
    return res.status(500).json({ status: 'error', error: 'Error en el servidor.' });
  }
}

/**
 * Logout: notifica al cliente que elimine el token.
 */
function logout(req, res) {
  // En APIs con JWT stateless, el cliente debe descartar el token
  res.json({ status: 'success', message: 'Logged out' });
}

/**
 * Devuelve datos del usuario autenticado.
 */
function me(req, res) {
  // req.user establecido por el middleware authenticateToken
  res.json({ status: 'success', user: req.user });
}

module.exports = { login, logout, me };