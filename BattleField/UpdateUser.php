<?php

header('Content-type: application/json');
/*
if($_GET) {
       $username   = $_GET['username'];
       $email   = $_GET['email'];
      // $itemID = $_GET['itemID'];
       $categoryTemp = $_GET['category'];
       $level = $_GET['level'];
       $amount = $_GET['goldamount'];
       $diamondsamount = $_GET['diamondsamount'];

$attributePoints = $_GET['attributePoints'];




	if($_GET['email']) {
	
	*/
	
	
if($_POST) {
       $username   = $_POST['username'];
       $email   = $_POST['email'];
      // $itemID = $_POST['itemID'];
       $categoryTemp = $_POST['category'];
       $level = $_POST['level'];
       $amount = $_POST['goldamount'];
       $attributePoints = $_POST['attributePoints'];

	if($_POST['email']) {
	
	
	
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

if ($_POST['goldamount']) {
//if ($_GET['goldamount']) {

$UpdateGold = "UPDATE users SET gold= :GoldAmount WHERE email = '".$email."'";
$sql_insert = $db->prepare($UpdateGold);
$sql_insert->bindParam(":GoldAmount", $amount);
$sql_insert->execute();

}


if ($_POST['attributePoints']) {

$UpdateAttribute = "UPDATE users SET attributePoints= :attributePoints WHERE email = '".$email."'";
$sql_insert = $db->prepare($UpdateAttribute);
$sql_insert->bindParam(":attributePoints", $attributePoints);
$sql_insert->execute();

}



if ($_POST['diamondsamount']) {
//if ($_GET['goldamount']) {

$UpdateGold = "UPDATE users SET diamonds= :DiamondsAmount WHERE email = '".$email."'";
$sql_insert = $db->prepare($UpdateGold);
$sql_insert->bindParam(":DiamondsAmount", $diamondsamount);
$sql_insert->execute();

}


if ($_POST['potionamount']) {
//if ($_GET['goldamount']) {

$NewPotionAmount = $_POST['potionamount'];
$PotionType = $_POST['type'];
$PotionSetting = $_POST['info'];

if ($PotionType == "health") {

   if ($PotionSetting == "count") {
     $PotionInsertType = "healthPotionCount";
   } else {
     $PotionInsertType = "healthPotionMax";
   }

}


if ($PotionType == "stamina") {

   if ($PotionSetting == "count") {
     $PotionInsertType = "staminaPotionCount";
   } else {
     $PotionInsertType = "staminaPotionMax";
   }

}


$UpdatePotion = "UPDATE users SET ".$PotionInsertType."= :PotionAmount WHERE email = '".$email."'";
$sql_insert = $db->prepare($UpdatePotion);
$sql_insert->bindParam(":PotionAmount", $NewPotionAmount);
$sql_insert->execute();

}


if ($_POST['category']) {
//if ($_GET['category']) {


if ($categoryTemp == "Boots") {
$category = "level_armor_boots";
}

if ($categoryTemp == "Shield") {
$category = "shield_level";
}

if ($categoryTemp == "Helmet") {
$category = "level_armor_helmet";
}

if ($categoryTemp == "Body") {
$category = "level_armor_body";
}

$UpdateGold = "UPDATE users SET ".$category."= ".$level." WHERE email = '".$email."'";
$sql_insert = $db->prepare($UpdateGold);
//$sql_insert->bindParam(":Level", $level);
$sql_insert->execute();

}


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