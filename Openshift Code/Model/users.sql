DROP TABLE IF EXISTS users.authentication CASCADE;
DROP TABLE IF EXISTS users.user_info CASCADE;
DROP TABLE IF EXISTS users.courses CASCADE;
DROP TABLE IF EXISTS users.professors CASCADE;
DROP TABLE IF EXISTS users.teaches CASCADE;
DROP TABLE IF EXISTS users.application CASCADE;
DROP TABLE IF EXISTS users.internationalapp CASCADE;
DROP TABLE IF EXISTS users.applied CASCADE;
DROP TABLE IF EXISTS users.applicantWants CASCADE;

DROP SCHEMA IF EXISTS users CASCADE;

CREATE SCHEMA users;

\echo 'Creating user_info...'
-- Table: users.user_info
-- Columns:
--    username          - The username for the account, supplied during registration.
--	  fname				- The first name of the user
--	  lname				- The last name of the user
--	  email				- The user's e-mail address
--	  phone				- The user's phone number
--    registration_date - The date the user registered. Set automatically.
--	  rating			- The rating given to the user by the admin.
--    comments		    - Comments on this user.  
CREATE TABLE users.user_info (
	username 			VARCHAR(30) PRIMARY KEY, --this should be larger just in case
	fname				VARCHAR(20) NOT NULL,
	lname				VARCHAR(20) NOT NULL,
	email				VARCHAR(40) NOT NULL, --this needs to be larger size, at min needs 25 but 30 would be better
	phone				VARCHAR(15) NOT NULL,
	registration_date 	TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	rating				INTEGER DEFAULT NULL,
	comments 			VARCHAR(500) DEFAULT NULL
);
\echo 'user_info created\n'

\echo 'inserting test values into user_info...'
INSERT INTO users.user_info VALUES('test1', 't1', 'tester1', 'test1@test.com', '123-456-7890', default, 5, 'n/a');
INSERT INTO users.user_info VALUES('test2', 't2', 'tester2', 'test2@test.com', '012-345-6789', default, 6, 'n/a');
INSERT INTO users.user_info VALUES('x', 'man', 'X', 'drx@test.com', '573-111-1111', default, default, 'n/a');
insert into users.user_info values('admin','admin', 'admin', 'adamspeichinger@gmail.com','314-444-5555', default, default, default);
\echo 'insertion complete\n'

\echo 'Creating authentication table...'
-- Table: users.authentication
-- Columns:
--    username      - The username tied to the authentication info.
--    password_hash - The hash of the user's password + salt. Expected to be SHA1.
--    salt          - The salt to use. Expected to be a SHA1 hash of a random input.
CREATE TABLE users.authentication (
	username 		VARCHAR(30) PRIMARY KEY,
	password_hash 	CHAR(40) NOT NULL,
	salt 			CHAR(40) NOT NULL,
	FOREIGN KEY (username) REFERENCES users.user_info(username)
);
\echo 'authentication table created\n'
insert into users.authentication values('admin', '4084cb683c5140dc777ccaf76dcb05395c433393', '4b35be0f7818df6954737ab957f691eb72a389d2');

\echo 'Creating professors table...'
--Table: users.professors
--Columns:
--	username	- The username of the instructor.
--	instructor	- The Instructor's Name.
--	
CREATE TABLE users.professors(
	username	VARCHAR(30) NOT NULL REFERENCES users.user_info PRIMARY KEY,
	instructor	VARCHAR(30) NOT NULL UNIQUE
);
\echo 'professors table created \n'

\echo 'inserting test data into professors (should be only 1)...'
INSERT INTO users.professors VALUES ('x','X');
\echo 'insertion complete\n'

\echo 'Creating courses table...'
--Table: users.courses
--Columns:
--	courseID	- The 5 digit course number found on myzou.
--	department	- The department which teaches this course.
--	courseNum	- The 4 digit course number.
--	instructor	- The instructor's name that teaches the course.
--	TA			- The TA for the course.
--	description	- A brief description of the course.
CREATE TABLE users.courses(
	--courseID	INTEGER PRIMARY KEY,
	department	VARCHAR(30),
	courseNum	INTEGER PRIMARY KEY,
	--instructor	VARCHAR(30) REFERENCES users.professors(instructor),
	TA			text[] DEFAULT NULL,--VARCHAR(30) DEFAULT NULL,
	description	VARCHAR(200)
);
\echo 'courses table created\n'

\echo 'inserting test data (should only be 1)...'
INSERT INTO users.courses VALUES('Computer Science',1000,DEFAULT,'Introduction to Computer Science');
INSERT INTO users.courses VALUES('Computer Science',1050,DEFAULT,'Algorithm Design and Programming I');
INSERT INTO users.courses VALUES('Computer Science',2050,DEFAULT,'Algorithm Design and Programming II');
INSERT INTO users.courses VALUES('Computer Science',2270,DEFAULT,'Introduction to Digital Logic');
INSERT INTO users.courses VALUES('Computer Science',2830,DEFAULT,'Introduction to the Internet, WWW and Multimedia Systems');
INSERT INTO users.courses VALUES('Computer Science',3050,DEFAULT,'Advanced Algorithm Design');
INSERT INTO users.courses VALUES('Computer Science',3280,DEFAULT,'Computer Organization and Assembly Language');
INSERT INTO users.courses VALUES('Computer Science',3330,DEFAULT,'Object Oriented Programming');
INSERT INTO users.courses VALUES('Computer Science',3380,DEFAULT,'Database Applications and Information Systems');
INSERT INTO users.courses VALUES('Computer Science',3530,DEFAULT,'UNIX Operating System');
INSERT INTO users.courses VALUES('Computer Science',3940,DEFAULT,'Internship in Computer Science');
INSERT INTO users.courses VALUES('Computer Science',4001,DEFAULT,'Topics in Computer Science');
INSERT INTO users.courses VALUES('Computer Science',4050,DEFAULT,'Design and Analysis of Algorithms I');
\echo 'insertion complete\n'

\echo 'Creating teaches table...'
--Table: users.teaches
--Columns:
--	username	- The username of the instructor that teaches the class
--	courseID	- The course number of the class
CREATE TABLE users.teaches(
	username	VARCHAR (30) NOT NULL REFERENCES users.professors PRIMARY KEY,
	courseID	INTEGER REFERENCES users.courses
);
\echo 'teaches table create\n'

\echo 'inserting test data (should only be 1)...'
INSERT INTO users.teaches VALUES('x', 1050);
\echo 'insertion complete\n'

\echo 'Creating applications table....'
--Table: users.applications
--Columns:
--	appID			- The primary key for the application table.
--	username		- Username that will reference user_info primary key
--	major			- The major of the applicant
--	gradDate		- The graduation date of the applicant
--	previous		- Classes the applicant has been a TA for.
--	cur				- Classes the applicant is currently a TA in.
--	GPA				- The applicant's GPA
--	isGrad			- Boolean variable to determine if applicant is a graduate student
--	degree			- The degree level of the applicant
--	advisor			- The applicant's advisor
--	isInternational	- Boolean variable to flag if the applicant is international.
--	GATO			- Boolean variable to flag if the applicant has gone to orientation.
CREATE TABLE users.applications(
	--appID				SERIAL PRIMARY KEY,
	username			VARCHAR(30) NOT NULL REFERENCES users.user_info PRIMARY KEY,
	studentID			INTEGER NOT NULL UNIQUE,
	major				VARCHAR(20) NOT NULL,
	gradDate			VARCHAR(20) NOT NULL,
	previous			text,--VARCHAR(50),
	cur					text,--VARCHAR(50),
	GPA					VARCHAR(4) NOT NULL,
	isGrad				BOOLEAN,
	degree				VARCHAR(20) NOT NULL,
	Advisor				VARCHAR(30) NOT NULL,
	isInternational		BOOLEAN,
	GATO				BOOLEAN,
	filename 			text,
	pdf 				bytea
);
\echo 'applications table created\n'

\echo 'inserting test data (should be 2)....'
INSERT INTO users.applications VALUES('test1', 12345678, 'computer science', 'spring 2015', 
	'CMP_SC 1040', 'CMP_SC 1040', '3.5', false, 'Bachelors', 'Adrianna Wheeler', false,
	false);
INSERT INTO users.applications VALUES('test2', 23456789, 'computer science', 'spring 2015', 
	'CMP_SC 1050', 'CMP_SC 1050', '3.6', true, 'Masters', 'Adrianna Wheeler', true,
	true);
\echo 'insertion complete\n'
	
\echo 'Creating internationalapp table..'
--Table: users.internationalapp
--Columns:
--	appID		-The application ID of the international applicant.
--	SPEAK		-Flag for whether the applicant has completed SPEAK assessment.
--	SPEAKdate	-Field for the date of their speak assessment if SPEAK is FALSE.
--	ONITA		-Flag for whether the applicant has completed ONITA.
--	willAttend	-Flag for if they will attend if ONITA is FALSE.
CREATE TABLE users.internationalapp(
	--appID		INTEGER REFERENCES users.applications,
	username	VARCHAR(30) NOT NULL REFERENCES users.user_info PRIMARY KEY,
	SPEAK		BOOLEAN NOT NULL,
	SPEAKscore	VARCHAR(4) DEFAULT NULL,
	SPEAKdate	VARCHAR(15),
	ONITA		BOOLEAN NOT NULL
	--willAttend	BOOLEAN	
);
\echo 'table created\n'

\echo 'inserting test data (should be 1)...'
INSERT INTO users.internationalapp VALUES('test2', true, '93.6', '04-24-13', true);
\echo 'insertion complete\n'

/* \echo 'Creating applied table...'
--Table: users.applied
--Columns:
--	appID		-The applicationID from the application table.
--	username	-The username of the applicant
--	course		-the course that they are applying for.
--	status		-The status of the application.
CREATE TABLE users.applied(
	--appID 		INTEGER REFERENCES users.applications PRIMARY KEY,
	username	VARCHAR(30) NOT NULL REFERENCES users.user_info PRIMARY KEY,
	course		INTEGER REFERENCES users.courses(courseID),
	status		VARCHAR(20) NOT NULL
);
\echo 'table created\n'

\echo 'inserting test data (should be 2)...'
INSERT INTO users.applied VALUES( 'test1', 1050, 'Accepted');
INSERT INTO users.applied VALUES( 'test2', 1050, 'Denied');
\echo 'insertion complete\n' */

\echo 'Create applicantWants table...'
--Table: users.applicantWants
--Columns:
--	ID			-An ID for the table.
--	username	-the username of the applicant
--	course		-the course they want to TA
--	grade		-The grade they received in the course noted above.
CREATE TABLE users.applicantWants(
	--ID 			SERIAL PRIMARY KEY,
	username	VARCHAR(30) NOT NULL REFERENCES users.user_info,
	courseNum	INTEGER REFERENCES users.courses(courseNum),
	grade		VARCHAR(2) NOT NULL,
	status		VARCHAR(20) NOT NULL
);
\echo 'table created\n'

\echo 'inserting test data (should be 2)...'
INSERT INTO users.applicantWants VALUES('test1', 1050, 'A','Accepted');
INSERT INTO users.applicantWants VALUES('test2', 1050, 'B', 'Denied');
\echo 'insertion complete\n\n'

--Table:users.timewindow
--Colums:
--	userdate	-date of user timewindow
--	teacherdate	-date of instructor timewindow
CREATE TABLE users.timewindow(
	userdateStart		date,
	userdateEnd			date,
	teacherdateStart 	date,
	teacherdateEnd		date
);
