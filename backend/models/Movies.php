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

        if($id) {

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
        }
    }

    /**
    * Returns an array of news items
    */

    public static function getMoviesList($page = 1) {

        $db = Db::getConnection();

        $moviesList = [];

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

    public static function getMoviesByCategory($categoryName) {

        $db = Db::getConnection();

        $moviesList = [];

        $result = $db->prepare("SELECT movies.* FROM movies 
                JOIN movie_category ON movies.id = movie_category.movie_id 
                JOIN categories ON movie_category.category_id = categories.id 
                WHERE categories.name = :categoryName
                LIMIT 20");
        
        $result->execute(['categoryName' => $categoryName]);

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

    public static function getMoviesBySearch($search) {

        $db = Db::getConnection();

        $moviesList = [];

        $result = $db->prepare("SELECT * FROM movies where title like :search LIMIT 20");
        $result->execute(['search' => "%" . $search . "%"]);

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

    public static function getTotalMovies() {

        $db = Db::getConnection();

        $result = $db->query('SELECT count(id) as count FROM movies');

        $row = $result->fetch(\PDO::FETCH_ASSOC);
       
        return $row['count'];
    }
}