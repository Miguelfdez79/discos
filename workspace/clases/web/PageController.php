<?php

class PageController {

    private $page, $rpp, $total;
    
    function __construct($total, $page = 1, $rpp = 16) {
        if($page === null){
            $page = 1;
        }
        $this->total = $total;
        $this->page = $page;
        $this->rpp = $rpp;
    }
    
    function getPages() {
        return ceil($this->total / $this->rpp);
    }
    
    function getPage() {
        if($this->page > $this->getPages() || $this->page < 1){
            $this->page = 1;
        }
        return $this->page;
    }
    
    function getPrevious() {
        return max($this->getPage() - 1, 1);
    }
    
    function getNext() {
        return min($this->getPage() + 1, $this->getPages());
    }
    
    function getFirst() {
        return 1;
    }
    
    function setRpp($rpp) {
        $this->rpp = $rpp;
    }

}