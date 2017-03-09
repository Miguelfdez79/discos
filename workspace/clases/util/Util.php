<?php

class Util {
    
    /**
    *
    * @password_hash($cadena, PASSWORD_DEFAULT, $opciones): Encripta la cadena
    * de texto que recibe la funcion encriptar(), realizando para la 
    * encriptacion tantas como vueltas como especifique $coste.
    * 
    */
    static function encriptar($cadena, $coste = 10) {
        $opciones = array(
            'cost' => $coste
        );
        return password_hash($cadena, PASSWORD_DEFAULT, $opciones);
    }
    
    /**
    *
    * Verifica que una clave se corresponde con otra clave encriptada mediaente
    * la funcion anterior.
    * 
    */
    static function verificarClave($claveSinEncriptar, $claveEncriptada){
        return password_verify($claveSinEncriptar, $claveEncriptada);
    }

    /**
    *
    * Investigar.
    * 
    */
    static function renderFile($file, array $data = array()) {
        if (!file_exists($file)) {
            echo 'Error: ' . $file . '<br>';
            return '';
        }
        $contenido = file_get_contents($file);
        return self::renderText($contenido, $data);
    }

    /**
    *
    * Introduce el contenido de $data en los placeholder {...} de $texto.
    * 
    */
    static function renderText($text, array $data = array()) {
        foreach ($data as $indice => $dato) {
            $text = str_replace('{' . $indice . '}', $dato, $text);
        }
        return $text;
    }
    
    static function getSelect($name, $parametros, $valorSeleccionado=null, $blanco=true, $atributos="", $email=null) {
        
        if($email !== null){
            $email = "email='$email'";
        }else{
            $email = "";
        }
        $r = "<select name='$name' $email $atributos>\n";
        
        //linea en blanco
        if($blanco === true){
            $r .= "<option value=''>&nbsp;</option>\n";
        }
        
        foreach ($parametros as $indice => $valor) {
            $seleted = "";
            if($valorSeleccionado !== null && $indice === $valorSeleccionado){
                $seleted = "selected";
            }
            $r .= "<option $seleted value='$indice'>$valor</option>\n";
        }
        $r .= "</select>\n";
        return $r;
    }
}