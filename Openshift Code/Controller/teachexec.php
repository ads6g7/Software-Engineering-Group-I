
<html>
<head>
<?php
	if(isset($_POST['action'])){
		$save_action = htmlspecialchars($_POST['save_action']);
		$username = htmlspecialchars($_POST['pk']);
		$action = htmlspecialchars($_POST['action']);
	}
	session_start();
	if($action == 'view'){
		$_SESSION['STUDENT'] = $username;
		header("Location: https://groupi-softwareeng.rhcloud.com/Controller/GetPDF.php");
	}
	else if($action == 'comment'){
		echo "<title>Edit Applicant</title>";
	}

	if (!isset($_SESSION['USERNAME']))
	{
		$redirect = "https://groupi-softwareeng.rhcloud.com";
		header("Location: $redirect");
	}
	
	if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == ""){
		$redirect = "https://".$_SERVER['HTTP_HOST']. $_SERVER['REQUEST_URI'];
	}
?>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

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
  </head>

  <body>
<nav class="navbar-wrapper navbar-default navbar-fixed-top" role="navigation">
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
              <li><a href="https://groupi-softwareeng.rhcloud.com/View/teacherdashboard.php">Home</a></li>
        </div>
      </div>
      
		<div class="container theme-showcase" role="main">

      <!-- Main jumbotron for a primary marketing message or call to action -->
      <div class="jumbotron">
  <div class="col-lg-12">
    <div class="input-group">
    </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->
  <br><br>
  <form method="POST" action="<?= $_SERVER['PHP_SELF']?>">
<?php
	$dbconn = pg_connect("host=/var/lib/openshift/5527ddbb5973cacee00000e9/postgresql/socket/ dbname=groupi user=adminup8hecl password=evnEWGkla94u")
		or die("Could not connect to the database: ".pg_last_error());
	if(isset($_POST['action'])){
		if($action == 'comment'){
			/* echo "save = ".$save_action."<br>\n";
			echo "username = ".$username."<br>\n";
			echo "action = ".$action."<br>\n"; */
			echo "<div class=\"panel panel-default\">
				  <!-- Default panel contents -->
				  <div class=\"panel-heading\"><center>Edit TA</center></div>";
				  
			$query = 'select username, fname as First, lname as Last, email, rating, comments from users.user_info where username = $1';
			$result = pg_prepare($dbconn, 'editQuery',$query)or die("Could not prepare editQuery:".pg_last_error());
			$result = pg_execute($dbconn, 'editQuery', array($username)) or die ("could not execute editQuery: ".pg_last_error());
			$num_columns = pg_num_fields($result);
			$selected = pg_fetch_array($result, NULL, PGSQL_NUM);
			
			echo "<input type=\"hidden\" name=\"save_action\" value=\"" . $save_action. "\">";
			echo "<input type=\"hidden\" name=\"pk\" value=\"" . $username. "\">";
			echo "<table class=\"table\">\n";
				for($i=0;$i<$num_columns;$i++){
					if(pg_field_name($result, $i) == 'rating' || pg_field_name($result, $i) == 'comments'){
						echo ("<tr><td><b>" .pg_field_name($result,$i). "</b></td><td><input type=\"text\" name=\"" .pg_field_name($result,$i). "\" value=\"" .$selected[$i]. "\"</td>");
					}
					else{
						echo ("<tr><td>" .pg_field_name($result,$i). "</td><td>" .$selected[$i]. "</td>");
					}			
				}
			echo "</table>\n";
			echo "<input type=\"submit\" name=\"save\" value=\"Save\">";
			echo "<input type=\"button\" name=\"cancel\" value=\"Cancel\" onclick = \"top.location.href = 'https://groupi-softwareeng.rhcloud.com/View/teacherdashboard.php'\">";
			echo "</form>\n";		
		}
	}
	if(isset($_POST['save'])){
		$username = htmlspecialchars($_POST['pk']);
		$save_action = htmlspecialchars($_POST['save_action']);
		if($save_action == 'comment'){
			$rank = htmlspecialchars($_POST['rating']);
			$comment = htmlspecialchars($_POST['comments']);

			
			$query = 'update users.user_info set rating = $1, comments = $2 where username = $3';
			$result = pg_prepare($dbconn, 'editUpdate', $query) or die("could not prepare editUpdate: ".pg_last_error());
			$result = pg_execute($dbconn, 'editUpdate', array($rank, $comment, $username)) or die("could not execute editUpdate statement: ".pg_last_error());
			echo "Update successful!\n";
			echo "<br/>\n";
			echo "<a href = \"https://groupi-softwareeng.rhcloud.com/View/teacherdashboard.php\">Return to Teacher Dashboard</a>";
		}
	}
?>
	