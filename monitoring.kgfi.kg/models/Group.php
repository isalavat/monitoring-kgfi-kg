<?php


class Group {
    public static function getAllGroups(){
        $db = Db::getConnection();
        $sql = "select * from group_ where semester > 0";
        $result = $db->prepare($sql);
        $result->execute();
        $groups = array();
        $i = 0;
        while ($row = $result->fetch()){
            $groups[$i]['id'] = $row['id'];
            $groups[$i]['name'] = $row['name'];
            $groups[$i]['description'] = $row['description'];
            $i++;
        }
        return $groups;
    }
    
    public static function getAllGroupsJson(){
        $db = Db::getConnection();
        $sql = "select * from group_ ";
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
    
    public static function addGroup($name , $description){
        $db = Db::getConnection();
        $sql = "insert into group_ (name, description) values (:name, :description)";
        $result = $db->prepare($sql);
        $result->bindParam(":name", $name, PDO::PARAM_STR);
        $result->bindParam(":description", $description, PDO::PARAM_STR);
        $bool = $result->execute();
        
        return $bool;
    }
    
    public static function checkExistsGroup($name){
        $db = Db::getConnection();
        $sql = "select count(*) from group_ where name =:name";
        $result = $db->prepare($sql);
        $result->bindParam(":name", $name, PDO::PARAM_STR);
        $result->execute();
        $count = $result->fetchColumn();
        if ($count == 0){
            return false;
        }
        return true;
    }
    
    public static function getGroupById($id){
        $db = Db::getConnection();
        $sql = 'select * from group_ where id = :id';
        $result = $db->prepare($sql);
        $result->bindParam(":id", $id, PDO::PARAM_INT);
        $result->execute();
        $group = array();
        $group = $result->fetch();
        
        return $group;
    }
    
    public static function editGroupById($id, $name, $description){
        $db = Db::getConnection();
        $sql = 'update group_ set name = :name, description = :description where id = :id';
        $result = $db->prepare($sql);
        $result->bindParam(":id", $id, PDO::PARAM_INT);
        $result->bindParam(":name", $name, PDO::PARAM_STR);
        $result->bindParam(":description", $description, PDO::PARAM_STR);
        $bool = $result->execute();
        
        return $bool;
    }
    
    public static function deleteGroupById($id){
        $db = Db::getConnection();
        $sql = 'select count(*) from student where group_id = :id';
        $result = $db->prepare($sql);
        $result->bindParam(":id", $id, PDO::PARAM_INT);
        $result->execute();
        $count =$result->fetchColumn();
        $result->execute();
       
        if ($count > 0){
            $db = Db::getConnection();
            $sql = 'select user_id from student where group_id = :id';
            $result = $db->prepare($sql);
            $result->bindParam(":id", $id, PDO::PARAM_INT);
            $result->execute();
            $sql = "delete from user_ where id = :id";
            $result2 = $db->prepare($sql);
            while ($row = $result->fetch()){
                
                $result2->bindParam(":id",$row['user_id'],PDO::PARAM_INT);
                $result2->execute();                
            }
        }
        $sql = 'delete from group_  where id = :id';
        $result = $db->prepare($sql);
        $result->bindParam(":id", $id, PDO::PARAM_INT);
        $bool = $result->execute();
        
        return $bool;
    }
    
    public static function getSemesterJson($id){
        $db = Db::getConnection();
        $sql = "select semester from group_ where id = :id";
        $result = $db->prepare($sql);
        $result->bindParam(":id", $id, PDO::PARAM_INT);
        $result->execute();
        $row =  $result->fetch();
        $semester = array();
        $semester['value'] = $row['semester'];
        echo json_encode($semester);
    }
    
    public static function addLessonsGroup($groupId, $semester, $lessonsGroupId){
        $db = Db::getConnection();
        $sql = "select count(*) from group_lessons_group where group_id = :group_id and semester = :semester";
        $result = $db->prepare($sql);
        $result->bindParam(":group_id", $groupId, PDO::PARAM_INT);
        $result->bindParam(":semester", $semester, PDO::PARAM_INT);
        $result->execute();
        $count = $result->fetchColumn();
        if ($count == 0){
            $sql = "insert into group_lessons_group (semester, group_id, lessons_group_id ) values ( :semester,:group_id, :lessons_group_id)";
            $result = $db->prepare($sql);
            $result->bindParam(":group_id", $groupId, PDO::PARAM_INT);
            $result->bindParam(":semester", $semester, PDO::PARAM_INT);
            $result->bindParam(":lessons_group_id", $lessonsGroupId, PDO::PARAM_INT);
            return $result->execute();
        }else{
            $sql = "update group_lessons_group set lessons_group_id = :lessons_group_id where group_id = :group_id and semester = :semester";
            $result = $db->prepare($sql);
            $result->bindParam(":group_id", $groupId, PDO::PARAM_INT);
            $result->bindParam(":semester", $semester, PDO::PARAM_INT);
            $result->bindParam(":lessons_group_id", $lessonsGroupId, PDO::PARAM_INT);
            return $result->execute();
        }
    }
    
    public static function getLessonsGroupByIdJson(){
        $groupId = $_POST['group'];
        $semester = $_POST['semester'];
        unset($_POST);
        $db = Db::getConnection();
        $sql = 'select lessons_group_id from group_lessons_group where group_id = :group_id and semester = :semester';
        $result = $db->prepare($sql);
        $result->bindParam(':group_id', $groupId, PDO::PARAM_INT);
        $result->bindParam(':semester', $semester, PDO::PARAM_INT);
        $result->execute();
        $lessonsGroupId = $result->fetchColumn();
        $sql = 'select * from lessons_group where id = :id';
        $result = $db->prepare($sql);
        $result->bindParam(':id', $lessonsGroupId, PDO::PARAM_INT);
        $result->execute();
        $row = $result->fetch();
        $name = $row['name'];
        $lessonsTeacherIds = array();
        $lessonsTeacherIds = json_decode($row['lessons']);
        
        $sql = 'select tea_id, less_id from teacher_lesson where id = :id';
        $sql_lesson = 'select name from teacher where user_id = :id';
        $sql_teacher = 'select name from lesson where id = :id';
        $result = $db->prepare($sql);
        $result_teacher = $db->prepare($sql_teacher);
        $result_lesson = $db->prepare($sql_lesson);
        $lessons = array();
        $result_teacher = $db->prepare($sql_teacher);
            $result_lesson = $db->prepare($sql_lesson);
            
        for ($i = 0; $i < count($lessonsTeacherIds); $i++){
            $result->bindParam(':id', $lessonsTeacherIds[$i], PDO::PARAM_INT);
            $result->execute();
            $row = $result->fetch();
            
            $lessons[$i]['teacher'] = $row['tea_id'];
            $lessons[$i]['lesson'] = $row['less_id'];
        }
        for ($i = 0; $i < count($lessonsTeacherIds); $i++){
            
            $sql_teacher = 'select name from teacher where user_id = :user_id';
            $sql_lesson = 'select name from lesson where id = :id';
            $result_teacher = $db->prepare($sql_teacher);
            $result_lesson = $db->prepare($sql_lesson);
            $result_teacher->bindParam(':user_id', $lessons[$i]['teacher'], PDO::PARAM_INT);
            $result_lesson->bindParam(':id', $lessons[$i]['lesson'], PDO::PARAM_INT);
           
            $result_teacher->execute();
            $result_lesson->execute();
            $row_teacher = $result_teacher->fetch();
            $row_lesson = $result_lesson->fetch();
            $lessons[$i]['teacher'] = $row_teacher['name'];
            $lessons[$i]['lesson'] = $row_lesson['name'];
        }
        
        echo json_encode($lessons);
        
    }
    
    public static function getGroupsByTeacherJson (){
        $id = $_POST['id'];
        unset($_POST);
        $db = Db::getConnection();
        $sql = 'select id, lessons from lessons_group';
        $result = $db->prepare($sql);
        $result->execute();
        $i = 0;
        $lessons_group = array();
        
        while($row = $result->fetch()){
            $lessons = json_decode($row['lessons']);
            for ($k = 0 ; $k < count($lessons); $k++ ){
                if ($id == $lessons[$k]){
                    $lessons_group[$i]['id'] = $row['id'];
                    $i++;
                    break;
                }
            }
       }
       
        
        $i = 0;
        $groups = array();
        
        for ($k = 0; $k < count($lessons_group); $k++){
            $sql = 'select glg.group_id , glg.semester , g.name from group_lessons_group as glg , group_ as g where glg.lessons_group_id = :l_g_id and glg.group_id = g.id' ;
        
            $result_ = $db->prepare($sql);
       
            $result_->bindParam(':l_g_id', $lessons_group[$k]['id'] , PDO::PARAM_INT );  
            $result_->execute();
            while ($row = $result_->fetch()){
                $groups[$i]['group_id'] = $row['group_id'];
                $groups [$i]['name'] = $row['name'];
                $groups [$i]['semester'] = $row['semester'];
                $i++;
            }    
            
        }
        
       
       echo json_encode($groups);
     }
     
     public static function semesterTranslateJson(){
         $db = Db::getConnection();
         $sql = 'select id , semester from group_ where semester > 0';
         $result = $db->prepare($sql);
         $result->execute();
         $i = 0;
         while($row = $result->fetch()){
             $group[$i]['id'] = $row['id'];
             $group[$i]['semester'] = $row['semester'];
             $i++;
         }
         print_r($group);
         for ($i = 0; $i <count($group); $i++){
             if ($group[$i]['semester'] == 8 ){
                 $group[$i]['semester'] = 0;
             }else{
                 $group[$i]['semester'] += 1;
             }
         }
          print_r($group);
        
        foreach ($group as $g){
            $sql = 'update group_ set semester = :semester  where id = :id';
            $result = $db->prepare($sql);
         
            $result->bindParam(':id', $g['id'], PDO::PARAM_INT);
            $result->bindParam(':semester', $g['semester'], PDO::PARAM_INT);
            $result->execute();
        }
        
        echo json_encode('Semester sind erfolgreich gesteigt worden');
    }
     
    public static function getCurrentGroups(){
        $db = Db::getConnection();
        $sql = 'select * from group_ where semester > 0';
        $result = $db->prepare($sql);
        $result->execute();
        $i = 0;
        $groups = array();
        while($row = $result->fetch()){
            $groups[$i]['name'] = $row['name'];
            $groups[$i]['id'] = $row['id'];
            $i++;
        }
        return $groups;
    }
    
    public static function getStudentsByGroup($groupId){
        $db = Db::getConnection();
        $sql = 'select s.name, s.user_id , g.semester from student as s, group_ as g where s.group_id = :group_id and s.group_id = g.id';
        $result = $db->prepare($sql);
        $result->bindParam(':group_id', $groupId, PDO::PARAM_INT);
        $result->execute();
        $i = 0;
        $students = array();
        while($row = $result->fetch()){
            $students[$i]['name'] = $row['name'];
            $students[$i]['id'] = $row['user_id'];
            $students[$i]['current_semester'] = $row['semester'];
            $students[$i]['group_id'] = $groupId;
            $i++;
        }
        return $students;
    }
    
    public static function getName($groupId){
        $db = Db::getConnection();
         $sql = 'select name from group_ where id = :group_id';
         
         $result = $db->prepare($sql);
         $result->bindParam(':group_id', $groupId, PDO::PARAM_INT);
         $result->execute();
         return $result->fetchColumn();
         
    }
    
    public static function getCurrentSemester($groupId){
        $db = Db::getConnection();
         $sql = 'select semester from group_ where id = :group_id';
         
         $result = $db->prepare($sql);
         $result->bindParam(':group_id', $groupId, PDO::PARAM_INT);
         $result->execute();
         return $result->fetchColumn();
         
    }
    
    public static function getTop5(){
        $groupId = $_POST['groupId'];
        $semester = $_POST['semester'];
        $db = Db::getConnection();
        $sql = 'select student, student_user_id , sum(note) as sum from note where semester = :semester and group_id = :group_id group by student_user_id order by sum desc';
        $result = $db->prepare($sql);
        $result->bindParam(":semester", $semester, PDO::PARAM_INT);
        $result->bindParam(":group_id", $groupId, PDO::PARAM_INT);
        $result->execute();
        $students = array();
        $i = 0;
        while ($row = $result->fetch()){
            $students[$i]['name'] = $row ['student'];
            $students[$i]['note'] = $row ['sum'];
            $i++;
            
        }
        $sql = 'select lessons_group_id from group_lessons_group where group_id = :group_id and semester = :semester';
        $result = $db->prepare($sql);
        $result->bindParam(":semester", $semester, PDO::PARAM_INT);
        $result->bindParam(":group_id", $groupId, PDO::PARAM_INT);
        $result->execute();
        $lessonsGroupId = $result->fetchColumn();
        
        
        $sql = 'select lessons from lessons_group where id = :lessons_group_id';
        $result = $db->prepare($sql);
        $result->bindParam(":lessons_group_id", $lessonsGroupId, PDO::PARAM_INT);
        $result->execute();
        $lessons = json_decode($result->fetchColumn());
        $count = count($lessons);
        $top5 = array();
        for ($i = 0 ; $i < 5; $i++){
            $top5[$i]['note'] = $students[$i]['note']/$count;
            $top5[$i]['name'] = $students[$i]['name'];
        }
        echo json_encode($top5);
    }
    
    public static function editHeadStudent($groupId, $studentId){
        $db = Db::getConnection();
        $sql = "update group_ set head_student_id = :std_id where id = :gr_id";
        $result = $db->prepare($sql);
        $result->bindParam(":gr_id", $groupId, PDO::PARAM_INT);
        $result->bindParam(":std_id", $studentId, PDO::PARAM_INT);
        $bool = $result->execute();
        return $bool; 
    }
    
    public static function newEvent(){
        $db = Db::getConnection();
        $sql = "insert into event (day_ , month_ , group_id, name) "
                . "values (:day, :month , :group_id , :name)";
        $result = $db->prepare($sql);
        $result->bindParam(":day", $_POST['day'], PDO::PARAM_INT);
        $result->bindParam(":month", $_POST['month'], PDO::PARAM_INT);
        $result->bindParam(":group_id", $_POST['groupId'], PDO::PARAM_INT);
        $result->bindParam(":name", $_POST['name'], PDO::PARAM_STR);
        $bool=$result->execute();
        echo json_encode($bool);
    }
    
    public static function getLastEvents(){
        $id = $_POST['groupId'];
        $db = Db::getConnection();
        $sql = 'select * from event where group_id = :id order by date_ desc limit 10';
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id , PDO::PARAM_INT);
        $result->execute();
        $i = 0;
        $events = array();
        while($row = $result->fetch()){
            $events[$i]['id'] = $row['id'];
            $events[$i]['name'] = $row['name'];
            $events[$i]['day'] = $row['day_'];
            $events[$i]['month'] = $row['month_'];
            $events[$i]['group_id'] = $row['group_id'];
            $i++;
        }
        echo json_encode($events);
        
    }
    
    
    public static function saveAttendance(){
        
        $e_id = $_POST['e_id'];
        $s_id = $_POST['s_id'];
        $status = $_POST['status'];
        $db = Db::getConnection();
        $sql = 'select count(*) from event_student where event_id = :e_id and student_user_id = :s_id';
        $result = $db->prepare($sql);
        $result->bindParam(':e_id', $e_id, PDO::PARAM_INT);
        $result->bindParam(':s_id', $s_id, PDO::PARAM_INT);
        $result->execute();
        $count = $result->fetchColumn();
        if ($count > 0){
            $sql = 'update event_student set status = :status where event_id = :e_id and student_user_id = :s_id';
            $result = $db->prepare($sql);
            $result->bindParam(':e_id', $e_id, PDO::PARAM_INT);
            $result->bindParam(':s_id', $s_id, PDO::PARAM_INT);
            $result->bindParam(':status', $status, PDO::PARAM_INT);
            $bool = $result->execute();
            if ($bool){
                if ($status == 1){
                    echo json_encode('Y');
                }else{
                    echo json_encode('N');
                }
            }else{
                echo json_encode('FAIL');
            }
        
        }else{
            $g_id = $_POST['g_id'];
            $e_name = $_POST['e_name'];
            $s_name = $_POST['s_name'];
            $day = $_POST['day'];
            $month = $_POST['month'];
            $sql = 'insert into event_student (event_id, event_name, group_id, student_user_id, student_name ,day_ , month_, status)'
                    . 'values (:e_id, :e_name, :g_id, :s_id, :s_name , :day , :month, :status)';
            $result = $db->prepare($sql);
            $result->bindParam(':e_id', $e_id, PDO::PARAM_INT);
            $result->bindParam(':e_name', $e_name, PDO::PARAM_STR);
            $result->bindParam(':g_id', $g_id, PDO::PARAM_INT);
            
            $result->bindParam(':s_id', $s_id, PDO::PARAM_INT);
            $result->bindParam(':s_name', $s_name, PDO::PARAM_STR);
            $result->bindParam(':status', $status, PDO::PARAM_INT);
            $result->bindParam(':day', $day, PDO::PARAM_INT);
            $result->bindParam(':month', $month, PDO::PARAM_INT);
            $bool = $result->execute();
            if ($bool){
                if ($status == 1){
                    echo json_encode('Y');
                }else{
                    echo json_encode('N');
                }
            }else{
                echo json_encode("FAIL");
            }
        }
        
        
    }
    
     public static function getAttendance(){
         $gId = $_POST['groupId'];
         $eId = $_POST['eventId'];
         $db = Db::getConnection();
         $sql = 'select student_user_id, status from event_student where group_id = :g_id and event_id = :e_id';
         $result = $db->prepare($sql);
         $result->bindParam(':g_id', $gId , PDO::PARAM_INT);
        $result->bindParam(':e_id', $eId , PDO::PARAM_INT);
        $result->execute();
        $i = 0;
        $status = array();
        while($row = $result->fetch()){
            $status[$i]['student_user_id'] = $row['student_user_id'];
            $status[$i]['status'] = $row['status'];
            $i++;
        }
        echo json_encode($status);
    }
    
    public static function getMonth($groupId){
        $db = Db::getConnection();
        $sql = 'select distinct month_ as m from event_student where group_id = :g_id ';
        $result = $db->prepare($sql);
        $result->bindParam(":g_id", $groupId, PDO::PARAM_INT);
        $result->execute();
        $months = array();
        $i = 0;
        while($row = $result->fetch()){
            $months[$i] = $row['m'];
            $i++;
        }
        return $months;
    }
    
    public static function getAttendanceDays(){
        $db = Db::getConnection();
        $gId = $_POST['id'];
        $m = $_POST['month'];
        $sql = 'select distinct  day_  from event_student where group_id = :g_id and month_ = :m  ';
        $result = $db->prepare($sql);
        $result->bindParam(":g_id", $gId, PDO::PARAM_INT);
        $result->bindParam(":m", $m, PDO::PARAM_INT);
        $result->execute();
        $days = array();
        $i = 0;
        while($row = $result->fetch()){
            $days[$i]['day'] = $row['day_'];
         //   $days[$i]['event_name'] = $row['event_name'];
            $i++;
        }
        echo json_encode($days);

    }
    
    public static function getEvents(){
        $db = Db::getConnection();
        $gId = $_POST['groupId'];
        $m = $_POST['month'];
        $d = $_POST['day'];
        $sql = 'select distinct  event_name, event_id  from event_student where group_id = :g_id and month_ = :m and day_ = :d order by day_ asc';
        $result = $db->prepare($sql);
        $result->bindParam(":g_id", $gId, PDO::PARAM_INT);
        $result->bindParam(":m", $m, PDO::PARAM_INT);
        $result->bindParam(":d", $d, PDO::PARAM_INT);
        $result->execute();
        $events = array();
        $i = 0;
        while($row = $result->fetch()){
            $events[$i]['event_id'] = $row['event_id'];
            $events[$i]['event_name'] = $row['event_name'];
            $i++;
        }
        echo json_encode($events);

    }
    
    public static function getStudentsCount(){
        $eId = $_POST['eventId'];
        $gId = $_POST['groupId'];
        $m = $_POST['month'];
        $d = $_POST['day'];
        $db = Db::getConnection();
        $sql = "select count(*) as count from event_student where event_id = :e_id and group_id = :g_id and month_ = :m and day_ = :d and status=1";
        $result = $db->prepare($sql);
        $result->bindParam(':e_id', $eId, PDO::PARAM_INT);
        $result->bindParam(':g_id', $gId, PDO::PARAM_INT);
        $result->bindParam(':m', $m, PDO::PARAM_INT);
        $result->bindParam(':d', $d, PDO::PARAM_INT);
        $result->execute();
        $count = array();
        $count['attendance'] = $result->fetchColumn();
        $sql = "select count(*) as count from student where  group_id = :g_id ";
        $result = $db->prepare($sql);
        $result->bindParam(':g_id', $gId, PDO::PARAM_INT);
        $result->execute();
        $count['notattendance'] = $result->fetchColumn()-$count['attendance'];
        echo json_encode($count);
    }
    
    public static function getStudents(){
        $eId = $_POST['eventId'];
        $gId = $_POST['groupId'];
        $m = $_POST['month'];
        $d = $_POST['day'];
        $db = Db::getConnection();
        $sql = "select student_name, status from event_student where event_id = :e_id and group_id = :g_id and month_ = :m and day_ = :d order by student_name";
        $result = $db->prepare($sql);
        $result->bindParam(':e_id', $eId, PDO::PARAM_INT);
        $result->bindParam(':g_id', $gId, PDO::PARAM_INT);
        $result->bindParam(':m', $m, PDO::PARAM_INT);
        $result->bindParam(':d', $d, PDO::PARAM_INT);
        $result->execute();
        $i = 0;
        $students = array();
        while($row = $result->fetch()){
            $students[$i]['name'] = $row['student_name'];
            $students[$i]['status'] = $row['status'];
            $i++;            
        }
        echo json_encode($students);
    }
    
}


 




