<?php 

namespace Palmo\middlewares;

class authMiddlewares {
    
    public static function auth() {

        if(isset($_SESSION['user'])) {
            return $_SESSION['user'];
        } else {
            return false;
        }
    }
}