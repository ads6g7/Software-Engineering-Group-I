<?php
include("../secure/database.php");
$conn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect: '.pg_last_error());

//get the binary file based on the filename
$data=file_get_contents('testing.pdf');
//escape the binary data
$escaped = bin2hex( $data );
//Insert into database
pg_query("INSERT INTO images (filename, pdf) VALUES ('testing', decode('{$escaped}', 'hex'))") or die('Error: '.pg_last_error());
?>
