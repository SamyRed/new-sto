<?php

class User {
    
    private $id;
    
    public function __construct() {
        
    }
    
    public function get($id = null) {
        
        $alertList = new Alert();
        $return = false;
        
        if($id !== null) {
            
            $userId = $id;
            
        } else {
        
            if(!empty($_SESSION['user_id'])) {

                $userId = $_SESSION['user_id'];
                
            } else {
                
                $userId = null;
                
            }
            
        }
        
        if($userId !== null) {

            try {

                $db = DB::getConnection();

                $query = $db->prepare("SELECT * FROM _user WHERE id = :id");
                $query->execute(array(

                    ':id' => $userId

                ));

                $userArr = $query->fetch(PDO::FETCH_ASSOC);
                $return = $userArr;

            } catch(PDOException $e) {

                $alertList::push('danger', '<b>PDO Error!</b>' . htmlspecialchars($e));
                $return = false;

            }
            
        } else {
            
            $return = false;
            
        }
        
        return $return;
        
    }
    
    public function set($id) {
        
        try {
            
            $db = DB::getConnection();
            
            $query = $db->prepare("SELECT count(*) FROM _user WHERE id = :id");
            $query->execute(array(
                
                ':id' => $id
                
            ));
            
            if($query->rowCount() > 0) {
                
                $_SESSION['user_id'] = $id;
                $return = true;
                
            } else {
                
                $return = false;
                
            }
            
        } catch(PDOException $e) {
            
            $return = false;
            
        }
        
        return $return;
        
    }
    
    public function registration($params) {
        
        var_dump($params);
        
    }
    
    public function logIn($params) {
        
        $return = array();
        $user = new User();
        $alertList = new Alert();
        $email = $params['formData']['e-mail'];
        $password = $params['formData']['password'];
        
        try {
        
            $db = Db::getConnection();

            $query = $db->prepare("SELECT * FROM _user WHERE email = :email");
            $query->execute(array(':email' => $email));

            if($query->rowCount() === 1) {
                
                $userArr = $query->fetch(PDO::FETCH_ASSOC);
                
                if((bool)$userArr['is_confirmed'] === true) {
                    
                    if (password_needs_rehash($userArr['password_hash'], PASSWORD_DEFAULT)) {
                        
                        $passwordHash = password_hash ($password, PASSWORD_DEFAULT);
                        
                        $query = $db->prepare ("UPDATE _user SET password_hash = :passwordHash WHERE id = :userId");
                        $query->execute(array(
                            
                            ':passwordHash' => $passwordHash,
                            ':userId' => $userArr['id']
                                
                        ));
                        
                    }
                    
                    if (password_verify($password, $userArr['password_hash'])) {
                        var_dump((int)$userArr['id']);
                        $user->set((int)$userArr['id']);
                        
                        $return['reload'] = true;
                        
                    } else {
                        $alertList->push('danger', '{PASSWORD_OR_EMAIL_IS_WRONG}');
                    }
                } else {
                    $alertList->push('danger', '{EMAIL_IS_NOT_CONFIRMED}');
                }
            } else {
                $alertList->push('danger', '{PASSWORD_OR_EMAIL_IS_WRONG}');
            }
        } catch (PDOException $e) {
            
            $alertList->push('danger', '<b>PDO Error!</b>' . htmlspecialchars($e));
            
        }

        return $return;
        
    }
    
    public function logOut() {
        
        $return = array();
        
        unset($_SESSION['user_id']);
        
        $return['reload'] = true;
        
        return $return;
        
    }
    
}