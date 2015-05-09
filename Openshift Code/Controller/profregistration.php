<!--
	GroupI
	Software Engineering
	4/13/15
	Registration page
-->
<?php
	session_start();
	if (!isset($_SESSION['USERNAME']) || !($_SESSION['USERNAME']==='admin'))
	{
		$redirect = "https://groupi-softwareeng.rhcloud.com";
		header("Location: $redirect");
	}
	
	if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == ""){
		$redirect = "https://".$_SERVER['HTTP_HOST']. $_SERVER['REQUEST_URI'];
	}
?>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
	
	<title>Teacher Registration</title>
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
		<script language="JavaScript" src="https://babbage.cs.missouri.edu/~skhhdc/cs2830/finalProject/dist/js/gen_validatorv4.js" type="text/javascript" xml:space="preserve"></script>
</head>
<body><nav class="navbar-wrapper navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand">Dashboard</a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li ><a href="https://groupi-softwareeng.rhcloud.com/View/admindashboard.php">Home</a></li>
              <li><a href="https://groupi-softwareeng.rhcloud.com/View/pendingapps.php">Pending Apps</a></li>
			  <li ><a href="https://groupi-softwareeng.rhcloud.com/View/assignedapps.php">Assigned Apps</a></li>
			  <li ><a href="https://groupi-softwareeng.rhcloud.com/View/deniedapps.php">Denied Apps</a></li>
			  <li class="active"><a href = "https://groupi-softwareeng.rhcloud.com/Controller/profregistration.php">Register Teacher</a></li>
			  <li><a href="https://groupi-softwareeng.rhcloud.com/Controller/editTimewindow.php"><span></span>Timewindow</a></li>
			  <li ><a href="https://groupi-softwareeng.rhcloud.com/Controller/logout.php"><span ></span>Logout</a></li>
        </div>
      </div>
      
		<div class="container theme-showcase" role="main">

      <!--  Main jumbotron for a primary marketing message or call to action -->
		<div class="jumbotron">
	  		<div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">Create New Instructor</> 
            </div>
            <div class="panel-body">
              From here you can register a new instructor by filling in the required fields below.<br/>
			  <br/>Password must be 8 characters long.
            </div>
          </div>
		  <br> 
			<form name="appform" method = 'POST' action = "<?= $_SERVER['PHP_SELF']?>">
			Username: <input type = text placeholder = 'Pawprint' name = 'username' /><br />
			First Name: <input type = 'text' placeholder = 'First Name' name = 'fname' /><br />
			Last Name: <input type = 'text' placeholder = 'Last Name' name = 'lname' /><br />
			Mizzou Email Address: <input type ='text' placeholder='Email Address' name = 'email' /><br />
			Phone Number: <input type = 'text' placeholder='Phone Number' name = 'phone' /><br />
			Course Teaching: <input type = 'text' placeholder='Course Number(i.e. 1050)' name = 'courseid' /><br/>
			Password: <input type = 'password' placeholder = 'Password' name = 'password' /><br />
			Confirm Password: <input type = 'password' placeholder = 'Confirm Password' name = 'password_confirm' /><br />
			<input type = 'submit' name = 'submit' value = 'Register' />
			</form>
			<a href = "https://groupi-softwareeng.rhcloud.com/View/admindashboard.php">Return</a><br />
		</div>

<?php	
	if(isset($_POST['submit'])){
		$username = htmlspecialchars($_POST['username']);
		$fname = htmlspecialchars($_POST['fname']);
		$lname = htmlspecialchars($_POST['lname']);
		$email = htmlspecialchars($_POST['email']);
		$phone = htmlspecialchars($_POST['phone']);
		$courseid = htmlspecialchars($_POST['courseid']);
		$password =  htmlspecialchars($_POST['password']);
		$passConfirm = htmlspecialchars($_POST['password_confirm']);
		
		if(empty($courseid) || empty($username) || empty($fname) || empty($lname) || empty($email) || empty($phone)|| empty($password) || empty($passConfirm)){
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
				
				$instructor = $fname." ".$lname;
				$result = pg_prepare($dbconn, "prof", 'INSERT INTO users.professors VALUES($1, $2)');
				$result = pg_execute($dbconn, "prof", array($username,$instructor));
				
				$result = pg_prepare($dbconn, "teaches", 'INSERT INTO users.teaches VALUES($1,$2)');
				$result = pg_execute($dbconn, "teaches", array($username,$courseid));
								
				$success = 'User was created successfully';
				echo "<div id = out>$success</div>";
				
				//session_start();
				//$_SESSION['USERNAME'] = $username;
				//$redirect = "https://groupi-softwareeng.rhcloud.com/teacherdashboard.php";
				//$redirect = "https://groupi-softwareeng.rhcloud.com/View/admindashboard.php";
				//header("Location: $redirect");
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
<!--Validation -->
<script language="JavaScript" type="text/javascript"
    xml:space="preserve">//<![CDATA[
//You should create the validator only after the definition of the HTML form
  var frmvalidator  = new Validator("appform");
  frmvalidator.addValidation("username","req","Username is required");
  frmvalidator.addValidation("fname","req","First Name is required");
  frmvalidator.addValidation("lname","req","Last Name is required");
  frmvalidator.addValidation("email","email","Must be a valid email");

  frmvalidator.addValidation("phone","req","Phone Number is required");
  frmvalidator.addValidation("phone","num","Phone Number must be numbers");
  
  frmvalidator.addValidation("courseid","req","Course ID is required");
  
  frmvalidator.addValidation("password","req","Password is required");
  frmvalidator.addValidation("password","neelmnt=username","The password should not be same as username");
  frmvalidator.addValidation("password_confirm","confpassword","eqelmnt=password","Passwords must match");
  
//]]></script>
</body>
</html>
