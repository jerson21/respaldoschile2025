<?php require_once "vistas/parte_superior.php" ?>

<!--INICIO del cont principal-->
<!--INICIO del cont principal-->
<div class="container">
    <h1>Lista Productos RespaldosChile</h1>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<div style="padding: 15px; margin:0 auto; text-align: center">
    <div class="container mt-5">
        <h2>Tabla de Productos</h2>
        <button id="btnAgregarProducto" class="btn btn-primary mb-3">Agregar Nuevo Producto</button>
        <div class="container mt-5">
    <h2>Tabla de Productos</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Categoría</th>
                <th>Modelo</th>
                <th>Tamaño</th>
                <th>Espuma</th>
                <th>Chapon</th>
                <th>Corchetes</th>
                <th>Tabla</th>
                <th>Costura</th>
                <th>Tela</th>
                <th>Tafetan</th>
                <th>Esqueletero</th>
                <th>ValorTapiz</th>
                <th>Alusa</th>
                <th>Costo Total</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody id="tablaProductos">
            <?php
            include_once 'bd/conexion.php';
            $objeto = new Conexion();
            $conexion = $objeto->Conectar();

            // Consulta a la base de datos
            $sql = "
            SELECT pv.*, pm.*, c.*, pm.id AS idprod,
                   (COALESCE(pm.espuma, 0) + COALESCE(pm.chapon, 0) + COALESCE(pm.corchetes, 0) + 
                    COALESCE(pm.tabla, 0) + COALESCE(pm.costura, 0) + COALESCE(pm.tafetan, 0) + 
                    COALESCE(pm.tela, 0) + COALESCE(pm.esqueletero, 0) + COALESCE(pm.valortapiz, 0) + 
                    COALESCE(pm.alusa, 0)) AS costo_total
            FROM productos_venta pv
            INNER JOIN productos_materiales pm ON pv.modelo = pm.modelo
            INNER JOIN categoria_productos c ON pv.id_categoria = c.id WHERE tamano != '' ORDER BY pv.modelo
            ";
            $resultado = $conexion->query($sql);
            if ($resultado->rowCount() > 0) {
                while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                        <td class='editable id' data-columna='id'>" . $fila["idprod"] . "</td>
                        <td class='editable' data-columna='categoria'>" . $fila["categoria"] . "</td>
                        <td class='editable' data-columna='modelo'>" . $fila["modelo"] . "</td>
                        <td class='editable' data-columna='tamano'>" . $fila["tamano"] . "</td>
                        <td class='editable' data-columna='espuma'>" . $fila["espuma"] . "</td>
                        <td class='editable' data-columna='chapon'>" . $fila["chapon"] . "</td>
                        <td class='editable' data-columna='corchetes'>" . $fila["corchetes"] . "</td>
                        <td class='editable' data-columna='tabla'>" . $fila["tabla"] . "</td>
                        <td class='editable' data-columna='costura'>" . $fila["costura"] . "</td>
                        <td class='editable' data-columna='tela'>" . $fila["tela"] . "</td>
                        <td class='editable' data-columna='tafetan'>" . $fila["tafetan"] . "</td>
                        <td class='editable' data-columna='esqueletero'>" . $fila["esqueletero"] . "</td>
                        <td class='editable' data-columna='valortapiz'>" . $fila["valortapiz"] . "</td>
                        <td class='editable' data-columna='alusa'>" . $fila["alusa"] . "</td>
                        <td>" . $fila["costo_total"] . "</td>
                        <td><button class='btn btn-danger eliminar'>Eliminar</button></td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='16'>No se encontraron datos</td></tr>";
            }
            $conexion = null;
            ?>
        </tbody>
    </table>
</div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const celdas = document.querySelectorAll('.editable');

                // Agregar nuevo producto
                document.getElementById('btnAgregarProducto').addEventListener('click', function () {
                    // Cargar las categorías primero
                    fetch('rutinas/get_categorias.php')
                        .then(response => response.json())
                        .then(data => {
                            let opcionesCategorias = data.map(categoria => `<option value="${categoria.id}">${categoria.nombre}</option>`).join('');
                            let htmlForm = `
            <select id="swal-categoria" class="swal2-input">${opcionesCategorias}</select>
            <input id="swal-nombre" class="swal2-input" placeholder="Nombre">
            <input id="swal-color" class="swal2-input" placeholder="Color">
            <input id="swal-tela" class="swal2-input" placeholder="Tela">
            <input id="swal-plazas" class="swal2-input" placeholder="Plazas">
            <input id="swal-alto" class="swal2-input" placeholder="Alto">
            <input id="swal-ancho" class="swal2-input" placeholder="Ancho">
            <input id="swal-descripcion" class="swal2-input" placeholder="Descripción">
        `;

                            Swal.fire({
                                title: 'Agregar Nuevo Producto',
                                html: htmlForm,
                                focusConfirm: false,
                                preConfirm: () => {
                                    const categoria = document.getElementById('swal-categoria').value;
                                    const nombre = document.getElementById('swal-nombre').value;
                                    const color = document.getElementById('swal-color').value;
                                    const tela = document.getElementById('swal-tela').value;
                                    const plazas = document.getElementById('swal-plazas').value;
                                    const alto = document.getElementById('swal-alto').value;
                                    const ancho = document.getElementById('swal-ancho').value;
                                    const descripcion = document.getElementById('swal-descripcion').value;

                                    $.ajax({
                                        url: 'rutinas/update_producto.php',
                                        type: 'POST',
                                        data: {
                                            accion: 'agregar',
                                            categoria: categoria,
                                            nombre: nombre,
                                            color: color,
                                            tela: tela,
                                            plazas: plazas,
                                            alto: alto,
                                            ancho: ancho,
                                            descripcion: descripcion
                                        },
                                        success: function (response) {
                                            Swal.fire('¡Éxito!', response, 'success').then(() => location.reload());
                                        }
                                    });
                                }
                            });
                        })
                        .catch(error => console.error('Error al cargar las categorías:', error));
                });

                // Editar producto
                celdas.forEach(celda => {
                    celda.addEventListener('dblclick', function () {
                        const id = this.closest('tr').querySelector('.id').textContent;
                        const columna = this.getAttribute('data-columna');
                        const valor = this.textContent;

                        Swal.fire({
                            title: 'Editar Producto',
                            input: 'text',
                            inputValue: valor,
                            showCancelButton: true,
                            confirmButtonText: 'Guardar',
                            preConfirm: (nuevoValor) => {
                                $.ajax({
                                    url: 'rutinas/update_producto.php',
                                    type: 'POST',
                                    data: {
                                        accion: 'editar',
                                        id: id,
                                        columna: columna,
                                        valor: nuevoValor
                                    },
                                    success: function (response) {
                                        Swal.fire('¡Éxito!', response, 'success').then(() => location.reload());
                                    }
                                });
                            }
                        });
                    });
                });

                // Manejar la eliminación de productos
                $('#tablaProductos').on('click', '.eliminar', function () {
                    const id = $(this).closest('tr').find('.id').text();

                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "¡No podrás revertir esto!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, eliminarlo',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: 'rutinas/update_producto.php',
                                type: 'POST',
                                data: {
                                    accion: 'eliminar',
                                    id: id
                                },
                                success: function (response) {
                                    Swal.fire('¡Eliminado!', response, 'success').then(() => location.reload());
                                }
                            });
                        }
                    });
                });
            });

        </script>


    </div>

    <!--FIN del cont principal-->

    <?php require_once "vistas/parte_inferior.php" ?>