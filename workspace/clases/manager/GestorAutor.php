<?php

class GestorAutor{
    
    const TABLA = 'autor';
    private $db;

    function __construct() {
        $this->db = new DataBase();
    }
    
    private static function _getCampos(Autor $objeto){
        $campos = $objeto->get();
        return $campos;
    }
    
    function add(Autor $objeto) {
        return $this->db->insertParameters(self::TABLA, self::_getCampos($objeto), true);
    }
    
    function delete($idAutor) {
        return $this->db->deleteParameters(self::TABLA, array('idAutor' => $idAutor));
    }
    
    function get($id_autor){
        $this->db->getCursorParameters(self::TABLA, '*', array('idAutor' => $id_autor));
        $objeto = new Autor();
        if($fila = $this->db->getRow()){
            $objeto->set($fila);
        }
        return $objeto;
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
            $objeto = new Autor();
            $objeto->set($fila);
            $respuesta[] = $objeto;
        }
        return $respuesta;
    }
    
    function save(Autor $objeto) {
        $campos = self::_getCampos($objeto);
        return $this->db->updateParameters(self::TABLA, $campos, array('idAutor' => $objeto->getIdAutor() ) );
    }
    
}