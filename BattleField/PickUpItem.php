<?php

header('Content-type: application/json');
if($_POST) {
	$username   = $_POST['username'];
       $itemID = $_POST['itemID'];
       $amount = $_POST['amount'];


	if($_POST['username']) {
		if ( $username == $username ) {

			require('/var/www/html/Apps/AppsConfig.php'); 
$dbname = "Stevens_GeoHunters";

define('DIR','http://'.$servername.'/Apps/BattleField/');
//define('SITEEMAIL','admin@'.$emailServer.'.com');

try {

    $db = new PDO("mysql:host=$servername;dbname=$dbname", $db_username, $db_password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
} catch(PDOException $e) {
	//show error
  //  echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    exit;
}



//DELETE BELOW
/*
$HealthCurrent = "SELECT health FROM users WHERE username = '" . $username . "'";
$stmt = $db->prepare($HealthCurrent);
$stmt->execute();
$C = $stmt->fetch(PDO::FETCH_ASSOC);
$CurrentHealthRating = $C['health'];
//$stmt->close();

//echo "got current health rating = $CurrentHealthRating";
//echo "<br>";

//CALCULATES USER'S NEW HEALTH RATING
$NewHealthRating = $CurrentHealthRating - $attackpower;

//echo "new health rating = $NewHealthRating";
//echo "<br>";
*/
//DELETE ABOVE


//UPDATES ITEM USER


$GetItem = "UPDATE GameItems SET username = :NewUser, isAvailable = 'no' WHERE id = " . $itemID;
$sql_insert = $db->prepare($GetItem);
$sql_insert->bindParam(":NewUser", $username);
$sql_insert->execute();


if ($amount > 0) {



$UpdateGold = "SELECT * FROM users WHERE (username = '".$username."')";

$stmtGold = $db->prepare($UpdateGold);
$stmtGold->execute();
$RowsGold = $stmtGold->fetch(PDO::FETCH_ASSOC);
$OldAmount = $RowsGold[gold];

$NewAmount = $OldAmount + $amount;


$SetGoldAmount = "UPDATE users SET gold = :NewGoldAmount WHERE username = '".$username."'";
$sql_insertGold = $db->prepare($SetGoldAmount);
$sql_insertGold->bindParam(":NewGoldAmount", $NewAmount);
$sql_insertGold->execute();

}

//$sql_insert->close();

//echo "updated the new health rating";
//echo "<br>";

//DELETE BELOW
/*
//SELECTS NEW HEALTH FROM SERVER
$HealthCurrent2 = "SELECT health FROM users WHERE username = '" . $username . "'";
$stmt2 = $db->prepare($HealthCurrent2);
$stmt2->execute();
$C2 = $stmt2->fetch(PDO::FETCH_ASSOC);
$UpdatedHealth = $C2['health'];

//echo "got updated health rating = $UpdatedHealth";
//echo "<br>";


//$UpdatedHealth = $NewHealthRating;
*/
//DELETE ABOVE
				if ($sql_insert->error) {error_log("Error: " . $sql_insert->error); }

				$success = $sql_insert->affected_rows;

				/* close statement and connection */
				//$stmt2->close();

				/* close connection */
				//$db->close();
				error_log("Success: $success");

				if (1 == 0) {
						echo '{"success":0,"error_message":"Item Does Not Exist."}';
				} else {
                                  error_log("User '$username' has been attacked.");
				   echo "{\"success\":1}";


//,\"username\":\"$username\",\"health\":$UpdatedHealth}";
/*
$tokenInfo = "SELECT DeviceToken FROM users WHERE username = '" . $username . "'";
$stmt3 = $db->prepare($tokenInfo);
$stmt3->execute();
$C3 = $stmt3->fetch(PDO::FETCH_ASSOC);
$UsersDeviceTK = $C3['DeviceToken'];
echo "{\"success\":1,\"health\":$UpdatedHealth,\"token\":\"$UsersDeviceTK\"}";
*/

				}
			
		} else {
			echo '{"success":0,"error_message":"Passwords does not match."}';
		}
	} else {
		echo '{"success":0,"error_message":"Invalid Item."}';
	}
}else {
	echo '{"success":0,"error_message":"Invalid Data."}';
}
?>
