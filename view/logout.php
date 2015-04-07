<?php
	session_start();
	$conn = pg_connect("") or die('Could not connect: ' . pg_last_error());
	$user = $_SESSION['login_user'];
	$ip = $_SERVER['REMOTE_ADDR'];
	$result = pg_prepare($conn,"Log_Activity","INSERT INTO users.log (username,ip_address,action) VALUES($1,$2,'Account Logout')");
	$result = pg_execute($conn, "Log_Activity",array($user,$ip));
	pg_free_result($result);
	pg_close($conn);
	session_unset();
	session_destroy();
	header("location: index.php");
	exit();
?>