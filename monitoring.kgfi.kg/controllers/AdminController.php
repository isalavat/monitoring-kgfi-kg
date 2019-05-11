<?php

class AdminController {
   
    public function actionIndex(){
        User::checkLoggedAdmin();
        include(ROOT."/views/admin/index.php");
    }
    
    public function actionLessons(){
        User::checkLoggedAdmin();
        include(ROOT."/views/admin/lessons/index.php");
    }
    
    public function actionTeachers(){
        User::checkLoggedAdmin();
        include(ROOT."/views/admin/teachers/index.php");
    }
   
    public function actionLessonsGroups(){
        User::checkLoggedAdmin();
        include(ROOT."/views/admin/lessonsGroup.php");
    }
    
    public function actionEditSemester(){
        User::checkLoggedAdmin();
        include(ROOT."/views/admin/semesters/index.php");
    }
    
    public function actionSemesterTranslate(){
        Group::semesterTranslateJson();
        
    }
    
    public function actionTest(){
        User::checkLoggedAdmin();
        include(ROOT."/views/admin/test/index.php");
    }
    
    //Group
  
    public function actionAddGroup(){
         User::checkLoggedAdmin();
         $errors = false;
         $success = false;
         $name = '';
         $description = '';
         if(isset($_POST['submit'])){
            
            $name = $_POST['name'];
            $description = $_POST['description'];
            unset($_POST);
            if (Group::checkExistsGroup($name)){
                $errors[] = 'Группа с данным названием уже существует';
            }else{
                $success = Group::addGroup($name, $description);
                if (!$success){
                    $errors[] = 'Не удалось добавить в базу данных';
                }else{
                    header("Location: /admin");
                } 
                
            }
        }
                 
        include(ROOT."/views/admin/addGroup.php");
        
    }
  
    public function actionGetAllGroups(){
        echo Group::getAllGroupsJson();
    }
    
    public function actionEditGroup($id){
        User::checkLoggedAdmin();
        $group = Group::getGroupById($id);
        $errors = false;
         $success = false;
         $name = '';
         $description = '';
         
         if(isset($_POST['submit'])){
             
            $name = $_POST['name'];
            $description = $_POST['description'];
            if (strcmp($group['name'], $name) != 1 ){
                if (Group::checkExistsGroup($name)){
                    $errors[] = 'Группа с данным названием уже существует';
                }else{
                    header("Location: /admin");
                }
            }
            if ($errors == false){
                unset($_POST);
                $success = Group::editGroupById($id, $name, $description);
                if (!$succes){
                    $errors[] = "Не удалось сделать изменение";
                }else{
                    header("Location: /admin");
                }
            }
        }
                 
        include(ROOT."/views/admin/editGroup.php");
        
    }
    
    public function actionDeleteGroup($id){
        User::checkLoggedAdmin();
        $group = Group::getGroupById($id);
        $success = false;
        $errors = false;
        if(isset($_POST['submit'])){
            unset($_POST);
            $success = Group::deleteGroupById($id); 
            if (!$success){
                $errors[] = 'Не удалось сделать удаление';
            }else{
                    header("Location: /admin");
            }
        }
                 
        include(ROOT."/views/admin/deleteGroup.php");
        
    }
   
    
    //Teachers
    public function actionDeleteLessonTeacher($lessonId, $teacherId){
        User::checkLoggedAdmin();
        if (!isset($_POST['submit'])){
            $teacher = User::getTeacherById($teacherId);
        }
        $success = false;
        $errors = false;
        if (isset($_POST['submit'])){
            unset($_POST);
            $success = Lesson::deleteLessonTeacher($lessonId, $teacherId);
            if (!$success){
                $errors[] = 'Не удалось сделать удаление';
            }else{
                 header("Location: /admin/teachers");
            }
        }
        include (ROOT.'/views/admin/deleteLessonTeacher.php');
    }
   
    public function actionAddTeacher(){
         User::checkLoggedAdmin();
         //print_r($_POST);
         $errors = false;
         $success = false;
         $name = "";
         $login = "";
         if(isset($_POST['submit'])){
            
            $name = $_POST['name'];
            $login = $_POST['login'];
            
            if (!User::checkLogin($login)){
                $errors[] = 'Логин должен содержать более 4-х символов';
            }
            
            $password = $_POST['password'];
            
            if (!User::checkPassword($password)){
                $errors[] = 'Пароль должен содержать более 4-х символов';
            }
            $password_2 = $_POST['password-2'];
            unset($_POST);
            if (!User::checkTwoPasswords($password, $password_2)){
                $errors[] = 'Пароли не совпадают';
            }
            if ($errors == false){
                $success = User::addTeacher($name, $login, $password);
                if (!$success){
                    $errors[] = 'Не удалось добавить в базу данных';
                }else{
                    header("Location: /admin/teachers");
            }
            }
         }
                 
        include(ROOT."/views/admin/addTeacher.php");
        
    }
   
    public function actionGetAllTeachers(){
        echo User::getAllTeachersJson();
    }
   
    public function actionDeleteTeacher($id){
        User::checkLoggedAdmin();
        if (!isset($_POST['submit'])){
            $teacher = User::getTeacherById($id);
        }
        $success = false;
        $errors = false;
        if(isset($_POST['submit'])){
            unset($_POST);
            $success = User::deleteTeacher($id);
            if (!$success){
                $errors[] = 'Не удалось сделать удаление';
            }else{
                 header("Location: /admin/teachers");
            }
        }
                 
        include(ROOT."/views/admin/deleteTeacher.php");
        
    }
   
    public function actionGetLessonTeachers(){
        User::getLessonTeachersJson();
    }
    
    public function actionAddLessonTeacher($id){
        User::checkLoggedAdmin();
        $teachers = User::getTeachers();
        $lesson = Lesson::getLesson($id);
        
        $errors = false;
        $success = false;
        if (isset($_POST['submit'])){
            $teacherId = $_POST['teacher'];
            unset($_POST);
            if (!Lesson::checkExistsTeacher($id, $teacherId)){
                $errors[] = "Такой преподаватель уже имеется";
            }else{
            $success = Lesson::addTeacher($id, $teacherId);
            if (!$success){
                $errors[] = 'Не удалось сделать добавление';
            }else{
                 header("Location: /admin/teachers");
            }
            }
        }
        include (ROOT."/views/admin/addLessonTeacher.php");
    }
 
    public function actionGetAllLessonTeachers(){
        Lesson::getAllLessonTeachersJson();
    }
    
    public function actionEditTeacher($id){
        User::checkLoggedAdmin();
        if(!isset($_POST['submit'])){
            $teacher = User::getTeacherById($id);
        }
        $errors = false;
        $success = false;
        if (isset($_POST['submit'])){
            $name = $_POST['name'];
            if (!User::checkName($name)){
                $errors[] = 'Введите имя';
            }
                        
            unset($_POST);
            
            if ($errors == false){
                $success = User::editTeacher($id, $name);
                if (!$success){
                    $errors[] = 'Не удалось добавить в базу данных';
                }else{
                 header("Location: /admin/teachers");
                }
                
            }
        }
        include (ROOT."/views/admin/editTeacher.php");
    }
    
    
    //Student
    public function actionAddStudent(){
         User::checkLoggedAdmin();
         $groups = Group::getAllGroups();
         $errors = false;
         $success = false;
         $name = "";
         $login = "";
         if(isset($_POST['submit'])){
            
            $name = $_POST['name'];
            if (!User::checkName($name)){
                $errors[] = 'Введите имя';
            }
            $groupId = $_POST['group'];
            $login = $_POST['login'];
            if (!User::checkLogin($login)){
                $errors[] = 'Логин должен содержать более 4-х символов';
                
            }
            
            if (!User::checkExistsLogin($login)){
                $errors[] = 'Такой логин уже существует';
                
            }
            
            $password = $_POST['password'];
            if (!User::checkPassword($password)){
                $errors[] = 'Пароль должен содержать более 4-х символов';
                
                
            }
            $password_2 = $_POST['password-2'];
            unset($_POST);
            if (!User::checkTwoPasswords($password, $password_2)){
                $errors[] = 'Пароли не совпадают';
                
                
            }
            if ($errors == false){
                $success = User::addStudent($name, $login, $password, $groupId);
                if (!$success){
                    $errors[] = 'Не удалось добавить в базу данных';
                }else{
                    header("Location: /admin");
                }
                
            }
         }
                 
        include(ROOT."/views/admin/addStudent.php");
        
    }
    
    public function actionStudentsByGroup(){
        User::getAllStudentsByGroupIdJson();
    }
    
    public function actionEditStudent($id){
        User::checkLoggedAdmin();
        $student = User::getStudentById($id);
        $groups = Group::getAllGroups();
        $errors = false;
        $success = false;
        if (isset($_POST['submit'])){
            $name = $_POST['name'];
            if (!User::checkName($name)){
                $errors[] = 'Введите имя';
            }
            $groupId = $_POST['group'];
            
            unset($_POST);
            
            if ($errors == false){
                $success = User::editStudent($id, $name , $groupId);
                if (!$success){
                    $errors[] = 'Не удалось добавить в базу данных';
                }else{
                    header("Location: /admin");
                }
                
            }
        }
        include (ROOT."/views/admin/editStudent.php");
    }
    
    public function actionDeleteStudent($id){
        User::checkLoggedAdmin();
        if (!isset($_POST['submit'])){
            $student = User::getStudentById($id);
        }
        $success = false;
        $errors = false;
        if(isset($_POST['submit'])){
            unset($_POST);
            $success = User::deleteStudent($id);
            if (!$success){
                $errors[] = 'Не удалось сделать удаление';
            }else{
                header("Location: /admin");
            }
        }
                 
        include(ROOT."/views/admin/deleteStudent.php");
        
    }
        
    
    //Lessons
    public function actionAddLesson(){
         User::checkLoggedAdmin();
         $errors = false;
         $success = false;
         $name = "";
         $description = "";
         if(isset($_POST['submit'])){
            $name = $_POST['name'];
            $description =  $_POST["description"];
            unset($_POST);
            if (Lesson::checkExistsLesson($name)){
                $errors[] = "Предмет с таким названием уже существует !";
            }else{
                $success = Lesson::addLesson($name, $description);
                if (!$success){
                    $errors[] = "Не удалось добавить в базу данных";
                }else{
                    header("Location: /admin/lessons");
                }
            }
         }
                 
        include(ROOT."/views/admin/addLesson.php");
        
    }
    
    public function actionGetAllLessons(){
        echo Lesson::getAllLessonsJson();
    }
       
    public function actionDeleteLessonsGroup($id){
        User::checkLoggedAdmin();
        $lg = Lesson::getLessonsGroup($id);
        $success = false;
        $errors = false;
        if(isset($_POST['submit'])){
            unset($_POST);
            $success = Lesson::deleteLessonsGroup($id); 
            if (!$success){
                $errors[] = 'Не удалось сделать удаление';
            }else{
                    header("Location: /admin/lessons-groups");
            }
        }
                 
        include(ROOT."/views/admin/deleteLessonsGroup.php");
        
    }
    
    public function actionChooseLessonsGroup($group , $semester){
        User::checkLoggedAdmin();
        $lessonsGroups = Lesson::getLessonsGroups();
        
        $success = false;
        $errors = false;
        if(isset($_POST['submit'])){
            $lessonsGroupId = $_POST['lessons-group'];
            $success = Group::addLessonsGroup($group, $semester, $lessonsGroupId); 
            if (!$success){
                $errors[] = 'Не удалось cделать операцию';
            }else{
                header("Location: /admin");
            }
        }
                 
        
        include (ROOT."/views/admin/chooseLessonsGroup.php");
    }
    
    public function actionDeleteLesson ($id){
        User::checkLoggedAdmin();
        if (!isset($_POST['submit'])){
            $lesson = Lesson::getLesson($id);
        }
        $success = false;
        $errors = false;
        
        if (isset($_POST['submit'])){
            unset($_POST);
            $success = Lesson::deleteLesson($id);
            if (!$success){
                $errors[] = 'Не удалось сделать удаление';
            }else{
                 header("Location: /admin/lessons");
            }
        }
        include (ROOT."/views/admin/deleteLesson.php");
        
    }
    
    public function actionEditLesson($id){
        User::checkLoggedAdmin();
        $lesson = Lesson::getLesson($id);
        $errors = false;
        $success = false;
                 
        if(isset($_POST['submit'])){
             
            $name = $_POST['name'];
            $description = $_POST['description'];
            if (strcmp($lesson['name'], $name) != 1 ){
                if (Lesson::checkExistsLesson($name)){
                    $errors[] = 'Предмет с данным названием уже существует';
                }
            }
            
            unset($_POST);
            $success = Lesson::editLesson($id, $name, $description); 
            if (!$success){
                $errors[] = 'Не удалось сделать удаление';
            }else{
                header("Location: /admin/lessons");
            }
            
        }
        
                 
        include(ROOT."/views/admin/editLesson.php");
        
    } 
    
    public function actionGetLessonsJson(){
        Lesson::getLessonsJson();
    }
    
    public static function actionGetLessonsGroupByIdJson(){
        Group::getLessonsGroupByIdJson();
    }
    
    
    public function actionGetSemesterJson(){
        $id = $_POST['id'];
        Group::getSemesterJson($id);
    }
    public function actionAddLessonsGroupJson(){
        Lesson::addLessonsGroupJson();
    }
    public function actionGetLessonsGroupJson(){
        Lesson::getLessonsGroupJson();
    }
    
    public function actionHeadStudent($groupId){
       
         User::checkLoggedAdmin();
         $students = User::getAllStudentsByGroupId($groupId);
        
        $success = false;
        $errors = false;
        if(isset($_POST['submit'])){
            $studentId = $_POST['student'];
            $success = Group::editHeadStudent($groupId, $studentId); 
            if (!$success){
                $errors[] = 'Не удалось cделать операцию';
            }else{
                header("Location: /admin");
            }
        }
       
        include(ROOT."/views/admin/headStudent.php");
        
    }
    
}

