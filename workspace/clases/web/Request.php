<?php

/**
* Class Request
*
* Esta clase proporciona el acceso a los valores
* que nos llegan a través de la petición (request).
* @version 0.98
* @author izv
* @license http://...
*
*/

class Request implements ObjectReader {

    private static function _getValue($valor, $filtrar = true){
        $valor = trim($valor);//quitar espacios en blanco iniciales y finales
        if($valor === '') {
            $valor = null;//si es la cadena vacía, nos quedamos con el valor null
        }
        if($filtrar === true) {//filtramos cuando interesa
            $valor = htmlspecialchars($valor);
        }
        return $valor;
    }

    private static function _read($valorSinFiltrar, $filtrar = true){
        $valor = null;
        if(is_array($valorSinFiltrar)) {
            $valor = array(); //$valor = [];
            foreach ($valorSinFiltrar as $value) {
                $valor[] = self::_getValue($value, $filtrar);
            }
        } else {
            $valor = self::_getValue($valorSinFiltrar, $filtrar);
        }
        return $valor;
    }

    /**
    * Lee la variable cuyo nombre se pasa como parámetro de la petición GET.
    * @access public
    * @param string $nombre Nombre del parámetro que se quiere leer.
    * @param boolean $filtrar Indica si quiero filtrar la entrada.
    * @return string Valor del parámetro leido, null, si no ha llegado.
    */
    static function get($nombre, $filtrar = true) {
        $valor = null;
        if(isset($_GET[$nombre])) {
            $valor = self::_read($_GET[$nombre], $filtrar);
        }
        return $valor;
    }
    
    /**
    * Lee la variable cuyo nombre se pasa como parámetro de la petición POST.
    * @access public
    * @param string $nombre Nombre del parámetro que se quiere leer.
    * @param boolean $filtrar Indica si quiero filtrar la entrada.
    * @return string Valor del parámetro leido, null, si no ha llegado.
    */
    static function post($nombre, $filtrar = true) {
        $valor = null;
        if(isset($_POST[$nombre])) {
            $valor = self::_read($_POST[$nombre], $filtrar);
        }
        return $valor;
    }
    
    /**
    * Lee la variable cuyo nombre se pasa como parámetro de la petición.
    * @access public
    * @param string $nombre Nombre del parámetro que se quiere leer.
    * @param boolean $filtrar Indica si quiero filtrar la entrada.
    * @return string Valor del parámetro leido, null, si no ha llegado.
    */
    static function read($nombre, $filtrar = true) {
        $valor = self::post($nombre, $filtrar);
        if($valor === null){
            $valor = self::get($nombre, $filtrar);
        }
        return $valor;
    }
}