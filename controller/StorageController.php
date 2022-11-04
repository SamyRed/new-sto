<?php

include 'controller/ServiceController.php';

class StorageController extends ServiceController {
    
    public static function actionView($params = null) {
         
        Service::setTitle('List of orders');
        $user = new User();
        $storage = new Storage();
        $materialList = $storage->getMaterialList();
        
        if(!empty($params)) {
            
            $storage->set($params[0]);

        }

        include_once ROOT . '/view/header.php';
        if($user->get() !== false) {
            
            include_once ROOT . '/view/storage/view.php';
            
        } else {
            
            include_once ROOT . '/view/dialog/logIn.php';
            echo "
<script>$(window).on('load', function(){
$('#dialogLogIn').modal('show');
});</script>";
            
        }
        
        include_once ROOT . '/view/footer.php';
        
    }
    
}