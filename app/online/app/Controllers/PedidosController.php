<?php
namespace App\Controllers;

use App\Core\BaseController;
// El consumo de datos se realiza desde la API Node a través de JS en el cliente

class PedidosController extends BaseController
{
    public function index(): void
    {
        // Renderiza la vista; los pedidos se cargarán dinámicamente en el cliente
        $this->view('pedidos/index');
    }
}