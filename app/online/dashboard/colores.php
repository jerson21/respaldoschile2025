<?php require_once "init.php" ?> 
<?php 
require_once "vistas/parte_superior.php";  
$tipo_tela = $_GET['tipo_tela'];
?>  

<!--INICIO del cont principal--> 
<div class="container">
    <h1>AGREGANDO COLORES - <?php echo strtoupper($tipo_tela);?></h1> 
</div>  

<?php
// Incluimos el archivo de conexión
include("bd/conexion.php");

// Obtenemos la conexión usando el método estático
$conn = Conexion::Conectar();

$opcion = isset($_POST['opcion']) ? $_POST['opcion'] : '';

try {
    // Consulta para obtener los colores
    $stmt = $conn->prepare("SELECT * FROM colores");
    $stmt->execute();
    
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) { 
?>
<div class="alert alert-info" role="alert"> 
    <?php echo $row['id']." ".$row['color']; $color = $row['color']; ?>  
    <form action="" method="POST" enctype="multipart/form-data"/> 
        Añadir imagen: <input name="archivo" id="archivo" type="file"/> 
        <input type="hidden" name="color" value="<?php echo $color; ?>">  
        <input type="submit" name="subir" value="Subir imagen"/> 
    </form> 
</div> 
<br> 
<?php 
    }
} catch(PDOException $e) {
    echo "Error en la consulta: " . $e->getMessage();
}

//Si se quiere subir una imagen 
if (isset($_POST['subir'])) {
    //Recogemos el archivo enviado por el formulario
    $archivo = $_FILES['archivo']['name'];
    $color = $_POST['color'];
    
    //Si el archivo contiene algo y es diferente de vacio
    if (isset($archivo) && $archivo != "") {
        //Obtenemos algunos datos necesarios sobre el archivo
        $tipo = $_FILES['archivo']['type'];
        $tamano = $_FILES['archivo']['size'];
        $temp = $_FILES['archivo']['tmp_name'];
        
        //Se comprueba si el archivo a cargar es correcto observando su extensión y tamaño
        if (!((strpos($tipo, "gif") || strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png")) && ($tamano < 2000000))) {
            echo '<div><b>Error. La extensión o el tamaño de los archivos no es correcta.<br/>
            - Se permiten archivos .gif, .jpg, .png. y de 200 kb como máximo.</b></div>';
        }
        else {
            //Si la imagen es correcta en tamaño y tipo
            //Se intenta subir al servidor
            if (move_uploaded_file($temp, 'images/'.$tipo_tela."-".$color.".jpeg")) {
                //Cambiamos los permisos del archivo a 777 para poder modificarlo posteriormente
                chmod('images/'.$tipo_tela."-".$color.".jpeg", 0777);
                //Mostramos el mensaje de que se ha subido co éxito
                echo '<div><b>Se ha subido correctamente la imagen.</b></div>';
                //Mostramos la imagen subida
                echo '<p><img src="images/'.$tipo_tela."-".$color.'.jpeg"></p>';
            }
            else {
                //Si no se ha podido subir la imagen, mostramos un mensaje de error
                echo '<div><b>Ocurrió algún error al subir el fichero. No pudo guardarse.</b></div>';
            }
        }
    } 
}   
?>    

<div style="background: red; width:50%; height: 50px; display: inline-block; margin-top: 50px;"></div> 
<div style="background: blue; width:50%; height: 50px; display:inline-block; margin-top: 50px; "></div> 
<!--FIN del cont principal-->  

<?php require_once "vistas/parte_inferior.php"?>