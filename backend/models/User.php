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

            $user = [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email']
            ];

            return $user;
        }

        return false;
    }

    public static function auth($user) {
        $_SESSION['id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['email'] = $user['email'];
    }


}