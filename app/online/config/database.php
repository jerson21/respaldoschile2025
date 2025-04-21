<?php
return [
    'driver'   => 'mysql',
    'host'     => getenv('DB_HOST') ?: '127.0.0.1',
    'port'     => getenv('DB_PORT') ?: '3306',
    'database' => getenv('DB_NAME') ?: 'respaldos',
    'username' => getenv('DB_USER') ?: 'root',
    // Utiliza DB_PASSWORD de .env (o DB_PASS para compatibilidad hacia atrás)
    'password' => getenv('DB_PASSWORD') ?: getenv('DB_PASS') ?: '',
    'charset'  => 'utf8mb4',
    'options'  => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ],
];