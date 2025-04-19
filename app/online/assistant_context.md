y# Contexto de la aplicación

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

## Próximos pasos
- Definir endpoints REST para recursos principales (p.ej. `/api/pedidos`, `/api/rutas`).
- Crear modelos (`models/`) y controladores (`controllers/`) para entidades.
- Comenzar migración de lógica de scripts PHP del dashboard a controladores Node.js.
- Revisar y ajustar variables de entorno