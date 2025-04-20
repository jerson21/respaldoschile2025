const express = require('express');
const router = express.Router();
const testController = require('../controllers/testController');

/**
 * @openapi
 * /api/test:
 *   get:
 *     summary: Verifica que el servidor y la base de datos están operativos.
 *     description: Retorna un mensaje y el resultado de la prueba de base de datos.
 *     responses:
 *       200:
 *         description: API is working
 *         content:
 *           application/json:
 *             schema:
 *               type: object
 *               properties:
 *                 message:
 *                   type: string
 *                 dbTest:
 *                   type: integer
 *       500:
 *         description: Database error
 */
router.get('/test', testController.test);

module.exports = router;