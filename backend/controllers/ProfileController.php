<?php

use Palmo\middlewares\authMiddlewares;
use Palmo\models\Favorit;
use Palmo\service\View;


class ProfileController {
    
    public function actionIndex() {
        
        $auth = authMiddlewares::auth();

        if($auth) {

            $view = new View();
            $view->component('/views/header/header.php');

            $moviesList = Favorit::getFavoritMoviesByUser($auth);

            require_once(ROOT."/views/profile/profile.php");
            
        } else {
            header('Location: /user/login');
        }
    }
}