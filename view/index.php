<html>
<head>
	<title>Sign In</title>
	<style>
		#title{
			text-align: center;
		}
		.container{
			padding: 0px;
			margin: 0 auto;
			width: 260px;
		}
		#out{
			text-align: center;
			color: red;
		}
	</style>
</head>
<body>
	<h1 id = title>Welcome!</h1>
	<form method="post">
		<div class=container>
			<b>Username:</b> <input type = text name=usr></input></br>
			<b>Password:</b> <input type = password name=pwd></input>
		</div>
		<div class=container>
			<input type="submit" name ="submit" value = "Login"></input>
			<input type="button" id=register value = "Register" onclick = "register()"></input>
		</div>
	</form>
<script>
	document.getElementById("register").onclick = function () {
	location.href = "register.php";
    };
</script>
</body>
</html>
<?php
	session_start();
	//if session already exists, redirect to profile
	if(isset($_SESSION['login_user'])){
		header("location: profile.php");
	}
	//if submit button is pressed, login
	if(isset($_POST['submit'])){
		$user = $_POST['usr'];
		$pass = $_POST{'pwd'};
		$error='';
		//if username or password field is empty, print error
		if (empty($user) || empty($pass)){
			$error = 'Username or Password field is empty';
			echo "<div id=out>$error</div>";
		}
		else{
			//connect to database
			$conn = pg_connect("") or die('Could not connect: ' . pg_last_error());
			//check if user exists in authentication table
			$result = pg_prepare($conn,"User_Check", "SELECT * FROM users.authentication WHERE username = $1");
			$result = pg_execute($conn,"User_Check", array($user));
			$rows = pg_num_rows($result);
			//if username exists, check password attempt
			if ($rows == 1) {
				$salt = pg_fetch_result($result,'salt');
				$pwh = sha1($pass);
				$attempt = sha1($pwh + $salt);
				//attempt to login using supplied credentials
				$result = pg_prepare($conn, "Login_Attempt", "SELECT * FROM users.authentication WHERE username = $1 AND password_hash = $2");
				$result = pg_execute($conn, "Login_Attempt", array($user,$attempt));
				$rows = pg_num_rows($result);
				//if credentials match, log the action of user
				if ($rows == 1) {
					$ip = $_SERVER['REMOTE_ADDR'];
					$result = pg_prepare($conn,"Log_Activity","INSERT INTO users.log (username,ip_address,action) VALUES($1,$2,'Account Login')");
					$result = pg_execute($conn, "Log_Activity",array($user,$ip));
					session_start();
					$_SESSION['login_user']=$user;
					//redirect to profile
					header("location: profile.php");
				}
				else{
					//if password is invalid, issue error
					$error = 'Password is invalid';
					echo "<div id=out>$error</div>";
				}
			}
			else{
				//if username is invalid, issue error
				$error = 'Username is invalid';
				echo "<div id=out>$error</div>";
			}
			//free result and close connection to database
			pg_free_result($result);
			pg_close($conn);
		}
	}
?>