<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificación de Nueva Venta</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            background-color: #ffffff;
            width: 100%;
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        h1, h2 {
            color: #007BFF;
        }
        p {
            color: #666;
            line-height: 1.5;
        }
        .footer {
            font-size: 0.9em;
            color: #777;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Pedido N° <?= $data['pedido']['orden']['idpedido'] ?></h1>
        <p>Fecha del Pedido: <?= $data['pedido']['orden']['fecha'] ?></p>
        <p>Total del Pedido: <?= SMONEY . number_format($data['pedido']['orden']['monto'], 2) ?></p>
        
        <h2>Detalles del Cliente</h2>
        <p>Nombre: <?= $_SESSION['userData']['nombres'] . ' ' . $_SESSION['userData']['apellidos'] ?></p>
        <p>Email: <?= $_SESSION['userData']['email_user'] ?></p>
        <p>Teléfono: <?= $_SESSION['userData']['telefono'] ?></p>
        <p>Dirección: <?= $data['pedido']['orden']['direccion_envio'] ?></p>
        
        <h2>Productos Comprados</h2>
        <?php foreach ($data['pedido']['detalle'] as $producto): ?>
            <p><?= $producto['cantidad'] ?> x <?= $producto['producto'] ?> a <?= SMONEY . number_format($producto['precio'], 2) ?></p>
        <?php endforeach; ?>
        
        <div class="footer">
            <p>Gracias por usar nuestro servicio.</p>
        </div>
    </div>
</body>
</html>
