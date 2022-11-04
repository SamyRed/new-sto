<?php

class MakeRoute {
    
    private $routes;
    
    public function __construct() {
        
        $routesPath = ROOT . '/config/routes.php';
        $this->routes = include($routesPath);
        
    }
    
    public function makeRoute($params) {
        
        ob_start();
        
        $uri = $params['uri'];
        
        foreach($this->routes as $pattern => $path) {
            
            if(preg_match("~$pattern~", $uri)) {
                
                if($uri !== '' && $pattern === '') {
                    
                    $internalRoute = 'service/pageNotFound';
                    
                } else {
                
                    $internalRoute = preg_replace("~$pattern~", $path, $uri);
                    
                }
                
                $segments = explode('/', $internalRoute);
                
                $controllerName = ucfirst(array_shift($segments)) . 'Controller';
                $actionName = 'action' . ucfirst(array_shift($segments));
                $parameters = $segments;
                
                $controllerFile = ROOT . '/controller/' . $controllerName . '.php';
                
                if(file_exists($controllerFile)) {
                    
                    include_once($controllerFile);
                    
                }
                
                $controllerObj = new $controllerName;
                
                call_user_func_array(array($controllerObj, $actionName), array($parameters));
                
                break;
                
            }
            
        }
        
        $return['alert'] = Alert::get();
        $return['html'] = ob_get_clean();
        
        return json_encode($return);
        
    }
    
}