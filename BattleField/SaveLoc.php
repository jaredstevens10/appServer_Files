<?php


header('Content-type: application/json');

/*
if($_GET) {
	$username   = $_GET['username'];
	//$password   = $_GET['password'];
        $latitude = $_GET['latitude'];
        
        $longitude = $_GET['longitude'];
        $altitude = $_GET['altitude'];
	//$c_password = $_GET['c_password'];
	
	

	if($_GET['username']) {
	
	if ($username == "UnknownUsername") {
	echo '{"success":0,"error_message":"unknown username."}';
	exit;
	}
*/	
	
if($_POST) {
	$username   = $_POST['username'];
	//$password   = $_GET['password'];
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];
        $altitude = $_POST['altitude'];
        $token = $_POST['token'];   
        $lat = $latitude;
        $lon = $longitude;
        $alt = $altitude;
	//$c_password = $_POST['c_password'];
        $rad = "1";

        //$friendType = "cameras";
        //$targetType = "isTargetting";

	if($_POST['username']) {
	
	if ($username == "UnknownUsername") {
	echo '{"success":0,"error_message":"unknown username."}';
	exit;
	}
	
	
	
		if ( $username == $username ) {

//echo "connecting";

/*
			$db_name     = 'clavenso_GeoHunters';
			$db_user     = 'clavenso_Admin';
			$db_password = 'claven01*';
			 $server_url  = '181.224.137.57'; 
                       $server_url = 'localhost';
*/

			/* $mysqli = new mysqli('localhost', $clavenso_Admin, $claven01*, $clavenso_TestDB); */
                    
                   //  $mysqli = new mysqli($server_url, $db_user, $db_password, $db_name);
                   // $mysqli = new PDO($server_url, $db_user, $db_password, $db_name);


	require('/var/www/html/Apps/AppsConfig.php'); 
$dbname = "Stevens_GeoHunters";

define('DIR','http://'.$servername.'/Apps/BattleField/');
define('SITEEMAIL','admin@'.$emailServer.'.com');


try {

                       $db = new PDO("mysql:host=$servername;dbname=$dbname", $db_username, $db_password);
                       $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                       
if(!isset($error)){


$stmt3 = $db->prepare("UPDATE users SET username = :username, latitude = :lat, longitude = :long, DeviceToken = :token, altitude = :alt WHERE username = :username");
			$stmt3->execute(array(
			':username' => $username,
			':long' => $longitude,
			':lat' => $latitude,
                        ':token' => $token,
                        ':alt' => $altitude
			));

$row_count = $stmt3->rowCount();

if ($row_count > 0) {
$success = 1;
} else {
$success = 0;
}


/*
if ($username == "jaredstevens10") {

$time = date('Y-m-d H:i:s', time());

$stmt = $db->prepare("INSERT INTO TestTracking (username, latitude, longitude, time, altitude) VALUES (?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $username);
        $stmt->bindParam(2, $latitude);
        $stmt->bindParam(3, $longitude);
        $stmt->bindParam(4, $time);
        $stmt->bindParam(5, $altitude);
        

       
        $stmt->execute();
        //$UniqueID = $dbh->lastInsertId();
       // $success = $stmt->rowCount();

}

*/
















}


 }
catch(Exception $e)
{
         {
            echo '{"success":0,"error_message":'.$e->getMessage().'}';
         }
        
        
}


                                if ($success > 0) {
					//error_log("User '$username' created.");
					//echo '{"success":1}';
					
					
					
//   $R = 6371;  // earth's mean radius, km
    $R = 3959;  // earth's mean radius, miles

    // first-cut bounding box (in degrees)
    $maxLat = $lat + rad2deg($rad/$R);
    $minLat = $lat - rad2deg($rad/$R);

    // compensate for degrees longitude getting smaller with increasing latitude
    $maxLon = $lon + rad2deg($rad/$R/cos(deg2rad($lat)));
    $minLon = $lon - rad2deg($rad/$R/cos(deg2rad($lat)));

// $LocationInfo = "Select id, username, latitude, longitude, type WHERE latitude >= 27";


$LocationInfo = "Select id, imageName, name, latitude, longitude, altitude, type, username, code, isAvailable, acos(sin(:lat)*sin(radians(latitude)) + cos(:lat)*cos(radians(latitude))*cos(radians(longitude)-:lon)) * :R As D From (Select id, imageName, name, latitude, longitude, altitude, type, username, code, isAvailable From GameItems Where latitude Between :minLat And :maxLat And longitude Between :minLon And :maxLon And isAvailable = \"yes\") As FirstCut Where acos(sin(:lat)*sin(radians(latitude)) + cos(:lat)*cos(radians(latitude))*cos(radians(longitude)-:lon)) * :R < :rad Order by D";


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


echo "{\"success\":1,\"items\":[";



$TotalItems = 0;

while($rows = $points->fetch(PDO::FETCH_ASSOC)){

$TotalItems = $TotalItems + 1;

$username2 =  $point->username;
$lat2 =  $point->latitude;
$long2 =  $point->longitude;
$health2 =  $point->health;
$stealth2 =  $point->stealth;


echo "{\"id\": \"$rows[id]\",\"name\": \"$rows[name]\", \"latitude\": \"$rows[latitude]\", \"longitude\": \"$rows[longitude]\", \"altitude\": \"$rows[altitude]\", \"type\": \"$rows[type]\", \"isAvailable\": \"$rows[isAvailable]\", \"code\": \"$rows[code]\", \"username\": \"$rows[username]\", \"speed\": \"$rows[speed]\", \"power\": \"$rows[power]\", \"range\": \"$rows[range]\", \"category\": \"$rows[category]\", \"imagename\":\"$rows[imageName]\"},";


}


echo "{\"id\": \"0\",\"name\": \"dummy\", \"latitude\": \"28.683860\", \"longitude\": \"-81.263624\", \"altitude\": \"0.0\", \"type\": \"NA\", \"isAvailable\": \"no\", \"type\": \"NA\", \"username\": \"NA\", \"speed\": \"NA\", \"power\": \"NA\", \"range\": \"NA\", \"category\": \"NA\", \"imagename\":\"NA\"}],\"totalitems\":$TotalItems}";






					
					
				} else {
					echo '{"success":0,"error_message":"No Location Change."}';
				}

} else {
echo '{"success":0,"error_message":"match error."}';
}

} else {
echo '{"success":0,"error_message":"username error."}';
}
			
} else {
echo '{"success":0,"error_message":"Network Error."}';
}



?>