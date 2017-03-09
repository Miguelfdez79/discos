<?php

class Autor {
    
    private $idAutor, $autor;
    
    function __construct($idAutor = null, $autor = null) {
        $this->idAutor = $idAutor;
        $this->autor = $autor;
    }
    
    function getIdAutor() {
        return $this->idAutor;
    }

    function getAutor() {
        return $this->autor;
    }

    function setIdAutor($idAutor) {
        $this->idAutor = $idAutor;
    }

    function setAutor($autor) {
        $this->autor = $autor;
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
        $this->idAutor = $array[0 + $inicio];
        $this->autor = $array[1 + $inicio];
    }
    
    function isValid() {
        if( $this->autor === null ) {
            return false;
        }
        return true;
    }

}