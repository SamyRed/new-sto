<?php

class Order {
    
    public function __construct() {
        
        
        
    }
    
    public function get($id = null) {
        
        $alertList = new Alert();
        $return = null;
        
        $worker = new Worker();
        
        if($worker->havePermission('view_order')) {

            if($id === null) {

                $id = $_SESSION['order_id'];

            }

            try {

                $db = DB::getConnection();

                $result = $db->prepare("SELECT * FROM _order "
                        . "WHERE id = :id");
                $result->execute(array(

                    ':id' => $id

                ));

                if($result->rowCount() > 0) {

                    $orderArr = $result->fetch(PDO::FETCH_ASSOC);
                    $orderContentArr = json_decode($orderArr['content'], 1);

                    $fieldList = $this->getFields();

                    foreach($orderContentArr as $key => $item) {

                        $orderArr[$key] = $item;

                    }

                    unset($orderArr['content']);
                    $return = $orderArr;

                }

            } catch(PDOException $e) {

                $alertList->push('danger', '<b>PDO Error!</b>' . htmlspecialchars($e));

            }
            
        } else {
            
            $alertList->push('danger', '{HAVE_NOT_ACCESS}');
            
        }

        return $return;
        
    }
    
    public function set($id) {
        
        $_SESSION['order_id'] = $id;
        
    }
    
    /**
     * Return list of fields of orders by active company id
     * @return array
     */
    public function getFields() {
        
        $alertList = new Alert();
        $return = array();
        
        $company = new Company();
        
        if($companyArr = $company->get()) {
        
            try {

                $db = DB::getConnection();

                $result = $db->prepare("SELECT * FROM _order_fields "
                        . "WHERE company_id = :company_id");
                $result->execute(array(
                    ':company_id' => $companyArr['id']
                ));

                $fieldList = $result->fetchAll(PDO::FETCH_ASSOC);
                $return = $fieldList;

            } catch(PDOException $e) {

                $alertList::push('danger', '<b>PDO Error!</b>' . htmlspecialchars($e));

            }
            
        } else {
            
            $alertList::push('danger', 'COMPANY_NOT_FOUND');
            
        }
        
        return $return;
        
    }
    
    /**
     * Return list of orders by active company id
     * @return array
     */
    public static function getList() {
        
        $alertList = new Alert();
        $return = null;
        
        $company = new Company();
        $worker = new Worker();
        
        if($worker->havePermission('view_order_list')) {
        
            if($companyArr = $company->get()) {

                try {

                    $db = DB::getConnection();

                    $result = $db->prepare("SELECT o.*, SUM(t.price) as sum, s.title as status_title "
                        . "FROM _order_task_list as t "
                        . "INNER JOIN _order as o "
                        . "INNER JOIN _order_status_list as s "
                        . "WHERE o.company_id = :company_id AND t.order_id = o.id AND s.id = o.status_id "
                        . "GROUP BY t.order_id");
                    $result->execute(array(
                        ':company_id' => $companyArr['id']
                    ));

                    $orderList = $result->fetchAll(PDO::FETCH_ASSOC);

                    $return = $orderList;

                } catch(PDOException $e) {

                    $alertList->push('danger', '<b>PDO Error!</b>' . htmlspecialchars($e));

                }

            } else {

                $alertList::push('danger', '{COMPANY_NOT_FOUND}');

            }
            
        } else {
            
            $alertList->push('danger', '{HAVE_NOT_ACCESS}');
            
        }
        
        return $return;
        
    }
    
    public static function add($params) {
        
        $alertList = new Alert();
        $return = array();
        $formData = $params['formData'];
        
        $order = new Order();
        $company = new Company();
        $worker = new Worker();
        
        if($worker->havePermission('add_company_order')) {

            if($companyArr = $company->get()) {

                $paramsArr = array();

                foreach($order->getFields() as $field) {

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

                        $result = $db->prepare("INSERT INTO _order "
                                . "VALUES(NULL, NOW(), :params, :company_id, 1)");
                        $result->execute(array(

                            ':params' => $paramsJSON,
                            ':company_id' => $companyArr['id']

                        ));

                        $alertList::push('success', '{ORDER_CREATED}');
                        $return['reload'] = true;

                    } catch(PDOException $e) {

                        $alertList::push('danger', '<b>PDO Error!</b>' . htmlspecialchars($e));

                    }

                }

            } else {

                $alertList::push('danger', '{COMPANY_NOT_FOUND}');

            }
        
        } else {
            
            $alertList::push('danger', '{HAVE_NOT_ACCESS}');
            
        }
        
        return $return;
        
    }
    
    public function getMaterialList() {
        
        $alertList = new Alert();
        $return = array();
        
        $worker = new Worker();
        
        if($worker->havePermission('view_order')) {

            if($orderArr = $this->get()) {
        
                try {

                    $db = DB::getConnection();

                    $result = $db->prepare(""
                            . "SELECT s.title as storage_title, MAX(m.date) as date, m.worker_id, m.storage_id, m.title, SUM(m.amount) as amount, AVG(m.price) as price, m.unit, SUM(m.amount * m.price) AS sum "
                            . "FROM _order_material_list as m "
                            . "INNER JOIN _storage as s "
                            . "WHERE m.order_id = :order_id AND s.id = m.storage_id "
                            . "GROUP BY m.worker_id, m.storage_id, m.title, m.unit");
                    $result->execute(array(

                        ':order_id' => $orderArr['id']

                    ));
                    $materialList = $result->fetchAll(PDO::FETCH_ASSOC);
                    $return = $materialList;

                } catch(PDOException $e) {

                    $alertList->push('danger', '<b>PDO Error!</b> ' . htmlspecialchars($e));

                }
                
            } else {
                
                $alertList->push('danger', '{ORDER_NOT_FOUND}');
                
            }
            
        } else {
            
            $alertList->push('danger', '{HAVE_NOT_ACCESS}');
            
        }
        
        return $return;
        
    }
    
    public function getTaskList() {
        
        $alertList = new Alert();
        $return = array();
        
        $worker = new Worker();
        
        if($worker->havePermission('view_order')) {
            
            if($orderArr = $this->get()) {

                try{

                    $db = DB::getConnection();

                    $result = $db->prepare("SELECT MAX(date) as date, worker_id, title, SUM(amount) as amount, price as price, SUM(amount * price) AS sum FROM _order_task_list WHERE order_id = :order_id GROUP BY worker_id, title, price");
                    $result->execute(array(

                        ':order_id' => $orderArr['id']

                    ));
                    $taskListArr = $result->fetchAll(PDO::FETCH_ASSOC);
                    $return = $taskListArr;

                } catch(PDOException $e) {

                    $alertList->push('danger', '<b>PDO Error!</b> ' . htmlspecialchars($e));

                }

            } else {
                
                $alertList->push('danger', '{ORDER_NOT_FOUND}');
                
            }
            
        } else {
            
            $alertList->push('danger', '{HAVE_NOT_ACCESS}');
            
        }
        
        return $return;
        
    }
    
    public function addMaterial($params) {
        
        $alertList = new Alert();
        $return = array();
        
        $storage = new Storage();
        $worker = new Worker();
        
        if($worker->havePermission('add_order_material')) {
            
            if($formData = $params['formData']) {

                if($storageArr = $storage->get()) {

                    if($workerArr = $worker->get()) {

                        if($orderArr = $this->get($formData['order_id'])) {

                            try {

                                $db = DB::getConnection();

                                $result = $db->prepare("SELECT amount FROM _storage_material_list WHERE id = :materialId LIMIT 1");
                                $result->execute(array(

                                    ':materialId' => $formData['id']

                                ));

                                if($result->rowCount() > 0) {

                                    $materialArr = $result->fetch(PDO::FETCH_ASSOC);
                                    $materialAmount = $materialArr['amount'];

                                    if($materialAmount >= $formData['amount']) {

                                        $result = $db->prepare(""
                                                . "INSERT INTO _order_material_list VALUES(NULL, NOW(), :workerId, :storageId, :orderId, :title, :amount, :unit, :price);"
                                                . "UPDATE _storage_material_list SET amount = amount - :amount WHERE id = :materialId");
                                        $result->execute(array(

                                            ':materialId' => $formData['id'],
                                            ':workerId' => $workerArr['id'],
                                            ':storageId' => $storageArr['id'],
                                            ':orderId' => $formData['order_id'],
                                            ':title' => $formData['title'],
                                            ':amount' => $formData['amount'],
                                            ':unit' => $formData['unit'],
                                            ':price' => $formData['price'],

                                        ));

                                        $alertList->push('success', '{MATERIAL_ADDED_TO_ORDER} <b>' . $orderArr['car_name'] . '</b> {FROM_STORAGE} <b>' . $storageArr['title'] . '</b> {WHITH_AMOUNT} <b>' . $formData['amount']);

                                    } else {

                                        $alertList->push('danger', '{NOT_ENOUGHT_MATERIAL}');

                                    }

                                } else {

                                    $alertList->push('danger', '{MATERIAL_NOT_FOUND}');

                                }

                            } catch(PDOException $e) {

                                $alertList->push('danger', '<b>DB Error!</b> ' . htmlspecialchars($e));

                            }

                        } else {

                            $alertList->push('danger', '{ORDER_NOT_FOUND}');

                        }

                    } else {

                        $alertList->push('danger', '{WORKER_NOT_FOUND}');

                    }

                } else {

                    $alertList->push('danger', '{STORAGE_NOT_FOUND}');

                }

            } else {

                $alertList->push('danger', '{FORM_DATA_IS_EMPTY}');

            }
            
        } else {
            
            $alertList->push('danger', '{HAVE_NOT_ACCESS}');
            
        }
        
    }
    
    public function addTask($params) {
        
        $alertList = new Alert();
        $return = array();
        
        $worker = new Worker();
        
        if($worker->havePermission('add_order_task')) {
            
            if($formData = $params['formData']) {

                if(empty($formData['amount'])) {

                    $formData['amount'] = 1;

                }

                if($orderArr = $this->get($formData['order_id'])) {

                    try {

                        $db = DB::getConnection();
                        $result = $db->prepare("INSERT INTO _order_task_list VALUES(NULL, NOW(), :orderId, :workerId, :title, :description, :price, :amount)");
                        $result->execute(array(

                            ':orderId' => $formData['order_id'],
                            ':workerId' => $formData['worker_id'],
                            ':title' => $formData['title'],
                            ':description' => $formData['description'],
                            ':price' => $formData['price'],
                            ':amount' => $formData['amount']

                        ));

                        $alertList->push('success', '{TASK_ADDED_TO_ORDER} <b>' . $orderArr['car_name'] . '</b> {WHITH_PRICE} <b>' . $formData['price'] . '</b>, {WHITH_AMOUNT} <b>' . $formData['amount']);

                    } catch(PDOException $e) {

                        $alertList->push('danger', '<b>DB Error!</b> ' . htmlspecialchars($e));

                    }

                } else {

                    $alertList->push('danger', '{ORDER_NOT_FOUND}');

                }

            } else {

                $alertList->push('danger', '{FORM_DATA_IS_EMPTY}');

            }
            
        } else {

            $alertList->push('danger', '{HAVE_NOT_ACCESS}');

        }
        
    }
    
    public function addTaskPattern($params) {
        
        $alertList = new Alert();
        $return = array();
        
        $company = new Company();
        $worker = new Worker();
        
        if($worker->havePermission('add_order_task')) {
            
            if($formData = $params['formData']) {

                if($companyArr = $company->get()) {
        
                    try {
            
                        $db = DB::getConnection();

                        $result = $db->prepare("SELECT * FROM _order_task_pattern WHERE company_id = :companyId AND title = :title");
                        $result->execute(array(

                            ':companyId' => $companyArr['id'],
                            ':title' => $formData['title']

                        ));

                        if($result->rowCount() > 0) {

                            $result = $db->prepare("UPDATE _order_task_pattern SET price = :price WHERE company_id = :companyId AND title = :title");
                            $result->execute(array(

                                ':price' => $formData['price'],
                                ':companyId' => $companyArr['id'],
                                ':title' => $formData['title']

                            ));

                            $alertList->push('success', '{TASK_PATTERN_UPDATED}');

                        } else {

                            $result = $db->prepare("INSERT INTO _order_task_pattern VALUES(NULL, NOW(), :companyId, :title, :price)");
                            $result->execute(array(

                                ':price' => $formData['price'],
                                ':companyId' => $companyArr['id'],
                                ':title' => $formData['title']

                            ));

                            $alertList->push('success', '{TASK_PATTERN_ADDED}');

                        }
            
                    } catch(PDOException $e) {

                        $alertList->push('danger', '<b>PDO Error!</b> ' . htmlspecialchars($e));

                    }

                } else {

                    $alertList->push('danger', '{COMPANY_NOT_FOUND}');

                }
            } else {
                
                $alertList->push('danger', '{FORM_DATA_IS_EMPTY}');
                
            }
            
        } else {

            $alertList->push('danger', '{HAVE_NOT_ACCESS}');

        }
        
        return $return;
        
    }
    
    public function getTaskPatternListByKeyword($params) {
        
        $alertList = new Alert();
        $return = array();
        
        $company = new Company();
        $worker = new Worker();
        
        if($worker->havePermission('add_order_task')) {
            
            if($companyArr = $company->get()) {
        
                try {
            
                    $db = DB::getConnection();
            
                    $result = $db->prepare("SELECT * FROM _order_task_pattern WHERE company_id = :companyId AND title LIKE :keyword");
                    $result->execute(array(

                        ':companyId' => $companyArr['id'],
                        ':keyword' => '%' . $params['keyword'] . '%'

                    ));

                    if($result->rowCount() > 0) {

                        $patternListArr = $result->fetchAll(PDO::FETCH_ASSOC);
                        $return['result'] = $patternListArr;

                    }
            
                } catch(PDOException $e) {

                    $alertList->push('danger', '<b>PDO Error!</b> ' . htmlspecialchars($e));

                }
                
            } else {
                
                $alertList->push('danger', '{COMPANY_NOT_FOUND}');
                
            }
            
        } else {

            $alertList->push('danger', '{HAVE_NOT_ACCESS}');

        }
        
        return $return;
        
    }
    
    public function getStatus($id = null) {
        
        $alertList = new Alert();
        $return = array();
        
        if($id = null) {
            
            $orderArr = $this->get();
            
        } else {
            
            $orderArr = $this->get($id);
            
        }
        
        try {
            
            $db = DB::getConnection();
            $result = $db->prepare("SELECT * FROM _order_status_list WHERE id = :orderId");
            $result->execute(array(
                
                ':orderId' => $orderArr['id']
                
            ));
            
            if($result->rowCount()) {
                
                $orderArr = $result->fetch(PDO::FETCH_ASSOC);
                $return = $orderArr;
                
            }
    
        } catch (PDOException $e) {

            $alertList->push('danger', '<b>PDO Error!</b> ' . htmlspecialchars($e));
        }
        
        return $return;
        
    }
    
    public function getStatusList() {

        $alertList = new Alert();
        $return = array();
        
        try {
                    
            $db = DB::getConnection();
            $result = $db->query("SELECT * FROM _order_status_list");
            
            if($result->rowCount() > 0) {
                
                $statusListArr = $result->fetchAll(PDO::FETCH_ASSOC);
                $return = $statusListArr;
                
            }
    
        } catch (PDOException $e) {

            $alertList->push('danger', '<b>PDO Error!</b> ' . htmlspecialchars($e));
        }
        
        return $return;
            
    }
    
    public function setStatus($params) {
        
        $alertList = new Alert();
        $return = array();
        
        $company = new Company();
        $worker = new Worker();
        
        if($companyArr = $company->get()) {
            
            if($workerArr = $worker->get()) {
                
                if($orderArr = $this->get($params['order_id'])) {
                
                    if($statusArr = $this->getStatus($params['status_id'])) {

                        try {

                            $db = DB::getConnection();
                            $result = $db->prepare("UPDATE _order SET status_id = :statusId WHERE id = :orderId");
                            $result->execute(array(

                                ':statusId' => $params['status_id'],
                                ':orderId' => $params['order_id']

                            ));

                            $alertList->push('success', '{STATUS CHANGED AT <b>' . $statusArr['title'] . '</b> {IN_ORDER} <b>' . $orderArr['car_name'] . '[' . $orderArr['car_number'] . ']</b>');
                            Service::addAction('change_status', '{STATUS CHANGED AT} <b>' . $statusArr['title'] . '</b> {IN_ORDER} <b>' . $orderArr['car_name'] . '[' . $orderArr['car_number'] . ']</b>', $companyArr['id'], $workerArr['id']);

                        } catch (PDOException $e) {

                            $alertList->push('danger', '<b>PDO Error!</b> ' . htmlspecialchars($e));

                        }

                    } else {

                        $alertList->push('danger', '{STATUS_NOT_FOUND}');

                    }
                    
                }
                
            } else {
                
                $alertList->push('danger', '{WORKER_NOT_FOUND}');
                
            }
            
        } else {
                
            $alertList->push('danger', '{COMPANY_NOT_FOUND}');

        }

        return $return;
        
    }
    
}