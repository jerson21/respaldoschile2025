<?php
namespace App\Core;

use PDO;

class BaseModel
{
    protected PDO $db;

    public function __construct()
    {
        $config = require __DIR__ . '/../../config/database.php';
        $dsn = "{$config['driver']}:host={$config['host']};dbname={$config['database']};charset={$config['charset']}";
        $this->db = new PDO($dsn, $config['username'], $config['password'], $config['options']);
    }
}