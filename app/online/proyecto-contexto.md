 # Proyecto Contexto - Respaldos Chile

 **Fecha de análisis:** 2025-04-21

 ## Estructura Actual
 - Mezcla de vistas (HTML/CSS/JS) y lógica PHP en mismos archivos.
 - Uso de PDO para acceso a datos.
 - Uso de jQuery, Bootstrap y Socket.IO para interacción en tiempo real.
 - Directorios principales:
   - `dashboard/`: panel de administración con múltiples módulos y scripts.
   - `bd/`, `sistema/`, `rbot/`, `salidadespacho/`, etc.: lógica dispersa.
   - `vistas/`: fragmentos de interfaz (navbar, encabezados, pies).
   - Archivos sueltos en raíz: `index.php`, `insert_ecommerce_pedido.php`, `codigo.js`, `estilos.css`.

 ## Tecnologías y dependencias
 - PHP 7.x+ con PDO.
 - Front-end: HTML, CSS, Bootstrap, jQuery.
 - Socket.IO y Node/ratchet para tiempo real en `rutinas/`.
 - Librerías de terceros en `dashboard/Libraries` y `dashboard/vendor`.
 - Sin estructura de autoload o Composer configurado.

 ## Principales problemas actuales
 1. Código altamente acoplado, difícil de mantener y escalar.
 2. Redundancia y duplicación de lógica en múltiples scripts.
 3. Ausencia de enrutamiento centralizado y separación de responsabilidades.
 4. Dificultad para aplicar pruebas unitarias o integración.

 ## Propuesta de migración a MVC
 - Configurar Composer y autoload PSR-4.
 - Crear Front Controller en `public/index.php`.
 - Definir carpetas:
   - `app/Controllers`
   - `app/Models`
   - `app/Views`
   - `app/Core` (Router, BaseController, BaseModel)
 - Archivos de configuración en `config/`.
 - Recursos públicos en `public/assets/`.

 ## Siguientes pasos

4. Configurar `.env` con credenciales de base de datos, URL de la API (`API_BASE_URL`) y otros valores.
6. Continuar migración del dashboard de pedidos usando llamadas al API desde el cliente (token en localStorage) para listar los pedidos.