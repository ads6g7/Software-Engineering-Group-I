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

$username = $_SESSION['STUDENT'];
$dbconn = pg_connect("host=/var/lib/openshift/5527ddbb5973cacee00000e9/postgresql/socket/ dbname=groupi user=adminup8hecl password=evnEWGkla94u") or die('Unable to connect to database' .pg_last_error());
$res = pg_query("SELECT filename FROM users.applications WHERE username= '".$username."'") or die('Could not connect?!: '.pg_last_error());  
$raw = pg_fetch_result($res, "filename") or die('Could not connect!!: '.pg_last_error());
$raw = "../".$raw;
if (file_exists($raw))
{
	header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($raw));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($raw));
    readfile($raw);
    exit;
}

?>