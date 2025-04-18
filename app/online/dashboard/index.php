<?php
session_start();

$tiempo_maximo = 1800; // 30 minutos (en segundos)

if (isset($_SESSION["ultimo_acceso"])) {
    if (time() - $_SESSION["ultimo_acceso"] > $tiempo_maximo) {
        session_unset(); // Elimina variables de sesión
        session_destroy(); // Destruye la sesión
        header("Location: login.php?timeout=true"); // Redirige al login
        exit();
    } else {
        $_SESSION["ultimo_acceso"] = time(); // Reinicia el contador
    }
} else {
    header("Location: ../login.php");
    exit();
}

?>
<?php require_once "init.php" ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pedidos</title>
  

     <!-- Fuentes e íconos -->
<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">  
     <!-- Fuentes e íconos  -->
  <script src="https://kit.fontawesome.com/c5b4401310.js" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="https://www.respaldoschile.cl/assets/img/favicon.png" rel="icon">

  <!-- Estilos principales -->
  <link href="css/sb-admin-2.min.css" rel="stylesheet"> 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <!-- Librerías adicionales -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/flatpickr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/flatpickr.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.all.min.js"></script>

   <!-- <link rel="stylesheet" type="text/css" href="css/design_respaldoschile.css">  -->

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/rowgroup/1.1.3/js/dataTables.rowGroup.min.js"></script>

</head>

<body>
<?php require_once "vistas/parte_superior.php" ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


<!--INICIO del cont principal-->
<div style="background-color: white;">
<div class="container">
    <h1>Respaldos Chile - Sistema</h1>
</div>
<!--FIN del cont principal-->

<?php

 include_once 'bd/conexion.php';
                        error_reporting(0);
                        $objeto1 = new Conexion();
                        $conexion = $objeto1->Conectar();
                         $fecha = date('m');
                         $consulta = "SELECT 
                         YEAR(fecha) AS anio, 
                         MONTH(fecha) AS mes, 
                         SUM(precio) AS total_ventas 
                     FROM 
                         pedido_detalle p 
                     INNER JOIN 
                         rutas r ON p.ruta_asignada = r.id
                     WHERE 
                         p.pagado = 1 
                         OR p.num_orden IN (SELECT DISTINCT num_orden FROM pagos)
                     GROUP BY 
                         YEAR(fecha), MONTH(fecha)";
                        $resultado = $conexion->prepare($consulta);
                        $resultado->execute();
                        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);


                         $objeto2 = new Conexion();
                        $conexion = $objeto2->Conectar();
                        
                         $consulta2 = "SELECT modelo AS nombre_producto, SUM(precio) AS total_ventas  FROM pedido_detalle where pagado = 1   
  GROUP BY modelo

  ORDER BY total_ventas DESC
  ";
                        $resultado2 = $conexion->prepare($consulta2);
                        $resultado2->execute();
                        $data2=$resultado2->fetchAll(PDO::FETCH_ASSOC);


                     



  
    
  
    

    
                       
    $consulta = " SELECT modelo AS nombre_producto, COUNT(*) AS total_ventas
      FROM pedido_detalle  where pagado = 1  
      GROUP BY modelo
      HAVING total_ventas > 5
      ORDER BY total_ventas DESC";
    $statement = $conexion->prepare($consulta);
    $statement->execute();
    $ventas_por_producto = $statement->fetchAll(PDO::FETCH_ASSOC);
    
   $pdo = null;
    
    // Crear el array de datos para el gráfico
    $datos = [
      'labels' => [],
      'datasets' => [
        [
          'label' => 'Ventas por producto',
          'data' => [],
          'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
          'borderColor' => 'rgba(255, 99, 132, 1)',
          'borderWidth' => 1
        ]
      ]
    ];
    
    // Agregar las etiquetas y los datos de ventas al array de datos
     foreach ($ventas_por_producto as $venta) {
      array_push($datos['labels'], $venta['nombre_producto']);
      array_push($datos['datasets'][0]['data'], intval($venta['total_ventas']));
    }
    



?>
<?php if($_SESSION["privilegios"] >= 20){  ?> 

<!--  <div class="col-sm-12 col-md-5  archivos" id="grafico"></div>


<script type="text/javascript">
  // Cargar la librería de Google Charts
  google.charts.load('current', {'packages':['corechart']});
  
  // Función para dibujar el gráfico
  function dibujarGrafico() {
    // Cargar los datos de ventas por mes desde PHP
    var ventas_por_mes = <?php echo json_encode($data); ?>;
    
    // Crear un array con los datos de ventas por mes para el gráfico
    var datos = [['Mes', 'Ventas']];
    for (var i = 0; i < ventas_por_mes.length; i++) {
      var mes = ventas_por_mes[i]['mes'];
      var anio = ventas_por_mes[i]['anio'];
      var total_ventas = parseFloat(ventas_por_mes[i]['total_ventas']);
      datos.push([mes + '/' + anio, total_ventas]);
    }
    
    // Crear un objeto DataTable de Google Charts con los datos del gráfico
    var data = google.visualization.arrayToDataTable(datos);

    // Configurar las opciones del gráfico
    var options = {
      title: 'Ventas por mes',
      legend: { position: 'none' },
      vAxis: { title: 'Monto de ventas' },
      hAxis: { title: 'Mes' }
    };

    // Dibujar el gráfico en el div con id "grafico"
    var chart = new google.visualization.ColumnChart(document.getElementById('grafico'));
    chart.draw(data, options);
  }
  
  // Llamar a la función dibujarGrafico cuando se haya cargado la librería de Google Charts
  google.charts.setOnLoadCallback(dibujarGrafico);
</script> -->




<div class="col-sm-12 col-md-5  archivos">


                      <canvas id="grafica"></canvas>
                    <script>
                      // Cargar los datos de ventas por mes desde PHP
                      var ventas_por_mes = <?php echo json_encode($data); ?>;
                      
                      // Crear un array con los nombres de los meses
                      var meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                      
                      // Crear un array con las etiquetas de los meses y los totales de ventas
                      var labels = [];
                      var ventas = [];
                      for (var i = 0; i < ventas_por_mes.length; i++) {
                        var mes = ventas_por_mes[i]['mes'];
                        var anio = ventas_por_mes[i]['anio'];
                        var total_ventas = parseFloat(ventas_por_mes[i]['total_ventas']);
                        labels.push(meses[mes-1] + ' ' + anio);
                        ventas.push(total_ventas);
                      }
                      
                      // Configurar el gráfico utilizando Chart.js
                      var ctx = document.getElementById('grafica').getContext('2d');
                      var myChart = new Chart(ctx, {
                          type: 'line',
                          data: {
                              labels: labels,
                              datasets: [{
                                  label: 'Ventas por mes',
                                  data: ventas,
                                  backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                  borderColor: 'rgba(54, 162, 235, 1)',
                                  borderWidth: 1
                              }]
                          },
                          options: {
                              scales: {
                                  yAxes: [{
                                      ticks: {
                                          beginAtZero: true
                                      }
                                  }]
                              }
                          }
                      });
                    </script>



 </div>
<div class="container">
   <h1>Productos mas vendidos</h1>
</div>

 <div class="col-sm-12 col-md-5  archivos">


                      <canvas id="grafico1"></canvas>
                      <script>
      var ctx = document.getElementById('grafico1').getContext('2d');
     var chart = new Chart(ctx, {
  type: 'bar',
  data: <?php echo json_encode($datos); ?>,
  options: {
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true
        }
      }]
    },
    plugins: {
      datalabels: {
        anchor: 'end',
        align: 'top',
        formatter: function(value, context) {
          return context.dataset.text[context.dataIndex];
        }
      }
    }
  }
});
    </script>


 </div>
<?php  } ?>

<div style="text-align: center;"><img src="img/loader.gif"></div>

</div>


<?php require_once "vistas/parte_inferior.php"?>