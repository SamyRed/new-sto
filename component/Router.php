<?php

class Router {
    
    private $routes;
    
    public function __construct() {
        
        $routesPath = ROOT . '/config/routes.php';
        $this->routes = include($routesPath);
        
    }
    
    /**
     * Returns request string
     * @return string
     */    
    private function getURI() {
        
        if(!empty($_SERVER['REQUEST_URI'])) {
            
            return trim($_SERVER['REQUEST_URI'], '/');
            
        }
        
    }
    
    /**
     * Run router
     */
    public function route() {
        
        $uri = $this->getURI();
        
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
        
    }
    
}