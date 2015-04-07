DROP TABLE IF EXISTS users.log;
DROP TABLE IF EXISTS users.authentication;
DROP TABLE IF EXISTS users.user_info;
DROP TABLE IF EXISTS users.courses;
DROP TABLE IF EXISTS users.professors;
DROP TABLE IF EXISTS users.teaches;
DROP TABLE IF EXISTS users.application;
DROP TABLE IF EXISTS users.internationalapp;

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
--    comments		    - Comments on this user.
CREATE TABLE users.user_info (
	username 			VARCHAR(30) PRIMARY KEY REFERENCES users.authentication,
	fname				VARCHAR(20) NOT NULL,
	lname				VARCHAR(20) NOT NULL,
	email				VARCHAR(20) NOT NULL,
	phone				VARCHAR(15) NOT NULL,
	registration_date 	TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
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

-- Table: users.log
-- Columns:
--    log_id     - A unique ID for the log entry. Set by a sequence.
--    username   - The user whose action generated this log entry.
--    ip_address - The IP address of the user at the time the log was entered.
--    log_date   - The date of the log entry. Set automatically by a default value.
--    action     - What the user did to generate a log entry (i.e., "logged in").
CREATE TABLE users.log (
	log_id  	SERIAL PRIMARY KEY,
	username 	VARCHAR(30) NOT NULL REFERENCES users.user_info,
	ip_address 	VARCHAR(15) NOT NULL,
	log_date 	TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	action 		VARCHAR(50) NOT NULL

);

--Table: users.course
--Columns:
--	courseID	- The 5 digit course number found on myzou.
--	department	- The department which teaches this course.
--	courseNum	- The 4 digit course number.
--	instructor	- The instructor's name that teaches the course.
--	TA			- The TA for the course.
--	description	- A brief description of the course.
CREATE TABLE users.courses(
	courseID	INT(5) PRIMARY KEY,
	department	VARCHAR(20),
	courseNum	INT(4),
	instructor	VARCHAR(30) REFERENCES users.professor,
	TA			VARCHAR(30) DEFAULT NULL,
	description	VARCHAR(200)
);

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
	username	VARCHAR (30) NOT NULL REFERENCES users.user_info PRIMARY KEY,
	courseID	INT REFERENCES users.courses
);

--Table: users.application
--Columns:
--	appID			- The primary key for the application table.
--	major			- The major of the applicant
--	gradDate		- The graduation date of the applicant
--	previous		- 
--	cur				- 
--	want			- 
--	GPA				- The applicant's GPA
--	isGrad			- Boolean variable to determine if applicant is a graduate student
--	degree			- The degree of the applicant
--	advisor			- The applicant's advisor
--	isInternational	- Boolean variable to flag if the applicant is international
CREATE TABLE users.application(
	appID
	major
	gradDate
	previous
	cur
	want
	GPA
	isGrad
	degree
	Advisor
	isInternational
);

--Table: users.internationalapp
--Columns:
--
--
--
CREATE TABLE users.internationalapp(
	
	
);

CREATE INDEX log_log_id_index ON users.log (username);


