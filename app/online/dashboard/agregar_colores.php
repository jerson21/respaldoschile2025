<?php require_once "vistas/parte_superior.php"?>

<!--INICIO del cont principal-->
<div class="container">
    <h1>Agregar Imagenes de Telas - Respaldos Chile</h1>
</div>

<div style="padding: 15px; margin:0 auto; text-align: center">
	<div style="width: 50%; margin:0 auto; text-align: center;">
<form action="colores.php" method="GET">
	<select class="form-control" name="tipo_tela">
		<option value="lino">Lino</option>
		<option value="felpa">Felpa</option>
		<option value="mosaico">Felpa Mosaico</option>
		<option value="ecocuero">Eco Cuero</option>
	</select>
	<br><br>
	<input type="submit" value="Agregar">
</form>

	</div>
</div>
<!--FIN del cont principal-->

<?php require_once "vistas/parte_inferior.php"?>