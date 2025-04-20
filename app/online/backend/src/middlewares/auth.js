const jwt = require('jsonwebtoken');

/**
 * Middleware para validar JWT en headers Authorization: Bearer <token>
 */
function authenticateToken(req, res, next) {
  const authHeader = req.headers['authorization'];
  const token = authHeader && authHeader.split(' ')[1];
  if (!token) {
    return res.status(401).json({ status: 'error', error: 'Token no proporcionado.' });
  }
  jwt.verify(token, process.env.JWT_SECRET || 'secret', (err, user) => {
    if (err) {
      return res.status(403).json({ status: 'error', error: 'Token inválido.' });
    }
    req.user = user;
    next();
  });
}

module.exports = { authenticateToken };