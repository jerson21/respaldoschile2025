<?php require_once "init.php" ?>
<?php
// Incluir archivo de configuración

require_once('sistema_control/config/db.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Control de Gastos</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <!-- Header -->
    <?php require_once "/vistas/parte_superior.php" ?>


    <!-- Main Dashboard Content -->
    <div class="container mt-4">
        <div class="row mb-4">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Stats Cards Row -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card stat-card income dashboard-card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted">Ingresos Mensuales</h6>
                            <h3 class="mb-0">$45,850</h3>
                            <small class="text-success"><i class="fas fa-arrow-up"></i> 5.3% vs mes anterior</small>
                        </div>
                        <div>
                            <i class="fas fa-coins text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card expense dashboard-card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted">Gastos Totales</h6>
                            <h3 class="mb-0" id="total-gastos">$0</h3>
                            <small class="text-danger"><i class="fas fa-arrow-up"></i> <span id="var-gastos">0%</span> vs mes anterior</small>
                        </div>
                        <div>
                            <i class="fas fa-credit-card text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card product dashboard-card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted">Margen Promedio</h6>
                            <h3 class="mb-0" id="margen-promedio">0%</h3>
                            <small class="text-success"><i class="fas fa-arrow-up"></i> <span id="var-margen">0%</span> vs mes anterior</small>
                        </div>
                        <div>
                            <i class="fas fa-percentage text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card dashboard-card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted">Sueldos</h6>
                            <h3 class="mb-0" id="total-sueldos">$0</h3>
                            <small class="text-muted"><i class="fas fa-equals"></i> <span id="var-sueldos">0%</span> vs mes anterior</small>
                        </div>
                        <div>
                            <i class="fas fa-users text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Dashboards Tabs -->
        <div class="row">
            <div class="col-md-12">
                <div class="card dashboard-card">
                    <div class="card-header p-3">
                        <ul class="nav nav-tabs card-header-tabs" id="dashboardTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="gastos-tab" data-bs-toggle="tab" data-bs-target="#gastos" type="button" role="tab" aria-controls="gastos" aria-selected="true">
                                    <i class="fas fa-chart-pie me-2"></i>Control de Gastos
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="productos-tab" data-bs-toggle="tab" data-bs-target="#productos" type="button" role="tab" aria-controls="productos" aria-selected="false">
                                    <i class="fas fa-box me-2"></i>Costos de Productos
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="sueldos-tab" data-bs-toggle="tab" data-bs-target="#sueldos" type="button" role="tab" aria-controls="sueldos" aria-selected="false">
                                    <i class="fas fa-wallet me-2"></i>Control de Sueldos
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="presupuesto-tab" data-bs-toggle="tab" data-bs-target="#presupuesto" type="button" role="tab" aria-controls="presupuesto" aria-selected="false">
                                    <i class="fas fa-money-bill-wave me-2"></i>Presupuesto
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content" id="dashboardTabsContent">
                        <!-- Tab: Control de Gastos -->
                        <div class="tab-pane fade show active" id="gastos" role="tabpanel" aria-labelledby="gastos-tab">
                            <div class="row">
                                <div class="col-md-8">
                                    <h5 class="mb-3">Distribución de Gastos por Categoría</h5>
                                    <canvas id="gastosChart" height="250"></canvas>
                                </div>
                                <div class="col-md-4">
                                    <h5 class="mb-3">Gastos vs Presupuesto</h5>
                                    <div id="comparativa-container">
                                        <!-- Aquí se cargarán las barras de progreso desde PHP -->
                                        <div class="text-center p-5">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">Cargando...</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5>Registro de Gastos Recientes</h5>
                                        <button class="btn btn-primary" id="btn-nuevo-gasto"><i class="fas fa-plus me-2"></i>Registrar Nuevo Gasto</button>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover" id="tabla-gastos">
                                            <thead>
                                                <tr>
                                                    <th>Fecha</th>
                                                    <th>Descripción</th>
                                                    <th>Categoría</th>
                                                    <th>Monto</th>
                                                    <th>Responsable</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Aquí se cargarán los gastos desde PHP -->
                                                <tr>
                                                    <td colspan="6" class="text-center">Cargando datos...</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Tab: Costos de Productos -->
                        <div class="tab-pane fade" id="productos" role="tabpanel" aria-labelledby="productos-tab">
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5>Resumen de Costos por Producto</h5>
                                        <div>
                                            <div class="btn-group">
                                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    Filtrar por Categoría
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#">Todos</a></li>
                                                    <li><a class="dropdown-item" href="#">Electrónicos</a></li>
                                                    <li><a class="dropdown-item" href="#">Muebles</a></li>
                                                    <li><a class="dropdown-item" href="#">Ropa</a></li>
                                                    <li><a class="dropdown-item" href="#">Alimentos</a></li>
                                                </ul>
                                            </div>
                                            <button class="btn btn-outline-primary ms-2" id="btn-exportar-productos">
                                                <i class="fas fa-file-export me-1"></i> Exportar
                                            </button>
                                            <button class="btn btn-primary ms-2" id="btn-nuevo-producto">
                                                <i class="fas fa-plus me-1"></i> Nuevo Producto
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover" id="tabla-productos">
                                            <thead>
                                                <tr>
                                                    <th>Producto</th>
                                                    <th>Costo Unitario</th>
                                                    <th>Precio Venta</th>
                                                    <th>Margen</th>
                                                    <th>Stock</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Aquí se cargarán los productos desde PHP -->
                                                <tr>
                                                    <td colspan="6" class="text-center">Cargando datos...</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="card dashboard-card">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">Evolución de Costos</h5>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="costEvolutionChart" height="250"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <h5 class="mb-3">Productos con Mayor Margen</h5>
                                    <div class="row" id="productos-margen">
                                        <!-- Aquí se cargarán los productos con mayor margen desde PHP -->
                                        <div class="col-12 text-center p-5">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">Cargando...</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Tab: Control de Sueldos -->
                        <div class="tab-pane fade" id="sueldos" role="tabpanel" aria-labelledby="sueldos-tab">
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5>Control de Nómina</h5>
                                        <div>
                                            <select class="form-select d-inline-block" id="select-mes" style="width: auto;">
                                                <option value="3">Marzo 2025</option>
                                                <option value="2">Febrero 2025</option>
                                                <option value="1">Enero 2025</option>
                                                <option value="12">Diciembre 2024</option>
                                            </select>
                                            <button class="btn btn-outline-primary ms-2" id="btn-exportar-nomina">
                                                <i class="fas fa-file-export me-1"></i> Exportar
                                            </button>
                                            <button class="btn btn-primary ms-2" id="btn-actualizar-nomina">
                                                <i class="fas fa-sync-alt me-1"></i> Actualizar Nómina
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover" id="tabla-nomina">
                                            <thead>
                                                <tr>
                                                    <th>Empleado</th>
                                                    <th>Departamento</th>
                                                    <th>Cargo</th>
                                                    <th>Sueldo Base</th>
                                                    <th>Extras</th>
                                                    <th>Total</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Aquí se cargarán los datos de nómina desde PHP -->
                                                <tr>
                                                    <td colspan="7" class="text-center">Cargando datos...</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card dashboard-card mb-4">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">Distribución por Departamento</h5>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="salaryDeptChart" height="220"></canvas>
                                        </div>
                                    </div>
                                    <div class="card dashboard-card">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">Resumen de Nómina</h5>
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-group list-group-flush" id="resumen-nomina">
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <span>Total Sueldos Base:</span>
                                                    <strong id="total-sueldos-base">$0</strong>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <span>Total Extras:</span>
                                                    <strong id="total-extras">$0</strong>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <span>Impuestos:</span>
                                                    <strong id="total-impuestos">$0</strong>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between bg-light">
                                                    <span>Total Nómina:</span>
                                                    <strong class="text-primary" id="total-nomina">$0</strong>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <h5 class="mb-3">Tendencia de Gastos en Nómina</h5>
                                    <div class="card dashboard-card">
                                        <div class="card-body">
                                            <canvas id="salaryTrendChart" height="120"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Tab: Presupuesto -->
                        <div class="tab-pane fade" id="presupuesto" role="tabpanel" aria-labelledby="presupuesto-tab">
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5>Control de Presupuesto 2025</h5>
                                        <div>
                                            <select class="form-select d-inline-block" id="select-periodo" style="width: auto;">
                                                <option value="anual">Anual 2025</option>
                                                <option value="Q1">Q1 2025</option>
                                                <option value="Q2">Q2 2025</option>
                                                <option value="Q3">Q3 2025</option>
                                                <option value="Q4">Q4 2025</option>
                                            </select>
                                            <button class="btn btn-outline-primary ms-2" id="btn-configurar-presupuesto">
                                                <i class="fas fa-cog me-1"></i> Configurar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4 mb-4">
                                    <div class="card dashboard-card">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">Estado Presupuestario</h5>
                                        </div>
                                        <div class="card-body text-center">
                                            <div class="position-relative" style="height: 180px; width: 180px; margin: 0 auto;">
                                                <canvas id="budgetDonutChart"></canvas>
                                                <div class="position-absolute top-50 start-50 translate-middle">
                                                    <h3 class="mb-0" id="porcentaje-ejecutado">0%</h3>
                                                    <small class="text-muted">Ejecutado</small>
                                                </div>
                                            </div>
                                            <div class="mt-4">
                                                <div class="d-flex justify-content-between">
                                                    <span>Presupuesto Total:</span>
                                                    <strong id="presupuesto-total">$0</strong>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <span>Ejecutado:</span>
                                                    <strong id="presupuesto-ejecutado">$0</strong>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <span>Disponible:</span>
                                                    <strong class="text-success" id="presupuesto-disponible">$0</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8 mb-4">
                                    <div class="card dashboard-card">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">Ejecución Presupuestaria por Área</h5>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="budgetByAreaChart" height="250"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card dashboard-card">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">Detalle Presupuestario por Mes</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-hover" id="tabla-presupuesto">
                                                    <thead>
                                                        <tr>
                                                            <th>Categoría</th>
                                                            <th>Presupuesto Anual</th>
                                                            <th>Gastado YTD</th>
                                                            <th>% Ejecutado</th>
                                                            <th>Tendencia</th>
                                                            <th>Proyección</th>
                                                            <th>Estado</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- Aquí se cargarán los datos de presupuesto desde PHP -->
                                                        <tr>
                                                            <td colspan="7" class="text-center">Cargando datos...</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modales -->
    <!-- Modal para Nuevo/Editar Gasto -->
    <div class="modal fade" id="modalGasto" tabindex="-1" aria-labelledby="modalGastoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalGastoLabel">Registrar Nuevo Gasto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formGasto">
                        <input type="hidden" id="id_gasto" name="id_gasto" value="">
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="fecha" class="form-label">Fecha</label>
                                <input type="date" class="form-control" id="fecha" name="fecha" required>
                            </div>
                            <div class="col-md-6">
                                <label for="monto" class="form-label">Monto</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" id="monto" name="monto" step="0.01" min="0" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <input type="text" class="form-control" id="descripcion" name="descripcion" required>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="id_categoria" class="form-label">Categoría</label>
                                <select class="form-select" id="id_categoria" name="id_categoria" required>
                                    <option value="">Seleccione una categoría</option>
                                    <!-- Aquí se cargarán las categorías desde PHP -->
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="id_responsable" class="form-label">Responsable</label>
                                <select class="form-select" id="id_responsable" name="id_responsable" required>
                                    <option value="">Seleccione un responsable</option>
                                    <!-- Aquí se cargarán los empleados desde PHP -->
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="notas" class="form-label">Notas adicionales</label>
                            <textarea class="form-control" id="notas" name="notas" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btnGuardarGasto">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Nuevo/Editar Producto -->
    <div class="modal fade" id="modalProducto" tabindex="-1" aria-labelledby="modalProductoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalProductoLabel">Gestionar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formProducto">
                        <input type="hidden" id="id_producto" name="id_producto" value="">
                        <input type="hidden" id="costo_anterior" name="costo_anterior" value="0">
                        
                        <div class="mb-3">
                            <label for="nombre_producto" class="form-label">Nombre del Producto</label>
                            <input type="text" class="form-control" id="nombre_producto" name="nombre" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="descripcion_producto" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion_producto" name="descripcion" rows="2"></textarea>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="costo_unitario" class="form-label">Costo Unitario</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" id="costo_unitario" name="costo_unitario" step="0.01" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="precio_venta" class="form-label">Precio de Venta</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" id="precio_venta" name="precio_venta" step="0.01" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="stock" class="form-label">Stock</label>
                                <input type="number" class="form-control" id="stock" name="stock" min="0" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="categoria_producto" class="form-label">Categoría</label>
                            <select class="form-select" id="categoria_producto" name="id_categoria">
                                <option value="1">Electrónicos</option>
                                <option value="2">Muebles</option>
                                <option value="3">Ropa</option>
                                <option value="4">Alimentos</option>
                                <option value="5">Otros</option>
                            </select>
                        </div>
                        
                        <div class="mb-3" id="div-razon-cambio" style="display: none;">
                            <label for="razon_cambio" class="form-label">Razón del cambio de costo</label>
                            <input type="text" class="form-control" id="razon_cambio" name="razon_cambio">
                            <small class="text-muted">Requerido solo si el costo unitario ha cambiado</small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btnGuardarProducto">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Ver Historial de Costos -->
    <div class="modal fade" id="modalHistorialCostos" tabindex="-1" aria-labelledby="modalHistorialCostosLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalHistorialCostosLabel">Historial de Costos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="contenido-historial">
                        <div class="text-center p-5">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Cargando...</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Editar Nómina -->
    <div class="modal fade" id="modalNomina" tabindex="-1" aria-labelledby="modalNominaLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalNominaLabel">Editar Nómina</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formNomina">
                        <input type="hidden" id="id_nomina" name="id_nomina" value="">
                        <input type="hidden" id="id_empleado_nomina" name="id_empleado" value="">
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="empleado_nomina" class="form-label">Empleado</label>
                                <input type="text" class="form-control" id="empleado_nomina" disabled>
                            </div>
                            <div class="col-md-6">
                                <label for="fecha_nomina" class="form-label">Fecha</label>
                                <input type="date" class="form-control" id="fecha_nomina" name="fecha_nomina" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="sueldo_base" class="form-label">Sueldo Base</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" id="sueldo_base" name="sueldo_base" step="0.01" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="extras" class="form-label">Extras</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" id="extras" name="extras" step="0.01" min="0" value="0">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="bonos" class="form-label">Bonos</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" id="bonos" name="bonos" step="0.01" min="0" value="0">
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="observaciones" class="form-label">Observaciones</label>
                            <textarea class="form-control" id="observaciones" name="observaciones" rows="2"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btnGuardarNomina">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer mt-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0">&copy; 2025 Tu Empresa. Todos los derechos reservados.</p>
                </div>
                <div class="col-md-6 text-end">
                    <p class="mb-0">Sistema de Control v2.3</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap & Required JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <!-- Dashboard JS -->
    <script src="sistema_control/js/dashboard.js"></script>
</body>
</html>