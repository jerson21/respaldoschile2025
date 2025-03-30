<?php 

class Controllers {
    public $views; // Declaración explícita de la propiedad $views
    public $model; // Declaración explícita de la propiedad $model

    public function __construct() {
        $this->views = new Views();
        $this->loadModel();
    }

    public function loadModel() {
        $model = get_class($this) . "Model";
        $routClass = "Models/" . $model . ".php";
        if (file_exists($routClass)) {
            require_once($routClass);
            $this->model = new $model(); // Aquí usamos la propiedad declarada explícitamente
        }
    }
}

