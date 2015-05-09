<?php
	if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == ""){
		$redirect = "https://".$_SERVER['HTTP_HOST']. $_SERVER['REQUEST_URI'];
		header("Location: $redirect");
	}
	
	$_SESSION['INVALID_LOGIN'] = 0;
/*	session_start();
	if(isset($_SESSION['USERNAME']) && $_SESSION['USERNAME'] != ''){
		HEADER('Location: home.php');
	}*/
?>
<html>
<title> Logging In </title>
</html>

<?php
	//include("../secure/database.php");
	//$conn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect: '.pg_last_error());
	$conn = pg_connect("host=/var/lib/openshift/5527ddbb5973cacee00000e9/postgresql/socket/ dbname=groupi user=adminup8hecl password=evnEWGkla94u") or die('Unable to connect to database' .pg_last_error());

	$username = htmlspecialchars($_POST['username']);
	$password = htmlspecialchars($_POST['password']);
	
	$result = pg_prepare($conn,"User_Check", "SELECT * FROM users.authentication WHERE username = $1") or die('Could not connect!!!: '.pg_last_error());
	$result = pg_execute($conn,"User_Check", array($username)) or die('Could not connect???: '.pg_last_error());
	$rows = pg_num_rows($result);
	
	if ($rows == 1) {
	
		$salt = pg_fetch_result($result,'salt');
		$attempt = sha1($salt . $password);
		//attempt to login using supplied credentials
		$result = pg_prepare($conn, "Login_Attempt", "SELECT * FROM users.authentication WHERE username = $1 AND password_hash = $2") or die('Could not connect%%%: '.pg_last_error());
		$result = pg_execute($conn, "Login_Attempt", array($username, $attempt)) or die('Could not connect###: '.pg_last_error());
		$rows = pg_num_rows($result);
		session_start();
		if ($rows == 1){
			//login successful, so start session
			$_SESSION['USERNAME']=$username;
			//check if user is a professor
			$result = pg_prepare($conn, "Login_Attempt2", "SELECT * FROM users.professors WHERE username = $1") or die('Could not connect@@@: '.pg_last_error());
			$result = pg_execute($conn, "Login_Attempt2", array($username)) or die('Could not connect***: '.pg_last_error());
			$rows = pg_num_rows($result);
			
			//User is a professor, redirect
			if ($rows==1)
			{
				header("Location: https://groupi-softwareeng.rhcloud.com/View/teacherdashboard.php");
			}
			
			//Check if user is admin, redirect
			else if (strcmp($username, "admin")==0)
			{
				header("Location: https://groupi-softwareeng.rhcloud.com/View/admindashboard.php");
			}
			
			//otherwise redirect to applicantdash
			else
			{
				header("Location: https://groupi-softwareeng.rhcloud.com/View/applicantdashboard.php");
			}
		}
		else{
			//session_start();
			$_SESSION['INVALID_LOGIN'] = 'notValid';
			header("Location: https://groupi-softwareeng.rhcloud.com");
		}
	}		
	else{
		session_start();
		$_SESSION['INVALID_LOGIN'] = 'notValid';
		header("Location: https://groupi-softwareeng.rhcloud.com");
	}
?>
