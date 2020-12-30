<?php

header('Content-type: application/json');

/*
if($_GET) {
//$gameid   = $_POST['gameid'];
$email   = $_GET['email'];
$level   = $_GET['level'];
$status   = $_GET['status'];

*/


if($_POST) {
//$gameid   = $_POST['gameid'];
$email   = $_POST['email'];
$level   = $_POST['level'];
$status   = $_POST['status'];


$itemType   = $_POST['itemType'];


//$friendType   = $_POST['type'];
$friendType = "skills";


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

//echo $FriendsData;
$FriendsArray = json_decode(json_encode($FriendsData), true);

//print_r ($FriendsArray);

$manage_array = get_object_vars(json_decode($FriendsData));


//print_r($manage_array);

//echo"{\"success\":1,".$FriendsArray."}";
//exit;
//$rowStatus = $stmt->fetch(PDO::FETCH_ASSOC);
//$commentsReturned = $rowStatus['comments'];



echo"{\"success\":1,\"Data\":[";



foreach ($manage_array['data'] as $key=>$value) {

$ID = $value->id;
//echo "LOCATION ID ".$locationID;
foreach ($value->info as $idKey=>$idValue) {

$Status = $idValue->status;
$Level = $idValue->level;
$Description = $idValue->description;
$Title = $idValue->title;
$imageURL = $idValue->imageURL;
$XP = $idValue->xp;

$DescriptionData = base64_encode($Description);
$TitleData = base64_encode($Title);

//echo $Title;

//$MissionName = $idValue->name;
//$MissionCategory = $idValue->category;
//$CategoryTitle = $idValue->categoryTitle;

}

echo "{\"id\":\"$ID\",\"title\":\"$TitleData\",\"status\":\"$Status\",\"level\":\"$Level\",\"description\":\"$DescriptionData\",\"imageURL\":\"$imageURL\",\"xp\":\"$XP\"},";

}

echo "{\"id\":\"NA\",\"latitude\":\"NA\"}]}";

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