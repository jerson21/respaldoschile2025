<?php 
 require "conexion.php";

if (!$conn) {
    echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
    echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
    echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

$tela=$_POST['colores'];

	 $sql="SELECT id,
			 color			 
		from colores 
		where $tela='1' ORDER BY color ASC";

	$result=mysqli_query($conn,$sql);


	$cadena="<label for='listatelas' class='form-label fw-bold'>Colores disponibles en ".strtoupper($tela)."</label>
			<select class='form-select form-select-sm' id='lista2' name='lista2'  >";

	while ($ver=mysqli_fetch_row($result)) {
		$cadena=$cadena.'<option value="'.$ver[1].'">'.utf8_encode($ver[1]).'</option>';
	}

	
	echo  $cadena."</select>";
	

			

?>



