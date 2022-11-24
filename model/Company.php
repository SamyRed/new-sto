<?php

class Company {
    
    private $id = 1;
    
    public function __construct() {
        
        
        
    }
    
    public function get($id = null) {
        
        $alertList = new Alert();
        $user = new User();
        
        if($id !== null) {
            
            $companyId = $id;
            
        } else {
        
            if(!empty($_SESSION['company_id'])) {

                $companyId = $_SESSION['company_id'];
                
            } else {
                
                $companyId = null;
                
            }
            
        }
        
        if($companyId !== null) {
            
            try {
                
                $db = DB::getConnection();
                $result = $db->prepare("SELECT * FROM _company WHERE id = :id");
                $result->execute(array(
                    
                    ':id' => $companyId
                    
                ));
                
                if($result->rowCount() > 0) {
                    
                    $companyArr = $result->fetch(PDO::FETCH_ASSOC);
                    $return = $companyArr;
                    
                } else {
                    
                    $return = false;
                    
                }
                
            } catch(PDOException $e) {
                
                $return = false;
                $alertList::push('danger', '<b>PDO Error!</b>' . htmlspecialchars($e));
                
            }
            
        } else {
            
            try {
                
                if($userArr = $user->get()) {
                    
                    $db = DB::getConnection();
                    $result = $db->prepare("SELECT * FROM _company WHERE user_id = :userId OR JSON_CONTAINS(access_users, :userId, '$')");
                    $result->execute(array(

                        ':userId' => $userArr['id']

                    ));

                    if($result->rowCount() > 0) {

                        $companyArr = $result->fetch(PDO::FETCH_ASSOC);
                        $this->set($companyArr['id']);
                        $return = $companyArr;

                    } else {

                        $return = false;

                    }
                    
                } else {
                    
                    $return = false;
                    
                }
                
            } catch(PDOException $e) {
                
                $return = false;
                $alertList::push('danger', '<b>PDO Error!</b>' . htmlspecialchars($e));
                
            }
            
        }
        
        return $return;
        
    }
    
    public function set($id) {
        
        try {
            
            $db = DB::getConnection();
            
            $query = $db->prepare("SELECT count(*) FROM _company WHERE id = :id");
            $query->execute(array(
                
                ':id' => $id
                
            ));
            
            if($query->rowCount() > 0) {
                
                $_SESSION['company_id'] = $id;
                $return = true;
                
            } else {
                
                $return = false;
                
            }
            
        } catch(PDOException $e) {
            
            $return = false;
            
        }
        
        return $return;
        
    }
    
    public function add($params) {
        
        $alertList = new Alert();
        $return = array();
        $formData = $params['formData'];
        
        $user = new User();
        $company = new Company();
        $position = new Position();
        
        if($userArr = $user->get()) {
        
            try {

                $db = DB::getConnection();
                
                $result = $db->prepare("INSERT INTO _company VALUES(NULL, NOW(), :title, :userId, '{}')");
                $result->execute(array(

                    ':title' => $formData['title'],
                    ':userId' => $userArr['id']

                ));
                
                    
                $companyId = $db->lastInsertId();

                $result = $db->prepare("INSERT INTO _position "
                        . "VALUES(NULL, NOW(), :companyId, :title)");
                $result->execute(array(

                    ':companyId' => $companyId,
                    ':title' => $formData['position_title']

                ));
                
                $defaultPermissionListArr = $position->getDefaultPerlissionList();
                $positionId = $db->lastInsertId();

                foreach($defaultPermissionListArr as $permissionArr) {

                    $result = $db->prepare("INSERT INTO _permission_list "
                            . "VALUES(NULL, :permissionId, :positionId, 1)");
                    $result->execute(array(

                        ':permissionId' => $permissionArr['id'],
                        ':positionId' => $positionId

                    ));

                }

                $result = $db->prepare("INSERT INTO _worker VALUES(NULL, NOW(), :userId, :positionId, :companyId)");
                $result->execute(array(

                    ':userId' => $userArr['id'],
                    ':positionId' => $positionId,
                    ':companyId' => $companyId

                ));
                    
                $alertList->push('success', '{COMPANY} <b>' . $formData['title'] . '</b> {CREATED}');
                $company->set($db->lastInsertId());
                $return['reload'] = true;

            } catch(PDOException $e) {

                $alertList->push('danger', '<b>PDO Error!</b>' . htmlspecialchars($e));

            }
            
        } else {
            
            $alertList->push('danger', '{NOT_AUTORIZED}');
            
        }
        
        return $return;
        
    }
    
}