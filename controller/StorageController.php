<?php

include 'controller/ServiceController.php';

class StorageController extends ServiceController {
    
    public static function actionView($params = null) {
         
        Service::setTitle('Storage');
        
        $user = new User();
        $storage = new Storage();
        $company = new Company();

        include_once ROOT . '/view/header.php';
        
        if($user->get()) {
            
            if($companyArr = $company->get()) {
        
                if(!empty($params[0])) {

                    $storage->set($params[0]);

                }
                
                $permittedStorageList = $storage->permittedList();
            
                    include_once ROOT . '/view/storage/view.php';
                
            } else {
            
                include_once ROOT . '/view/dialog/companyAdd.php';
                echo "
<script>$(window).on('load', function(){
$('#dialogCompanyAdd').modal('show');
});</script>";
            
            }
            
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