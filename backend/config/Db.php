<?php 

class Db 
{
    public static function getConnection() 
    {
        $host = 'db';
        $port = 3306;
        $dbname = 'project_php_palmo';
        $user = 'root';
        $password = 'sql_course';

        $dsn = "mysql:host=$host;port=$port;dbname=$dbname";
        $db = new PDO($dsn, $user, $password);

        return $db;
    }
}