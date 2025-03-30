<?php

include('conexion.php');
 $id = $_POST['id'];

$strsql = "SELECT * FROM pedido_detalle where ruta_asignada = $id ORDER BY orden_ruta ASC";
    $rs = mysqli_query($conn, $strsql) or die("Error: ".mysqli_error($conn)) ;
    $total_rows = $rs->num_rows;
    $data = array();
   $contador = 0;
while( $row=mysqli_fetch_row($rs) ) {
 $idpedido = $row[0];
 $contador = $contador+1;
   $query = "UPDATE pedido_detalle SET orden_ruta='$contador' WHERE id = $idpedido";
$conn->query($query) or die("Error: ".mysqli_error($conn));

echo "1";
}
    
        
        //print_r($data);
        
    






?>