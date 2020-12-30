<?php

header('Content-type: application/json');

/*
if($_GET) {

//$gameid   = $_POST['gameid'];
$byUser = $_GET['username'];
$Category = $_GET['category'];
$date = $_GET['date'];
$comments2 = $_GET['message'];
$byID = $_GET['userid'];
$image = $_POST['image'];
*/

if($_POST) {

//$gameid   = $_POST['gameid'];
$byUser = $_POST['username'];
$Category = $_POST['category'];
$date = $_POST['date'];
$comments2 = $_POST['message'];
$byID = $_POST['userid'];
$image = $_POST['image'];
//$repliedUsername = $_POST['replyuser'];
//$repliedUserID = $_POST['replyuserID'];
$Area = "All";
//$Area = $_POST['area'];

$Message = rawurldecode($comments2);


$time = date('Y-m-d H:i:s', time());


$servername = "localhost";
$A_username = "clavenso_Admin";
$A_password = "claven01*";
$dbname = "clavenso_iAmDataBase";
//$dbname = "members";

//application address
define('DIR','http://clavensolutions.com/Apps/TelePictionary/');
define('SITEEMAIL','admin@clavensolutions.com');


try {

	//create PDO connection 
	//$db = new PDO("mysql:host=".DBHOST.";port=8889;dbname=".DBNAME, DBUSER, DBPASS);
	$dbh = new PDO("mysql:host=$servername;dbname=$dbname", $A_username, $A_password);
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	//if no errors have been created carry on
	if(!isset($error)){

		//create the activasion code
		$token = md5(uniqid(rand(),true));

 $stmt = $dbh->prepare("INSERT INTO News (message, byUser, byID, category, DateTimeStamp, image, Area) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $Message);
        $stmt->bindParam(2, $byUser);
        $stmt->bindParam(3, $byID);
        $stmt->bindParam(4, $Category);
        $stmt->bindParam(5, $time);
        $stmt->bindParam(6, $image);
        $stmt->bindParam(7, $Area);
   


        /*** execute the query ***/
        $stmt->execute();
        $success = $stmt->rowCount();
 
        //Exit;
        }
        }
catch(Exception $e)
{
         {
            echo '{"success":0,"error_message":'.$e->getMessage().'}';
         }
        
        
}

if ($success > 0) {
			

echo '{"success":1}';

/*

////////////////////


 $DeviceTokenInfo = "SELECT deviceToken, first_name FROM members WHERE username = '".$toUser."'";
 $tokenResult = $dbh->prepare($DeviceTokenInfo);
 $tokenResult->execute();
 $tokenRow = $tokenResult->fetch(PDO::FETCH_ASSOC);

 $deviceToken = $tokenRow['deviceToken'];
 $ToPerson = $tokenRow['first_name'];
      

//$player = $noticeRow['player'];    
//$deviceToken = $noticeRow['token']; 
//$GameID = $gameid;
//$GameBy = $playerRow['User1'];
$Alert = "newMessage";
//$TurnINFO = "NA";
//$userMessage = "NA";
//$GameType = $GameStyle;

$message = "$ToPerson, $Message.";

//echo "Device Token = ".$deviceToken;
//echo "Device Token = ".$deviceToken;
//echo "Message = ".$message;

if ($deviceToken == "NA") {
    //DO NOT ATTEMPT TO SEND NOTICE
} else {
//SENDING NOTICE


//$deviceToken = 'f16cb9bd07ebe1374bb8b92249ab55f909e5bc8ad65047086def84ec79ed6fa8';
  

$body['aps'] = array(
                     'alert' =>  $message,
                     'badge' => 1,
                     'category' => $Alert
                     );
    
//Server stuff
$passphrase = 'jared';
$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', 'iamhertzCK.pem');
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);


$fp = stream_socket_client(
	'ssl://gateway.sandbox.push.apple.com:2195', $err,
	$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);


//$fp = stream_socket_client(
//	'ssl://gateway.push.apple.com:2195', $err,
//	$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

if (!$fp)

	exit("Failed to connect: $err $errstr" . PHP_EOL);
//echo 'Connected to APNS' . PHP_EOL;
$payload = json_encode($body);
// Build the binary notification

$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
// Send it to the server
$result = fwrite($fp, $msg, strlen($msg));
if (!$result) {

    //MESSAGE NOT DELIVERED - COMMENTED OUT THE SUCCESS = 0 ECHO
    //echo '{"success":0,"Message not delivered":"Error Sending."}';
}
else {
	//echo 'Message successfully delivered' . PHP_EOL;

//$SuccessPushArray[] = $deviceToken;

    }

  // }

 }

*/

	} else {
	echo '{"success":2,"error_message":"No Status Change."}';
	}
	
} else {
    
    echo '{"success":0,"error_message":"Connection Error."}';
    
}


?>
