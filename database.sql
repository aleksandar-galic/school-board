create table school_board.boards
(
    id   int auto_increment
        primary key,
    name text not null
);

create table school_board.students
(
    id       int auto_increment
        primary key,
    name     text not null,
    board_id int  not null,
    constraint students_boards_id_fk
        foreign key (board_id) references school_board.boards (id)
);

create table school_board.grades
(
    id         int auto_increment
        primary key,
    student_id int not null,
    subject     text not null,
    value      int not null,
    constraint grades_students_id_fk
        foreign key (student_id) references school_board.students (id)
);


-- Populate students table
insert into students (name, board_id)
values ('Aleksandar', 1);

insert into students (name, board_id)
values ('Katarina', 2);

-- Populate grades table
insert into grades (student_id, value)
values (1, 'languages', 8);
insert into grades (student_id, value)
values (1, 'mathematics', 6);
insert into grades (student_id, value)
values (1, 'programming', 7);
insert into grades (student_id, value)
values (1, 'science', 10);

insert into grades (student_id, value)
values (2, 'languages', 8);
insert into grades (student_id, value)
values (2, 'languages', 10);
insert into grades (student_id, value)
values (2, 'languages', 9);
insert into grades (student_id, value)
values (2, 'languages', 6);

-- Populate boards table

insert into boards (name)
values ('CSM');

insert into boards (name)
values ('CSMB');
