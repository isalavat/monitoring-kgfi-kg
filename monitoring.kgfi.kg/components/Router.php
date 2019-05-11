<?php

class Router {
    private $routes;
    public function __construct() {
        $routesPath = ROOT."/config/routes.php";
        $this->routes = include($routesPath);
    }
    private function getUri(){
        return trim($_SERVER["REQUEST_URI"],"/");
    }
    public function run(){
        $uri = $this->getUri();
        foreach($this->routes as $uriPattern=>$path){
            if (preg_match("~$uriPattern~",$uri)){
                $internalUri = preg_replace("~$uriPattern~", $path, $uri);
                $segments = explode("/",$internalUri);
                
                $controllerName = array_shift($segments)."Controller";
                $controllerName = ucfirst($controllerName);
                $actionName = "action".ucfirst(array_shift($segments));
                $parameters = $segments;
                if (file_exists(ROOT."/controllers/".$controllerName.".php")){
                   include(ROOT."/controllers/".$controllerName.".php") ;
                }
                
                $controllerObject = new $controllerName;
                $result = call_user_func_array(array($controllerObject, $actionName),$parameters);
                
                    break;
                
               
            }
        }
        
    }
}
