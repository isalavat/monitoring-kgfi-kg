<?php


class Lesson {
    public static function checkExistsLesson($name){
        $db = Db::getConnection();
        $sql = "select count(*) from lesson where name =:name";
        $result = $db->prepare($sql);
        $result->bindParam(":name", $name, PDO::PARAM_STR);
        $result->execute();
        $count = $result->fetchColumn();
        if ($count == 0){
            return false;
        }
        return true;
    }
    
    public static function addLesson($name , $description){
        $db = Db::getConnection();
        $sql = "insert into lesson (name, description) values (:name, :description)";
        $result = $db->prepare($sql);
        $result->bindParam(":name", $name, PDO::PARAM_STR);
        $result->bindParam(":description", $description, PDO::PARAM_STR);
        $bool = $result->execute();
       
        return $bool;
    }
    
    public static function getAllLessonsJson(){
        $db = Db::getConnection();
        $sql = "select * from lesson ";
        $result = $db->prepare($sql);
        $result->execute();
        $groups = array();
        $id = 0;
        while ($row = $result->fetch()){
            $id = $row['id'];
            $groups[$id] = $row['name'];
            
        }
        return json_encode($groups);
    }
    
    public static function getLessons(){
        $db = Db::getConnection();
        $sql = "select * from lesson ";
        $result = $db->prepare($sql);
        $result->execute();
        $lessons = array();
        $id = 0;
        while ($row = $result->fetch()){
            $id = $row['id'];
            $lessons[$id] = $row['name'];
            
        }
        return $lessons;
    }
    
    public static function checkExistsTeacher($id, $teacher_id){
        $db = Db::getConnection();
        $sql = 'select count(*) from teacher_lesson where less_id = :less_id and tea_id = :tea_id';
        $result = $db->prepare($sql);
        $result->bindParam(":less_id", $id, PDO::PARAM_INT);
        $result->bindParam(":tea_id", $teacher_id, PDO::PARAM_INT);
        $result->execute();
        $count = $result->fetchColumn();
       
        if ($count == 0){
            return true;
        }
        return false;
    }
    
    public static function addTeacher($id, $teacherId){
        $db = Db::getConnection();
        $sql = 'insert into teacher_lesson (less_id, tea_id) values (:less_id, :tea_id)';
        $result = $db->prepare($sql);
        $result->bindParam(":less_id", $id, PDO::PARAM_INT);
        $result->bindParam(":tea_id", $teacherId, PDO::PARAM_INT);
        $bool = $result->execute();
        return $bool;
    }
    
    
    public static function deleteLessonTeacher($id, $teacherId){
        $db = Db::getConnection();
        $sql = "delete  from teacher_lesson where less_id = :lesson_id and tea_id = :teacher_id";
        
        $result = $db->prepare($sql);
        $result->bindParam(':lesson_id', $id, PDO::PARAM_INT);
        $result->bindParam(':teacher_id', $teacherId, PDO::PARAM_INT);
        $bool =  $result->execute();
        
        return $bool;
    }
    
    public static function getLesson($id){
        $db = Db::getConnection();
        $sql = "select * from lesson where id = :id";
        $result = $db->prepare($sql);
        $result->bindParam(":id", $id, PDO::PARAM_INT);
        $result->execute();
        $lesson = array();
        
        $row = $result->fetch();
        $lesson ['id'] = $row['id'];
        $lesson ['name'] = $row['name'];
        $lesson ['description'] = $row['description'];    
        return $lesson;
    }
    
    public static function deleteLesson($id){
        $db = Db::getConnection();
        $sql = "delete from lesson where id = :id";
        $result = $db->prepare($sql);
        $result->bindParam(":id", $id, PDO::PARAM_INT);
        $bool = $result->execute();
        return $bool;
    }
    
    public static function editLesson($id, $name, $description){
        $db = Db::getConnection();
        $sql = 'update lesson set name = :name, description = :description where id = :id';
        $result = $db->prepare($sql);
        $result->bindParam(":id", $id, PDO::PARAM_INT);
        $result->bindParam(":name", $name, PDO::PARAM_STR);
        $result->bindParam(":description", $description, PDO::PARAM_STR);
        $bool = $result->execute();
        return $bool;
    }
    
    public static function addLessonGroup($json){
        $json = json_encode($json);
        $db = Db::getConnection();
        $sql = "insert into lessons_group (lessons) values (:lessons)";
        $result = $db->prepare($sql);
        $result->bindParam(":lessons", $json, PDO::PARAM_STR);
        if( $result->execute()){
            echo 'success';
        } else{
            echo 'fail';
        }
    }
    
    public static function getAllLessonTeachersJson(){
        $db = Db::getConnection();
        $sql = "select tl.id , t.name as teacher , l.name as lesson from teacher_lesson as tl , lesson as l, teacher as t where tl.tea_id = t.user_id and tl.less_id = l.id";
        $result = $db->prepare($sql);
        $result->execute();
        $i = 0;
        $lessonGroup = array();
        while ($row = $result->fetch()){
            $lessonGroup[$i]['id'] = $row['id'];
            $lessonGroup[$i]['teacher'] = $row['teacher'];
            $lessonGroup[$i]['lesson'] = $row['lesson'];
            $i++;
        }
        echo json_encode($lessonGroup);
        
    }
    public static function addLessonsGroupJson(){
        $name = $_POST['name'];
        $json = $_POST['json'];
       // unset($_POST);
        $db = Db::getConnection();
        $sql = "insert into lessons_group (name, lessons) values (:name, :lessons)";
        $result = $db->prepare($sql);
        $result->bindParam(":name", $name, PDO::PARAM_STR);
        $result->bindParam(":lessons", $json, PDO::PARAM_STR);
        $bool = $result->execute();
        echo $bool;
    }
    public static function getLessonsGroupJson(){
        $db = Db::getConnection();
        $sql = "select id , name from lessons_group";
        $result = $db->prepare($sql);
        $result->execute();
        $lg = array();
        $i = 0;
        while ($row = $result->fetch()){
            $lg[$i]['id'] = $row['id'];
            $lg[$i]['name'] = $row['name'];
            $i++;
        }    
        
        echo json_encode($lg);
        
     }
    
    public static function getLessonsJson(){
        $id = $_POST['id'];
        unset($_POST);
        $db = Db::getConnection();
        $sql = "select lessons from lessons_group where id = :id";
        $result = $db->prepare($sql);
        $result->bindParam(':id',$id , PDO::PARAM_INT);
        $result->execute();
        $row_lg = $result->fetch();
        $lessons = json_decode(($row_lg['lessons']));
        $sql = "select tea_id , less_id from teacher_lesson where id = :id";
        $lessons_group = array();
        for ($i = 0; $i < count($lessons); $i++ ){
            $result2 = $db->prepare($sql);
            $result2->bindParam(":id", $lessons[$i],PDO::PARAM_INT);
            $result2->execute();
            $row = $result2->fetch();
            $tea_id = $row['tea_id'];
            $less_id = $row['less_id'];
            $sql_teacher = 'select name from teacher where user_id = :t_id';
            $result_teacher = $db->prepare($sql_teacher);
            $result_teacher->bindParam(":t_id", $tea_id, PDO::PARAM_INT);
            $sql_lesson = 'select name from lesson where id = :l_id';
            $result_lesson = $db->prepare($sql_lesson);
            $result_lesson->bindParam(":l_id", $less_id, PDO::PARAM_INT);
             $result_lesson->execute();
            $result_teacher->execute();
            $row_t = $result_teacher->fetch();
             
            $row_l = $result_lesson->fetch();
            
            $lessons_group[$i]['teacher'] = $row_t['name'];
            $lessons_group[$i]['lesson'] = $row_l['name'];
            
        }
       
        echo json_encode($lessons_group);
    }
    
    public static function deleteLessonsGroup($id){
        $db = Db::getConnection();
        
        
        $sql = 'delete from lessons_group  where id = :id';
        $result = $db->prepare($sql);
        $result->bindParam(":id", $id, PDO::PARAM_INT);
        $bool = $result->execute();
        if ($bool){
            return true;
        }
        return false;
    }
    
    public static function getLessonsGroup($id){
        $db = Db::getConnection();
        $sql = 'select * from lessons_group where id = :id';
        $result = $db->prepare($sql);
        $result->bindParam(":id", $id, PDO::PARAM_INT);
        $result->execute();
        $lg = array();
        $lg = $result->fetch();
        return $lg;
    }
    
    public static function getLessonsGroups(){
        $db = Db::getConnection();
        $sql = 'select * from lessons_group';
        $result = $db->prepare($sql);
        $result->execute();
        $lg = array();
        $i = 0;
        while ($row = $result->fetch()){
            $lg[$i]['id'] = $row['id'];
            $lg[$i]['name'] = $row['name'];
            $i++;
        }
       
        return $lg;
    }
    
    public static function getTaecherLessonsJson(){
        $id = $_POST['id'];
        $db = Db::getConnection();
        $sql = 'select tl.id ,  l.name from teacher_lesson as tl , lesson as l where tl.less_id = l.id and tl.tea_id = :tea_id';
        $result = $db->prepare($sql);
        $result->bindParam(':tea_id', $id);
        $result->execute();
        $i = 0;
        $lessons = array();
        while ($row = $result->fetch()){
            $lessons[$i]['id'] = $row['id'];
            $lessons[$i]['name'] = $row['name'];
            $i++;    
        }
        
        echo json_encode($lessons);
    }
    
}



