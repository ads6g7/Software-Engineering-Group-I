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

	<?php
	$today = date("Y-m-d");
	$date = "2015-04-25";
	
	if (strtotime($date) < strtotime($today))
	{
		echo "<div class=\"container\">
    <div class=\"row\">
		<div class=\"col-md-4 col-md-offset-4\">
    		<div class=\"panel panel-default\">
			  	<div class=\"panel-heading\">
			    	<h3 class=\"panel-title\">Time window closed</h3>";
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
			    	<form accept-charset="UTF-8" role="form">
                    <fieldset>
			    	  	<div class="form-group">
			    		    <input class="form-control" placeholder="User" name="user" type="text">
			    		</div>
			    		<div class="form-group">
			    			<input class="form-control" placeholder="Password" name="password" type="password" value="">
			    		</div>
			    		<div class="checkbox">
			    	    	<label>
			    	    		<input name="remember" type="checkbox" value="Remember Me"> Remember Me
			    	    	</label>
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
