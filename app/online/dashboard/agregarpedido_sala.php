<?php require_once "init.php" ?>
<?php require_once "vistas/parte_superior.php"?>
<?php include "css/header_estilos.php" ?>

<!--INICIO del cont principal-->
<main id="main">
    <!-- ======= Breadcrumbs ======= -->
    
    <!-- ======= Portfolio Details Section ======= -->
    <section id="contact" class="contact">
        <div class="container" >
            
            <?php 
            $_SESSION["s_usuario"]; 
            include("bd/conexion.php"); 
            
            // Usamos la conexión PDO
            $conn = Conexion::Conectar();
            
            if(isset($_GET['num_orden'])) {
                $num_orden = $_GET['num_orden'];
                
                // Consulta preparada para obtener los pedidos
                $strsql1 = "SELECT * FROM pedidos WHERE num_orden = :num_orden";
                $stmt1 = $conn->prepare($strsql1);
                $stmt1->bindParam(':num_orden', $num_orden, PDO::PARAM_INT);
                $stmt1->execute();
                
                // Obtener la primera fila para el encabezado
                $rowfila = $stmt1->fetch(PDO::FETCH_ASSOC);
            ?>
            
            <div class="alert alert-success">
                <p style="margin-bottom:0;">Ingresando un nuevo producto para la orden Nº: <?php echo $num_orden." Cliente ".$rowfila['rut_cliente'];?></p>
                
                <?php
                // Volvemos a ejecutar la consulta para iterar sobre todos los resultados
                $stmt1 = $conn->prepare($strsql1);
                $stmt1->bindParam(':num_orden', $num_orden, PDO::PARAM_INT);
                $stmt1->execute();
                
                while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                    echo "<p style='font-size:0.9rem; margin-bottom:0;'>";
                    echo "<span style='font-size:0.8rem;font-weight: bold;'>".$row1['id'].". </span>";
                    
                    if(is_numeric($row1['plazas'])) {
                        echo $modelo = $row1['modelo']." ".$row1['plazas']." Plazas"." Color: ".$row1['color'];
                    } elseif($row1['modelo'] == "Patas de cama") {
                        echo $modelo = $row1['modelo']." ".$row1['tipotela']." Cantidad : ".$row1['cantidad'];
                    } else {
                        echo $modelo = $row1['modelo']." ".$row1['plazas']." ".ucfirst($row1['tipotela'])." ". $row1['color'];
                    }
                    
                    $direccion = $row1['direccion'];
                    $telefono = $row1['telefono'];
                    $numero = $row1['numero'];
                    $dpto = $row1['dpto'];
                    $correo = $row1['correo'];
                    $instagram = $row1['instagram'];
                    echo "</p>";
                }
                ?>
            </div>
            
            <?php
            // Consulta preparada para obtener la orden
            $strsql = "SELECT * FROM orden WHERE num_orden = :num_orden";
            $stmt = $conn->prepare($strsql);
            $stmt->bindParam(':num_orden', $num_orden, PDO::PARAM_INT);
            $stmt->execute();
            
            // Contamos las filas manualmente o usando rowCount()
            $total_rows = $stmt->rowCount();
            
            $data = array();
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $rut_cliente = $row['rut_cliente'];
                $direccion = $row['direccion'];
                $telefono = $row['telefono'];
                $numero = $row['numero'];
                $dpto = $row['dpto'];
                $correo = $row['correo'];
                $instagram = $row['instagram'];
            }
            }
            ?>
            
            <div class="col-md-6">
                <form action="#" method="post">
                    <label> Que producto quieres agregar?</label>
                    <select id="status" name="status" class="form-select" onChange="mostrar(this.value)">
                        <option value="respaldo" >Seleccionar producto</option>
                        <option value="respaldo">Respaldos de Cama</option>
                        <option value="colchon">Colchones</option>
                        <option value="base">Base de Cama</option>
                        <option value="patas">Patas de cama</option>
                        <option value="velador">Veladores</option>
                        <option value="banquetas">Banquetas</option>
                        <option value="fundas">Fundas</option>
                        <option value="living">Living</option>
                        <option value="respaldo2">Respaldo 2 </option>
                    </select>
                </form>
            </div>
            <p></p>
            
            <div id="formularios" style="display: none;"></div>
        </div>
        <div id="fracaso" style=" width: 60rem; margin:0 auto; text-align: center; "></div>
    </section>
</main><!-- End #main --><!-- End #main -->
<!--FIN del cont principal-->

<?php require_once "vistas/parte_inferior.php"?>