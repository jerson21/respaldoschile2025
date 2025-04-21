<?php require "init.php";?>
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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
     <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/flatpickr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.css">

    <style>
        /* Estilos personalizados para botones - Ajustados para mejor interacción táctil y consistencia */
        .btn-circle.btn-sm,
        .btn-confirmar.btn-sm { /* Aplicar estos estilos también al botón de confirmación */
            width: 36px; /* Ligeramente más grande para mejor tacto */
            height: 36px; /* Ligeramente más grande */
            padding: 0; /* Quitar padding */
            border-radius: 50%; /* Hacerlo completamente circular */
            font-size: 0.85rem; /* Texto/icono ligeramente más grande */
            text-align: center;
            display: inline-flex; /* Usar flexbox para centrar icono */
            align-items: center;
            justify-content: center;
            flex-shrink: 0; /* Prevenir encogimiento en espacios reducidos */
        }

        /* Color específico para Desasignar */
        .btn-desasignar {
             /* Mantener verde */
             background-color: #1cc88a; /* Éxito de SB Admin 2 */
             border-color: #1cc88a;
             color: white;
        }

        /* Color específico para Asignar */
        .btn-asignar-tapicero {
             /* Mantener amarillo advertencia */
             background-color: #f6c23e; /* Advertencia de SB Admin 2 */
             border-color: #f6c23e;
             color: #333; /* Asegurar texto legible sobre amarillo */
        }

        /* Colores de Botones de Estado (movidos de estilos en línea) */
        .btn-estado-pedido {
             min-width: 100px; /* Dar a los botones de estado un ancho mínimo */
             text-align: center;
        }
        .btn-estado-aceptado { /* Corresponde a estadopedido 1 */
             background-color: #e4e6f0; /* Gris claro */
             border-color: #e4e6f0;
             color: #444;
        }
        .btn-estado-por-fabricar { /* Corresponde a estadopedido 2, sin tapicero */
             background-color: #f6c23e; /* Amarillo advertencia */
             border-color: #f6c23e;
             color: #333;
        }
         .btn-estado-en-fabricacion { /* Corresponde a estadopedido 2, con tapicero */
             background-color: #36b9cc; /* Azul info */
             border-color: #36b9cc;
             color: white;
        }
         .btn-estado-listo { /* Corresponde a estadopedido 3 */
             background-color: #36b9cc; /* Azul info */
             border-color: #36b9cc;
             color: white;
        }
        .btn-estado-reagendar { /* Corresponde a estadopedido 9 */
             background-color: #f6c23e; /* Amarillo advertencia */
             border-color: #f6c23e;
             color: #333;
        }
        .btn-estado-asignado-ruta { /* Corresponde a estadopedido 4 */
            background-color: #FF338A; /* Tu color específico */
            border-color: #FF338A;
            color: white;
        }
         .btn-estado-entregado { /* Corresponde a estadopedido 5 */
            background-color: #ABFF71; /* Tu color específico */
            border-color: #ABFF71;
             color: #333; /* Ajustar color de texto si es necesario */
        }

        /* Ajustes de tabla responsiva */
        .table-responsive-modern {
            overflow-x: auto; /* Asegurar scroll horizontal si es necesario */
            -webkit-overflow-scrolling: touch; /* Scroll suave en iOS */
            width: 100%; /* Usar ancho completo del contenedor */
            border: 1px solid #e3e6f0;
            padding-bottom: 1px; /* Arreglar posible problema de borde con tablas rayadas */
            background-color: transparent;
             border: none; /* Quitar borde aquí, la tarjeta lo proporcionará */
             box-shadow: none; /* Quitar sombra aquí */
        }

        .table-modern {
            margin-bottom: 0;
            border: none;
        }

        .table-modern th,
        .table-modern td {
            white-space: nowrap; /* Prevenir ajuste de texto en celdas */
            padding: 0.75rem 1rem; /* Padding ajustado para mejor espaciado */
            vertical-align: middle; /* Alinear verticalmente contenido de celda */
             border-top: 1px solid #e3e6f0; /* Borde sutil entre filas */
             color: #333; /* Color de texto por defecto para cuerpo de tabla */
        }
        .table-modern th {
             padding-top: 1rem;
             padding-bottom: 1rem;
             border-bottom: 2px solid #e3e6f0; /* Borde más grueso bajo encabezado */
             color: #5a5c69; /* Color de texto de encabezado por defecto */
        }

         /* Estilo para la columna 'Orden' */
         .table-modern th:nth-child(2),
         .table-modern td:nth-child(2) {
             min-width: 60px; /* Ancho mínimo para la columna 'Orden' */
             width: 80px; /* Ancho preferido, permite encogerse */
             max-width: 100px; /* Ancho máximo */
             overflow: hidden; /* Ocultar desbordamiento si el contenido es muy ancho */
             text-overflow: ellipsis; /* Añadir puntos suspensivos si el texto se trunca (requiere overflow: hidden) */
         }


        /* Estilo de Leyenda */
        .legend-alert {
            padding: 0.75rem 1.25rem;
            margin-bottom: 1.5rem; /* Más espacio bajo la leyenda */
            border: 1px solid transparent;
            border-radius: 0.35rem; /* Coincidir con border-radius del contenedor */
            color: #004085; /* Color de texto alert-info por defecto */
            background-color: #cce5ff; /* Fondo alert-info por defecto */
            border-color: #b8daff; /* Borde alert-info por defecto */
            text-align: left; /* Alinear texto de leyenda a la izquierda */
            font-size: 0.9rem;
        }
        .legend-alert img {
            vertical-align: middle; /* Alinear iconos con texto */
             margin-right: 5px; /* Espacio después del icono */
        }
        .legend-alert b {
             margin-left: 10px; /* Espacio antes del texto en negrita */
        }

        /* --- Estilos de Tarjeta --- */
        .card-modern {
            margin-top: 2rem; /* Espacio sobre cada sección de tarjeta */
            border: 1px solid rgba(0, 0, 0, .125); /* Borde por defecto de Bootstrap */
            border-radius: 0.35rem;
            box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15);
            background-color: #fff; /* Fondo de tarjeta por defecto */
        }

        .card-modern .card-header {
            padding: 0.75rem 1.25rem;
            margin-bottom: 0;
            background-color: rgba(0, 0, 0, .03); /* Fondo de encabezado por defecto */
            border-bottom: 1px solid rgba(0, 0, 0, .125);
            color: #858796; /* Texto de encabezado por defecto */
            font-weight: bold;
        }

        /* Estilo para Tarjeta "Pedidos sin asignar a ruta" */
        .card-no-route {
            border-left: 4px solid #e74a3b; /* Borde izquierdo rojo */
        }
         .card-no-route .card-header {
             background-color: #e74a3b; /* Fondo rojo */
             color: white; /* Texto blanco */
             border-bottom: 1px solid #e74a3b;
         }


        /* Estilo para Tarjetas de Ruta (Tema más claro) */
        .card-route {
            background-color: #fff; /* Fondo blanco */
            border-left: 4px solid #36b9cc; /* Mantener borde izquierdo azul info */
            color: #333; /* Color de texto oscuro para contenido del cuerpo de la tarjeta fuera de la tabla */
             box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15); /* Mantener sombra sutil */
        }
        .card-route .card-header {
            background-color: #e9ecef; /* Encabezado gris/azul claro */
            color: #36b9cc; /* Texto azul info */
            border-bottom: 1px solid #d1d3e2; /* Ajustar color de borde de encabezado */
            font-size: 1.1rem; /* Texto de encabezado ligeramente más grande */
        }
         /* Asegurar que la tabla dentro de la tarjeta tenga texto legible */
         .card-route .table-modern th {
             color: #5a5c69; /* Color de texto de encabezado por defecto */
             border-bottom-color: #e3e6f0; /* Color de borde por defecto */
         }
         .card-route .table-modern td {
             color: #333; /* Color de texto por defecto para celdas de cuerpo */
             border-top-color: #e3e6f0; /* Color de borde por defecto */
         }

         /* Ajustar fondo rayado para tarjeta clara - usar rayas por defecto de Bootstrap */
         .card-route .table-modern.table-striped tbody tr:nth-of-type(odd) {
             background-color: rgba(0,0,0,.05); /* Raya por defecto de Bootstrap */
         }
         .card-route .table-modern.table-hover tbody tr:hover {
             background-color: rgba(0,0,0,.075); /* Efecto hover por defecto de Bootstrap */
         }

         /* --- Animación de Resaltado de Fila (Asignar) --- */
        @keyframes highlight-assign-glow {
            0% { box-shadow: 0 0 12px 4px rgba(246, 194, 62, 0.8); } /* Empezar con brillo amarillo */
            100% { box-shadow: none; } /* Desvanecer brillo */
        }

        .row-highlight-assign {
            animation: highlight-assign-glow 2s ease-out forwards; /* Aplicar animación por 2 segundos */
            position: relative; /* Necesario para box-shadow en tr */
            z-index: 1; /* Traer fila ligeramente adelante si es necesario */
            /* Cambio de color de fondo eliminado, confiando solo en el brillo */
        }

        /* --- Resaltado de Actualización de Socket --- */
        @keyframes highlight-update-glow {
            0% { box-shadow: 0 0 10px 3px rgba(54, 185, 204, 0.7); } /* Empezar con brillo azul */
            100% { box-shadow: none; } /* Desvanecer brillo */
        }
        .row-highlight-update {
            animation: highlight-update-glow 1.5s ease-out forwards;
            position: relative; /* Necesario para box-shadow en tr */
            z-index: 1; /* Traer fila ligeramente adelante si es necesario */
        }

    </style>
</head>

<body>
<?php include 'bd/conexion.php'; ?>

<?php require_once "vistas/parte_superior.php"; ?>

<div class="container-fluid mt-3"> <h1 class="h3 mb-4 text-gray-800">Pedidos Asignados a Ruta y Pendientes - Respaldos Chile</h1> <div class="alert legend-alert"> <img width="15" src="img/patasmadera.jpg" alt="Icono de patas de madera"> Patas de madera -
        <img width="15" src="img/anclaje.png" alt="Icono de madera interior para anclaje"> Madera interior para anclaje -
        <b> B D </b> Boton Diamante
    </div>

    <div id="contenido1">
        <?php
        $objeto1 = new Conexion();
        $conexion = $objeto1->Conectar();

        // Función para determinar la clase y texto del botón de estado - SINTAXIS PHP CORREGIDA
         function getEstadoButtonHtml($estadoPedido, $tapiceroId) {
             $estadoBtnClass = 'btn-secondary';
             $estadoBtnText = "Estado {$estadoPedido}"; // Por defecto

             // Usar $ para variable en PHP
             $procesoNames = [
                 1 => 'Aceptado', 2 => 'Env. Fabricación', 3 => 'Tela Cortada', 4 => 'Corte/Esqueleto',
                 5 => 'Fabricando', 6 => 'Fabricado', 7 => 'Despacho Iniciado', 8 => 'Cargado Camion',
                 9 => 'Reagendar', 10 => 'Dev. Error Fab', 11 => 'Dev. Disconf.', 12 => 'Dev. Falla Carga',
                 13 => 'Dev. Otro', 14 => 'Dev. Garantia', 15 => 'Dev. Cte No Contesta', 16 => 'Cliente Confirma',
                 17 => 'Cliente Solicita Fact.', 18 => 'Eliminado', 19 => 'Reagendar', 20 => 'Re-emitido'
              ];


             switch ($estadoPedido) { // Asegurar comparación es string si la BD envía string
                 case '1':
                     $estadoBtnClass = 'btn-estado-aceptado';
                     $estadoBtnText = 'Aceptado';
                     break;
                 case '2':
                     $estadoBtnClass = empty($tapiceroId) ? 'btn-estado-por-fabricar' : 'btn-estado-en-fabricacion';
                     $estadoBtnText = empty($tapiceroId) ? 'Por Fabricar' : 'En Fabricacion';
                     break;
                 case '3':
                     $estadoBtnClass = 'btn-estado-listo';
                     $estadoBtnText = 'Pedido Listo';
                     break;
                 case '9':
                     $estadoBtnClass = 'btn-estado-reagendar';
                     $estadoBtnText = 'Reagendar';
                     break;
                 case '4':
                     $estadoBtnClass = 'btn-estado-asignado-ruta';
                     $estadoBtnText = 'Asignado a Ruta';
                     break;
                 case '5':
                     $estadoBtnClass = 'btn-estado-entregado';
                     $estadoBtnText = 'Fabricando Ahora';
                     break;
                 default:
                     $estadoBtnClass = 'btn-secondary'; // U otro estilo por defecto
                     $estadoBtnText = $procesoNames[$estadoPedido] ?? "Estado {$estadoPedido}"; // Usar coalescencia nula para fallback más limpio
                     break;
             }
             return "<button class='btn {$estadoBtnClass} btn-sm btn-estado-pedido'>{$estadoBtnText}</button>";
         }


        // Función auxiliar para renderizar una fila de pedido
        function renderPedidoRow($dat) {
            $etapas = !empty($dat['eTapas']) ? explode(',', $dat['eTapas']) : [];
            // Verificar si existe Etapa 3 (Tela Cortada) O Etapa 4 (Corte/Armado Esqueleto) O Etapa 5 (Fabricando) O Etapa 6 (Fabricado)
            // ya que se relacionan con el proceso de fabricación/costura más allá de los pasos iniciales.
            $isFabricationStarted = in_array('3', $etapas);


            // Determinar clase del botón de confirmación
            $confirmaClass = $dat['confirma'] == '1' ? 'btn-info' : 'btn-danger';

             // Obtener HTML para el botón de estado
            $estadoButtonHtml = getEstadoButtonHtml($dat['estadopedido'], $dat['tapicero_id']);

            // Combinar partes de la dirección
            $fullAddress = trim($dat['direccion'] . ($dat['numero'] ? ' #' . $dat['numero'] : '') . ($dat['comuna'] ? ', ' . $dat['comuna'] : ''));
            if (empty($fullAddress)) $fullAddress = 'Dirección no especificada';


            echo "<tr data-pedido-id='{$dat['id']}'>"; // Añadir atributo data para fácil selección de fila
            echo "<td>{$dat['id']}</td>";
            echo "<td>{$dat['num_orden']}</td>"; // Columna ORDEN
            echo "<td>{$dat['rut_cliente']}</td>";
            echo "<td>{$dat['modelo']}";
            if ($dat['anclaje'] == 'si') echo " <img width='15' src='img/anclaje.png' alt='Icono de anclaje'>";
            if ($dat['anclaje'] == 'patas') echo " <img width='15' src='img/patasmadera.jpg' alt='Icono de patas de madera'>";
            echo "<br><span class='small text-danger fw-bold'>{$dat['comentarios']}</span></td>";
            echo "<td>{$dat['tamano']} <b class='text-primary'>{$dat['tipo_boton']}</b></td>";
            echo "<td>{$dat['alturabase']}</td>";
            echo "<td>{$dat['tipotela']}</td>";
            echo "<td>{$dat['color']}</td>";
            echo "<td>{$fullAddress}</td>"; // Columna Dirección combinada
            echo "<td>{$dat['detalles_fabricacion']}</td>";
              // Verificación de Costura actualizada: Verificar cualquier etapa relacionada con fabricación
            echo "<td class='text-center'>";
            echo $isFabricationStarted
                ? "<i class='fas fa-check text-success' title='Fabricación Iniciada/Completa'></i>" // Tooltip actualizado
                : "<i class='fas fa-times text-danger' title='Fabricación Pendiente'></i>"; // Tooltip actualizado
            echo "</td>";

            // Estado pedido - Usar clases y texto determinados
            echo "<td>{$estadoButtonHtml}</td>";

            // Cliente
            echo "<td>{$dat['cliente_nombre']}</td>";
            // Botón de confirmación (usando clase determinada)
            echo "<td class='text-center'><button class='btn {$confirmaClass} btn-confirmar btn-sm'></button></td>";

            // Botones tapicero para asignar/desasignar, uno por columna
            for ($t = 1; $t <= 3; $t++) {
                if ($dat['tapicero_id'] == $t) {
                    // Botón verde para desasignar al tapicero correspondiente
                    echo "<td class='text-center'><button class='btn btn-success btn-circle btn-sm btn-desasignar' data-id='{$dat['id']}' data-tap='{$t}' title='Desasignar Tapicero {$t}'><i class='fas fa-user-check'></i></button></td>";
                } else {
                    // Botón amarillo para asignar a este tapicero
                    echo "<td class='text-center'><button class='btn btn-warning btn-circle btn-sm btn-asignar-tapicero' data-id='{$dat['id']}' data-tap='{$t}' title='Asignar Tapicero {$t}'><i class='fas fa-user-plus'></i></button></td>";
                }
            }
            echo "</tr>";
        }

        // Obtenemos rutas únicas con pedidos en estado 2, 4, 5
         $consulta = "SELECT DISTINCT d.ruta_asignada
                      FROM pedido_detalle d
                      WHERE d.estadopedido IN (2, 4, 5) AND d.ruta_asignada IS NOT NULL AND d.ruta_asignada != '' ORDER BY d.ruta_asignada ASC";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $rutasConPedidos = $resultado->fetchAll(PDO::FETCH_ASSOC);

        // Manejar pedidos sin ruta asignada en estado 2, 4, 5
        $consultaSinRuta = $conexion->prepare(
            "SELECT p.*, d.*, c.nombre AS cliente_nombre, etapas.eTapas
             FROM pedido p
             INNER JOIN pedido_detalle d ON p.num_orden = d.num_orden
             LEFT JOIN (
                 SELECT idPedido, GROUP_CONCAT(idProceso) AS eTapas
                 FROM pedido_etapas
                 WHERE idProceso != 1
                 GROUP BY idPedido
             ) etapas ON d.id = etapas.idPedido
             INNER JOIN clientes c ON p.rut_cliente = c.rut
             WHERE d.estadopedido IN (2, 4, 5) AND (d.ruta_asignada IS NULL OR d.ruta_asignada = '')"
        );
        $consultaSinRuta->execute();
        $pedidosSinRuta = $consultaSinRuta->fetchAll(PDO::FETCH_ASSOC);

        // Definición de encabezado de tabla (ajustado para dirección combinada y Num Orden acortado)
        $tableHeaderHtml = "
            <thead><tr>
                <th>Id</th>
                <th>Orden</th> <th>Rut Cliente</th>
                <th>Modelo</th>
                <th>Plazas</th>
                <th>Alt</th>
                <th>Tela</th>
                <th>Color</th>
                <th>Direccion</th> <th>Detalles</th>
                <th>Costura</th>
                <th>Estado Pedido</th>
                <th>Cliente</th>
                <th>Confirma</th>
                <th>Tapicero 1</th>
                <th>Tapicero 2</th>
                <th>Tapicero 3</th>
            </tr></thead>";


        // Mostrar tabla de pedidos sin ruta si existen (usando estructura de tarjeta)
        if (!empty($pedidosSinRuta)) {
            echo "<div class='card card-modern card-no-route'>"; // Usar clases de tarjeta modernas
            echo "<div class='card-header'><b>Pedidos sin asignar a ruta</b></div>"; // Usar card-header
            echo "<div class='card-body p-0'>"; // Usar card-body sin padding

            echo "<div class='table-responsive-modern'>
                    <table class='table table-striped table-hover table-sm table-modern'>
                    {$tableHeaderHtml}
                    <tbody>";
            foreach ($pedidosSinRuta as $dat) {
                renderPedidoRow($dat);
            }
            echo "</tbody></table></div>";

            echo "</div></div>"; // Cerrar card-body y card
        }


        // Iterar sobre las rutas con pedidos (usando estructura de tarjeta)
        foreach ($rutasConPedidos as $row) {
            $ruta = $row['ruta_asignada'];

            // Obtenemos fecha de la ruta
            $stmtF = $conexion->prepare("SELECT fecha FROM rutas WHERE id = :ruta");
            $stmtF->bindParam(":ruta", $ruta, PDO::PARAM_INT);
            $stmtF->execute();
            $rows = $stmtF->fetch(PDO::FETCH_ASSOC);

            if (!empty($rows['fecha'])) {
                // Intentar crear objeto DateTime
                $fechaObj = DateTime::createFromFormat('Y-m-d', $rows['fecha']);
                 if ($fechaObj) { // Verificar si la creación fue exitosa
                     // Definir nombres de días y meses en español
                     $dias_semana = ['domingo','lunes','martes','miércoles','jueves','viernes','sábado'];
                     $meses = ['', 'enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];
                     // Formatear la fecha en español
                     $fecha = $dias_semana[$fechaObj->format('w')] . ', ' . $fechaObj->format('d') . ' de ' . $meses[$fechaObj->format('n')] . ' de ' . $fechaObj->format('Y');
                 } else {
                      // Manejar fecha inválida si createFromFormat falla
                      $fecha = "Fecha Inválida";
                 }
            } else {
                $fecha = "Fecha no disponible";
            }

            // Encabezado de la ruta (usando card-header)
            echo "<div class='card card-modern card-route'>"; // Usar clases de tarjeta modernas estilo AI
            echo "<div class='card-header'><b>Ruta {$ruta}.</b> {$fecha}</div>"; // Usar card-header
            echo "<div class='card-body p-0'>"; // Usar card-body sin padding

            // Consultar detalles por ruta y estados relevantes (2, 4, 5)
            $consulta2 = $conexion->prepare(
                "SELECT p.*, d.*, c.nombre AS cliente_nombre, etapas.eTapas
                 FROM pedido p
                 INNER JOIN pedido_detalle d ON p.num_orden = d.num_orden
                 LEFT JOIN (
                     SELECT idPedido, GROUP_CONCAT(idProceso) AS eTapas
                     FROM pedido_etapas
                     WHERE idProceso != 1
                     GROUP BY idPedido
                 ) etapas ON d.id = etapas.idPedido
                 INNER JOIN clientes c ON p.rut_cliente = c.rut
                 WHERE d.estadopedido IN (2, 4, 5) AND d.ruta_asignada = :ruta"
            );
            $consulta2->bindParam(":ruta", $ruta, PDO::PARAM_INT);
            $consulta2->execute();

            echo "<div class='table-responsive-modern'>
                    <table class='table table-striped table-hover table-sm table-modern'>
                    {$tableHeaderHtml} <tbody>";

            while ($dat = $consulta2->fetch(PDO::FETCH_ASSOC)) {
                renderPedidoRow($dat);
            }

            echo "</tbody></table></div>";

            echo "</div></div>"; // Cerrar card-body y card
        }

        ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.all.min.js"></script>
<script src="http://localhost:3000/socket.io/socket.io.js"></script>
<script>
    // URL base de tu backend Node.js en Docker
    const API_BASE_URL = 'http://localhost:3000/api'; // <-- Apuntando a tu backend en 3000
    // Obtener el token JWT del localStorage
    const TOKEN = localStorage.getItem('token') || ''; // <-- Obteniendo el token

    // Función auxiliar (versión JS de PHP getEstadoButtonHtml) - Mantener sincronizada con versión PHP
     function generateEstadoButtonHtml(estadoPedido, tapiceroId) {
         let estadoBtnClass = 'btn-secondary';
         let estadoBtnText = `Estado ${estadoPedido}`; // Por defecto

          const procesoNames = {
             1 : 'Aceptado', 2 : 'Env. Fabricación', 3 : 'Tela Cortada', 4 : 'Corte/Esqueleto',
             5 : 'Fabricando', 6 : 'Fabricado', 7 : 'Despacho Iniciado', 8 : 'Cargado Camion',
             9 : 'Reagendar', 10 : 'Dev. Error Fab', 11 : 'Dev. Disconf.', 12 : 'Dev. Falla Carga',
             13 : 'Dev. Otro', 14 : 'Dev. Garantia', 15 : 'Dev. Cte No Contesta', 16 : 'Cliente Confirma',
             17 : 'Cliente Solicita Fact.', 18 : 'Eliminado', 19 : 'Reagendar', 20 : 'Re-emitido'
          };


         switch (String(estadoPedido)) { // Asegurar comparación es string si la BD envía string
             case '1':
                 estadoBtnClass = 'btn-estado-aceptado';
                 estadoBtnText = 'Aceptado';
                 break;
             case '2':
                 // Si tapiceroId tiene un valor (no es null, undefined, 0, '', false), está asignado
                 estadoBtnClass = tapiceroId ? 'btn-estado-en-fabricacion' : 'btn-estado-por-fabricar';
                 estadoBtnText = tapiceroId ? 'En Fabricacion' : 'Por Fabricar';
                 break;
             case '3':
                 estadoBtnClass = 'btn-estado-listo';
                 estadoBtnText = 'Pedido Listo';
                 break;
             case '9':
                 estadoBtnClass = 'btn-estado-reagendar';
                 estadoBtnText = 'Reagendar';
                 break;
             case '4':
                 estadoBtnClass = 'btn-estado-asignado-ruta';
                 estadoBtnText = 'Asignado a Ruta';
                 break;
             case '5':
                 estadoBtnClass = 'btn-estado-entregado';
                 estadoBtnText = 'Fabricando Ahora';
                 break;
             default:
                 estadoBtnClass = 'btn-secondary';
                 estadoBtnText = procesoNames[estadoPedido] || `Estado ${estadoPedido}`;
                 break;
         }
         return `<button class='btn ${estadoBtnClass} btn-sm btn-estado-pedido'>${estadoBtnText}</button>`;
     }


    // Función para actualizar la fila visualmente basada en los datos proporcionados
    function updatePedidoRow(pedidoId, newData) {
        const $row = $(`#contenido1 table tbody tr[data-pedido-id='${pedidoId}']`);

        if ($row.length === 0) {
            console.warn(`Fila para pedido ID ${pedidoId} no encontrada para actualización.`);
            return;
        }
         console.log(`[updatePedidoRow] Actualizando fila para pedido ID: ${pedidoId}`, newData);

        const cellIndexMap = {
             id: 0, orden: 1, rut_cliente: 2, modelo: 3, plazas: 4, alt: 5, tela: 6,
             color: 7, direccion: 8, detalles: 9, costura: 10, estado_pedido: 11,
             cliente: 12, confirma: 13, tapicero_1: 14, tapicero_2: 15, tapicero_3: 16
        };

        // Determinar el estado y tapicero a usar para las actualizaciones
        let estadoFinal = newData.estadopedido;
        let tapiceroFinal = newData.tapicero_id; // Puede ser undefined si no viene

        // *** Lógica Mejorada para determinar estado y tapicero final ***
        if (newData.action === 'assigned') {
             console.log(" - Detectada acción 'assigned'.");
             // tapiceroFinal ya debería tener el valor de newData.tapicero_id
             if (estadoFinal === undefined) {
                 estadoFinal = '2'; // Asumir estado 'En Fabricacion' si no viene
                 console.log(" - Estado no venía en 'assigned', asumiendo estado '2'.");
             }
        } else if (newData.action === 'unassigned') {
            console.log(" - Detectada acción 'unassigned'.");
            tapiceroFinal = null; // Forzar tapicero a null
            if (estadoFinal === undefined) {
                estadoFinal = '2'; // Asumir estado 'Por Fabricar' si no viene
                console.log(" - Estado no venía en 'unassigned', asumiendo estado '2'.");
            }
        }

        // 1. Actualizar Botón de Estado (si tenemos un estado final determinado)
        if (estadoFinal !== undefined) {
            // Usar tapiceroFinal (puede ser el ID asignado o null si es unassigned)
            const estadoButtonHtml = generateEstadoButtonHtml(estadoFinal, tapiceroFinal);
            const $estadoCell = $row.find('td').eq(cellIndexMap.estado_pedido);
             console.log(` - Intentando actualizar celda de estado (índice ${cellIndexMap.estado_pedido}) con HTML: ${estadoButtonHtml}`);
             $estadoCell.html(estadoButtonHtml);
             console.log(` - Celda de estado actualizada (Estado: ${estadoFinal}, Tapicero: ${tapiceroFinal})`);
        } else {
             console.log(" - No se determinó un 'estadoFinal', no se actualiza botón de estado.");
        }


        // 2. Actualizar Botones de Tapicero (si tapicero_id está definido o la acción es unassigned)
        //    Usaremos 'tapiceroFinal' que ya tiene el valor correcto (ID o null)
        if (newData.tapicero_id !== undefined || newData.action === 'unassigned') {
             console.log(` - Actualizando botones de tapicero. Tapicero final considerado: ${tapiceroFinal}`);

            for(let i = 1; i <= 3; i++) {
                const cellIndex = cellIndexMap.tapicero_1 + i - 1;
                const $tapBtnCell = $row.find('td').eq(cellIndex);
                let newButtonHtml = '';

                 // Compara i con tapiceroFinal (que será null si es unassigned)
                 if (tapiceroFinal != null && String(tapiceroFinal) === String(i)) {
                     // Botón verde "Desasignar"
                     newButtonHtml = `<button class='btn btn-success btn-circle btn-sm btn-desasignar' data-id='${pedidoId}' data-tap='${i}' title='Desasignar Tapicero ${i}'><i class='fas fa-user-check'></i></button>`;
                 } else {
                     // Botón amarillo "Asignar" (también si tapiceroFinal es null)
                     newButtonHtml = `<button class='btn btn-warning btn-circle btn-sm btn-asignar-tapicero' data-id='${pedidoId}' data-tap='${i}' title='Asignar Tapicero ${i}'><i class='fas fa-user-plus'></i></button>`;
                 }

                 console.log(`   - Tapicero ${i}: Intentando actualizar celda (índice ${cellIndex}) con HTML: ${newButtonHtml}`);
                 $tapBtnCell.html(newButtonHtml); // Actualiza HTML de la celda
            }
            console.log(` - Botones de tapicero procesados.`);
        } else {
             // Este log ahora solo aparecerá si NO se recibe tapicero_id Y la acción NO es unassigned
             console.log(" - No se actualizan botones de tapicero (tapicero_id no definido y acción no es 'unassigned').");
        }

        // 3. Actualizar otros campos (si vienen en newData y es necesario)
        // ... (ejemplos comentados) ...


        console.log(`[updatePedidoRow] Fila para pedido ID ${pedidoId} procesada.`); // Mensaje final de la función
    }


    // Conectar a Socket.IO y escuchar actualizaciones
    try {
        const socket = io('http://localhost:3000');

        socket.on('pedidoUpdated', (data) => {
            console.log('Socket.IO: Actualización de pedido recibida', data);
            // Verificar si existen datos Y si existe la propiedad 'pedidoId'
            if (data && data.pedidoId) {
                // Llamar a updatePedidoRow con el ID y los datos recibidos
                updatePedidoRow(data.pedidoId, data);

                // Lógica de resaltado visual (brillo azul)
                 const $row = $(`#contenido1 table tbody tr[data-pedido-id='${data.pedidoId}']`);
                 if ($row.length > 0) {
                    $row.removeClass('row-highlight-assign row-highlight-update');
                    $row.addClass('row-highlight-update');
                    setTimeout(() => {
                        $row.removeClass('row-highlight-update');
                    }, 1500);
                 }
            } else {
                console.warn('Socket.IO: Actualización recibida sin datos o sin pedidoId válido:', data);
            }
        });

         socket.on('connect', () => { console.log('Socket.IO: Conectado'); });
         socket.on('disconnect', () => { console.log('Socket.IO: Desconectado'); });
         socket.on('connect_error', (err) => { console.error('Error de conexión Socket.IO:', err); });

    } catch (e) {
        console.error('Error conectando a Socket.IO:', e);
    }


    $(function(){ // Equivalente a $(document).ready()
        // Asignar tapicero a pedido con confirmación
        $('#contenido1').on('click', '.btn-asignar-tapicero', function() {
            const $btn = $(this);
            const pedidoId = $btn.data('id');
            const tapiceroId = $btn.data('tap');
            const $row = $btn.closest('tr');

            Swal.fire({
                title: `Asignar pedido ${pedidoId} al tapicero ${tapiceroId}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, asignar',
                cancelButtonText: 'Cancelar',
                 customClass: { confirmButton: 'btn btn-success mx-1', cancelButton: 'btn btn-danger mx-1' },
                 buttonsStyling: false,
                 reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `${API_BASE_URL}/tapiceros/${tapiceroId}/pedidos/${pedidoId}`,
                        type: 'PUT',
                        dataType: 'json',
                        headers: { 'Authorization': `Bearer ${TOKEN}` }
                    }).done(function(res) {
                        if (res.status === 'success') {
                            Swal.fire('¡Asignado!', 'El pedido fue asignado correctamente.', 'success');
                             // Actualización local INMEDIATA (puede ser sobrescrita por evento socket si llega)
                             // Es importante que esta data coincida con lo que enviará el socket
                             updatePedidoRow(pedidoId, {
                                 action: 'assigned', // Añadir acción para que updateRow la detecte
                                 estadopedido: '2', // Asumir estado 2 al asignar
                                 tapicero_id: tapiceroId
                             });

                             // Animación de resaltado
                             $row.removeClass('row-highlight-assign row-highlight-update');
                             $row.addClass('row-highlight-assign');
                             setTimeout(() => { $row.removeClass('row-highlight-assign'); }, 2000);

                        } else {
                            Swal.fire('Error', res.error || 'No se pudo asignar tapicero', 'error');
                        }
                    }).fail(function(jqXHR, textStatus, errorThrown) {
                        console.error("Error AJAX:", textStatus, errorThrown, jqXHR.responseText);
                        Swal.fire('Error', 'Error de conexión con la API o error del servidor', 'error');
                    });
                }
            });
        });

        // Desasignar tapicero de pedido con confirmación
        $('#contenido1').on('click', '.btn-desasignar', function() {
            const $btn = $(this);
            const pedidoId = $btn.data('id');
            const $row = $btn.closest('tr');

            Swal.fire({
                title: `Desasignar tapicero del pedido ${pedidoId}?`,
                text: "Esto cambiará el estado a 'Por Fabricar'.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, desasignar',
                cancelButtonText: 'Cancelar',
                 customClass: { confirmButton: 'btn btn-warning mx-1', cancelButton: 'btn btn-secondary mx-1' },
                 buttonsStyling: false,
                 reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `${API_BASE_URL}/tapiceros/unassigned/pedidos/${pedidoId}`,
                        type: 'DELETE',
                        dataType: 'json',
                        headers: { 'Authorization': `Bearer ${TOKEN}` }
                    }).done(function(res) {
                        if (res.status === 'success') {
                            Swal.fire('¡Desasignado!', 'El pedido fue desasignado.', 'success');
                             // Actualización local INMEDIATA
                             updatePedidoRow(pedidoId, {
                                 // Pasar explícitamente la acción para que el updateRow la maneje
                                 action: 'unassigned',
                                 estadopedido: '2', // Asumir estado 2 al desasignar
                                 tapicero_id: null // Tapicero es null (aunque no se use directamente si action es unassigned)
                             });
                             // El backend debería enviar evento socket.io confirmando (idealmente con tapicero_id: null)
                        } else {
                            Swal.fire('Error', res.error || 'No se pudo desasignar tapicero', 'error');
                        }
                    }).fail(function(jqXHR, textStatus, errorThrown) {
                         console.error("Error AJAX:", textStatus, errorThrown, jqXHR.responseText);
                         Swal.fire('Error', 'Error de conexión con la API o error del servidor', 'error');
                    });
                }
            });
        });

    }); // Fin document ready
</script>

<?php require_once "vistas/parte_inferior.php" ?>
</body>
</html>
