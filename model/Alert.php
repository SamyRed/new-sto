<?php

class Alert {
    
    public static function push($type, $text) {
        
        $alert = '<div class="alert alert-' . htmlspecialchars($type) . '">' . $text . '</div>';
        $_SESSION['alert'][] = $alert;
        
        return true;
        
    }
    
    public static function empty() {
        if(empty($_SESSION['alert'])) {
            
            return true;
            
        } else {
            
            return false;
            
        }
    }
    
    public static function get() {
        
        if(!empty($_SESSION['alert'])) {
        
            $alertList = $_SESSION['alert'];
            $_SESSION['alert'] = array();
        
        } else {
            
            $alertList = [];
            
        }
        
        return $alertList;
        
    }
    
    public static function show() {
        
        if(!self::empty()) {
            
            $alertList = $_SESSION['alert'];
            $_SESSION['alert'] = array();
        
            foreach($alertList as $alert) {
                
                echo $alert;
                
            }
            
        }
        
        return true;
        
    }
    
}