<?php

use Palmo\middlewares\authMiddlewares;
use Palmo\models\Favorit;

class FavoritController {

    public function actionAdd() {
        
        $movieId = $_POST['id'];
        $auth = authMiddlewares::auth();

        if(!$auth) {
            header('Location: /user/login');
        }

        $favorit = Favorit::addToFavorit($movieId, $auth);


        if($favorit) {
            header("Location: /movies/$movieId");
        }
        
        return true;
    }

    public function actionRemove() {

        $movieId = $_POST['id'];
        $auth = authMiddlewares::auth();

        if(!$auth) {
            header('Location: /user/login');
        }

        $favorit = Favorit::removeToFavorit($movieId, $auth);

        if($favorit) {
            header("Location: /movies/$movieId");
        }
        
        return true;
    }
}