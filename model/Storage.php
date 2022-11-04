<?php

class Storage {
    
    private static $id;
    
    private $date,
            $company_id,
            $title,
            $description,
            $access_rules;
    
    public function __construct() {
        
        $company = new Company();
            
        try {
                
            $db = DB::getConnection();
        
            if(!empty($_SESSION['storage_id'])) {
                
                $query = $db->prepare("SELECT * FROM _storage WHERE id = :id");
                $query->execute(array(
                    
                    ':id' => (int)$_SESSION['storage_id']
                    
                ));
                
                if($query->rowCount() > 0) {
                    
                    $storage = $query->fetch(PDO::FETCH_ASSOC);
                    
                    $this->init($storage);
                    
                }
            
            } else {

                $query = $db->prepare("SELECT * FROM _storage WHERE company_id = :company_id LIMIT 1");
                $query->execute(array(

                    'company_id' => $company->id()

                ));

                if($query->columnCount() !== 0) {

                    $storage = $query->fetch(PDO::FETCH_ASSOC);

                    $this->init($storage);


                }

            }
                
        } catch(PDOException $e) {
            
            
            
        }
        
    }
    
    public function content() {
        
        $content['date'] = $this->date;
        $content['company_id'] = $this->company_id;
        $content['title'] = $this->title;
        $content['description'] = $this->description;
        $content['access_rules'] = $this->access_rules;
        
        return $content;
        
    }
    
    private function init($storage) {
        
        self::$id = $storage['id'];
        $this->date = $storage['date'];
        $this->company_id = $storage['company_id'];
        $this->title = $storage['title'];
        $this->description = $storage['description'];
        $this->access_rules = $storage['access_rules'];
        
        $_SESSION['storage_id'] = self::$id;
        
    }
    
    public function get(int $id = null) {
        
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
                    
                } else {
                    
                    $return = false;
                    
                }
                
            } catch(PDOException $e) {
                
                $return = false;
                
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
                        $return = $storageArr;
                        
                    } else {
                        
                        $return = false;
                        
                    }
                    
                } catch(PDOException $e) {
                    
                    $return = false;
                    
                }
                
            } else {
                
                $return = false;
                
            }
            
        }
        
        return $return;
        
    }
    
    public function set(int $id) {
        
        try {
            
            $db = DB::getConnection();
            $result = $db->prepare("SELECT count(*) FROM _storage WHERE id = :id");
            $result->execute(array(
                
                ':id' => $id
                
            ));
            
            if($result->rowCount() > 0) {
                
                $_SESSION['storage_id'] = $id;
                $return = true;
                
            } else {
                
                $return = false;
                
            }
            
        } catch(PDOException $e) {
            
            $return = false;
            
        }
        
        return $return;
        
    }
    
    public function getMaterialList() {
        
        $return = array();
        $storage_id = self::$id;
        
        try{
            
            $db = DB::getConnection();
            
            $result = $db->prepare("SELECT * FROM _storage_material_list WHERE storage_id = :storage_id");
            $result->execute(array(
                
                ':storage_id' => $storage_id
                
            ));
            $materialList = $result->fetchAll(PDO::FETCH_ASSOC);
            
            $return = $materialList;
            
        } catch(PDOException $e) {
            
            $return = false;
            
        }
        
        return $return;
        
    }
    
    public function getMaterialListJSON($params) {
        
        $return = array();
        $storage = new Storage();
        
        try {
            
            $db = DB::getConnection();
            
            $query = $db->prepare("SELECT * FROM _storage_material_list WHERE storage_id = :storage_id AND title LIKE :keyword ORDER BY title");
            $query->execute(array(
                
                ':storage_id' => $storage->get()['id'],
                ':keyword' => '%' . $params['keyword'] . '%'
                
            ));
            
            $materialList = $query->fetchAll(PDO::FETCH_ASSOC);
            
            $return['result'] = $materialList;
            
        } catch(PDOException $e) {
            
            $alertList->push('danger', '<b>PDO Error!</b>' . htmlspecialchars($e));
            
        }
        
        return json_encode($return);
        
    }
    
    public function addMaterial($params) {
        
        $return = array();
        $formData = $params['formData'];
        $alertList = new Alert();
        $worker = new Worker();
        $storage = new Storage();
        
        try {
            
            $db = DB::getConnection();
            
            $query = $db->prepare("SELECT * FROM _storage_material_list WHERE storage_id = :storageId AND title = :title");
            $query->execute(array(
                
                ':storageId' => $storage->get()['id'],
                ':title' => $formData['title']
                
            ));
            
            if($query->rowCount() > 0) {
                
                $query = $db->prepare("UPDATE _storage_material_list SET date = NOW(), worker_id = :workerId, amount = amount + :amount, unit = :unit, price = :price, min_residue = :minResidue, tare_weight = :tareWeight WHERE storage_id = :storageId AND title = :title");
                $query->execute(array(
                    
                    ':workerId' => $worker->get()['id'],
                    ':amount' => $formData['amount'],
                    ':unit' => $formData['unit'],
                    ':price' => $formData['price'],
                    ':tareWeight' => $formData['tare_weight'],
                    ':minResidue' => $formData['min_residue'],
                    ':storageId' => $storage->get()['id'],
                    ':title' => $formData['title']
                    
                ));
                
                $return['reload'] = true;
                $alertList->push('success', '{MATERIAL_ADDED_AT_STORAGE}');
                
            } else {
                
                $query = $db->prepare("INSERT INTO _storage_material_list VALUES(NULL, NOW(), :workerId, :storageId, :title, :amount, :unit, :price, :minResidue, :tareWeight)");
                $query->execute(array(
                    
                    ':workerId' => $worker->get()['id'],
                    ':amount' => $formData['amount'],
                    ':unit' => $formData['unit'],
                    ':price' => $formData['price'],
                    ':tareWeight' => $formData['tare_weight'],
                    ':minResidue' => $formData['min_residue'],
                    ':storageId' => $storage->get()['id'],
                    ':title' => $formData['title']
                    
                ));
                
                $return['reload'] = true;
                $alertList->push('success', '{MATERIAL_ADDED_AT_STORAGE}');
                
            }
            
        } catch(PDOException $e) {
            
            $alertList->push('danger', '<b>PDO Error!</b>' . htmlspecialchars($e));
            
        }
        
        return json_encode($return);
        
    }
    
}