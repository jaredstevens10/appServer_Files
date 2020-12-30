<?php

header('Content-type: application/json');

/*
if($_GET) {
//$gameid   = $_POST['gameid'];
$email   = $_GET['email'];
*/


if($_POST) {
//$gameid   = $_POST['gameid'];
$email   = $_POST['email'];


$itemType   = $_POST['itemType'];


//$friendType   = $_POST['type'];
$friendType = "userTerritory";


		require('/var/www/html/Apps/AppsConfig.php'); 
$dbname = "Stevens_GeoHunters";

define('DIR','http://'.$servername.'/Apps/BattleField/');
define('SITEEMAIL','admin@'.$emailServer.'.com');


try {

	//create PDO connection 
	//$db = new PDO("mysql:host=".DBHOST.";port=8889;dbname=".DBNAME, DBUSER, DBPASS);
	$db = new PDO("mysql:host=$servername;dbname=$dbname", $db_username, $db_password);


	//if no errors have been created carry on
	if(!isset($error)){

		//create the activasion code
		$token = md5(uniqid(rand(),true));



$stmtF = $db->prepare("Select ".$friendType." FROM users WHERE email = \"".$email."\"");
$stmtF->execute();
$rowF = $stmtF->fetch(PDO::FETCH_ASSOC);
$FriendsData = $rowF[$friendType];
$FriendsArray = json_decode(json_encode($FriendsData), true);

$manage_array = get_object_vars(json_decode($FriendsData));


//echo"{\"success\":1,".$FriendsArray."}";
//exit;
//$rowStatus = $stmt->fetch(PDO::FETCH_ASSOC);
//$commentsReturned = $rowStatus['comments'];



echo"{\"success\":1,\"Data\":[";

foreach ($manage_array['data'] as $key=>$value) {

$locationID = $value->id;

foreach ($value->info as $idKey=>$idValue) {


foreach ($idValue->Point1 as $pointKey=>$pointValue) {
$PointLat1 = $pointValue->latitude;
$PointLong1 = $pointValue->longitude;
//$PointAlt1 = $pointValue->altitude;
}


foreach ($idValue->Point2 as $pointKey=>$pointValue) {
$PointLat2 = $pointValue->latitude;
$PointLong2 = $pointValue->longitude;
}

foreach ($idValue->Point3 as $pointKey=>$pointValue) {
$PointLat3 = $pointValue->latitude;
$PointLong3 = $pointValue->longitude;
}

foreach ($idValue->Point4 as $pointKey=>$pointValue) {
$PointLat4 = $pointValue->latitude;
$PointLong4 = $pointValue->longitude;
}

foreach ($idValue->Point5 as $pointKey=>$pointValue) {
$PointLat5 = $pointValue->latitude;
$PointLong5 = $pointValue->longitude;
}

}

echo "{\"id\":\"$locationID\",\"PointLat1\":\"$PointLat1\",\"PointLong1\":\"$PointLong1\",\"PointLat2\":\"$PointLat2\",\"PointLong2\":\"$PointLong2\",\"PointLat3\":\"$PointLat3\",\"PointLong3\":\"$PointLong3\",\"PointLat4\":\"$PointLat4\",\"PointLong4\":\"$PointLong4\",\"PointLat5\":\"$PointLat5\",\"PointLong5\":\"$PointLong5\"},";

}

echo "{\"id\":\"NA\",\"PointLat1\":\"NA\"}]}";

Exit;


/*
while($rows = $stmt->fetch(PDO::FETCH_ASSOC)){
$CommentData = base64_encode($rows[comment]);
echo "{\"id\":\"$rows[id]\",\"gameid\":\"$rows[gameid]\",\"username\":\"$rows[username]\",\"date\":\"$rows[datestamp]\",\"comment\":\"$CommentData\",\"datetimestamp\":\"$rows[DateTimeStamp]\",\"userid\":\"$rows[PlayerID]\"},";
}
echo "{\"id\":\"NA\",\"gameid\":\"NA\",\"username\":\"NA\",\"date\":\"NA\",\"comment\":\"NA\",\"userid\":\"NA\"}]}";
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
				//	error_log("User '$username' created.");
					//echo '{"success":1,"comments":$commentsReturned}';
//echo "{\"success\":1,\"comments\":\"$commentsReturned\"}";


				} else {
					//echo '{"success":2,"error_message":"No Status Change."}';
				}
	
} else {
    
    echo '{"success":0,"error_message":"Invalid Data."}';
    
}


?>