const express = require('express');
const router = express.Router();
const testController = require('../controllers/testController');

/**
 * Ruta GET /api/test
 * Verifica que el servidor y la base de datos están operativos.
 */
router.get('/test', testController.test);

module.exports = router;