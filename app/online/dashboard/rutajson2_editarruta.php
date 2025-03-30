<?php

include("conexion.php");
$id = $_POST['id'];
$opcion = $_POST['opcion'];

$strsql = "SELECT  *,pd.id as id_pedido FROM pedido p INNER JOIN pedido_detalle pd ON p.num_orden = pd.num_orden INNER JOIN clientes c ON p.rut_cliente = c.rut INNER JOIN rutas r ON pd.ruta_asignada = r.id WHERE pd.ruta_asignada = $id order by pd.comuna";
    $rs = mysqli_query($conn, $strsql);
    $total_rows = $rs->num_rows;
    $data = array();
   $contador="1";
while( $row=mysqli_fetch_array($rs) ) {
$nestedData=array();

    $nestedData[] = $row["orden_ruta"];
    $nestedData[] = $row["num_orden"];
    $nestedData[] = $row["id_pedido"];
    $rut_cliente = $row["rut_cliente"];
$strsqle = "SELECT * FROM clientes WHERE rut ='$rut_cliente'";
    $rse = mysqli_query($conn, $strsqle);
    $rowe=mysqli_fetch_array($rse);


    $nestedData[] = $row["rut_cliente"]." ".$rowe['nombre'];
    $nestedData[] = $row["modelo"];
    $nestedData[] = $row["tamano"];
    
    
  
    if($row['dpto']!="Dpto"){

    }
    else
    {}
    
    if($opcion == "editar_orden"){


  
    $nestedData[] = ucfirst($row["tipotela"]." ".$row["color"]. " ".$row["alturabase"]);
        
  $nestedData[] = $row["direccion"]." ".$row['numero']." / ".$row['dpto']. " ".$row["comuna"];


    }else{
        $nestedData[] = $row["direccion"]." ".$row['numero']." / ".$row['dpto'];
        $nestedData[] = $row["color"];
         $nestedData[] = $row["alturabase"];
    }
     
    
    $nestedData[] = $row["telefono"];
    $rut_cliente = $row['rut_cliente'];

    $strsqls = "SELECT * FROM clientes WHERE rut = '$rut_cliente'";
    $rss = mysqli_query($conn, $strsqls);    
    
while( $row1=mysqli_fetch_array($rss) ) {
$instagram = $row1['instagram'];
}
    $patas = "";
    $nestedData[] = $instagram;

    if($opcion == "editar_orden" )
    {
         if($row['formadepago'] == 'transferencia' or $row['mododepago'] == 'transferencia'){
        $nestedData[] =  "T"." ".$row["precio"];
    }
     if($row['formadepago'] == 'efectivo' or $row['mododepago'] == 'efectivo'){
        $nestedData[] =  "E"." ".$row["precio"];
    }
    if($row['formadepago'] == 'pagado' or $row['mododepago'] == 'pagado'){
        $nestedData[] =  "P"." ".$row["precio"];
    }
     if($row['formadepago'] == 'credito' or $row['mododepago'] == 'credito'){
        $nestedData[] =  "C"." ".$row["precio"];
    }
     if($row['formadepago'] == 'debito' or $row['mododepago'] == 'debito'){
        $nestedData[] =  "D"." ".$row["precio"];
    }


       
    }
     else{
       if($row['formadepago'] == 'transferencia'){
        $nestedData[] =  "T";
    }
     if($row['formadepago'] == 'efectivo'){
        $nestedData[] =  "F";
    }
    if($row['formadepago'] == 'pagado'){
        $nestedData[] =  "P";
    }
     if($row['formadepago'] == 'credito'){
        $nestedData[] =  "C";
    }

        }

   
    
    




    $boton = '';
    $anclajeMetal = '';
    if($row['tipo_boton'] == 'B D'){
        $boton = "Boton Diamante";
    }if($row['tipo_boton'] == 'B Color'){
        $boton = "Boton de Colores";
    }
    if($row['anclaje'] == 'patas'){
        $patas = "Patas Madera";
    }
    if($row['anclaje'] == 'si'){
        $patas = "Madera de Anclaje";
    }
    if($row['anclajeMetal'] == 'si'){
        $anclajeMetal = "Anclajes Metal";
    }

     if($opcion == "editar_orden" )
    {
        $nestedData[] = "___"; 
       
         $nestedData[] = $row["detalles_fabricacion"]." ".$boton." ".$patas." ".$anclajeMetal;
    $nestedData[] = "";
    }else{
         $nestedData[] = ""; 
        $nestedData[] = $row["detalles_fabricacion"]." ".$boton." ".$patas." ".$anclajeMetal;
   
    }

   


$data[] = $nestedData;
}
    
        
        //print_r($data);
        
    $json_data = array(
            "data"            => $data   // total data array
            );
 
echo json_encode($json_data);





?>