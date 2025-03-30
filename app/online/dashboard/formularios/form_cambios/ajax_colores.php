<?php 

	require "conexion.php";
	
$color=$_POST['color'];




	$sql="SELECT color		 
		from colores 
		where $color = 1 ORDER BY color ASC";

	$result=mysqli_query($conn,$sql);


	$link = "https://catextil.cl/c/54-category_default/lino-.jpg";
	
	while ($ver=mysqli_fetch_row($result)) {
		//echo "Div de telas ".$ver[0];
		$link2 = "img/".$color."-".strtolower($ver[0]).".jpg";
		echo "<div id='imagenes' style='width:5.5rem; float:left; margin-left:0.2rem; margin-bottom:0.2rem; text-align:center; font-size:x-small'><div style=' border-radius: 50%; height:4rem; width:4rem; '>
		<img width='100%' height='100%' style='border-radius: 50%; '  src='".$link2."' alt='".$ver[0]."' title='".strtoupper($color).' '.$ver[0]."'></div>".$ver[0]." </div>";
		
	}



?>