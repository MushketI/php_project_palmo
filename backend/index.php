<?php 

use Palmo\Router;
use Palmo\config\Db;

//1. Общие настройки:
require __DIR__ . '/vendor/autoload.php';

//Вывод errors:
ini_set('display_error', 1);
error_reporting(E_ALL);

//2. Подключение файлов системы:
define('ROOT', dirname(__FILE__));

//3. Вызов Router
$router = new Router();
$router->run();