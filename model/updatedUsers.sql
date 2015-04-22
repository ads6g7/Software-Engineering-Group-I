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
	comments 			VARCHAR(500)
);

INSERT INTO users.user_info VALUES('test1', 't1', 'tester1', 'test1@test.com', '123-456-7890', default, 5, 'n/a');
INSERT INTO users.user_info VALUES('test2', 't2', 'tester2', 'test2@test.com', '012-345-6789', default, 6, 'n/a');
INSERT INTO users.user_info VALUES('x', 'man', 'X', 'drx@test.com', '573-111-1111', default, default, 'n/a');

--Table: users.professors
--Columns:
--	username	- The username of the instructor.
--	instructor	- The Instructor's Name.
--	
CREATE TABLE users.professors(
	username	VARCHAR(30) NOT NULL REFERENCES users.user_info PRIMARY KEY,
	instructor	VARCHAR(30) NOT NULL UNIQUE
);

INSERT INTO users.professors VALUES ('x','X');

--Table: users.courses
--Columns:
--	courseID	- The 5 digit course number found on myzou.
--	department	- The department which teaches this course.
--	courseNum	- The 4 digit course number.
--	instructor	- The instructor's name that teaches the course.
--	TA			- The TA for the course.
--	description	- A brief description of the course.
CREATE TABLE users.courses(
	courseID	INTEGER PRIMARY KEY,
	department	VARCHAR(30),
	courseNum	INTEGER,
	instructor	VARCHAR(30) REFERENCES users.professors(instructor),
	TA			VARCHAR(30) DEFAULT NULL,
	description	VARCHAR(200)
);

INSERT INTO users.courses VALUES(1050,'Computer Science',1050,'X','test2','Algorithm Design and Programming 1');


--Table: users.teaches
--Columns:
--	username	- The username of the instructor that teaches the class
--	courseID	- The course number of the class
CREATE TABLE users.teaches(
	username	VARCHAR (30) NOT NULL REFERENCES users.professors PRIMARY KEY,
	courseID	INTEGER REFERENCES users.courses
);

INSERT INTO users.teaches VALUES('x', 1050);

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
	major				VARCHAR(20) NOT NULL,
	gradDate			VARCHAR(20) NOT NULL,
	previous			VARCHAR(50),
	cur					VARCHAR(50),
	GPA					VARCHAR(4) NOT NULL,
	isGrad				BOOLEAN,
	degree				VARCHAR(20) NOT NULL,
	Advisor				VARCHAR(30) NOT NULL,
	isInternational		BOOLEAN,
	GATO				BOOLEAN,
	filename 			text,
	pdf 				bytea
);

INSERT INTO users.applications VALUES('test1', 'computer science', 'spring 2015', 
	'CMP_SC 1040', 'CMP_SC 1040', '3.5', false, 'Bachelors', 'Adrianna Wheeler', false,
	false);
INSERT INTO users.applications VALUES('test2', 'computer science', 'spring 2015', 
	'CMP_SC 1050', 'CMP_SC 1050', '3.6', true, 'Masters', 'Adrianna Wheeler', true,
	true);
	
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
	SPEAK		BOOLEAN,
	SPEAKdate	VARCHAR(15),
	ONITA		BOOLEAN,
	willAttend	BOOLEAN	
);

INSERT INTO users.internationalapp VALUES('test2', true, '04-24-13', true, false);

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

INSERT INTO users.applied VALUES( 'test1', 1050, 'Accepted');
INSERT INTO users.applied VALUES( 'test2', 1050, 'Denied');

--Table: users.applicantWants
--Columns:
--	ID			-An ID for the table.
--	username	-the username of the applicant
--	course		-the course they want to TA
--	grade		-The grade they received in the course noted above.
CREATE TABLE users.applicantWants(
	--ID 			SERIAL PRIMARY KEY,
	username	VARCHAR(30) NOT NULL REFERENCES users.user_info,
	course		INTEGER REFERENCES users.courses(courseID),
	grade		VARCHAR(2) NOT NULL
);

INSERT INTO users.applicantWants VALUES('test1', 1050, 'A');
INSERT INTO users.applicantWants VALUES('test2', 1050, 'B');
