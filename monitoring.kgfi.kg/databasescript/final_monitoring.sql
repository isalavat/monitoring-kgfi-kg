create table group_ (
    id int primary key auto_increment,
    name varchar (10) not null unique,
    description text not null ,
    created_year timestamp default current_timestamp,
    semester int default 1  check (semester in(0,1,2,3,4,5,6,7,8)) 
);

create table user_ (
    id int primary key auto_increment,
    login varchar(20) unique not null,
    password varchar(20) not null,
    role varchar (20) not null 
);

create table student(
    id int primary key auto_increment,
    name varchar(250) not null,
    group_id int not null,
    user_id int not null,
    foreign key (group_id) references group_(id) on delete cascade,
    foreign key (user_id) references user_(id) on delete cascade 
);

create table teacher (
    id int primary key auto_increment,
    name varchar(250) not null,
    user_id int,
    foreign key (user_id) references user_(id) on delete cascade
);

create table lesson (
    id int primary key auto_increment,
    name varchar(250) not null unique,
    description text
);

create table teacher_lesson (
    id int primary key auto_increment,
    tea_id int,
    less_id int,
    foreign key (tea_id) references teacher(user_id) on delete cascade,
    foreign key (less_id) references lesson(id) on delete cascade
);

create table group_teacher_lesson(
    group_id int,
    teacher_lesson_id int,
    semester int not null check (semester >= 1 and semester <=8),
    foreign key (group_id) references group_(id) on delete cascade,
    foreign key (teacher_lesson_id) references teacher_lesson(id) on delete cascade
    
);

create table lessons_group(
    id int primary key auto_increment,
    name varchar(250) unique,
    lessons text not null
);

create table group_lessons_group(
    id int primary key auto_increment,
    semester int ,
    group_id int,
    lessons_group_id int ,
    foreign key (lessons_group_id) references lessons_group(id) on delete cascade,
    foreign key (group_id) references group_(id) on delete cascade
    
);


create table note (
    id int primary key auto_increment,
    teacher_lesson_id int,
    student_user_id int,
    teacher_user_id int,
    group_id int,
    semester int,
    student varchar (250),
    teacher varchar(250),
    lesson varchar(250),
    note double default 0 check(note <= 5),
    foreign key (teacher_lesson_id) references teacher_lesson(id) on delete cascade ,
    foreign key (student_user_id) references student(user_id) on delete cascade ,
    foreign key (student_user_id) references student(user_id) on delete cascade ,
    foreign key (group_id) references group_(id) on delete cascade 
)

alter table group_ add head_student_id int default 0;
 
create table event (
    id int auto_increment PRIMARY key,
    name varchar(255) default 'unbekannt',
    group_id int, 
    day_ int,
    month_ int,
    date_ timestamp default current_timestamp,
    foreign key (group_id) references group_(id) on delete cascade 
);

create table event_student(
    id int auto_increment primary key,
    group_id int,
    event_id int,
    day_ int,
    month_ int,
    event_name varchar (250),
    student_name varchar(250),
    student_user_id int,
    status int default 0,
    foreign key (group_id) references group_(id) on delete cascade,
    foreign key (event_id) references event(id) on delete cascade
);











