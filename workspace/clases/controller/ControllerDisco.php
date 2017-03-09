<?php

class ControllerDisco extends Controller {
    
    function doinsert(){
        $disco = new Disco();
        $disco->read();
        
        $autor = new Autor();
        $autor->read();
        
        $discoAutor = new DiscoAutor();
        $discoAutor->read();
        
        if( $disco->isValid() && $autor->isValid() ) {
            $d = $this->getModel()->insertDisco($disco);
            $a = $this->getModel()->insertAutor($autor);
            
            $discoAutor->setIdDisco($d);
            $discoAutor->setIdAutor($a);
            $this->getModel()->insertDiscoAutor($discoAutor);
            
            $img = new FileUpload('path');
            $img->setDestino("portadas/");
            $img->setTamano(9000000);
            $img->setNombre($d);
            
            $re = $img->upload();
            
            return self::viewlistadiscos();
        }
    }
    
    function doedit(){
        $disco = new Disco();
        $disco->read();
        
        $autor = new Autor();
        $autor->read();
        
        $this->getModel()->editDisco($disco);
        $this->getModel()->editAutor($autor);
        
        $img = new FileUpload('path');
        $img->setDestino("portadas/");
        $img->setTamano(9000000);
        $img->setNombre( $disco->getIdDisco() );
        
        $nombre_fichero = $img->getNombre();
        $dir = 'portadas/'.$nombre_fichero.'.jpg';
        
        if(file_exists($dir)){
            unlink($dir);
        }
        $re = $img->upload();
        
        header('Location: index.php?ruta=disco&accion=viewlistadiscos');
        exit(); 
    }
    
    function dodelete(){
        $idDisco = Request::get('idDisco');
        $idAutor = Request::get('idAutor');
        
        $this->getModel()->deleteDiscoAutor($idDisco, $idAutor);
        $this->getModel()->deleteDisco($idDisco);
        $this->getModel()->deleteAutor($idAutor);
        
        header('Location: index.php?ruta=disco&accion=viewlistadiscos');
        exit(); 
    }


    /*  ==================VISTAS ======================== */
    
    function viewdisco(){
        $idDisco = Request::get('idDisco');
        $idAutor = Request::get('idAutor');
        
        $disco = $this->getModel()->getDisco($idDisco);
        $autor = $this->getModel()->getAutor($idAutor);
        
        $nombre_fichero = $idDisco;
        $dir = 'portadas/'.$nombre_fichero.'.jpg';

        if( file_exists($dir) ){
            $img = $dir;
        }else{
            $img = 'portadas/default.png';
        }
        
        $estructurahtml = Util::renderFile( 'template/html/verDisco.html' , array( 'idDisco' => $disco->getIdDisco(), 'title' => $disco->getTitle(), 'autor' => $autor->getAutor(), 'img' => $img ));
        
        
        if($this->getSession()->isLogged()){
            $this->getModel()->addFile('loguear', Util::renderFile('template/html/logueado.html'));
            $this->getModel()->addFile('aside', Util::renderFile('template/html/naV-usuario.html'));
        } else {
             $this->getModel()->addFile('loguear', Util::renderFile('template/html/des.html'));
            $this->getModel()->addFile('aside', Util::renderFile('template/html/naV-visitante.html'));
        }
        $this->getModel()->addData('contenido', $estructurahtml);
        $this->getModel()->addFile('paginacion', Util::renderFile('template/html/paginacion-vacio.html'));
    }


    function viewlistadiscos(){
        
        $pc = $this->getDiskPageController();
        $lista = $this->getModel()->getDiscos($pc->getPage());
        
        $estructurahtml = '';
	    
        foreach($lista as $disco){
            
            $disco_autor = $this->getModel()->getDisco_DiscoAutores( $disco->getIdDisco() );
            foreach($disco_autor as $dis){
                $autor = $this->getModel()->getAutor( $dis->getIdAutor() );
            }
            
            
            $nombre_fichero = $disco->getIdDisco();
            $dir = 'portadas/'.$nombre_fichero.'.jpg';

            if( file_exists($dir) ){
                $img = $dir;
            }else{
                $img = 'portadas/default.png';
            }

            if($this->getSession()->isLogged()){
                $this->getModel()->addFile('loguear', Util::renderFile('template/html/logueado.html'));
                $estructurahtml .= Util::renderFile( 'template/html/estructura_discos.html', array( 'idDisco' => $disco->getIdDisco(), 'idAutor' => $autor->getIdAutor(), 'title' => $disco->getTitle(), 'autor' => $autor->getAutor(), 'img' => $img ) );
            } else {
                $this->getModel()->addFile('loguear', Util::renderFile('template/html/deslogueado.html'));
                $estructurahtml .= Util::renderFile( 'template/html/estructura_discos2.html', array( 'idDisco' => $disco->getIdDisco(), 'idAutor' => $autor->getIdAutor(), 'title' => $disco->getTitle(), 'autor' => $autor->getAutor(), 'img' => $img ) );
            }

        }
        
        if($this->getSession()->isLogged()){
            $this->getModel()->addFile('loguear', Util::renderFile('template/html/logueado.html'));
            $this->getModel()->addFile('aside', Util::renderFile('template/html/naV-usuario.html'));
        } else {
            $this->getModel()->addFile('loguear', Util::renderFile('template/html/deslogueado.html'));
            $this->getModel()->addFile('aside', Util::renderFile('template/html/naV-visitante.html'));
        }
        $this->getModel()->addData('contenido', $estructurahtml);
        $this->getModel()->addFile('paginacion', Util::renderFile('template/html/paginacion.html', array('primera' => $pc->getFirst(), 'anterior' => $pc->getPrevious(), 'siguiente' => $pc->getNext(), 'ultima'=> $pc->getPages() ) ));
    }
    
    
    function viewlistadiscosTitulo(){
        
        $pc = $this->getDiskPageController();
        $lista = $this->getModel()->getDiscosPorTitulo($pc->getPage());
        
        $estructurahtml = '';
	    
        foreach($lista as $disco){
            
            $disco_autor = $this->getModel()->getDisco_DiscoAutores( $disco->getIdDisco() );
            foreach($disco_autor as $dis){
                $autor = $this->getModel()->getAutor( $dis->getIdAutor() );
            }
            
            $nombre_fichero = $disco->getIdDisco();
            $dir = 'portadas/'.$nombre_fichero.'.jpg';

            if( file_exists($dir) ){
                $img = $dir;
            }else{
                $img = 'portadas/default.png';
            }

            if($this->getSession()->isLogged()){
                $estructurahtml .= Util::renderFile( 'template/html/estructura_discos.html', array( 'idDisco' => $disco->getIdDisco(), 'idAutor' => $autor->getIdAutor(), 'title' => $disco->getTitle(), 'autor' => $autor->getAutor(), 'img' => $img ) );
            } else {
                $estructurahtml .= Util::renderFile( 'template/html/estructura_discos2.html', array( 'idDisco' => $disco->getIdDisco(), 'idAutor' => $autor->getIdAutor(), 'title' => $disco->getTitle(), 'autor' => $autor->getAutor(), 'img' => $img ) );
            }
        }
        
        if($this->getSession()->isLogged()){
            $this->getModel()->addFile('loguear', Util::renderFile('template/html/logueado.html'));
            $this->getModel()->addFile('aside', Util::renderFile('template/html/naV-usuario.html'));
        } else {
            $this->getModel()->addFile('loguear', Util::renderFile('template/html/deslogueado.html'));
            $this->getModel()->addFile('aside', Util::renderFile('template/html/naV-visitante.html'));
        }
        $this->getModel()->addData('contenido', $estructurahtml);
        $this->getModel()->addFile('paginacion', Util::renderFile('template/html/paginacion.html', array('primera' => $pc->getFirst(), 'anterior' => $pc->getPrevious(), 'siguiente' => $pc->getNext(), 'ultima'=> $pc->getPages() ) ));
    }
    
    
    function viewlistadiscosAutor(){
        
        $pc = $this->getDiskPageController();
        $lista = $this->getModel()->getDiscosPorAutor($pc->getPage());
        
        $estructurahtml = '';
	    
        foreach($lista as $autor){
            $disco_autor = $this->getModel()->getAutor_DiscoAutores( $autor->getIdAutor() );
            foreach($disco_autor as $dis){
                $disco = $this->getModel()->getDisco( $dis->getIdDisco() );
            }
            
            $nombre_fichero = $disco->getIdDisco();
            $dir = 'portadas/'.$nombre_fichero.'.jpg';

            if( file_exists($dir) ){
                $img = $dir;
            }else{
                $img = 'portadas/default.png';
            }

            if($this->getSession()->isLogged()){
                $this->getModel()->addFile('loguear', Util::renderFile('template/html/logueado.html'));
                $estructurahtml .= Util::renderFile( 'template/html/estructura_discos.html', array( 'idDisco' => $disco->getIdDisco(), 'idAutor' => $autor->getIdAutor(), 'title' => $disco->getTitle(), 'autor' => $autor->getAutor(), 'img' => $img ) );
            } else {
                $this->getModel()->addFile('loguear', Util::renderFile('template/html/deslogueado.html'));
                $estructurahtml .= Util::renderFile( 'template/html/estructura_discos2.html', array( 'idDisco' => $disco->getIdDisco(), 'idAutor' => $autor->getIdAutor(), 'title' => $disco->getTitle(), 'autor' => $autor->getAutor(), 'img' => $img ) );
            }
        }
        
        if($this->getSession()->isLogged()){
            $this->getModel()->addFile('loguear', Util::renderFile('template/html/logueado.html'));
            $this->getModel()->addFile('aside', Util::renderFile('template/html/naV-usuario.html'));
        } else {
            $this->getModel()->addFile('loguear', Util::renderFile('template/html/deslogueado.html'));
            $this->getModel()->addFile('aside', Util::renderFile('template/html/naV-visitante.html'));
        }
        $this->getModel()->addData('contenido', $estructurahtml);
        $this->getModel()->addFile('paginacion', Util::renderFile('template/html/paginacion.html', array('primera' => $pc->getFirst(), 'anterior' => $pc->getPrevious(), 'siguiente' => $pc->getNext(), 'ultima'=> $pc->getPages() ) ));
    }
    
    
    
    function viewsearch(){
        $campo = Request::get('search');
        $radio = Request::get('radio');
        
        if($radio == 'titulo'){
            $pc = $this->getDiskPageController();
            $lista = $this->getModel()->searchTitulo($pc->getPage(), $campo);
        } else {
            $pc = $this->getDiskPageController();
            $lista = $this->getModel()->searchAutor($pc->getPage(), $campo); 
        }
        
        $estructurahtml = '';
	    
        if($radio == 'titulo'){
    	   foreach($lista as $disco){
                
                $disco_autor = $this->getModel()->getDisco_DiscoAutores( $disco->getIdDisco() );
                foreach($disco_autor as $dis){
                    $autor = $this->getModel()->getAutor( $dis->getIdAutor() );
                }
                
                $nombre_fichero = $disco->getIdDisco();
                $dir = 'portadas/'.$nombre_fichero.'.jpg';
    
                if( file_exists($dir) ){
                    $img = $dir;
                }else{
                    $img = 'portadas/default.png';
                }
    
                if($this->getSession()->isLogged()){
                    $estructurahtml .= Util::renderFile( 'template/html/estructura_discos.html', array( 'idDisco' => $disco->getIdDisco(), 'idAutor' => $autor->getIdAutor(), 'title' => $disco->getTitle(), 'autor' => $autor->getAutor(), 'img' => $img ) );
                } else {
                    $estructurahtml .= Util::renderFile( 'template/html/estructura_discos2.html', array( 'idDisco' => $disco->getIdDisco(), 'idAutor' => $autor->getIdAutor(), 'title' => $disco->getTitle(), 'autor' => $autor->getAutor(), 'img' => $img ) );
                }
            
            }
        }else{
            foreach($lista as $autor){
                $disco_autor = $this->getModel()->getAutor_DiscoAutores( $autor->getIdAutor() );
                foreach($disco_autor as $dis){
                    $disco = $this->getModel()->getDisco( $dis->getIdDisco() );
                }
                
                $nombre_fichero = $disco->getIdDisco();
                $dir = 'portadas/'.$nombre_fichero.'.jpg';
    
                if( file_exists($dir) ){
                    $img = $dir;
                }else{
                     $img = 'portadas/default.jpg';
                }
    
                if($this->getSession()->isLogged()){
                    $this->getModel()->addFile('loguear', Util::renderFile('template/html/logueado.html'));
                    $estructurahtml .= Util::renderFile( 'template/html/estructura_discos.html', array( 'idDisco' => $disco->getIdDisco(), 'idAutor' => $autor->getIdAutor(), 'title' => $disco->getTitle(), 'autor' => $autor->getAutor(), 'img' => $img ) );
                } else {
                    $this->getModel()->addFile('loguear', Util::renderFile('template/html/deslogueado.html'));
                    $estructurahtml .= Util::renderFile( 'template/html/estructura_discos2.html', array( 'idDisco' => $disco->getIdDisco(), 'idAutor' => $autor->getIdAutor(), 'title' => $disco->getTitle(), 'autor' => $autor->getAutor(), 'img' => $img ) );
                }
            }
        }
        
        if($this->getSession()->isLogged()){
            $this->getModel()->addFile('loguear', Util::renderFile('template/html/logueado.html'));
            $this->getModel()->addFile('aside', Util::renderFile('template/html/naV-usuario.html'));
        } else {
            $this->getModel()->addFile('loguear', Util::renderFile('template/html/deslogueado.html'));
            $this->getModel()->addFile('aside', Util::renderFile('template/html/naV-visitante.html'));
        }
        $this->getModel()->addData('contenido', $estructurahtml);
        $this->getModel()->addFile('paginacion', Util::renderFile('template/html/paginacion.html', array('primera' => $pc->getFirst(), 'anterior' => $pc->getPrevious(), 'siguiente' => $pc->getNext(), 'ultima'=> $pc->getPages() ) ));
        
    }
    
    
    
    function viewadd(){
        $this->getModel()->addFile('loguear', Util::renderFile('template/html/logueado.html'));
        $this->getModel()->addFile('aside', Util::renderFile('template/html/naV-usuario.html'));
        $this->getModel()->addFile('contenido', Util::renderFile('template/html/aniadirDiscos.html'));
        $this->getModel()->addFile('paginacion', Util::renderFile('template/html/paginacion-vacio.html'));
    }
    
    
    
    function viewedit(){
        
        $idDisco = Request::get('idDisco');
        $idAutor = Request::get('idAutor');
        $title = Request::get('title');
        $autor = Request::get('autor');
        $this->getModel()->addFile('loguear', Util::renderFile('template/html/logueado.html'));
        $this->getModel()->addFile('aside', Util::renderFile('template/html/naV-usuario.html'));
        $this->getModel()->addFile('contenido', Util::renderFile('template/html/editDiscos.html', array('idDisco' => $idDisco, 'idAutor' => $idAutor, 'title' => $title, 'autor' => $autor ) ) );
        $this->getModel()->addFile('paginacion', Util::renderFile('template/html/paginacion-vacio.html'));
    }
    
}