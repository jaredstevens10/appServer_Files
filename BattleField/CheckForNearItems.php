<?php


//header('Content-type: application/json');


if($_POST) {
	$username   = $_POST['username'];
        $email   = $_POST['email'];
	//$rad   = $_POST['radius'];
        $rad = "1";
        $lat = $_POST['latitude'];
        $lon = $_POST['longitude'];
	//$c_password = $_POST['c_password'];

	if($_POST['username']) {
/*

if($_GET) {
	$username   = $_GET['username'];
        $email   = $_GET['email'];
	//$rad   = $_GET['radius'];
        $rad = "1";
        $lat = $_GET['latitude'];
        $lon = $_GET['longitude'];
	//$c_password = $_POST['c_password'];

	if($_GET['email']) {

*/

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



//   $R = 6371;  // earth's mean radius, km
    $R = 3959;  // earth's mean radius, miles

    // first-cut bounding box (in degrees)
    $maxLat = $lat + rad2deg($rad/$R);
    $minLat = $lat - rad2deg($rad/$R);

    // compensate for degrees longitude getting smaller with increasing latitude
    $maxLon = $lon + rad2deg($rad/$R/cos(deg2rad($lat)));
    $minLon = $lon - rad2deg($rad/$R/cos(deg2rad($lat)));

// $LocationInfo = "Select id, username, latitude, longitude, type WHERE latitude >= 27";


$LocationInfo = "Select id, imageName, name, latitude, longitude, type, username, code, isAvailable, acos(sin(:lat)*sin(radians(latitude)) + cos(:lat)*cos(radians(latitude))*cos(radians(longitude)-:lon)) * :R As D From (Select id, imageName, name, latitude, longitude, type, username, code, isAvailable From GameItems Where latitude Between :minLat And :maxLat And longitude Between :minLon And :maxLon And isAvailable = \"yes\") As FirstCut Where acos(sin(:lat)*sin(radians(latitude)) + cos(:lat)*cos(radians(latitude))*cos(radians(longitude)-:lon)) * :R < :rad Order by D";


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

echo "{\"success\":1,\"items\":[";


//foreach ($points as $point):
//ORIGINAL while($rows = $stmt->fetch(PDO::FETCH_ASSOC)){


while($rows = $points->fetch(PDO::FETCH_ASSOC)){

//echo "'" . $rows["username"] . "',";
//echo "<br>";

$username2 =  $point->username;
$lat2 =  $point->latitude;
$long2 =  $point->longitude;
$health2 =  $point->health;
$stealth2 =  $point->stealth;


echo "{\"id\": \"$rows[id]\",\"name\": \"$rows[name]\", \"latitude\": \"$rows[latitude]\", \"longitude\": \"$rows[longitude]\", \"type\": \"$rows[type]\", \"isAvailable\": \"$rows[isAvailable]\", \"code\": \"$rows[code]\", \"username\": \"$rows[username]\", \"speed\": \"$rows[speed]\", \"power\": \"$rows[power]\", \"range\": \"$rows[range]\", \"category\": \"$rows[category]\", \"imagename\":\"$rows[imageName]\"},";

//echo "{\"username\": \"$username2\", \"latitude\": \"$lat2\", \"longitude\": \"$long2\", \"health\": \"$health2\", \"stealth\": \"$stealth2\"},";


//endforeach;
}


echo "{\"id\": \"0\",\"name\": \"dummy\", \"latitude\": \"28.683860\", \"longitude\": \"-81.263624\", \"type\": \"NA\", \"isAvailable\": \"no\", \"type\": \"NA\", \"username\": \"NA\", \"speed\": \"NA\", \"power\": \"NA\", \"range\": \"NA\", \"category\": \"NA\", \"imagename\":\"NA\"}]}";


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