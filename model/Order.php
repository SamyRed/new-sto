<?php

class Order {
    
    private static $id;
    
    private $content,
            $fieldList,
            $date;
    
    public function __construct() {
        
        $this->fieldList = self::getFields();
        
    }
    
    public function content() {
        
        $content = $this->content;
        $content['date'] = $this->date;
        $content['id'] = self::$id;
        
        return $content;
        
    }
    
    public function id(int $id = null) {
        
        $return = array();
        
        if($id !== null) {
            
            try{
                
                $db = DB::getConnection();
                
                $query = $db->prepare("SELECT * FROM _order WHERE id = :id");
                $query->execute(array(
                    
                    ':id' => $id
                    
                ));
                
                if($query->rowCount() > 0) {
                    
                    $order = $query->fetch(PDO::FETCH_ASSOC);
                    
                    self::$id = $id;
                    $this->content = json_decode($order['content'], 1);
                    $this->date = $order['date'];
                
                    $return = true;
                    
                } else {
                
                    $return = false;
                    
                }
                
            } catch(PDOException $e) {
                
                $return = false;
                
            }
            
        } else {
            
            if(!empty(self::$id)) {
                
                $return = self::$id;
                
            } else {
                
                $return = false;
                
            }
            
        }
        
        return $return;
        
    }
    
    public function fieldList() {
        
        return $this->fieldList;
        
    }
    
    /**
     * Return list of fields of orders by active company id
     * @return array
     */
    private static function getFields() {
        
        $return = array();
        $alertList = new Alert();
        $company = new Company();
        
        try {
            
            $db = DB::getConnection();
            
            $result = $db->prepare("SELECT * FROM _order_fields WHERE company_id = :company_id");
            $result->execute(array(
                ':company_id' => $company->id()
            ));
            
            $fieldList = $result->fetchAll(PDO::FETCH_ASSOC);
            
            $return['result'] = $fieldList;
            
        } catch(PDOException $e) {
            
            $alertList::push('danger', '<b>PDO Error!</b>' . htmlspecialchars($e));
            
        }
        
        if(!$alertList::empty()) {
            
            $return['result'] = false;
            
        }
        
        return $return['result'];
        
    }
    
    /**
     * Return list of orders by active company id
     * @return JSON array
     */
    public static function getList() {
        
        $return = array();
        $alertList = new Alert();
        $company = new Company();
        
        try {
            
            $db = DB::getConnection();
            
            $result = $db->prepare("SELECT * FROM _order WHERE company_id = :company_id");
            $result->execute(array(
                ':company_id' => $company->id()
            ));
            
            $orderList = $result->fetchAll(PDO::FETCH_ASSOC);
            
            $return['result'] = $orderList;
            
        } catch(PDOException $e) {
            
            $alertList->push('danger', '<b>PDO Error!</b>' . htmlspecialchars($e));
            
        }
        
        $return['alert'] = $alertList;
        
        return json_encode($return);
        
    }
    
    public static function add($params) {
        
        $formData = $params['formData'];
        $order = new Order();
        $return = array();
        $alertList = new Alert();
        $company = new Company();
        $paramsArr = array();
        
        foreach($order->fieldList() as $field) {
            
            if(!empty($formData[$field['service_field_name']])) {
                
                $paramsArr[$field['service_field_name']] = $formData[$field['service_field_name']];
            
            } else {
                
                $alertList->push('danger', 'Field name does not exists <b>(' . $field['service_field_name'] . ')</b>');
                
            }
            
        }
        
        $paramsJSON = json_encode($paramsArr);
        
        if($alertList->empty()) {
            
            try {

                $db = DB::getConnection();

                $result = $db->prepare("INSERT INTO _order (content, date, company_id) VALUES(:params, NOW(), :company_id)");
                $result->execute(array(

                    ':params' => $paramsJSON,
                    ':company_id' => $company->id()

                ));

                $return['result'] = true;

            } catch(PDOException $e) {

                $return['result'] = false;
                $alertList::push('danger', '<b>PDO Error!</b>' . htmlspecialchars($e));

            }
            
        } else {
            
            $return['result'] = false;
            
        }
        
        return $return['result'];
        
    }
    
    public function getMaterialList() {
        
        $return = array();
        $order_id = self::$id;
        
        try{
            
            $db = DB::getConnection();
            
            $result = $db->prepare("SELECT * FROM _order_material_list WHERE order_id = :order_id");
            $result->execute(array(
                
                ':order_id' => $order_id
                
            ));
            $materialList = $result->fetchAll(PDO::FETCH_ASSOC);
            
            $return = $materialList;
            
        } catch(PDOException $e) {
            
            $return = false;
            
        }
        
        return $return;
        
    }
    
}