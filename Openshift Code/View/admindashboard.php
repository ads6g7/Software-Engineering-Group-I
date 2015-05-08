<!DOCTYPE html>
<html lang="en">
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
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Admin Home</title>

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
<nav class="navbar navbar-default">
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
              <li class="active"><a href="https://groupi-softwareeng.rhcloud.com/View/admindashboard.php">Home</a></li>
              <li><a href="https://groupi-softwareeng.rhcloud.com/View/pendingapps.php">Pending Apps</a></li>
			  <li><a href = "https://groupi-softwareeng.rhcloud.com/Controller/profregistration.php">Register Teacher</a></li>
			  <li><a href="https://groupi-softwareeng.rhcloud.com/Controller/editTimewindow.php"><span></span>Timewindow</a></li>
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
              From this you can view pending apps using the Pending App tab, add teachers using the Register Teacher tab</br>
            </div>
          </div>
		  <br>
  <div class="col-lg-12">
    <div class="input-group">
	<!--
	  <center>
      <input type="text" class="form-control" placeholder="Search Applying Student's Name">
      <span class="input-group-btn">
        <button class="btn btn-default" type="button">Search</button>
      </span>
	  </center>-->
    </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->
  <br><br>
  
  <div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading"><center>Courses Needing TA/PLA</center></div>
  <?php
	$dbconn = pg_connect("host=/var/lib/openshift/5527ddbb5973cacee00000e9/postgresql/socket/ dbname=groupi user=adminup8hecl password=evnEWGkla94u")
		or die("Could not connect to the database: ".pg_last_error());
	$query = "select department, courseNum, description from users.courses where TA is NULL group by courseNum order by courseNum asc";
	$result = pg_prepare($dbconn, "emptyCourses", $query);
	$result = pg_execute($dbconn, "emptyCourses", array());
	$columns = pg_num_fields($result);
	
	echo "<table class=\"table\">\n";
		echo "<thead>\n";
			echo "<tr> \n";
				echo "<th> # </th>\n";
				for($i=0;$i<$columns;$i++){
					echo "<th>".pg_field_name($result, $i)."</th>\n";
				}
			echo "</tr>\n";
		echo "</thead>\n";
		echo "<tbody>";
			$num_class = 1;
			while($line=pg_fetch_array($result, null, PGSQL_ASSOC)){
				echo "<tr>\n";
				echo "<td>$num_class</td>\n";
				$num_class++;
				foreach($line as $col_value){
					echo "<td>$col_value</td>\n";
				}
				echo "</tr>\n";
			}
		echo "</tbody>";
	echo "</table>";
  ?>
</div>
</div><!-- /.row -->
</div>
</nav>
  </body>
</html>
