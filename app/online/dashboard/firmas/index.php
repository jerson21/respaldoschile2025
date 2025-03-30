<?php
/************************************************************
* Formulario para generar reporte                           *
*                                                           *
* Fecha:    2021-02-09                                      *
* Autor:  Marko Robles                                      *
* Web:  www.codigosdeprogramacion.com                       *
************************************************************/

require "conexion.php";

$sql = "SELECT * FROM rutas";
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

    <h2>Imprimir Hoja de Firmas para ruta</h2>

    <form action="reporte.php" method="post" autocomplete="off">

        Ingresa Ruta
        <select id="id" name="id">
            <option value="">Selecciona una opcion</option>
            <?php while ($fila = $resultado->fetch_assoc()) { ?>
                <option value="<?php echo $fila['id']; ?>"><?php echo $fila['fecha']; ?></option>
            <?php } ?>
        </select>

        <br />

        <button type="submit">Generar</button>

    </form>

</body>

</html>