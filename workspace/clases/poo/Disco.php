<?php

class Disco{
    private $idDisco, $title;
    
    function __construct($idDisco=null, $title=null) {
        $this->idDisco = $idDisco;
        $this->title = $title;
    }

    function getIdDisco() {
        return $this->idDisco;
    }

    function getTitle() {
        return $this->title;
    }

    function setIdDisco($idDisco) {
        $this->idDisco = $idDisco;
    }

    function setTitle($title) {
        $this->title = $title;
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
        $this->title = $array[1 + $inicio];
    }
    
    function isValid() {
        if( $this->title === null ) {
            return false;
        }
        return true;
    }

}