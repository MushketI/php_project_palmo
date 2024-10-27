<?php

use Palmo\middlewares\authMiddlewares;
use Palmo\service\Pagination;
use Palmo\models\Categories;
use Palmo\models\Favorit;
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

        $errors = false;

        if(isset($_GET['search'])) {

            $search = htmlspecialchars($_GET['search']);

            $total = Movies::getTotalMovies('search', $search);
            $pagination = new Pagination($total, $page, 20);

            $moviesList = Movies::getMoviesBySearch($search, $page);

            if(count($moviesList) == 0) {
                $errors = 'Фильмы не найдены';
            }

            require_once(ROOT."/views/movie/movies/viewMovies.php");
            return true;
        }
        
        if(isset($_GET['select'][0])) {

            $categoryName = htmlspecialchars($_GET['select']);
            
            $total = Movies::getTotalMovies('select', $categoryName);
            $pagination = new Pagination($total, $page, 20);

            $moviesList = Movies::getMoviesByCategory($categoryName, $page);

            if(count($moviesList) == 0) {
                $errors = 'Фильмы не найдены';
            }
           
            require_once(ROOT."/views/movie/movies/viewMovies.php");
            return true;
        }



        if(!$moviesList) {
            $view->component('/views/pageNotFound/pageNotFound.php');
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

            $auth = authMiddlewares::auth();

            if (!in_array($id, $movieItem)) {
                
                $view->component('/views/pageNotFound/pageNotFound.php');
                return true;
            }
            
            $favorit = Favorit::searchMovieForFavorit($movieItem['id'], $auth);

            require_once(ROOT."/views/movie/singMovie/viewSingMovie.php");
            return true;
        } 
    }
}