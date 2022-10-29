<?php

class Order {
    
    private $content,
            $fieldList;
    public  $id,
            $date;
    
    public function __construct() {
        
        $this->fieldList = self::getFields();
        
    }
    
    public function content() {
        
        return $this->content;
        
    }
    
    public function id(int $id = null) {
        
        $return = array();
        
        if($id !==null) {
            
            try{
                
                $db = DB::getConnection();
                
                $query = $db->prepare("SELECT * FROM _order WHERE id = :id");
                $query->execute(array(
                    
                    ':id' => $id
                    
                ));
                
                if($query->columnCount() !== 0) {
                    
                    $order = $query->fetch(PDO::FETCH_ASSOC);
                    
                    $this->id = $id;
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
            
            if(!empty($this->id)) {
                
                $return = $this->id;
                
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
        var_dump($params);
        
        $order = new Order();
        $return = array();
        $alertList = new Alert();
        $company = new Company();
        $paramsArr = array();
        
        foreach($order->fieldList() as $field) {
            
            if(!empty($params['formData'][$field['service_field_name']])) {
                
                $paramsArr[$field['service_field_name']] = $params['formData'][$field['service_field_name']];
            
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
    
}