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
    
    public function getList() {
        
        $alertList = new Alert();
        $company = new Company();
        $return = array();
        
        if($companyArr = $company->get()) {
            
            try {
                
                $db = DB::getConnection();
                
                $result = $db->prepare("SELECT u.email as email, u.name as name, w.date as date, p.title as position_title "
                        . "FROM _worker as w "
                        . "INNER JOIN _user as u "
                        . "INNER JOIN _position as p "
                        . "WHERE w.company_id = :companyId AND w.user_id = u.id AND p.id = w.position_id");
                $result->execute(array(
                    
                    ':companyId' => $companyArr['id']
                    
                ));
                
                if($result->rowCount() > 0) {
                    
                    $return = $result->fetchAll(PDO::FETCH_ASSOC);
                    
                }
                
            } catch(PDOException $e) {
                
                $alertList->push('danger', '<b>PDO Error!</b> ' . htmlspecialchars($e));
                
            }
            
        } else {
            
            $alertList->push('danger', '{COMPANY_NOT_FOUND}');
            
        }
        
        return $return;
        
    }
    
    public function havePermission($permission) {
        
        $alertList = new Alert();
        $return = false;
        
        if($workerArr = $this->get()) {
            
            try {
                
                $db = DB::getConnection();
                $result = $db->prepare("SELECT p.value FROM _permission_list as p INNER JOIN _permission_default as d WHERE d.service_title = :title AND p.value = 1 AND p.permission_id = d.id");
                $result->execute(array(
                    
                    ':title' => $permission
                    
                ));
                
                if($result->rowCount() > 0) {
                    
                    $return = true;
                    
                }
                
            } catch(PDOException $e) {
                
                $alertList->push('danger', '<b>PDO Error!</b> ' . htmlspecialchars($e));
                
            }
            
        } else {
            
            $alertList->push('danger', '{WORKER_NOT_FOUND}');
            
        }
        
        return $return;
        
    }
    
}