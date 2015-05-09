<!--
Logout.php 
TA/PLA Application Project
Group I
CS4320
-->
	<?php
		if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] ==""){
			$redirect = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			header("Location: $redirect");
		}	
		if(!session_start()) {
			$redirect = "https://groupi-softwareeng.rhcloud.com/Controller/errorSession.php";
			header("Location: $redirect");
			exit;
		}	
		$_SESSION = array();
		
		if(ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000,
				$params["path"], $params["domain"],
				$params["secure"], $params["httponly"]
			);
		}
		
		session_destroy();
		$redirect = "https://groupi-softwareeng.rhcloud.com";
		header("Location: $redirect");
	?>