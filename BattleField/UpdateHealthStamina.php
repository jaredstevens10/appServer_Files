<?php

header('Content-type: application/json');

/*
if($_GET) {
       //$username   = $_GET['username'];
       $email   = $_GET['email'];
      // $itemID = $_GET['itemID'];
       $type = $_GET['type'];
       $amount = $_GET['amount'];
      
     if($_GET['email']) {
	
	*/
	
if($_POST) {
      // $username   = $_POST['username'];
       $email   = $_POST['email'];
      // $itemID = $_POST['itemID'];
       $type = $_POST['type'];
       $amount = $_POST['amount'];
       //$amount = $_POST['amount'];


	if($_POST['email']) {
	

	
	
		if ( $email == $email ) {

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






//UPDATES ITEM USER



$UpdateHS = "UPDATE users SET ".$type." = ".$amount." WHERE email = '".$email."'";
$sql_insert = $db->prepare($UpdateHS);
//$sql_insert->bindParam(":Level", $level);
$sql_insert->execute();




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
                                 // error_log("User '$username' has been attacked.");
				   echo "{\"success\":1}";




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