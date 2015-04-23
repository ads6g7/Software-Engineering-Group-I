<?php
include("../secure/database.php");
$conn=pg_connect(HOST." ".DBNAME. " ".USERNAME. " ". PASSWORD)
or die ('Could not connect:' .pg_last_error());

$res = pg_query("SELECT encode(pdf, 'base64') AS data FROM users.applications WHERE users.applications.username='test'") or die('Could not connect?!: '.pg_last_error());  
$raw = pg_fetch_result($res, "data") or die('Could not connect!!: '.pg_last_error());
  
// Convert to binary and send to the browser
header('Content-type: application/pdf');
echo base64_decode($raw);
?>