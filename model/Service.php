<?php

class Service {
    
    private static $title;
    private static $alerts = [];
    
    public function __construct() {
        
        
        
    }
    
    public static function setTitle($title) {
        
        self::$title = $title . ' - ' .  self::config()['title'];
        
    }
    
    public static function getTitle() {
        
        return self::$title;
        
    }
    
    public static function config() {
        
        $configPath = ROOT . '/config/config.php';
        $config = include($configPath);
        return $config;
        
    }
    
}