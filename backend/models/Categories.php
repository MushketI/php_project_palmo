<?php

namespace Palmo\models;

use Palmo\config\Db;

class Categories {

    /**
     * Returns an array of news items
     */
    
    public static function getCategoriesList() {

        $db = Db::getConnection();

        $categoriesList = [];
        
        $result = $db->query('SELECT * FROM categories');

        $i = 0;
        while($row = $result->fetch()) {
            $categoriesList[$i]['id'] = $row['id'];
            $categoriesList[$i]['name'] = $row['name'];
            $i++;
        }

        return $categoriesList;
    }
}