<!-- 
error.php
TA/PLA Project
Group I
CS_4320
-->

<!--
will need to add any styling to this page
-->

<!DOCTYPE html>
<html>
	<head>
		<title>Session Error!</title>
	</head>

	<body>
		<h1>Error!</h1>
		<p>There was an error starting a session. You will be redirected to the login page in 30 seconds.</p>
		<?php
			sleep(30);
			header("Location: https://groupi-softwareeng.rhcloud.com");
		?>
		
	</body>
</html>
