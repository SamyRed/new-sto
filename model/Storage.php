<?php

class Storage {
    
    private $id;
    
    public function __construct() {
        
        
        
    }
    
    public function get($id = null) {
        
        $alertList = new Alert();
        $return = array();
        
        $company = new Company();
        $worker = new Worker();

        if($companyArr = $company->get()) {
        
            if($worker->havePermission('view_storage')) {

                if($id !== null) {

                    try {

                        $db = DB::getConnection();
                        $result = $db->prepare("SELECT * FROM _storage WHERE id = :id");
                        $result->execute(array(

                            ':id' => $id

                        ));

                        if($result->rowCount() > 0) {

                            $storageArr = $result->fetch(PDO::FETCH_ASSOC);
                            $return = $storageArr;

                        }

                    } catch(PDOException $e) {

                        $alertList->push('danger', '<b>PDO Error!</b>' . htmlspecialchars($e));

                    }

                } else {

                    if(!empty($_SESSION['storage_id'])) {

                        try {

                            $db = DB::getConnection();
                            $result = $db->prepare("SELECT * FROM _storage WHERE id = :id");
                            $result->execute(array(

                                ':id' => $_SESSION['storage_id']

                            ));

                            if($result->rowCount() > 0) {

                                $storageArr = $result->fetch(PDO::FETCH_ASSOC);

                            } else {
                                
                                $storageListArr = $this->permittedList();
                                $storageArr = $storageListArr[0];
                                $this->set($storageArr['id']);
                                
                            }
                            
                            $return = $storageArr;

                        } catch(PDOException $e) {

                            $alertList->push('danger', '<b>PDO Error!</b>' . htmlspecialchars($e));

                        }

                    } else {

                        try {

                            $db = DB::getConnection();
                            $result = $db->prepare("SELECT * FROM _storage WHERE company_id = :companyId LIMIT 1");
                            $result->execute(array(

                                ':companyId' => $companyArr['id']

                            ));

                            if($result->rowCount() > 0) {

                                $storageArr = $result->fetchAll(PDO::FETCH_ASSOC)[0];
                                $return = $storageArr;
                                $this->set($storageArr['id']);

                            }

                        } catch(PDOException $e) {

                            $alertList->push('danger', '<b>PDO Error!</b>' . htmlspecialchars($e));

                        }

                    }

                }

            } else {

                $alertList->push('danger', 'HAVE_NOT_ACCESS');

            }

        } else {

            $alertList->push('warning', '{COMPANY_NOT_FOUND}');

        }
        
        return $return;
        
    }
    
    public function setId($params) {
        
        $return = array();
        $alertList = new Alert();
        
        if(!empty($params['id'])) {
            
            $id = $params['id'];
            $this->set($id);
            
        } else {
            
            $alertList->push('danger', '{STORAGE_ID_IS_EMPTY}');
            
        }
        
    }
    
    public function set($id) {
        
        $alertList = new Alert();
        $return = array();
        
        try {
            
            $db = DB::getConnection();
            $result = $db->prepare("SELECT count(*) FROM _storage WHERE id = :id");
            $result->execute(array(
                
                ':id' => $id
                
            ));
            
            if($result->rowCount() > 0) {
                
                $_SESSION['storage_id'] = $id;
                
            } else {
                
                $alertList->push('danger', '{STORAGE_NOT_FOUND}');
                
            }
            
        } catch(PDOException $e) {
            
            $alertList->push('danger', '<b>PDO Error!</b>' . htmlspecialchars($e));
            
        }
        
        return $return;
        
    }
    
    public function add($params) {
        
        $alertList = new Alert();
        $return = array();
        $formData = $params['formData'];
        
        $company = new Company();
        $worker = new Worker;
        
        if($worker->havePermission('add_company_storage')) {

            if($companyArr = $company->get()) {

                $accessRulesArr = array(

                    'worker' => array(),
                    'position' => array()

                );

                if(!empty($formData['permitted-worker'])) {

                    if(is_array($formData['permitted-worker'])) {

                        foreach($formData['permitted-worker'] as $item) {

                            $accessRulesArr['worker'][] = (int)$item;

                        }

                    } else {

                        $alertList->push('caution', '{INCORRECT_FIELD_FORMAT}');

                    }
                }

                if(!empty($formData['permitted-position'])) {

                    if(is_array($formData['permitted-position'])) {

                        foreach($formData['permitted-position'] as $item) {

                            $accessRulesArr['position'][] = (int)$item;

                        }

                    } else {

                        $alertList->push('caution', '{INCORRECT_FIELD_FORMAT}');

                    }

                }

                if($workerArr = $worker->get()) {

                    $accessRulesArr['worker'][] = (int)$workerArr['id'];

                } else {

                    $alertList->push('warning', '{WORKER_NOT_FOUND}');

                }

                $accessRulesJSON = json_encode($accessRulesArr);

                try {

                    $db = DB::getConnection();
                    $result = $db->prepare("INSERT INTO _storage VALUES(NULL, NOW(), :companyId, :title, :description, :accessRules)");
                    $result->execute(array(

                        ':companyId' => $companyArr['id'],
                        ':title' => $formData['title'],
                        ':description' => $formData['description'],
                        ':accessRules' => $accessRulesJSON

                    ));

                    $alertList->push('success', '{STORAGE} <b>' . $formData['title'] . '</b> {CREATED}');

                } catch(PDOException $e) {

                    $alertList->push('danger', '<b>PDO Error!</b>' . htmlspecialchars($e));

                }

            } else {

                    $alertList->push('danger', '{COMPANY_NOT_FOUND}');

            }
            
        } else {
            
            $alertList->push('danger', 'HAVE_NOT_ACCESS');
            
        }
        
        return $return;
        
    }
    
    public function permittedList() {
        
        $alertList = new Alert();
        $return = array();
        
        $company = new Company();
        $worker = new Worker();
        
        if($companyArr = $company->get()) {
            
            if($workerArr = $worker->get()) {
                
                $workerId = $workerArr['id'];
                $positionId = $workerArr['position_id'];
                
            } else {
                
                $workerId = null;
                $positionId = null;
                
            }
        
            try {

                $db = DB::getConnection();
                $result = $db->prepare("SELECT * FROM _storage WHERE company_id = :companyId AND (JSON_CONTAINS(access_rules, :workerId, '$.worker') OR JSON_CONTAINS(access_rules, :positionId, '$.position'))");
                $result->execute(array(

                    ':companyId' => $companyArr['id'],
                    ':workerId' => $workerId,
                    ':positionId' => $positionId

                ));

                if($result->rowCount() > 0) {

                    $storageListArr = $result->fetchAll(PDO::FETCH_ASSOC);
                    $return = $storageListArr;

                }

            } catch(PDOException $e) {

                $alertList->push('danger', '<b>PDO Error!</b>' . htmlspecialchars($e));

            }
            
        } else {
            
            $alertList->push('danger', '{COMPANY_NOT_FOUND}');
            
        }
        
        return $return;
        
    }
    
    public function getMaterialList($id = null) {
        
        $alertList = new Alert();
        $return = array();
        
        $worker = new Worker();
        
        if($id !== null) {
            
            $storageArr = $this->get($id);
            
        } else {
            
            $storageArr = $this->get();
            
        }
        
        if($worker->havePermission('view_storage')) {
        
            if($storageArr) {

                try {

                    $db = DB::getConnection();

                    $result = $db->prepare("SELECT *, (price * amount) as sum FROM _storage_material_list WHERE storage_id = :storage_id");
                    $result->execute(array(

                        ':storage_id' => $storageArr['id']

                    ));

                    $materialList = $result->fetchAll(PDO::FETCH_ASSOC);
                    $return = $materialList;

                } catch(PDOException $e) {

                    $alertList->push('danger', '<b>PDO Error!</b>' . htmlspecialchars($e));

                }

            } else {

                $alertList->push('danger', '{STORAGE_NOT_FOUND}');

            }
            
        } else {
            
            $alertList->push('danger', '{HAVE_NOT_ACCESS}');
            
        }
        
        return $return;
        
    }
    
    public function getMaterialListByKeyword($params) {
        
        $return = array();
        $alertList = new Alert();
        
        $storage = new Storage();
            
        if($storageArr = $storage->get()) {
        
            try {

                $db = DB::getConnection();
            
                $query = $db->prepare("SELECT * FROM _storage_material_list WHERE storage_id = :storageId AND title LIKE :keyword ORDER BY title");
                $query->execute(array(

                    ':storageId' => $storageArr['id'],
                    ':keyword' => '%' . $params['keyword'] . '%'

                ));

                $materialList = $query->fetchAll(PDO::FETCH_ASSOC);
                $return['result'] = $materialList;
            
            } catch(PDOException $e) {

                $alertList->push('danger', '<b>PDO Error!</b>' . htmlspecialchars($e));

            }
                
        } else {

            $alertList->push('danger', '{STORAGE_NOT_CHOOSEN}');

        }
        
        return $return;
        
    }
    
    public function addMaterial($params) {
        
        $alertList = new Alert();
        $return = array();
        $formData = $params['formData'];
        
        $worker = new Worker();
        $storage = new Storage();
        
        if($worker->havePermission('add_storage_material')) {
        
            try {

                $db = DB::getConnection();

                $result = $db->prepare("SELECT * FROM _storage_material_list WHERE storage_id = :storageId AND title = :title");
                $result->execute(array(

                    ':storageId' => $storage->get()['id'],
                    ':title' => $formData['title']

                ));

                if($result->rowCount() > 0) {

                    $materialArr = $result->fetch(PDO::FETCH_ASSOC);
                    $amount = $materialArr['amount'] + $formData['amount'];

                    $result = $db->prepare("UPDATE _storage_material_list SET date = NOW(), worker_id = :workerId, amount = :amount, unit = :unit, price = :price, min_residue = :minResidue, tare_weight = :tareWeight WHERE storage_id = :storageId AND title = :title");
                    $result->execute(array(

                        ':workerId' => $worker->get()['id'],
                        ':amount' => $amount,
                        ':unit' => $formData['unit'],
                        ':price' => $formData['price'],
                        ':tareWeight' => $formData['tare_weight'],
                        ':minResidue' => $formData['min_residue'],
                        ':storageId' => $storage->get()['id'],
                        ':title' => $formData['title']

                    ));

                    $alertList->push('success', '{MATERIAL} <b>' . $formData['title'] . '</b> {UPDATED_AT_STORAGE} <b>' . $storage->get()['title'] . '</b>! {CURRENT_AMOUNT}: <b>' . $amount . $formData['unit'] . '</b>');

                } else {

                    $result = $db->prepare("INSERT INTO _storage_material_list VALUES(NULL, NOW(), :workerId, :storageId, :title, :amount, :unit, :price, :minResidue, :tareWeight)");
                    $result->execute(array(

                        ':workerId' => $worker->get()['id'],
                        ':amount' => $formData['amount'],
                        ':unit' => $formData['unit'],
                        ':price' => $formData['price'],
                        ':tareWeight' => $formData['tare_weight'],
                        ':minResidue' => $formData['min_residue'],
                        ':storageId' => $storage->get()['id'],
                        ':title' => $formData['title']

                    ));

                    $alertList->push('success', '{MATERIAL} <b>' . $formData['title'] . '</b> {ADDED_AT_STORAGE} <b>' . $storage->get()['title'] . '</b> {WHITH_AMOUNT}: <b>' . $formData['amount'] . $formData['unit'] . '</b>');

                }

            } catch(PDOException $e) {

                $alertList->push('danger', '<b>PDO Error!</b>' . htmlspecialchars($e));

            }
            
        } else {
            
            $alertList->push('danger', '{HAVE_NOT_ACCESS}');
            
        }
        
        return $return;
        
    }
    
}