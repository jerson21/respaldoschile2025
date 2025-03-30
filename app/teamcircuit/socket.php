<?php
// Get the received data
$data = file_get_contents('php://input');

// Specify the file path
$filePath = 'webhooks.txt';

// Open the file in append mode
$file = fopen($filePath, 'a');

// Write the data to the file
fwrite($file, $data . PHP_EOL);

// Close the file
fclose($file);
?>