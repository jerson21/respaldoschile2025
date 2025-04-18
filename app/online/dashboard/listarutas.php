<div id="impresion">

<?php
// Incluir el archivo de conexión utilizando la clase Conexion
require_once "bd/conexion.php";

// Inicializar la conexión usando la clase Conexion
$objeto = new Conexion();
$conexion = $objeto->Conectar();

// Obtener el ID de la ruta
$id = isset($_POST['id']) ? $_POST['id'] : 0;

// Validar que el ID sea numérico
if (!is_numeric($id)) {
    echo "<h5>ID de ruta inválido</h5>";
    exit;
}

try {
    // Consulta para obtener los pedidos de la ruta ordenados por dirección
    $sql = "SELECT * FROM pedidos WHERE ruta_asignada = :id ORDER BY direccion ASC";
    $query = $conexion->prepare($sql);
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    
    // Verificar si hay resultados
    if ($query->rowCount() > 0) {
        echo "<div style='margin:0 auto; margin-bottom: 3rem;'>
        <a href='editar_ordenruta_pruebas.php?id=".$id."' class='btn btn-success'>ORGANIZAR RUTA</a>
        </div>";
        
        $output = "";
        $output .= "<table class='table table-hover table-striped table-bordered' style='font-size:12px; padding:0px;' cellpadding='0' cellspacing='0'>
        <thead>
        <tr style=''>
        <th>Codigo</th>
        <th style='width:8rem; padding: 0;'>Rut Cliente</th>
        <th style='width:8rem; padding: 0;'>Modelo</th>
        <th style='width:4rem; padding: 0;'>Plazas</th>
        <th>Tela</th>
        <th style='width:10rem; padding: 0;'>Color</th>
        <th style='width:3rem; padding: 0;'>Altura Base</th>
        <th style='width:10rem; padding: 0;'>Direccion</th>
        <th>Telefono</th>
        <th>Instagram</th>
        <th>Estado</th>
        <th style='width:8rem; padding: 0;'>Borrar</th>
        <th style='width:9rem; padding: 0;' >Cliente</th>
        <th>Notificar</th>
        </tr>
        </thead><tbody>";
        
        $contador = 0;
        
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $contador++;
            $id_prod = $row['id'];
            
            // Determinar el estado del pedido
            if($row['estadopedido'] == '2') {
                $estado = "<a href='informacion_producto.php?id=$id_prod'><img src='img/fabricacion.png' width='25px'></a>";
            } elseif($row['estadopedido'] == '3') {
                $estado = "<a href='informacion_producto.php?id=$id_prod'><img src='img/ok.png' width='25px'></a>";
            } else {
                $estado = "";
            }
            
            // Obtener información del color
            $cod = $row['color'];
            $stmt_color = $conexion->prepare("SELECT color FROM colores WHERE id = :cod");
            $stmt_color->bindParam(':cod', $cod, PDO::PARAM_INT);
            $stmt_color->execute();
            $color_result = $stmt_color->fetch(PDO::FETCH_ASSOC);
            
            // Obtener información de la ruta
            $cod_ruta = $row['ruta_asignada'];
            $stmt_ruta = $conexion->prepare("SELECT fecha FROM rutas WHERE id = :cod");
            $stmt_ruta->bindParam(':cod', $cod_ruta, PDO::PARAM_INT);
            $stmt_ruta->execute();
            $ruta_result = $stmt_ruta->fetch(PDO::FETCH_ASSOC);
            $fecha_rutar = isset($ruta_result['fecha']) ? $ruta_result['fecha'] : '';
            
            // Formatear la fecha
            setlocale(LC_TIME, "spanish");
            $fecha_ruta = $fecha_rutar ? strftime("%A, %d de %B de %Y", strtotime($fecha_rutar)) : '';
            $fecha_ruta = strtoupper($fecha_ruta);
            
            // Determinar el estado de confirmación
            if($row['confirma'] == 1) {
                $confirmacion = "<button class='btn btn-info btn-sm -btn' data-id='{$row['id']}'>Confirmado</button>";
            } else {
                $confirmacion = "<button class='btn btn-danger btn-sm -btn' data-id='{$row['id']}'>No Confirmado</button>";
            }
            
            // Formatear modelo y otros datos
            $modelo = ucfirst($row['modelo']);
            if($row['modelo'] == "Botone 3 corridas de botones") {
                $modelo = "1.35";
            }
            
            $color = $row['color'];
            $color = ucfirst(strtolower($color));
            $tipotela = ucwords($row['tipotela']);
            $idrutas = $row['id'];
            $rut = $row['rut_cliente'];
            
            // Obtener información del cliente
            $stmt_cliente = $conexion->prepare("SELECT * FROM clientes WHERE rut = :rut");
            $stmt_cliente->bindParam(':rut', $rut, PDO::PARAM_STR);
            $stmt_cliente->execute();
            $cliente_result = $stmt_cliente->fetch(PDO::FETCH_ASSOC);
            
            $numero_de_orden = $row['num_orden'];
            
            // Obtener información de todos los pedidos con el mismo número de orden
            $stmt_pedidos = $conexion->prepare("SELECT * FROM pedidos WHERE num_orden = :num_orden ORDER BY modelo");
            $stmt_pedidos->bindParam(':num_orden', $numero_de_orden, PDO::PARAM_STR);
            $stmt_pedidos->execute();
            
            $pedido = "";
            $total_pagar = 0;
            $ordenes_array = array();
            
            while($filas = $stmt_pedidos->fetch(PDO::FETCH_ASSOC)) {
                $pedido .= "-".$filas['modelo']." ".$filas['plazas']." ".$filas['tipotela']." ".$filas['color']." ".$filas['alturabase']."%0A";
                $total_pagar += $filas['precio'];
                $ordenes_array[] = $numero_de_orden;
            }
            
            $nombre = isset($cliente_result['nombre']) ? utf8_encode($cliente_result['nombre']) : '';
            $fecha_ruta = utf8_encode($fecha_ruta);
            
            // Construir el enlace de WhatsApp
            $mensaje_whatsapp = "<a href='https://api.whatsapp.com/send/?phone=+56{$row['telefono']}&text=Hola {$nombre}👋!%0A%0A Le informamos que su pedido%0A{$pedido}%0A%0A Será entregado este *{$fecha_ruta}*, por RespaldosChile%0ADireccion de Entrega: {$row['direccion']} {$row['numero']} %0ADpto/Casa : {$row['dpto']} %0AComuna: {$row['comuna']} %0ATotal a pagar: $ {$total_pagar} (Si esta pagado omitir esto) %0A%0A*Por favor ingresar en el siguiente link y confirmarnos que puede recibir*👉 %0Ahttps://respaldoschile.cl/cliente_confirma_numorden.php?pedido={$numero_de_orden}%0A%0ASi no le aparece el link debe agregar este numero a sus contactos.%0A*Importante: El producto debe estar pagado para que nuestro despachador se retire del domicilio.*%0A%0A*El horario de entrega se informara mediante un sms al momento de salir a reparto.*' class='btn btn-success' style='height:30px; line-height:15px; font-size:12px;'>Notificar Whatsapp</a>";
            
            // Agregar la fila a la tabla
            $output .= "<tr>
            <td>{$row['id']}</td>
            <td>{$row['rut_cliente']}</td>
            <td>{$modelo}</td>
            <td>{$row['plazas']} {$row['tipo_boton']}</td>
            <td>{$row['tipotela']}</td>
            <td>{$color}</td>
            <td>{$row['alturabase']}</td>
            <td>{$row['direccion']} {$row['numero']},{$row['dpto']} ,{$row['comuna']}</td>
            <td>{$row['telefono']}</td>
            <td>{$cliente_result['instagram']}</td>
            <td>{$estado}</td>
            <td><button class='btn btn-danger btn-sm borrar-btn' data-id='{$row['id']}'>Borrar de Ruta</button></td>
            <td>{$confirmacion}</td>
            <td>{$mensaje_whatsapp}</td>
            </tr>";
            
            $pedido = "";
            $total_pagar = 0;
        }
        
        $output .= "</tbody></table><br> Cantidad de Productos cargados en ruta: ".$contador;
        echo $output;
        
        ?>
        
        <br>
        <div class="container">
            <div class="row">
                <!-- Información de despacho -->
            </div>
        </div>
    </div>
    <input type="button" onclick="printDiv('impresion')" value="imprimir div" />
<?php
    } else {
        echo "<h5>Ningún registro fue encontrado</h5>";
    }
} catch (PDOException $e) {
    echo "<h5>Error en la consulta: " . $e->getMessage() . "</h5>";
}
?>

<script type="text/javascript">
 $(document).on("click",".borrar-btn",function(){ // ELIMINAR PEDIDO DE LA RUTA
    var id = $(this).data('id');
    var element = this;
    $.ajax({
        url: "deleteidruta.php",
        type: "POST",
        cache: false,
        data: {agregarId: id},
        success: function(data){
            if (data == 1) {
                $(element).closest("tr").fadeOut();
            } else {
                alert("Error al agregar a ruta");
            }
        }
    });
});
</script>

<script type="text/javascript">
function printDiv(nombreDiv) {
    var contenido = document.getElementById(nombreDiv).innerHTML;
    var contenidoOriginal = document.body.innerHTML;
    
    document.body.innerHTML = contenido;
    window.print();
    document.body.innerHTML = contenidoOriginal;
}
</script>