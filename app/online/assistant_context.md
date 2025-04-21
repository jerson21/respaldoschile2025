 - Recursos implementados:
   - Autenticación: login, logout, me (+ middleware JWT).
   - Clientes: modelo, controlador y rutas CRUD (`/api/clientes`).
   - Direcciones: modelo, controlador y rutas CRUD (`/api/direcciones`).
   - Detalles de pedido: sub-recurso modelo, controlador y rutas CRUD (`/api/pedidos/{pedidoId}/detalles`).
     - GET `/api/pedidos/{pedidoId}/detalles`, GET `/api/pedidos/{pedidoId}/detalles/:id`, POST, PUT, DELETE con JWT y validación.
   - Rutas: modelo, controlador y rutas CRUD (`/api/rutas`), incluido sub-recurso para asignar y desasignar pedidos (`/api/rutas/:id/pedidos`).
   - Pagos: modelo, controlador y rutas CRUD (`/api/pagos`), con validación de entrada (express-validator).

- Próximos recursos:
  - Pedidos: listado, detalle, creación, actualización, eliminación.
  - Adaptación del frontend legacy para consumir `/api/rutas` y `/api/pagos`.
  - Completar documentación OpenAPI (Swagger) de todos los nuevos endpoints.
  - QA y pruebas automatizadas (unitarias e integración).
## Contexto de la aplicación

## Estructura actual
- Raíz del proyecto:
  - `index.php` y monolito PHP principal
  - Carpeta `dashboard/` con scripts PHP, CSS, JS, BD, vistas, vendor…
  - Carpeta `backend/` con servidor Node.js/Express (`index.js`, `package.json`, `.env`)
  - Archivos Docker: `Dockerfile`, `docker-compose.yml`, `.env.example`

## Objetivo principal
Migrar toda la lógica del dashboard (PHP) a un backend organizado en Node.js, exponer una API REST y reestructurar el frontend.

## Plan de migración por fases
1. Estructura y configuración
   - Reubicar `index.js` en `backend/src/`
   - Crear carpetas `routes/`, `controllers/`, `models/`, `db.js`, `middlewares/`
   - Ajustar `docker-compose.yml` para Node.js
2. Diseño de la API
   - Definir endpoints REST (`/api/pedidos`, `/api/rutas`, etc.)
   - Documentar con OpenAPI o README en `backend/`
3. Migración de lógica de datos
   - Reescribir scripts PHP en JavaScript/Node
   - Organizar queries en `models/`
4. Adaptación del frontend
   - Extraer HTML/JS/CSS de `dashboard/` a `frontend/`
   - Cambiar llamadas AJAX a nuevos endpoints `/api`
5. Depuración y QA
   - Pruebas de cada flujo (pedidos, rutas, pagos…)
   - Eliminar código PHP obsoleto

- ## Estado actual
- Estructura base creada en `backend/src` con carpetas `controllers`, `routes`, `models`, archivo `db.js` y `src/index.js` reubicado.
- Endpoint de prueba `GET /api/test` implementado y listo para verificar.
  - Autenticación:
    - Nuevo controlador `POST /api/auth/login` implementado en `backend/src/controllers/authController.js`, que usa bcryptjs para verificar credenciales y genera un JWT (expira en 1h).
    - Se añade compatibilidad con hashes de PHP `$2y$`, reemplazando el prefijo `$2y$` por `$2a$` antes de la comparación.
  - Ruta registrada en `backend/src/routes/auth.js` y montada con CORS habilitado (`app.use(cors())`) en `backend/src/index.js`.
  - Dependencias añadidas: `cors`, `bcryptjs`, `jsonwebtoken` en `package.json`.
  - Integración de login en `codigo.js`:
    - Primero autentica contra Node (`/api/auth/login`), almacena el JWT.
    - Luego invoca `/bd/login.php` (con `xhrFields: { withCredentials: true }`) para establecer la sesión PHP.
    - Redirige al dashboard legacy (`dashboard/`) tras confirmar ambos logins.

## Próximos pasos
-- Autenticación y seguridad:
  - Middleware JWT implementado en `backend/src/middlewares/auth.js`.
  - Extendido `authController` con `me` y `logout`:
    - POST `/api/auth/logout` devuelve estado y fuerza borrado de token en cliente.
    - GET `/api/auth/me` devuelve datos del usuario autenticado.
- Migración de funcionalidades:
- Migración de funcionalidades:
  - Migrar lógica de `dashboard/bd/*` a rutas REST en `backend/src/routes/`.
  - Desarrollar controladores para `POST`, `GET`, `PUT`, `DELETE` en `/api/pedidos`, `/api/rutas`, `/api/pagos`, etc.
- Adaptación del frontend legacy:
  - Reemplazar llamadas AJAX en `dashboard/` por peticiones a `/api/...`, incluyendo header `Authorization: Bearer <token>`.
  - Ajustar vistas y plantillas para renderizar datos desde la nueva API.
- Documentación y QA:
  - Completar documentación OpenAPI (Swagger) con todos los nuevos endpoints.
  - Configurar pruebas automáticas (unitarias o de integración) para los endpoints críticos.

## Cómo probar en Postman

- Paso 0: Preparar entorno
  - Levanta el servidor Node.js (`npm start` o `docker-compose up`) y asegúrate de que esté escuchando en `http://localhost:3000` (o el puerto configurado).
  - En Postman crea un _Environment_ con variable `base_url = http://localhost:3000/api`.

- Paso 1: Autenticación y obtención de token
  1. Crea petición `POST {{base_url}}/auth/login`.
     - Headers: `Content-Type: application/json`
     - Body (raw, JSON):
       {
         "usuario": "tu_usuario",
         "password": "tu_contraseña"
       }
  2. Envía la petición y copia el campo `token` de la respuesta.
  3. Define variable de entorno `auth_token` con ese valor.

- Paso 2: Probar endpoints protegidos
  - En pestaña Authorization elige tipo Bearer Token e ingresa `{{auth_token}}`.
  - O bien, añade header:
    - `Authorization: Bearer {{auth_token}}`

- Paso 3: Ejemplos de peticiones
  - `GET {{base_url}}/auth/me` — info del usuario.
  - **Clientes**: `GET {{base_url}}/clientes` / `POST {{base_url}}/clientes` (JSON según schema).
  - **Pedidos**: `GET {{base_url}}/pedidos` / `POST {{base_url}}/pedidos` (JSON `PedidoInput`).
  - **Detalles de pedido**: `GET {{base_url}}/pedidos/{{id}}/detalles`.

- Paso 4: Logout (opcional)
  - `POST {{base_url}}/auth/logout` — devuelve `status` y `message`.

- Consejo:
  - Importa el spec de Swagger en Postman (`http://localhost:3000/api-docs`).
  - Renueva `auth_token` al expirar (p.ej. 1 hora).