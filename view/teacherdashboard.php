
<!DOCTYPE html>
<html lang="en">
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
        <li class="active"><a href="http://groupi-softwareeng.rhcloud.com/teacherdashboard.html">Home</a></li>
	<li ><a href="https://groupi-softwareeng.rhcloud.com/logout.php"><span ></span>Logout</a></li>
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
            </div>
          </div>
		  <br>
<center>
  <div class="col-lg-6">
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
      <input type="text" class="form-control" placeholder="Search Applications" name="query_string" value="">
	  <input type = 'submit' name = 'submit' value = 'Search' />
      <!--<span class="input-group-btn">
        <button class="btn btn-default" type="button">Search</button>
      </span>-->
    </form>
</center>

  <?php

  //include("../secure/database.php");
	//$dbconn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect: '.pg_last_error());
    //$dbconn = pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=skhhdc user=skhhdc password=VP3RdwLt")
	$dbconn = pg_connect("host=/var/lib/openshift/5527ddbb5973cacee00000e9/postgresql/socket/ dbname=groupi user=adminup8hecl password=evnEWGkla94u")
    //attempt to connect to database
    //or die("Error - could not connect to database: " . pg_last_error());
    //display error if connection is unsuccessful

    $choice = $_POST['searchby'];
    //$inpcode = $_POST['begin'];

    if(isset($_POST['submit'])) {
		$searchby = ($_POST['searchby']);
		$querystring = $_POST['query_string'];
		$query_string=htmlspecialchars($querystring);
		if($searchby == "username"){
			$query = 'select * from users.applications where username ilike $1 order by username asc';
			$result = pg_prepare($dbconn, "find", $query) or die ("Could not prepare query find: ".pg_last_error());
			$query_string=$query_string."%";
		}
		else{
			$query_string=intval($query_string);
			$query = 'select * from users.applicantWants where courseNum=$1 order by courseNum asc';
			$result = pg_prepare($dbconn, "find", $query) or die ("Could not prepare query find: ".pg_last_error());
		}
		$result = pg_execute($dbconn, "find", array($query_string)) or die("Could not perform query find: ".pg_last_error());
		$columns = pg_num_fields($result);
		
		echo "There were <em>".pg_num_rows($result)."</em> rows returned<br/><br/>\n";
		//echo "<form id=\"action_form\" method=\"POST\" action=\"exec.php\">";
		echo "\t<input type=\"hidden\" name=\"pk\"/>\n";
		echo "\t<input type=\"hidden\" name=\"tbl\"/>\n";
		echo "\t<input type=\"hidden\" name=\"action\" />\n";
		echo "</form>";
			
		echo "<table border=\"1\">\n";
		echo"<tr>\n";
		//echo"<th> Actions </th>\n";
			
		for($i=0;$i<$columns;$i++){
			echo "<th>".pg_field_name($result,$i)."</th>\n";
		}
		echo "\t</tr>\n";
			
		while($line = pg_fetch_array($result,null, PGSQL_ASSOC)){
			echo "\t<tr>\n";
			/*
			if($searchby == 'username'){				
				echo "<td><input type=\"button\" value=\"Edit\"  onclick=\"clickAction('action_form', '" .$line['country_code']. ':' .$line['language']. "','" .$searchby. "','edit');\" />";
				echo "<input type=\"button\" value=\"Remove\"  onclick=\"clickAction('action_form', '" .$line['country_code']. ':'. $line['language']. "','" .$searchby. "','remove');\" /> </td>";
			}
			else{
				echo "<td> <input type=\"button\" value=\"Edit\"  onclick=\"clickAction('action_form', '" .reset($line). "','" .$searchby. "','edit')\"/>";
				echo "<input type=\"button\" value=\"Remove\"  onclick=\"clickAction('action_form', '" .reset($line). "', '" .$searchby. "','remove')\"/> </td>";
			}
			*/
			
			foreach($line as $col_value){
				echo "\t\t<td>$col_value</td>\n";
			}
				
			echo "\t</tr>\n";
				
		}
	}
	/*
      switch($choice) {
		  case 1:
		  //username lookup
			$inpcode = $inpcode ."%";
			$outcome = pg_prepare($dbconn, "user_lookup", 'SELECT * FROM users.applications WHERE username = $1');
			//sql for retrieving username code key
			$username = htmlspecialchars($_POST['username']);
			$outcome = pg_execute($dbconn, "user_lookup", array($username));
			 echo "<hr /><br/># of row: " . $temp . " rows." ."<br />";
			//output number of rows
			echo "<br/><table border=\"2\">";
			echo "<tr>";
			echo "<th> studentID</th>" . "\n";
			echo "<th> major</th>";
			echo "<th> gradDate</th>";
			echo "<th> previous</th>";
			echo "<th> cur</th>";
			echo "<th> GPA</th>";
			echo "<th> isGrad</th>";
			echo "<th> degree</th>";
			echo "<th> Advisor</th>";
			echo "<th> isInternational</th>";
			echo "<th> GATO</th>";
			echo "<th> filename</th>";
			echo "<th> pdf</th>";
			echo "</tr>";
			$holder;
			$temp = 0;
			//Output columns

		  while($holder = pg_fetch_all($outcome)) {
		  //fetch all rows from the outcome
			echo "<tr>";
			echo "<td>" . htmlspecialchars($holder['username']) . "</td>";
			echo "<td>" . htmlspecialchars($holder['studentID']) . "</td>";
			echo "<td>" . htmlspecialchars($holder['major']) . "</td>";
			echo "<td>" . htmlspecialchars($holder['gradDate']) . "</td>";
			echo "<td>" . htmlspecialchars($holder['previous']) . "</td>";
			echo "<td>" . htmlspecialchars($holder['cur']) . "</td>";
			echo "<td>" . htmlspecialchars($holder['GPA']) . "</td>";
			echo "<td>" . htmlspecialchars($holder['isGrad']) . "</td>";
			echo "<td>" . htmlspecialchars($holder['degree']) . "</td>";
			echo "<td>" . htmlspecialchars($holder['Advisor']) . "</td>";
			echo "<td>" . htmlspecialchars($holder['isAdvisor']) . "</td>";
			echo "<td>" . htmlspecialchars($holder['GATO']) . "</td>";
			echo "<td>" . htmlspecialchars($holder['filename']) . "</td>";
			echo "<td>" . htmlspecialchars($holder['pdf']) . "</td>";
			echo "</tr>";
			$temp++;
			//move ahead & output extracted info from database
		  }
			echo "</table>";
			break;

		  case 2:
		  //course lookup
			$inpcode = $inpcode ."%";
			$outcome = pg_prepare($dbconn, "city_lookup", 'SELECT * FROM lab4.city WHERE name = $1');
			$outcome = pg_execute($dbconn, "city_lookup", array($inpcode));
			echo "<hr /><br/>There were " . $temp . " rows." ."<br />";
			echo "<br/><table border=\"2\">";
			echo "<tr>";
			echo "<th> studentID</th>" . "\n";
			echo "<th> major</th>";
			echo "<th> gradDate</th>";
			echo "<th> previous</th>";
			echo "<th> cur</th>";
			echo "<th> GPA</th>";
			echo "<th> isGrad</th>";
			echo "<th> degree</th>";
			echo "<th> Advisor</th>";
			echo "<th> isInternational</th>";
			echo "<th> GATO</th>";
			echo "<th> filename</th>";
			echo "<th> pdf</th>";
			echo "</tr>";
			$holder;
			$temp = 0;

		  while($holder = pg_fetch_all($outcome))
		  {
			echo "<tr>";
			echo "<td>" . htmlspecialchars($holder['username']) . "</td>";
			echo "<td>" . htmlspecialchars($holder['studentID']) . "</td>";
			echo "<td>" . htmlspecialchars($holder['major']) . "</td>";
			echo "<td>" . htmlspecialchars($holder['gradDate']) . "</td>";
			echo "<td>" . htmlspecialchars($holder['previous']) . "</td>";
			echo "<td>" . htmlspecialchars($holder['cur']) . "</td>";
			echo "<td>" . htmlspecialchars($holder['GPA']) . "</td>";
			echo "<td>" . htmlspecialchars($holder['isGrad']) . "</td>";
			echo "<td>" . htmlspecialchars($holder['degree']) . "</td>";
			echo "<td>" . htmlspecialchars($holder['Advisor']) . "</td>";
			echo "<td>" . htmlspecialchars($holder['isAdvisor']) . "</td>";
			echo "<td>" . htmlspecialchars($holder['GATO']) . "</td>";
			echo "<td>" . htmlspecialchars($holder['filename']) . "</td>";
			echo "<td>" . htmlspecialchars($holder['pdf']) . "</td>";
			echo "</tr>";
			$temp++;
		  }
			echo "</table>";
			break;
		}*/
  ?>
    </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->
</div><!-- /.row -->


</div>
</nav>

  </body>
</html>
