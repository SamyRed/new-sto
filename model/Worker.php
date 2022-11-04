<?php

class Worker {
    
    public function __construct() {
        
        
        
    }
    
    public function get(int $id = null) {
        
        $user = new User();
        
        if($id !== null) {
            
            try {
                
                $db = DB::getConnection();
                
                $result = $db->prepare("SELECT * FROM _worker WHERE id = :id");
                $result->execute(array(
                    
                    ':id' => $id
                    
                ));
                
                if($result->rowsCount() > 0) {

                    $workerArr = $result->fetch(PDO::FETCH_ASSOC);

                    $return = $workerArr;
                    
                } else {
                    
                    $return = false;
                    
                }
                
            } catch(PDOException $e) {
                
                $return = false;
                
            }
            
        } else {
        
            try {

                $db = DB::getConnection();

                $result = $db->prepare("SELECT * FROM _worker WHERE user_id = :userId");
                $result->execute(array(

                    ':userId' => $user->get()['id']

                ));
                
                if($result->rowCount() > 0) {
                    
                    $workerArr = $result->fetch(PDO::FETCH_ASSOC);
                    $return = $workerArr;
                    
                } else {
                    
                    $return = false;
                    
                }

            } catch(PDOException $e) {

                $return = false;
                
            }
            
        }
        
        return $return;
        
    }
    
}