<?php
// Asumimos sesión iniciada y variables disponibles
$usuario = $_SESSION["s_usuario"] ?? 'Usuario';
$privilegios = $_SESSION["privilegios"] ?? -1;

// Paleta de colores corporativos (Mantenida)
$azulPrimario = '#2C3E50'; // Midnight Blue
$azulSecundario = '#34495E'; // Wet Asphalt
$grisClaro = '#ECF0F1'; // Clouds
$grisMedio = '#BDC3C7'; // Silver
$textoClaro = '#FFFFFF'; // White
$textoOscuro = '#34495E'; // Wet Asphalt (for text)
$bordeActivo = '#f6c23e'; // Amarillo/Dorado para resaltar activo/hover

// === Definir Anchos del Sidebar ===
$sidebarWidth = '14rem'; // Ancho estándar (224px)
$sidebarWidthToggled = '6.5rem'; // Ancho colapsado (104px)
?>

<style>
    /* === Estilos Navbar Lateral "2025" (Fijo, Espaciado Reducido, Scroll Estilizado) === */

    /* Base Sidebar: Fijo */
    .sidebar.navbar-nav {
        position: fixed; top: 0; left: 0; bottom: 0; z-index: 1000;
        background-color: <?php echo $azulPrimario; ?>;
        width: <?php echo $sidebarWidth; ?>;
        overflow-x: hidden; transition: width 0.3s ease; overflow-y: auto;
     
    }

    /* --- Estilos para Scrollbar del Sidebar --- */
    .sidebar.navbar-nav::-webkit-scrollbar { width: 6px; height: 6px; }
    .sidebar.navbar-nav::-webkit-scrollbar-track { background: transparent; margin: 2px; }
    .sidebar.navbar-nav::-webkit-scrollbar-thumb { background-color: rgba(255, 255, 255, 0.2); border-radius: 3px; }
    .sidebar.navbar-nav::-webkit-scrollbar-thumb:hover { background-color: rgba(255, 255, 255, 0.4); }
    .sidebar.navbar-nav { scrollbar-width: thin; scrollbar-color: rgba(255, 255, 255, 0.2) transparent; }
    /* --- Fin Estilos Scrollbar --- */


    /* Ajuste del Contenido Principal */
    #content-wrapper { padding-left: <?php echo $sidebarWidth; ?>; transition: padding-left 0.3s ease; }

    /* --- Estilos para Sidebar Colapsado (.toggled) --- */
    .sidebar.navbar-nav.toggled { width: <?php echo $sidebarWidthToggled; ?>; overflow: visible; }
    #wrapper.sidebar-toggled #content-wrapper { padding-left: <?php echo $sidebarWidthToggled; ?>; }
    .sidebar.navbar-nav.toggled .sidebar-brand-text,
    .sidebar.navbar-nav.toggled .sidebar-heading,
    .sidebar.navbar-nav.toggled .nav-item .nav-link span,
    .sidebar.navbar-nav.toggled .nav-item .nav-link[data-bs-toggle="collapse"]::after { display: none; }
    .sidebar.navbar-nav.toggled .sidebar-brand { padding: 1.25rem 0.5rem; }
    .sidebar.navbar-nav.toggled .sidebar-brand-icon img { width: 35px; }
    .sidebar.navbar-nav.toggled .nav-item .nav-link { padding: 0.7rem 0.5rem; justify-content: center; border-left-width: 0; }
    .sidebar.navbar-nav.toggled .nav-item .nav-link i { margin-right: 0; font-size: 1rem; }
    .sidebar.navbar-nav.toggled #sidebarToggle { width: auto; margin-left: auto; margin-right: auto; }

    /* --- Resto de estilos --- */
    .sidebar .sidebar-brand { height: auto; padding: 1.25rem 1rem; text-align: center; }
    .sidebar .sidebar-brand-icon img { width: 45px; margin: 0 auto; animation: mover 1.5s infinite alternate; -webkit-animation: mover 1.5s infinite alternate; }
    .sidebar .sidebar-brand-text { margin-top: 0.5rem; font-size: 0.9rem; font-weight: 600; color: <?php echo $textoClaro; ?>; font-family: 'Montserrat', sans-serif; }
    hr.sidebar-divider { border-top: 1px solid rgba(236, 240, 241, 0.1); margin: 0.3rem 1rem; }
    hr.sidebar-divider.my-0 { margin: 0 1rem; }
    .sidebar-dark .sidebar-heading {
    color: rgba(236, 240, 241, 0.5);
    font-size: 0.65rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    /* Padding actual: 0.35rem arriba/abajo, 1rem derecha, 1.25rem izquierda */
    padding: 0.35rem 1rem 0.35rem 1.25rem;
    /* Margen superior actual: 0.15rem */
    margin-top: -0.5rem;
    font-weight: 600;
}    .sidebar-dark .nav-item { position: relative; }
    .sidebar-dark .nav-item .nav-link { color: rgba(236, 240, 241, 0.75); padding: 0.7rem 1rem 0.7rem 1.25rem; display: flex; align-items: center; transition: all 0.2s ease-in-out; border-left: 3px solid transparent; }
    .sidebar-dark .nav-item .nav-link span { flex-grow: 1; font-size: 0.85rem; }
    .sidebar-dark .nav-item .nav-link i { color: rgba(236, 240, 241, 0.5); margin-right: 0.75rem; width: 20px; text-align: center; font-size: 0.9rem; transition: color 0.2s ease-in-out; }
    .sidebar-dark .nav-item .nav-link:hover { color: <?php echo $textoClaro; ?>; background-color: rgba(255, 255, 255, 0.05); border-left-color: <?php echo $bordeActivo; ?>; }
    .sidebar.toggled .nav-item .nav-link:hover { border-left-color: transparent; }
    .sidebar-dark .nav-item .nav-link:hover i { color: rgba(255, 255, 255, 0.8); }
    .sidebar-dark .nav-item.active .nav-link { color: <?php echo $textoClaro; ?>; font-weight: 500; background-color: rgba(0, 0, 0, 0.1); border-left-color: <?php echo $bordeActivo; ?>; }
    .sidebar.toggled .nav-item.active .nav-link { border-left-color: transparent; }
    .sidebar-dark .nav-item.active .nav-link i { color: <?php echo $textoClaro; ?>; }
    .sidebar-dark .nav-item .nav-link[data-bs-toggle="collapse"]::after { font-family: 'Font Awesome 5 Free'; font-weight: 900; content: '\f0da'; margin-left: auto; transition: transform 0.2s ease-in-out; font-size: 0.8rem; opacity: 0.5; }
    .sidebar-dark .nav-item .nav-link[data-bs-toggle="collapse"]:not(.collapsed)::after { transform: rotate(90deg); opacity: 1; }

    /* === Menú Colapsable - Fondo Claro === */
    .sidebar-dark .collapse { border-left: 3px solid transparent; }
    .sidebar-dark .collapse-inner {
        background-color: <?php echo $textoClaro; ?>; /* Fondo blanco */
        padding: 0.5rem 0; /* Ajustar padding si es necesario */
        margin: 0.25rem 0.75rem; /* Ajustar margen si es necesario */
        border-radius: 5px;
        box-shadow: 0 0.15rem 1.75rem rgba(58, 59, 69, 0.15); /* Sombra suave */
    }
    .sidebar-dark .collapse-inner .collapse-header {
        color: <?php echo $grisMedio; ?>; /* Color de encabezado gris */
        font-size: 0.7rem;
        font-weight: 700; /* Más peso */
        text-transform: uppercase;
        padding: 0.5rem 1.5rem; /* Ajustar padding */
        margin: 0; /* Sin margen extra */
    }
    .sidebar-dark .collapse-inner .collapse-item {
        color: <?php echo $textoOscuro; ?>; /* Texto oscuro */
        padding: 0.5rem 1.5rem; /* Padding ajustado */
        font-size: 0.82rem; /* Ligeramente más grande */
        transition: all 0.2s ease-in-out;
        border-radius: 3px; /* Bordes redondeados */
        margin: 0 0.5rem; /* Margen horizontal */
    }
    .sidebar-dark .collapse-inner .collapse-item:hover,
    .sidebar-dark .collapse-inner .collapse-item.active {
        background-color: <?php echo $grisClaro; ?>; /* Fondo gris claro en hover/active */
        color: <?php echo $azulPrimario; ?>; /* Texto azul oscuro */
        font-weight: 500;
    }
    /* === Fin Estilos Menú Colapsable === */

    .sidebar-dark #sidebarToggle { background-color: rgba(255, 255, 255, 0.1); }
    .sidebar-dark #sidebarToggle:hover { background-color: rgba(255, 255, 255, 0.2); }
    .sidebar #sidebarToggle::before { font-family: 'Font Awesome 5 Free'; font-weight: 900; content: '\f337'; color: rgba(255, 255, 255, 0.5); }
    .sidebar.toggled #sidebarToggle::before { content: '\f338'; }
    @-webkit-keyframes mover { 0% { transform: translateY(0); } 100% { transform: translateY(-4px); } }
    @keyframes mover { 0% { transform: translateY(0); } 100% { transform: translateY(-4px); } }
    .disabled-link { pointer-events: none; opacity: 0.4; position: relative; }
    .disabled-link:hover::after { content: "En Proceso"; position: absolute; left: 105%; top: 50%; transform: translateY(-50%); background-color: #333; color: white; padding: 3px 8px; border-radius: 4px; font-size: 0.75rem; white-space: nowrap; z-index: 10; }
    .nav-item .nav-link .text-success { color: #1cc88a !important; }
    .nav-item .nav-link .text-warning { color: #f6c23e !important; }
    .nav-item .nav-link .text-info { color: #36b9cc !important; }
    .btn-primary-corp { color: <?php echo $textoClaro; ?>; background-color: <?php echo $azulPrimario; ?>; border-color: <?php echo $azulPrimario; ?>; }
    .btn-primary-corp:hover { color: <?php echo $textoClaro; ?>; background-color: #1A252F; border-color: #151E26; }
    .img-profile { height: 2.5rem; width: 2.5rem; }
    .topbar .nav-item .nav-link { height: 4.375rem; display: flex; align-items: center; }
    .topbar .topbar-divider { width: 0; border-right: 1px solid #e3e6f0; height: calc(4.375rem - 2rem); margin: auto 1rem; }
/* === Estilos Móviles (Ejemplo con Media Query para < 768px) === */
@media (max-width: 767.98px) { /* Breakpoint 'md' de Bootstrap */

.sidebar.navbar-nav {
    position: fixed;
    top: 0;
    left: 0; /* O usar transform: translateX(-100%); */
    bottom: 0;
    z-index: 1045; /* Asegurar que esté sobre el contenido y posible backdrop */
    width: 250px; /* O un ancho fijo o % que funcione bien */
    background-color: <?php echo $azulPrimario; ?>;
    overflow-y: auto;
    transition: transform 0.3s ease-in-out; /* Transición para el deslizamiento */
    transform: translateX(-100%); /* Oculto por defecto */
    /* Quitar estilos .toggled específicos de ancho si no se usan en off-canvas */
}

.sidebar.navbar-nav.active { /* Usar una clase 'active' o 'show' en lugar de 'toggled' para claridad */
    transform: translateX(0); /* Mostrar */
    box-shadow: 0 0 15px rgba(0,0,0,0.2); /* Sombra opcional */
}

#content-wrapper {
    padding-left: 0 !important; /* Sin padding cuando el menú está oculto */
    transition: none; /* No necesita transición de padding en móvil */
}

/* Opcional: Si quieres que el menú empuje el contenido */
/* body.sidebar-active #content-wrapper {
    padding-left: 250px;
    transition: padding-left 0.3s ease-in-out;
} */

/* Opcional: Backdrop para cerrar menú al tocar fuera */
.sidebar-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1040; /* Debajo del sidebar pero sobre el contenido */
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
}

body.sidebar-active .sidebar-backdrop {
    opacity: 1;
    visibility: visible;
}

/* Ocultar el toggle de escritorio en móvil (ya está hecho con d-md-inline) */
/* .sidebar #sidebarToggle { display: none; } */

/* Asegurar que el toggle de móvil esté visible (ya está hecho con d-md-none) */
/* .topbar #sidebarToggleTop { display: block; } */

/* Ajustes menores al Topbar si es necesario para que quepa todo */
.topbar .nav-item .nav-link {
    padding-left: 0.75rem;
    padding-right: 0.75rem;
}
.topbar .dropdown {
     position: static; /* Puede ayudar si los dropdowns se cortan */
}
.topbar .dropdown-menu {
     width: auto; /* O un ancho específico si es necesario */
     right: 0;
     left: auto;
}
}

/* Estilos para pantallas más grandes (mantener los actuales) */
@media (min-width: 768px) {
 /* Aquí van (o se quedan) los estilos originales para el sidebar fijo y colapsable */
 .sidebar.navbar-nav {
     position: fixed; top: 0; left: 0; bottom: 0; z-index: 1000;
     background-color: <?php echo $azulPrimario; ?>;
     width: <?php echo $sidebarWidth; ?>;
     overflow-x: hidden; transition: width 0.3s ease; overflow-y: auto;
     transform: none !important; /* Asegurar que no herede el transform móvil */
 }

 #content-wrapper {
     padding-left: <?php echo $sidebarWidth; ?>;
     transition: padding-left 0.3s ease;
 }

 .sidebar.navbar-nav.toggled {
     width: <?php echo $sidebarWidthToggled; ?>;
     overflow: visible; /* O hidden si prefieres */
 }
 #wrapper.sidebar-toggled #content-wrapper {
      padding-left: <?php echo $sidebarWidthToggled; ?>;
 }
 /* ... (resto de estilos .toggled para desktop) ... */

 /* Ocultar el backdrop en desktop */
 .sidebar-backdrop { display: none; }
}
</style>

<div id="wrapper"> <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar"> <a class="sidebar-brand" href="index.php">
             <div class="sidebar-brand-icon">
                <img src="img/logoblanco.png" alt="RespaldosChile Logo">
             </div>
             <div class="sidebar-brand-text">RespaldosChile</div>
        </a>

        <hr class="sidebar-divider my-0">

        <?php if ($privilegios >= 20) : ?>
            <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard2024.php' ? 'active' : ''); ?>">
                <a class="nav-link" href="dashboard2024.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
        <?php endif; ?>

        <?php if ($privilegios >= 20 && ($privilegios >= 20 || $privilegios == 4 || $privilegios == 0 || $privilegios == 5)) : ?>
            <hr class="sidebar-divider">
        <?php endif; ?>


        <?php if ($privilegios >= 20 || $privilegios == 4) : ?>
            <div class="sidebar-heading">Ventas</div>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseVentas"
                   aria-expanded="false" aria-controls="collapseVentas">
                   <i class="fas fa-fw fa-cash-register text-warning"></i> <span>Gestión Ventas</span>
                </a>
                <div id="collapseVentas" class="collapse" aria-labelledby="headingVentas" data-bs-parent="#accordionSidebar">
                    <div class="collapse-inner rounded"> <a class="collapse-item" href="agregarpedido_sala.php">Ventas Sala</a>
                        <a class="collapse-item" href="stock.php">Stock Sala</a>
                        <a class="collapse-item" href="reimprimir.php">Re-imprimir</a>
                        <a class="collapse-item" href="retiro.php">Retiro Cliente</a>
                    </div>
                </div>
            </li>
        <?php endif; ?>


        <?php if ($privilegios >= 20) : ?>
            <?php if (!($privilegios >= 20 || $privilegios == 4)) : ?> <hr class="sidebar-divider"> <?php endif; ?>
            <div class="sidebar-heading">Pedidos</div>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePedidos"
                   aria-expanded="false" aria-controls="collapsePedidos">
                   <i class="fas fa-fw fa-clipboard-list text-warning"></i> <span>Gestión Pedidos</span>
                </a>
                <div id="collapsePedidos" class="collapse" aria-labelledby="headingPedidos" data-bs-parent="#accordionSidebar">
                    <div class="collapse-inner rounded"> <a class="collapse-item" href="validar_pagos2024.php">Validar Pagos</a>
                        <a class="collapse-item" href="addpedido.php">Agregar Pedido</a>
                        <a class="collapse-item" href="todoslospedidos.php">Todos los Pedidos</a>
                        <a class="collapse-item" href="pedidoseliminados.php">Pedidos Eliminados</a>
                    </div>
                </div>
            </li>
        <?php endif; ?>


        <?php if ($privilegios == 0 || $privilegios == 5 || $privilegios >= 20) : ?>
            <?php if (!($privilegios >= 20)) : ?> <hr class="sidebar-divider"> <?php endif; ?>
             <div class="sidebar-heading">Producción</div>
            <li class="nav-item">
                 <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseProduccion"
                   aria-expanded="false" aria-controls="collapseProduccion">
                   <i class="fas fa-fw fa-industry <?php echo ($privilegios >= 20) ? 'text-warning' : ''; ?>"></i> <span>Control Producción</span>
                </a>
                <div id="collapseProduccion" class="collapse" aria-labelledby="headingProduccion" data-bs-parent="#accordionSidebar">
                    <div class="collapse-inner rounded"> <?php if ($privilegios == 0) : ?>
                             <a class="collapse-item" href="produccion_tapiceros.php">Ver Mi Producción</a>
                        <?php elseif ($privilegios == 5) : ?>
                             <a class="collapse-item" href="vista_produccion.php">Vista General</a>
                             <a class="collapse-item" href="cortar_telas.php">Cortar Telas</a>
                             <a class="collapse-item" href="cortar_estructuras.php">Cortar Esqueletos</a>
                        <?php elseif ($privilegios >= 20) : ?>
                            <a class="collapse-item" href="registro_esqueletos.php">Ingreso Esqueletos</a>
                            <a class="collapse-item" href="prod_tapiceros.php">Asignar Producción</a>
                            <a class="collapse-item" href="produccion_tapiceros.php">Ver Toda Producción</a>
                        <?php endif; ?>
                    </div>
                    <?php if ($privilegios >= 20 || $privilegios == 5) : ?>
                         <div class="collapse-inner rounded mt-1"> <h6 class="collapse-header">Corte:</h6>
                            <?php if ($privilegios >= 20) : ?> <a class="collapse-item" href="metraje.php">Ver Metrajes</a> <?php endif; ?>
                            <a class="collapse-item" href="cortar_telas.php">Cortar Telas</a>
                            <a class="collapse-item" href="cortar_estructuras.php">Cortar Esqueletos</a>
                         </div>
                    <?php endif; ?>
                </div>
            </li>
        <?php endif; ?>


        <?php if ($privilegios >= 20) : ?>
             <?php if (!($privilegios == 0 || $privilegios == 5 || $privilegios >= 20)) : ?> <hr class="sidebar-divider"> <?php endif; ?>
            <div class="sidebar-heading">Bodega & Stock</div>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseBodega"
                   aria-expanded="false" aria-controls="collapseBodega">
                   <i class="fas fa-fw fa-warehouse text-success"></i> <span>Control Bodega</span>
                </a>
                <div id="collapseBodega" class="collapse" aria-labelledby="headingBodega" data-bs-parent="#accordionSidebar">
                    <div class="collapse-inner rounded"> <a class="collapse-item" href="productos.php">Ver Stock General</a>
                        <a class="collapse-item" href="escanear.php">Ingresar Producto</a>
                        <a class="collapse-item" href="escanear_telas.php">Ingresar Telas</a>
                        <a class="collapse-item" href="esc_stock_telas.php">Ingresar Costuras</a>
                        <a class="collapse-item" href="mover.php">Mover de Lugar</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseStockProd"
                   aria-expanded="false" aria-controls="collapseStockProd">
                   <i class="fas fa-fw fa-boxes text-info"></i> <span>Stock Terminados</span>
                </a>
                <div id="collapseStockProd" class="collapse" aria-labelledby="headingStockProd" data-bs-parent="#accordionSidebar">
                    <div class="collapse-inner rounded"> <a class="collapse-item" href="stock_productos.php">Ingresar Producto</a>
                        <a class="collapse-item" href="stock_productos.php">Ver Stock</a>
                        <a class="collapse-item" href="vender_stock.php">Venta Stock</a>
                    </div>
                </div>
            </li>
             <li class="nav-item">
                <a class="nav-link disabled-link" href="#" aria-expanded="false">
                    <i class="fas fa-fw fa-scroll text-warning"></i> <span>Stock Telas</span>
                </a>
            </li>
        <?php endif; ?>


        <?php if ($privilegios >= 20) : ?>
            <hr class="sidebar-divider"> <div class="sidebar-heading">Logística</div>
             <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseRutas"
                   aria-expanded="false" aria-controls="collapseRutas">
                   <i class="fas fa-fw fa-route text-warning"></i> <span>Rutas Despacho</span>
                </a>
                <div id="collapseRutas" class="collapse" aria-labelledby="headingRutas" data-bs-parent="#accordionSidebar">
                    <div class="collapse-inner rounded"> <a class="collapse-item" href="crear_rutas.php">Crear Ruta</a>
                        <a class="collapse-item" href="seleccionar_ruta.php">Ver Rutas</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseStarken"
                   aria-expanded="false" aria-controls="collapseStarken">
                   <i class="fas fa-fw fa-truck text-success"></i> <span>Starken</span>
                </a>
                <div id="collapseStarken" class="collapse" aria-labelledby="headingStarken" data-bs-parent="#accordionSidebar">
                    <div class="collapse-inner rounded"> <a class="collapse-item" href="consultastarken.php">Cotizar Envío</a>
                        <a class="collapse-item" href="consultastarken.php">Seguimiento</a>
                        <a class="collapse-item" href="consultastarken.php">Ingresar Orden</a>
                    </div>
                </div>
            </li>
        <?php endif; ?>


        <?php if ($privilegios >= 20) : ?>
            <hr class="sidebar-divider"> <div class="sidebar-heading">Administración</div>
             <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseClientes"
                   aria-expanded="false" aria-controls="collapseClientes">
                   <i class="fas fa-fw fa-users text-warning"></i> <span>Clientes</span>
                </a>
                <div id="collapseClientes" class="collapse" aria-labelledby="headingClientes" data-bs-parent="#accordionSidebar">
                    <div class="collapse-inner rounded"> <a class="collapse-item" href="verclientes.php">Ver Clientes</a>
                    </div>
                </div>
            </li>
             <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseColores"
                   aria-expanded="false" aria-controls="collapseColores">
                   <i class="fas fa-fw fa-palette text-warning"></i> <span>Colores</span>
                </a>
                <div id="collapseColores" class="collapse" aria-labelledby="headingColores" data-bs-parent="#accordionSidebar">
                    <div class="collapse-inner rounded"> <a class="collapse-item" href="agregar_colores.php">Agregar Colores</a>
                    </div>
                </div>
            </li>
            <?php if ($privilegios >= 21) : ?>
                 <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseCostos"
                       aria-expanded="false" aria-controls="collapseCostos">
                       <i class="fas fa-fw fa-dollar-sign text-warning"></i> <span>Costos</span>
                    </a>
                    <div id="collapseCostos" class="collapse" aria-labelledby="headingCostos" data-bs-parent="#accordionSidebar">
                        <div class="collapse-inner rounded"> <a class="collapse-item" href="productos_inventario.php">Costos Producción</a>
                        </div>
                    </div>
                </li>
                 <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseContabilidad"
                       aria-expanded="false" aria-controls="collapseContabilidad">
                       <i class="fas fa-fw fa-calculator text-warning"></i> <span>Contabilidad</span>
                    </a>
                    <div id="collapseContabilidad" class="collapse" aria-labelledby="headingContabilidad" data-bs-parent="#accordionSidebar">
                        <div class="collapse-inner rounded"> <a class="collapse-item" href="contabilidad.php">Contabilidad</a>
                            <a class="collapse-item" href="pagos.php">Pagos</a>
                        </div>
                    </div>
                </li>
            <?php endif; ?>
             <hr class="sidebar-divider d-none d-md-block">
        <?php endif; ?>


        <div class="text-center d-none d-md-inline mt-3 mb-3">
             <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle me-3">
                    <i class="fa fa-bars" style="color: <?php echo $azulPrimario; ?>;"></i>
                </button>
                <form class="d-none d-sm-inline-block form-inline me-auto ms-md-3 my-2 my-md-0 mw-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Buscar..." aria-label="Search">
                        <button class="btn btn-primary-corp" type="button">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </form>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown no-arrow d-sm-none">
                        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-search fa-fw text-gray-600"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                            <form class="form-inline me-auto w-100 navbar-search">
                                <div class="input-group">
                                    <input type="text" class="form-control bg-light border-0 small" placeholder="Buscar..." aria-label="Search">
                                    <button class="btn btn-primary-corp" type="button"><i class="fas fa-search fa-sm"></i></button>
                                </div>
                            </form>
                        </div>
                    </li>
                    <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bell fa-fw text-gray-600"></i>
                            <span class="badge bg-danger badge-counter">3+</span>
                        </a>
                        <div class="dropdown-list dropdown-menu dropdown-menu-end shadow animated--grow-in" aria-labelledby="alertsDropdown">
                            <h6 class="dropdown-header" style="background-color: <?php echo $azulPrimario; ?>; border-color: <?php echo $azulPrimario; ?>;">Notificaciones</h6>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="me-3"><div class="icon-circle bg-primary"><i class="fas fa-file-alt text-white"></i></div></div>
                                <div><div class="small text-gray-500">Mayo, 2022</div><span class="font-weight-bold">Mantener Lugar de trabajo limpio!</span></div>
                            </a>
                            <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-envelope fa-fw text-gray-600"></i>
                            <span class="badge bg-warning text-dark badge-counter">7</span>
                        </a>
                        <div class="dropdown-list dropdown-menu dropdown-menu-end shadow animated--grow-in" aria-labelledby="messagesDropdown">
                             <h6 class="dropdown-header" style="background-color: <?php echo $azulPrimario; ?>; border-color: <?php echo $azulPrimario; ?>;">Centro de Mensajes</h6>
                             <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="dropdown-list-image me-3"><img class="rounded-circle" src="img/chapon.jpg" alt="Chapon"><div class="status-indicator bg-success"></div></div>
                                <div class="font-weight-bold"><div class="text-truncate">Verificar Chapon.</div><div class="small text-gray-500">Diciembre</div></div>
                            </a>
                             <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                        </div>
                    </li>
                    <div class="topbar-divider d-none d-sm-block"></div>
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="me-2 d-none d-lg-inline text-gray-600 small"><?php echo htmlspecialchars($usuario); ?></span>
                             <img class="img-profile rounded-circle" src="img/user.png" alt="User Icon">
                        </a>
                        <div class="dropdown-menu dropdown-menu-end shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="#"><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>Profile</a>
                            <a class="dropdown-item" href="#"><i class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>Settings</a>
                            <a class="dropdown-item" href="#"><i class="fas fa-list fa-sm fa-fw me-2 text-gray-400"></i>Activity Log</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>Cerrar Sesión</a>
                        </div>
                    </li>
                </ul>
            </nav>
            <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">¿Listo para Salir?</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">Selecciona "Cerrar Sesión" abajo si estás listo para terminar tu sesión actual.</div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancelar</button>
                            <a class="btn btn-primary-corp" href="bd/logout.php">Cerrar Sesión</a>
                        </div>
                    </div>
                </div>
            </div>

            