<!DOCTYPE html>

<html lang="en">
<!-- Sign In from template, Ben Woolridge, Shannon Hall -->
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Signin</title>

    <!-- Bootstrap core CSS -->
      <link href="http://babbage.cs.missouri.edu/~skhhdc/cs2830/finalProject/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="http://babbage.cs.missouri.edu/~skhhdc/cs2830/finalProject/dist/css/bootstrap-theme.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">
<!-- Fixed navbar -->
<div class="navbar navbar-default">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand">Application Form</a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li><a href="http://groupi-softwareeng.rhcloud.com/applicantdashboard.html">Home</a></li>
			  <li class="active"><a href="http://groupi-softwareeng.rhcloud.com/applicantdashboard.html#">Sign Up</a></li>

        </div>
      </div>
      
<?php
	$conn = pg_connect("host=/var/lib/openshift/5527ddbb5973cacee00000e9/postgresql/socket/ dbname=groupi user=adminup8hecl password=evnEWGkla94u") or die('Could not connect: ' . pg_last_error());
	$today = date("Y-m-d");
	$date = "2015-04-25";
	
	function random()
	{
	 $size = 20;
	 $charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*';
     $randStr = '';
	
	  for($i=0; $i < $size; $i++)
		{
	   	$randStr .= $charset[rand(0, strlen($charset)-1)];
		}
	   return $randStr;
	}
	if($_POST['action']=="Register")
	{
		$usr = $_POST['username'];
		$pwd = $_POST['password'];
		$conf_pass = $_POST['confirm-password'];

		//check if passwords are same
		if($pwd != $conf_pass)
			die ('Passwords do not match');
		if($usr == NULL || $pwd == NULL)
			die('All fields required');
	
		//hash and salt password
		$salt = random();
		$pwSalt = $salt.$pwd;
		$hash = sha1($pwSalt);

		//insert into authentication table
		$q2 = 'INSERT INTO users.authentication (username, password_hash, salt)
			VALUES ($usr, $hash, $salt)';
		
		//prepare
		$result2 = pg_prepare($conn, 'auth', $q2);
		
		//check for error
		if(!$result2)
			die('Error pg_prepare:'.pg_last_error());
		
		//execute
		$result2 = pg_execute($conn, 'auth', array($usr, $hash, $salt));
		
		//check for error
		if(!$result2)
			die('Error pg_execute:'.pg_last_error());

		
		//set session vars
		$_SESSION['user'] = $usr;
		$_SESSION['loggedin'] = true;
		
		//go to home page
	
	}
	if($_SESSION['loggedin'])
		header('location: http://groupi-softwareeng.rhcloud.com/applicantdashboard.html');
  
  }
	
	if (strtotime($date) < strtotime($today)) {
		echo "<div class=\"container\">
			<div class=\"row\">
			<div class=\"col-md-4 col-md-offset-4\">
    		<div class=\"panel panel-default\">
		  	<div class=\"panel-heading\">
		   	<div class=\"alert alert-danger\" role=\"alert\">
			<span aria-hidden=\"true\"></span>
            <span class=\"sr-only\"> Error:</span>✘ Time Window Closed</div>";
			exit;
	}
	
	?>

  </head>

  <body>

    <div class="container">
    <div class="row">
		<div class="col-md-4 col-md-offset-4">
    		<div class="panel panel-default">
			  	<div class="panel-heading">
			    	<h3 class="panel-title">Please sign in</h3>
			 	</div>
			  	<div class="panel-body">
			    	<form method= "POST" accept-charset="UTF-8" role="form">
                    <fieldset>
			    	  	<div class="form-group">
			    		    <input class="form-control" placeholder="User" name="user" type="text">
			    		</div>
			    		<div class="form-group">
			    			<input class="form-control" placeholder="Password" name="password" type="password" value="">
			    		</div>
			    		<input class="btn btn-lg btn-success btn-block" type="submit" value="Login"><br>
			    	
						<div class="form-group">
					
			    		    <input class="form-control" placeholder="User" name="user" type="text">
			    		</div>
			    		<div class="form-group">
			    			<input class="form-control" placeholder="Password" name="password" type="password" value="">
			    		</div>
			    		<div class="form-group">
			    			<input class="form-control" placeholder="Re-Password" name="password" type="password" value="">
			    		</div>
			    		<input class="btn btn-lg btn-info btn-block" type="submit" value="Register">
			    	</fieldset>
			      	</form>
			    </div>
			</div>
		</div>
	</div>
</div>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
