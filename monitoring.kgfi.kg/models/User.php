<?php

class User {
    public static function checkLogged(){
        
        if (!isset($_SESSION['id'])){
            header("Location: /user/login");
        }
    }
    
     public static function getGroupId($studentId){
        $db = DB::getConnection();
       
        $sql = "select group_id from student where user_id = :user_id";
       
        $result = $db->prepare($sql);
        $result->bindParam(":user_id" , $studentId, PDO::PARAM_STR);
        
        $result->execute();
        $row = $result->fetchColumn();
        return $row;
         
     }
      public static function checkLoggedHeadStudent(){
        
        if (!isset($_SESSION['id'])){
            header("Location: /user/login");
        }
        if (isset($_SESSION['id'])){
            $id = $_SESSION['id'];
            $db = Db::getConnection();
            $sql = 'select count(*) from group_ where head_student_id = :id';
            $result = $db->prepare($sql);
            $result->bindParam(":id", $id, PDO::PARAM_INT);
            $result->execute();
            $count = $result->fetchColumn();
            //echo $count;
            if ($count != 1){
                header("Location: /user/login");
            }
        }
    }
    public static function auth($user){
       $_SESSION['id'] = $user['id'];
       $_SESSION['role'] = $user['role'];
       
    }
    public static function checkLoggedAdmin(){
        
        if (!isset($_SESSION['id']) || strcmp($_SESSION['role'], 'admin') != 0 ){
            header("Location: /user/login");
        }
    }
    public static function checkLoggedTeacher(){
        
        if (!isset($_SESSION['id']) || strcmp($_SESSION['role'], 'teacher') != 0 ){
            header("Location: /user/login");
        }
    }
    public static function isGuest(){
        if (isset($_SESSION['id'])){
            return false;
        }
        return true;
    }

    public static function login($login, $password){
        $db = DB::getConnection();
       
        $sql = "select * from user_ where login = :login and password = :password";
       
        $result = $db->prepare($sql);
        $result->bindParam(":login" , $login, PDO::PARAM_STR);
        $result->bindParam(":password" , $password, PDO::PARAM_STR);
        
        $result->execute();
        $row = $result->fetch();
        if ($row){
            
            $user['id'] = $row['id'];
            $user['role'] = $row['role'];
            return $user;
        }   
        return false;
    }

     public static function logout(){
         unset($_SESSION['id']);
         unset($_SESSION['role']);
         header("Location: /");
     }

    public static function checkLogin($login){
        $pattern = "([a-z]+)";
        if (!isset($login)){
            return false;
        }
        if ( strlen($login)>=5){
           
            return true;
        }
        
        return false;
    }
    
    public static function checkName($name){
        $pattern = "([a-z]+)";
        if (!isset($name)){
            return false;
        }
        
        return true;
    }
    
    public static function checkPassword($password){
        if ( strlen($password)>=5){
            
            return true;
        }
        
        return false;
    }
    
    public static function checkTwoPasswords($password, $password_2){
        if (strcmp($password, $password_2) == 0){
            return true;
        }
        return false;
    }
    
    public static function checkExistsLogin($login){
        $db = Db::getConnection();
        $sql = "select count(*) from user_ where login =:login";
        $result = $db->prepare($sql);
        $result->bindParam(":login", $login, PDO::PARAM_STR);
        $result->execute();
                
        $count = $result->fetchColumn();
        if ($count == 0){
            return true;
        }
        return false;
    }
    
    public static function addStudent($name, $login, $password, $groupId){
        
        $db = Db::getConnection();
        $sql = "insert into user_ (login , password, role) values (:login, :password, :role)";
        $result = $db->prepare($sql);
        $role = "student";
        $result->bindParam(":login", $login, PDO::PARAM_STR);
        $result->bindParam(":password", $password, PDO::PARAM_INT);
        $result->bindParam(":role",$role , PDO::PARAM_STR);
        $bool = $result->execute();
       
        if ($bool){
            $sql = "select id from user_ where login = :login";
            $result = $db->prepare($sql);
            $result->bindParam(":login", $login, PDO::PARAM_STR);
            $result->execute();
            $userId = $result->fetchColumn();
        
            $sql = "insert into student (name , group_id, user_id) values (:name, :group_id, :user_id)";
            $result = $db->prepare($sql);
            $result->bindParam(":name", $name, PDO::PARAM_STR);
            $result->bindParam(":group_id", $groupId, PDO::PARAM_INT);
            $result->bindParam(":user_id", $userId, PDO::PARAM_INT);
            $bool = $result->execute();
            
            return $bool;
            
        }
        return false;
    }
    
    public static function addTeacher($name, $login, $password){
        
        $db = Db::getConnection();
        $sql = "insert into user_ (login , password, role) values (:login, :password, :role)";
        $result = $db->prepare($sql);
        $role = "teacher";
        $result->bindParam(":login", $login, PDO::PARAM_STR);
        $result->bindParam(":password", $password, PDO::PARAM_INT);
        $result->bindParam(":role",$role , PDO::PARAM_STR);
        $bool = $result->execute();
       
        if ($bool){
            $sql = "select id from user_ where login = :login";
            $result = $db->prepare($sql);
            $result->bindParam(":login", $login, PDO::PARAM_STR);
            $result->execute();
            $userId = $result->fetchColumn();
        
            $sql = "insert into teacher (name , user_id) values (:name,  :user_id)";
            $result = $db->prepare($sql);
            $result->bindParam(":name", $name, PDO::PARAM_STR);
            
            $result->bindParam(":user_id", $userId, PDO::PARAM_INT);
            $bool = $result->execute();
            
            return $bool;
            
        }
        return false;
    }
    
    public static function deleteStudent($id){
        $db = Db::getConnection();
        $sql = "delete from user_ where id = :id";
        $result = $db->prepare($sql);
        $result->bindParam(":id", $id, PDO::PARAM_INT);
        $bool = $result->execute();
        return $bool;
    }
    
    public static function deleteTeacher($id){
        $db = Db::getConnection();
        $sql = "delete from user_ where id = :id";
        $result = $db->prepare($sql);
        $result->bindParam(":id", $id, PDO::PARAM_INT);
        $bool = $result->execute();
        return $bool;
    }
    
    public static function getAllTeachersJson(){
        $db = Db::getConnection();
        $sql = "select user_id , name from teacher ";
        $result = $db->prepare($sql);
        $result->execute();
        $teachers = array();
        $id = 0;
        while ($row = $result->fetch()){
            $id = $row['user_id'];
            $teachers[$id] = $row['name'];
            
        }
        return json_encode($teachers);
    }
    
    public static function getAllStudentsByGroupIdJson(){
        $db = Db::getConnection();
        $groupId = $_POST['id'];
        $sql = "select *  from student where group_id = :group_id";
        $result = $db->prepare($sql);
        $students = array();
        $result->bindParam(":group_id", $groupId, PDO::PARAM_INT);
        $result->execute();
        while ($row = $result->fetch()){
            $userId = $row['user_id'];
            $students[$userId] = $row['name'];     
        }
        $students = json_encode($students);
        echo $students;
    }
    
    
    public static function getAllStudentsByGroupIdJson2(){
        $db = Db::getConnection();
        $groupId = $_POST['id'];
        $sql = "select *  from student where group_id = :group_id";
        $result = $db->prepare($sql);
        $students = array();
        $result->bindParam(":group_id", $groupId, PDO::PARAM_INT);
        $result->execute();
        $i = 0;
        while ($row = $result->fetch()){
            $userId = 
            $students[$i]['name'] = $row['name'];
            $students[$i]['user_id'] = $row['user_id'];
            $i++;
        }
        $students = json_encode($students);
        echo $students;
    }
    
    public static function getAllStudentsByGroupId($groupId){
        $db = Db::getConnection();
        
        $sql = "select *  from student where group_id = :group_id";
        $result = $db->prepare($sql);
        $students = array();
        $result->bindParam(":group_id", $groupId, PDO::PARAM_INT);
        $result->execute();
        $i = 0;
        while ($row = $result->fetch()){
            $students[$i]['user_id'] = $row['user_id'];
            $students[$i]['name'] = $row['name'];
            $i++;
        }
        
        return $students;
    }
    
    public static function getAllStudentsByTeacherByGroupIdJson(){
        $db = Db::getConnection();
        $groupId = $_POST['groupId'];
        $lessonId = $_POST['lessonId'];
        $semester = $_POST['semester'];
        $sql = "select * from student where group_id = :group_id";
        $result = $db->prepare($sql);
        $students = array();
        $result->bindParam(":group_id", $groupId, PDO::PARAM_INT);
        $result->execute();
        $i = 0;
        
        while ($row = $result->fetch()){
            $students[$i]['user_id'] = $row['user_id'];
            $students[$i]['name'] = $row['name'];
            $i++;
        }
        
        $students = json_encode($students);
        echo $students;
    }
    
    
    
     public static function getAllNotesByTeacherByGroupIdJson(){
        $db = Db::getConnection();
        $groupId = $_POST['groupId'];
        $lessonId = $_POST['lessonId'];
        $semester = $_POST['semester'];
        $sql = "select s.user_id as user_id ,  n.note as note from student as s , note as n "
                . "where s.group_id = :group_id and n.group_id = :group_id and n.semester = :semester and n.teacher_lesson_id = :t_l_id and s.user_id = n.student_user_id";
        //$sql = "select * from student where group_id = :group_id";
        $result = $db->prepare($sql);
        $students = array();
        $result->bindParam(":group_id", $groupId, PDO::PARAM_INT);
        $result->bindParam(":semester", $semester, PDO::PARAM_INT);
        $result->bindParam(":t_l_id", $lessonId, PDO::PARAM_INT);
        
        $result->execute();
        $i = 0;
        
        while ($row = $result->fetch()){
            $students[$i]['user_id'] = $row['user_id'];
            $students[$i]['note'] = $row['note'];
         
            $i++;
        }
        
        $students = json_encode($students);
        echo $students;
    }
   
    
    public static function getStudentById($id){
        $db = Db::getConnection();
        $sql = "select *  from student where user_id = :id";
        $result = $db->prepare($sql);
        $student = array();
        $result->bindParam(":id", $id, PDO::PARAM_INT);
        $result->execute();
        $student = $result->fetch();
       
        return $student;
    }
    
    public static function getStudentName(){
        $id = $_POST['id'];
        $db = Db::getConnection();
        $sql = "select name  from student where user_id = :id";
        $result = $db->prepare($sql);
        $student = array();
        $result->bindParam(":id", $id, PDO::PARAM_INT);
        $result->execute();
        $row = $result->fetch();
        $student[0]['name'] = $row['name'];
       
        echo json_encode($student);
    }
    
    
    public static function getTeacherById($id){
        $db = Db::getConnection();
        $sql = "select *  from teacher where user_id = :id";
        $result = $db->prepare($sql);
        $teacher = array();
        $result->bindParam(":id", $id, PDO::PARAM_INT);
        $result->execute();
        $teacher = $result->fetch();
       
        return $teacher;
    }
    
    public static function editStudent($id, $name, $groupId){
        
        $db = Db::getConnection();
        $sql = 'update student set name = :name, group_id = :group_id where user_id = :id';
        $result = $db->prepare($sql);
        $result->bindParam(":id", $id, PDO::PARAM_INT);
        $result->bindParam(":name", $name, PDO::PARAM_STR);
        $result->bindParam(":group_id", $groupId, PDO::PARAM_INT);
        $bool = $result->execute();
        return $bool;
    
    }
    
    public static function editTeacher($id, $name){
        
        $db = Db::getConnection();
        $sql = 'update teacher set name = :name where user_id = :id';
        $result = $db->prepare($sql);
        $result->bindParam(":id", $id, PDO::PARAM_INT);
        $result->bindParam(":name", $name, PDO::PARAM_STR);
       
        $bool = $result->execute();
    
        return $bool;
    }
    
    public static function getLessonTeachersJson(){
        $db = Db::getConnection();
        $lessId = $_POST['id'];
        unset($_POST);
        $sql = 'select count(*) from teacher_lesson where less_id = :less_id';
        $result = $db->prepare($sql);
        $result->bindParam(":less_id", $lessId, PDO::PARAM_INT);
        $result->execute();
        $count = $result->fetchColumn();
        $teachers = array();
        if ($count > 0){
            $sql = 'select t.user_id , t.name from teacher_lesson as tl, teacher as t where tl.less_id = :less_id and t.user_id = tl.tea_id';
            $result = $db->prepare($sql);
            $result->bindParam(":less_id", $lessId, PDO::PARAM_INT);
            $result->execute();
            
            while ($row = $result->fetch()){
                $teachers [$row['user_id']] = $row['name']; 
            }
            echo json_encode($teachers);
        }else {
            $teachers[0]='0';
            echo json_encode($teachers);
        }
    }  
    
    public static function getTeachers(){
        $db = Db::getConnection();
        $sql = "select user_id , name from teacher  ";
        $result = $db->prepare($sql);
        $result->execute();
        $teachers = array();
        $i = 0;
        while ($row = $result->fetch()){
            $teachers[$i]['id'] = $row['user_id'];
            $teachers[$i]['name'] = $row['name'];
            $i++;
        }
        return $teachers;
    }
    
    public static function getTeacherIdJson(){
        $id  = $_SESSION['id'];
        $id = json_encode($id);
        echo $id;
    }
    
    public static function saveNoteJson(){
        print_r($_POST);
        $db = Db::getConnection();
        $sql = 'select count(*) from note where group_id = :g_id and semester = :sem and student_user_id = :s_u_id and teacher_user_id = :t_u_id and teacher_lesson_id = :t_l_id';
        $result = $db->prepare($sql);
        
        $result->bindParam(':t_l_id',$_POST['lessonId'], PDO::PARAM_INT);
        $result->bindParam(':s_u_id',$_POST['studentId'], PDO::PARAM_INT);
        $result->bindParam(':t_u_id',$_POST['teacherId'], PDO::PARAM_INT);
        $result->bindParam(':g_id',$_POST['groupId'], PDO::PARAM_INT);
        $result->bindParam(':sem',$_POST['semester'], PDO::PARAM_INT);
        $result->execute();
        $count = $result->fetchColumn();
        if ($count > 0){
            $sql = 'update note set note = :n where group_id = :g_id and semester = :sem and student_user_id = :s_u_id and teacher_user_id = :t_u_id and teacher_lesson_id = :t_l_id';
            $result = $db->prepare($sql);
            $result->bindParam(':t_l_id',$_POST['lessonId'], PDO::PARAM_INT);
            $result->bindParam(':s_u_id',$_POST['studentId'], PDO::PARAM_INT);
            $result->bindParam(':t_u_id',$_POST['teacherId'], PDO::PARAM_INT);
            $result->bindParam(':g_id',$_POST['groupId'], PDO::PARAM_INT);
            $result->bindParam(':sem',$_POST['semester'], PDO::PARAM_INT);
            $result->bindParam(':n',$_POST['note'], PDO::PARAM_INT);
            $result->execute();
            $note[0]['note'] = $_POST['note'];
            echo json_encode($note);
            
        }else{
        
        
        $sql = 'select t.name as teacher, l.name as lesson , s.name as student from lesson as l , teacher as t, teacher_lesson as tl, student as s '.
                'where s.user_id = :s_user_id and t.user_id = :t_user_id and l.id = tl.less_id and tl.id = :lesson_id';
        $result = $db->prepare($sql);
        $result->bindParam(':s_user_id', $_POST['studentId'], PDO::PARAM_INT);
        $result->bindParam(':t_user_id', $_POST['teacherId'], PDO::PARAM_INT);
        $result->bindParam(':lesson_id', $_POST['lessonId'], PDO::PARAM_INT);
    
        $result->execute();
        $row = $result->fetch();
        $teacher = $row['teacher'];
        $lesson = $row['lesson'];
        $student = $row['student'];
        $sql = 'insert into note (teacher_lesson_id, student_user_id, teacher_user_id, group_id, teacher, student, lesson, note, semester)'.
        'values (:t_l_id, :s_u_id, :t_u_id, :g_id, :t, :s, :l, :n, :sem)';        
        $result = $db->prepare($sql);
        $result->bindParam(':t_l_id',$_POST['lessonId'], PDO::PARAM_INT);
        $result->bindParam(':s_u_id',$_POST['studentId'], PDO::PARAM_INT);
        $result->bindParam(':t_u_id',$_POST['teacherId'], PDO::PARAM_INT);
        $result->bindParam(':g_id',$_POST['groupId'], PDO::PARAM_INT);
        $result->bindParam(':sem',$_POST['semester'], PDO::PARAM_INT);
        $result->bindParam(':n',$_POST['note'], PDO::PARAM_INT);
        $result->bindParam(':t',$teacher, PDO::PARAM_STR);
        $result->bindParam(':s',$student, PDO::PARAM_STR);
        $result->bindParam(':l',$lesson, PDO::PARAM_STR);
        $bool = $result->execute();
        $note[0]['note'] = $_POST['note'];
            echo json_encode($note);
        }
    }
    
    public static function getNoteByStudent(){
        $db = Db::getConnection();
        $sql = 'select lesson, note from note where group_id = :g_id and student_user_id = :s_id and semester = :s';
        $result = $db->prepare($sql);
        $result->bindParam(':g_id',$_POST['groupId'],PDO::PARAM_INT);
        $result->bindParam(':s_id',$_POST['studentId'],PDO::PARAM_INT);
        $result->bindParam(':s',$_POST['semester'],PDO::PARAM_INT);
        $result->execute();
        $i = 0;
        $notes = array();
        while ($row = $result->fetch()){
            $notes[$i]['lesson'] = $row['lesson'];
            $notes[$i]['note'] = $row['note'];
            $i++;
         }
         
         echo json_encode($notes);
        
        
    }
}







