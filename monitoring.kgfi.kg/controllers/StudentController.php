<?php


class StudentController {
    public function actionIndex(){
       User::checkLoggedHeadStudent();
       $groupId = User::getGroupId($_SESSION['id']);
        include (ROOT."/views/student/index.php");
    }
    
    public function actionEvents(){
       User::checkLoggedHeadStudent();
       $groupId = User::getGroupId($_SESSION['id']);
       include (ROOT."/views/student/events.php");
    }
    public function actionGetAttendance(){
        Group::getAttendance();
    }
    public function actionSaveAttendance(){
        Group::saveAttendance();
    }
    
    public function actionGetLastEvents(){
        Group::getLastEvents();
    }
    
    public function actionGetStudents(){
        User::getAllStudentsByGroupIdJson2();
    }
    
    public function actionNewEvent(){
        Group::newEvent();
    }
       
    
}

