<!--
Sign Up Application Form
TA/PLA Application Project
Group I
CS4320
-->

<!DOCTYPE html>
<html lang="en">
  <head>
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
	
	<?php
	$today = date("Y-m-d");
	$date = "2015-04-25";
	
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

  <body role="document" onload="classArray()">

<script>
<!--Figured we'd pull from database, but for now using this. Also got rid of grades JS, too sloppy/unreliable-->
var classes=["CMP_SC 1000: Introduction to Computer Science",
"CMP_SC 1001: Topics in Computer Science",
"CMP_SC 1050: Algorithm Design and Programming I",
"CMP_SC 2001: Topics in Computer Science",
"CMP_SC 2050: Algorithm Design and Programming II",
"CMP_SC 2111: Production Languages",
"CMP_SC 2270: Introduction to Digital Logic",
"CMP_SC 2830: Introduction to the Internet, WWW and Multimedia Systems",
"CMP_SC 3001: Topics in Computer Science",
"CMP_SC 3050: Advanced Algorithm Design",
"CMP_SC 3280: Computer Organization and Assembly Language",
"CMP_SC 3330: Object Oriented Programming",
"CMP_SC 3380: Database Applications and Information Systems",
"CMP_SC 3530: UNIX Operating System",
"CMP_SC 3940: Internship in Computer Science",
"CMP_SC 4001: Topics in Computer Science",
"CMP_SC 4050: Design and Analysis of Algorithms I",
"CMP_SC 4060: String Algorithms",
"CMP_SC 4070: Numerical Methods for Science and Engineering",
"CMP_SC 4085: Problems in Computer Science",
"CMP_SC 4270: Computer Architecture I",
"CMP_SC 4280: Network Systems Architecture",
"CMP_SC 4320: Software Engineering I",
"CMP_SC 4330: Object Oriented Design I",
"CMP_SC 4380: Database Management Systems I",
"CMP_SC 4410: Theory of Computation I",
"CMP_SC 4430: Compilers I",
"CMP_SC 4440: Malware Analysis and Defense",
"CMP_SC 4450: Principles of Programming Languages",
"CMP_SC 4520: Operating Systems I",
"CMP_SC 4610: Computer Graphics I",
"CMP_SC 4620: Physically Based Modeling and Animation",
"CMP_SC 4650: Digital Image Processing",
"CMP_SC 4670: Digital Image Compression",
"CMP_SC 4720: Introduction to Machine Learning and Pattern Recognition",
"CMP_SC 4730: Building Intelligent Robots",
"CMP_SC 4740: Interdisciplinary Introduction to NLP",
"CMP_SC 4750: Artificial Intelligence I",
"CMP_SC 4770: Introduction to Computational Intelligence",
"CMP_SC 4830: Science and Engineering of the World Wide Web",
"CMP_SC 4850: Computer Networks I",
"CMP_SC 4860: Network Security",
"CMP_SC 4870: Wireless and Mobile Networks",
"CMP_SC 4970: Senior Capstone Design I",
"CMP_SC 4980: Senior Capstone Design II",
"CMP_SC 4990: Undergraduate Research in Computer Science",
"CMP_SC 4995: Undergraduate Research in Computer Science - Honors"];
function classArray()
{
	var select=document.getElementById("select");
	for (var i=0; i<classes.length; i++)
	{
		var opt=document.createElement("option");
		opt.innerHTML=classes[i];
		opt.value=classes[i];
		opt.onclick="myFunction(this.value)";
		select.appendChild(opt);
	}
}
</script>


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
              <li><a href="http://groupi-softwareeng.rhcloud.com/">Home</a></li>
			  <li class="active"><a href="signup.html">Sign Up</a></li>

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

  		<form action="upload.php" method="post" enctype="multipart/form-data">

    		Student ID:<br>
    		<input type="text" name="id" placeholder="Ex: 12345678" required><br>

      Previous Position:<br>
  		<input type="text" name="prev" placeholder="Previous Position" required><br>

      Current Position:<br>
  		<input type="text" name="curr" placeholder="Current Position" required><br><br>

      Wanted Positions:<br>
<div>
<select multiple id="select" name="select[]" required>
</select>
<br><br>
</body>

<!-- Rough code for entering grades-->
<script>
function myFunction(val)
{
	if (document.getElementById(val))
	{
		var remove=document.getElementById(val)
		var myDiv=document.getElementById("myDiv");
		myDiv.removeChild(remove);
	}
	else
	{
	var myDiv=document.getElementById("myDiv");
	var mySelect=document.getElementById("select");
	var val=mySelect.options[mySelect.selectedIndex].value;
	var label=document.createElement("label");
	label.appendChild(document.createTextNode("Enter grade for " +val +": "));
	label.id=val;
	var option = document.createElement("input");
	option.type="text";
	option.id=val;
	label.appendChild(option);
	myDiv.appendChild(label);
	}
}
</script>	
</div>	

      GPA:<br>
      <input type="text" name="gpa" placeholder="GPA" required><br>
	  
	  Anticipated Grad. Date:<br>
      <input type="text" name="gradDate" placeholder="Ex: Fall 2016" required><br>

      Advisor:<br>
      <input type="text" name="advisor" placeholder="Advisor's Full Name" required><br>
      Degree Type:<br>
      <input type="text" name="degreetype" placeholder="Degree Type" required><br>
	  Major:<br>
	  <input type="text" name="major" placeholder="Major" required><br><br>
	  

      Graduate Student:<br>
      <input type="radio" name="gradstudent" value="true">Graduate<br>
      <input type="radio" name="gradstudent" value="false">Undergraduate<br><br>
	  <input type="checkbox" name="gato" value="false"/> International Applicant: <br>
      <input type="checkbox" name="international" value="false"/> Completed GATO: <br>
	  <input type="checkbox" name="international" value="false"/> Will complete GATO: <br><br>
		<br>
			Select PDF to upload for resume:
		<input type="file" name="fileToUpload" id="fileToUpload" required>
		<br>
		<br>
  		<input type="submit" value="Send">
  		</form>
  		</br>
		<br>
      </div>

      <div class="well">
        <p><center><small>Group I</small></center></p>
      </div>


    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="http://babbage.cs.missouri.edu/~skhhdc/cs2830/finalProject/dist/js/bootstrap.min.js"></script>
  </body>
</html>
