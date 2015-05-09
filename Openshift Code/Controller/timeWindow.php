<?php
$conn = pg_connect("host=/var/lib/openshift/5527ddbb5973cacee00000e9/postgresql/socket/ dbname=groupi user=adminup8hecl password=evnEWGkla94u") or die('Unable to connect to database' .pg_last_error());

$result=pg_query("SELECT * FROM users.timewindow") or die('Unable to execute' .pg_last_error());
$line = pg_fetch_array($result, null, PGSQL_ASSOC);
$studentStart = $line['userdatestart'];
$studentEnd = $line['userdateend'];
$teacherStart = $line['teacherdatestart'];
$teacherEnd = $line['teacherdateend'];

$username=$_SESSION['USERNAME'];
$today = date("Y-m-d");

$result = pg_prepare($conn, "Check", "select * from users.professors where username = $1");
$result = pg_execute($conn, "Check", array($username));
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
