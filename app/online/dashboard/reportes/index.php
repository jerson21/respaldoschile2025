<?php
/************************************************************
* Formulario para generar reporte                           *
*                                                           *
* Fecha:    2021-02-09                                      *
* Autor:  Marko Robles                                      *
* Web:  www.codigosdeprogramacion.com                       *
************************************************************/

require "conexion.php";

$sql = "SELECT * FROM gan group by categoria";
$resultado = $mysqli->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte</title>
</head>

<body>

    <h2>Genera reporte de alumnos</h2>

    <form action="reporte.php" method="post" autocomplete="off">

        Ingresa el grado
        <select id="grado" name="grado">
            <option value="">Selecciona una opcion</option>
            <?php while ($fila = $resultado->fetch_assoc()) { ?>
                <option value="<?php echo $fila['categoria']; ?>"><?php echo $fila['categoria']; ?></option>
            <?php } ?>
        </select>

        <br />

        <button type="submit">Generar</button>

    </form>

</body>

</html>