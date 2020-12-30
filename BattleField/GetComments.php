<?php

header('Content-type: application/json');

/*
if($_GET) {
$teamName   = $_GET['teamName'];
$userID   = $_GET['email'];
*/

if($_POST) {
$teamName   = $_POST['teamName'];
$userID   = $_POST['email'];


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


//if ($_POST['teamName']) {

if ($teamName != "") {

$GameComments = "SELECT * FROM messageData WHERE toTeam = '".$teamName."' ORDER BY DateTimeStamp DESC";
$stmt = $db->prepare($GameComments);
$stmt->execute();

//$rowStatus = $stmt->fetch(PDO::FETCH_ASSOC);
//$commentsReturned = $rowStatus['comments'];


echo"{\"success\":1,\"Data\":[";

while($rows = $stmt->fetch(PDO::FETCH_ASSOC)){

$CommentData = base64_encode($rows[message]);

echo "{\"id\":\"$rows[id]\",\"toTeam\":\"$rows[toTeam]\",\"toUser\":\"$rows[toUser]\",\"fromUser\":\"$rows[fromUser]\",\"message\":\"$CommentData\",\"datetimestamp\":\"$rows[DateTime]\",\"toUserID\":\"$rows[toUserID]\",\"fromUserID\":\"$rows[fromUserID]\"},";

           }

echo "{\"id\":\"NA\",\"toTeam\":\"NA\"}]}";
          }
          
          
if ($_POST['email']) {
//if ($_GET['email']) {
$GameComments = "SELECT * FROM messageData WHERE messageType = 'user' ORDER BY DateTimeStamp DESC";
$stmt = $db->prepare($GameComments);
$stmt->execute();

//$rowStatus = $stmt->fetch(PDO::FETCH_ASSOC);
//$commentsReturned = $rowStatus['comments'];


echo"{\"success\":1,\"Data\":[";

while($rows = $stmt->fetch(PDO::FETCH_ASSOC)){

$CommentData = base64_encode($rows[message]);

echo "{\"id\":\"$rows[id]\",\"toTeam\":\"$rows[toTeam]\",\"toUser\":\"$rows[toUser]\",\"fromUser\":\"$rows[fromUser]\",\"message\":\"$CommentData\",\"datetimestamp\":\"$rows[DateTime]\",\"toUserID\":\"$rows[toUserID]\",\"fromUserID\":\"$rows[fromUserID]\"},";

           }

echo "{\"id\":\"NA\",\"toTeam\":\"NA\"}]}";


}
          
          
          
          
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