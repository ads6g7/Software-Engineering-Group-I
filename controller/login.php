<!--
	GroupI
	Software Engineering
	4/23/15
	login.php
	Description: login.php handles all login attempts on index.html. On a successful login, the user is redirected to
				 either the admin, professor, or applicant dashboards accordingly.
-->

<?php
	
	// Here we are using sessions to propagate the login
	if(!session_start()) {
		// If the session couldn't start, present an error
		header("Location: errorSession.php");
		exit;
	}

	$errors = 0; // track errors

	$dbhost = "host=/var/lib/openshift/5527ddbb5973cacee00000e9/postgresql/socket/";
	$dbuser = "adminup8hec1";
	$dbpass = "evnEWGkla94u";	
	$dbname = "groupi";
	$dbconn = pg_connect($dbhost, $dbname, $dbuser, $dbpass) or die('Unable to connect to database' . pg_last_error());

	if(!$dbconn)
		echo "Error: Unable to connect to the database server!" . "Error code: " . pg_last_error() . "</p>\n";
	else
		echo "Opened database successfully!";
	

	// Check to see if the user has already logged in
	$loggedIn = empty($_SESSION['loggedin']) ? false : $_SESSION['loggedin'];
	
	/* checks for logged in status. will need to add additional checks for
			applicant
			professor
			admin
	*/
	if ($loggedIn) {
		//Temporary dashboard redirect
		header("Location: http://groupi-softwareeng.rhcloud.com/applicantdashboard.html");
		exit;
	}
	
	
	$action = empty($_POST['action']) ? '' : $_POST['action']; //looks at the form action. We have a hidden element with action do_login
	
	if ($action == 'do_login') {
		handle_login();
	} else {
		login_form();
	}
	
	//Still need to check against the DB for password
	function handle_login() {
		$username = empty($_POST['username']) ? '' : stripslashes($_POST['username']); // if(username is empty) $username = ''; else $username = stripslashes($_POST['username']);
		$password = empty($_POST['password']) ? '' : stripslashes($_POST['password']);
		$failedQuery = "Failed check query";
		
		// Check for professor login
		if($errors == 0)
		{
			$query = "SELECT username FROM users.professors WHERE username = '" . $1 . "' and '" . "SELECT password FROM users.authentication WHERE password_hash = '" . $2 . "'";
			$result = pg_prepare($dbconn, "Check", $query) or die("Invalid query" . pg_last_error());
			$found = pg_execute($dbconn, "Check", array($username, $password)) or die("Couldn't authenticate username or password: " . pg_last_error());
			if($found == 0)
			{
				echo "<p>The username or password combination entered is not valid.</p>\n";
				++$errors;

			}
			else
			{
				//direct them to professor dashboard
				header("Location: http://groupi-softwareeng.rhcloud.com/professordashboard.html");
			}
		}
		
		if($errors > 0)
			echo "<p>Please use your browser's BACK button to return to the form and fix the errors indicated. </p>";
			//header("Location: http://groupi-softwareeng.rhcloud.com/");

		/* 
		$query = "SELECT username FROM users.professors WHERE username = $1";
		
		$result = pg_prepare($dbconn, "Check", $query);
		$found = pg_execute($dbconn, "Check", array($username));
		if($found == 1)
		{
			 
		}
		else if()
		*/

		/*$result = pg_query($dbconn, $query) or die($failedQuery . pg_last_error());
		while()*/
	
		/*if ($username == "admin" && $password == "admin") {
			// Instead of setting a cookie, we'll set a key/value pair in $_SESSION
			$_SESSION['loggedin'] = $username;
			header("Location: http://groupi-softwareeng.rhcloud.com/applicantdashboard.html");//again, temp redirect to dashboard
			exit;
		} else {
			$error = 'Login failed.  Please enter your username and password.';
			require "signin.php";
		}		
		*/
	}
	
	function login_form() {
		$username = "";
		$error = "";
		require "signin.php";
	}

	pg_close($dbconn);	
?>