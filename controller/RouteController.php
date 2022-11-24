<?php
include ROOT . '/model/MakeRoute.php';

class RouteController {
    
    public static function actionMakeRoute() {
        
        $actionName = $_POST['action'];
        $params = $_POST;
        
        unset($params['action']);
        $methodName = 'make'.ucfirst($actionName);
        $controllerObject = new MakeRoute();
        $result = call_user_func_array(array($controllerObject, $methodName), array($params));
        
        echo $result;
        
        return true;
    }
}