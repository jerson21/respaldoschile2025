<?php require_once "init.php" ?>
<?php

include_once 'bd/conexion.php';
$ruta = $_POST['id'];
$objeto1 = new Conexion();
$conexion = $objeto1->Conectar();

$consulta = "SELECT * FROM pedidos where ruta_asignada = $ruta ORDER BY id and rut_cliente";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data=$resultado->fetchAll(PDO::FETCH_ASSOC);
$data2 = array();




 
    

                            
 foreach($data as $dat) {                                                        
                            
      $nestedData=array();                       

$numerodeorden = $dat['num_orden'];                                
                                $nestedData[] = $dat['id'];
                               $nestedData[] = $dat['rut_cliente'];                 
                                                               
                               $nestedData[] = $dat['modelo'];
                                $nestedData[] = $dat['plazas']; 
                                 $nestedData[] = $dat['alturabase']; 
                                 $nestedData[] = $dat['tipotela']; 
                                 $nestedData[] = $dat['color'];
                               $nestedData[] = $dat['direccion']; 
                             $nestedData[] = $dat['numero'];
                                $nestedData[] = $dat['comuna']; 
                                  $nestedData[] = $dat['telefono']; 
                                 $nestedData[] =  $dat['estadopedido']; 
                                 $nestedData[] =  $dat['comentarios'];
                                
                                 

$data2[] = $nestedData;
}


 $json_data = array(
            "data"            => $data2   // total data array
            );
 
echo json_encode($json_data);

// HACER UN FORECH PARA RECORRER TODA LA FILA Y AGREGARLO AL ARRAY DATA2 PAR QUE SE MUESTRE EN ASIGNAR_RUTA.PHP Y QUE SE GENERER CON EL NESTEDDATA

                            ?>