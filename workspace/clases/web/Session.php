<?php

class Session {

    private static $instancia = null;

    private function __construct() {
    }

    function close() {
        $this->delete("_usuario");
    }

    function delete($nombre) {
        if (isset($_SESSION[$nombre])) {
            unset($_SESSION[$nombre]);
        }
    }

    function destroy() {
        session_destroy();
    }

    function get($nombre) {
        if (isset($_SESSION[$nombre])) {
            return $_SESSION[$nombre];
        }
        return null;
    }

    static function getInstance($nombre = null) {
        if (self::$instancia === null) {
            if ($nombre !== null) {
                session_name($nombre);
            }
            session_start();
            self::$instancia = new Session();
        }
        return self::$instancia;
    }
    
    function getUser() {
        return $this->get("_usuario");
    }

    function isLogged() {
        return $this->getUser() !== null;
    }

    function sendRedirect($destino = "index.php") {
        header("Location: $destino");
        exit();
    }

    function set($nombre, $valor) {
        $_SESSION[$nombre] = $valor;
    }

    function setUser($usuario) {
        $this->set("_usuario", $usuario);
    }

}