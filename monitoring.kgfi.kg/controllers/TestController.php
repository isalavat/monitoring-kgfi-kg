<?php


class TestController {
    public function actionIndex(){
        	
	
       // print_r(User::getAllStudentsByGroupIdJson(2));
        include(ROOT.'/views/test/json_.php');
    }
    public function actionGetJson(){
        $db     = Db::getConnection();
        $sql    = "select value from testing";
        $result = $db->prepare($sql);
        $result->execute();
        $students = array();
        $i = 0;
        
    }
}



