<?php

class FrontController {

    private $controlador;
    private $modelo;
    private $vista;

    public function __construct(Router $router, $nombreRuta = null, $accion = null) {
        $nombreRuta = strtolower($nombreRuta);
        
        $accion = strtolower($accion);
        $ruta = $router->getRoute($nombreRuta);

        $nombreModelo = $ruta->getModel();
        $nombreVista = $ruta->getView();
        $nombreControlador = $ruta->getController();

        $this->modelo = new $nombreModelo();
        $this->vista = new $nombreVista($this->modelo);
        $this->controlador = new $nombreControlador($this->modelo);

        if (method_exists($this->controlador, $accion)) {
            $this->controlador->$accion();
        } else {
            $this->controlador->main();
        }
    }

    public function output() {
        return $this->vista->render();
    }

}