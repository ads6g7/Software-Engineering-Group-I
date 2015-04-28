<!--
Sign Up Application Form
TA/PLA Application Project
Group I
CS4320
-->

<!DOCTYPE html>
<html lang="en">
  <head>
  <?php
  session_start();
	if (!isset($_SESSION['USERNAME']))
	{
		header("Location: index.php");
	}
	?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <title>TA Application Form</title>

    <!-- Bootstrap core CSS -->
    <link href="https://babbage.cs.missouri.edu/~skhhdc/cs2830/finalProject/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="https://babbage.cs.missouri.edu/~skhhdc/cs2830/finalProject/dist/css/bootstrap-theme.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="theme.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	<!--JS form validation-->
	
	<?php
	session_start();
	$today = date("Y-m-d");
	$date = "2015-05-25";
	
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

  <body role="document">


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
              <li><a href="http://groupi-softwareeng.rhcloud.com/">Home</a></li>
			  <li class="active"><a href="signup.html">Sign Up</a></li>

        </div>
      </div>

    <div class="container theme-showcase" role="main">

      <!-- Main jumbotron for a primary marketing message or call to action -->
      <div class="jumbotron">
	  <h2>TA/PLA Application</h2></br>
		<div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">Directions</h3>
            </div>
            <div class="panel-body">
              Please be sure to fill out all required entities in the form below</br>
            </div>
          </div>

          <h2>Questions:</h2>

  		<form name="appform" action="applicantWants.php" method="post" enctype="multipart/form-data">

    
      Wanted Positions:<br>
	  <?php
	  if (isset($_POST['submit']))
	 {
		$username=$_SESSION['USERNAME'];
		$selected=$_SESSION['select'];
		$gradeArray=htmlspecialchars($_POST['grades']);
		$dbconn = pg_connect("host=/var/lib/openshift/5527ddbb5973cacee00000e9/postgresql/socket/ dbname=groupi user=adminup8hecl password=evnEWGkla94u");
		
		for ($i=0; $i<count($_SESSION['select']); ++$i)
		{
			$result = pg_prepare($dbconn, "grades", "INSERT INTO users.applicantWants VALUES ($1, $2, $3)") or die ("Could not prepare query grades: ".pg_last_error());
			$result = pg_execute($dbconn, "grades", array($username, intval($selected[$i]), $gradeArray[$i])) or die("Could not perform query grades: ".pg_last_error());
		}
	}
		
else{	 
	  $selected=$_SESSION['select'];
	  $i=0;
	  foreach ($selected as $key=>$values)
	{
		
		echo $values;
		echo " <input type='text' name=grades[$i] placeholder='Grade' required><br>";
		++$i;
	}	
	}
	?>
<div>
<br><br>
</body>

<!-- Rough code for entering grades-->
</div>	

      
		<br>
		<br>
  		<input type="submit" name="submit" value="Save and Continue">
  		</form>
  		</br>
		<br>
      </div>

      <div class="well">
        <p><center><small>Group I</small></center></p>
      </div>


    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="http://babbage.cs.missouri.edu/~skhhdc/cs2830/finalProject/dist/js/bootstrap.min.js"></script>
  </body>
</html>
