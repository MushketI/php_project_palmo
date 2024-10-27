<?php 

namespace Palmo\models;

use Palmo\config\Db;

class Movies {
    
    /**
    * Returnes singles news item with specifield id
    * @param integer $id
    */

    public static function getMoviesItemById($id) {

        $id = intval($id);

        if($id != 'string') {

            $db = Db::getConnection();

            $result = $db->prepare("SELECT * FROM movies WHERE id = :id");
            $result->execute(['id' => $id]);

            $newsItem = $result->fetch(\PDO::FETCH_ASSOC);

            $category = $db->prepare(
                "SELECT GROUP_CONCAT(categories.name SEPARATOR ', ') AS categories FROM movies 
                JOIN movie_category ON movies.id = movie_category.movie_id 
                JOIN categories ON movie_category.category_id = categories.id
                WHERE movies.id = :id 
                GROUP BY movies.id");

            $category->execute(['id' => $id]);
            $categories = $category->fetch(\PDO::FETCH_ASSOC);
            
            $newsItem['categories'] = $categories;
            
            return $newsItem;
        } else {
            return false;
        }
    }

    /**
    * Returns an array of news items
    */

    public static function getMoviesList($page = 1) {

        $db = Db::getConnection();

        $moviesList = [];

        if(!is_numeric($page)) {
            return false;
        } 

        $offset = ($page - 1) * 20;

        $result = $db->prepare("SELECT * FROM movies LIMIT 20 OFFSET :offset");
        $result->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $result->execute();

        $i = 0;
        while($row = $result->fetch()) {

            $category = $db->prepare(
                    "SELECT GROUP_CONCAT(categories.name SEPARATOR ', ') AS categories FROM movies 
                    JOIN movie_category ON movies.id = movie_category.movie_id 
                    JOIN categories ON movie_category.category_id = categories.id
                    WHERE movies.id = :id
                    GROUP BY movies.id");

            $category->execute(['id' => $row['id']]);
            $categories = $category->fetch(\PDO::FETCH_ASSOC);

            $moviesList[$i]['id'] = $row['id'];
            $moviesList[$i]['title'] = $row['title'];
            $moviesList[$i]['categories'] = $categories;
            $moviesList[$i]['overview'] = $row['overview'];
            $moviesList[$i]['poster_path'] = $row['poster_path'];
            $moviesList[$i]['release_date'] = $row['release_date'];
            $i++;
        }

        return $moviesList;
    } 

     /**
     * Returns an array of news items by category
     * @param string $categoryName
     */

    public static function getMoviesByCategory($categoryName, $page = 1) {

        $db = Db::getConnection();

        $offset = ($page - 1) * 20;

        $moviesList = [];

        $result = $db->prepare("SELECT movies.* FROM movies 
                JOIN movie_category ON movies.id = movie_category.movie_id 
                JOIN categories ON movie_category.category_id = categories.id 
                WHERE categories.name = :categoryName
                LIMIT 20 OFFSET :offset");
        
        $result->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $result->bindValue(':categoryName', $categoryName, \PDO::PARAM_STR);
        
        $result->execute();


        $i = 0;
        while($row = $result->fetch()) {

            $category = $db->prepare(
                "SELECT GROUP_CONCAT(categories.name SEPARATOR ', ') AS categories FROM movies 
                JOIN movie_category ON movies.id = movie_category.movie_id 
                JOIN categories ON movie_category.category_id = categories.id
                WHERE movies.id = :id 
                GROUP BY movies.id");

            $category->execute(['id' => $row['id']]);
            $categories = $category->fetch(\PDO::FETCH_ASSOC);

            $moviesList[$i]['id'] = $row['id'];
            $moviesList[$i]['title'] = $row['title'];
            $moviesList[$i]['categories'] = $categories;
            $moviesList[$i]['overview'] = $row['overview'];
            $moviesList[$i]['poster_path'] = $row['poster_path'];
            $moviesList[$i]['release_date'] = $row['release_date'];
            $i++;
        }

        return $moviesList;
    } 

    /**
    * Returns an array of news items by search
    * @param string $search
    */

    public static function getMoviesBySearch($search, $page = 1) {

        $db = Db::getConnection();

        $moviesList = [];

        $offset = ($page - 1) * 20;

        $result = $db->prepare("SELECT * FROM movies WHERE title LIKE :search LIMIT 20 OFFSET :offset");

        $result->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $result->bindValue(':search', "%" . $search . "%", \PDO::PARAM_STR);

        $result->execute();

        $i = 0;
        while($row = $result->fetch()) {

            $category = $db->prepare(
                "SELECT GROUP_CONCAT(categories.name SEPARATOR ', ') AS categories FROM movies 
                JOIN movie_category ON movies.id = movie_category.movie_id 
                JOIN categories ON movie_category.category_id = categories.id
                WHERE movies.id = :id 
                GROUP BY movies.id");
            
            $category->execute(['id' => $row['id']]);
            $categories = $category->fetch(\PDO::FETCH_ASSOC);

            $moviesList[$i]['id'] = $row['id'];
            $moviesList[$i]['title'] = $row['title'];
            $moviesList[$i]['categories'] = $categories;
            $moviesList[$i]['overview'] = $row['overview'];
            $moviesList[$i]['poster_path'] = $row['poster_path'];
            $moviesList[$i]['release_date'] = $row['release_date'];
            $i++;            
        }

        return $moviesList;
    }

      /**
     * Returns an count movies by params 
     * @param string $param 
     * @param string $str
     */


    public static function getTotalMovies($param, $str = null) {

        $db = Db::getConnection();

        if($param === 'movies') {

            $row = $db->query('SELECT COUNT(id) as count FROM movies');
            $total = $row->fetch(\PDO::FETCH_ASSOC);
           
            return $total['count'];
        }

        if($param === 'search') {

            $row = $db->prepare("SELECT COUNT(id) as count FROM movies WHERE title LIKE :search");
            $row->execute(['search' => "%" . $str . "%"]);
            $total= $row->fetch(\PDO::FETCH_ASSOC);

            return $total['count'];
         
        }

        if($param === 'select') {
            
            $row = $db->prepare("SELECT COUNT(movies.id) AS count FROM movies
                JOIN movie_category ON movies.id = movie_category.movie_id
                JOIN categories ON movie_category.category_id = categories.id
                WHERE categories.name = :categoryName");
            $row->execute(['categoryName' =>  $str ]);
            $total= $row->fetch(\PDO::FETCH_ASSOC);

            return $total['count'];

        }
    }
}