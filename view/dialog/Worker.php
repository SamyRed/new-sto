<?php

class Worker {
    
    public function __construct() {
        
        
        
    }
    
    public function get(int $id = null) {
        
        $alertList = new Alert();
        $return = array();
        
        $user = new User();
        
        if($id !== null) {
            
            try {
                
                $db = DB::getConnection();
                
                $result = $db->prepare("SELECT u.name, p.title, w.* FROM _worker as w "
                        . "INNER JOIN _user AS u "
                        . "INNER JOIN _position as p "
                        . "WHERE u.id = w.user_id AND p.id = w.position_id AND w.id = :id");
                $result->execute(array(
                    
                    ':id' => $id
                    
                ));
                
                if($result->rowCount() > 0) {

                    $workerArr = $result->fetch(PDO::FETCH_ASSOC);

                    $return = $workerArr;
                    
                }
                
            } catch(PDOException $e) {
                
                $alertList->push('danger', '<b>PDO Error!</b> ' . htmlspecialchars($e));
                
            }
            
        } else {
        
            if($userArr = $user->get()) {

                try {

                    $db = DB::getConnection();

                    $result = $db->prepare("SELECT u.name, p.title, w.* FROM _worker as w "
                        . "INNER JOIN _user AS u "
                        . "INNER JOIN _position as p "
                        . "WHERE u.id = w.user_id AND p.id = w.position_id AND w.id = :userId");
                    $result->execute(array(

                        ':userId' => $userArr['id']

                    ));

                    if($result->rowCount() > 0) {

                        $workerArr = $result->fetch(PDO::FETCH_ASSOC);
                        $return = $workerArr;

                    }

                } catch(PDOException $e) {

                    $alertList->push('danger', '<b>PDO Error!</b> ' . htmlspecialchars($e));

                }
                
            } else {

                    $alertList->push('danger', '{USER_NOT_FOUND}');
                
            }
            
        }
        
        return $return;
        
    }
    
    public function getList() {
        
        $alertList = new Alert();
        $return = array();
        
        $company = new Company();
        
        if($companyArr = $company->get()) {
            
            try {
                
                $db = DB::getConnection();
                
                $result = $db->prepare("SELECT w.id, u.email as email, u.name as name, w.date as date, p.title as position_title "
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
    
    public function getSalaryList($params) {
        
        $alertList = new Alert();
        $return = array();
        
        $company = new Company();
        $worker = new Worker();
            
            try {

                $db = DB::getConnection();
        
                if($worker->havePermission('view_salary')) {
            
                    if($companyArr = $company->get()) {
                    
                        $result = $db->prepare("SELECT o.id  AS order_id, o.content as content, JSON_EXTRACT(content, '$.car_name') AS car_name, w.id as worker_id, u.name AS worker_name, t.id as task_id, t.title AS title, t.price AS price, t.amount AS amount, t.price * t.amount as sum "
                                . "FROM _order AS o "
                                . "INNER JOIN _order_task_list AS t "
                                . "INNER JOIN _worker AS w  "
                                . "INNER JOIN _user AS u  "
                                . "WHERE u.id = w.user_id AND t.order_id = o.id AND t.worker_id = w.id AND o.company_id = :companyId "
                                . "ORDER BY o.id");
                        $result->execute(array(

                            ':companyId' => $companyArr['id']

                        ));

                        if($result->rowCount() > 0) {

                            $salaryListArr = $result->fetchAll(PDO::FETCH_ASSOC);
                            $sortedSalaryListArr = array();

                            foreach($salaryListArr as $item) {
                                
                                $sortedSalaryListArr[$item['worker_id']][$item['order_id']][$item['task_id']] = $item;
                                unset($sortedSalaryListArr[$item['worker_id']][$item['order_id']]['task_id']);
                                unset($sortedSalaryListArr[$item['worker_id']][$item['order_id']]['worker_id']);
                                unset($sortedSalaryListArr[$item['worker_id']][$item['order_id']]['order_id']);
                                    
                            }
                            
                            ksort($sortedSalaryListArr, SORT_NUMERIC);
                            $return = $sortedSalaryListArr;

                        }
            
                    } else {

                        $alertList->push('danger', '{COMPANY_NOT_FOUND}');

                    }
            
                } else if($worker->havePermission('view_self_salary')) {
            
                    if($workerArr = $worker->get()) {
                    
                        $result = $db->prepare("SELECT o.id AS order_id, w.id as worker_id, u.name AS worker_name, t.title AS task_title, t.price AS task_price, t.amount AS task_amount, t.price * t.amount as task_sum "
                                . "FROM _order AS o "
                                . "INNER JOIN _order_task_list AS t "
                                . "INNER JOIN _worker AS w  "
                                . "INNER JOIN _user AS u  "
                                . "WHERE u.id = w.user_id AND t.order_id = o.id AND t.worker_id = w.id AND w.id = :workerId "
                                . "ORDER BY o.id");
                        $result->execute(array(

                            ':workerId' => $workerArr['id']

                        ));

                        if($result->rowCount() > 0) {

                            $salaryListArr = $result->fetchAll(PDO::FETCH_ASSOC);
                            $return = $salaryListArr;

                        }
            
                    } else {

                        $alertList->push('danger', '{WORKER_NOT_FOUND}');

                    }

                } else {

                    $alertList->push('danger', '{HAVE_NOT_ACCESS}');

                }
                
            } catch(PDOException $e) {

                $alertList->push('danger', '{<b>PDE Error!</b> }' . htmlspecialchars($e));

            }
        
        return $return;
        
    }
    
    public function add($params) {
        
        $alertList = new Alert();
        $return = array();
        $formData = $params['formData'];
        
        $company = new Company();
        $worker = new Worker();
        
        if($worker->havePermission('company_edit_settings')) {
            
            if($companyArr = $company->get()) {
            
                try {

                    $db = DB::getConnection();
                    $result = $db->prepare("SELECT * FROM _user WHERE email = :email");
                    $result->execute(array(

                        ':email' => $formData['email']

                    ));

                    if($result->rowCount() > 0) {

                        $userArr = $result->fetch(PDO::FETCH_ASSOC);

                        $result = $db->prepare("INSERT INTO _worker VALUES(NULL, NOW(), :userId, :positionId, :companyId)");
                        $result->execute(array(

                            ':userId' => $userArr['id'],
                            ':positionId' => $formData['positionId'],
                            ':companyId' => $companyArr['id']

                        ));

                    }

                } catch (PDOException $e) {

                    $alertList->push('danger', '<b>PDO Error!</b> ' . htmlspecialchars($e));
                }
                
            } else {

                $alertList->push('danger', '{COMPANY_NOT_FOUND}');

            }
                    
        } else {
            
            $alertList->push('danger', '<b>PDO Error!</b> ' . htmlspecialchars($e));
            
        }
        
        return $return;
        
    }
    
}