<?php

class DiscoAutor {
    
    private $idDisco, $idAutor;
    
    function __construct($idDisco=null, $idAutor=null) {
        $this->idDisco = $idDisco;
        $this->idAutor = $idAutor;
    }

    function getIdDisco() {
        return $this->idDisco;
    }

    function getIdAutor() {
        return $this->idAutor;
    }

    function setIdDisco($idDisco) {
        $this->idDisco = $idDisco;
    }

    function setIdAutor($idAutor) {
        $this->idAutor = $idAutor;
    }

    public function __toString() {
        $r = '';
        foreach($this as $key => $valor) {
            $r .= "$key => $valor - ";
        }
        return $r;
    }
    
    function read(ObjectReader $reader = null){
        if($reader===null){
            $reader = 'Request';
        }
        foreach($this as $key => $valor) {
            $this->$key = $reader::read($key);
        }
    }
    
    function get(){
        $nuevoArray = array();
        foreach($this as $key => $valor) {
            $nuevoArray[$key] = $valor;
        }
        return $nuevoArray;
    }
    
    function set(array $array, $inicio = 0) {
        $this->idDisco = $array[0 + $inicio];
        $this->idAutor = $array[1 + $inicio];
    }
    
    function isValid() {
        if($this->idDisco === null || $this->idAutor === null ) {
            return false;
        }
        return true;
    }
    
}