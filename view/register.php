<!DOCTYPE html>
<html>
<head>
<title>Register New User</title>
<style>
	#title{
		text-align: center;
	}
	#submit{
		width: 250px;
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
	<h1 id = title>Create New User</h1>
	<form method="post">
		<div class=container>
			<b>Username:</b> <input type = text name=usr></input></br>
			<b>Password:</b> <input type = password name=pwd></input>
		</div>
		<div class=container>
			<input type="submit" name ="submit" value = "Register"></input></br></br>
			<input type = "button" id = "home" value = "Return To Login"></input></br></br>
		</div>
	</form>
<script>
	document.getElementById("home").onclick = function () {
		location.href = "index.php";
    };
</script>
</body>
</html>
<?php
	if(isset($_POST['submit'])){
		$user = $_POST['usr'];
		$pass = $_POST{'pwd'};
		$error='';
		//if username or password fields are empty, print error
		if (empty($user) || empty($pass)){
			$error = 'Username or Password field is empty';
			echo "<div id=out>$error</div>";
		}
		else{
			//connect to database
			$conn = pg_connect("") or die('Could not connect: ' . pg_last_error());
			//check if username exists in database
			$result = pg_prepare($conn,"Check", "SELECT * FROM users.authentication WHERE username = $1");
			$result = pg_execute($conn,"Check",array($user));
			$rows = pg_num_rows($result);
			//if username exists, print error
			if ($rows == 1) {
				$error='Username Is Already Taken!';
				echo "<div id=out>$error</div>";
			}
			else{
				//generate random number
				$num = rand();
				//generate salt from random int
				$salt = sha1($num);
				//generate password hash
				$pwh = sha1($pass);
				$ph = sha1($pwh+$salt);
				//get current date and time
				$date = date('Y/m/d H:i:s');
				//create user info and authentication entry in database
				$result = pg_prepare($conn,"Create_User_Info","INSERT INTO users.user_info VALUES($1,$2,'(No Description)')");
				$result = pg_execute($conn,"Create_User_Info",array($user,$date));
				$result = pg_prepare($conn,"Create_User","INSERT INTO users.authentication VALUES($1,$2,$3)");
				$result = pg_execute($conn,"Create_User",array($user,$ph,$salt));
				//get client ip
				$ip = $_SERVER['REMOTE_ADDR'];
				//log the user logging in after user is registered
				$result = pg_prepare($conn,"Log","INSERT INTO users.log (username,ip_address,action) VALUES($1,$2,'Account Login')");
				$result = pg_execute($conn,"Log",array($user,$ip));
				$error='User Created Successfully!';
				echo "<div id=out>$error</div>";
				session_start();
				$_SESSION['login_user']=$user;
				//redirect to profile
				header("location: profile.php");
			}
			pg_free_result($result);
			pg_close($conn);
		}
	}
?>