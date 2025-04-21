<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard de Pedidos</title>
</head>
<body>
    <h1>Dashboard de Pedidos (MVC)</h1>
    <div id="pedidos-container">
        <p>Cargando pedidos...</p>
    </div>
    <script>
    (function() {
        const container = document.getElementById('pedidos-container');
        const API_BASE = '<?= getenv("API_BASE_URL") ?: "http://localhost:3000/api" ?>';
        const token = localStorage.getItem('api_token');
        if (!token) {
            container.innerHTML = '<p>No has iniciado sesión. Por favor <a href="/login">inicia sesión</a>.</p>';
            return;
        }
        fetch(API_BASE + '/pedidos', {
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('HTTP ' + response.status);
            return response.json();
        })
        .then(data => {
            const pedidos = data.data || data;
            if (!Array.isArray(pedidos) || pedidos.length === 0) {
                container.innerHTML = '<p>No hay pedidos para mostrar.</p>';
                return;
            }
            const table = document.createElement('table');
            table.border = 1; table.cellPadding = 5; table.cellSpacing = 0;
            const thead = table.createTHead();
            const headerRow = thead.insertRow();
            Object.keys(pedidos[0]).forEach(col => {
                const th = document.createElement('th');
                th.textContent = col;
                headerRow.appendChild(th);
            });
            const tbody = table.createTBody();
            pedidos.forEach(p => {
                const row = tbody.insertRow();
                Object.values(p).forEach(val => {
                    const cell = row.insertCell();
                    cell.textContent = val;
                });
            });
            container.innerHTML = '';
            container.appendChild(table);
        })
        .catch(err => {
            console.error(err);
            container.innerHTML = '<p>Error cargando pedidos.</p>';
        });
    })();
    </script>
</body>
</html>