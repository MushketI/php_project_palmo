<?php

use Palmo\models\Categories;
use Palmo\models\Movies;
use Palmo\service\View;

class MoviesController {

    public function actionIndex() {
        
        $view = new View();
        $view->component("/views/header/header.php");

        $moviesList = Movies::getMoviesList();
        $categories = Categories::getCategoriesList();
        
        if(isset($_GET['select'][0])) {
            
            $categoryName = $_GET['select'];
            $moviesList = Movies::getMoviesByCategory($categoryName);

            require_once(ROOT."/views/movie/movies/viewMovies.php");

            return true;

        }
       
        require_once(ROOT."/views/movie/movies/viewMovies.php");
       
        return true;
    }

    public function actionView($id) {
        
        if($id) {

            $view = new View();
            $view->component("/views/header/header.php");

            $movieItem = Movies::getMoviesItemById($id);

            if (!in_array($id, $movieItem)) {
                
                $view->component('/views/pageNotFound/pageNotFound.php');

                return true;
            }
           
            require_once(ROOT."/views/movie/singMovie/viewSingMovie.php");

        } 

        return true;
    }

}