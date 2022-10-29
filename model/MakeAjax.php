<?php

class MakeAjax {
    
    public function makeLoadContainer($params) {
        
        $return = array();
        $tags = preg_split("/(?=(?<![A-Z]|^)[A-Z])/", $params['content']); 
        $folder = array_shift($tags);
        $name = lcfirst(implode($tags));
        $filename = ROOT . "/view/$folder/$name.php";
        
        if(file_exists($filename)) {
            
            ob_start();
            include($filename);
            $return['alert'] = Alert::get();
            $return['html'] = ob_get_clean();
            
        } else {
            
            $return['html'] = '';
            $return['alert'][] = "{PAGE_NOT_FOUND} \"<b>$filename</b>\"";
            
        }
        
        return json_encode($return);
        
    }
    
    public function makeSendForm($params) {
        $return = array();
        $tags = preg_split("/(?=(?<![A-Z]|^)[A-Z])/", $params['script']);
        unset($params['script']);
        $className = ucfirst(array_shift($tags));
        $methodName = lcfirst(implode($tags));
        $controllerObject = new $className;
        
        $result = call_user_func_array(array($controllerObject, $methodName), array($params));
        
        $return['alert'] = Alert::get();
        
        return json_encode($return);
        
    }
    
}
