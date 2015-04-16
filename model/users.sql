DROP TABLE IF EXISTS users.authentication;
DROP TABLE IF EXISTS users.user_info;
DROP TABLE IF EXISTS users.courses;
DROP TABLE IF EXISTS users.professors;
DROP TABLE IF EXISTS users.teaches;
DROP TABLE IF EXISTS users.application;
DROP TABLE IF EXISTS users.internationalapp;
DROP TABLE IF EXISTS users.applied;
DROP TABLE IF EXISTS users.applicantWants;

DROP SCHEMA IF EXISTS users;

CREATE SCHEMA users;

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
	username 			VARCHAR(30) PRIMARY KEY REFERENCES users.authentication,
	fname				VARCHAR(20) NOT NULL,
	lname				VARCHAR(20) NOT NULL,
	email				VARCHAR(20) NOT NULL,
	phone				VARCHAR(15) NOT NULL,
	registration_date 	TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	rating				INT DEFAULT NULL,
	comments 			VARCHAR(500)
);

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

--Table: users.courses
--Columns:
--	courseID	- The 5 digit course number found on myzou.
--	department	- The department which teaches this course.
--	courseNum	- The 4 digit course number.
--	instructor	- The instructor's name that teaches the course.
--	TA			- The TA for the course.
--	description	- A brief description of the course.
CREATE TABLE users.courses(
	courseID	INT PRIMARY KEY,
	department	VARCHAR(20),
	courseNum	INT,
	instructor	VARCHAR(30) REFERENCES users.professor,
	TA			VARCHAR(30) DEFAULT NULL,
	description	VARCHAR(200)
);

INSERT INTO users.courses VALUES(59500,'Computer Science',1050,,'Algorithm Design and Programming 1');
INSERT INTO users.courses VALUES(59506,'Computer Science',2050,,'Algorithm Design and Programming 2');
INSERT INTO users.courses VALUES(59510,'Computer Science',2270,,'Introduction to Digital Logic');
INSERT INTO users.courses VALUES(59509,'Computer Science',2830,,'Introduction to the Internet, WWW and Multimedia Systems');

--Table: users.professors
--Columns:
--	username	- The username of the instructor.
--	instructor	- The Instructor's Name.
--	
CREATE TABLE users.professors(
	username	VARCHAR(30) NOT NULL REFERENCES users.user_info PRIMARY KEY,
	instructor	VARCHAR(30) NOT NULL
);

--Table: users.teaches
--Columns:
--	username	- The username of the instructor that teaches the class
--	courseID	- The course number of the class
CREATE TABLE users.teaches(
	username	VARCHAR (30) NOT NULL REFERENCES users.professors PRIMARY KEY,
	courseID	INT REFERENCES users.courses
);

--Table: users.applications
--Columns:
--	appID			- The primary key for the application table.
--	major			- The major of the applicant
--	gradDate		- The graduation date of the applicant
--	previous		- Classes the applicant has been a TA for.
--	cur				- Classes the applicant is currently a TA in.
--	GPA				- The applicant's GPA
--	isGrad			- Boolean variable to determine if applicant is a graduate student
--	degree			- The degree of the applicant
--	advisor			- The applicant's advisor
--	isInternational	- Boolean variable to flag if the applicant is international.
--	GATO			- Boolean variable to flag if the applicant has gone to orientation.
CREATE TABLE users.applications(
	appID				SERIAL INT PRIMARY KEY,
	major				VARCHAR(20) NOT NULL,
	gradDate			VARCHAR(20) NOT NULL,
	previous			VARCHAR(50),
	cur					VARCHAR(50),
	GPA					INT NOT NULL,
	isGrad				BOOLEAN,
	degree				VARCHAR(20) NOT NULL,
	Advisor				VARCHAR(30) NOT NULL,
	isInternational		BOOLEAN,
	GATO				BOOLEAN,
	filename 			text,
	pdf 				bytea
);

--Table: users.internationalapp
--Columns:
--	appID		-The application ID of the international applicant.
--	SPEAK		-Flag for whether the applicant has completed SPEAK assessment.
--	SPEAKdate	-Field for the date of their speak assessment if SPEAK is FALSE.
--	ONITA		-Flag for whether the applicant has completed ONITA.
--	willAttend	-Flag for if they will attend if ONITA is FALSE.
CREATE TABLE users.internationalapp(
	appID		INT REFERENCES users.applications,
	SPEAK		BOOLEAN,
	SPEAKdate	VARCHAR(15),
	ONITA		BOOLEAN,
	willAttend	BOOLEAN	
);

--Table: users.applied
--Columns:
--	appID		-The applicationID from the application table.
--	username	-The username of the applicant
--	course		-the course that they are applying for.
--	status		-The status of the application.
CREATE TABLE users.applied(
	appID 		INT REFERENCES users.application PRIMARY KEY,
	username	VARCHAR(30) NOT NULL REFERENCES users.user_info,
	course		INT REFERENCES users.courses(courseID),
	status		VARCHAR(20) NOT NULL
);

--Table: users.applicantWants
--Columns:
--	ID			-An ID for the table.
--	username	-the username of the applicant
--	course		-the course they want to TA
--	grade		-The grade they received in the course noted above.
CREATE TABLE users.applicantWants(
	ID 			SERIAL INT PRIMARY KEY,
	username	VARCHAR(30) NOT NULL REFERENCES users.user_info,
	course		INT REFERENCES users.courses(courseID),
	grade		VARCHAR(2) NOT NULL
);

