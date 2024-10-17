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

            $result = $db->query('SELECT * FROM movies WHERE id=' . $id);
            
            $result->setFetchMode(\PDO::FETCH_ASSOC);
            $newsItem = $result->fetch();

            $category = $db->query(
                "SELECT GROUP_CONCAT(categories.name SEPARATOR ', ') AS categories FROM movies 
                JOIN movie_category ON movies.id = movie_category.movie_id 
                JOIN categories ON movie_category.category_id = categories.id
                WHERE movies.id = $id 
                GROUP BY movies.id")->fetch(\PDO::FETCH_ASSOC);

            $newsItem['categories'] = $category;
            
            return $newsItem;
        }
    }

    /**
     * Returns an array of news items
     */

    public static function getMoviesList() {

        $db = Db::getConnection();

        $moviesList = [];

        $result = $db->query('SELECT * FROM movies LIMIT 20');

        $i = 0;
        while($row = $result->fetch()) {

            $category = $db->query(
                    "SELECT GROUP_CONCAT(categories.name SEPARATOR ', ') AS categories FROM movies 
                    JOIN movie_category ON movies.id = movie_category.movie_id 
                    JOIN categories ON movie_category.category_id = categories.id
                    WHERE movies.id = $row[id] 
                    GROUP BY movies.id")->fetch(\PDO::FETCH_ASSOC);

            $moviesList[$i]['id'] = $row['id'];
            $moviesList[$i]['title'] = $row['title'];
            $moviesList[$i]['categories'] = $category;
            $moviesList[$i]['overview'] = $row['overview'];
            $moviesList[$i]['poster_path'] = $row['poster_path'];
            $moviesList[$i]['release_date'] = $row['release_date'];
            $i++;
        }

        return $moviesList;
    } 

    public static function getMoviesByCategory($categoryName) {

        $db = Db::getConnection();

        $moviesList = [];

        $result = $db->query("SELECT movies.* FROM movies 
                JOIN movie_category ON movies.id = movie_category.movie_id 
                JOIN categories ON movie_category.category_id = categories.id 
                WHERE categories.name = '$categoryName'
                LIMIT 20");
        
        $i = 0;
        while($row = $result->fetch()) {

            $category = $db->query(
                "SELECT GROUP_CONCAT(categories.name SEPARATOR ', ') AS categories FROM movies 
                JOIN movie_category ON movies.id = movie_category.movie_id 
                JOIN categories ON movie_category.category_id = categories.id
                WHERE movies.id = $row[id] 
                GROUP BY movies.id")->fetch(\PDO::FETCH_ASSOC);

            $moviesList[$i]['id'] = $row['id'];
            $moviesList[$i]['title'] = $row['title'];
            $moviesList[$i]['categories'] = $category;
            $moviesList[$i]['overview'] = $row['overview'];
            $moviesList[$i]['poster_path'] = $row['poster_path'];
            $moviesList[$i]['release_date'] = $row['release_date'];
            $i++;
        }

        return $moviesList;
    } 
}