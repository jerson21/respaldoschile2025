<?php require_once "init.php" ?>
<?php include "vistas/parte_superior.php"?>
<style type="text/css">
    ody {
    font-family: Arial;
    font-size: 17px;
    padding: 8px;
}

* {
    box-sizing: border-box;
}

h2 {
    font-size: 40px;
    background: linear-gradient(to left, #660066 0%, #ff3300 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.row {
    display: -ms-flexbox;
    /* IE10 */
    display: flex;
    -ms-flex-wrap: wrap;
    /* IE10 */
    flex-wrap: wrap;
    margin: 0 -16px;
}

.col-25 {
    -ms-flex: 25%;
    /* IE10 */
    flex: 25%;
}

.col-50 {
    -ms-flex: 50%;
    /* IE10 */
    flex: 50%;
}

.col-75 {
    -ms-flex: 75%;
    /* IE10 */
    flex: 75%;
}

.col-25,
.col-50,
.col-75 {
    padding: 0 16px;
}

.container {
    background-color: #f2f2f2;
    padding: 5px 20px 15px 20px;
    border: 1px solid lightgrey;
    border-radius: 3px;
}

input[type=text] {
    width: 100%;
    margin-bottom: 20px;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 3px;
}

label {
    margin-bottom: 10px;
    display: block;
}

.icon-container {
    margin-bottom: 20px;
    padding: 7px 0;
    font-size: 24px;
}



hr {
    border: 1px solid lightgrey;
}

span.price {
    float: right;
    color: grey;
}

/* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other (also change the direction - make the "cart" column go on top) */
@media (max-width: 800px) {
    .row {
        flex-direction: column-reverse;
    }

    .col-25 {
        margin-bottom: 20px;
    }
}
.texto{
    float: right;
    font-weight: bold;
    color: black;
}
</style>
<!--INICIO del cont principal-->

<h1>Confirmacion de cambio de producto</h1>
    
<?php
if(!isset($_SESSION)) 
{ 
    session_start();
}
$usuario_activo = $_SESSION['nombre_user'] = $_SESSION["s_usuario"];

// Incluir el archivo de conexión utilizando la clase Conexion
require_once 'bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();
?>

<div class="container">
    <div class="row">
        <div class="col-75">
        <?php
        // Obtener datos del POST con validación
        $num_orden = isset($_POST['num_orden']) ? $_POST['num_orden'] : '';
        $rut_cliente = isset($_POST['rut_cliente']) ? $_POST['rut_cliente'] : '';
        $cod_pedidoanterior = isset($_POST['cod_pedidoanterior']) ? $_POST['cod_pedidoanterior'] : 0;
        $modelo_nuevo = isset($_POST['modelo_nuevo']) ? $_POST['modelo_nuevo'] : '';
        $plazas_nuevo = isset($_POST['plazas_nuevo']) ? $_POST['plazas_nuevo'] : '';
        $tipotela_nuevo = isset($_POST['tipotela_nuevo']) ? $_POST['tipotela_nuevo'] : '';
        $color_nuevo = isset($_POST['color_nuevo']) ? $_POST['color_nuevo'] : '';
        $alturabase_nuevo = isset($_POST['alturabase_nuevo']) ? $_POST['alturabase_nuevo'] : '';  
        $direccion_nuevo = isset($_POST['direccion_nuevo']) ? $_POST['direccion_nuevo'] : '';
        $numero_nuevo = isset($_POST['numero_nuevo']) ? $_POST['numero_nuevo'] : '';  
        $dpto_nuevo = isset($_POST['dpto_nuevo']) ? $_POST['dpto_nuevo'] : '';  
        $telefono_nuevo = isset($_POST['telefono_nuevo']) ? $_POST['telefono_nuevo'] : '';     
        $region_nuevo = isset($_POST['region']) ? $_POST['region'] : '';
        $comuna_nuevo = isset($_POST['comuna_nuevo']) ? $_POST['comuna_nuevo'] : '';
        $comentarios_nuevo = isset($_POST['comentarios_nuevo']) ? $_POST['comentarios_nuevo'] : '';
        $precio_nuevo = isset($_POST['precio']) ? $_POST['precio'] : 0;
        $abono = isset($_POST['abono']) ? $_POST['abono'] : 0;
        $precio_porpagar = isset($_POST['por_pagar']) ? $_POST['por_pagar'] : 0;
        $total_porpagar = $precio_nuevo + $precio_porpagar;
        $mododepago_nuevo = isset($_POST['mododepago']) ? $_POST['mododepago'] : '';
        $metodo_entrega = isset($_POST['metodo_entrega']) ? $_POST['metodo_entrega'] : '';
        $detalle_entrega = isset($_POST['detalle_entrega']) ? $_POST['detalle_entrega'] : '';
        $atencion = isset($_POST['atencion']) ? $_POST['atencion'] : '';
        $boton_nuevo = isset($_POST['boton_nuevo']) ? $_POST['boton_nuevo'] : '';
        $anclaje_nuevo = isset($_POST['anclaje_nuevo']) ? $_POST['anclaje_nuevo'] : '';
        
        setlocale(LC_ALL, "es_ES");
        $fecha_ingreso = date("j/n/Y"); 
        $fecha_entrega = isset($_POST['fecha_entrega']) ? $_POST['fecha_entrega'] : '';
        $instagram = isset($_POST['instagram']) ? $_POST['instagram'] : '';
        $pagado = isset($_POST['pagado']) ? $_POST['pagado'] : 0;
        $correo = isset($_POST['email']) ? ucfirst($_POST['email']) : '';
        $detalles_fabricacion = isset($_POST['detalles_fabricacion']) ? ucfirst($_POST['detalles_fabricacion']) : '';

        // Validar si el formulario es para agregar patas
        if (isset($_POST['tipo_formulario']) && $_POST['tipo_formulario'] == "patas") {
            $cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : 1;
            $modelo = "Patas de cama";
            $tipotela = ucfirst(isset($_POST['modelo']) ? $_POST['modelo'] : '');
        } else {
            $cantidad = 1;
        }

        try {
            // Obtener el último número de orden
            $stmt_orden = $conexion->prepare("SELECT MAX(num_orden) AS num_orden FROM pedido");
            $stmt_orden->execute();
            $row_orden = $stmt_orden->fetch(PDO::FETCH_ASSOC);
            $ultimoregistroorden = trim($row_orden['num_orden']);
            $nuevoregistroorden = $ultimoregistroorden + 1;
            
            // Insertar el nuevo pedido
            $stmt_insert = $conexion->prepare("INSERT INTO pedido_detalle(
                num_orden, direccion, numero, dpto, region, comuna, modelo, tamano, alturabase, 
                tipotela, color, precio, abono, tipo_boton, anclaje, comentarios, detalles_fabricacion, 
                fecha_ingreso, pagado, formadepago, metodo_entrega, detalle_entrega, vendedor, 
                estadopedido, ruta_asignada, orden_ruta, confirma, tapicero_id, cod_ped_anterior, 
                atencion, cantidad) 
                VALUES (
                :num_orden, :direccion, :numero, :dpto, :region, :comuna, :modelo, :tamano, :alturabase,
                :tipotela, :color, :precio, :abono, :tipo_boton, :anclaje, :comentarios, :detalles_fabricacion,
                :fecha_ingreso, :pagado, '0', :metodo_entrega, :detalle_entrega, :vendedor,
                '1', '', '', '', '', :cod_ped_anterior, :atencion, :cantidad)");
            
            // Vincular los parámetros
            $stmt_insert->bindParam(':num_orden', $num_orden, PDO::PARAM_INT);
            $stmt_insert->bindParam(':direccion', $direccion_nuevo, PDO::PARAM_STR);
            $stmt_insert->bindParam(':numero', $numero_nuevo, PDO::PARAM_STR);
            $stmt_insert->bindParam(':dpto', $dpto_nuevo, PDO::PARAM_STR);
            $stmt_insert->bindParam(':region', $region_nuevo, PDO::PARAM_STR);
            $stmt_insert->bindParam(':comuna', $comuna_nuevo, PDO::PARAM_STR);
            $stmt_insert->bindParam(':modelo', $modelo_nuevo, PDO::PARAM_STR);
            $stmt_insert->bindParam(':tamano', $plazas_nuevo, PDO::PARAM_STR);
            $stmt_insert->bindParam(':alturabase', $alturabase_nuevo, PDO::PARAM_STR);
            $stmt_insert->bindParam(':tipotela', $tipotela_nuevo, PDO::PARAM_STR);
            $stmt_insert->bindParam(':color', $color_nuevo, PDO::PARAM_STR);
            $stmt_insert->bindParam(':precio', $total_porpagar, PDO::PARAM_INT);
            $stmt_insert->bindParam(':abono', $abono, PDO::PARAM_INT);
            $stmt_insert->bindParam(':tipo_boton', $boton_nuevo, PDO::PARAM_STR);
            $stmt_insert->bindParam(':anclaje', $anclaje_nuevo, PDO::PARAM_STR);
            $stmt_insert->bindParam(':comentarios', $comentarios_nuevo, PDO::PARAM_STR);
            $stmt_insert->bindParam(':detalles_fabricacion', $detalles_fabricacion, PDO::PARAM_STR);
            $stmt_insert->bindParam(':fecha_ingreso', $fecha_ingreso, PDO::PARAM_STR);
            $stmt_insert->bindParam(':pagado', $pagado, PDO::PARAM_STR);
            $stmt_insert->bindParam(':metodo_entrega', $metodo_entrega, PDO::PARAM_STR);
            $stmt_insert->bindParam(':detalle_entrega', $detalle_entrega, PDO::PARAM_STR);
            $stmt_insert->bindParam(':vendedor', $usuario_activo, PDO::PARAM_STR);
            $stmt_insert->bindParam(':cod_ped_anterior', $cod_pedidoanterior, PDO::PARAM_INT);
            $stmt_insert->bindParam(':atencion', $atencion, PDO::PARAM_STR);
            $stmt_insert->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
            
            // Ejecutar la inserción
            if ($stmt_insert->execute()) {
                $lastid = $conexion->lastInsertId();
                
                echo "<div style='margin:0 auto; text-align:center;'>
                    Pedido Cambiado con exito<br>
                    <b>Se han generado nuevos codigos</b><br>
                    Numero de Pedido: ".$lastid."<br>
                    Numero de Orden: ".$nuevoregistroorden."<br>
                    <img width='30%' src='img/okimg.png'><br>";
                
                // Registrar el cambio en pedido_etapas para el nuevo pedido
                $obs = "Cambio por codigo ".$cod_pedidoanterior;
                $stmt_etapa1 = $conexion->prepare("INSERT INTO pedido_etapas (idPedido, idProceso, fecha, usuario, observacion) 
                                               VALUES(:idPedido, '20', now(), :usuario, :observacion)");
                $stmt_etapa1->bindParam(':idPedido', $lastid, PDO::PARAM_INT);
                $stmt_etapa1->bindParam(':usuario', $usuario_activo, PDO::PARAM_STR);
                $stmt_etapa1->bindParam(':observacion', $obs, PDO::PARAM_STR);
                $stmt_etapa1->execute();
                
                // Registrar el cambio en pedido_etapas para el pedido anterior
                $obs = "Cambio por codigo ".$lastid;
                $stmt_etapa2 = $conexion->prepare("INSERT INTO pedido_etapas (idPedido, idProceso, fecha, usuario, observacion) 
                                               VALUES(:idPedido, '20', now(), :usuario, :observacion)");
                $stmt_etapa2->bindParam(':idPedido', $cod_pedidoanterior, PDO::PARAM_INT);
                $stmt_etapa2->bindParam(':usuario', $usuario_activo, PDO::PARAM_STR);
                $stmt_etapa2->bindParam(':observacion', $obs, PDO::PARAM_STR);
                $stmt_etapa2->execute();
                
                // Actualizar el estado del pedido anterior
                $stmt_update = $conexion->prepare("UPDATE pedido_detalle SET estadopedido = '20' WHERE id = :id");
                $stmt_update->bindParam(':id', $cod_pedidoanterior, PDO::PARAM_INT);
                
                if ($stmt_update->execute()) {
                    echo "Pedido Anterior eliminado";
                } else {
                    echo "Error eliminando el pedido anterior. Por favor informar al administrador.";
                }
                
                echo "</div>";
            } else {
                echo "<div class='alert alert-danger'>Error al insertar el nuevo pedido.</div>";
            }
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger'>Error en la base de datos: " . $e->getMessage() . "</div>";
        }
        ?>
        </div>
    </div>
</div>

<!--FIN del cont principal-->
<?php require_once "vistas/parte_inferior.php"?>