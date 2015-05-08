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
	if(!isset($_SESSION['USERNAME'])){
		$redirect = "https://groupi-softwareeng.rhcloud.com";
		header("Location: $redirect");
	}
	if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS']== ""){
		$redirect = "https://".$_SERVER['HTTP_HOST']. $_SERVER['REQUEST_URI'];
		header("Location: $redirect");
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

	<!--Form Validation-->
    <link href="http://fonts.googleapis.com/css?family=Andada" rel="stylesheet" type="text/css">
    <link href="styles/main.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
    <script type="text/javascript" src="https://rickharrison.github.io/validate.js/validate.min.js"></script>
	
	<?php
	$conn = pg_connect("host=/var/lib/openshift/5527ddbb5973cacee00000e9/postgresql/socket/ dbname=groupi user=adminup8hecl password=evnEWGkla94u") or die('Unable to connect to database' .pg_last_error());

	$result=pg_query("SELECT * FROM users.timewindow") or die('Unable to execute' .pg_last_error());
	$line = pg_fetch_array($result, null, PGSQL_ASSOC);
	$studentStart = $line['userdatestart'];
	$studentEnd = $line['userdateend'];

	$username=$_SESSION['USERNAME'];
	$today = date("Y-m-d");
		
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
	?>
  </head>

  <body role="document">
<?php
$result = pg_query($dbconn, "select department, courseNum, description from users.courses") or die('Unable to execute courses' .pg_last_error());
$rows=pg_num_rows($result);
$depart=pg_fetch_all_columns($result, 0);
$course=pg_fetch_all_columns($result, 1);
$descrip=pg_fetch_all_columns($result, 2);
?>
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
              <li><a href="https://groupi-softwareeng.rhcloud.com/View/applicantdashboard.php">Home</a></li>
			  <li class="active"><a href="https://groupi-softwareeng.rhcloud.com/View/application.php">Sign Up</a></li>
			  <li><a href="https://groupi-softwareeng.rhcloud.com/Controller/logout.php">Logout</a></li>
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
			  <strong>PLEASE READ BEFORE FILLING OUT</strong><br/><br/>
			  Providing invalid information will result in an immediate disqualification from TA/PLA position.<br/><br/>
              Please be sure to fill out all required entities in the form below.</br>
			  Previous position and current position can take in multiple courses. </br>
			  If multiple courses apply to you, please separate them with a comma, such as: CMP_SC 1040, CMP_SC 1050</br>
            </div>
          </div>
		<?php
			
			$username=htmlspecialchars($_SESSION['USERNAME']);
			$dbconn = pg_connect("host=/var/lib/openshift/5527ddbb5973cacee00000e9/postgresql/socket/ dbname=groupi user=adminup8hecl password=evnEWGkla94u") or die('Unable to connect to database' .pg_last_error());
			$result = pg_prepare($dbconn, "Check", "select * from users.applications where username = $1");
			$result = pg_execute($dbconn, "Check", array($username));
			$rows=pg_num_rows($result);
			
			if ($rows==1)
			{
				echo "You have already submitted an application, please contact the administrator if you need to change anything.";
				exit;
			}
		?>
          <h2>Questions:</h2>
  		<form name="appform" action="https://groupi-softwareeng.rhcloud.com/View/application.php" method="post" enctype="multipart/form-data">
		<div class = "succes_box"></div>
		<div class = "error_box"><br></div>
		
		
    		Student ID:<br>
    		<input type="text" name="id" placeholder="Ex: 12345678" required><br>

			Previous Position(s):<br>
			<input type="text" name="prev" placeholder="Previous Position (see instructions)" required><br>

			Current Position(s):<br>
			<input type="text" name="curr" placeholder="Current Position (see instructions)" required><br><br>

			Wanted Positions:<br>
<div>
<select multiple id="select" name="select[]" required>
<?php
	for($i=0;$i<count($depart); ++$i){
		$whole[$i]=$dpart[$i]." ".$course[$i].": ".$descrip[$i];
		echo "<option value='$course[$i]'>$whole[$i]</option>";
	}
?>
</select>
<br><br>
</body>

</div>	

      GPA:<br>
      <input type="text" name="gpa" placeholder="GPA" required><br>
	  
	  Anticipated Grad. Date:<br>
      <input type="text" name="gradDate" placeholder="Ex: Fall 2016" required><br>

      Advisor:<br>
      <input type="text" name="advisor" placeholder="Advisor's Full Name" required><br>
      Degree Type:<br>
      <input type="text" name="degreetype" placeholder="BS/MS/PhD" required><br>
	  Major:<br>
	  <input type="text" name="major" placeholder="Major" required><br><br>
	  

      Graduate Student:<br>
      <input type="radio" name="gradstudent" value="true">Graduate<br>
      <input type="radio" name="gradstudent" value="false">Undergraduate<br><br>
	            
				<div class="alert alert-warning" role="alert">New TAs, ITAs, and PLAs who have received an appointment, are required to participate in the GATO
		          (Graduate Assistant Teaching Orientation), which is offered just prior to the start of fall and winter terms. (You
		          do not need to attend more than once.) Select if the requirement has been met or if you will attend in Aug./Jan.
				</div>
				
<ul class="list-group">
          <li class="list-group-item">
            <input type="radio" name="gato" value="false" required/> Completed GATO <br>
          </li>
          <li class="list-group-item">
            <input type="radio" name="gato" value="true"/> Will complete GATO <br>
          </li>
        </ul>
        <ul class="list-group">
          <li class="list-group-item">
            <input type="radio" name="international" value="false"/> International Applicant <br>
			<input type="radio" name="international" value="true" required/> Non-International Applicant <br>
          </li>
          <li class="list-group-item">
            Select PDF to upload for resume:
            <input type="file" name="fileToUpload" id="fileToUpload" required>
          </li>
        </ul>
		<br>
		<br>
  		<input type="submit" value="Save and Continue">
  		</form>
  		</br>
		<br>
      </div>

      <div class="well">
        <p><center><small>Group I</small></center></p>
      </div>


    </div> <!-- /container -->
<script type="text/javascript">

new FormValidator('appform', [{
    name: 'id',
    display: 'studentID',
    rules: 'required|exact_length[8]|numeric'
}, {
    name: 'GPA',
	display: 'GPA',
    rules: 'required|numeric'
}, {
    name: 'gradDate',
    display: 'gradeDate',
    rules: 'min_length[8]'
}, {
    name: 'advisor',
	display: 'advisor',
    rules: 'required'
}, {
    name: 'degreetype',
    display: 'degreetype',
    rules: 'max_length[3]'
}, {
    name: 'major',
	display: 'major',
    rules: 'required'
}], function(errors, evt) {

    var SELECTOR_ERRORS = $('.error_box'),
        SELECTOR_SUCCESS = $('.success_box');

    if (errors.length > 0) {
        SELECTOR_ERRORS.empty();

        for (var i = 0, errorLength = errors.length; i < errorLength; i++) {
            SELECTOR_ERRORS.append("✘ " + errors[i].message + '<br />');
        }

        SELECTOR_SUCCESS.css({ display: 'none' });
        SELECTOR_ERRORS.fadeIn(200);
    } else if(errors.length == 0){
		<?php header("Location: https://groupi-softwareeng.rhcloud.com/Controller/upload.php");?>
	} else {
        SELECTOR_ERRORS.css({ display: 'none' });
        SELECTOR_SUCCESS.fadeIn(200);
    }

    if (evt && evt.preventDefault) {
        evt.preventDefault();
    } else if (event) {
        event.returnValue = false;
    }
});

</script>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-26362841-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="https://babbage.cs.missouri.edu/~skhhdc/cs2830/finalProject/dist/js/bootstrap.min.js"></script>
  </body>
</html>
