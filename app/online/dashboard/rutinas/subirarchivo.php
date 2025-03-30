<?php   
$dir_subida = '../leerpagos/';
    $fichero_subido = $dir_subida . "libro1.xls";
    move_uploaded_file($_FILES['fichero_usuario']['tmp_name'], $fichero_subido);
    header("Location: ../validarpagos.php");
?>