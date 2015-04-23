<?php

	// Here we are using sessions to propagate the login
	if(!session_start()) {
		// If the session couldn't start, present an error
		header("Location: error.php");
		exit;
	}
	
	$dbconn = pg_connect("host=/var/lib/openshift/5527ddbb5973cacee00000e9/postgresql/socket/ 
		dbname=groupi 
		user=adminup8hecl 
		password=evnEWGkla94u") 
		or die('Unable to connect to database' .pg_last_error());
	
	// Check to see if the user has already logged in
	$loggedIn = empty($_SESSION['loggedin']) ? false : $_SESSION['loggedin'];
	
	// checks for logged in status. will need to add additional checks for
	//		applicant
	//		professor
	//		admin
	if ($loggedIn) {
		//Temporary dashboard redirect
		header("Location: http://groupi-softwareeng.rhcloud.com/applicantdashboard.html");
		exit;
	}
	
	
	$action = empty($_POST['action']) ? '' : $_POST['action'];
	
	if ($action == 'do_login') {
		handle_login();
	} else {
		login_form();
	}
	
	//Still need to check against the DB for password
	function handle_login() {
		$username = empty($_POST['username']) ? '' : $_POST['username'];
		$password = empty($_POST['password']) ? '' : $_POST['password'];
	
		if ($username == "admin" && $password == "admin") {
			// Instead of setting a cookie, we'll set a key/value pair in $_SESSION
			$_SESSION['loggedin'] = $username;
			header("Location: http://groupi-softwareeng.rhcloud.com/applicantdashboard.html");//again, temp redirect to dashboard
			exit;
		} else {
			$error = 'Login failed.  Please enter your username and password.';
			//require "login_form.php";
		}		
	}
	
	function login_form() {
		$username = "";
		$error = "";
		//require "login_form.php";
	}
	
?>
