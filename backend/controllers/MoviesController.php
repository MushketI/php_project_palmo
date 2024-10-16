<?php 

use Palmo\models\Movies;
use Palmo\service\View;

class MoviesController {

    public function actionIndex() {
        
        $view = new View();
        $view->component("/views/header/header.php");

        $moviesList = Movies::getMoviesList();
   
        require_once(ROOT."/views/movie/movies/viewMovies.php");
       
        return true;
    }

    public function actionView($id) {
        
        if($id) {

            $view = new View();
            $view->component("/views/header/header.php");

            $movieItem = Movies::getMoviesItemById($id);
           
            require_once(ROOT."/views/movie/singMovie/viewSingMovie.php");

        } else {
            echo 'Page not found';
        }
        
        return true;
    }

}