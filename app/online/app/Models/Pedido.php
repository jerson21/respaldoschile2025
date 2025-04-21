<?php
namespace App\Models;

use App\Core\BaseModel;
use PDO;

class Pedido extends BaseModel
{
    public function all(): array
    {
        $stmt = $this->db->query('SELECT * FROM pedidos');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}