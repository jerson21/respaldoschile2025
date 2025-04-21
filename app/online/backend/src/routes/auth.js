const express = require('express');
const router = express.Router();
const authController = require('../controllers/authController');
const { authenticateToken } = require('../middlewares/auth');

/**
 * @openapi
 * tags:
 *   - name: Auth
 *     description: Autenticación de usuarios
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
router.post('/login', authController.login);
/**
 * @openapi
 * /api/auth/logout:
 *   post:
 *     summary: Cierra la sesión y elimina el token JWT en el cliente.
 *     tags: [Auth]
 *     responses:
 *       200:
 *         description: Logout exitoso.
 *         content:
 *           application/json:
 *             schema:
 *               type: object
 *               properties:
 *                 status:
 *                   type: string
 *                 message:
 *                   type: string
 */
router.post('/logout', authController.logout);
/**
 * @openapi
 * /api/auth/me:
 *   get:
 *     summary: Obtiene los datos del usuario autenticado.
 *     tags: [Auth]
 *     security:
 *       - bearerAuth: []
 *     responses:
 *       200:
 *         description: Información del usuario.
 *         content:
 *           application/json:
 *             schema:
 *               type: object
 *               properties:
 *                 status:
 *                   type: string
 *                 data:
 *                   type: object
 */
router.get('/me', authenticateToken, authController.me);

module.exports = router;