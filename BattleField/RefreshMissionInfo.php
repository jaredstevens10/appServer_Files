<?php


header('Content-type: application/json');

if($_POST) {
$username   = $_POST['username'];
$email   = $_POST['email'];
$level   = $_POST['level'];


/*
if($_GET) {

$username   = $_GET['username'];
$email   = $_GET['email'];
$level   = $_GET['level'];
*/

$appversion = "1.0.0";


	if($_POST['username']) {
//if($_GET['username']) {
		if ( $username == $username ) {

//echo $username;
			require('/var/www/html/Apps/AppsConfig.php'); 
$dbname = "Stevens_GeoHunters";

define('DIR','http://'.$servername.'/Apps/BattleField/');
define('SITEEMAIL','admin@'.$emailServer.'.com');


try {

	//create PDO connection 
	//$db = new PDO("mysql:host=".DBHOST.";port=8889;dbname=".DBNAME, DBUSER, DBPASS);
	$db = new PDO("mysql:host=$servername;dbname=$dbname", $db_username, $db_password);
    
    
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   // echo "Connected Successfully";
    
} catch(PDOException $e) {
	//show error
    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    exit;
}


if($_POST['level'])  {

$LocationInfo = "SELECT * FROM MissionData WHERE level = ".$level."";

// ORDER BY DateApt ASC, TimeApt ASC";

$stmt = $db->prepare($LocationInfo);
$stmt->execute();



echo"{\"success\":1,\"appversion\":\"$appversion\",\"Data\":[";

while($rows = $stmt->fetch(PDO::FETCH_ASSOC)){


echo "{\"id\":\"$rows[id]\",\"missionName\":\"$rows[missionName]\",\"missionMapURL\":\"$rows[missionMapURL]\",\"xp\":\"$rows[xp]\",\"objective\":\"$rows[objective]\",\"level\":\"$rows[level]\",\"objectURL\":\"$rows[objectURL]\"},";


}

echo "{\"id\":\"0\",\"name\":\"NA\",\"category\":\"NA\"}]}";


} else {


$LocationInfo = "SELECT * FROM MissionData";

// ORDER BY DateApt ASC, TimeApt ASC";

$stmt = $db->prepare($LocationInfo);
$stmt->execute();

//$c = $stmt->fetch(PDO::FETCH_ASSOC);
//$c = $stmt->fetch(mysqli_stmt::fetch);
//$stmt = $mysqli->query($LocationInfo);
//$stmt->execute();
//$C = $stmt->fetch(PDO::FETCH_ASSOC);
//$C = $stmt->fetchall();


echo"{\"success\":1,\"appversion\":\"$appversion\",\"MissionInfo\":[";

while($rows = $stmt->fetch(PDO::FETCH_ASSOC)){


echo "{\"id\":\"$rows[id]\",\"missionName\":\"$rows[missionName]\",\"missionMapURL\":\"$rows[missionMapURL]\",\"xp\":\"$rows[xp]\",\"objective\":\"$rows[objective]\",\"level\":\"$rows[level]\",\"objectURL\":\"$rows[objectURL]\"},";


}

echo "{\"id\":\"0\",\"name\":\"NA\",\"category\":\"NA\"}]}";


}


$C = $stmt->fetch(PDO::FETCH_ASSOC);




				if ($stmt->error) {error_log("Error: " . $stmt->error); }

				$success = $stmt->affected_rows;

				/* close statement and connection */
				//$stmt->close();

				/* close connection */
				//$db->close();
				error_log("Success: $success");

				if ($username == "") {
						//echo '{"success":0,"error_message":"Username Exist."}';
				} else {
error_log("User '$username' created.");

	}
			
		} else {
			echo '{"success":0,"error_message":"Passwords does not match."}';
		}
	} else {
		echo '{"success":0,"error_message":"Invalid Username."}';
	}
}else {
	echo '{"success":0,"error_message":"Invalid Data."}';
}
?>
