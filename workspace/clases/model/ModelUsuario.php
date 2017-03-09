<?php

class ModelUsuario extends Model {
    
    function getUsuario($login){
        $gestor = new GestorUsuario();
        return $gestor->getUsuario($login);
    }
    
    function getList(){
        $gestor = new GestorUsuario();
        return $gestor->getList($login);
    }
    
    function insertUsuario($usuario){
        $gestor = new GestorUsuario();
        return $gestor->add($usuario);
    }
    
    function editUsuario($usuario, $login){
        $gestor = new GestorUsuario();
        return $gestor->save($usuario, $login);
    }
    
    function deleteUsuario($login){
        $gestor = new GestorUsuario();
        return $gestor->delete($login);
    }
    
    function getUsuarioPageController($pagina){
        $gestor = new GestorUsuario();
        $total = $gestor->count();
        return new PageController($total, $pagina);
    }
    
    function getUsuarioPage($pagina){
        $gestor = new GestorUsuario();
        return $gestor->getPage($pagina);
    }
}