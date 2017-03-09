<?php

class FileUpload {

    private $destino="./", $nombre="null", $tamano=1000000, $parametro;
    private $error = false, $politica = self::RENOMBRAR;
    const CONSERVAR = 1, REEMPLAZAR = 2, RENOMBRAR = 3; 
    
    private $arrayDeTipos =array(
        "jpg"=>1,
        "gif"=>1,
        "png"=>1,
        "jpeg"=>1
        );
    private $extension;
    
    function __construct($parametro) {
        if(isset($_FILES[$parametro]) && $_FILES[$parametro]["name"]!=="" ){
            $this -> parametro = $parametro;
            $nombre = $_FILES[$this->parametro]["name"];
            $trozos = pathinfo($nombre);
            $extension = $trozos["extension"];
            $this->nombre = $trozos["filename"];
            $this->extension =  $extension;
        }else{
            $this->error=true;
        }
    }

    
    public function getDestino() {
        return $this->destino;
    }

    public function getNombre() {
        return $this->nombre;
    } 

    public function getTamano() {
        return $this->tamano;
    }
    
    public function getPolitica() {
        return $this->politica;
    }

    public function setDestino($destino) {
        $this->destino = $destino;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setTamano($tamano) {
        $this->tamano = $tamano;
    }
    
    public function setPolitica($politica) {
        $this->politica = $politica;
    }
   
    public function upload(){
        if($this->error){
            return false;
        }
        if($_FILES[$this->parametro]["error"]!=UPLOAD_ERR_OK){
            return false;
        }
        if($_FILES[$this->parametro]["size"]>$this->tamano){
            return false;
        }
        
        if(!$this->isTipo($this->extension)){
            return false;
        }
        
        if(!(is_dir($this->destino) && substr($this->destino, -1) === "/")){
            return false;
        }
        
        if($this->politica === self::CONSERVAR 
                && file_exists($this->destino.$this->nombre.".".$this->extension)){
            return false;
        }
        $nombre = $this->nombre;
        if($this->politica === self::RENOMBRAR
                && file_exists($this->destino.$this->nombre.".".$this->extension)){
            $nombre = $this->renombrar($nombre);
        }
        
        return move_uploaded_file($_FILES[$this->parametro]["tmp_name"], 
                $this->destino.$nombre.".".$this->extension);
    }
    
    private function renombrar($nombre){
        $i=1;
        while(file_exists($this->destino.$nombre."_".$i.".".$this->extension)){
            $i++;
        }
        return $nombre . "_" . $i;
    }
    
    public function addTipo($tipo){
        if(!$this->isTipo($tipo)){
             $this->arrayDeTipos[$tipo]=1;
            return true;
        }
        return false;   
    }
    
    public function removeTipo($tipo){
        if($this->isTipo($tipo)){
            unset($this->arrayDeTipos[$tipo]);
            return true;
        }
        return false;
    }
    
    public function isTipo($tipo){
        return isset($this->arrayDeTipos[$tipo]);
    }
    
    function getExtension(){
        return $this->extension;
    }

}