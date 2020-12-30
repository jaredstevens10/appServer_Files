<?php

header('Content-type: application/json');


//if($_GET) {
//$email   = $_GET['email'];

if($_POST) {
$email   = $_POST['email'];



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




if ($_POST['email']) {

$GameComments = "SELECT * FROM newsData ORDER BY DateTimeStamp DESC";
$stmt = $db->prepare($GameComments);
$stmt->execute();


echo"{\"success\":1,\"Data\":[";

while($rows = $stmt->fetch(PDO::FETCH_ASSOC)){

$TitleData = base64_encode($rows[title]);
$DescriptionData = base64_encode($rows[description]);
$LinkData = base64_encode($rows[link]);
$imageURLData = base64_encode($rows[imageURL]);

echo "{\"id\":\"$rows[id]\",\"title\":\"$TitleData\",\"description\":\"$DescriptionData\",\"link\":\"$LinkData\",\"imageURL\":\"$imageURLData\",\"datetimestamp\":\"$rows[DateTimeStamp]\"},";

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