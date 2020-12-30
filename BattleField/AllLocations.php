<?php


header('Content-type: application/json');
//username=jaredstevens10&latitude=28.7062162545839&longitude=-81.2831355824369&radius=2

/*
if($_GET) {
	$username   = $_GET['username'];
	$rad   = $_GET['radius'];
        $lat = $_GET['latitude'];
$lon = $_GET['longitude'];


	//$c_password = $_POST['c_password'];

	if($_GET['username']) {

*/

if($_POST) {
	$username   = $_POST['username'];
	$rad   = $_POST['radius'];
        $lat = $_POST['latitude'];
	$lon = $_POST['longitude'];
	//$c_password = $_POST['c_password'];

	if($_POST['username']) {
	
	
	
	
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



//   $R = 6371;  // earth's mean radius, km
 $R = 3959;  // earth's mean radius, miles

    // first-cut bounding box (in degrees)
    $maxLat = $lat + rad2deg($rad/$R);
    $minLat = $lat - rad2deg($rad/$R);

    // compensate for degrees longitude getting smaller with increasing latitude
    $maxLon = $lon + rad2deg($rad/$R/cos(deg2rad($lat)));
    $minLon = $lon - rad2deg($rad/$R/cos(deg2rad($lat)));

// $LocationInfo = "Select id, username, latitude, longitude, health Where latitude >= 27";




 $LocationInfo = "Select id, email, imageName, username, latitude, longitude, altitude, health, gold, stamina, wasAttacked, AttackedTimeDate, team, level_armor_body, level_armor_helmet, level_armor_boots, shield_level, level, stealth, attributes, skills, killCount, killedCount, xp, acos(sin(:lat)*sin(radians(latitude)) + cos(:lat)*cos(radians(latitude))*cos(radians(longitude)-:lon)) * :R As D From (Select id, email, imageName, username, latitude, longitude, altitude, health, gold, stamina, wasAttacked, AttackedTimeDate, team, level_armor_body, level_armor_helmet, level_armor_boots, shield_level, level, stealth, attributes, skills, killCount, killedCount, xp From users Where latitude Between :minLat And :maxLat And longitude Between :minLon And :maxLon) As FirstCut Where acos(sin(:lat)*sin(radians(latitude)) + cos(:lat)*cos(radians(latitude))*cos(radians(longitude)-:lon)) * :R < :rad Order by D";


$params = array(
        'lat'    => deg2rad($lat),
        'lon'    => deg2rad($lon),
        'minLat' => $minLat,
        'minLon' => $minLon,
        'maxLat' => $maxLat,
        'maxLon' => $maxLon,
        'rad'    => $rad,
        'R'      => $R,
    );
    $points = $db->prepare($LocationInfo);
    $points->execute($params);



echo"{\"success\":1,\"members\":[";



$imageName = "BlackHatUser";
while($rows = $points->fetch(PDO::FETCH_ASSOC)){

//echo "'" . $rows["username"] . "',";
//echo "<br>";

$username2 =  $point->username;
$lat2 =  $point->latitude;
$long2 =  $point->longitude;
$health2 =  $point->health;
$stealth2 =  $point->stealth;

$imageName = "BlackHatUser";





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







echo "{\"username\": \"$rows[username]\",\"playerid\": \"$rows[email]\", \"latitude\": \"$rows[latitude]\", \"longitude\": \"$rows[longitude]\", \"altitude\": \"$rows[altitude]\", \"health\": \"$rows[health]\", \"stealth\": \"$rows[stealth]\", \"gold\":\"$rows[gold]\", \"wasAttacked\":\"$rows[wasAttacked]\", \"AttackedTimeDate\":\"$rows[AttackedTimeDate]\", \"team\":\"$rows[team]\", \"level_armor_body\":\"$rows[level_armor_body]\", \"level_armor_helmet\":\"$rows[level_armor_helmet]\", \"level_armor_boots\":\"$rows[level_armor_boots]\", \"shield_level\":\"$rows[shield_level]\", \"level\":\"$rows[level]\",\"stamina\":\"$rows[stamina]\",\"AttributeAwareness\":\"$AttributeAwareness\",\"AttributeCharisma\":\"$AttributeCharisma\",\"AttributeCredibility\":\"$AttributeCredibility\",\"AttributeEndurance\":\"$AttributeEndurance\",\"AttributeIntelligence\":\"$AttributeIntelligence\",\"AttributeSpeed\":\"$AttributeSpeed\",\"AttributeStrength\":\"$AttributeStrength\",\"AttributeVision\":\"$AttributeVision\",\"xp\":\"$rows[xp]\",\"killcount\":\"$rows[killCount]\",\"killedcount\":\"$rows[killedCount]\"},";

//echo "{\"username\": \"$username2\", \"latitude\": \"$lat2\", \"longitude\": \"$long2\", \"health\": \"$health2\", \"stealth\": \"$stealth2\", \"stealth\": \"$stealth2\",\"imagename\":\"$rows[imageName]\"},";


//endforeach;
}


echo "{\"username\": \"dummy\", \"latitude\": \"28.683860\", \"longitude\": \"-81.263624\", \"health\": \"100\", \"stealth\": \"no\", \"imagename\": \"$imageName\"}]}";




//$result = $stmt->fetchAll();
//print_r($result);
//echo $c;

//$stmt = $mysqli->query($LocationInfo);
//$stmt->execute();
//$C = $stmt->fetch(PDO::FETCH_ASSOC);
//$latitude = $stmt->fetchColumn();

//print_r($c);

//$userlatitude = $C['latitude'];
//$userlongitude = $C['longitude'];


//$stmt->bind_Param('sss',$username,$latitude,$longitude);



				if ($stmt->error) {error_log("Error: " . $stmt->error); }

				$success = $stmt->affected_rows;

				/* close statement and connection */
				//$stmt->close();

				/* close connection */
				//$db->close();
				error_log("Success: $success");

				if ($userlatitude != "") {
				//		echo '{"success":0,"error_message":"Username Exist."}';
				} else {
                                  error_log("User '$username' created.");
				//	echo "{\"success\":1,\"Latitude\":$userlatitude,\"Longitude\":$userlongitude}";
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
