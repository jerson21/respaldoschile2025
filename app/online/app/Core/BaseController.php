<?php
namespace App\Core;

class BaseController
{
    protected function view(string $view, array $params = []): void
    {
        extract($params, EXTR_SKIP);
        $viewFile = __DIR__ . '/../Views/' . $view . '.php';
        if (!file_exists($viewFile)) {
            throw new \Exception("View {$view} not found");
        }
        require $viewFile;
    }
}