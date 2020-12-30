<?php


header('Content-type: application/json');


if($_POST) {
	$username   = $_POST['username'];
	$rad   = $_POST['radius'];
        $lat = $_POST['latitude'];
        $lon = $_POST['longitude'];
        $alt = $_POST['altitude'];

/*
if($_GET) {
        $username   = $_GET['username'];
	$rad   = $_GET['radius'];
        $lat = $_GET['latitude'];
        $lon = $_GET['longitude'];

        if($_GET['username']) {
*/


	if($_POST['username']) {
		if ( $username == $username ) {


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

//$LocationInfo = "Select id, username, latitude, longitude, health Where latitude >= 27";


  $LocationInfo = "Select id, teamName, members, missions, level, health, admins, latitude, longitude, altitude, acos(sin(:lat)*sin(radians(latitude)) + cos(:lat)*cos(radians(latitude))*cos(radians(longitude)-:lon)) * :R As D From (Select id, teamName, members, missions, level, health, admins, latitude, longitude, altitude From TeamInfo Where latitude Between :minLat And :maxLat And longitude Between :minLon And :maxLon) As FirstCut Where acos(sin(:lat)*sin(radians(latitude)) + cos(:lat)*cos(radians(latitude))*cos(radians(longitude)-:lon)) * :R < :rad Order by D";


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


//$LocationInfo = "SELECT * FROM LocationData WHERE username = '" . $username . "'";
//ORIGINAL  $LocationInfo = "SELECT username, latitude, longitude, health FROM LocationData";





//ORIGINAL $stmt = $db->prepare($LocationInfo);
//ORIGINAL $stmt->execute();



//$c = $stmt->fetchAll(PDO::FETCH_ASSOC);
//$c = $stmt->fetch(mysqli_stmt::fetch);

   // var_dump($c);

echo"{\"success\":1,\"Data\":[";

//foreach ($points as $point):

//ORIGINAL while($rows = $stmt->fetch(PDO::FETCH_ASSOC)){



$imageName = "BlackHatUser";
while($rows = $points->fetch(PDO::FETCH_ASSOC)){

//echo "'" . $rows["username"] . "',";
//echo "<br>";

$username2 =  $point->teamName;
$lat2 =  $point->latitude;
$long2 =  $point->longitude;
$health2 =  $point->health;
$stealth2 =  $point->stealth;
$members = "";
$missions = "";
$admins = "";

$imageName = "BlackHatUser";




echo "{\"id\": \"$rows[id]\",\"teamname\": \"$rows[teamName]\", \"latitude\": \"$rows[latitude]\", \"longitude\": \"$rows[longitude]\", \"altitude\": \"$rows[altitude]\", \"level\": \"$rows[level]\",\"health\":\"$rows[health]\",\"members\":[";

//echo "{\"username\": \"$username2\", \"latitude\": \"$lat2\", \"longitude\": \"$long2\", \"health\": \"$health2\", \"stealth\": \"$stealth2\", \"stealth\": \"$stealth2\",\"imagename\":\"$rows[imageName]\"},";


//endforeach;




//echo "{\"id\": \"NA\",\"teamname\": \"NA\", \"latitude\": \"28.683860\", \"longitude\": \"-81.263624\", \"health\": \"100\", \"level\": \"1\",\"members\":[";



$MemberData = $rows[members];
$MembersArray = json_decode(json_encode($MemberData), true);
$manage_array = get_object_vars(json_decode($MemberData));

foreach ($manage_array['data'] as $key=>$value) {

$MemberID = $value->id;
//echo "LOCATION ID ".$locationID;
foreach ($value->info as $idKey=>$idValue) {


foreach ($idValue->location as $locationKey=>$locationValue) {
$MemberPointLat = $locationValue->latitude;
$MemberPointLong = $locationValue->longitude;
$MemberPointAlt = $locationValue->altitude;
}

$MemberUsername = $idValue->username;
$MemberEmail = $idValue->email;
$MemberTitle = $idValue->title;
$MemberStatus = $idValue->status;


}

echo "{\"id\":\"$MemberID\",\"name\":\"$MemberUsername\",\"latitude\":\"$MemberPointLat\",\"longitude\":\"$MemberPointLong\",\"altitude\":\"$MemberPointAlt\",\"status\":\"$MemberStatus\",\"title\":\"$MemberTitle\"},";


//,\"level\":\"$MemberLevel\"

}



echo "{\"id\":\"NA\",\"latitude\":\"NA\"}],\"admins\":[";





$AdminData = $rows[admins];
$AdminArray = json_decode(json_encode($AdminData), true);
$admin_manage_array = get_object_vars(json_decode($AdminData));

foreach ($admin_manage_array['data'] as $key=>$value) {

$AdminID = $value->id;
//echo "LOCATION ID ".$locationID;
foreach ($value->info as $idKey=>$idValue) {

/*
foreach ($idValue->location as $locationKey=>$locationValue) {
$AdminPointLat = $locationValue->latitude;
$AdminPointLong = $locationValue->longitude;
}
*/

$AdminUsername = $idValue->username;
$AdminEmail = $idValue->email;

}

echo "{\"id\":\"$AdminID\",\"name\":\"$AdminUsername\",\"email\":\"$AdminEmail\"},";


//,\"level\":\"$MemberLevel\"

}



$MissionData = $rows[missions];
$MissionArray = json_decode(json_encode($MissionData), true);
$mission_manage_array = get_object_vars(json_decode($MissionData));


echo "{\"id\":\"NA\",\"latitude\":\"NA\"}],\"missions\":[";



foreach ($mission_manage_array['data'] as $key=>$value) {

$locationID = $value->id;
//echo "LOCATION ID ".$locationID;
foreach ($value->info as $idKey=>$idValue) {


foreach ($idValue->location as $locationKey=>$locationValue) {
$PointLat = $locationValue->latitude;
$PointLong = $locationValue->longitude;
$PointAlt = $locationValue->altitude;
}

$MissionStatus = $idValue->status;
$MissionLevel = $idValue->level;
$MissionObjective = $idValue->objective;
$MissionXP = $idValue->xp;
$MissionMapURL = $idValue->imageURL;
$MissionName = $idValue->name;
$MissionCategory = $idValue->category;
$CategoryTitle = $idValue->categoryTitle;

}

echo "{\"id\":\"$locationID\",\"name\":\"$MissionName\",\"latitude\":\"$PointLat\",\"longitude\":\"$PointLong\",\"altitude\":\"$PointAlt\",\"status\":\"$MissionStatus\",\"level\":\"$MissionLevel\",\"objective\":\"$MissionObjective\",\"xp\":\"$MissionXP\",\"imageURL\":\"$MissionMapURL\",\"category\":\"$MissionCategory\",\"categoryTitle\":\"$CategoryTitle\"},";



}

echo "{\"id\":\"NA\",\"latitude\":\"NA\"}]},";


}

echo "{\"id\":\"NA\",\"latitude\":\"NA\"}]}";

//echo "]}";



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
			echo '{"success":0,"error_message":"No Teams Match."}';
		}
	} else {
		echo '{"success":0,"error_message":"Invalid Username."}';
	}
}else {
	echo '{"success":0,"error_message":"Invalid Data."}';
}
?>
