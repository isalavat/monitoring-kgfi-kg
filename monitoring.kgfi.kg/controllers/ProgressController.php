<?php

class ProgressController {
    public function actionIndex(){
        $groups = Group::getCurrentGroups();
        include(ROOT.'/views/progress/index.php');
    }
    
    public function actionStudents($groupId){
        $students = Group::getStudentsByGroup($groupId);
        $group = Group::getName($groupId);
        include(ROOT.'/views/progress/students.php');
    }
    
    public function actionGetStudentName(){
        User::getStudentName();
    }
    
    public function actionStudent($groupId, $studentId,$currentSemester ){
        $student = User::getStudentById($studentId);
        $name = $student['name'];
        $group = Group::getName($groupId);
        include(ROOT.'/views/progress/student.php');
    }
    
    public function actionGetNoteByStudent(){
        User::getNoteByStudent();
    }
    
    public function actionShowStudents(){
        include(ROOT.'/views/progress/students.php'); 
    } 
    public function actionShowStudentsResult($std_id){
        include(ROOT.'/views/progress/student.php'); 
    } 
    
    public function actionTop5($groupId){
        $currentSemester = Group::getCurrentSemester($groupId);
        $group = Group::getName($groupId);
        
        include(ROOT.'/views/progress/top5.php');
    }
    
    public function actionGetTop5(){
        Group::getTop5();
    }
}
