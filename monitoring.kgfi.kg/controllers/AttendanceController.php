<?php


class AttendanceController {
    public function actionIndex(){
        $groups = Group::getCurrentGroups();
        include (ROOT."/views/attendance/index.php");
    }
     public function actionShow($groupId){
        $m = array("Januar", "Februar","Mart", "April","Mai", "Juni","Juli", "August","September", "October","Nowember", "December");
        $name = Group::getName($groupId);
        $months =  Group::getMonth($groupId);
        include (ROOT."/views/attendance/charts.php");
    }
    
    public function actionGetDays(){
        
        Group::getAttendanceDays();
    }
    
    public function actionGetEvents(){
        Group::getEvents();
    }
    
    public function actionGetStudentsCount(){
        Group::getStudentsCount();
    }
    
    public function actionGetStudents(){
        Group::getStudents();
    }
    
    public function actionAdminIndex(){
        include (ROOT."/views/attendance/admi.php");
    }
}
