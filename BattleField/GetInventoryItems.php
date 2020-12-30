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
$friendType = "itemInventory";


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

/*
$GameComments = "SELECT * FROM GameComments WHERE gameid = $gameid ORDER BY DateTimeStamp DESC";
$stmt = $db->prepare($GameComments);
$stmt->execute();
*/



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

$itemName = $value->item;
$itemURL = $value->itemURL;
$itemURL100 = $value->itemURL100;
$category = $value->category;
$count = $value->count;
$ammoCount = $value->ammoCount;
$level = $value->level;
$range = $value->range;
$viewRange = $value->viewRange;
$power = $value->power;
$speed = $value->speed;

echo "{\"item\":\"$itemName\",\"itemURL\":\"$itemURL\",\"itemURL100\":\"$itemURL100\",\"category\":\"$category\",\"count\":\"$count\",\"ammoCount\":\"$ammoCount\",\"level\":\"$level\",\"range\":\"$range\",\"viewrange\":\"$viewRange\",\"power\":\"$power\",\"speed\":\"$speed\"},";

}

echo "{\"item\":\"NA\",\"playerid\":\"NA\"}]}";

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