<?php

include 'controller/ServiceController.php';

class OrderController extends ServiceController {
    
    /**
     * The list of all orders
     */
    public function actionList($params = null) {
        
        Service::setTitle('List of orders');
        
        $user = new User();
        $company = new Company();
        
        include_once ROOT . '/view/header.php';
        
        if($user->get()) {
            
            if($companyArr = $company->get()) {
            
                include_once ROOT . '/view/order/list.php';
                
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
    
    public function actionView($params = null) {
        
        Service::setTitle('View order');
        
        $user = new User();
        $company = new Company();
        $order = new Order();
        $order->set($params[1]);
        $orderArr = $order->get();
        
        include_once ROOT . '/view/header.php';
        
        if($userArr = $user->get()) {
            
            if($companyArr = $company->get()) {
            
                $subPage = $params[0];
                include_once ROOT . '/view/order/view.php';

            }
        
        } else {
            
            include_once ROOT . '/view/table/orderMaterialList.php';
            
        }
        
        include_once ROOT . '/view/footer.php';
        
    }
    
}