<?php
session_start();
if (!isset($_SESSION['USERNAME']))
{
    header("Location: https://groupi-softwareeng.rhcloud.com/");
}
if(!isset($_SESSION['STUDENT'])){
	header("Location: https://groupi-softwareeng.rhcloud.com/View/teacherdashboard.php");
}

if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "")
{
		$redirect = "https://".$_SERVER['HTTP_HOST']. $_SERVER['REQUEST_URI'];
		header("Location: $redirect");
}


$conn = pg_connect("host=/var/lib/openshift/5527ddbb5973cacee00000e9/postgresql/socket/ dbname=groupi user=adminup8hecl password=evnEWGkla94u") or die('Unable to connect to database' .pg_last_error());
$username=$_SESSION['STUDENT'];
echo "username = ".$username."<br>";

//$res = pg_prepare($conn, "getpdf", "SELECT encode(pdf, 'base64') AS data FROM users.applications WHERE filename=$1") or die('Could not prepare: '.pg_last_error());  
//$res = pg_execute($conn, "getpdf", array("note5.pdf")) or die('Could not execute: '.pg_last_error());  
$res = pg_query("select encode(pdf, 'base64') AS data FROM users.applications WHERE filename='097734620602'") or die("FUCK THIS");
$raw = pg_fetch_result($res, "data") or die('Could not execute: '.pg_last_error());
  
// Convert to binary and send to the browser
header('Content-type: application/pdf');
echo base64_decode($raw);
?>
