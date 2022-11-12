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
    
}