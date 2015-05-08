<!DOCTYPE html>
<html lang="en">
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
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="adescription" content="">
    <meta name="author" content="">

    <title>Applicant Home</title>

 <!-- Bootstrap core CSS -->
    <link href="https://babbage.cs.missouri.edu/~skhhdc/cs2830/finalProject/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="https://babbage.cs.missouri.edu/~skhhdc/cs2830/finalProject/dist/css/bootstrap-theme.min.css" rel="stylesheet">
</script>
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
            <a class="navbar-brand" href="#">Dashboard</a>
          </div>
		  <div class="collapse navbar-collapse navbar-ex1-collapse">
    <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
              <li class="active"><a href="https://groupi-softwareeng.rhcloud.com/View/applicantdashboard.html"><span ></span> Home</a></li>
			   <li ><a href="https://groupi-softwareeng.rhcloud.com/View/application.php"><span ></span>Apply</a></li>
              <li ><a href="https://groupi-softwareeng.rhcloud.com/Controller/logout.php"><span ></span>Logout</a></li>
            </div>
        </div>
		<div class="container theme-showcase" role="main">

      <!-- Main jumbotron for a primary marketing message or call to action -->
      <div class="jumbotron">
	  		<div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">Welcome Back!</h3>
            </div>
            <div class="panel-body">
              From this page you can check your application status, apply, etc.</br>
            </div>
          </div>
		  <br>
<?php 
$username=$_SESSION['USERNAME'];
//include("secure/database.php");
//$conn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect: '.pg_last_error());
$conn = pg_connect("host=/var/lib/openshift/5527ddbb5973cacee00000e9/postgresql/socket/ dbname=groupi user=adminup8hecl password=evnEWGkla94u") or die('Could not connect to database: '.pg_last_erro());
$result=pg_prepare($conn, "update", "SELECT status from users.applicantWants WHERE username=$1") or die('Could not prepare update: '.pg_last_error());
$result=pg_execute($conn, "update", array($username)) or die('Could not execute update: '.pg_last_error());
$line = pg_fetch_array($result, null, PGSQL_ASSOC);
$row = pg_num_rows($result);
if($row == 0){
	$status = 'Pending';
}else{
	$status=$line[status];
}
echo "<button class=\"btn btn-md btn-success center btn-block\" type=\"submit\" onclick=\"alert('Your status is $status')\">Check Status</button>";
?>
</div>
</nav>


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>

  </body>
</html>