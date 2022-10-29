<?php

include 'model/Service.php';
include 'model/MakeAjax.php';
include 'model/Order.php';
include 'model/Alert.php';
include 'model/Company.php';

class ServiceController {
    
    public function __construct() {
        
        
        
    }
    
    public function actionPageNotFound() {
        
        Service::setTitle('Page not found!');
        
        include_once ROOT . '/view/header.php';
        include_once ROOT . '/view/pageNotFound.php';
        include_once ROOT . '/view/footer.php';
        
    }
    
}