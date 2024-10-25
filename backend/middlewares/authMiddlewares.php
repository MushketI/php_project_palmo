<?php 

namespace Palmo\middlewares;

class authMiddlewares {
    
    public static function auth() {

        if(isset($_SESSION['id'])) {
            return $_SESSION['id'];
        } else {
            return false;
        }
    }
}