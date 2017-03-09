<?php

class Model {

    private $data = array();
    private $file = array();

    function __construct() {
    }
    
    function getText(){
        return $this->text;
    }
    
    function setText($text){
        $this->text = $text;
    }

    function addData($name, $data) {
        $this->data[$name] = $data;
    }

    function addFile($name, $file) {
        $this->data[$name] = $file;
    }

    function getData() {
        return $this->data;
    }
    
    function getFile() {
        return $this->file;
    }

}