<?php

include 'controller/ServiceController.php';

class OrderController extends ServiceController {
    
    /**
     * The list of all orders
     */
    public function actionList($params = null) {
        
        Service::setTitle('List of orders');
        
        include_once ROOT . '/view/header.php';
        include_once ROOT . '/view/order/list.php';
        include_once ROOT . '/view/footer.php';
        
    }
    
    public function actionView($params = null) {
        
        Service::setTitle('View order');
        $subPage = $params[0];
        $order = new Order();
        $order->id($params[1]);
        
        include_once ROOT . '/view/header.php';
        include_once ROOT . '/view/order/view.php';
        include_once ROOT . '/view/footer.php';
        
    }
    
}