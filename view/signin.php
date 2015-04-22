
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
            <a class="navbar-brand">Sign In</a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
          <!--    <li><a href="http://groupi-softwareeng.rhcloud.com/applicantdashboard.html">Home</a></li>
			  <li class="active"><a href="http://groupi-softwareeng.rhcloud.com/applicantdashboard.html#">Sign Up</a></li> -->

        </div>
      </div>
 </div>   

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
			    	<form method= "POST" action="http://groupi-softwareeng.rhcloud.com/applicantdashboard.html" accept-charset="UTF-8" role="form">
                    <fieldset>
			    	  	<div class="form-group">
			    		    <input class="form-control" placeholder="User" name="username" type="text">
			    		</div>
			    		<div class="form-group">
			    			<input class="form-control" placeholder="Password" name="password" type="password" value="">
			    		</div>
			    		<input class="btn btn-lg btn-success btn-block" type="submit" value="Login"><br>
						<div>
						 Don't have an account?  <a href="#">Register Here</a>
						</div>
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
<?php
SESSION_START();
$conn = pg_connect("host=/var/lib/openshift/5527ddbb5973cacee00000e9/postgresql/socket/ dbname=groupi user=adminup8hecl password=evnEWGkla94u") or die('Could not connect to DB ' . pg_last_error());
/*	
$_SESSION['loggedin'];
if(isset($_POST['submit']=="Login"))
	{
		#get username and password
		$un = $_POST['username'];
		$pw = $_POST['password'];
		
		#if input is valid
		#if(!$un || !$pw)
		#	die('<br/>Invalid Data ');
			
		#protect from SQL injection attack
		$q = 'SELECT * FROM users.authentication
				WHERE username = $1';
		#prepare
		$result = pg_prepare($conn, 'query', $q);
		
		#check for error
		if(!$result)
			die('<br/>Error pg_prepare');
			
		#execute
		$result = pg_execute($conn, 'query', array($un));
		
		#check for error
		if(!$result)
			die('<br/>Error pg_execute');
			
		$info = pg_fetch_assoc($result);		
		if($info == NULL)
			die('<br/>Incorrect username/password');
		
		#salt and hash
		$salty = trim($info['salt']);
		$pwHash = sha1($salty.$pw);
		
	if($pwHash == $info['password_hash'])
		{	
			$_SESSION['username'] = $un;
			$_SESSION['loggedin'] = true;
			header('location: http://groupi-softwareeng.rhcloud.com/applicantdashboard.html');
		}
		else
			die('<br/>Incorrect username/password');
	}
#	$today = date("Y-m-d");
#	$date = "2015-04-25";
#	if (strtotime($date) < strtotime($today)) {
#		echo "<div class=\"container\">
#			<div class=\"row\">
#			<div class=\"col-md-4 col-md-offset-4\">
 #   		<div class=\"panel panel-default\">
	#	  	<div class=\"panel-heading\">
	#	   	<div class=\"alert alert-danger\" role=\"alert\">
	#		<span aria-hidden=\"true\"></span>
     #       <span class=\"sr-only\"> Error:</span>✘ Time Window Closed</div>";
		#	exit;*/
/*Test info is benTest--joker123*/
	
?>	
