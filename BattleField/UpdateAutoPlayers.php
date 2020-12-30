<?php

//chmod("/usr/local/bin/php/home/clavenso/public_html/Apps/BattleField/UpdateAutoPlayers.php", 0755);
chmod("/var/www/html/Apps/BattleField/UpdateAutoPlayers.php", 0755);
///usr/local/bin/php/home/clavenso/public_html/Apps/BattleField/UpdateAutoPlayers.php
//omefile", 0755);


header('Content-type: application/json');

function float_rand($Min, $Max, $round=0){
    //validate input
    if ($min>$Max) { $min=$Max; $max=$Min; }
        else { $min=$Min; $max=$Max; }
    $randomfloat = $min + mt_rand() / mt_getrandmax() * ($max - $min);
    if($round>0)
        $randomfloat = round($randomfloat,$round);

    return $randomfloat;
}


//if($_GET) {
if (1 == 1) {
       //$username   = $_GET['username'];
       //$password   = $_GET['password'];
       $password = "jared01*";
      // $itemID = $_GET['itemID'];
      // $action = $_GET['action'];
       $action = "temp";
       $correctPassword = "jared01*";
       
       //$level = $_GET['level'];
       //$amount = $_GET['goldamount'];
       //$diamondsamount = $_GET['diamondsamount'];

//	if($_GET['password']) {
	if (1 == 1) {	
	
	
	/*
if($_POST) {
       $username   = $_POST['username'];
       $email   = $_POST['email'];
      // $itemID = $_POST['itemID'];
       $categoryTemp = $_POST['category'];
       $level = $_POST['level'];
       $amount = $_POST['goldamount'];


	if($_POST['email']) {
	
	*/
	
		if ( $password == $password ) {

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



if ($password == $correctPassword) {
//if ($_POST['category']) {
//if ($_GET['action']) {
if (1 == 1) {


$LocationInfo = "SELECT * FROM users WHERE (userControlled = 'auto')";

// AND category = '".$category."')";


$stmt = $db->prepare($LocationInfo);
$stmt->execute();

echo "{\"success\":1}";

while($rows = $stmt->fetch(PDO::FETCH_ASSOC)){

$rand_lat = 0;
$rand_long = 0;

$AutoUserLat = $rows[latitude];
$AutoUserLong = $rows[longitude];
$AutoUserAlt = $rows[altitude];

$RandomLat = array(float_rand(0.001, 0.01, 6) * -1, float_rand(0.001, 0.01, 6));
$RandomLong = array(float_rand(0.001, 0.01, 6) * -1, float_rand(0.001, 0.01, 6));
$RandomAlt = array(float_rand(0.001, 0.01, 6) * -1, float_rand(0.001, 0.01, 6));


$rand_lat = $RandomLat[array_rand($RandomLat)];
$rand_long = $RandomLong[array_rand($RandomLong)];
$rand_alt = $RandomAlt[array_rand($RandomAlt)];

//echo "Rand User Lat =".$rand_lat."\n";

//$NewUserLat = $AutoUserLat + float_rand(0.001, 0.01, 6);
$NewUserLat = $AutoUserLat + $rand_lat;
//$NewUserLong = $AutoUserLong + float_rand(0.001, 0.01, 6);
$NewUserLong = $AutoUserLong + $rand_long;

$NewUserAlt = $AutoUserAlt + $rand_alt;
//$NewUserAlt = 0.000000;

$AutoUserID = $rows[id];

//echo "random user number between 0.001 and 0.01 = ".$NewUserLat;

//echo "Start UserLat = ".$AutoUserLat."\n";
//echo "New UserLat = ".$NewUserLat."\n";
//echo "Start UserLong = ".$AutoUserLong."\n";
//echo "New UserLong = ".$NewUserLong."\n";


$UpdateAutoUserLocation = "UPDATE users SET latitude = ".$NewUserLat.", longitude = ".$NewUserLong.", altitude = ".$NewUserAlt."  WHERE id = '".$AutoUserID."'";
$sql_insert = $db->prepare($UpdateAutoUserLocation);
//$sql_insert->bindParam(":Level", $level);
$sql_insert->execute();

echo "UserID: ".$AutoUserID." New Location is [".$NewUserLat.",".$NewUserLong.",".$NewUserAlt."]\n";

}

/*
$UpdateGold = "UPDATE users SET ".$category."= ".$level." WHERE email = '".$email."'";
$sql_insert = $db->prepare($UpdateGold);
//$sql_insert->bindParam(":Level", $level);
$sql_insert->execute();
*/

} 

} else {
echo '{"success":0,"error_message":"You do not have the access to perform this action."}';
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
				//   echo "{\"success\":1}";




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