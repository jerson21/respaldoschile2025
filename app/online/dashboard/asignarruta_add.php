<?php
// Incluimos el archivo de conexión
include("bd/conexion.php");

// Obtenemos la conexión usando el método estático
$conn = Conexion::Conectar();

try {
    $id = $_POST['id'];
    
    // Consulta para obtener pedidos no asignados a rutas
    $sql2 = "SELECT * FROM pedido_detalle WHERE ruta_asignada = 0 AND estadopedido IN (2,3,9)";
    $stmt = $conn->prepare($sql2);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        $output = "";
        $output .= "<table class='table table-hover table-striped table-bordered' style='padding:0px; font-size:12px;'>
            <thead>
                <tr style=''>
                    <th>Cod</th>
                    <th style='width:8rem;'>Rut Cliente</th>
                    <th style='width:8rem;'>Modelo</th>
                    <th style='width:8rem;'>Plazas</th>
                    <th>Tela</th>
                    <th style='width:10rem;'>Color</th>
                    <th style='width:5rem;'>Altura Base</th>
                    <th style='width:15rem;'>Direccion</th>
                    <th>Telefono</th>
                    <th style='width:5rem;'>Instagram</th>
                    <th style='width:9rem;'>Estado Pedido</th>
                    <th style='width:1rem;'>Borrar</th>
                    <th style='width:9rem;'>Rutas</th>
                </tr>
            </thead>";
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $id_prod = $row['id'];
            
            // Determinar estado
            if ($row['estadopedido'] == '2') {
                $estado = "<img src='img/fabricacion.png' width='25px'";
            }
            if ($row['estadopedido'] == '3') {
                $estado = "<a href='informacion_producto.php?id=$id_prod'> <img src='img/ok.png' width='25px'> </a>";
            }
            
            // Obtener información del color
            $cod = $row['color'];
            $colorStmt = $conn->prepare("SELECT color FROM colores WHERE id = :cod");
            $colorStmt->bindParam(':cod', $cod, PDO::PARAM_STR);
            $colorStmt->execute();
            $fila = $colorStmt->fetch(PDO::FETCH_ASSOC);
            
            // Formatear datos
            $modelo = ucfirst($row['modelo']);
            if ($row['modelo'] == "Botone 3 corridas de botones") {
                $modelo = "1.35";
            }
            $color = isset($fila['color']) ? ucfirst(strtolower($fila['color'])) : '';
            $tipotela = ucwords($row['tipotela']);
            
            // Obtener información del cliente
            $rut = $row['rut_cliente'];
            $clienteStmt = $conn->prepare("SELECT * FROM clientes WHERE rut = :rut");
            $clienteStmt->bindParam(':rut', $rut, PDO::PARAM_STR);
            $clienteStmt->execute();
            $fila = $clienteStmt->fetch(PDO::FETCH_ASSOC);
            
            $output .= "<tbody>
                <tr>
                    <td>{$row['id']}</td>
                    <td>{$row['rut_cliente']}</td>
                    <td>{$modelo}</td>
                    <td>{$row['plazas']}</td>
                    <td>{$tipotela}</td>
                    <td>{$row['color']}</td>
                    <td>{$row['alturabase']}</td>
                    <td>{$row['direccion']} {$row['numero']}, {$row['comuna']}</td>
                    <td>{$row['telefono']}</td>
                    <td>" . (isset($fila['instagram']) ? $fila['instagram'] : '') . "</td>
                    <td>{$estado}</td>
                    <td><button class='btn btn-danger btn-sm eliminar-btn' data-id='{$row['id']}'>Eliminar</button></td>
                    <td><button type='button' class='btn btn-info btn-sm agregar-btn' data-toggle='modal' data-ruta='{$id}' data-id='{$row['id']}' data-target='#exampleModalCenter' data-num_orden='{$row['num_orden']}'>Asignar a ruta</button></td>
                </tr>
            </tbody>";
        }
        
        $output .= "</table>";
        echo $output;
    } else {
        echo "<h5>Ningún registro fue encontrado</h5>";
    }
} catch (PDOException $e) {
    echo "Error en la consulta: " . $e->getMessage();
}
?>

<script type="text/javascript">
$(document).on("click", ".agregar-btn", function() {
    var num_orden = $(this).data('num_orden');
    var id = $(this).data('id');
    var ruta = $(this).data('ruta');
    var element = this;
    
    $.ajax({
        url: "addidruta.php",
        type: "POST",
        cache: false,
        data: {
            agregarId: id,
            rutaId: ruta,
            numero_orden: num_orden
        },
        success: function(data) {
            if (data == 3) {
                $(element).closest("tr").fadeOut();
            } else {
                alert("Error al agregar a rutas" + data);
            }
        }
    });
});
</script>

<script type="text/javascript">
$(document).on("click", ".eliminar-btn", function() {
    var id = $(this).data('id');
    var ruta = $(this).data('ruta');
    var element = this;
    
    $.ajax({
        url: "eliminarpedido.php",
        type: "POST",
        cache: false,
        data: {
            agregarId: id
        },
        success: function(data) {
            if (data == 1) {
                $(element).closest("tr").fadeOut();
                setInterval(cargarrutas, 3000);
            } else {
                alert("Error al agregar a ruta");
            }
        }
    });
});
</script>