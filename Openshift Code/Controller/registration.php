<!--
	GroupI
	Software Engineering
	4/13/15
	Registration page
-->
<?php
	if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS']== ""){
		$redirect = "https://".$_SERVER['HTTP_HOST']. $_SERVER['REQUEST_URI'];
		header("Location: $redirect");
	}
?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
   <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
	
	<title> Registration </title>

	<!-- Bootstrap core CSS -->
    <link href="https://babbage.cs.missouri.edu/~skhhdc/cs2830/finalProject/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="https://babbage.cs.missouri.edu/~skhhdc/cs2830/finalProject/dist/css/bootstrap-theme.min.css" rel="stylesheet">
<style>
.panel{
  max-width: 330px;
  margin: 0 auto;
  }
.btn-block{
  max-width: 110px;
  text-align: center;
  margin: 0 auto;
  }
.container{
	text-align:center;
	}
.jumbotron{
	text-align:center;
	}
</style>

 <!--Form Validation-->
    <link href="http://fonts.googleapis.com/css?family=Andada" rel="stylesheet" type="text/css">
    <link href="styles/main.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
    <script type="text/javascript" src="https://rickharrison.github.io/validate.js/validate.min.js"></script>
</head>
<body>
 <div class="navbar-wrapper navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand">Registration</a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
    	      <!--<li ><a href="https://groupi-softwareeng.rhcloud.com/logout.php"><span ></span>Logout</a></li>-->
        </div>
      </div>
      
		<div class="container theme-showcase" role="main">

      <!--  Main jumbotron for a primary marketing message or call to action -->
		<div class="jumbotron">
	  		<div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">Create New User</> 
            </div>
            <div class="panel-body">
              From here you can register a new user by filling in the required fields below.<br/>
			  <br/>Password must be 8 characters long.
            </div>
          </div>
		  <br> 
		

			<form method = 'POST' action = "<?= $_SERVER['PHP_SELF']?>">
			Username: <input type = 'text' id='username' placeholder='Pawprint' name = 'username' /><br />
			First Name: <input type = 'text' id='fname' placeholder='First Name' name = 'fname' /><br />
			Last Name: <input type = 'text' id='lname' placeholder='Last Name' name = 'lname' /><br />
			Mizzou Email Address: <input type ='text' id='email' placeholder='Mizzou Email Address' name = 'email' /><br />
			Phone Number: <input type = 'text' id='phone' placeholder='Phone Number (xxxxxxxxxx)' name = 'phone' /><br />
			Password: <input type = 'password' id='password' placeholder='Password' name = 'password' /><br />
			Confirm Password: <input type = 'password' id='password_confirm' placeholder='Confirm Password' name = 'password_confirm' /><br /><br>
			<input type = 'submit' name = 'submit' value = 'Register' />
			</form>
			<br/><br/><br/><a href = "https://groupi-softwareeng.rhcloud.com">Return</a><br />

		</div>

<?php	
	if(isset($_POST['submit'])){
		$username = htmlspecialchars($_POST['username']);
		$fname = htmlspecialchars($_POST['fname']);
		$lname = htmlspecialchars($_POST['lname']);
		$email = htmlspecialchars($_POST['email']);
		$phone = htmlspecialchars($_POST['phone']);
		$password =  htmlspecialchars($_POST['password']);
		$passConfirm = htmlspecialchars($_POST['password_confirm']);
		
		if(empty($username) || empty($fname) || empty($lname) || empty($email) || empty($phone)|| empty($password) || empty($passConfirm)){
			$error = 'Please fill in all text boxes before submitting';
			echo "<div id = out>$error</div>";
		}
		else{
		
			//include("/secure/database.php");
			//$dbconn = pg_connect(HOST. " " .DBNAME. " " .USERNAME. " " .PASSWORD) or die('Unable to connect to database'.pg_last_error());
			$dbconn = pg_connect("host=/var/lib/openshift/5527ddbb5973cacee00000e9/postgresql/socket/ dbname=groupi user=adminup8hecl password=evnEWGkla94u") or die('Unable to connect to database' .pg_last_error());
			
			$result = pg_prepare($dbconn, "Check", "select * from users.user_info where username = $1");
			$result = pg_execute($dbconn, "Check", array($username));
			$found = pg_num_rows($result);
			/*$user_flag = true;
			while($line = pg_fetch_array($result, null, PGSQL_ASSOC)){
				//echo "<br>u = " .$username;
				//echo "<br>u2 = " .$line['username'];
				if($username === $line['username']){
					echo "Error: username already exists.";
					$user_flag = false;
				}
			}*/
			if($found == 1){
				$error = 'Username is already taken.';
				echo "<div id = out>$error</div>";
			}
			else if($password == $passConfirm){
				mt_srand();
				$salt = sha1(mt_rand());
				$passwordHash = sha1($salt . $password);
				//$date = date('Y/m/d H:i:s');
				
				$result = pg_prepare($dbconn, "insertion", "INSERT INTO users.user_info VALUES($1, $2, $3, $4, $5, DEFAULT, DEFAULT, 'No comments')") or die('Invalid user query'. pg_last_error());
				$result = pg_execute($dbconn, "insertion", array($username, $fname, $lname, $email, $phone)) or die('Couldn\'t insert the values into user info: '.pg_last_error());
				
				$result = pg_prepare($dbconn, "auth", 'INSERT INTO users.authentication VALUES($1, $2, $3);') or die('Invalid auth query' . pg_last_error());
				$result = pg_execute($dbconn, "auth", array($username, $passwordHash, $salt)) or die('Couldn\'t insert the values into authenticate: ' . pg_last_error());
				
				//$ip = $_SERVER['REMOTE_ADDR'];
				//pg_prepare($dbconn, "log in", 'INSERT INTO users.log VALUES(DEFAULT, $1, $2, DEFAULT, $3);') or die('Invalid log in query'. pg_last_error());
				//pg_prepare($dbconn, "log in", array($username, $ip_address, 'registration')) or die('Couldn\'t insert the values into log in: ' . pg_last_error());
			
			}
			else if($password != $passConfirm){
				$error = 'Passwords do not match';
				echo "<div id = out>$error</div>";
			}
			else{
				$error = 'Error with submitting this registration form';
				echo "<div id = out>$error</div>";
			}
			
			pg_free_result($result);
			pg_close($dbconn);
		}
	}
?>

<script type="text/javascript">

new FormValidator('appform', [{
    name: 'username',
    display: 'username',
    rules: 'required|exact_length[6]'
}, {
    name: 'fname',
	display: 'first name',
    rules: 'required'
}, {
    name: 'lname',
	display: 'last name',
    rules: 'required'
}, {
    name: 'email',
	display: 'email',
    rules: 'valid_email'
}, {
    name: 'phone',
    display: 'phone',
    rules: 'exact_length[10]'
}, {
    name: 'password',
    rules: 'required'
}, {
    name: 'password_confirm',
    display: 'password confirmation',
    rules: 'required|matches[password]'
}], function(errors, evt) {

    var SELECTOR_ERRORS = $('.error_box'),
        SELECTOR_SUCCESS = $('.success_box');

    if (errors.length > 0) {
        SELECTOR_ERRORS.empty();

        for (var i = 0, errorLength = errors.length; i < errorLength; i++) {
            SELECTOR_ERRORS.append("✘ " + errors[i].message + '<br />');
        }

        SELECTOR_SUCCESS.css({ display: 'none' });
        SELECTOR_ERRORS.fadeIn(200);
    } else {
        SELECTOR_ERRORS.css({ display: 'none' });
        SELECTOR_SUCCESS.fadeIn(200);
		$success = 'User was created successfully';
		echo "<div id = out>$success</div>";
		
		session_start();
		$_SESSION['USERNAME'] = $username;
		$redirect = "https://groupi-softwareeng.rhcloud.com/View/application.php";
		header("Location: $redirect");
    }

    if (evt && evt.preventDefault) {
        evt.preventDefault();
    } else if (event) {
        event.returnValue = false;
    }
});

</script>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-26362841-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

</body>
</html>
