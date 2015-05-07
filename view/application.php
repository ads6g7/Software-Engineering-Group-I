<!--
Sign Up Application Form
TA/PLA Application Project
Group I
CS4320
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <title>TA/PLA Application Form</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">
    <meta name="description" content="Lightweight form validation library in JavaScript ready to include in any web application." />

    <!-- Bootstrap core CSS -->
    <link href="https://babbage.cs.missouri.edu/~skhhdc/cs2830/finalProject/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="https://babbage.cs.missouri.edu/~skhhdc/cs2830/finalProject/dist/css/bootstrap-theme.min.css" rel="stylesheet">

    <!--Form Validation-->
    <link href="http://fonts.googleapis.com/css?family=Andada" rel="stylesheet" type="text/css">
    <link href="styles/main.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
    <script type="text/javascript" src="validate.min.js"></script>
</head>

<body role="document" onload="classArray()">

<script>
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

    <div class="success_box">✔<br></div>
    <div class="error_box"><br></div>

    <form name="appform" action="#" method="POST">
        <label for="id">Student ID:</label><br>
        <input name="id" id="id" /><br><br>

        <label for="prev">Previous Position:</label><br>
        <input name="prev" id="prev" /><br><br>

        <label for="curr">Current Position:</label><br>
        <input name="curr" id="curr" /><br><br>

        <label for="want">Wanted Position:</label><br>
        <input name="want" id="want" /><br><br>

        <div><select multiple id="select" name="select[]" required></select><br><br>

        <label for="GPA">GPA:</label><br>
        <input name="GPA" id="GPA" placeholder="Ex: 3.4"/><br>
        
        <label for="graddate">Anticipated Graduation Date:</label><br>
        <input name="graddate" id="graddate"/><br>

        <label for="advisor">Advisor:</label><br>
        <input name="advisor" id="advisor"/><br>

        <label for="degreetype">Degree Type:</label><br>
        <input name="degreetype" id="degreetype"/><br>

        <label for="major">Major:</label><br>
        <input name="major" id="major"/><br><br>

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
            <input type="checkbox" name="international" value="false"/> International Applicant <br>
          </li>
          <li class="list-group-item">
            Select PDF to upload for resume:
            <input type="file" name="fileToUpload" id="fileToUpload" required>
          </li>
        </ul>

  <br>
    <input type="submit" value="Save and Continue">
        <button class="button gray" type="submit" name="submit">Submit</button>
    </form>
  </div> <!-- /container -->

<script type="text/javascript">

new FormValidator('appform', [{
    name: 'id',
    display: 'required',
    rules: 'required|exact_length[8]'
}, {
    name: 'prev',
    rules: 'required'
}, {
    name: 'curr',
    rules: 'required'
}, {
    name: 'GPA',
    rules: 'valid_email'
}, {
    name: 'gradDate',
    display: 'min length',
    rules: 'min_length[8]'
}, {
    name: 'advisor',
    display: 'terms of service',
    rules: 'required'
}, {
    name: 'degreetype',
    display: 'min length',
    rules: 'min_length[8]'
}, {
    name: 'major',
    display: 'Major',
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

</body>
</html>
