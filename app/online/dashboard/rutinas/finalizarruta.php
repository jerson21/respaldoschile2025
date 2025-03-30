<?php

include('conexion.php');
 $id = $_POST['id'];

//INICIAR RUTA PARA INDICAR QUE ESTA EN RUTA AL DOMICILIO.
$query = "UPDATE rutas SET estado='200' WHERE id = $id";
$conn->query($query) or die("Error: ".mysqli_error($conn));



    
        
        //print_r($data);
        
    






?>