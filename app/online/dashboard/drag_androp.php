<?php require_once "init.php" ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pedidos</title>
  
    <link rel="stylesheet" src="vistas/extras.css"> 




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
<?php
// Tu código PHP existente...

// Datos de tus pedidos (desde tu base de datos)
$pedidos = [
    [
        "id" => "1",
        "producto" => "Base para maceta",
        "tamano" => "Grande",
        "material" => "Madera",
        "color" => "Natural",
        "alturaBase" => "15 cm",
        "cantidad" => 2,
        "precio" => 25000,
        "estado" => "pendiente",
        "detallesFabricacion" => "Acabado liso con bordes redondeados"
    ],
    // ... más pedidos
];

// Convertir a JSON para pasar a React
$pedidosJson = json_encode($pedidos);
?>

<!-- Dentro de tu dashboard, donde quieras mostrar el componente de pedidos -->
<div id="pedidos-dashboard-container" class="mi-contenedor-dashboard"></div>

<!-- Al final de tu archivo, antes de cerrar el body -->
<!-- Incluir los archivos compilados de React -->
<script src="pedidos-component/build/static/js/main.63ea4a48.js"></script>

<link href="pedidos-component/build/static/css/main.7bed83df.css" rel="stylesheet">

<script>
    // Montar el componente React en tu dashboard
    window.montarComponentePedidos('pedidos-dashboard-container', {
        datosPedidos: <?php echo $pedidosJson; ?>,
        onGuardarCambios: function(datos) {
            // Puedes manejar los cambios como prefieras
            console.log('Datos guardados:', datos);
            
            // Ejemplo: enviar datos a servidor mediante fetch
            fetch('guardar_pedidos.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(datos),
            })
            .then(response => response.json())
            .then(data => {
                alert('Cambios guardados correctamente');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al guardar cambios');
            });
        }
    });
</script>