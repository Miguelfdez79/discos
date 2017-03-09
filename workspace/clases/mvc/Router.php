<?php

class Router {

    private $rutas = array();

    function __construct() {
        $this->rutas['index'] = new Route('Model', 'View', 'Controller');
        $this->rutas['usuario'] = new Route ('ModelUsuario', 'View', 'ControllerUsuario');
        $this->rutas['disco'] = new Route ('ModelDisco', 'View', 'ControllerDisco');
    }

    function getRoute($ruta) {
        if (!isset($this->rutas[$ruta])) {
            return $this->rutas['index'];
        }
        return $this->rutas[$ruta];
    }

}