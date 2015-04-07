<html>
<head>
<title>Profile Home</title>
<style>
	h1{
		text-align: center;
	}
	h3{
		text-align: center;
	}
	.tablecontainer{
		padding: 0px;
		margin: 0 auto;
		width: 480px;
	}
	.vidcontainer{
		padding: 0px;
		margin: 0 auto;
		width: 600px;
	}
	.container{
		padding: 0px;
		margin: 0 auto;
		width: 200px;
	}
	#logout{
		width: 200px;
	}
	#updatepic{
		width: 200px;
	}
	#profilepic{
		margin: 0 auto;
		border: 2px solid black;
		width: 200px;
		height: 200px;
	}
	#cname{
		text-align: center;
	}
</style>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">
<script>
function showVideo(str)
{
var xmlhttp;    
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("vid").innerHTML = xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","getvideo.php?q="+str,true);
xmlhttp.send();
}
</script>
</head>
<body>
	<?php
		session_start();
		//if user is not logged in, redirect to index
		if(!isset($_SESSION['login_user'])){
			header("location: index.php");
		}
		//construct user's profile
		$user = $_SESSION['login_user'];
		//welcome message
		echo "<h1>Welcome $user!</h1>";
	?>
	
	<div id="profilepic" class="ui-widget-content">
	<img src="AnonPic.jpg" alt="Profile Picture Here" style="width:200px;height:200px">
	</div>
	</br>
	
	<?php
		//connect to database and get info of user
		$conn = pg_connect("") or die('Could not connect: ' . pg_last_error());
		$result = pg_prepare($conn,"Get_Info","SELECT registration_date, description FROM users.user_info WHERE username = $1");
		$result = pg_execute($conn,"Get_Info",array($user));
		//create table of user registration date and description
		echo "<div class = tablecontainer>\n";
		echo "<table border = '1'>\n";
		while ($i < pg_num_fields($result)){
			$fieldName = pg_field_name($result, $i);
			echo '<th>' . $fieldName . '</th>';
			$i = $i + 1;
		}
		while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
			echo "\t<tr>\n";
			foreach ($line as $col_value) {
				echo "\t\t<td>$col_value</td>\n";
			}
			echo "\t</tr>\n";
		}
		echo "</table>\n</br>";
		echo "<input id = 'update' type='button' name = 'update' value ='Update Description'></input>";
		echo "<input id = 'cpass' type='button' name = 'cpass' value ='Change Password'></input>";
		echo "</div>";
		//reset variable for next table
		$i =0;
		//free result
		pg_free_result($result);
?>
</br>
<h3> Popular Youtube Tech Channels</h3>
<div class = "vidcontainer">
<form> 
<select name="videos" onchange="showVideo(this.value)">
<option value="">Select a Channel:</option>
<option value="JayzTwoCents">JayzTwoCents</option>
<option value="Barnacules">Barnacules Nerdgasm</option>
<option value="PaulsHardware">Paul's Hardware</option>
<option value="LinusTech">Linus Tech Tips</option>
<option value="TechQuickie">TechQuickie</option>
<option value="DJI">DJI Drones</option>
</select>
</form>
<div id = "vid">
<h3 style = 'color: red'>NO VIDEO SELECTED</h3>
</div>
</div>
</br>
<script>
 $(function() {
$( "#accordion" ).accordion();
});
</script>
<div class = "tablecontainer">
<h3>Top Search Engines</h3>
<div id="accordion">
<h3><img src="googleLogo.jpg" alt="Google Logo Here" style="width:200px;height:100px"></h3>
<div>
<p style="font-size:12px">
Google is the premier search engine in use on the web today. Google uses software known as “web crawlers” to discover publicly available webpages. 
The most well-known crawler is called “Googlebot.” Crawlers look at webpages and follow links on those pages, much like you would if you were browsing content on the web. 
They go from link to link and bring data about those webpages back to Google’s servers. 
</p>
<a href="http://www.google.com">Google Search</a> 
</div>
<h3><img src="yahooLogo.jpg" alt="Yahoo Logo Here" style="width:200px;height:100px"></h3>
<div>
<p style="font-size:12px">
Yahoo was the original search giant, when it first launched back in the 1990s. 
Google has long since eclipsed it in popularity as a search engine, but Yahoo still has a significant share of search activity.
</p>
<a href="http://www.search.yahoo.com">Yahoo! Search</a>
</div>
<h3><img src="bingLogo.jpg" alt="Bing Logo Here" style="width:200px;height:100px"></h3>
<div>
<p style="font-size:12px">
Microsoft has long offered its own search engine. However, it opened a new chapter in its fight against Google’s dominance by relaunching its search engine as Bing in June 2009.
Since that time, Bing has gained market share, though it remains far behind Google and even Yahoo.
</p>
<a href="http://www.bing.com">Bing Search</a>
</div>
</div>
<?php		
		echo "<h3>Recent Activity</h3>";
		//get past activity of user
		$result = pg_prepare($conn,"Get_Log","SELECT username,ip_address,log_date,action FROM users.log WHERE username = $1");
		$result = pg_execute($conn,"Get_Log",array($user));
		//create table of past user activity
		echo "<div class = tablecontainer>";
		echo "<table border = '1'>\n";
		while ($i < pg_num_fields($result)){
			$fieldName = pg_field_name($result, $i);
			echo '<th>' . $fieldName . '</th>';
			$i = $i + 1;
		}
		while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
			echo "\t<tr>\n";
			foreach ($line as $col_value) {
				echo "\t\t<td>$col_value</td>\n";
			}
			echo "\t</tr>\n";
		}
		echo "</table>\n";
		echo "</div>";
		//free result and close database connection
		pg_free_result($result);
		pg_close($conn);
	?>
	</br>
	<div class = container>
	<input id = "logout" type="button" name = "logout" value ="Logout"></input>
	</div>
<script>
	document.getElementById("logout").onclick = function () {
	location.href = "logout.php";
    };
	document.getElementById("update").onclick = function () {
	location.href = "update.php";
    };
	document.getElementById("cpass").onclick = function () {
	location.href = "newpass.php";
    };
</script>
<script>
$(function() {
	$( "#profilepic" ).draggable({ grid: [ 20, 20 ] });
});
</script>
</body>
</html>
