<?php 

namespace Palmo\models;

use Palmo\config\Db;

class User {

    public static function register($name, $email, $password) {

        $db = Db::getConnection();

        $result = $db->prepare('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
        $result->execute([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);
    }

    public static function login($email) {

        $db = Db::getConnection();

        $result = $db->prepare('SELECT * FROM users WHERE email = :email');
        $result->execute([
            'email' => $email,
        ]);

        $user = $result->fetch();

        if($user) {
            return $user['id'];
        }

        return false;
    }

    public static function auth($userId) {
        $_SESSION['user'] = $userId;
    }
}