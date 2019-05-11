<?php

return array(
     
    'user/logout' => 'user/logout',
    'user/login' => 'user/login',
    'std-admin/events' => 'student/events',
    'std-admin' =>'student/index',
    'student/new-event' => 'student/newEvent',
    'student/get-last-events' => 'student/getLastEvents',
    'student/get-students' => 'student/getStudents',
    'student/save-attendance' => 'student/saveAttendance',
    'student/get-attendance' => 'student/getAttendance',
    'admin/head-student/([0-9]+)' => 'admin/headStudent/$1',
    'admin/lessons-group-choose/([0-9]+)/([0-9]+)'=>'admin/chooseLessonsGroup/$1/$2',
    'admin/lessonsgroupdelete/([0-9]+)' => 'admin/deleteLessonsGroup/$1',
    'admin/group-lessons' => 'admin/getLessonsJson',
    'admin/add-lessons-group' => 'admin/addLessonsGroupJson',
    'admin/get-lessons-group-by-id-json' => 'admin/getLessonsGroupByIdJson',
    
    'admin/get-lessons-group' => 'admin/getLessonsGroupJson',
    'progress/top-5/([0-9]+)' => 'progress/top5/$1',
    'progress/get-top-5' => 'progress/getTop5',
    'progress/get-student-notes' =>'progress/getNoteByStudent',
    'progress/student-name' => 'progress/getStudentName',
    'progress/student/([0-9]+)/([0-9]+)/([0-9]+)' => 'progress/student/$1/$2/$3', 
    'progress/group/([0-9]+)' => 'progress/students/$1',
    'progress' => 'progress/index',
    'attendance/get-days' =>'attendance/getDays',
    'attendance/all-students' => 'attendance/getStudents',
    'attendance/get-students-count' => 'attendance/getStudentsCount',
    
    'attendance/get-events'=>'attendance/getEvents',
    'attendance/show/([0-9]+)' => 'attendance/show/$1',
    
    'attendance' => 'attendance/index',
    'admin/semester-edit' => 'admin/editSemester',
    'admin/semester-translate' => 'admin/semesterTranslate',
    'admin/add-student' => 'admin/addStudent',
    'admin/add-teacher' => 'admin/addTeacher',
    'admin/add-admin' => 'admin/addSuperUser',
    'admin/add-group' => 'admin/addGroup',
    'admin/students'=>'admin/studentsByGroup',
    'admin/add-lesson' => 'admin/addLesson',
    'admin/get-all-groups' => 'admin/getAllGroups',
    'admin/get-all-teachers' => 'admin/getAllTeachers',
    'admin/get-all-lessons' => 'admin/getAllLessons',
    'admin/edit-group/([0-9]+)'  => 'admin/editGroup/$1',
    'admin/delete-group/([0-9]+)'  => 'admin/deleteGroup/$1',
    'admin/edit-student/([0-9]+)'  => 'admin/editStudent/$1',
    'admin/delete-student/([0-9]+)'  => 'admin/deleteStudent/$1',
    'admin/edit-teacher/([0-9]+)'  => 'admin/editTeacher/$1',
    'admin/delete-teacher/([0-9]+)'  => 'admin/deleteTeacher/$1',
    'admin/get-lesson-teachers' => 'admin/getLessonTeachers',
    'admin/add-lessonteacher/([0-9]+)' => 'admin/addLessonTeacher/$1',
    'admin/delete-lessonteacher/([0-9]+)/([0-9]+)' => 'admin/deleteLessonTeacher/$1/$2',
    'admin/delete-lesson/([0-9]+)' => 'admin/deleteLesson/$1',
    'admin/edit-lesson/([0-9]+)' => 'admin/editLesson/$1',
    'admin/get-semester' => 'admin/getSemesterJson',
    'admin/get-all-lessonteachers' => 'admin/getAllLessonTeachers',
    'admin/lessons-groups' => 'admin/lessonsGroups',
    'admin/lessons' => 'admin/lessons',
    'admin/teachers' => 'admin/teachers',
    'admin/test' => 'admin/test',
    'admin' => 'admin/index',
    'teacher/get-lessons' => 'teacher/getLessons',
    'teacher/get-groups' => 'teacher/getGroups',
    'teacher/get-id' => 'teacher/getIdJson',
    'teacher/get-students-by-group' => 'teacher/getStudentsByGroup',
    'teacher/get-notes-by-group' => 'teacher/getNotesByGroup',
    'teacher' => 'teacher/index',
    
    
    'user/save-note' => 'user/saveNote',
    
    'user' => 'user/login',
    'student/([0-9]+)/([0-9]+)'=>'student/getResult/$1/$2',
    'test' => 'test/index',
    'site' => 'site/index',
    
    '' => 'site/index'
);