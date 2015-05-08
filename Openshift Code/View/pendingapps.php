
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
    <title>Applicant Home</title>

 <!-- Bootstrap core CSS -->
    <link href="https://babbage.cs.missouri.edu/~skhhdc/cs2830/finalProject/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="https://babbage.cs.missouri.edu/~skhhdc/cs2830/finalProject/dist/css/bootstrap-theme.min.css" rel="stylesheet">

<script>
function clickAction(form, save_action, pk, action)
{
  document.forms[form].elements['save_action'].value = save_action;
  document.forms[form].elements['pk'].value = pk;
  document.forms[form].elements['action'].value = action;
  document.getElementById(form).submit();
}
</script>
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
              <li class = "active"><a href="https://groupi-softwareeng.rhcloud.com/View/pendingapps.php">Pending Apps</a></li>
			  <li><a href = "https://groupi-softwareeng.rhcloud.com/Controller/profregistration.php">Register Teacher</a></li>
			  <li><a href="https://groupi-softwareeng.rhcloud.com/Controller/editTimewindow.php"><span></span>Timewindow</a></li>
	      <li ><a href="https://groupi-softwareeng.rhcloud.com/Controller/logout.php"><span ></span>Logout</a></li>
        </div>
      </div>

		<div class="container theme-showcase" role="main">

      <!-- Main jumbotron for a primary marketing message or call to action -->
      <div class="jumbotron">


  <div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">Pending Applications</div>
  <?php
	$dbconn = pg_connect("host=/var/lib/openshift/5527ddbb5973cacee00000e9/postgresql/socket/ dbname=groupi user=adminup8hecl password=evnEWGkla94u") or die('Could not connect to database: '.pg_last_error());
	$query = 'select username as pawprint, fname as first_name, lname as Last_name, courseNum as Desired, grade, status, rating as rank, comments from users.user_info inner join users.applicantWants using(username) where status = $1 order by courseNum asc';
	$result = pg_prepare($dbconn, "getPending", $query) or die("could not prepare getPending statement: ".pg_last_error());
	$result = pg_execute($dbconn, "getPending", array('Pending')) or die("could not execute get pending statement: ".pg_last_error());
	$columns = pg_num_fields($result);
	
	echo "<form id=\"action_form\" method=\"POST\" action=\"https://groupi-softwareeng.rhcloud.com/Controller/exec.php\">";
	echo "\t<input type=\"hidden\" name=\"save_action\" />\n";
	echo "\t<input type=\"hidden\" name=\"pk\" />\n";
	echo "\t<input type=\"hidden\" name=\"action\" />\n";
	echo "</form>";

	echo "<table class=\"table\">";
	echo "<thead>";
	echo "<tr>\n";
	echo "<th><center> # </center></th>\n";
	echo "<th><center> Actions </center></th>\n";
	
	for($i=0;$i<$columns;$i++){
		echo"<th><center>".pg_field_name($result, $i)."</center></th>\n";
	}
	echo "</tr>\n";
	echo "</thead>\n";
	echo "<tbody>\n";
	$app_num = 1;
	while($line = pg_fetch_array($result, null, PGSQL_ASSOC)){
		echo "\t<tr>\n";
		echo "<td> $app_num </td>";
		$app_num++;
		echo "<td><input type=\"button\" value=\"Assign\" onclick=\"clickAction('action_form','assign','".$line['pawprint']."', 'assign')\" />";
		echo "<input type=\"button\" value=\"Edit\" onclick=\"clickAction('action_form','edit','".$line['pawprint']."','edit')\" />";
		echo "<input type=\"button\" value=\"Delete User\" onclick=\"clickAction('action_form','remove','".$line['pawprint']."','remove')\" /></td>";
		
		foreach($line as $col_value){
			echo "\t\t<td>$col_value</td>\n";
		}
		
		echo "\t</tr>\n";
	}
	echo "</table>\n";
  ?>
</div>

</div><!-- /.row -->


</div>
</nav>

  </body>
</html>
