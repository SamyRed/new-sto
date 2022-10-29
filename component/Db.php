<?php

class Db {
    
    public static function getConnection() {
        $paramsPath = ROOT . '/config/db_params.php';
        $params = include($paramsPath);
        $db = new PDO(
                "mysql:host={$params['host']};dbname={$params['dbname']}",
                $params['user'],
                $params['password']);
        
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
        return $db;
    }
}