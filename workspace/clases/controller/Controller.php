<?php

class Controller {

    private $modelo, $sesion, $usuario;

    function __construct(Model $modelo) {
        $this->modelo = $modelo;
        $this->sesion = Session::getInstance('discos');
    }

    function getModel() {
        return $this->modelo;
    }
    
    function getSession() {
        return $this->sesion;
    }
    
    function getDiskPageController(){
        return $this->getModel()->getDiscosPageController(Request::get('pagina'));
    }
    
    function getUsuarioPageController(){
        return $this->getModel()->getUsuarioPageController(Request::get('pagina'));
    }

    function main() {
        if($this->sesion->isLogged()){
            $this->modelo->addFile('loguear', Util::renderFile('template/html/logueado.html'));
            $this->modelo->addFile('aside', Util::renderFile('template/html/naV-usuario.html'));
            $this->modelo->addFile('paginacion', Util::renderFile('template/html/paginacion.html'));
            header('Location: index.php?ruta=disco&accion=viewlistadiscos');
        } else {
            $this->modelo->addFile('loguear', Util::renderFile('template/html/deslogueado.html'));
            $this->modelo->addFile('aside', Util::renderFile('template/html/naV-visitante.html'));
            $this->modelo->addFile('paginacion', Util::renderFile('template/html/paginacion-vacio.html'));
            header('Location: index.php?ruta=disco&accion=viewlistadiscos');
        }
    }
    
    function usuario() {
        $this->modelo->addFile('loguear', Util::renderFile('template/html/deslogueado.html'));
        $this->modelo->addFile('aside', Util::renderFile('template/html/naV-visitante.html'));
        $this->modelo->addFile('contenido', Util::renderFile('template/html/loguearse.html'));
        $this->modelo->addFile('paginacion', Util::renderFile('template/html/paginacion-vacio.html'));
        
    }
    
}