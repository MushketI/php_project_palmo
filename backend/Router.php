<?php 

namespace Palmo;

class Router 
{
    private $routes;

    public function __construct()
    {
        $routesPath = ROOT.'/config/routes.php';
        $this->routes = include($routesPath);
       
    }

    /**
    * Returnes request string
    * @return string
    */

    private function getURI() {
        
        // if(!empty($_SERVER['REQUEST_URI'])) {
        //     return trim($_SERVER['REQUEST_URI'], '/');
        // }
        
        if(!empty($_SERVER['REQUEST_URI'])) {
            // Используем parse_url для разделения пути и GET параметров
            $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); 
            return trim($uri, '/');
        }

    }

    public function run() {
       
        //Получаем строку запроса
        $uri = $this->getURI();
        
        //Проверить наличие такого запроса в routes.php
        foreach($this->routes as $uriPattern => $path) {
            
            //Сравниваем $uriPattern и $uri
            if(preg_match("~$uriPattern~", $uri)) {

                //Получаем внутрений путь из внешнего согласно правилу 
                $internalRouter = preg_replace("~$uriPattern~", $path, $uri);
              
                //Определить контроллер, action, параметры
                
                $segments = explode('/', $internalRouter); 

                $controllerName = array_shift($segments).'Controller';
                $controllerName = ucfirst($controllerName);
                
                $actionName = 'action'.ucfirst(array_shift($segments));
               
                $parameters = $segments;
                
                //Подключить файл класса-контроллера
                $controllerFile = ROOT . '/controllers/' . $controllerName . '.php';

                if(file_exists($controllerFile)) {
                    include_once($controllerFile);
                } else {
                    include_once(ROOT . '/views/pageNotFound/pageNotFound.php');
                    break;
                }

                //Создать обьект, вызвать метод (т.е. action)
                $controllerObject = new $controllerName;

              
                if(method_exists($controllerObject, $actionName)) {
                    $result = call_user_func_array(array($controllerObject, $actionName), $parameters);
                } else {
                    include_once(ROOT . '/views/pageNotFound/pageNotFound.php');
                }
        
                //old:
                // $result = $controllerObject->$actionName($parameters);

                if($result != null) {
                    break;
                }
            }
        }
    }
}

?>