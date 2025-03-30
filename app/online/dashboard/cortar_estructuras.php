<?php require_once "vistas/parte_superior.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Corte de Esqueleteria</title>
  <style>
    /* Estilos para SweetAlert y campos personalizados */
    .custom-input {
      width: 150px;
      height: 40px;
      font-size: 15px;
      margin: 0 auto;
    }
    .swal2-content {
      margin-bottom: 20px;
    }
    .swal2-content label {
      display: block;
      margin-bottom: 10px;
    }
    .swal2-content input[type="checkbox"] {
      margin-right: 5px;
    }
    .swal2-content input[type="text"] {
      display: none;
      margin-top: 10px;
      padding: 5px;
      width: 100%;
    }
    /* Estilos para botones circulares */
    .btn-circle.btn-sm {
      width: 40px;
      height: 40px;
      padding: 6px 0px;
      border-radius: 20px;
      font-size: 8px;
      text-align: center;
    }
    .btn-circles.btn-sm {
      width: 20px;
      height: 20px;
      padding: 3px 0px;
      border-radius: 20px;
      font-size: 8px;
      text-align: center;
    }
  </style>
</head>
<body>
<div id="contenido1" style="margin:0 auto; overflow: auto;">
  <div class="container" style="max-width: 100rem; width: 200rem;">
    <h1>Corte de Esqueleteria</h1>
    <!-- Se elimina la clase btn-sm para mantener la apariencia original -->
    <button class="btn btn-primary" id="ingreso-stock-btn">Ingreso de Stock</button>

    <script>
      // Botón Ingreso de Stock: muestra un SweetAlert para capturar datos y enviarlos vía AJAX
      $('#ingreso-stock-btn').click(function() {
        Swal.fire({
          title: 'Ingreso de Stock',
          html: `
            <select id="plaza-select" class="swal2-input">
              <option value="1 plaza">1 plaza</option>
              <option value="1.5 plazas">1.5 plazas</option>
              <option value="2 plazas">2 plazas</option>
              <option value="Queen">Queen</option>
              <option value="King">King</option>
              <option value="Super King">Super King</option>
            </select>
            <input type="number" id="cantidad-input" class="swal2-input" placeholder="Cantidad">
          `,
          focusConfirm: false,
          showCancelButton: true,
          confirmButtonText: 'Aceptar',
          cancelButtonText: 'Cancelar',
          preConfirm: () => {
            const plaza = document.getElementById('plaza-select').value;
            const cantidad = document.getElementById('cantidad-input').value;
            if (!plaza || !cantidad) {
              Swal.showValidationMessage(`Por favor, ingrese todos los datos`);
              return false;
            }
            return { plaza, cantidad };
          }
        }).then((result) => {
          if (result.isConfirmed) {
            const { plaza, cantidad } = result.value;
            $.ajax({
              url: 'tu-endpoint-de-crud', // Cambia esta URL según corresponda
              method: 'POST',
              data: { plaza: plaza, cantidad: cantidad },
              success: function(response) {
                Swal.fire({
                  icon: 'success',
                  title: 'Éxito',
                  text: 'Datos enviados correctamente'
                });
              },
              error: function(xhr, status, error) {
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'Hubo un problema al enviar los datos'
                });
              }
            });
          }
        });
      });
    </script>

    <?php
    // Conexión a la base de datos con MySQLi
    $BD_SERVIDOR = "localhost";
    $BD_USUARIO = "cre61650_respaldos21";
    $BD_PASSWORD = "respaldos21/";
    $BD_NOMBRE = "cre61650_agenda";

    $mysqli = new mysqli($BD_SERVIDOR, $BD_USUARIO, $BD_PASSWORD, $BD_NOMBRE);
    if ($mysqli->connect_error) {
      die("Error de conexión: " . $mysqli->connect_error);
    }
    $mysqli->set_charset("utf8");

    // Obtener todas las rutas en una sola consulta para evitar búsquedas repetidas
    $rutas = [];
    $resultadoRutas = $mysqli->query("SELECT id, fecha FROM rutas");
    while ($filaRuta = mysqli_fetch_assoc($resultadoRutas)) {
      $rutas[$filaRuta['id']] = $filaRuta['fecha'];
    }

    // Consulta principal agrupando por 'ruta_asignada'
    $query = "SELECT * FROM pedido_detalle pd 
              INNER JOIN pedido_etapas pe ON pd.id = pe.idpedido 
              WHERE pd.estadopedido IN (2,5) 
              GROUP BY ruta_asignada";
    $resultado = $mysqli->query($query);
    ?>

    <div class="container">
      <div class="row">
        <!-- Sección para contenido adicional si es necesario -->
      </div>
    </div>
    <br>
    <div class="container" style="float:left; padding: 0;">
      <div class="row">
        <div class="col-lg-12">
          <?php
          // Recorremos cada grupo de pedidos por ruta
          while ($row = mysqli_fetch_array($resultado)) {
            $ruta = $row['ruta_asignada'];
            if (!empty($ruta) && isset($rutas[$ruta])) {
              // Se prueba con varias opciones de locale en español
              setlocale(LC_TIME, 'es_CL.UTF-8', 'es_ES.UTF-8', 'Spanish_Spain.1252');
              $fecha = strftime("%A, %d de %B de %Y", strtotime($rutas[$ruta]));
              $fecha = iconv('ISO-8859-1', 'UTF-8', $fecha);

            } else {
              $fecha = "Pedidos sin asignar a ruta";
            }
            ?>
            <div class="table-responsive" style="margin:0; width: 80rem;">
              <table id="tablatapiceross" class="table table-striped table-bordered table-condensed" style="width:100%; font-size:0.8rem;">
                <thead class="text-center">
                  <tr>
                    <th colspan="12">
                      <div class="alert <?php echo (empty($ruta) || $ruta==0 || $ruta=='{0}') ? 'alert-danger' : 'alert-warning'; ?>" role="alert" style="margin:0 auto; text-align:center;">
                        <?php 
                        if (empty($ruta) || $ruta==0 || $ruta=='{0}') {
                          echo "Pedidos sin asignar a ruta";
                        } else {
                          echo "<b>" . htmlspecialchars($ruta) . ".</b> " . htmlspecialchars($fecha);
                        }
                        ?>
                      </div>
                    </th>
                  </tr>
                  <tr>
                    <th style="width:2rem;">Id</th>
                    <th style="width:7rem;">Modelo</th>
                    <th style="width:2rem;">Tamano</th>
                    <th style="width:2rem;">Base</th>
                    <th style="width:6rem;">Observacion</th>
                    <th style="width:9rem;">Detalle</th>
                    <th style="width:2rem;">Tablas</th>
                    <th style="width:5rem;">Estado Pedido</th>
                    <th style="width:1rem;">Cliente</th>
                    <th style="width:5rem;">Cortar</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // Para cada grupo de ruta, se consultan los pedidos correspondientes
                  $rutaEscapado = $mysqli->real_escape_string($ruta);
                  $queryPedidos = "SELECT *, pd.id AS id, pd.modelo AS modelo,
                      CASE
                          WHEN pd.tamano = '1' THEN pv.unaplaza
                          WHEN pd.tamano = '1 1/2' THEN pv.plazaymedia
                          WHEN pd.tamano = 'full' THEN pv.full
                          WHEN pd.tamano = '2' THEN pv.dosplazas
                          WHEN pd.tamano = 'queen' THEN pv.queen
                          WHEN pd.tamano = 'king' THEN pv.king
                          WHEN pd.tamano = 'super king' THEN pv.superking
                          ELSE NULL
                      END AS metraje
                      FROM pedido_detalle pd
                      LEFT JOIN productos_venta pv ON pd.modelo = pv.modelo
                      LEFT JOIN (
                          SELECT idPedido, fecha, idProceso, GROUP_CONCAT(idProceso) AS eTapas
                          FROM pedido_etapas
                          WHERE idProceso != 1
                          GROUP BY idPedido
                      ) etapas ON pd.id = etapas.idPedido
                      WHERE pd.ruta_asignada = '$ruta' 
                        AND (pd.estadopedido IN (2,5,6) OR (etapas.idProceso = 6 AND etapas.fecha = CURDATE()))
                      ORDER BY pd.color, pd.tipotela";
                  $resultados = $mysqli->query($queryPedidos);
                  while ($dat = mysqli_fetch_array($resultados)) {
                    ?>
                    <tr>
                      <td style="height:10px; padding: 1px;"><?php echo $dat['id']; ?></td>
                      <td style="height:10px; padding: 1px;"><?php echo htmlspecialchars($dat['modelo']); ?></td>
                      <td style="height:10px; padding: 1px; text-align: center;"><?php echo htmlspecialchars($dat['tamano']) . " <b>" . htmlspecialchars($dat['tipo_boton']) . "</b>"; ?></td>
                      <td style="height:10px; padding: 1px; font-weight: bold; text-align: center;"><?php echo htmlspecialchars($dat['alturabase']); ?></td>
                      <td style="height:10px; padding: 1px;"><?php echo htmlspecialchars($dat['detalles_fabricacion']); ?></td>
                      <td style="height:15px; padding: 1px;">
                        <?php
                        $fechaActual = new DateTime();
                        if (!empty($dat['detalle_entrega']) && strtotime($dat['detalle_entrega']) !== false) {
                          $detalleEntrega = new DateTime($dat['detalle_entrega']);
                          $detalleHora = new DateTime($dat['detalle_entrega']);
                          $detalleEntrega->setTime(0, 0, 0);
                          $manana = new DateTime('tomorrow');
                          if ($detalleEntrega->format('Y-m-d') === $fechaActual->format('Y-m-d')) {
                            echo "<span style='color:red;'>RETIRA HOY a las " . $detalleHora->format('H:i') . "</span>";
                          } elseif ($detalleEntrega->format('Y-m-d') === $manana->format('Y-m-d')) {
                            echo "RETIRA MAÑANA a las " . $detalleHora->format('H:i');
                          } else {
                            echo htmlspecialchars($dat['detalle_entrega']);
                          }
                        }
                        ?>
                      </td>
                      <td style="height:10px; padding: 1px; text-align:center;">
                        <?php echo "<b>" . ($dat['metraje'] / 2) . "</b> - " . $dat['metraje']; ?>
                      </td>
                      <td style="height:10px; padding: 1px;">
                        <?php
                        if ($dat['estadopedido'] == "0") {
                          echo "<div class='text-center'><div class='btn-group'><button class='btn btn-warning' style='font-size:0.8rem; max-height:1.5rem; line-height:12px;'>No Aceptado</button></div>";
                        } elseif ($dat['estadopedido'] == "1") {
                          echo "<div class='text-center'><div class='btn-group'><button class='btn btn-secondary' style='font-size:0.8rem; max-height:1.5rem; line-height:12px;'>Aceptado</button></div>";
                        } elseif ($dat['estadopedido'] == "2" && (empty($dat['tapicero_id']) || $dat['tapicero_id'] == "0")) {
                          echo "<div class='text-center'><div class='btn-group'><button class='btn btn-warning' id='parpadea_' style='font-size:0.8rem; max-height:1.5rem; line-height:12px;'>Por Fabricar</button></div>";
                        } elseif ($dat['estadopedido'] == "5") {
                          echo "<div class='text-center'><div class='btn-group'><button class='btn btn-success' id='parpadea' style='font-size:0.8rem; max-height:1.5rem; line-height:12px;'>Fabricando</button></div>";
                        } elseif ($dat['estadopedido'] == "2") {
                          echo "<div class='text-center'><div class='btn-group'><button class='btn btn-success' id='parpadea' style='font-size:0.8rem; max-height:1.5rem; line-height:12px;'>Por Fabricar</button></div>";
                        } elseif ($dat['estadopedido'] == "6") {
                          echo "<div class='text-center'><div class='btn-group'><button class='btn btn-info' style='font-size:0.8rem; max-height:1.5rem; line-height:12px;'>Pedido Listo</button></div>";
                        } elseif ($dat['estadopedido'] == "7") {
                          echo "<div class='text-center'><div class='btn-group'><button class='btn btn-warning' style='font-size:0.8rem; max-height:1.5rem; line-height:12px;'>En carga</button></div>";
                        } elseif ($dat['estadopedido'] == "19") {
                          echo "<div class='text-center'><div class='btn-group'><button class='btn btn-warning' style='font-size:0.8rem; max-height:1.5rem; line-height:12px;'>Reagendar</button></div>";
                        } elseif ($dat['estadopedido'] == "4") {
                          echo "<div class='text-center'><div class='btn-group'><button class='btn btn-dark' style='font-size:0.8rem; max-height:1.5rem; line-height:12px;'>Devuelto</button></div>";
                        }
                        ?>
                      </td>
                      <td style="height:10px; padding: 1px; text-align: center;">
                        <?php if ($dat['confirma'] == "1") { ?>
                          <button type="button" class="btn btn-info btn-circles btn-sm"></button>
                        <?php } else { ?>
                          <button type="button" class="btn btn-danger btn-circles btn-sm"></button>
                        <?php } ?>
                      </td>
                      <?php
                      $etapas = explode(',', $dat['eTapas']);
                      $existeEtapa1 = in_array('4', $etapas);
                      if ($existeEtapa1) { ?>
                        <td style="height:10px; padding: 1px; text-align: center;">
                          <button type="button" class="btn btn-success btn-circle btn-sm btneliminaresqueleto"></button>
                        </td>
                      <?php } else { ?>
                        <td style="height:10px; padding: 1px; text-align: center;">
                          <button type="button" class="btn btn-warning btn-circle btn-sm btncortaresqueleto"></button>
                        </td>
                      <?php } ?>
                    </tr>
                    <?php
                  }
                  ?>
                </tbody>
              </table>
            </div>
          <?php } // fin while rutas ?>
        </div>
      </div>
    </div>
  </div><!-- fin div contenido1 -->

  <script>
    $(document).ready(function () {
      $('#buscadorGeneral').keyup(function () {
        var terminosDeBusqueda = this.value.toLowerCase().trim().split(/\s+/);
        $('table').each(function () {
          var tablaActual = $(this);
          tablaActual.find('tbody tr').each(function () {
            var fila = $(this);
            var textoFila = fila.text().toLowerCase();
            var todosTerminosEncontrados = terminosDeBusqueda.every(function (termino) {
              return textoFila.includes(termino);
            });
            fila.toggle(todosTerminosEncontrados);
          });
        });
      });
    });
  </script>

</div>
<!--FIN del cont principal-->
<?php require_once "vistas/parte_inferior.php"; ?>
</body>
</html>
