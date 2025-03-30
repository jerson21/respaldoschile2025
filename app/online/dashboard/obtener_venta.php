<?php require_once "vistas/parte_superior.php";
error_reporting(E_ALL);
include_once 'bd/conexion.php';
$objeto2 = new Conexion();
$conexion = $objeto2->Conectar();
$id = $_GET['id'];

$consultar = "SELECT * FROM pedidos WHERE id='$id' ";
        $resultado2 = $conexion->prepare($consultar);
        $resultado2->execute();

        $data = $resultado2->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($data as $dat) { 
                $codigo = $dat['id'];
                $rut_cliente = $dat['rut_cliente'];
                 $fecha_ingreso = $dat['fecha_ingreso'];
                  }


        ?>

<?php
$objeto = new ConEcom();
$conec = $objeto->Conectar2();

$consultar2 = "SELECT ped.*,per.identificacion,per.nombres,per.apellidos,per.telefono,per.email_user FROM pedido ped INNER JOIN persona per ON per.idpersona = ped.personaid";
$resultadoas = $conec->prepare($consultar2);
$resultadoas->execute();

$data2 = $resultadoas->fetchAll(PDO::FETCH_ASSOC);

foreach ($data2 as $dat) { 
    $codigo = $dat['idpedido'];
    $rut_cliente = $dat['identificacion'];
    $fecha_ingreso = $dat['fecha'];
    
    $direccion_envio = $dat['direccion_envio'];
   if($direccion_envio == "Retiro en local") {
    $metodo_entrega = "Retiro en tienda";
   }else{
    $metodo_entrega = "Despacho";
   }
   $costo_envio = $dat['costo_envio'];

   if($dat['status'] == "Aprobado"){
    $total_pagado =  $dat['monto'];
    }else{
        $total_pagado = 0;
    }

/* OBTENER ULTIMO NUM_ORDEN PARA AGREGAR AL PEDIDO */
$consulta_ultimo_registro = "SELECT MAX(num_orden) AS num_orden FROM pedido";
    $stmt_ultimo_registro = $conexion->prepare($consulta_ultimo_registro);
    $stmt_ultimo_registro->execute();

    $resultado_ultimo_registro = $stmt_ultimo_registro->fetch(PDO::FETCH_ASSOC);

    $ultimoregistroorden = $resultado_ultimo_registro['num_orden'];
echo $nuevoregistroorden = $ultimoregistroorden + 1;


$vendedor = "PAGINA WEB";
$estado = "0";

    /* INSERTAR INFO EN LA BD DE DATOS INTRANET */
     $consulta_insertar_pedido = "INSERT INTO pedido (num_orden,rut_cliente, fecha_ingreso, despacho, total_pagado, vendedor, metodo_entrega,estado, orden_ext) VALUES (:num_orden,:rut, :fecha_ingreso, :despacho, :total_pagado, :vendedor, :metodo_entrega,:estado,:orden_ext)";

$stmt_insertar_pedido = $conexion->prepare($consulta_insertar_pedido);
$stmt_insertar_pedido->bindParam(':num_orden', $nuevoregistroorden, PDO::PARAM_STR);
$stmt_insertar_pedido->bindParam(':rut', $rut_cliente, PDO::PARAM_STR);
$stmt_insertar_pedido->bindParam(':fecha_ingreso', $fecha_ingreso, PDO::PARAM_STR);
$stmt_insertar_pedido->bindParam(':despacho', $costo_envio, PDO::PARAM_STR);
$stmt_insertar_pedido->bindParam(':total_pagado', $total_pagado, PDO::PARAM_STR);
$stmt_insertar_pedido->bindParam(':vendedor', $vendedor, PDO::PARAM_STR);
$stmt_insertar_pedido->bindParam(':metodo_entrega', $metodo_entrega, PDO::PARAM_STR);
$stmt_insertar_pedido->bindParam(':estado', $estado, PDO::PARAM_INT);
$stmt_insertar_pedido->bindParam(':orden_ext', $codigo, PDO::PARAM_STR);

// Var_dump de los parámetros
/*var_dump([
    ':num_orden' => $nuevoregistroorden,
    ':rut' => $rut_cliente,
    ':fecha_ingreso' => $fecha_ingreso,
    ':despacho' => $costo_envio,
    ':vendedor' => $vendedor,
    ':metodo_entrega' => $metodo_entrega,
    ':orden_ext' => $codigo,
]); */

if (!$stmt_insertar_pedido->execute()) {
    echo "Falló el ingreso de datos en pedido: (" . $stmt_insertar_pedido->errorInfo()[2] . ")";
} 
   // $stmt_insert_pedidos->execute();




    // Realizar la consulta a la tabla detalle_pedido para cada pedido
    $consulta_detalle = "SELECT dp.*,p.*,ped.*, dp.precio as precio_a FROM pedido ped INNER JOIN detalle_pedido dp ON ped.idpedido = dp.PEDIDOID LEFT JOIN producto p ON dp.productoid = p.idproducto WHERE pedidoid = :id_pedido";
    $stmt_detalle = $conec->prepare($consulta_detalle);
    $stmt_detalle->bindParam(':id_pedido', $codigo, PDO::PARAM_INT);
    $stmt_detalle->execute();

    $data_detalle = $stmt_detalle->fetchAll(PDO::FETCH_ASSOC);
    var_dump($data_detalle);


    // Ahora $data_detalle contiene la información de detalle_pedido para el pedido actual
    // Puedes procesar y mostrar esta información según tus necesidades




    foreach ($data_detalle as $detalle) {


        $nuevoregistroorden = $nuevoregistroorden; 
         $direccion = $detalle['direccion_envio'];

// Descomponer la dirección por comas
$elementos = explode(", ", $direccion);

// Imprimir cada elemento por separado
foreach ($elementos as $elemento) {
  $direccion = $elementos[0];
$numero = $elementos[1];
$dpto = $elementos[2];
$region = $elementos[3];
$comuna = $elementos[4];
}

        $direccion = $direccion;
        $numero = $numero; 
        $dpto = $dpto;
        $region = $region; 
        $comuna = $comuna;
        $modelo = $detalle['nombre'];; //  **
        $plazas = $detalle['tamano']; // **
        $alturabase = $detalle['altura_base'];; // 
        $tipotela = $detalle['tipo_tela']; // 
        $color = $detalle['color']; 
        
        $precio = number_format($detalle['precio_a'], 0, '.', '');

        
        $abono = "0"; 
        $cantidad = $detalle['cantidad']; 
        $botones = ""; 
        $anclaje = "no"; 
        $comentarios = ""; 
        $detalles_fabricacion = ""; 
        $fecha_ingreso = $detalle['fecha']; 
        // si status es APROBADO ES PORQUE ESTA PAGADO
        if ($detalle['status'] == "Aprobado") {
            $pagado = "1";
            $abono = $precio;
        } else {
            $pagado = "0";
        }
      

        if ($detalle['tipopagoid'] == 1) {
            $mododepago = 'WebPay';
        } elseif ($mododepago == 2) {
            $mododepago = 'efectivo';
        } elseif ($mododepago == 3) {
            $mododepago = 'credito';
        } elseif ($mododepago == 5) {
            $mododepago = 'transferencia';
        }     

        // Verificar si el método de entrega es "Retiro en local"
        if ($detalle['metodo_entrega'] == "Retiro en local") {
            $metodo_entrega = "Retiro en local";
        } else {
            $metodo_entrega = "Despacho";
        }

        $detalle_entrega = "";
        $referencia = $detalle['referencia']; 
        $vendedor = 'PAGINAWEB';

        $consulta_insertar_pedido_detalle = "INSERT INTO pedido_detalle (num_orden, direccion, numero, dpto, region, comuna, modelo, tamano, alturabase, tipotela, color, precio, abono, cantidad, tipo_boton, anclaje, comentarios, detalles_fabricacion, fecha_ingreso, pagado, mododepago, metodo_entrega, detalle_entrega, vendedor, estadopedido, ruta_asignada, orden_ruta, confirma, tapicero_id) VALUES (:num_orden, :direccion, :numero, :dpto, :region, :comuna, :modelo, :tamano, :alturabase, :tipotela, :color, :precio, :abono, :cantidad, :tipo_boton, :anclaje, :comentarios, :detalles_fabricacion, :fecha_ingreso, :pagado, :mododepago, :metodo_entrega, :detalle_entrega, :vendedor, '0', '', '', '', '')";

        $stmt_insertar_pedido_detalle = $conexion->prepare($consulta_insertar_pedido_detalle);

        // Vincula los valores a los parámetros
        $stmt_insertar_pedido_detalle->bindParam(':num_orden', $nuevoregistroorden, PDO::PARAM_STR);
        $stmt_insertar_pedido_detalle->bindParam(':direccion', $direccion, PDO::PARAM_STR);
        $stmt_insertar_pedido_detalle->bindParam(':numero', $numero, PDO::PARAM_STR);
        $stmt_insertar_pedido_detalle->bindParam(':dpto', $dpto, PDO::PARAM_STR);
        $stmt_insertar_pedido_detalle->bindParam(':region', $region, PDO::PARAM_STR);
        $stmt_insertar_pedido_detalle->bindParam(':comuna', $comuna, PDO::PARAM_STR);
        $stmt_insertar_pedido_detalle->bindParam(':modelo', $modelo, PDO::PARAM_STR);
        $stmt_insertar_pedido_detalle->bindParam(':tamano', $plazas, PDO::PARAM_STR);
        $stmt_insertar_pedido_detalle->bindParam(':alturabase', $alturabase, PDO::PARAM_STR);
        $stmt_insertar_pedido_detalle->bindParam(':tipotela', $tipotela, PDO::PARAM_STR);
        $stmt_insertar_pedido_detalle->bindParam(':color', $color, PDO::PARAM_STR);
        $stmt_insertar_pedido_detalle->bindParam(':precio', $precio, PDO::PARAM_STR);
        $stmt_insertar_pedido_detalle->bindParam(':abono', $abono, PDO::PARAM_STR);
        $stmt_insertar_pedido_detalle->bindParam(':cantidad', $cantidad, PDO::PARAM_STR);
        $stmt_insertar_pedido_detalle->bindParam(':tipo_boton', $botones, PDO::PARAM_STR);
        $stmt_insertar_pedido_detalle->bindParam(':anclaje', $anclaje, PDO::PARAM_STR);
        $stmt_insertar_pedido_detalle->bindParam(':comentarios', $comentarios, PDO::PARAM_STR);
        $stmt_insertar_pedido_detalle->bindParam(':detalles_fabricacion', $detalles_fabricacion, PDO::PARAM_STR);
        $stmt_insertar_pedido_detalle->bindParam(':fecha_ingreso', $fecha_ingreso, PDO::PARAM_STR);
        $stmt_insertar_pedido_detalle->bindParam(':pagado', $pagado, PDO::PARAM_STR);
        $stmt_insertar_pedido_detalle->bindParam(':mododepago', $mododepago, PDO::PARAM_STR);
        $stmt_insertar_pedido_detalle->bindParam(':metodo_entrega', $metodo_entrega, PDO::PARAM_STR);
        $stmt_insertar_pedido_detalle->bindParam(':detalle_entrega', $detalle_entrega, PDO::PARAM_STR);
        $stmt_insertar_pedido_detalle->bindParam(':vendedor', $vendedor, PDO::PARAM_STR);

        // Ejecutar la consulta
        if ($stmt_insertar_pedido_detalle->execute()) {
            echo "Inserción exitosa en pedido_detalle";
        } else {
            echo "Falló el ingreso de datos en pedido_detalle: (" . $stmt_insertar_pedido_detalle->errorInfo()[2] . ")";
        }


        // Acceder a los campos de la tabla detalle_pedido
        $producto_id = $detalle['producto_id'];
        $cantidad = $detalle['cantidad'];
        // ... (otros campos)
    }
       
    // Ahora puedes imprimir la información del pedido y su detalle
    echo "Pedido ID:<b> $codigo</b> <br>";
       echo "Fecha: {$fecha_ingreso}<br>";
    foreach ($data_detalle as $detalle) {
      echo "         <br>";
     
        echo "           Modelo: {$detalle['nombre']}<br>";
        echo "           Tamaño: {$detalle['tamano']}<br>";
        echo "           Tela: {$detalle['tipo_tela']}<br>";
        echo "           Color: {$detalle['color']}<br>";
        echo "           Base: {$detalle['altura_base']}<br>";
        echo "           Cantidad: {$detalle['cantidad']}<br>";
        echo "           Precio: {$detalle['precio_a']}<br>";
        echo "         __________________<br>";

        
        
   
    
    }

     echo "           Status: {$dat['status']}<br>";
          echo "           Costo envio: {$dat['costo_envio']}<br>";
            echo "           Descuento: {$dat['descuento']}<br>";
             echo "           Tipo pago : {$dat['tipopagoid']}<br>";
              echo "           Rut Cliente : {$dat['identificacion']}<br>";
                echo "           Nombre: {$dat['nombres']} {$dat['apellidos']}<br>";
              echo "           Telefono : {$dat['telefono']}<br>";
              echo "           Email : {$dat['email_user']}<br>";
           
              echo "           Direccion : {$dat['direccion_envio']}<br>";
               echo "           Referencia: {$dat['referencia']}<br><br>";

                       echo "         _________________________________________________________<br>";

}
?>

    
</div>
<!--FIN del cont principal-->
<?php require_once "vistas/parte_inferior.php"?>