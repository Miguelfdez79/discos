<?php

class GestorUsuario {
    
    const TABLA = 'usuario';
    private $db;

    function __construct() {
        $this->db = new DataBase();
    }
    
    private static function _getCampos(Usuario $objeto){
        $campos = $objeto->get();
        return $campos;
    }
    
    function add(Usuario $objeto){
        return $this->db->insertParameters(self::TABLA, $objeto->get(), true);
    }
    
    function count($parametros = array()) {
        return $this->db->countParameters(self::TABLA, $parametros);
    }
    
    function delete($login) {
        return $this->db->deleteParameters(self::TABLA, array('login' => $login));
    }
    
    function getUsuario($login){
        $this->db->getCursorParameters(self::TABLA, '*', array('login' => $login));
        if ($fila = $this->db->getRow()) {
            $objeto = new Usuario();
            $objeto->set($fila);
            return $objeto;
        }
        return new Usuario();
    }
    
    function getList(){
        $this->db->getCursorParameters(self::TABLA);
        $respuesta = array();
        while ($fila = $this->db->getRow()) {
            $objeto = new Usuario();
            $objeto->set($fila);
            $respuesta[] = $objeto;
        }
        return $respuesta;
    }
    
    function getPage($pagina = 1, $parametros = array(), $orderby = '1',  $rpp = 8) {
        $desde = ($pagina - 1) * $rpp;
        $limit = 'limit ' . $desde . ', ' . $rpp;
        $this->db->getCursorParameters(self::TABLA, '*', $parametros, $orderby, $limit);
        return $this->getResultadoSelect();
    }

    private function getResultadoSelect() {
        $respuesta = array();
        while ($fila = $this->db->getRow()) {
            $objeto = new Usuario();
            $objeto->set($fila);
            $respuesta[] = $objeto;
        }
        return $respuesta;
    }
    
    function save(Usuario $objeto, $loginpk) {
        $campos = $objeto->get();
        
        if( $objeto->getLogin() === null || $objeto->getLogin() === '' ){
            unset($campos['login']);
        }
        
        if($objeto->getPassword() === null || $objeto->getPassword() === '') {
            unset($campos['password']);
        }
        return $this->db->updateParameters(self::TABLA, $campos, array('login' => $loginpk));
    }
    
}