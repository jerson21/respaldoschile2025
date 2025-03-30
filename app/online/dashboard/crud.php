<?php
include_once '../bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();
// Recepción de los datos enviados mediante POST desde el JS   

$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
$pais = (isset($_POST['pais'])) ? $_POST['pais'] : '';
$edad = (isset($_POST['edad'])) ? $_POST['edad'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$estado = (isset($_POST['estado'])) ? $_POST['estado'] : '';
$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$ide = (isset($_POST['ide'])) ? $_POST['ide'] : '';
$modelo = (isset($_POST['modelo'])) ? $_POST['modelo'] : '';
$color = (isset($_POST['color'])) ? $_POST['color'] : '';
$tela = (isset($_POST['tela'])) ? $_POST['tela'] : '';
$plazas = (isset($_POST['plazas'])) ? $_POST['plazas'] : '';
$alturabase = (isset($_POST['alturabase'])) ? $_POST['alturabase'] : '';
$rut = (isset($_POST['rut'])) ? $_POST['rut'] : '';
$direccion = (isset($_POST['direccion'])) ? $_POST['direccion'] : '';
$num = (isset($_POST['numero'])) ? $_POST['numero'] : '';
$comuna = (isset($_POST['comuna'])) ? $_POST['comuna'] : '';
$telefono = (isset($_POST['telefono'])) ? $_POST['telefono'] : '';
$pago = (isset($_POST['pago'])) ? $_POST['pago'] : '';
$orden = (isset($_POST['orden'])) ? $_POST['orden'] : '';
$rut_tapicero = (isset($_POST['rut_tapicero'])) ? $_POST['rut_tapicero'] : '';


switch($opcion){
    case 1: //alta
        $consulta = "INSERT INTO personas (nombre, pais, edad) VALUES('$nombre', '$pais', '$edad') ";			
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        $consulta = "SELECT id, nombre, pais, edad FROM personas ORDER BY id DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2: //modificación
        $consulta = "UPDATE personas SET nombre='$nombre', pais='$pais', edad='$edad' WHERE id='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        
        $consulta = "SELECT id, nombre, pais, edad FROM personas WHERE id='$id' ";       
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;        
    case 3://baja
    $consultar = "INSERT INTO eliminados (id_pedido, rut_cliente,modelo,plazas,tipotela,color,alturabase,direccion,numero,dpto,telefono,comuna,precio)
    SELECT id, rut_cliente,modelo,plazas,tipotela,color,alturabase,direccion,numero,dpto,telefono,comuna,precio FROM pedidos WHERE id='$id'";  


        $resultador = $conexion->prepare($consultar);
        $resultador->execute();

        $consulta = "DELETE FROM pedidos WHERE id='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();                           
        break; 
    case 4: //modificación de estado
    
        $consulta = "UPDATE pedidos SET estadopedido={$estado} WHERE id='$id' ";     
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        $consultar = "SELECT num_orden FROM pedidos WHERE id='$id' ";
        $resultado2 = $conexion->prepare($consultar);
        $resultado2->execute();

        $data = $resultado2->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($data as $dat) { 
                $orden = $dat['num_orden'];
                
        }
        $consultar2 = "UPDATE orden SET estado={$estado} WHERE num_orden='$orden' ";     
        $resultado2 = $conexion->prepare($consultar2);
        $resultado2->execute();


             
        
        $consulta = "SELECT * FROM pedidos WHERE id='$id' ";       
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;    

    case 5: //modificación de datos de pedido
    
        $consulta = "UPDATE pedidos SET rut_cliente='$rut',telefono='$telefono',modelo='$modelo',tipotela='$tela', color='$color', plazas='$plazas',alturabase='$alturabase', direccion='$direccion', numero='$num',comuna='$comuna' WHERE id='$ide' ";     
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        
        $consulta = "SELECT * FROM pedidos WHERE id='$ide' ";       
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;     

        case 6: //modificación de pago
    
        $consulta = "UPDATE pedidos SET estadopedido={$pago} WHERE id='$id' ";     
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        $consultar = "SELECT num_orden FROM pedidos WHERE id='$id' ";
        $resultado2 = $conexion->prepare($consultar);
        $resultado2->execute();

        $data = $resultado2->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($data as $dat) { 
                $orden = $dat['num_orden'];
                
        }
        $consultar2 = "UPDATE orden SET estado={$estado} WHERE num_orden='$orden' ";     
        $resultado2 = $conexion->prepare($consultar2);
        $resultado2->execute();


             
        
        $consulta = "SELECT * FROM pedidos WHERE id='$id' ";       
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;   

        case 15: //asignar rut de tapicero a trabajo
    
        $consulta = "UPDATE pedidos SET tapicero_rut={$rut_tapicero} WHERE id='$id' ";     
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 
        break;      
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
