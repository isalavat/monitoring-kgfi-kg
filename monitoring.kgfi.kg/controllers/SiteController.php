<?php

class SiteController {
    public function actionIndex(){
        User::checkLogged();   
       include (ROOT."/views/site/index.php");
        
    }
  
    
}
