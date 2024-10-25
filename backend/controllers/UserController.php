<?php

use Palmo\models\User;
use Palmo\service\View;
use Palmo\service\Validation;

class UserController {
    
    public function actionRegister() {
        
        $name = "";
        $email = "";
        $password = "";
        $result = false;

        $view = new View();
        $view->component("/views/header/header.php");
     
        if(isset($_POST['register'])) {

            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            $errors = false;

            if(!Validation::checkName($name)) {
                $errors[] = 'Неправильное имя';
            } 
            
            if(!Validation::checkEmail($email)) {
                $errors[] = 'Неправильный email';
            }

            if(!Validation::checkPassword($password)) {
                $errors[] = 'Некоректный пароль';
            } 

            if(Validation::checkEmailExists($email)) {
                $errors[] = 'Этот email уже существует';
            } 

            if($errors == false) {

                $hashPassword = password_hash($password, PASSWORD_DEFAULT);
                $result = User::register($name, $email, $hashPassword);

            }
        }

        require_once(ROOT."/views/auth/register/register.php");
        return true;

    }

    public function actionLogin() {

        $email = "Test@gmail.com";
        $password = 123456789;

        if(isset($_POST['login'])) {

            $email = $_POST['email'];
            $password = $_POST['password'];

            $hashPassword = Validation::getPasswordForEmail('Test@gmail.com');   

            $errors = false;

            if(!Validation::checkEmail($email)) {
                $errors[] = 'Email is not valid';
            }

            if(!Validation::checkPassword($password)) {
                $errors[] = 'Password is not valid';
            }

            $userId = User::login($email);

            if($userId == false) {

                $errors[] = 'Неверный email';
                
            } else {
                
                if (password_verify($password, $hashPassword)) {

                    User::auth($userId);
                    header('Location: /movies');
                    
                } else {
                    $errors[] = 'Неверный пароль';
                } 
            }
        }

        $view = new View();
        $view->component('/views/header/header.php');

        require_once(ROOT."/views/auth/login/login.php");
        return true;
    }

    public function actionLogout() {
        unset($_SESSION['user']);
        header('Location: /movies');
    }
 }