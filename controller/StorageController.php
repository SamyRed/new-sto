<?php

include 'controller/ServiceController.php';

class StorageController extends ServiceController {
    
    public static function actionMaterials() {
        
        Service::setTitle('List of orders');
        
        include_once ROOT . '/view/header.php';
        include_once ROOT . '/view/storage/materials.php';
        include_once ROOT . '/view/footer.php';
        
    }
    
}