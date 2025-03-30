<?php
header('Content-Type: application/json');
header('Cache-Control: no-cache');

// Simular mensajes nuevos
sleep(5);

// Aquí es donde buscaría los mensajes en su base de datos o archivo
$mensajes = array(
  array('mensaje' => 'Hola desde el chat en tiempo real'),
  array('mensaje' => '¡Esto es genial!'),
);

echo json_encode($mensajes);