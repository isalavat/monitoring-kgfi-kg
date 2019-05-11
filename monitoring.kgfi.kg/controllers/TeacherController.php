<?php

class TeacherController {
    public function actionIndex(){
        User::checkLoggedTeacher();
        include(ROOT."/views/teacher/index.php");
    }
    
    public function actionGetGroups(){
        Group::getGroupsByTeacherJson();
    }
    
    public function  actionGetIdJson(){
        User::getTeacherIdJson();
    }
    public function  actionGetLessons(){
        Lesson::getTaecherLessonsJson();
    }
    
    public function actionGetStudentsByGroup(){
        User::getAllStudentsByTeacherByGroupIdJson();
    }
    public function actionGetNotesByGroup(){
       User::getAllNotesByTeacherByGroupIdJson(); 
    }
    
}
