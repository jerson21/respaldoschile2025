<?php 
include("conexion.php");
require 'phpqrcode/qrlib.php';
		$id_ruta = $_POST['id'];

// SELECT APRA CONSULTAR LOS PEDIDOS QUE AUN NO SON MARCADOS COMO TERMINADOS.
$strsqlss = "SELECT * FROM pedido_detalle WHERE ruta_asignada = $id_ruta and (estadopedido < 6)  ORDER by orden_ruta desc";
    $rsss = mysqli_query($conn, $strsqlss);
   $row_cnts = $rsss->num_rows;
    



if($row_cnts >= 1){

    echo "<i class='fas fa-exclamation-circle'></i> Faltan respaldos por terminar<br>";

while($arow=mysqli_fetch_array($rsss) ) {
    $respaldo = "";
    if ($arow['tamano'] == "2") {
        $respaldo .= " ";  // Icono de cama para 2 plazas
        $tamanoTexto = "2 plazas";
    } elseif ($arow['tamano'] == "1") {
        $tamanoTexto = "1 plaza";
    } else {
        $tamanoTexto = $arow['tamano'] . " plazas";  // Para otros casos, asumimos que se indica el número de plazas
    }
    
    $respaldo .= "-<b>" . $arow['id'] . " " . $arow['modelo'] . " " . $tamanoTexto . " " . ucfirst($arow['tipotela']) . " " . $arow['color'] . "</b><br>";
    
    echo $respaldo;
    
}

}

else{

    $strsqls = "SELECT pedido_detalle.*, pe6.fecha AS fecha_etapa_6
    FROM pedido_detalle 
    INNER JOIN pedido_etapas ON pedido_detalle.id = pedido_etapas.idPedido
    LEFT JOIN pedido_etapas AS pe6 ON pedido_detalle.id = pe6.idPedido AND pe6.idProceso = 6
    WHERE ruta_asignada = $id_ruta AND estadopedido <= 6
    ORDER BY orden_ruta DESC 
    LIMIT 1";
    $rss = mysqli_query($conn, $strsqls);
   $row_cnt = $rss->num_rows;
    
while($arow=mysqli_fetch_array($rss) ) {

    echo "<b>" . $arow['id'] . "</b><br> Modelo: <b>" . $arow['modelo'];

// Condición para mostrar "Anclaje" si es necesario
if ($arow['anclaje'] == "si") {
    echo " Anclaje";
}

// Condición para modificar la visualización de 'tipo_boton'
if ($arow['tipo_boton'] == "B D") {
    echo " Botón Diamante";
} else {
    echo " " . $arow['tipo_boton'];
}

echo "</b><br> Plazas: ";
    if ($arow['tamano'] == "2") {
       
    }
    echo "<b>" . $arow['tamano'] . " plazas</b><br> Tela: <b>" . ucfirst($arow['tipotela']) . "</b><br> Color: <b>" . $arow['color'] . "</b><br> Altura Base: <b>" . $arow['alturabase'] . "</b><br> Comentarios: <b>" . $arow['detalles_fabricacion'] . "</b><br> Fecha Fabricación: <b>" . $arow['fecha_etapa_6'] . "</b><br><span style='font-size:25px;'>" . $arow['orden_ruta']. "</span>";
    $codigo = $arow['id'];

?>

<script type="text/javascript">


	$(document).ready(function(){
 

  generarqr();
});


	 function generarqr(){
        $.ajax({
            url:'generate_code.php',
            type:'POST',
            data: {formData:<?php echo $codigo; ?>, ecc:"M", size:"5"},
            success: function(response) {
                $(".showQRCode").html(response);  
            },
         });
    }

</script>


<?php
}
if($row_cnt == 0){
	echo "Todos los productos cargados<br><img src='ok.png' width='300px;'>";
}


}








		?>