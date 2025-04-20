const express = require('express');
const router = express.Router();
const authController = require('../controllers/authController');
const { authenticateToken } = require('../middlewares/auth');

/**
 * @openapi
 * /api/auth/login:
 *   post:
 *     summary: Autentica un usuario y retorna un token JWT.
 *     tags:
 *       - Auth
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema:
 *             type: object
 *             properties:
 *               usuario:
 *                 type: string
 *               password:
 *                 type: string
 *     responses:
 *       '200':
 *         description: Autenticación exitosa.
 *         content:
 *           application/json:
 *             schema:
 *               type: object
 *               properties:
 *                 status:
 *                   type: string
 *                 redirect:
 *                   type: string
 *                 token:
 *                   type: string
 *       '400':
 *         description: Faltan datos.
 *       '401':
 *         description: Credenciales inválidas.
 *       '500':
 *         description: Error en el servidor.
 */
/**
 * POST /api/auth/login
 */
router.post('/login', authController.login);
/**
 * POST /api/auth/logout
 */
router.post('/logout', authController.logout);
/**
 * GET /api/auth/me
 */
router.get('/me', authenticateToken, authController.me);

module.exports = router;