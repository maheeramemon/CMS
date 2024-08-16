CREATE DATABASE clubdb;
USE clubdb; 

CREATE TABLE Person
(
    UTD_ID Integer(10) AUTO_INCREMENT,
    Net_ID Char(9) NOT NULL,
    Name Varchar(50) NOT NULL,
    Email Varchar(50) NOT NULL,
    Major Varchar(20) NOT NULL,
    Password varchar(50) NOT NULL,
    PRIMARY KEY (UTD_ID) 
);

CREATE TABLE Student
(
    UTD_ID Integer(10),
    Year integer(4) NOT NULL,
    PRIMARY KEY (UTD_ID),
    FOREIGN KEY(UTD_ID) REFERENCES Person(UTD_ID) 
); 

CREATE TABLE Department
(
    DEPARTMENT_ID Integer(1) AUTO_INCREMENT,
    Name Varchar(50) NOT NULL,
    PRIMARY KEY (DEPARTMENT_ID)


); 
 

CREATE TABLE Faculty
(
    UTD_ID Integer(10),
    Department_ID Integer(1),
    Office VarChar(50),
    PRIMARY KEY (UTD_ID),
	FOREIGN KEY(Department_ID) REFERENCES Department(DEPARTMENT_ID) ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY(UTD_ID) REFERENCES Person(UTD_ID)

); 
CREATE TABLE Club
(
    Club_ID Integer(6) NOT NULL,
    Club_Name VarChar(30) NOT NULL,
    No_Members INT,
    DateOfEstablishment Integer(8) NOT NULL,
    ClubDescription VarChar(100),
    ClubType VarChar(30) NOT NULL,
    Recruitment_Status Bool NOT NULL, 
    Department_ID Integer(1),
    Faculty_ID Integer(10),
    PRIMARY KEY (Club_ID),
    FOREIGN KEY(Department_ID) REFERENCES Department(DEPARTMENT_ID) ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY(Faculty_ID) REFERENCES Faculty(UTD_ID) ON DELETE SET NULL ON UPDATE CASCADE

);
CREATE TABLE Member_Of
(
    Member_ID Integer(12) NOT NULL auto_increment,
    MemberUTD_ID Integer(10),
    Club_ID Integer(6) NOT NULL,
    PRIMARY KEY (Member_ID),
    FOREIGN KEY (MemberUTD_ID) REFERENCES Person(UTD_ID),
    FOREIGN KEY(Club_ID) REFERENCES Club(Club_ID)
);
CREATE TABLE Board_Of
(
    Member_ID Integer(12),
    Club_Position VarChar(20),
    PRIMARY KEY (Member_ID),
    FOREIGN KEY (Member_ID) REFERENCES Member_Of(Member_ID) ON DELETE CASCADE ON UPDATE CASCADE
);
CREATE TABLE Supervises
(
    FacultyUTD_ID Integer(10),
    Club_ID Integer(6),
    PRIMARY KEY (FacultyUTD_ID),
    FOREIGN KEY (FacultyUTD_ID) REFERENCES Person(UTD_ID) ON UPDATE CASCADE,
    FOREIGN KEY(Club_ID) REFERENCES Club(Club_ID) ON DELETE CASCADE ON UPDATE CASCADE
);







