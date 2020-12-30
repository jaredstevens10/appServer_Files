<?php


header('Content-type: application/json');
if($_POST) {
//if($_GET) {
$username   = $_POST['username'];
$category   = $_POST['category'];
$email   = $_POST['email'];

//$username   = $_GET['username'];
//$email   = $_GET['email'];
//$category   = $_GET['category'];
//$username   = $_GET['username'];
//$category   = $_GET['category'];
	
	//$c_password = $_POST['c_password'];

	if($_POST['email']) {
//if($_GET['username']) {
//if($_GET['email']) {
		if ( $email == $email ) {

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


//$LocationInfo = "SELECT * FROM GameItems WHERE (username = '".$username."' AND category = '".$category."')";


$LocationInfo = "SELECT * FROM users WHERE email = '".$email."'";

// ORDER BY DateApt ASC, TimeApt ASC";

$stmt = $db->prepare($LocationInfo);
$stmt->execute();

//$c = $stmt->fetch(PDO::FETCH_ASSOC);
//$c = $stmt->fetch(mysqli_stmt::fetch);
//$stmt = $mysqli->query($LocationInfo);
//$stmt->execute();
//$C = $stmt->fetch(PDO::FETCH_ASSOC);
//$C = $stmt->fetchall();


echo"{\"success\":1,\"Items\":[";

while($rows = $stmt->fetch(PDO::FETCH_ASSOC)){







$AttributeData = $rows[attributes];

$AttributeArray = json_decode(json_encode($AttributeData), true);
$manage_attribute_array = get_object_vars(json_decode($AttributeData));



foreach ($manage_attribute_array['data'] as $key=>$value) {

$ID = $value->id;

foreach ($value->info as $idKey=>$idValue) {

$AttributeAwareness = $idValue->awareness;
$AttributeCharisma = $idValue->charisma;
$AttributeCredibility = $idValue->credibility;
$AttributeEndurance = $idValue->endurance;
$AttributeIntelligence = $idValue->intelligence;
$AttributeSpeed = $idValue->speed;
$AttributeStrength = $idValue->strength;
$AttributeVision = $idValue->vision;

//$DescriptionData = base64_encode($Description);
//$TitleData = base64_encode($Title);

}

}




$WasAttacked = $rows[wasAttacked];

//print_r($row);
//$latitude = $stmt->fetchColumn();

//print_r($rows);

//echo "{\"id\":\"$rows[id]\",\"name\":\"$rows[name]\",\"type\":\"$rows[type]\",\"category\":\"$rows[category]\",\"power\":\"$rows[power]\",\"range\":\"$rows[range]\",\"speed\":\"$rows[speed]\"},";

echo "{\"id\":\"$rows[id]\",\"username\":\"$rows[username]\",\"email\":\"$rows[email]\",\"latitude\":\"$rows[latitude]\",\"longitude\":\"$rows[longitude]\",\"altitude\":\"$rows[altitude]\",\"health\":\"$rows[health]\",\"level_armor_body\":\"$rows[level_armor_body]\",\"level_armor_helmet\":\"$rows[level_armor_helmet]\",\"level_armor_boots\":\"$rows[level_armor_boots]\",\"level_weapon_fist\":\"$rows[level_weapon_fist]\",\"team\":\"$rows[team]\",\"gold\":\"$rows[gold]\",\"shield_level\":\"$rows[shield_level]\",\"wasAttacked\":\"$rows[wasAttacked]\",\"attackedtimedate\":\"$rows[AttackedTimeDate]\",\"stamina\":\"$rows[stamina]\",\"diamonds\":\"$rows[diamonds]\",\"healthPotionCount\":\"$rows[healthPotionCount]\",\"healthPotionMax\":\"$rows[healthPotionMax]\",\"staminaPotionCount\":\"$rows[staminaPotionCount]\",\"staminaPotionMax\":\"$rows[staminaPotionMax]\",\"userLevel\":\"$rows[level]\",\"userXP\":\"$rows[xp]\",\"AttributeAwareness\":\"$AttributeAwareness\",\"AttributeCharisma\":\"$AttributeCharisma\",\"AttributeCredibility\":\"$AttributeCredibility\",\"AttributeEndurance\":\"$AttributeEndurance\",\"AttributeIntelligence\":\"$AttributeIntelligence\",\"AttributeSpeed\":\"$AttributeSpeed\",\"AttributeStrength\":\"$AttributeStrength\",\"AttributeVision\":\"$AttributeVision\",\"attributePoints\":\"$rows[attributePoints]\"},";

//  ,\"Turn5\":\"$rows[Turn5]\"
//  ,\"phone\":\"NA\"

//echo "{\"customername\": \"$rows[customername]\"";
//, \"DateApt\":\"$rows[DateApt]\",\"TimeApt\":\"$rows[DateTime]\",";


}

echo "{\"id\":\"0\",\"name\":\"NA\",\"type\":\"NA\",\"category\":\"NA\"}]}";





$C = $stmt->fetch(PDO::FETCH_ASSOC);



if ($WasAttacked == "yes") {

$No = "no";

$UpdateGold = "UPDATE users SET wasAttacked= :No WHERE email = '".$email."'";
$sql_insert = $db->prepare($UpdateGold);
$sql_insert->bindParam(":No", $No);
$sql_insert->execute();

}

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
