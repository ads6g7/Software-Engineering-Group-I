<!--
Logout.php 
TA/PLA Application Project
Group I
CS4320
-->
	<?php
		if(!session_start()) {
			header("Location: error.php");
			exit;
		}
			
		$_SESSION = array();
		
		if(ini_get("session.use_cookies")) {
			$params - session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000,
				$params["path"], $params["domain"],
				$params["secure"], $params["httponly"]
			);
		}
		session_destroy();
		header(Location: "http://groupi-softwareeng.rhcloud.com/");
	?>
