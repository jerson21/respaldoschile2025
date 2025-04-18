document.addEventListener('DOMContentLoaded', function() {
    // Cargar datos para los gráficos y estadísticas
    cargarEstadisticas();
    cargarGastos();
    cargarComparativaPresupuesto();
    cargarProductos();
    cargarNomina();
    cargarPresupuesto();
    
    // Inicializar eventos para gastos
    document.getElementById('btn-nuevo-gasto').addEventListener('click', abrirModalNuevoGasto);
    document.getElementById('btnGuardarGasto').addEventListener('click', guardarGasto);
    
    // Inicializar eventos para productos
    document.getElementById('btn-nuevo-producto').addEventListener('click', abrirModalNuevoProducto);
    document.getElementById('btnGuardarProducto').addEventListener('click', guardarProducto);
    
    // Inicializar eventos para nómina
    document.getElementById('select-mes').addEventListener('change', function() {
        cargarNomina(this.value);
    });
    document.getElementById('btn-actualizar-nomina').addEventListener('click', function() {
        cargarNomina(document.getElementById('select-mes').value);
    });
    document.getElementById('btnGuardarNomina').addEventListener('click', guardarNomina);
    
    // Inicializar eventos para presupuesto
    document.getElementById('select-periodo').addEventListener('change', function() {
        cargarPresupuesto(this.value);
    });
    
    // Detectar cambios en costo unitario para mostrar/ocultar razón del cambio
    document.getElementById('costo_unitario').addEventListener('change', function() {
        const costoAnterior = parseFloat(document.getElementById('costo_anterior').value);
        const costoNuevo = parseFloat(this.value);
        
        if (costoAnterior !== costoNuevo && costoAnterior > 0) {
            document.getElementById('div-razon-cambio').style.display = 'block';
            document.getElementById('razon_cambio').setAttribute('required', 'required');
        } else {
            document.getElementById('div-razon-cambio').style.display = 'none';
            document.getElementById('razon_cambio').removeAttribute('required');
        }
    });
    
    // Inicializar gráfico de tendencia de sueldos
    const salaryTrendCtx = document.getElementById('salaryTrendChart').getContext('2d');
    new Chart(salaryTrendCtx, {
        type: 'line',
        data: {
            labels: ['Oct 2024', 'Nov 2024', 'Dic 2024', 'Ene 2025', 'Feb 2025', 'Mar 2025'],
            datasets: [{
                label: 'Total Nómina',
                data: [14800, 14800, 15200, 15200, 15750, 15750],
                borderColor: '#2c3e50',
                backgroundColor: 'rgba(44, 62, 80, 0.1)',
                tension: 0.1,
                fill: true
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: false,
                    min: 14000,
                    ticks: {
                        callback: function(value) {
                            return '$' + value;
                        }
                    }
                }
            }
        }
    });
});

// Función para cargar estadísticas generales
function cargarEstadisticas() {
    fetch('sistema_control/api/estadisticas.php')
    .then(response => response.json())
        .then(data => {
            document.getElementById('total-gastos').textContent = '$' + data.gastos_totales.toLocaleString();
            document.getElementById('var-gastos').textContent = data.var_gastos + '%';
            document.getElementById('margen-promedio').textContent = data.margen_promedio + '%';
            document.getElementById('var-margen').textContent = data.var_margen + '%';
            document.getElementById('total-sueldos').textContent = '$' + data.sueldos_totales.toLocaleString();
            document.getElementById('var-sueldos').textContent = data.var_sueldos + '%';
            
            // Inicializar gráfico de distribución de gastos
            inicializarGraficoGastos(data.distribucion_gastos);
            // Inicializar gráfico de evolución de costos
            inicializarGraficoEvolucionCostos(data.evolucion_costos);
        })
        .catch(error => {
            console.error('Error al cargar estadísticas:', error);
        });
}

// Función para cargar lista de gastos
function cargarGastos() {
    fetch('sistema_control/api/gastos.php')
        .then(response => response.json())
        .then(data => {
            actualizarTablaGastos(data);
        })
        .catch(error => {
            console.error('Error al cargar gastos:', error);
            document.querySelector('#tabla-gastos tbody').innerHTML = 
                '<tr><td colspan="6" class="text-center text-danger">Error al cargar los datos</td></tr>';
        });
}

// Función para actualizar la tabla de gastos
function actualizarTablaGastos(gastos) {
    const tbody = document.querySelector('#tabla-gastos tbody');
    
    if (gastos.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" class="text-center">No hay gastos registrados</td></tr>';
        return;
    }
    
    let html = '';
    gastos.forEach(gasto => {
        const fecha = new Date(gasto.fecha).toLocaleDateString('es-ES');
        
        html += `
        <tr>
            <td>${fecha}</td>
            <td>${gasto.descripcion}</td>
            <td><span class="badge" style="background-color: ${gasto.color}"><i class="fas ${gasto.icono} me-1"></i> ${gasto.categoria}</span></td>
            <td>$${parseFloat(gasto.monto).toLocaleString('es-ES', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
            <td>${gasto.responsable}</td>
            <td>
                <button class="btn btn-sm btn-outline-secondary ver-gasto" data-id="${gasto.id_gasto}"><i class="fas fa-eye"></i></button>
                <button class="btn btn-sm btn-outline-primary editar-gasto" data-id="${gasto.id_gasto}"><i class="fas fa-edit"></i></button>
            </td>
        </tr>
        `;
    });
    
    tbody.innerHTML = html;
    
    // Agregar eventos a los botones
    document.querySelectorAll('.ver-gasto').forEach(btn => {
        btn.addEventListener('click', function() {
            verGasto(this.getAttribute('data-id'));
        });
    });
    
    document.querySelectorAll('.editar-gasto').forEach(btn => {
        btn.addEventListener('click', function() {
            editarGasto(this.getAttribute('data-id'));
        });
    });
}

// Función para cargar la comparativa presupuesto vs gastos
function cargarComparativaPresupuesto() {
    fetch('sistema_control/api/comparativa_presupuesto.php')
        .then(response => response.json())
        .then(data => {
            actualizarComparativaPresupuesto(data);
        })
        .catch(error => {
            console.error('Error al cargar comparativa de presupuesto:', error);
            document.getElementById('comparativa-container').innerHTML = 
                '<div class="alert alert-danger">Error al cargar los datos de comparativa</div>';
        });
}

// Función para actualizar la comparativa presupuesto vs gastos
function actualizarComparativaPresupuesto(comparativas) {
    const container = document.getElementById('comparativa-container');
    
    if (comparativas.length === 0) {
        container.innerHTML = '<div class="alert alert-info">No hay datos de presupuesto disponibles</div>';
        return;
    }
    
    let html = '';
    comparativas.forEach(comp => {
        const porcentaje = comp.presupuesto_mensual > 0 
            ? (comp.gastado / comp.presupuesto_mensual * 100).toFixed(1) 
            : 0;
            
        const clase = porcentaje > 100 ? 'bg-danger' : (porcentaje > 90 ? 'bg-warning' : 'bg-success');
        
        html += `
        <div class="mb-3">
            <div class="d-flex justify-content-between mb-1">
                <span>${comp.categoria}</span>
                <span>$${parseFloat(comp.gastado).toLocaleString('es-ES', {minimumFractionDigits: 2, maximumFractionDigits: 2})} / $${parseFloat(comp.presupuesto_mensual).toLocaleString('es-ES', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</span>
            </div>
            <div class="progress">
                <div class="progress-bar ${clase}" role="progressbar" style="width: ${Math.min(porcentaje, 100)}%" 
                    aria-valuenow="${porcentaje}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
        `;
    });
    
    container.innerHTML = html;
}

// Función para cargar productos
function cargarProductos() {
    fetch('sistema_control/api/productos.php')
        .then(response => response.json())
        .then(data => {
            actualizarTablaProductos(data);
            actualizarProductosMargen(data);
        })
        .catch(error => {
            console.error('Error al cargar productos:', error);
            document.querySelector('#tabla-productos tbody').innerHTML = 
                '<tr><td colspan="6" class="text-center text-danger">Error al cargar los datos</td></tr>';
        });
}

// Función para actualizar la tabla de productos
// Función para actualizar la tabla de productos
function actualizarTablaProductos(productos) {
    const tbody = document.querySelector('#tabla-productos tbody');
    
    if (productos.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" class="text-center">No hay productos registrados</td></tr>';
        return;
    }
    
    let html = '';
    productos.forEach(producto => {
        const margenColor = producto.margen >= 50 ? 'success' : (producto.margen >= 30 ? 'primary' : 'warning');
        
        html += `
        <tr>
            <td>${producto.nombre}</td>
            <td>$${parseFloat(producto.costo_unitario).toLocaleString('es-ES', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
            <td>$${parseFloat(producto.precio_venta).toLocaleString('es-ES', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
            <td><span class="badge bg-${margenColor}">${producto.margen}%</span></td>
            <td>${producto.stock}</td>
            <td>
                <button class="btn btn-sm btn-outline-primary editar-producto" data-id="${producto.id_producto}"><i class="fas fa-edit"></i></button>
                <button class="btn btn-sm btn-outline-info historial-producto" data-id="${producto.id_producto}"><i class="fas fa-history"></i></button>
                <button class="btn btn-sm btn-outline-danger eliminar-producto" data-id="${producto.id_producto}"><i class="fas fa-trash-alt"></i></button>
            </td>
        </tr>
        `;
    });
    
    tbody.innerHTML = html;
    
    // Agregar eventos a los botones
    document.querySelectorAll('.editar-producto').forEach(btn => {
        btn.addEventListener('click', function() {
            editarProducto(this.getAttribute('data-id'));
        });
    });
    
    document.querySelectorAll('.historial-producto').forEach(btn => {
        btn.addEventListener('click', function() {
            verHistorialCostos(this.getAttribute('data-id'));
        });
    });
    
    document.querySelectorAll('.eliminar-producto').forEach(btn => {
        btn.addEventListener('click', function() {
            mostrarConfirmacionEliminarProducto(this.getAttribute('data-id'));
        });
    });
}

// Función para cargar nómina
function cargarNomina(mes = null) {
    const mesActual = mes || document.getElementById('select-mes').value;
    
    fetch(`sistema_control/api/nomina.php?mes=${mesActual}`)
        .then(response => response.json())
        .then(data => {
            actualizarTablaNomina(data.empleados);
            actualizarResumenNomina(data.resumen);
            
            // Actualizar gráficos de nómina
            actualizarGraficoNomina(data.departamentos);
        })
        .catch(error => {
            console.error('Error al cargar nómina:', error);
            document.querySelector('#tabla-nomina tbody').innerHTML = 
                '<tr><td colspan="7" class="text-center text-danger">Error al cargar los datos</td></tr>';
        });
}

// Función para actualizar tabla de nómina
function actualizarTablaNomina(empleados) {
    const tbody = document.querySelector('#tabla-nomina tbody');
    
    if (empleados.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" class="text-center">No hay datos de nómina para este mes</td></tr>';
        return;
    }
    
    let html = '';
    empleados.forEach(emp => {
        html += `
        <tr>
            <td>${emp.empleado}</td>
            <td>${emp.departamento}</td>
            <td>${emp.cargo}</td>
            <td>$${parseFloat(emp.sueldo_base).toLocaleString('es-ES', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
            <td>$${parseFloat(emp.extras).toLocaleString('es-ES', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
            <td>$${parseFloat(emp.total).toLocaleString('es-ES', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
            <td>
                <button class="btn btn-sm btn-outline-secondary ver-nomina" data-id="${emp.id_nomina}"><i class="fas fa-eye"></i></button>
                <button class="btn btn-sm btn-outline-primary editar-nomina" data-id="${emp.id_nomina}" data-empleado="${emp.id_empleado}" data-nombre="${emp.empleado}"><i class="fas fa-edit"></i></button>
            </td>
        </tr>
        `;
    });
    
    tbody.innerHTML = html;
    
    // Agregar eventos a los botones
    document.querySelectorAll('.editar-nomina').forEach(btn => {
        btn.addEventListener('click', function() {
            editarNomina(
                this.getAttribute('data-id'),
                this.getAttribute('data-empleado'),
                this.getAttribute('data-nombre')
            );
        });
    });
}

// Función para actualizar resumen de nómina
function actualizarResumenNomina(resumen) {
    document.getElementById('total-sueldos-base').textContent = '$' + parseFloat(resumen.total_base).toLocaleString('es-ES', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    document.getElementById('total-extras').textContent = '$' + parseFloat(resumen.total_extras).toLocaleString('es-ES', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    
    // Calcular impuestos (aproximadamente 10% del total)
    const impuestos = (parseFloat(resumen.total_base) + parseFloat(resumen.total_extras)) * 0.1;
    document.getElementById('total-impuestos').textContent = '$' + impuestos.toLocaleString('es-ES', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    
    document.getElementById('total-nomina').textContent = '$' + parseFloat(resumen.total_nomina).toLocaleString('es-ES', {minimumFractionDigits: 2, maximumFractionDigits: 2});
}

// Función para actualizar gráfico de distribución de nómina por departamento
function actualizarGraficoNomina(departamentos) {
    const ctx = document.getElementById('salaryDeptChart').getContext('2d');
    
    // Destruir gráfico existente si hay uno
    if (window.salaryDeptChart instanceof Chart) {
        window.salaryDeptChart.destroy();
    }
    
    const labels = departamentos.map(item => item.departamento);
    const values = departamentos.map(item => item.total);
    const colors = ['#3498db', '#2ecc71', '#9b59b6', '#e74c3c', '#f39c12', '#16a085', '#34495e'];
    
    window.salaryDeptChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: values,
                backgroundColor: colors,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });
}

// Función para cargar presupuesto
function cargarPresupuesto(periodo = 'anual') {
    fetch(`sistema_control/api/presupuesto.php?periodo=${periodo}`)
        .then(response => response.json())
        .then(data => {
            actualizarResumenPresupuesto(data.resumen);
            actualizarTablaPresupuesto(data.detalle);
            actualizarGraficoPresupuesto(data.areas);
        })
        .catch(error => {
            console.error('Error al cargar presupuesto:', error);
            document.querySelector('#tabla-presupuesto tbody').innerHTML = 
                '<tr><td colspan="7" class="text-center text-danger">Error al cargar los datos</td></tr>';
        });
}

// Función para actualizar resumen de presupuesto
function actualizarResumenPresupuesto(resumen) {
    const porcentajeEjecutado = (resumen.ejecutado / resumen.total * 100).toFixed(1);
    const disponible = resumen.total - resumen.ejecutado;
    
    document.getElementById('porcentaje-ejecutado').textContent = porcentajeEjecutado + '%';
    document.getElementById('presupuesto-total').textContent = '$' + resumen.total.toLocaleString('es-ES');
    document.getElementById('presupuesto-ejecutado').textContent = '$' + resumen.ejecutado.toLocaleString('es-ES');
    document.getElementById('presupuesto-disponible').textContent = '$' + disponible.toLocaleString('es-ES');
    
    // Actualizar gráfico de donut
    const ctx = document.getElementById('budgetDonutChart').getContext('2d');
    
    // Destruir gráfico existente si hay uno
    if (window.budgetDonutChart instanceof Chart) {
        window.budgetDonutChart.destroy();
    }
    
    window.budgetDonutChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Ejecutado', 'Disponible'],
            datasets: [{
                data: [parseFloat(porcentajeEjecutado), 100 - parseFloat(porcentajeEjecutado)],
                backgroundColor: [
                    '#3498db',
                    '#ecf0f1'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            cutout: '75%',
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.parsed + '%';
                        }
                    }
                }
            }
        }
    });
}

// Función para actualizar tabla de presupuesto
function actualizarTablaPresupuesto(detalle) {
    const tbody = document.querySelector('#tabla-presupuesto tbody');
    
    if (detalle.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" class="text-center">No hay datos de presupuesto disponibles</td></tr>';
        return;
    }
    
    let html = '';
    detalle.forEach(item => {
        const porcentaje = (item.gastado / item.presupuesto * 100).toFixed(1);
        const tendenciaClase = item.tendencia >= 0 ? 'text-danger' : 'text-success';
        const tendenciaIcono = item.tendencia >= 0 ? 'fa-arrow-up' : 'fa-arrow-down';
        
        const estadoClase = item.estado === 'En riesgo' ? 'bg-warning text-dark' : 
                          (item.estado === 'Subutilizado' ? 'bg-info' : 'bg-success');
        
        html += `
        <tr>
            <td>${item.categoria}</td>
            <td>$${parseFloat(item.presupuesto).toLocaleString('es-ES')}</td>
            <td>$${parseFloat(item.gastado).toLocaleString('es-ES')}</td>
            <td>${porcentaje}%</td>
            <td><span class="${tendenciaClase}"><i class="fas ${tendenciaIcono}"></i> ${Math.abs(item.tendencia)}%</span></td>
            <td>$${parseFloat(item.proyeccion).toLocaleString('es-ES')}</td>
            <td><span class="badge ${estadoClase}">${item.estado}</span></td>
        </tr>
        `;
    });
    
    tbody.innerHTML = html;
}

// Función para actualizar gráfico de presupuesto por área
function actualizarGraficoPresupuesto(areas) {
    const ctx = document.getElementById('budgetByAreaChart').getContext('2d');
    
    // Destruir gráfico existente si hay uno
    if (window.budgetByAreaChart instanceof Chart) {
        window.budgetByAreaChart.destroy();
    }
    
    const labels = areas.map(item => item.categoria);
    const presupuestado = areas.map(item => item.presupuesto);
    const ejecutado = areas.map(item => item.ejecutado);
    
    window.budgetByAreaChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Presupuestado',
                    data: presupuestado,
                    backgroundColor: 'rgba(44, 62, 80, 0.6)',
                    borderColor: 'rgba(44, 62, 80, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Ejecutado',
                    data: ejecutado,
                    backgroundColor: 'rgba(52, 152, 219, 0.6)',
                    borderColor: 'rgba(52, 152, 219, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value;
                        }
                    }
                }
            }
        }
    });
}

// Función para actualizar los productos con mayor margen
function actualizarProductosMargen(productos) {
    const container = document.getElementById('productos-margen');
    
    if (productos.length === 0) {
        container.innerHTML = '<div class="col-12 text-center">No hay productos registrados</div>';
        return;
    }
    
    // Ordenar productos por margen (de mayor a menor)
    productos.sort((a, b) => b.margen - a.margen);
    
    // Mostrar los 4 productos con mayor margen
    let html = '';
    const topProductos = productos.slice(0, 4);
    
    topProductos.forEach(producto => {
        html += `
        <div class="col-md-3 mb-3">
            <div class="card product-card">
                <div class="card-body text-center">
                    <h5 class="card-title">${producto.nombre}</h5>
                    <div class="text-success fw-bold fs-4">${producto.margen}%</div>
                    <div class="text-muted small">Margen</div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-muted small">Costo</div>
                            <div>${parseFloat(producto.costo_unitario).toLocaleString('es-ES', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</div>
                        </div>
                        <div>
                            <div class="text-muted small">Precio</div>
                            <div>${parseFloat(producto.precio_venta).toLocaleString('es-ES', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `;
    });
    
    container.innerHTML = html;
}

// Función para inicializar el gráfico de distribución de gastos
function inicializarGraficoGastos(datos) {
    const ctx = document.getElementById('gastosChart').getContext('2d');
    
    // Destruir gráfico existente si hay uno
    if (window.gastosChart instanceof Chart) {
        window.gastosChart.destroy();
    }
    
    const labels = datos.map(item => item.nombre);
    const values = datos.map(item => item.total);
    const colors = datos.map(item => item.color);
    
    window.gastosChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: values,
                backgroundColor: colors,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const value = context.raw;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return `${value.toLocaleString('es-ES')} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
}

// Función para inicializar el gráfico de evolución de costos
function inicializarGraficoEvolucionCostos(datos) {
    const ctx = document.getElementById('costEvolutionChart').getContext('2d');
    
    // Destruir gráfico existente si hay uno
    if (window.costEvolutionChart instanceof Chart) {
        window.costEvolutionChart.destroy();
    }
    
    const labels = datos.map(item => item.mes);
    const values = datos.map(item => item.costo_promedio);
    
    window.costEvolutionChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Costo promedio',
                data: values,
                borderColor: '#3498db',
                tension: 0.1,
                fill: false
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: false,
                    ticks: {
                        callback: function(value) {
                            return '$' + value;
                        }
                    }
                }
            }
        }
    });
}

// Función para abrir el modal de nuevo gasto
function abrirModalNuevoGasto() {
    document.getElementById('formGasto').reset();
    document.getElementById('id_gasto').value = '';
    document.getElementById('modalGastoLabel').textContent = 'Registrar Nuevo Gasto';
    
    // Cargar categorías y responsables
    cargarCategorias();
    cargarResponsables();
    
    // Establecer la fecha actual por defecto
    const hoy = new Date().toISOString().split('T')[0];
    document.getElementById('fecha').value = hoy;
    
    // Mostrar el modal
    const modal = new bootstrap.Modal(document.getElementById('modalGasto'));
    modal.show();
}

// Función para abrir el modal de nuevo producto
function abrirModalNuevoProducto() {
    document.getElementById('formProducto').reset();
    document.getElementById('id_producto').value = '';
    document.getElementById('costo_anterior').value = '0';
    document.getElementById('modalProductoLabel').textContent = 'Registrar Nuevo Producto';
    
    // Ocultar el campo de razón de cambio
    document.getElementById('div-razon-cambio').style.display = 'none';
    document.getElementById('razon_cambio').removeAttribute('required');
    
    // Establecer valores por defecto
    document.getElementById('stock').value = '0';
    
    // Mostrar el modal
    const modal = new bootstrap.Modal(document.getElementById('modalProducto'));
    modal.show();
}

// Función para cargar categorías en el select
function cargarCategorias() {
    fetch('sistema_control/api/categorias.php')
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById('id_categoria');
            select.innerHTML = '<option value="">Seleccione una categoría</option>';
            
            data.forEach(categoria => {
                select.innerHTML += `<option value="${categoria.id_categoria}">${categoria.nombre}</option>`;
            });
        })
        .catch(error => {
            console.error('Error al cargar categorías:', error);
        });
}

// Función para cargar responsables en el select
function cargarResponsables() {
    fetch('sistema_control/api/empleados.php')
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById('id_responsable');
            select.innerHTML = '<option value="">Seleccione un responsable</option>';
            
            data.forEach(empleado => {
                select.innerHTML += `<option value="${empleado.id_empleado}">${empleado.nombre_completo}</option>`;
            });
        })
        .catch(error => {
            console.error('Error al cargar empleados:', error);
        });
}

// Función para ver un gasto
function verGasto(id) {
    fetch(`sistema_control/api/gasto.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            // Aquí puedes mostrar los detalles del gasto en un modal o alert
            alert(`Gasto: ${data.descripcion}\nFecha: ${new Date(data.fecha).toLocaleDateString('es-ES')}\nMonto: ${parseFloat(data.monto).toLocaleString('es-ES')}\nCategoría: ${data.categoria_nombre}\nResponsable: ${data.responsable_nombre}\nNotas: ${data.notas || 'N/A'}`);
        })
        .catch(error => {
            console.error('Error al cargar gasto:', error);
        });
}

// Función para editar un gasto
function editarGasto(id) {
    fetch(`sistema_control/api/gasto.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('id_gasto').value = data.id_gasto;
            document.getElementById('fecha').value = data.fecha;
            document.getElementById('descripcion').value = data.descripcion;
            document.getElementById('monto').value = data.monto;
            document.getElementById('notas').value = data.notas || '';
            
            // Cargar categorías y responsables, luego seleccionar los valores correctos
            cargarCategorias();
            cargarResponsables();
            
            setTimeout(() => {
                document.getElementById('id_categoria').value = data.id_categoria;
                document.getElementById('id_responsable').value = data.id_responsable;
            }, 500);
            
            document.getElementById('modalGastoLabel').textContent = 'Editar Gasto';
            
            // Mostrar el modal
            const modal = new bootstrap.Modal(document.getElementById('modalGasto'));
            modal.show();
        })
        .catch(error => {
            console.error('Error al cargar gasto para editar:', error);
        });
}

// Función para guardar un gasto (nuevo o editar)
function guardarGasto() {
    const formData = new FormData(document.getElementById('formGasto'));
    const id = document.getElementById('id_gasto').value;
    const url = id ? `sistema_control/api/gasto_update.php?id=${id}` : 'sistema_control/api/gasto_create.php';
    
    fetch(url, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Cerrar el modal
            bootstrap.Modal.getInstance(document.getElementById('modalGasto')).hide();
            
            // Recargar los datos
            cargarGastos();
            cargarEstadisticas();
            cargarComparativaPresupuesto();
            
            // Mostrar mensaje de éxito
            alert(id ? 'Gasto actualizado correctamente' : 'Gasto registrado correctamente');
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error al guardar gasto:', error);
        alert('Error al procesar la solicitud');
    });
}

// Función para editar un producto
function editarProducto(id) {
    fetch(`sistema_control/api/producto.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('id_producto').value = data.id_producto;
            document.getElementById('nombre_producto').value = data.nombre;
            document.getElementById('descripcion_producto').value = data.descripcion || '';
            document.getElementById('costo_unitario').value = data.costo_unitario;
            document.getElementById('costo_anterior').value = data.costo_unitario;
            document.getElementById('precio_venta').value = data.precio_venta;
            document.getElementById('stock').value = data.stock;
            document.getElementById('categoria_producto').value = data.id_categoria || '1';
            
            // Ocultar el campo de razón de cambio inicialmente
            document.getElementById('div-razon-cambio').style.display = 'none';
            document.getElementById('razon_cambio').removeAttribute('required');
            
            document.getElementById('modalProductoLabel').textContent = 'Editar Producto';
            
            // Mostrar el modal
            const modal = new bootstrap.Modal(document.getElementById('modalProducto'));
            modal.show();
        })
        .catch(error => {
            console.error('Error al cargar producto para editar:', error);
        });
}

// Función para guardar un producto (nuevo o editar)
function guardarProducto() {
    const formData = new FormData(document.getElementById('formProducto'));
    const id = document.getElementById('id_producto').value;
    const url = id ? `sistema_control/api/producto_update.php?id=${id}` : 'sistema_control/api/producto_create.php';
    
    fetch(url, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Cerrar el modal
            bootstrap.Modal.getInstance(document.getElementById('modalProducto')).hide();
            
            // Recargar los datos
            cargarProductos();
            cargarEstadisticas();
            
            // Mostrar mensaje de éxito
            alert(id ? 'Producto actualizado correctamente' : 'Producto registrado correctamente');
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error al guardar producto:', error);
        alert('Error al procesar la solicitud');
    });
}

// Función para editar nómina
function editarNomina(id, idEmpleado, nombreEmpleado) {
    fetch(`sistema_control/api/nomina_detalle.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('id_nomina').value = id;
            document.getElementById('id_empleado_nomina').value = idEmpleado;
            document.getElementById('empleado_nomina').value = nombreEmpleado;
            document.getElementById('fecha_nomina').value = data.fecha_nomina;
            document.getElementById('sueldo_base').value = data.sueldo_base;
            document.getElementById('extras').value = data.extras || '0';
            document.getElementById('bonos').value = data.bonos || '0';
            document.getElementById('observaciones').value = data.observaciones || '';
            
            // Mostrar el modal
            const modal = new bootstrap.Modal(document.getElementById('modalNomina'));
            modal.show();
        })
        .catch(error => {
            console.error('Error al cargar datos de nómina:', error);
        });
}

// Función para guardar nómina
function guardarNomina() {
    const formData = new FormData(document.getElementById('formNomina'));
    const id = document.getElementById('id_nomina').value;
    
    fetch(`sistema_control/api/nomina_update.php?id=${id}`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Cerrar el modal
            bootstrap.Modal.getInstance(document.getElementById('modalNomina')).hide();
            
            // Recargar los datos
            cargarNomina();
            cargarEstadisticas();
            
            // Mostrar mensaje de éxito
            alert('Nómina actualizada correctamente');
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error al guardar nómina:', error);
        alert('Error al procesar la solicitud');
    });
}

// Función para ver el historial de costos de un producto
function verHistorialCostos(id) {
    fetch(`sistema_control/api/historial_costos.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('contenido-historial');
            
            if (data.length === 0) {
                container.innerHTML = '<div class="alert alert-info">No hay historial de cambios de costo para este producto</div>';
            } else {
                let html = `
                <h6 class="mb-3">Producto: ${data[0].producto_nombre}</h6>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Costo Anterior</th>
                                <th>Costo Nuevo</th>
                                <th>Variación</th>
                                <th>Razón del Cambio</th>
                            </tr>
                        </thead>
                        <tbody>
                `;
                
                data.forEach(item => {
                    const fecha = new Date(item.fecha).toLocaleDateString('es-ES');
                    const costoAnterior = parseFloat(item.costo_anterior);
                    const costoNuevo = parseFloat(item.costo_nuevo);
                    const variacion = ((costoNuevo - costoAnterior) / costoAnterior * 100).toFixed(2);
                    const variacionClase = variacion > 0 ? 'text-danger' : 'text-success';
                    const variacionIcono = variacion > 0 ? 'fa-arrow-up' : 'fa-arrow-down';
                    
                    html += `
                    <tr>
                        <td>${fecha}</td>
                        <td>${costoAnterior.toLocaleString('es-ES', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
                        <td>${costoNuevo.toLocaleString('es-ES', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
                        <td class="${variacionClase}"><i class="fas ${variacionIcono}"></i> ${Math.abs(variacion)}%</td>
                        <td>${item.razon_cambio || 'No especificada'}</td>
                    </tr>
                    `;
                });
                
                html += `
                        </tbody>
                    </table>
                </div>
                `;
                
                container.innerHTML = html;
            }
            
            // Mostrar el modal
            const modal = new bootstrap.Modal(document.getElementById('modalHistorialCostos'));
            modal.show();
        })
        .catch(error => {
            console.error('Error al cargar historial de costos:', error);
        });
}


// Inicializar eventos para presupuesto
document.getElementById('btn-configurar-presupuesto').addEventListener('click', abrirModalConfigPresupuesto);
document.getElementById('btnGuardarPresupuesto').addEventListener('click', guardarConfigPresupuesto);

// Función para abrir el modal de configuración de presupuesto
function abrirModalConfigPresupuesto() {
    // Cargar presupuestos actuales
    cargarConfiguracionPresupuesto();
    
    // Mostrar el modal
    const modal = new bootstrap.Modal(document.getElementById('modalConfigPresupuesto'));
    modal.show();
}

// Función para cargar la configuración actual de presupuestos
function cargarConfiguracionPresupuesto() {
    fetch('sistema_control/api/presupuesto_config.php')
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('presupuestos-areas');
            
            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="3" class="text-center">No hay categorías disponibles</td></tr>';
                return;
            }
            
            let html = '';
            data.forEach((item, index) => {
                html += `
                <tr>
                    <td>
                        <input type="hidden" name="id_presupuesto[]" value="${item.id_presupuesto || ''}">
                        <input type="text" class="form-control" name="categoria[]" value="${item.categoria}" ${item.id_presupuesto ? 'readonly' : ''}>
                    </td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" name="monto_anual[]" value="${item.monto_anual || 0}" step="0.01" min="0" required>
                        </div>
                    </td>
                    <td>
                        <input type="text" class="form-control" name="descripcion[]" value="${item.descripcion || ''}">
                    </td>
                </tr>`;
            });
            
            // Agregar una fila para nueva categoría
            html += `
            <tr>
                <td>
                    <input type="hidden" name="id_presupuesto[]" value="">
                    <input type="text" class="form-control" name="categoria[]" placeholder="Nueva categoría">
                </td>
                <td>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" name="monto_anual[]" value="0" step="0.01" min="0">
                    </div>
                </td>
                <td>
                    <input type="text" class="form-control" name="descripcion[]" placeholder="Descripción">
                </td>
            </tr>`;
            
            tbody.innerHTML = html;
        })
        .catch(error => {
            console.error('Error al cargar configuración de presupuesto:', error);
            document.getElementById('presupuestos-areas').innerHTML = 
                '<tr><td colspan="3" class="text-center text-danger">Error al cargar los datos</td></tr>';
        });
}

// Función para guardar la configuración de presupuesto
function guardarConfigPresupuesto() {
    const formData = new FormData(document.getElementById('formPresupuesto'));
    
    fetch('sistema_control/api/presupuesto_save.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Cerrar el modal
            bootstrap.Modal.getInstance(document.getElementById('modalConfigPresupuesto')).hide();
            
            // Recargar los datos de presupuesto
            cargarPresupuesto();
            
            // Mostrar mensaje de éxito
            alert('Configuración de presupuesto guardada correctamente');
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error al guardar presupuesto:', error);
        alert('Error al procesar la solicitud');
    });
}

// Inicializar eventos para gestión de empleados
document.addEventListener('DOMContentLoaded', function() {
    // Eventos para gestión de empleados
    document.getElementById('btn-gestionar-empleados').addEventListener('click', abrirModalGestionEmpleados);
    document.getElementById('btn-nuevo-empleado').addEventListener('click', abrirModalNuevoEmpleado);
    document.getElementById('btnGuardarEmpleado').addEventListener('click', guardarEmpleado);
    document.getElementById('btnConfirmDelete').addEventListener('click', confirmarEliminarEmpleado);
});

// Función para abrir el modal de gestión de empleados
function abrirModalGestionEmpleados() {
    // Cargar lista de empleados
    cargarEmpleadosTabla();
    
    // Mostrar el modal
    const modal = new bootstrap.Modal(document.getElementById('modalGestionEmpleados'));
    modal.show();
}

// Función para cargar la tabla de empleados
function cargarEmpleadosTabla() {
    fetch('sistema_control/api/empleados_lista.php')
        .then(response => response.json())
        .then(data => {
            const tbody = document.querySelector('#tabla-empleados tbody');
            
            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="9" class="text-center">No hay empleados registrados</td></tr>';
                return;
            }
            
            let html = '';
            data.forEach(emp => {
                const fechaContratacion = new Date(emp.fecha_contratacion).toLocaleDateString('es-ES');
                
                html += `
                <tr>
                    <td>${emp.nombre}</td>
                    <td>${emp.apellido}</td>
                    <td>${emp.departamento}</td>
                    <td>${emp.cargo}</td>
                    <td>${fechaContratacion}</td>
                    <td>$${parseFloat(emp.sueldo_base).toLocaleString('es-ES', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
                    <td>${emp.email || '-'}</td>
                    <td>${emp.telefono || '-'}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary editar-empleado" data-id="${emp.id_empleado}"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-sm btn-outline-danger eliminar-empleado" data-id="${emp.id_empleado}"><i class="fas fa-trash-alt"></i></button>
                    </td>
                </tr>
                `;
            });
            
            tbody.innerHTML = html;
            
            // Agregar eventos a los botones
            document.querySelectorAll('.editar-empleado').forEach(btn => {
                btn.addEventListener('click', function() {
                    editarEmpleado(this.getAttribute('data-id'));
                });
            });
            
            document.querySelectorAll('.eliminar-empleado').forEach(btn => {
                btn.addEventListener('click', function() {
                    mostrarConfirmacionEliminar(this.getAttribute('data-id'));
                });
            });
        })
        .catch(error => {
            console.error('Error al cargar empleados:', error);
            document.querySelector('#tabla-empleados tbody').innerHTML = 
                '<tr><td colspan="9" class="text-center text-danger">Error al cargar los datos</td></tr>';
        });
}

// Función para abrir el modal de nuevo empleado
function abrirModalNuevoEmpleado() {
    document.getElementById('formEmpleado').reset();
    document.getElementById('id_empleado').value = '';
    document.getElementById('modalEmpleadoLabel').textContent = 'Nuevo Empleado';
    
    // Cargar departamentos
    cargarDepartamentos();
    
    // Establecer la fecha actual por defecto
    const hoy = new Date().toISOString().split('T')[0];
    document.getElementById('fecha_contratacion').value = hoy;
    
    // Mostrar el modal
    const modal = new bootstrap.Modal(document.getElementById('modalEmpleado'));
    modal.show();
}

// Función para cargar departamentos en el select
function cargarDepartamentos() {
    fetch('sistema_control/api/departamentos.php')
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById('id_departamento');
            select.innerHTML = '<option value="">Seleccione un departamento</option>';
            
            data.forEach(depto => {
                select.innerHTML += `<option value="${depto.id_departamento}">${depto.nombre}</option>`;
            });
        })
        .catch(error => {
            console.error('Error al cargar departamentos:', error);
        });
}

// Función para editar un empleado
function editarEmpleado(id) {
    fetch(`sistema_control/api/empleado.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('id_empleado').value = data.id_empleado;
            document.getElementById('nombre_empleado').value = data.nombre;
            document.getElementById('apellido_empleado').value = data.apellido;
            document.getElementById('cargo_empleado').value = data.cargo;
            document.getElementById('fecha_contratacion').value = data.fecha_contratacion;
            document.getElementById('sueldo_base_empleado').value = data.sueldo_base;
            document.getElementById('email_empleado').value = data.email || '';
            document.getElementById('telefono_empleado').value = data.telefono || '';
            document.getElementById('activo_empleado').checked = data.activo == 1;
            
            // Cargar departamentos y seleccionar el correcto
            cargarDepartamentos();
            setTimeout(() => {
                document.getElementById('id_departamento').value = data.id_departamento;
            }, 500);
            
            document.getElementById('modalEmpleadoLabel').textContent = 'Editar Empleado';
            
            // Mostrar el modal
            const modal = new bootstrap.Modal(document.getElementById('modalEmpleado'));
            modal.show();
        })
        .catch(error => {
            console.error('Error al cargar empleado para editar:', error);
        });
}

// Función para guardar un empleado (nuevo o editar)
function guardarEmpleado() {
    const formData = new FormData(document.getElementById('formEmpleado'));
    const id = document.getElementById('id_empleado').value;
    const url = id ? `sistema_control/api/empleado_update.php?id=${id}` : 'sistema_control/api/empleado_create.php';
    
    // Ajustar el valor de activo si no está marcado el checkbox
    if (!formData.has('activo')) {
        formData.append('activo', '0');
    }
    
    fetch(url, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Cerrar el modal
            bootstrap.Modal.getInstance(document.getElementById('modalEmpleado')).hide();
            
            // Recargar los datos
            cargarEmpleadosTabla();
            
            // Actualizar también el select de responsables para gastos
            cargarResponsables();
            
            // Mostrar mensaje de éxito
            alert(id ? 'Empleado actualizado correctamente' : 'Empleado registrado correctamente');
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error al guardar empleado:', error);
        alert('Error al procesar la solicitud');
    });
}

// Función para mostrar confirmación de eliminación
function mostrarConfirmacionEliminar(id) {
    document.getElementById('id_eliminar').value = id;
    
    const modal = new bootstrap.Modal(document.getElementById('modalConfirmDelete'));
    modal.show();
}

// Función para confirmar eliminación de empleado
function confirmarEliminarEmpleado() {
    const id = document.getElementById('id_eliminar').value;
    
    fetch(`sistema_control/api/empleado_delete.php?id=${id}`, {
        method: 'POST'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Cerrar el modal
            bootstrap.Modal.getInstance(document.getElementById('modalConfirmDelete')).hide();
            
            // Recargar los datos
            cargarEmpleadosTabla();
            
            // Actualizar también el select de responsables para gastos
            cargarResponsables();
            
            // Mostrar mensaje de éxito
            alert('Empleado eliminado correctamente');
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error al eliminar empleado:', error);
        alert('Error al procesar la solicitud');
    });
}


// Inicializar eventos para eliminación de productos
document.addEventListener('DOMContentLoaded', function() {
    // ... (otros eventos inicializados)
    document.getElementById('btnConfirmDeleteProducto').addEventListener('click', confirmarEliminarProducto);
});

// Función para mostrar confirmación de eliminación de producto
function mostrarConfirmacionEliminarProducto(id) {
    document.getElementById('id_eliminar_producto').value = id;
    
    const modal = new bootstrap.Modal(document.getElementById('modalConfirmDeleteProducto'));
    modal.show();
}

// Función para confirmar eliminación de producto
function confirmarEliminarProducto() {
    const id = document.getElementById('id_eliminar_producto').value;
    
    fetch(`sistema_control/api/producto_delete.php?id=${id}`, {
        method: 'POST'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Cerrar el modal
            bootstrap.Modal.getInstance(document.getElementById('modalConfirmDeleteProducto')).hide();
            
            // Recargar los datos
            cargarProductos();
            cargarEstadisticas();
            
            // Mostrar mensaje de éxito
            alert('Producto eliminado correctamente');
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error al eliminar producto:', error);
        alert('Error al procesar la solicitud');
    });
}