<?php

class Usuario {

    private $login, $password;
    
    function __construct($login=null, $password=null) {
        $this->login = $login;
        $this->password = $password;
    }
    
    function getLogin() {
        return $this->login;
    }

    function getPassword() {
        return $this->password;
    }

    function setLogin($login) {
        $this->login = $login;
    }

    function setPassword($password) {
        $this->password = $password;
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
        $this->login = $array[0 + $inicio];
        $this->password = $array[1 + $inicio];
    }
    
    function isValid() {
        if($this->login === null || $this->password === null ) {
            return false;
        }
        return true;
    }

}
