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
		$redirect = "https://groupi-softwareeng.rhcloud.com";
		header("Location: $redirect");
	}
	if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] ==""){
		$redirect = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		HEADER("Location: $redirect");
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
              <li><a href="https://groupi-softwareeng.rhcloud.com/View/applicantdashboard.html"><span></span>Home</a></li>
			  <li class="active"><a href = "https://groupi-softwareeng.rhcloud.com/View/applicantWants.php"><span></span>Sign Up</a></li>

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
		$gradeArray=$_POST['grades'];
		$dbconn = pg_connect("host=/var/lib/openshift/5527ddbb5973cacee00000e9/postgresql/socket/ dbname=groupi user=adminup8hecl password=evnEWGkla94u") or die("Could not access database: ".pg_last_error());
		
		for ($i=0; $i<count($_SESSION['select']); ++$i)
		{
			$result = pg_prepare($dbconn, "grades$i", "INSERT INTO users.applicantWants VALUES ($1, $2, $3, $4)") or die ("Could not prepare query grades: ".pg_last_error());
			$result = pg_execute($dbconn, "grades$i", array($username, intval($selected[$i]), $gradeArray[$i],"Pending")) or die("Could not perform query grades: ".pg_last_error());
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
	<?php
	if(isset($_POST['submit'])){
		if ($_SESSION['international']==true)
		{
			$redirect = 'https://groupi-softwareeng.rhcloud.com/View/internationalApp.php';
			header("Location: $redirect");
		}
		else 
		{
			$redirect = 'https://groupi-softwareeng.rhcloud.com/View/successful.php';
			header("Location: $redirect");
		}
	}
	?>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="http://babbage.cs.missouri.edu/~skhhdc/cs2830/finalProject/dist/js/bootstrap.min.js"></script>
	</div>
  </body>
</html>
