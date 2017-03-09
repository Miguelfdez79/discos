<?php

class ControllerUsuario extends Controller {
    
    function logout(){
        $this->getSession()->destroy();
        header('Location: index.php');
        exit();
    }
    
    function dologin() {
        $usuarioWeb = new Usuario();
        $usuarioWeb->read();
        
        $usuarioBD = $this->getModel()->getUsuario($usuarioWeb->getLogin());

        if( ( $usuarioWeb->getLogin() === $usuarioBD->getLogin() ) 
                && ($usuarioWeb->getPassword() === $usuarioBD->getPassword() ) ){
                    $this->getSession()->setUser($usuarioBD);
       
            header('Location: index.php?ruta=disco&accion=viewlistadiscos');
            exit();
        }
        
        $this->getSession()->destroy();
        $this->getModel()->addFile('loguear', Util::renderFile('template/html/logueado.html'));
        $this->getModel()->addFile('paginacion', Util::renderFile('template/html/paginacion-vacio.html'));
        return $this->getModel()->addFile('contenido', Util::renderFile('template/html/loguearse.html'));
    }
    
    function doinsert(){
        $usuario = new Usuario();
        $usuario->read();
        
        if( $usuario->isValid() ) {
            $this->getModel()->insertUsuario($usuario);
            header('Location: index.php?ruta=usuario&accion=viewusuario');
            exit();
        }
    }
    
    function doedit(){
        $usuario = new Usuario();
        $usuario->read();
        $loginpk = Request::get('loginpk');
        
        $this->getModel()->editUsuario($usuario, $loginpk);
        header('Location: index.php?ruta=usuario&accion=viewusuario');
        exit(); 
    }
    
    function dodelete(){
        $login = Request::get('login');
        
        $this->getModel()->deleteUsuario($login);
        
        header('Location: index.php?ruta=usuario&accion=viewusuario');
        exit();
    }
    
    
    /*  DIFERENTES VISTAS SEGUN ACCIONES */

    function viewusuario(){
        $pc = $this->getUsuarioPageController();
        $lista = $this->getModel()->getUsuarioPage($pc->getPage());
        
        $estructurahtml = '';
        
        $estructurahtml .= "<table class='tablaUsuarios'>
                    <tr>
		                <th>USUARIOS</th>
		                <th></th>
		                <th></th>
	                </tr>";
	    
        foreach($lista as $usuario){
            
            $estructurahtml .= "<tr>";
            $estructurahtml .= Util::renderFile( 'template/html/estructura_usuario.html', array( 'login' => $usuario->getLogin(), 'password' => $usuario->getPassword() ) );
            $estructurahtml .= "</tr>";
        }
        
        $estructurahtml .= "</table>";
        
        $this->getModel()->addFile('loguear', Util::renderFile('template/html/logueado.html'));
        $this->getModel()->addFile('aside', Util::renderFile('template/html/naV-usuario.html'));
        $this->getModel()->addData('contenido', $estructurahtml);
        //$this->getModel()->addFile('paginacion', Util::renderFile('template/html/paginacion.html'), array('primera' => $pc->getFirst(), 'anterior' => $pc->getPrevious(), 'siguiente' => $pc->getNext(), 'ultima'=> $pc->getPages() ));
    }
    
    function viewadd(){
        $this->getModel()->addFile('loguear', Util::renderFile('template/html/logueado.html'));
        $this->getModel()->addFile('aside', Util::renderFile('template/html/naV-usuario.html'));
        $this->getModel()->addFile('contenido', Util::renderFile('template/html/aniadirUsuario.html'));
        //$this->getModel()->addFile('paginacion', Util::renderFile('template/html/paginacion.html'));
    }
    
    function viewedit(){
        $login = Request::get('login');
        $password = Request::get('password');
        $this->getModel()->addFile('loguear', Util::renderFile('template/html/logueado.html'));
        $this->getModel()->addFile('aside', Util::renderFile('template/html/naV-usuario.html'));
        $this->getModel()->addFile('contenido', Util::renderFile('template/html/editUsuario.html', array('login' => $login, 'password' => $password ) ) );
        //$this->getModel()->addFile('paginacion', Util::renderFile('template/html/paginacion.html'));
    }
    
    
}