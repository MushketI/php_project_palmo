<?php 

namespace Palmo\models;

use Palmo\config\Db;

class News 
{
    /**
     * Returnes singles news item with specifield id
     * @param integer $id
     */

    public static function getNewsItemById($id) 
    {
        $id = intval($id);

        if($id) {

            $db = Db::getConnection();

            $result = $db->query('SELECT * FROM news WHERE id=' . $id);

            $result->setFetchMode(\PDO::FETCH_ASSOC);
            $newsItem = $result->fetch();

            return $newsItem;
        }
    }
    
    /**
     * Returns an array of news items
     */

    public static function getNewsList() 
    {
        $db = Db::getConnection();

        $newsList = array();

        $result = $db->query('SELECT * FROM news');

        $i = 0;
        while($row = $result->fetch()) {
            $newsList[$i]['id'] = $row['id'];
            $newsList[$i]['title'] = $row['title'];
            $newsList[$i]['short_content'] = $row['short_content'];
            $newsList[$i]['created_at'] = $row['created_at'];
            $i++;
        }

        return $newsList;
    } 

}