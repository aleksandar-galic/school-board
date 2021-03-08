create database school_board;

use school_board;

create table boards
(
    id int auto_increment primary key,
    name text not null
);

create table students
(
    id int auto_increment primary key,
    name text not null,
    board_id int not null
);

create table grades
(
    id int auto_increment primary key,
    student_id int not null,
    subject text not null,
    value int not null
);

alter table students
add foreign key (board_id) references boards(id);

alter table grades
add foreign key (student_id) references students(id);

-- Populate boards table
insert into boards (name)
values ('CSM');

insert into boards (name)
values ('CSMB');

-- Populate students table
insert into students (name, board_id)
values ('Aleksandar', 1);

insert into students (name, board_id)
values ('Katarina', 2);

-- Populate grades table
insert into grades (student_id, subject, value)
values (1, 'languages', 8);
insert into grades (student_id, subject, value)
values (1, 'mathematics', 6);
insert into grades (student_id, subject, value)
values (1, 'programming', 7);
insert into grades (student_id, subject, value)
values (1, 'science', 10);

insert into grades (student_id, subject, value)
values (2, 'languages', 8);
insert into grades (student_id, subject, value)
values (2, 'mathematics', 10);
insert into grades (student_id, subject, value)
values (2, 'programming', 9);
insert into grades (student_id, subject, value)
values (2, 'science', 6);
