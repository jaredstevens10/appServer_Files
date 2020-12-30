<?php

header('Content-type: application/json');

/*
if($_GET) {
//$gameid   = $_POST['gameid'];
$email   = $_GET['email'];
$level   = $_GET['level'];
$status   = $_GET['status'];
$background   = $_GET['background'];
*/



if($_POST) {
//$gameid   = $_POST['gameid'];
$email   = $_POST['email'];
$level   = $_POST['level'];
$status   = $_POST['status'];
$background   = $_POST['background'];


$itemType   = $_POST['itemType'];


//$friendType   = $_POST['type'];
$friendType = "cameras";
$targetType = "isTargetting";


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



$stmtF = $db->prepare("Select ".$targetType." FROM users WHERE email = \"".$email."\"");
$stmtF->execute();
$rowF = $stmtF->fetch(PDO::FETCH_ASSOC);
$FriendsData = $rowF[$targetType];


$FriendsArray = json_decode(json_encode($FriendsData), true);


//print_r ($FriendsArray);
$manage_array = get_object_vars(json_decode($FriendsData));


//print_r($manage_array);

//echo"{\"success\":1,".$FriendsArray."}";
//exit;
//$rowStatus = $stmt->fetch(PDO::FETCH_ASSOC);
//$commentsReturned = $rowStatus['comments'];



echo"{\"success\":1,\"Data\":[";

$TotalCameras = 0;

$UsersTargetting = array();

foreach ($manage_array['data'] as $key=>$value) {

$locationID = $value->id;
//echo "LOCATION ID ".$locationID;
foreach ($value->info as $idKey=>$idValue) {


foreach ($idValue->location as $locationKey=>$locationValue) {
$PointLat = $locationValue->latitude;
$PointLong = $locationValue->longitude;
$PointAlt = $locationValue->altitude;
}

$TargetName = $idValue->targetname;
$TargetID = $idValue->targetID;


if ($TargetID != "NA") {
$UsersTargetting[] = $TargetID;
}



/*
$MissionStatus = $idValue->status;
$MissionLevel = $idValue->level;
$TargetName = $idValue->targetname;
$TargetID = $idValue->targetID;
$StartTime = $idValue->startTime;
$EndTime = $idValue->endTime;
$OwnerName = $idValue->ownername;
$OwnerID = $idValue->ownerID;
$Range = $idValue->range;
*/

}


//print_r ($UsersTargetting);

foreach ($UsersTargetting as $User) {

//echo "the userID = " .$User;





$stmtF = $db->prepare("Select ".$friendType." FROM users WHERE email = \"".$User."\"");
$stmtF->execute();
$rowF = $stmtF->fetch(PDO::FETCH_ASSOC);
$FriendsData = $rowF[$friendType];

//echo $FriendsData;
$FriendsArray = json_decode(json_encode($FriendsData), true);

//print_r ($FriendsArray);

$manage_array = get_object_vars(json_decode($FriendsData));



//echo"{\"success\":1,\"Data\":[";


foreach ($manage_array['data'] as $key=>$value) {

$locationID = $value->id;
//echo "LOCATION ID ".$locationID;
foreach ($value->info as $idKey=>$idValue) {


$TargetID = $idValue->targetID;

if ($TargetID == $email) {

$TotalCameras = $TotalCameras + 1;

foreach ($idValue->location as $locationKey=>$locationValue) {
$PointLat = $locationValue->latitude;
$PointLong = $locationValue->longitude;
$PointAlt = $locationValue->altitude;
}

$MissionStatus = $idValue->status;
$MissionLevel = $idValue->level;
$TargetName = $idValue->targetname;
$TargetID = $idValue->targetID;
$StartTime = $idValue->startTime;
$EndTime = $idValue->endTime;
$OwnerName = $idValue->ownername;
$OwnerID = $idValue->ownerID;
$Range = $idValue->range;



/*
{"data":[{"id":"NA","info":[{"location":[{"longitude":"NA","latitude":"NA"}],"targetname":"NA","targetID":"NA","startTime":"NA","endTime":"NA","ownername":"NA","ownerID":"NA","level":"NA","range":"NA","status":"NA"}]}]}
*/



echo "{\"id\":\"$locationID\",\"latitude\":\"$PointLat\",\"longitude\":\"$PointLong\",\"altitude\":\"$PointAlt\",\"status\":\"$MissionStatus\",\"level\":\"$MissionLevel\",\"targetname\":\"$TargetName\",\"targetid\":\"$TargetID\",\"starttime\":\"$StartTime\",\"endtime\":\"$EndTime\",\"ownername\":\"$OwnerName\",\"ownerid\":\"$OwnerID\",\"range\":\"$Range\"},";

}


}

}




}




/*
{"data":[{"id":"NA","info":[{"location":[{"longitude":"NA","latitude":"NA"}],"targetname":"NA","targetID":"NA","startTime":"NA","endTime":"NA","ownername":"NA","ownerID":"NA","level":"NA","range":"NA","status":"NA"}]}]}


//echo "{\"id\":\"$locationID\",\"latitude\":\"$PointLat\",\"longitude\":\"$PointLong\",\"status\":\"$MissionStatus\",\"level\":\"$MissionLevel\",\"targetname\":\"$TargetName\",\"targetid\":\"$TargetID\",\"starttime\":\"$StartTime\",\"endtime\":\"$EndTime\",\"ownername\":\"$OwnerName\",\"ownerid\":\"$OwnerID\",\"range\":\"$Range\"},";

*/
}

echo "{\"id\":\"NA\",\"latitude\":\"NA\"}],\"totalCameras\":$TotalCameras}";

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