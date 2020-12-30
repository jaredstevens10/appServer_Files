<?php

	$servername = "localhost";
	$username = "clavenso_Admin";
	$password = "claven01*";
	$dbname = "clavenso_JobTracker";


	//$conn = mysqli("$hostname","$username","$password") or die(mysql_error());
	//mysql_select_db("$dbname", $conn) or die(mysql_error());
	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

?>