<?php 

namespace Palmo\models;
use Palmo\config\Db;

class Favorit {

    public static function addToFavorit($movieId, $userId) {

        $db = Db::getConnection();

        $result = $db->prepare("INSERT INTO favorite (user_id, movies_id) VALUE (:userId, :movieId)");
        $result->execute([
            'userId' => $userId,
            'movieId' => $movieId,
        ]);

        if($result->rowCount() > 0) {
            return true;
        } 

        return false;
    }

    public static function removeToFavorit($movieId, $userId) {

        $db = Db::getConnection();

        $result = $db->prepare("DELETE from favorite WHERE user_id = :userId AND movies_id = :movieId");
        $result->execute([
            'userId' => $userId,
            'movieId' => $movieId,
        ]);

        if($result->rowCount() > 0) {
            return true;
        }

        return false;
    }

    public static function searchMovieForFavorit($movieId, $userId) {

        $db = Db::getConnection();

        $result = $db->prepare("SELECT * FROM favorite WHERE user_id = :userId AND movies_id = :moviesId");
        $result->bindValue(':moviesId', $movieId, \PDO::PARAM_INT);
        $result->bindValue(':userId', $userId, \PDO::PARAM_INT);
        $result->execute();
 
        if($result->fetchColumn()) { 
            return true;
        } 

        return false;
    }


    public static function getFavoritMoviesByUser($userId) {

        $db = Db::getConnection();
        $result = $db->prepare("SELECT * FROM movies JOIN favorite ON movies.id = favorite.movies_id WHERE favorite.user_id = :userId");
        $result->execute(['userId' => $userId]);

        $moviesList = [];

        $i = 0;
        while($row = $result->fetch()) {
            $moviesList[$i]['id'] = $row['id'];
            $moviesList[$i]['movies_id'] = $row['movies_id'];
            $moviesList[$i]['title'] = $row['title'];
            $moviesList[$i]['poster_path'] = $row['poster_path'];
            $i++;
        }

        return $moviesList;
    }
}