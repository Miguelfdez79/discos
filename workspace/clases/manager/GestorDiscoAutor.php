<?php

class GestorDiscoAutor{
    
    const TABLA = 'discosAutor';
    private $db;

    function __construct() {
        $this->db = new DataBase();
    }
    
    private static function _getCampos(DiscoAutor $objeto){
        $campos = $objeto->get();
        return $campos;
    }
    
    function add(DiscoAutor $objeto) {
        return $this->db->insertParameters(self::TABLA, $objeto->get(), true);
    }
    
    function delete($idDisco, $idAutor) {
        return $this->db->deleteParameters(self::TABLA, array('idDisco' => $idDisco, 'idAutor' => $idAutor));
    }
    
    function getDiscoAutores($idDisco){
        $this->db->getCursorParameters(self::TABLA, '*', array('idDisco' => $idDisco));
        $respuesta = array();
        while ($fila = $this->db->getRow()) {
            $objeto = new DiscoAutor();
            $objeto->set($fila);
            $respuesta[] = $objeto;
        }
        return $respuesta;
    }
    
    function getAutoresDisco($idAutor){
        $this->db->getCursorParameters(self::TABLA, '*', array('idAutor' => $idAutor));
        $respuesta = array();
        while ($fila = $this->db->getRow()) {
            $objeto = new DiscoAutor();
            $objeto->set($fila);
            $respuesta[] = $objeto;
        }
        return $respuesta;
    }
    
}