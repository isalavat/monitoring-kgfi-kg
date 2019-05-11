<?php

function __autoload($className){
   
    $pathArray = array(
        "/components/",
        "/models/"
    );
    
    foreach($pathArray as $path){
        $filePath = ROOT.$path.$className.".php";
        if (is_file($filePath)){
            include_once $filePath;
            break;
        }
    }

}
