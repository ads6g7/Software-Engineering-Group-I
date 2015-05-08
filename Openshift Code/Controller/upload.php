<?php
session_start();
if (!isset($_SESSION['USERNAME']))
{
	$redirect = "https://groupi-softwareeng.rhcloud.com";
	header("Location: $redirect");
}
if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS']== ""){
	$redirect = "https://".$_SERVER['HTTP_HOST']. $_SERVER['REQUEST_URI'];
	header("Location: $redirect");
}



//include("../secure/database.php");
$conn=pg_connect("host=/var/lib/openshift/5527ddbb5973cacee00000e9/postgresql/socket/ dbname=groupi user=adminup8hecl password=evnEWGkla94u") or die('Unable to connect to database' .pg_last_error());
//$conn =pg_connect(HOST ." ". DBNAME." ".USERNAME." ".PASSWORD) OR DIE('This is ridiculous');
$username = $_SESSION['USERNAME'];
$studentID=htmlspecialchars($_POST['id']);
$prevPos=htmlspecialchars($_POST['prev']);
$currPos=htmlspecialchars($_POST['curr']);
$wantPos=($_POST['select']);
$gpa=htmlspecialchars($_POST['gpa']);
$gradDate=htmlspecialchars($_POST['gradDate']);
$advisor=htmlspecialchars($_POST['advisor']);
$degree=htmlspecialchars($_POST['degreetype']);
$grad=htmlspecialchars($_POST['gradstudent']);
$international=htmlspecialchars($_POST['international']);
$major=htmlspecialchars($_POST['major']);
$gato=htmlspecialchars($_POST['gato']);

$_SESSION['select']=($_POST['select']);
$_SESSION['international']=$international;

//$target_dir = "";
$target_file = basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "pdf") {
    echo "Sorry, the file was not a pdf";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

$result=pg_prepare($conn, 'application','INSERT INTO users.applications VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12)') or die ('Prepare count failed: ' .pg_last_error());
$aliveResult = pg_execute($conn, 'application', array($username, $studentID, $major, $gradDate, $prevPos, $currPos, $gpa, $grad, $degree, $advisor, $international, $gato)) or die ('Execute count failed: '.pg_last_error());
//get the binary file based on the filename
$data=file_get_contents('$_FILES["fileToUpload"]["name"]');
//escape the binary data
$escaped = bin2hex( $data );
//Insert into database
//pg_query("UPDATE users.applications SET filename='testing', pdf=decode('{$escaped}', 'hex') WHERE username='$username'") or die('Error: '.pg_last_error());
pg_prepare($conn, 'updateresume', "update users.applications set filename = $1, pdf = decode('{$escaped}', 'hex') where username = $2") or die("Issue with updateresume prepared".pg_last_error());
$result = pg_execute($conn, 'updateresume', array($target_file, $username)) or die('Error with updating the files: '.pg_last_error());
$redirect = "https://groupi-softwareeng.rhcloud.com/View/applicantWants.php";
header("Location: $redirect");
?>
