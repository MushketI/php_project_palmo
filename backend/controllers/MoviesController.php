<?php

use Palmo\models\Categories;
use Palmo\models\Movies;
use Palmo\service\View;

/**
 * Class MoviesController
 *
 * This controller handles the management of movie data, including listing, 
 * filtering by category, and other related functionalities.
 */

class MoviesController {


    /**
    * Display a listing of the movies
    *
    * @return array
    */

    public function actionIndex() {
        
        $view = new View();
        $view->component("/views/header/header.php");

        $moviesList = Movies::getMoviesList();
        $categories = Categories::getCategoriesList();

        if(isset($_GET['search'])) {
            
            $search = $_GET['search'];

            $moviesList = Movies::getMoviesBySearch($search);

            require_once(ROOT."/views/movie/movies/viewMovies.php");

            return true;
        }
        
        if(isset($_GET['select'][0])) {

            $categoryName = $_GET['select'];

            if (!in_array($categoryName, array_column($categories, 'name'))) {

                $view->component('/views/pageNotFound/pageNotFound.php');

                return true;
            }

            $moviesList = Movies::getMoviesByCategory($categoryName);

            require_once(ROOT."/views/movie/movies/viewMovies.php");
            
            return true;
        }
       
        require_once(ROOT."/views/movie/movies/viewMovies.php");
        
        return true;
    }


    /**
    * Display movie by id
    *
    * @param string  $id The name of the id to filter movies
    * @return array
    */

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

            return true;
        } 
    }
}