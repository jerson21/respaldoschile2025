<?php

include("conexion.php");
$id = $_POST['id'];

$strsql = "SELECT * FROM pedidos where estadopedido <3 order by color";
    $rs = mysqli_query($conn, $strsql);
    $total_rows = $rs->num_rows;
    $data = array();
   $contador="1";
while( $row=mysqli_fetch_array($rs) ) {
$nestedData=array();

    $nestedData[] = $row["orden_ruta"];
    $nestedData[] = $row["num_orden"];
    $nestedData[] = $row["id"];
    $nestedData[] = $row["rut_cliente"];
    $nestedData[] = $row["modelo"];
    $nestedData[] = $row["plazas"];
    $nestedData[] = $row["tipotela"];
    $nestedData[] = $row["color"];
    $nestedData[] = $row["alturabase"];
    if($row['dpto']!="Dpto"){

    }
    else
    {}
    $nestedData[] = $row["direccion"]." ".$row['numero']." ";
    $nestedData[] = $row["comuna"];
    $nestedData[] = $row["telefono"];
    $rut_cliente = $row['rut_cliente'];

    $strsqls = "SELECT * FROM clientes WHERE rut = '$rut_cliente'";
    $rss = mysqli_query($conn, $strsqls);    
    
while( $row1=mysqli_fetch_array($rss) ) {
$instagram = $row1['instagram'];
}

    $nestedData[] = $instagram;
    $nestedData[] =  $row["mododepago"];
    $nestedData[] =  $row["precio"];
    $nestedData[] = "";
    $nestedData[] = "";


$data[] = $nestedData;
}
    
        
        //print_r($data);
        
    $json_data = array(
            "data"            => $data   // total data array
            );
 
echo json_encode($json_data);





?>