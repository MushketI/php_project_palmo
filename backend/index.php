<?php 

//Front Controller

//1. Общие настройки:
ini_set('display_error', 1);
error_reporting(E_ALL);

//2. Подключение файлов системы:\
require 'vendor/autoload.php';
define('ROOT', dirname(__FILE__));
require_once(ROOT. '/Router.php');
require_once(ROOT. '/config/Db.php');

//3. Вызов Router
$router = new Router();
$router->run();