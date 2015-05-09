<!--
	GroupI 
	Software Engineering
	4/15/15
	International Application page
-->

<?php 
	session_start();
 	if(!isset($_SESSION['USERNAME'])){
		$redirect = "https://groupi-softwareeng.rhcloud.com";
		header("Location: $redirect");
	}
	else{
		$user = $_SESSION['USERNAME'];
	}
	
	if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] ==""){
		$redirect = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		header("Location: $redirect");
	}
	
	$dbconn = pg_connect("host=/var/lib/openshift/5527ddbb5973cacee00000e9/postgresql/socket/ dbname=groupi user=adminup8hecl password=evnEWGkla94u") or die('Unable to connect to database' .pg_last_error());

	$result=pg_query("SELECT * FROM users.timewindow") or die('Unable to execute' .pg_last_error());
	$line = pg_fetch_array($result, null, PGSQL_ASSOC);
	$studentStart = $line['userdatestart'];
	$studentEnd = $line['userdateend'];
	$teacherStart = $line['teacherdatestart'];
	$teacherEnd = $line['teacherdateend'];

	$username=$_SESSION['USERNAME'];
	$today = date("Y-m-d");

	$result = pg_prepare($dbconn, "Check", "select * from users.professors where username = $1");
	$result = pg_execute($dbconn, "Check", array($username));
	$rows=pg_num_rows($result);
		
	if (strtotime($studentStart) > strtotime($today) || strtotime($studentEnd) < strtotime($today) && $rows!=1)
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

	if(isset($_POST['submit'])){
		$speak = htmlspecialchars($_POST['speak']);
		$speakdate = htmlspecialchars($_POST['examdate']);
		$speakscore = htmlspecialchars($_POST['examscore']);
		$onita = htmlspecialchars($_POST['onita']);
		
		$dbconn = pg_connect("host=/var/lib/openshift/5527ddbb5973cacee00000e9/postgresql/socket/ dbname=groupi user=adminup8hecl password=evnEWGkla94u") or die('Unable to connect to database' .pg_last_error());

		$query = 'insert into users.internationalapp values($1, $2, $3, $4, $5)';
		$result = pg_prepare($dbconn, "insertion", $query) or die('Couldn\'t prepare the insertion statement'.pg_last_error());
		$result = pg_execute($dbconn, "insertion", array($user, $speak, $speakscore, $speakdate, $onita))
					or die ('Couldn\'t insert the data into international table: '. pg_last_error());
		 
		$redirect = "https://groupi-softwareeng.rhcloud.com/View/successful.php"; 
		header("Location: $redirect");
	}
?>

<html lang="en">
<head>
	<title>International Information</title>
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
  max-width: 570px;
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
<!--Form Validation-->
	<script language="JavaScript" src="https://babbage.cs.missouri.edu/~skhhdc/cs2830/finalProject/dist/js/gen_validatorv4.js" type="text/javascript" xml:space="preserve"></script>
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
              <li><a href="https://groupi-softwareeng.rhcloud.com/View/applicantdashboard.html"><span ></span> Home</a></li>
			   <li class="active"><a href = "https://groupi-softwareeng.rhcloud.com/View/internationalApp.php"<span ></span>Apply</a></li>
              <li ><a href="https://groupi-softwareeng.rhcloud.com/Controller/logout.php"><span ></span>Logout</a></li>
               
            </div>
        </div>
		<div class="container theme-showcase" role="main">

      <!-- Main jumbotron for a primary marketing message or call to action -->
      <div class="jumbotron">
	  		<div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">International Application Information</h3>
            </div>
            <div class="panel-body">
              <form name= 'internationalform' method = 'POST' action = "<?= $_SERVER['PHP_SELF']?>">
                Prior to becoming a TA, any ITA (International Teaching Assistant) who received their primary and
                secondary education in a country where English is not the principal language are required by law to
                be assessed for English proficiency (SPEAK test). <br><br>If you do not register for and satisfy applicable 
                language assessment requirements, you will not be eligible to accept a TA appointment.
                Arrangements for language assessments must be made before the end of the semester prior to
                accepting a TA position.
            </div>
            </div>
            <h4>Have you met this requirement?</h4>
            <input type = "radio" name = "speak" value = "true" required/>Requirement met
            <input type = "radio" name = "speak" value = "false"/>Will attend in August/January <br/><br/>
            Date of SPEAK exam: 
            <input type = 'text' placeholder = '(MM-DD-YYYY)' name = 'examdate'/> <br/><br/>
            Score of last SPEAK/OPT Exam (if applicable): 
            <input type = 'number' placeholder = 'Exam Score' min="0" max="100" name = 'examscore'/> <br/><br>
            ONITA, is a requirement for all international TAs and PLAs who have not previously attended this
            orientation. You cannot have a TA/PLA appointment until this requirement has been met. (You do not
            need to attend more than once.) Have you met thes requirement? 
            <input type = "radio" name = "onita" value = "true" required/>Requirement met
            <input type = "radio" name = "onita" value = "false"/>Will attend in August/January <br/><br/>
            <input type = 'submit' name = 'submit' value = 'Submit form'/><br/><br/>

<br/><a href = "https://groupi-softwareeng.rhcloud.com/View/applicantWants.php">Back to Course Selection</a><br/>
</form>

</div>
</nav>

</html>

