const errorHandler = (err, req, res, next) => {
  console.error(err.stack);

  // Errores de validación
  if (err.name === 'ValidationError') {
    return res.status(400).json({
      error: 'Error de validación',
      details: err.message
    });
  }

  // Errores de base de datos
  if (err.code === 'ER_DUP_ENTRY') {
    return res.status(409).json({
      error: 'Registro duplicado',
      details: 'Ya existe un registro con estos datos'
    });
  }

  // Errores de autenticación
  if (err.name === 'UnauthorizedError') {
    return res.status(401).json({
      error: 'No autorizado',
      details: 'Token inválido o expirado'
    });
  }

  // Error por defecto
  res.status(500).json({
    error: 'Error interno del servidor',
    details: process.env.NODE_ENV === 'development' ? err.message : 'Ocurrió un error inesperado'
  });
};

module.exports = errorHandler; 