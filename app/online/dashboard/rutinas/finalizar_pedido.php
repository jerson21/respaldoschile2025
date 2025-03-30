<?php require_once "../vistas/parte_superior.php"?>

<!--INICIO del cont principal-->
<div class="container" style=" max-width: 400rem; width: 200rem; ">
    <h1>Pedidos</h1>
    

    
 <?php
include_once 'bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$consulta = "SELECT * FROM pedido p 
INNER JOIN pedido_detalle d ON p.num_orden = d.num_orden
INNER JOIN clientes c ON p.rut_cliente = c.rut
WHERE d.estadopedido != '100' and d.ruta_asignada = 0 or d.ruta_asignada = ''  ORDER BY p.rut_cliente asc";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data=$resultado->fetchAll(PDO::FETCH_ASSOC);


$consulta2 = "SELECT * FROM pedido p 
INNER JOIN pedido_detalle d ON p.num_orden = d.num_orden 
INNER JOIN clientes c ON p.rut_cliente = c.rut
GROUP BY d.num_orden HAVING COUNT(d.num_orden) > 1 ORDER BY d.num_orden asc";

$resultado2 = $conexion->prepare($consulta2);
$resultado2->execute();
$data2 = $resultado2->fetchAll(PDO::FETCH_ASSOC);

foreach($data2 as $dat){
    
    $numeros_deorden[] = $dat['num_orden'];
}
?>

</div>     

<?php require_once "../vistas/parte_inferior.php"?>