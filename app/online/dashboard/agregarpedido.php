<?php require_once "init.php" ?>

<?php

require_once "vistas/parte_superior.php" ?>

<!--INICIO del cont principal-->
<main id="main">

  <!-- ======= Portfolio Details Section ======= -->


  <section id="contact" class="contact">

    <div class="container">

      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/flatpickr.min.css">
      <script src="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/flatpickr.min.js"></script>

      <?php
      $_SESSION["s_usuario"];
      include_once '../bd/conexion.php';
      $objeto = new Conexion();
      $conexion = $objeto->Conectar();
      
      if (isset($_GET['num_orden'])) {
          $num_orden = $_GET['num_orden'];
      
          // Preparar la consulta con PDO
          $strsql1 = "SELECT * FROM pedido p
                      INNER JOIN pedido_detalle d ON d.num_orden = p.num_orden
                      LEFT JOIN clientes c ON p.rut_cliente = c.rut   
                      WHERE p.num_orden = :num_orden"; // Usar marcadores de nombre en PDO
          $stmt = $conexion->prepare($strsql1);
          $stmt->bindParam(':num_orden', $num_orden, PDO::PARAM_INT); // Enlazar el parámetro
          $stmt->execute();
          $rowfila = $stmt->fetch(PDO::FETCH_ASSOC); // Obtener el resultado
      
          if ($rowfila) {
              echo "<div class='alert alert-success'>";
              echo "<p style='margin-bottom:0;'>Ingresando un nuevo producto para la orden Nº: " . htmlspecialchars($num_orden) . " Cliente " . htmlspecialchars($rowfila['rut_cliente']) . "</p>";
      
              // Repetir la consulta no es necesario, reutilizar el resultado anterior
              do {
                  // Tu lógica para manejar los datos aquí...
              } while ($row1 = $stmt->fetch(PDO::FETCH_ASSOC)); // Continuar obteniendo el resto de las filas
              echo "</div>";
          }
      
          // Segunda consulta con PDO
          $strsql = "SELECT * FROM pedido p
                    INNER JOIN clientes c ON p.rut_cliente = c.rut
                    LEFT JOIN pedido_detalle pd ON p.num_orden = pd.num_orden
                    WHERE p.num_orden = :num_orden";
          $stmt = $conexion->prepare($strsql);
          $stmt->bindParam(':num_orden', $num_orden, PDO::PARAM_INT);
          $stmt->execute();
      
          $data = array();
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

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


      <div class="col-md-6" style="text-align: center; margin:0 auto;">
        <form action="#" method="post">
          <label> Que producto quieres agregar?</label>
          <select id="status" name="status" class="form-select" onChange="mostrar(this.value)">
            <option value="respaldo">Seleccionar producto</option>
            <option value="respaldo">Respaldos de Cama</option>
            <option value="colchon">Colchones</option>
            <option value="base">Base de Cama</option>
            <option value="velador">Veladores</option>
            <option value="patas">Patas de cama</option>
            <option value="banquetas">Banquetas</option>
            <option value="fundas">Fundas</option>
            <option value="living">Living</option>

          </select>
        </form>
      </div>
      <p></p>

      <div id="formularios" style="display: none;"> </div>











    </div>
    <div id="fracaso" style=" width: 60rem; margin:0 auto; text-align: center; ">


    </div>


  </section>

</main><!-- End #main --><!-- End #main -->
<!--FIN del cont principal-->

<?php require_once "vistas/parte_inferior.php" ?>