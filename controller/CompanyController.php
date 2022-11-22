<?php

include 'controller/ServiceController.php';

class CompanyController extends ServiceController {
    
    public function actionView($params = null) {
        
        Service::setTitle('View company');
        
        $user = new User();
        $company = new Company();
        $order = new Order();
        
        include_once ROOT . '/view/header.php';
        
        if($userArr = $user->get()) {
            
            if($companyArr = $company->get()) {
            
                $subPage = $params[0];
                include_once ROOT . '/view/company/view.php';

            }
        
        }
        
        include_once ROOT . '/view/footer.php';
        
    }
    
    public function actionReport($params = null) {
        
        Service::setTitle('Report');
        
        $user = new User();
        $company = new Company();
        $order = new Order();
        $storage = new Storage();
        
        include_once ROOT . '/view/header.php';
        
        if($userArr = $user->get()) {
            
            if($companyArr = $company->get()) {
        
                if(!empty($params[1])) {

                    $storageId = $params[1];

                    if($storageArr = $storage->get($storageId)) {

                        Service::setTitle('Storage report "' . $storageArr['title'] . '"');
                        $materialList = $storage->getMaterialList();
                        $permittedStorageList = $storage->permittedList();

                    }

                } else {

                    if($storageArr = $storage->get()) {

                        Service::setTitle('Storage report "' . $storageArr['title'] . '"');
                        $materialList = $storage->getMaterialList($storageArr['id']);
                        $permittedStorageList = $storage->permittedList();

                    }

                }
            
                $subPage = $params[0];
                include_once ROOT . '/view/company/report.php';

            } else {
            
                include_once ROOT . '/view/dialog/companyAdd.php';
                echo "
<script>$(window).on('load', function(){
$('#dialogCompanyAdd').modal('show');
});</script>";
            
            }
        
        }
        
        include_once ROOT . '/view/footer.php';
        
    }
    
}