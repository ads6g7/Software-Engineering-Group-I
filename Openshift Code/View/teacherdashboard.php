
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
	
	if (isset($_SESSION['USERNAME']))
	{
		$username=htmlspecialchars($_SESSION['USERNAME']);
		$dbconn = pg_connect("host=/var/lib/openshift/5527ddbb5973cacee00000e9/postgresql/socket/ dbname=groupi user=adminup8hecl password=evnEWGkla94u") or die('Unable to connect to database' .pg_last_error());
		
		$result = pg_prepare($dbconn, "Check", "select * from users.professors where username = $1");
		$result = pg_execute($dbconn, "Check", array($username));
		$rows=pg_num_rows($result);
		
		if ($rows!=1)
		{
			$redirect = "https://groupi-softwareeng.rhcloud.com/View/applicantdashboard.html";
			header("Location: $redirect");
		}
	}

		$conn = pg_connect("host=/var/lib/openshift/5527ddbb5973cacee00000e9/postgresql/socket/ dbname=groupi user=adminup8hecl password=evnEWGkla94u") or die('Unable to connect to database' .pg_last_error());

		$result=pg_query("SELECT * FROM users.timewindow") or die('Unable to execute' .pg_last_error());
		$line = pg_fetch_array($result, null, PGSQL_ASSOC);
		$teacherStart = $line['teacherdatestart'];
		$teacherEnd = $line['teacherdateend'];

		$username=$_SESSION['USERNAME'];
		$today = date("Y-m-d");

		$result = pg_prepare($conn, "Check", "select * from users.professors where username = $1");
		$result = pg_execute($conn, "Check", array($username));
		$rows=pg_num_rows($result);
			
		if (strtotime($teacherStart) > strtotime($today) || strtotime($teacherEnd) < strtotime($today) && $rows==1)
		{
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
  
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Instructor Home</title>

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
  max-width: 330px;
  margin: 0 auto;
  }
.panelOther{
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
<nav class="navbar navbar-default" role="navigation">
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
			<li class="active"><a href="https://groupi-softwareeng.rhcloud.com/View/teacherdashboard.php">Home</a></li>
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
              From this page you can search for submitted applications and decide whether or not to approve them to the Administrator</br>

			  <br>
			  <div class="col-lg-12">
			  <center>
				<div class="input-group">
				  <form method= "POST" action="<?=$_SERVER['PHP_SELF']?>">
					<div id="form">
					  <input type= "radio" name= "searchby" value="username" checked>
					  <label for= "username"> Username </label>
					  <!--Radio button 1 (username) checked by default-->
					  <input type= "radio" name= "searchby" value="course">
					  <label for= "course"> Course </label>
					  <!--HTML radio buttons for selecting what to search for
					  Corresponding values: (1) username (2) course
					  -->
					</div>
				  <input type="text" class="form-control" width="100px" placeholder="Search Applications" name="query_string" value="">
				  <input type = 'submit' name = 'submit' value = 'Search' /><br>
				  </center>
				  <!--<span class="input-group-btn">
					<button class="btn btn-default" type="button">Search</button>
				  </span>-->
				</form>
		  </div>
		  </div>
		</div>
		<br>
		<br>
  <?php

	$dbconn = pg_connect("host=/var/lib/openshift/5527ddbb5973cacee00000e9/postgresql/socket/ dbname=groupi user=adminup8hecl password=evnEWGkla94u")
    //attempt to connect to database
    or die("Error - could not connect to database: " . pg_last_error());
    //display error if connection is unsuccessful

    $choice = $_POST['searchby'];
    //$inpcode = $_POST['begin'];

    if(isset($_POST['submit'])) {
		$searchby = ($_POST['searchby']);
		$querystring = $_POST['query_string'];
		$query_string=htmlspecialchars($querystring);
		if($searchby == "username"){
			$query = 'select username AS pawprint, degree, major, previous, cur AS current, 
						courseNum AS Desired, GPA, rating, comments 
						from users.applications inner join users.applicantWants using(username) inner join users.user_info using(username) where username ilike $1 order by username asc';
			$result = pg_prepare($dbconn, "find", $query) or die ("Could not prepare query find: ".pg_last_error());
			$query_string=$query_string."%";
			echo "<div class=\"panelOther panel-default\">
				  <!-- Default panel contents -->
				  <div class=\"panel-heading\"><center>Applicants</center></div>";
		}
		else{
			$query_string=intval($query_string);
			$query = 'select username AS pawprint, degree, major, previous, cur AS Current,
						courseNum AS Desired, GPA, rating, comments
						from users.applicantWants inner join users.applications using(username) inner join users.user_info using(username) where courseNum=$1 order by courseNum asc';
			$result = pg_prepare($dbconn, "find", $query) or die ("Could not prepare query find: ".pg_last_error());
			echo "<div class=\"panelOther panel-default\">
				  <!-- Default panelOther contents -->
				  <div class=\"panel-heading\"><center>Courses</center></div>";
		}
		$result = pg_execute($dbconn, "find", array($query_string)) or die("Could not perform query find: ".pg_last_error());
		$columns = pg_num_fields($result);
		echo "<br>";
			
		echo "<table class=\"table\">\n";
		echo "<thead>";
		echo"<tr>\n";
		if($searchby == "username"){
			echo"<th><center> Actions </center></th>\n";
		}
			
		for($i=0;$i<$columns;$i++){
			echo "<th><center>".pg_field_name($result,$i)."</center></th>\n";
		}
		echo "\t</tr>\n";
		echo "</thead>\n";
		echo "<tbody>\n";
		echo "	<form id='action_form' method='POST' action=\"https://groupi-softwareeng.rhcloud.com/Controller/teachexec.php\">
				<input type='hidden' name='save_action'>
				<input type='hidden' name='pk'>
				<input type='hidden' name='action'>";
		echo "</form>";
		while($line = pg_fetch_array($result,null, PGSQL_ASSOC)){
			echo "\t<tr>\n";
			$pick = $line['pawprint'];
			echo "<td><input type = \"submit\" value=\"View Resume\" onclick=\"clickAction('action_form', 'view','".$pick."','view')\" >";
			echo "<input type = \"submit\" value=\"Comment\" onclick=\"clickAction('action_form','comment','".$pick."','comment')\" ></td>";

			foreach($line as $col_value){
				echo "\t\t<td>$col_value</td>\n";
			}
			echo "\t</tr>\n";
				
		}
		echo "</table>\n";
	}
  ?>
    </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->
</div><!-- /.row -->


</div>
</nav>

  </body>
</html>
