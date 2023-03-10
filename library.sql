create database library;
use library;

create table admin(
  Username varchar(50) not null,
  Password varchar(16) not null,
  primary  key(Username)
);

insert into admin values('admin',12345678);

create table books(
  Book_No int(10) not null AUTO_INCREMENT, 
  Author varchar(50) not null,
  Title varchar(30) not null,
  Edition varchar(15) not null,
  Publisher varchar(50) not null,
  Total_Pages int not null,
  Cost int not null,
  Supplier varchar(50) not null,
  Bill_No varchar(20),
  Status varchar(20) default "Available",
  primary key(Book_No)
);

create table member(
  Member_ID varchar(20) not null primary key
);

create table student(
  Student_Rollno varchar(20) not null,
  Student_Name varchar(50) not null,
  Student_Course varchar(50) not null,
  Student_Enrollmentno varchar(20) not null,
  Student_Book1 int(10) default null,
  Student_Book2 int(10) default null,
  Student_Book3 int(10) default null,
  primary key(Student_Rollno)
);

create table faculty(
  Faculty_ID varchar(20) not null,
  Faculty_Name varchar(50) not null,
  Faculty_Type varchar(20) not null,
  Faculty_Fatherorhusband varchar(50) not null,
  Faculty_Book1 int(10) default null,
  Faculty_Book2 int(10) default null,
  Faculty_Book3 int(10) default null,
  Faculty_Book4 int(10) default null,
  Faculty_Book5 int(10) default null,
  primary key(Faculty_ID)
);

create table issue_return(
  Issue_No int not null AUTO_INCREMENT,
  Issue_By varchar(20) not null,
  Issue_Bookno int(10) not null,
  Issue_Date date not null,
  Return_Date date default null,
  primary key(Issue_No)
);

alter table issue_return
add constraint issue
foreign key(Issue_Bookno) references books(Book_No);

alter table issue_return
add constraint issue_member
foreign key(Issue_By) references member(Member_ID);

alter table student
add constraint student_member
foreign key(Student_Rollno) references member(Member_ID);

use library;
alter table faculty
add constraint faculty_member
foreign key(Faculty_ID) references member(Member_ID);

alter table faculty
add constraint faculty_1
foreign key(Faculty_Book1) references books(Book_No);

alter table faculty
add constraint faculty_2
foreign key(Faculty_Book2) references books(Book_No);

alter table faculty
add constraint faculty_3
foreign key(Faculty_Book3) references books(Book_No);

alter table faculty
add constraint faculty_4
foreign key(Faculty_Book4) references books(Book_No);

alter table faculty
add constraint faculty_5
foreign key(Faculty_Book5) references books(Book_No);

alter table student 
add constraint student_1 
foreign key(Student_Book1) references books(Book_No);

alter table student 
add constraint student_2
foreign key(Student_Book2) references books(Book_No);

alter table student 
add constraint student_3
foreign key(Student_Book3) references books(Book_No);