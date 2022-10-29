<?php

class Company {
    
    private $id = 1;
    
    public function __construct() {
        
        if(!empty($_COOKIE['company_id'])) {
            
            $this->id = (int)$_COOKIE['company_id'];
            
        }
        
    }
    
    public function id() {
        
        return $this->id;
        
    }
    
}