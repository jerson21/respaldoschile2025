<?php require_once "init.php" ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pedidos</title>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <script src="https://kit.fontawesome.com/c5b4401310.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://www.respaldoschile.cl/assets/img/favicon.png" rel="icon">

    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/flatpickr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.css">
</head>

<body>
<?php require_once "vistas/parte_superior.php" ?>

<style>
    .btn-circle.btn-sm {
        width: 40px;
        height: 40px;
        padding: 6px 0px;
        border-radius: 20px;
        font-size: 8px;
        text-align: center;
    }
    /* Estilo para estado 5 (Iniciado/En Proceso) */
    .row-estado-5 {
        background-color: #a0c8ff !important; /* Un azul claro */
    }
    /* Estilo para estado 6 (Terminado) */
    .row-estado-6 {
        background-color: #d4edda !important; /* Verde claro */
    }
    /* Estilo para anclaje especial */
    .row-anclaje-especial {
         background-color: #FFE8A0 !important; /* Amarillo/Naranja */
    }

    /* Asegurar que los estilos de estado tengan prioridad si ambos aplican */
    .row-estado-6, .row-estado-5 {
        /* Puedes ajustar la prioridad si es necesario, pero !important suele ser suficiente */
    }

</style>

<div class="container">
    <h1>Producción Tapiceros - Respaldos Chile</h1>
    <div class="alert alert-info">
        <img width="15" src="img/patasmadera.jpg"> Patas de madera -
        <img width="15" src="img/anclaje.png"> Madera interior para anclaje -
        <b> B D </b> Boton Diamante
    </div>
</div>

<div id="contenido1" style="margin:0 auto; text-align: center;"></div>

<script src="//localhost:3000/socket.io/socket.io.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.all.min.js"></script>
<script>
// Base URL para la API Node.js y token JWT desde localStorage
const API_BASE = 'http://localhost:3000/api';
const TOKEN = localStorage.getItem('token') || '';

// Función para formatear los detalles del pedido para lectura y visualización
function formatPedido(p) {
    let modeloa = p.modelo.trim();
    // Lógica de mapeo original para modelos
    if (modeloa === 'Botone') modeloa = 'botoné Madrid, ';
    if (modeloa === 'Botone 4 corridas de botones') modeloa = 'botoné 4 corridas de botones, ';
    if (modeloa === 'Botone 3 corridas de botones') modeloa = 'botoné 3 corridas de botones, ';
    if (modeloa === 'Capitone') modeloa = 'capitoné';

    // Mapeo de tamaños a descripciones legibles
    let plazasMap = {
        '1': 'una plaza',
        '1 1/2': 'una plaza y media',
        '2': '2 plazas',
        '3': '3 cuerpos',
        '4': '4 cuerpos'
    };
    let plazas = plazasMap[p.tamano] || p.tamano; // Usa el mapeo o el valor original si no se encuentra
    let base = (p.alturabase !== '60') ? `, Base ${p.alturabase}` : ''; // Añade info de base si no es 60
    let tipo_boton = (p.tipo_boton === 'B D') ? ', Agregar botón Diamante' : ''; // Añade info de botón diamante
    let anclaje = '';
    if (p.anclaje === 'si') anclaje = ', Ocupar esqueleto con Madera de anclaje'; // Info de anclaje madera
    if (p.anclaje === 'patas') anclaje = ', Ocupar esqueleto con Patas de madera'; // Info de anclaje patas

    let comentario = p.comentarios ? '. Leer pantalla para ver detalles.' : ''; // Añade nota si hay comentarios

    // Construye la cadena final
    return `Solicitar tela para: ${modeloa}. ${plazas}, ${p.tipotela} ${p.color}${base}${tipo_boton}${anclaje}${comentario}`;
}

// Función para cambiar el estado de un detalle de pedido a través de la API
function cambiarEstado(detalleId, pedidoId, nuevoEstado) {
    // Enviar petición PUT con token de autenticación a la API
    fetch(`${API_BASE}/pedidos/${pedidoId}/detalles/${detalleId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${TOKEN}` // Incluye el token JWT
        },
        body: JSON.stringify({ estadopedido: nuevoEstado }) // Envía el nuevo estado en el cuerpo
    })
    .then(res => {
        if (!res.ok) {
            // Si la respuesta no es exitosa (ej. 401, 404, 500), lanza un error
            throw new Error(`Error HTTP ${res.status}: ${res.statusText}`);
        }
        return res.json(); // Procesa la respuesta JSON
    })
    .then(resp => {
        if (resp.status === 'success') {
            console.log(`Detalle ${detalleId} actualizado a estado ${nuevoEstado}`);
            // *** CORRECCIÓN CLAVE: Volver a renderizar después de un cambio exitoso ***
            // Esto asegura que la vista se actualice inmediatamente con los datos más recientes
            // obtenidos de la API, sin depender exclusivamente del socket.
            $('#contenido1').empty(); // Limpia el contenido actual
            renderTapicero(1); // Vuelve a renderizar para el tapicero 1
            renderTapicero(2); // Vuelve a renderizar para el tapicero 2
            // *************************************************************************
        } else {
            // Maneja errores reportados por la API en el cuerpo de la respuesta
            console.error('Error actualizando estado:', resp.error || 'Error desconocido');
            Swal.fire('Error', resp.error || 'Hubo un problema al actualizar el estado.', 'error');
        }
    })
    .catch(error => {
        // Captura errores de red o errores lanzados en el primer .then
        console.error('Error en la petición fetch:', error);
        Swal.fire('Error de Conexión', 'No se pudo comunicar con el servidor API.', 'error');
    });
}

// Función para renderizar la tabla de tareas para un tapicero específico
function renderTapicero(id) {
    // Obtener tareas con token JWT para autenticación desde la API
    fetch(`${API_BASE}/tapiceros/${id}/tareas`, {
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${TOKEN}` // Incluye el token JWT
        }
    })
    .then(res => {
        if (!res.ok) {
             // Si la respuesta no es exitosa, lanza un error
            throw new Error(`Error ${res.status}: ${res.statusText}`);
        }
        return res.json(); // Procesa la respuesta JSON
    })
    .then(data => {
        let pedidos = data.data || []; // Obtiene la lista de pedidos (detalles)
        let contador = 0;
        // Inicia la construcción del HTML para la tabla del tapicero
        let html = `<div style="background:white;border:1px solid #D1D1D1;border-radius:15px;width:700px;display:inline-block;margin:20px;padding:10px;">
            <h1>Tapicero ${id}</h1>
            <div class='alert alert-success text-center'>Pedidos en Fabricación</div>
            <table class="table table-striped" style="font-size:.8rem;"><thead><tr>
                <th>Id</th><th>Modelo</th><th>Tamaño</th><th>Alt</th><th>Tela</th><th>Color</th><th></th>
            </tr></thead><tbody>`;

        // Itera sobre cada pedido (detalle) para construir las filas de la tabla
        pedidos.forEach(p => {
            // *** NOTA sobre la visibilidad del estado 6: ***
            // Aquí se renderizan todos los pedidos que la API devuelve.
            // Si quieres que los pedidos en estado 6 de días anteriores no aparezcan,
            // esa lógica de filtrado DEBE implementarse en la API que responde a
            // ${API_BASE}/tapiceros/${id}/tareas. El cliente no tiene la fecha
            // en que el estado cambió para filtrar por sí mismo.

            contador++; // Incrementa el contador de pedidos mostrados
            let detalle = formatPedido(p); // Formatea el detalle para lectura

            // Determina las clases CSS para el estilo de la fila basado en el estado y anclaje
            let rowClasses = '';
            if (p.estadopedido == '6') {
                rowClasses += ' row-estado-6'; // Clase para estado 6 (verde)
            } else if (p.estadopedido == '5') {
                 rowClasses += ' row-estado-5'; // *** CORRECCIÓN: Clase para estado 5 (azul) ***
            }

            // Aplica la clase de anclaje si corresponde, pero solo si no es estado 6 (el verde tiene prioridad visual en tu descripción)
            // Si quieres que el anclaje amarillo se vea en estado 5, cambia la condición.
             if ((p.anclaje === 'si' || p.anclaje === 'patas') && p.estadopedido !== '6') {
                 rowClasses += ' row-anclaje-especial'; // Clase para anclaje especial (amarillo/naranja)
             }


            // Inicia la fila de la tabla con las clases de estilo determinadas
            html += `<tr class="${rowClasses.trim()}">
                <td>${p.id}</td>
                <td>${p.modelo}</td>
                <td>${p.tamano}</td>
                <td>${p.alturabase}</td>
                <td>${p.tipotela}</td>
                <td>${p.color}</td>
                <td class="text-center">`;

            // Añade el botón o ícono según el estado actual del pedido
            if (p.estadopedido == '2') {
                // Botón amarillo para iniciar fabricación (estado 2 -> 5)
                html += `<button class="btn btn-warning btn-circle btn-sm" onclick="leerYpopup(${p.id}, ${p.num_orden}, '${detalle.replace(/'/g, "\\'")}', '${p.estadopedido}')"></button>`;
            } else if (p.estadopedido == '5') {
                // Botón azul para finalizar fabricación (estado 5 -> 6)
                html += `<button class="btn btn-info btn-circle btn-sm" onclick="leerYpopup(${p.id}, ${p.num_orden}, '${detalle.replace(/'/g, "\\'")}', '${p.estadopedido}')"></button>`;
            } else if (p.estadopedido == '6') {
                // Botón verde (indicando terminado hoy) - al hacer click no hace nada según tu lógica actual
                 html += `<button class="btn btn-success btn-circle btn-sm" onclick="leerYpopup(${p.id}, ${p.num_orden}, '${detalle.replace(/'/g, "\\'")}', '${p.estadopedido}')"></button>`;
            } else if (p.estadopedido == '8') {
                // Ícono de camión para estado 8 (despachado)
                html += `<i class="fas fa-truck"></i>`;
            }
            html += `</td></tr>`; // Cierra la celda de acción y la fila
        });

        // Cierra la tabla y el contenedor del tapicero, mostrando el contador
        html += `</tbody></table><b>Cantidad: ${contador}</b></div>`;
        $('#contenido1').append(html); // Añade el HTML generado al contenedor principal
    })
    .catch(error => {
        // Captura errores en la petición fetch para obtener tareas
        console.error(`Error obteniendo tareas para tapicero ${id}:`, error);
        // Opcional: Mostrar un mensaje de error en la interfaz
        $('#contenido1').append(`<div class="alert alert-danger">Error al cargar tareas para Tapicero ${id}.</div>`);
    });
}

// Función para leer el detalle del pedido y mostrar un popup de confirmación
function leerYpopup(detalleId, pedidoId, texto, estado) {
    // Reemplaza comillas simples en el texto para evitar problemas en el string del onclick
     const cleanText = texto.replace(/'/g, "\\'");

    // Leer detalle mediante voz
    const utter = new SpeechSynthesisUtterance(cleanText);
    utter.lang = 'es-CL'; // Idioma español de Chile
    utter.rate = 0.9; // Velocidad de lectura
    window.speechSynthesis.cancel(); // Cancela cualquier lectura anterior
    window.speechSynthesis.speak(utter); // Inicia la lectura

    // Definir título del popup, texto del botón de confirmación y el próximo estado
    let title, confirmText, nextEstado;
    let showPopup = true; // Bandera para controlar si se muestra el popup

    if (estado == '2') {
        // Si el estado es 2 (pendiente de iniciar)
        title = `Pedido ${pedidoId} - Iniciar fabricación`;
        confirmText = 'Iniciar';
        nextEstado = 5; // El próximo estado será 5 (iniciado)
    } else if (estado == '5') {
        // Si el estado es 5 (en fabricación)
        title = `Pedido ${pedidoId} - Finalizar fabricación`;
        confirmText = 'Finalizar';
        nextEstado = 6; // El próximo estado será 6 (terminado)
    } else {
        // Si el estado es 6 o cualquier otro que no requiera acción desde el botón
        // No mostramos el popup de confirmación, solo se lee el detalle.
        showPopup = false;
        console.log(`Pedido ${pedidoId} - Estado ${estado}: No requiere acción de cambio.`);
    }

    // Mostrar el popup de SweetAlert2 si showPopup es true
    if (showPopup) {
        Swal.fire({
            title: title, // Título del popup
            text: cleanText, // Texto del detalle del pedido
            icon: 'info', // Ícono informativo
            showCancelButton: true, // Muestra el botón de cancelar
            confirmButtonText: confirmText, // Texto del botón de confirmar
            cancelButtonText: 'Cancelar', // Texto del botón de cancelar
            reverseButtons: true // Invierte el orden de los botones (Confirmar a la derecha)
        }).then((result) => {
            // Maneja el resultado de la interacción del usuario con el popup
            if (result.isConfirmed) {
                // Si el usuario hizo click en Confirmar
                cambiarEstado(detalleId, pedidoId, nextEstado); // Llama a la función para cambiar el estado
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                // Si el usuario hizo click en Cancelar o cerró el popup
                console.log('Acción cancelada por el usuario.');
            }
        });
    }
}

// Inicializar Socket.io para recibir actualizaciones en tiempo real
const socket = io('http://localhost:3000');

// Evento que se dispara cuando el cliente se conecta al servidor Socket.io
socket.on('connect', () => {
  console.log('Conectado al servidor Socket.io');
  // Unirse a las salas de los tapiceros 1 y 2 para recibir sus actualizaciones
  socket.emit('joinTapiceroRoom', 1);
  socket.emit('joinTapiceroRoom', 2);
});
// Escuchar actualizaciones de pedidos y recargar automáticamente
socket.on('pedidoUpdated', (data) => {
  console.log('pedidoUpdated recibido:', data);
  $('#contenido1').empty();
  renderTapicero(1);
  renderTapicero(2);
});

// Evento que se dispara cuando se asigna una nueva tarea (o se actualiza una existente)
// Este evento viene del servidor y nos indica que algo ha cambiado, forzando una re-renderización.
// NOTA: Con la corrección en cambiarEstado, esta actualización por socket es más un respaldo
// o para cambios hechos por otros usuarios/procesos, la actualización inmediata tras click
// del usuario ya no depende solo de esto.
// Evento que se dispara cuando se crea una nueva tarea (emitido ahora como 'taskCreated')
socket.on('taskCreated', (task) => {
  console.log('Evento taskCreated recibido:', task);
  // Re-renderiza todas las tablas para reflejar la nueva tarea
  $('#contenido1').empty();
  renderTapicero(1);
  renderTapicero(2);
});

// Evento que se dispara cuando se actualiza una tarea existente
// Similar a newTaskAssigned, asegura que los cambios hechos por otros se reflejen.
socket.on('taskUpdated', (task) => {
   console.log('Evento taskUpdated recibido:', task);
   // Re-renderiza todas las tablas para reflejar el cambio de estado
   $('#contenido1').empty();
   renderTapicero(1);
   renderTapicero(2);
});

// Render inicial al cargar la página
$(document).ready(() => {
    console.log('Documento listo, renderizando inicialmente.');
    renderTapicero(1); // Renderiza tareas para tapicero 1
    renderTapicero(2); // Renderiza tareas para tapicero 2
});
</script>

<?php
// Muestra la fecha y hora actual (zona horaria configurada en el servidor PHP)
date_default_timezone_set('America/Santiago'); // Asegura la zona horaria si no está en php.ini
echo date('d-m-Y h:i:s a');
?>

<?php require_once "vistas/parte_inferior.php" ?>
