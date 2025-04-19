# RespaldosChile Node.js Backend
Backend en Node.js con Express migrado desde un monolito PHP.

## Requisitos
- Docker y Docker Compose instalados.
- Node.js 18+ (opcional, para desarrollo local sin Docker)

## Primer arranque
1. Levantar los servicios (Node y MySQL):
```bash
docker-compose up -d
```
2. Instalar dependencias y preparar entorno:
```bash
cd backend
cp ../.env.example .env
npm install
```
3. Iniciar el servidor en modo desarrollo:
```bash
npm run dev
```
4. Abrir en el navegador: http://localhost:3000
5. Probar endpoint de test: http://localhost:3000/api/test (debe devolver JSON con mensaje y dbTest)

## Siguiente paso
 - Migrar módulos (Pedidos, Ventas, Dashboard) en ramas independientes dentro del directorio `backend`.

## Acceso a la Base de Datos

- MySQL (contenedor `db`):
  - Host: `localhost`
  - Puerto: `3306`
  - Usuario: `user`
  - Contraseña: `secret`
- phpMyAdmin (UI):
  - HTTP: http://localhost:8082
  - Usuario/Contraseña: `user` / `secret`