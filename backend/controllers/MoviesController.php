<?php

use Palmo\models\Categories;
use Palmo\service\Pagination;
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

    public function actionIndex($page = 1) {

        $total = Movies::getTotalMovies('movies');
   
        $pagination = new Pagination($total, $page, 20);

        $view = new View();
        $view->component("/views/header/header.php");

        $moviesList = Movies::getMoviesList($page);
        $categories = Categories::getCategoriesList();

        if(isset($_GET['search'])) {

            $search = $_GET['search'];

            $total = Movies::getTotalMovies('search', $search);
            $pagination = new Pagination($total, $page, 20);

            $moviesList = Movies::getMoviesBySearch($search, $page);

            require_once(ROOT."/views/movie/movies/viewMovies.php");
            return true;
        }
        
        if(isset($_GET['select'][0])) {

            $categoryName = $_GET['select'];

            $total = Movies::getTotalMovies('select', $categoryName);
            $pagination = new Pagination($total, $page, 20);

            if (!in_array($categoryName, array_column($categories, 'name'))) {

                $view->component('/views/pageNotFound/pageNotFound.php');
                return true;
            }

            $moviesList = Movies::getMoviesByCategory($categoryName, $page);
           
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