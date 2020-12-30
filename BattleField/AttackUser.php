<?php

header('Content-type: application/json');


if($_POST) {
        $username   = $_POST['username'];
        $attackID = $_POST['attackedID'];
        $email   = $_POST['email'];
        $attackpower = $_POST['attackpower'];


if($_POST['username']) {

/*
if($_GET) {
	$username   = $_GET['username'];
        $attackID = $_GET['attackedID'];
        $email   = $_GET['email'];
        $attackpower = $_GET['attackpower'];


if($_GET['username']) {
*/



		if ( $username == $username ) {

				require('/var/www/html/Apps/AppsConfig.php'); 
$dbname = "Stevens_GeoHunters";

define('DIR','http://'.$servername.'/Apps/BattleField/');
define('SITEEMAIL','admin@'.$emailServer.'.com');

try {

    $db = new PDO("mysql:host=$servername;dbname=$dbname", $db_username, $db_password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
} catch(PDOException $e) {
	//show error
  //  echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    exit;
}



//GETS USERS'S CURRENT HEALTH RATING FROM SERVER
$HealthCurrent = "SELECT health FROM users WHERE email = '" . $attackID . "'";
$stmt = $db->prepare($HealthCurrent);
$stmt->execute();
$C = $stmt->fetch(PDO::FETCH_ASSOC);
$CurrentHealthRating = $C['health'];
//$stmt->close();

//echo "got current health rating = $CurrentHealthRating";
//echo "<br>";

//CALCULATES USER'S NEW HEALTH RATING
$NewHealthRating = $CurrentHealthRating - $attackpower;


if ($NewHealthRating < 0) {

$NewHealthRating = 0;

}
//echo "new health rating = $NewHealthRating";
//echo "<br>";

//UPDATES USERS NEW HEALTH RATING
$HealthNew = "UPDATE users SET health = :NewHealth WHERE email = '" . $attackID . "'";
$sql_insert = $db->prepare($HealthNew);
$sql_insert->bindParam(":NewHealth", $NewHealthRating);
$sql_insert->execute();
//$sql_insert->close();

//echo "updated the new health rating";
//echo "<br>";


//SELECTS NEW HEALTH FROM SERVER
$HealthCurrent2 = "SELECT health FROM users WHERE email = '" . $attackID . "'";
$stmt2 = $db->prepare($HealthCurrent2);
$stmt2->execute();
$C2 = $stmt2->fetch(PDO::FETCH_ASSOC);
$UpdatedHealth = $C2['health'];

//echo "got updated health rating = $UpdatedHealth";
//echo "<br>";


//$UpdatedHealth = $NewHealthRating;


				if ($stmt2->error) {error_log("Error: " . $stmt2->error); }

				$success = $stmt2->affected_rows;

				/* close statement and connection */
				//$stmt2->close();

				/* close connection */
				//$db->close();
				error_log("Success: $success");

				if ($CurrentHealthRating == "") {
						echo '{"success":0,"error_message":"Username Does Not Exist."}';
				} else {
                                  error_log("User '$username' has been attacked.");
					//echo "{\"success\":1,\"username\":\"$username\",\"health\":$UpdatedHealth}";


$tokenInfo = "SELECT DeviceToken FROM users WHERE email = '" . $attackID . "'";
$stmt3 = $db->prepare($tokenInfo);
$stmt3->execute();
$C3 = $stmt3->fetch(PDO::FETCH_ASSOC);
$UsersDeviceTK = $C3['DeviceToken'];

                                  echo "{\"success\":1,\"health\":$UpdatedHealth,\"token\":\"$UsersDeviceTK\",\"attackedID\":\"$attackID\"}";

				}
			
		} else {
			echo '{"success":0,"error_message":"Passwords does not match."}';
		}
	} else {
		echo '{"success":0,"error_message":"Invalid Username."}';
	}
} else {
	echo '{"success":0,"error_message":"Invalid Data."}';
}
?>