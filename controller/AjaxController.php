<?php

include 'controller/ServiceController.php';

class AjaxController extends ServiceController {
    
    public static function actionMakeAjax() {
        
        $actionName = $_POST['action'];
        $params = $_POST;
        
        unset($params['action']);
        $methodName = 'make'.ucfirst($actionName);
        $controllerObject = new MakeAjax();
        $result = call_user_func_array(array($controllerObject, $methodName), array($params));
        
        echo $result;
        
        return true;
    }
}