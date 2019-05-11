create table group_ (
    id int primary key auto_increment,
    name varchar(250),
    description text,
    created_year int,
    status int
);

create table user_ (
    id int primary key auto_increment,
    login varchar (20)  unique,
    role varchar (20),
);

create table student(
    id int primary key auto_increment,
    name varchar(250),
    group_id int,
    user_id int,
    foreign key (group_id) references group_(id) on delete cascade,
    foreign key (user_id) references user_(user_id), 
);

create table teacher (
    id int primary key auto_increment,
    name varchar(250)
);

create table lesson (
    id int primary key auto_increment,
    name varchar(250),
    description text
);
create table tea_less (
    tea_less_id int primary key auto_increment,
    tea_id int,
    less_id int,
    foreign key (tea_id) references teacher(id),
    foreign key (less_id) references lesson(id)
);

create table gr_less(
    gr_id int,
    tea_less_id int,
    semester int,
    status int,
    note double,
    foreign key (gr_id) references group_(id),
    foreign key (tea_less_id) references tea_less(tea_less_id)
    
);

create table result (
    st_id int,
    tea_less_id int,
    note double,
    foreign key (st_id) references student(id),
    foreign key (tea_less_id) references tea_less(tea_less_id)
);

 