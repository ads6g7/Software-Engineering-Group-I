<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Timewindow</title>

 <!-- Bootstrap core CSS -->
    <link href="https://babbage.cs.missouri.edu/~skhhdc/cs2830/finalProject/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="https://babbage.cs.missouri.edu/~skhhdc/cs2830/finalProject/dist/css/bootstrap-theme.min.css" rel="stylesheet">


<style>
.panel{
  max-width: 1000px;
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
.input{
	padding: 0px 32px;
	float: left;
}
.inputText{
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
              <li><a href="https://groupi-softwareeng.rhcloud.com/View/admindashboard.php">Home</a></li>
              <li ><a href="https://groupi-softwareeng.rhcloud.com/View/pendingapps.php">Pending Apps</a></li>
			  <li ><a href="https://groupi-softwareeng.rhcloud.com/View/assignedapps.php">Assigned Apps</a></li>
			  <li ><a href="https://groupi-softwareeng.rhcloud.com/View/deniedapps.php">Denied Apps</a></li>
			  <li><a href = "https://groupi-softwareeng.rhcloud.com/Controller/profregistration.php">Register Teacher</a></li>
			  <li class = "active"><a href="https://groupi-softwareeng.rhcloud.com/Controller/editTimewindow.php"><span></span>Timewindow</a></li>
	      <li ><a href="https://groupi-softwareeng.rhcloud.com/Controller/logout.php"><span ></span>Logout</a></li>
        </div>
      </div>

		<div class="container theme-showcase" role="main">

      <!-- Main jumbotron for a primary marketing message or call to action -->
      <div class="jumbotron">


  <div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">Edit Time Windows</div>
  <?php
	
	session_start();
	
	if(!isset($_SESSION['USERNAME']))
	{
		header("Location: https://groupi-softwareeng.rhcloud.com/");
	}
	
	if (strcmp($_SESSION['USERNAME'], "admin")!==0)
	{
		header("Location: https://groupi-softwareeng.rhcloud.com/");
	}
	
	if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS']== "")
	{
		$redirect = "https://".$_SERVER['HTTP_HOST']. $_SERVER['REQUEST_URI'];
		header("Location: $redirect");
	}

	//include("secure/database.php");
	//$conn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect: '.pg_last_error());
    $conn = pg_connect("host=/var/lib/openshift/5527ddbb5973cacee00000e9/postgresql/socket/ dbname=groupi user=adminup8hecl password=evnEWGkla94u") or die('Could not connect to database: '.pg_last_erro());
	
if (isset($_POST['submit'])){
	$userdateStart=htmlspecialchars($_POST['userdatestart']);
	$userdateEnd=htmlspecialchars($_POST['userdateend']);
	$teacherdateStart=htmlspecialchars($_POST['teacherdatestart']);
	$teacherdateEnd=htmlspecialchars($_POST['teacherdateend']);
	$result=pg_query('SELECT * FROM users.timewindow') or die('Could not connect: '.pg_last_error());
	$rows=pg_num_rows($result);
	if ($rows!=0)
	{
		pg_prepare($conn, "update", "UPDATE users.timewindow set userdateStart=$1, userdateEnd=$2, teacherdateStart=$3, teacherdateEnd=$4") or die('Could not prepare update: '.pg_last_error());
		pg_execute($conn, "update", array($userdateStart, $userdateEnd, $teacherdateStart, $teacherdateEnd)) or die('Could not execute update: '.pg_last_error());
	}
	else
	{
		pg_prepare($conn, "insert", "INSERT into users.timewindow VALUES ($1, $2, $3, $4)") or die('Could not prepare update: '.pg_last_error());
		pg_execute($conn, "insert", array($userdateStart, $userdateEnd, $teacherdateStart, $teacherdateEnd)) or die('Could not execute update: '.pg_last_error());
	}
}

	$result=pg_query('SELECT * FROM users.timewindow') or die('Could not connect: '.pg_last_error());
	$columns = pg_num_fields($result);
	$rows = pg_num_rows($result);

	echo "<form id=\"action_form\" method=\"POST\" action=\"editTimewindow.php\">";



	echo "<table class=\"table\">";
	


	echo "\t<th>\n";
	echo "\t<tr>\n";

	$line = pg_fetch_array($result, null, PGSQL_ASSOC);

	for($i=0; $i<$columns; $i++){
		echo "\t\t<td>".pg_field_name($result, $i)."</td>\n";
	}
	
	echo "</tr>";
	echo "</th>";

	echo "\t<tr>\n";
	
	foreach($line as $col_value){
		echo "\t\t<td>$col_value</td>\n";
		//echo "<td><input type=\"button\" value=\"Edit\" onclick=\"clickAction('action_form','$col_value', 'users.user_info','edit')\" /></td>";
	}
		
	echo "\t</tr>\n";

	reset($line);
	echo "</table>\n";
	
	if ($rows == 0)
	{
		echo "<div class='input'><input type='date' name='userdatestart' class='inputDate' required></div>";
		echo "<div class='input'><input type='date' name='userdateend' class='inputDate' required></div>";
		echo "<div class='input'><input type='date' name='teacherdatestart' class='inputDate' required></div>";
		echo "<div class='input'><input type='date' name='teacherdateend' class='inputDate' required></div>";
	}
	
	else
	{
		$i=0;
		foreach($line as $col_value){
			echo "<div class='input'><input type='date' name=".pg_field_name($result, $i)." value='$col_value' placeholder='$col_value' class='inputText'></div>";
			++$i;
			echo "\n";
		}
	}
	echo "<br><br><br><input type='submit' value='submit' name='submit'>";	
	echo "</form>";

 ?>

</div>

</div><!-- /.row -->


</div>
</nav>

  </body>
</html>
