<?php
include("../secure/database.php");
$conn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect: '.pg_last_error());

//get the binary file based on the filename
$data=file_get_contents('testing.pdf');
//escape the binary data
$escaped = base64_encode( $data );
//Insert into database
pg_query("INSERT INTO users.applications (filename, pdf) VALUES ('testing', decode('{$escaped}', 'base64'))") or die('Error: '.pg_last_error());
?>
