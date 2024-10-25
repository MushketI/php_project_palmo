<?php 

namespace Palmo\service;

use Palmo\config\Db;
use PDO;

class Validation {

    public static function checkName($name) {

        if(strlen($name) >= 3 ) {
            return true;
        }

        return false;
    }

    public static function checkEmail($email) {
        
        if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }

        return false;
    }
    
    public static function checkPassword($password) {

        if(strlen($password) >= 6) {
            return true;
        }

        return false;
    }

    public static function checkEmailExists($email) {
        
        $db = Db::getConnection();
        
        $result = $db->prepare('SELECT COUNT(*) FROM users WHERE email = :email');

        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->execute();

        if($result->fetchColumn()){
            return true;
        } 

        return false;
    }

    public static function getPasswordForEmail($email) {

        $db = Db::getConnection();

        $result = $db->prepare("SELECT password FROM users WHERE email = :email");
        $result->execute(['email' => $email]);

        $password = $result->fetch();

        if($password) {
            return $password['password'];
        }

        return false;
        
    }

}