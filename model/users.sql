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

INSERT INTO users.user_info VALUES('x', 'dr', 'x', 'something@something.com', '123-456-7890', default, 0, 'n/a');

--Table: users.professors
--Columns:
--	username	- The username of the instructor.
--	instructor	- The Instructor's Name.
--	
CREATE TABLE users.professors(
	username	VARCHAR(30) NOT NULL REFERENCES users.user_info PRIMARY KEY,
	instructor	VARCHAR(30) NOT NULL UNIQUE
);

INSERT INTO users.professors VALUES ('x','Dr. X');
--INSERT INTO users.professors VALUES (,'Dr. Y');
--INSERT INTO users.professors VALUES (,'Dr. Z');
--INSERT INTO users.professors VALUES (,'Dr. A');

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

INSERT INTO users.courses VALUES(59500,'Computer Science',1050,'Dr. X','Guy1','Algorithm Design and Programming 1');
--INSERT INTO users.courses VALUES(59506,'Computer Science',2050,'Dr. Y','Guy2','Algorithm Design and Programming 2');
--INSERT INTO users.courses VALUES(59510,'Computer Science',2270,'Dr. Z','Guy2','Introduction to Digital Logic');
--INSERT INTO users.courses VALUES(59509,'Computer Science',2830,'Dr. A','Girl1','Introduction to the Internet, WWW and Multimedia Systems');


--Table: users.teaches
--Columns:
--	username	- The username of the instructor that teaches the class
--	courseID	- The course number of the class
CREATE TABLE users.teaches(
	username	VARCHAR (30) NOT NULL REFERENCES users.professors PRIMARY KEY,
	courseID	INTEGER REFERENCES users.courses
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
	appID				SERIAL PRIMARY KEY,
	major				VARCHAR(20) NOT NULL,
	gradDate			VARCHAR(20) NOT NULL,
	previous			VARCHAR(50),
	cur					VARCHAR(50),
	GPA					INTEGER NOT NULL,
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
	appID		INTEGER REFERENCES users.applications,
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
	appID 		INTEGER REFERENCES users.applications PRIMARY KEY,
	username	VARCHAR(30) NOT NULL REFERENCES users.user_info,
	course		INTEGER REFERENCES users.courses(courseID),
	status		VARCHAR(20) NOT NULL
);

--Table: users.applicantWants
--Columns:
--	ID			-An ID for the table.
--	username	-the username of the applicant
--	course		-the course they want to TA
--	grade		-The grade they received in the course noted above.
CREATE TABLE users.applicantWants(
	ID 			SERIAL PRIMARY KEY,
	username	VARCHAR(30) NOT NULL REFERENCES users.user_info,
	course		INTEGER REFERENCES users.courses(courseID),
	grade		VARCHAR(2) NOT NULL
);

