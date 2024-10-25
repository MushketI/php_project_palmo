<?php

use Palmo\models\User;
use Palmo\service\View;
use Palmo\service\Validation;
use Palmo\middlewares\authMiddlewares;

class UserController {
    
    public function actionRegister() {
        
        $name = "";
        $email = "";
        $password = "";
        $result = false;

        $auth = authMiddlewares::auth();

        if($auth) {
            header('Location: /movies');
        }
     
        if(isset($_POST['register'])) {

            $name = htmlspecialchars($_POST['name']);
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);

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

        $view = new View();
        $view->component("/views/header/header.php");

        require_once(ROOT."/views/auth/register/register.php");
        return true;

    }

    public function actionLogin() {

        $email = "Test@gmail.com";
        $password = 123456789;

        $auth = authMiddlewares::auth();

        if($auth) {
            header('Location: /movies');
        }

        if(isset($_POST['login'])) {

            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);

            $hashPassword = Validation::getPasswordForEmail($email);   

            $errors = false;

            if(!Validation::checkEmail($email)) {
                $errors[] = 'Email is not valid';
            }

            if(!Validation::checkPassword($password)) {
                $errors[] = 'Password is not valid';
            }

            $user = User::login($email);

            if($user == false) {

                $errors[] = 'Неверный email';
                
            } else {
                
                if (password_verify($password, $hashPassword)) {

                    User::auth($user);
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
        unset($_SESSION['id']);
        unset($_SESSION['name']);
        unset($_SESSION['email']);
        header('Location: /movies');
    }
 }