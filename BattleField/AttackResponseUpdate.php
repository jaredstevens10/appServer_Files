<?php

header('Content-type: application/json');

/*
if($_GET) {
       //$username   = $_GET['username'];
       $email   = $_GET['email'];
       $attackingID   = $_GET['attackingID'];
       $response = $_GET['response'];
      

//$amount = $_GET['amount'];

$action = $_GET['action'];
      
     if($_GET['email']) {
	*/
	
	
	
if($_POST) {
      // $username   = $_POST['username'];
       $email   = $_POST['email'];
       $attackingID   = $_POST['attackingID'];
       $response = $_POST['response'];
      // $amount = $_POST['amount'];
       //$amount = $_POST['amount'];

$action = $_POST['action'];


/*
if ($response == "") {
	if ($action == "write") {
		$underAttack = "no";
	} else {
		$underAttack = "yes";
	}
} else {
	if ($action == "read") {
		$underAttack = "yes";
	}
}
*/


if ($action == "write") {
	if ($response == "") {
		$underAttack = "no";
	} else {
	$underAttack = "yes";
	}
}

if ($action == "read") {
    $underAttack = "yes";
}




	if($_POST['email']) {


$type = "attackResponse";	
	
		if ( $email == $email ) {

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






//UPDATES ITEM USER

if ($action == "write") {

//$UpdateHS = "UPDATE users SET ".$type." = '".$response."' WHERE email = '".$attackingID."'";

$UpdateHS = "UPDATE users SET attackResponse = '".$response."', underAttack = '".$underAttack."'  WHERE email = '".$attackingID."'";
$sql_insert = $db->prepare($UpdateHS);
//$sql_insert->bindParam(":Level", $level);
$sql_insert->execute();


if ($sql_insert->error) {error_log("Error: " . $sql_insert->error); }

				$success = $sql_insert->affected_rows;

$playerResponse = $response;

}



if ($action == "read") {

$GameComments = "SELECT attackResponse FROM users WHERE email = '".$attackingID."'";

// ORDER BY DateTimeStamp DESC";
$stmt = $db->prepare($GameComments);
$stmt->execute();

$rows = $stmt->fetch(PDO::FETCH_ASSOC);
$playerResponse = $rows[attackResponse];

$success = 1;


$UpdateHS = "UPDATE users SET underAttack = '".$underAttack."'  WHERE email = '".$attackingID."'";
$sql_insert = $db->prepare($UpdateHS);
//$sql_insert->bindParam(":Level", $level);
$sql_insert->execute();

}

				/* close statement and connection */
				//$stmt2->close();

				/* close connection */
				//$db->close();
				error_log("Success: $success");

				if (1 == 0) {
						echo '{"success":0,"error_message":"Item Does Not Exist."}';
				} else {
                                 // error_log("User '$username' has been attacked.");
				   echo "{\"success\":1,\"response\":\"$playerResponse\"}";




				}
			
		} else {
			echo '{"success":0,"error_message":"Passwords does not match."}';
		}
	} else {
		echo '{"success":0,"error_message":"Invalid Item."}';
	}
} else {
	echo '{"success":0,"error_message":"Invalid Data."}';
}
?>