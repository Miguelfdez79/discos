<?php

class GestorDisco{
    
    const TABLA = 'disco';
    private $db;

    function __construct() {
        $this->db = new DataBase();
    }
    
    private static function _getCampos(Disco $objeto){
        $campos = $objeto->get();
        return $campos;
    }
    
    function add(Disco $objeto) {
        return $this->db->insertParameters(self::TABLA, self::_getCampos($objeto), true);
    }
    
    function count($parametros = array()) {
        return $this->db->countParameters(self::TABLA, $parametros);
    }
    
    function delete($idDisco) {
        return $this->db->deleteParameters(self::TABLA, array('idDisco' => $idDisco));
    }
    
    function get($idDisco){
        $this->db->getCursorParameters(self::TABLA, '*', array('idDisco' => $idDisco));
        $objeto = new Disco();
        if($fila = $this->db->getRow()){
            $objeto->set($fila);
        }
        return $objeto;
    }
    
    function getList(){
        $this->db->getCursorParameters(self::TABLA);
        $respuesta = array();
        while ($fila = $this->db->getRow()) {
            $objeto = new Disco();
            $objeto->set($fila);
            $respuesta[] = $objeto;
        }
        return $respuesta;
    }
    
    function getPage($pagina = 1, $parametros = array(), $orderby = '1',  $rpp = 16) {
        $desde = ($pagina - 1) * $rpp;
        $limit = 'limit ' . $desde . ', ' . $rpp;
        $this->db->getCursorParameters(self::TABLA, '*', $parametros, $orderby, $limit);
        return $this->getResultadoSelect();
    }

    private function getResultadoSelect() {
        $respuesta = array();
        while ($fila = $this->db->getRow()) {
            $objeto = new Disco();
            $objeto->set($fila);
            $respuesta[] = $objeto;
        }
        return $respuesta;
    }
    
    function save(Disco $objeto) {
        $campos = self::_getCampos($objeto);
        return $this->db->updateParameters(self::TABLA, $campos, array('idDisco' => $objeto->getIdDisco()));
    }
    
}