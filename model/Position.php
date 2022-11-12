<?php

Class Position {
    
    public function __construct() {
        
        
        
    }
    
    public function getList() {
        
        $alertList = new Alert();
        $return = array();
        
        $company = new Company();
            
        if($companyArr = $company->get()) {
        
            try {
                
                $db = DB::getConnection();
                $result = $db->prepare("SELECT * FROM _position WHERE company_id = :companyId");
                $result->execute(array(
                    
                    ':companyId' => $companyArr['id']
                    
                ));
                
                if($result->rowCount() > 0) {
                    
                    $positionListArr = $result->fetchAll(PDO::FETCH_ASSOC);
                    $return = $positionListArr;
                    
                } else {
            
                    $alertList->push('caution', '{POSITION_LIST_IS_EMPTY}');
                    
                }
            
            } catch(PDOException $e) {

                $alertList->push('danger', '<b>PDO Error!</b> ' . htmlspecialchars($e));

            }
                
        } else {

            $alertList->push('danger', '{COMPANY_NOT_FOUND}');

        }
        
        return $return;
        
    }
    
    public function add($params) {
        
        $alertList = new Alert();
        $return = array();
        $formData = $params['formData'];
        
        $company = new Company();
        $worker = new Worker();
        
        if($worker->havePermission('company_control')) {
            
            if($companyArr = $company->get()) {
            
                $db = DB::getConnection();

                $result = $db->prepare("SELECT * FROM _position WHERE title = :title");
                $result->execute(array(

                    ':title' => $formData['title']

                ));

                if($result->rowCount() > 0) {

                    $alertList->push('danger', '{POSITION_WHITH_THIS_TITLE_ALREADY_EXISTS}');

                } else {

                    $result = $db->prepare("INSERT INTO _position "
                            . "VALUES(NULL, NOW(), :companyId, :title)");
                    $result->execute(array(

                        ':companyId' => $companyArr['id'],
                        ':title' => $formData['title']

                    ));
                    
                    $positionId = $db->lastInsertId();
                    $permissionListArr = $this->getDefaultPerlissionList();

                    foreach($permissionListArr as $permissionArr) {

                        if(!empty($formData['permissionList'][$permissionArr['id']])) {
                            
                            if(in_array($permissionArr['id'], $formData['permissionList'])) {
                                
                                $permissionValue = 1;
                                
                            } else {
                                
                                $permissionValue = 0;
                                
                            }

                            $result = $db->prepare("INSERT INTO _permission_list "
                                    . "VALUES(NULL, :permissionId, :positionId, :value)");
                            $result->execute(array(

                                ':permissionId' => $permissionArr['id'],
                                ':positionId' => $positionId,
                                ':value' => $permissionValue

                            ));

                        }

                    }
                    
                    $alertList->push('success', '{POSITION_ADDED}');

                }
        
            } else {
                
                $alertList->push('danger', '{COMPANY_NOT_FOUND}');
                
            }
            
        } else {
            
            $alertList->push('danger', '{HAVE_NOT_ACCESS}');
            
        }
        
    }
    
    public function getDefaultPerlissionList() {
        
        $alertList = new Alert();
        $return = array();
        
        try {
            
            $db = DB::getConnection();
            $query = $db->query("SELECT * FROM _permission_default");
            $permissionListArr = $query->fetchAll(PDO::FETCH_ASSOC);
            $return = $permissionListArr;
            
        } catch(PDOException $e) {
            
            $alertList->push('danger', '<b>PDO Error!</b> ' . htmlspecialchars($e));
            
        }
    
        return $return;
        
    }
    
    public function getCurrent($id) {
        
        $alertList = new Alert();
        $return = array();
        
        try {
            
            $db = DB::getConnection();
            
            $query = $db->prepare("SELECT * FROM _position WHERE id = :positionId");
            $query->execute(array(
                
               ':positionId' => $id
                
            ));
            
            if($query->rowCount() > 0) {
                
                $positionArr = $query->fetch(PDO::FETCH_ASSOC);
            
                $query = $db->prepare("SELECT pd.id, pd.title, pl.value FROM _permission_default as pd LEFT JOIN _permission_list as pl ON pl.permission_id = pd.id AND pl.position_id = :positionId");
                $query->execute(array(

                    ':positionId' => $id

                ));

                if($query->rowCount() > 0) {

                    $permissionListArr = $query->fetchAll(PDO::FETCH_ASSOC);
                    $positionArr['permission_list'] = $permissionListArr;
                    $return = $positionArr;

                }
                
            }
            
        } catch(PDOException $e) {
            
            $alertList->push('danger', '<b>PDO Error!</b> ' . htmlspecialchars($e));
            
        }
    
        return $return;
        
    }
    
}