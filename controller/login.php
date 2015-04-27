<!--
	GroupI
	Software Engineering
	4/23/15
	login.php
	Description: login.php handles all login attempts on index.html. On a successful login, the user is redirected to
				 either the admin, professor, or applicant dashboards accordingly.
-->
<!DOCTYPE html>
<html>
<?php
	require_once("config.php");
?>
	<head>
		<title>Authentication</title>
	</head>

	<body>
<?php
	//require_once("config.php");
	
	// Here we are using sessions to propagate the login
	session_start();
	if(!session_start()) {
		// If the session couldn't start, present an error
		header("Location: errorSession.php");
		exit;
	}
	
	$errors = 0; // track errors
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

		//$conn_string = pg_connect("host=/var/lib/openshift/5527ddbb5973cacee00000e9/postgresql/socket/ user=adminup8hecl password=evnEWGkla94u dbname=groupi") or die('Could not connect to DB ' . pg_last_error());
		$dbconn = pg_connect(DB_HOST DB_USER DB_PASS DB_NAME) or die('<p>Unable to connect to database!</p>');

		// Check for connection to database
		if(!$dbconn)
			echo "<p>Error: Unable to connect to the database server! " . "Error code: " . pg_last_error() . "</p>\n";
		else
			echo "<p>Opened database successfully!</p>\n";
		
		// Check for professor login
		if($errors == 0)
		{
			$query = 'SELECT username, password FROM users.professors INNER JOIN users.authentication using(username) WHERE username = $1 AND password = $2';
			//$query = "SELECT username FROM users.professors WHERE username = '" . $1 . "' and '" . "SELECT password FROM users.authentication WHERE password_hash = '" . $2 . "'";
			$result = pg_prepare($dbconn, "Check", $query) or die($failedQuery . pg_last_error());
			$found = pg_execute($dbconn, "Check", array($username, sha1($password))) or die($failedQuery . pg_last_error());
			if($found == 0)
			{
				//If not found in users.professors, check users.user_info?
				$query = "SELECT username FROM users.user_info WHERE username = '" . $1 . "' and '" . "SELECT password FROM users.authentication WHERE password_hash = '" . $2 . "'";
				$result = pg_prepare($dbconn, "Check", $query) or die("Invalid query" . pg_last_error());
				$found = pg_execute($dbconn, "Check", array($username, sha1($password))) or die("Couldn't authenticate username or password: " . pg_last_error());
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

	}
	
	function login_form() {
		$username = "";
		$error = "";
		require "signin.php";
	}

	pg_close($dbconn);	
?>
	</body>
</html>