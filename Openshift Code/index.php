<!DOCTYPE html>
<html lang="en">
  <head>
	<?php
		if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == ""){
			$redirect = "https://".$_SERVER['HTTP_HOST']. $_SERVER['REQUEST_URI'];
			header("Location: $redirect");
		}
  
		session_start();
		if(isset($_SESSION['USERNAME']))
		{
			$username=htmlspecialchars($_SESSION['USERNAME']);
			$dbconn = pg_connect("host=/var/lib/openshift/5527ddbb5973cacee00000e9/postgresql/socket/ dbname=groupi user=adminup8hecl password=evnEWGkla94u") or die('Unable to connect to database' .pg_last_error());
			
			$result = pg_prepare($dbconn, "Check", "select * from users.professors where username = $1");
			$result = pg_execute($dbconn, "Check", array($username));
			$rows=pg_num_rows($result);
			
			if ($rows==1)
			{
				$redirect = "https://groupi-softwareeng.rhcloud.com/View/teacherdashboard.php";
				header("Location: $redirect");
			}
			
			else if (strcmp($username, "admin")==0)
			{
				$redirect = "https://groupi-softwareeng.rhcloud.com/View/admindashboard.php";
				header("Location: $redirect");
			}
			
			else
			{
				$redirect = "https://groupi-softwareeng.rhcloud.com/View/applicantdashboard.php";
				header("Location: $redirect");
			}
		}
	?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Signin</title>

    <!-- Bootstrap core CSS -->
      <link href="https://babbage.cs.missouri.edu/~skhhdc/cs2830/finalProject/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="https://babbage.cs.missouri.edu/~skhhdc/cs2830/finalProject/dist/css/bootstrap-theme.min.css" rel="stylesheet">

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
			    	<form method= "POST" action="https://groupi-softwareeng.rhcloud.com/Controller/loginTest.php" accept-charset="UTF-8" role="form">
                        <input type="hidden" name="action" value="do_login">
                    <fieldset>
						<?php
							session_start();
							if($_SESSION['INVALID_LOGIN'] == 'notValid'){
								echo "Error, not valid input information <br/>";
							}
						?>
			    	  	<div class="form-group">
			    		    <input class="form-control" placeholder="User" name="username" type="text">
			    		</div>
			    		<div class="form-group">
			    			<input class="form-control" placeholder="Password" name="password" type="password" value="">
			    		</div>
			    		<input class="btn btn-lg btn-success btn-block" type="submit" value="Login"><br>
						<div>
						 Don't have a student account?  <a href="https://groupi-softwareeng.rhcloud.com/Controller/registration.php">Register Here</a><br>
						 <!--Need to create a teacher account?  <a href="https://groupi-softwareeng.rhcloud.com/profregistration.php">Register Here</a>
						 -->
			    	</fieldset>
			      	</form>
			    </div>
			</div>
		</div>
	</div>
</div>

<center><a href="https://sites.google.com/site/swegroupidevelopment/user-documentation">User Documentation</a></center><br>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>