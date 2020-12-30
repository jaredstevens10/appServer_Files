<?php

header('Content-type: application/json');

/*
if($_GET) {

$FromUser   = $_GET['fromUser'];
$ToUser = $_GET['toUser'];
$FromUserID = $_GET['fromUserID'];
$DateTime = $_GET['dateTime'];
$Message2 = $_GET['message'];
$ToUserID = $_GET['toUserID'];
$ToTeam = $_GET['toTeam'];
$MessageType = $_GET['messageType'];
*/

if($_POST) {

$FromUser   = $_POST['fromUser'];
$ToUser = $_POST['toUser'];
$FromUserID = $_POST['fromUserID'];
$DateTime = $_POST['dateTime'];
$Message2 = $_POST['message'];
$ToUserID = $_POST['toUserID'];
$ToTeam = $_POST['toTeam'];
$MessageType = $_POST['messageType'];



$Message = rawurldecode($Message2);
$s = $DateTime;

$timeTwo = date_create_from_format('Y-m-d H:i:s', $s);
//$timeTwo->format('Y-m-d H:i:s');
//getTimestamp();

$time = date('Y-m-d H:i:s', time());

//Must set db_username and db_password
require('/var/www/html/Apps/AppsConfig.php'); 
$dbname = "Stevens_GeoHunters";

define('DIR','http://'.$servername.'/Apps/BattleField/');
define('SITEEMAIL','admin@'.$emailServer.'.com');

/*
$servername = "localhost";
$A_username = "clavenso_Admin";
$A_password = "claven01*";
$dbname = "clavenso_GeoHunters";
//$dbname = "members";

//application address
define('DIR','http://clavensolutions.com/Apps/BattleField/');
define('SITEEMAIL','admin@clavensolutions.com');
*/

try {

	//create PDO connection 
	//$db = new PDO("mysql:host=".DBHOST.";port=8889;dbname=".DBNAME, DBUSER, DBPASS);
	$dbh = new PDO("mysql:host=$servername;dbname=$dbname", $db_username, $db_password);
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	//if no errors have been created carry on
	if(!isset($error)){

		//create the activasion code
		$token = md5(uniqid(rand(),true));

 $stmt = $dbh->prepare("INSERT INTO messageData (fromUser, toUser, fromUserID, toUserID, message, DateTimeStamp, toTeam, DateTime, messageType) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $FromUser);
        $stmt->bindParam(2, $ToUser);
        $stmt->bindParam(3, $FromUserID);
        $stmt->bindParam(4, $ToUserID);
        $stmt->bindParam(5, $Message);
        $stmt->bindParam(6, $time);
        //$stmt->bindParam(6, $s);
        $stmt->bindParam(7, $ToTeam);
        $stmt->bindParam(8, $s);
        $stmt->bindParam(9, $MessageType);


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
			
if ($MessageType == "team") {
echo '{"success":1}';


////////////////////

 $UserInfo = "SELECT User1, User2, User3, User4, User5, User1ID, User2ID, User3ID, User4ID, User5ID FROM TeamInfo WHERE teamName = '".$ToTeam."'";
    
    $result = $dbh->prepare($UserInfo);
    $result->execute();
    $playerRow = $result->fetch(PDO::FETCH_ASSOC);
    
    $GameStyle = $playerRow['GameStyle'];
    
$playersArray = array( array( "player" => $playerRow['User1'], "playerID" => $playerRow['User1ID']),array( "player" => $playerRow['User2'], "playerID" => $playerRow['User2ID']),array( "player" => $playerRow['User3'], "playerID" => $playerRow['User3ID']),array( "player" => $playerRow['User4'], "playerID" => $playerRow['User4ID']),array( "player" => $playerRow['User5'], "playerID" => $playerRow['User5ID']));


/*
,array( "player" => $playerRow['User6'], "playerID" => $playerRow['User6ID']),array( "player" => $playerRow['User7'], "playerID" => $playerRow['User7ID']),array( "player" => $playerRow['User8'], "playerID" => $playerRow['User8ID']),array( "player" => $playerRow['User9'], "playerID" => $playerRow['User9ID']),array( "player" => $playerRow['User10'], "playerID" => $playerRow['User10ID'])
*/

$last = count($GameArray) - 1;

$tokenList = array();

foreach ($playersArray as $I => $row) {


$isFirst = ($I == 0);
$isLast = ($I == $last);

$player = $row['player'];
$playerID = $row['playerID'];

if ($player == "-") {
  $tokenList[] = "NA";  
} else {

 $DeviceTokenInfo = "SELECT DeviceToken FROM users WHERE email = '".$playerID."'";
 $tokenResult = $dbh->prepare($DeviceTokenInfo);
 $tokenResult->execute();
 $tokenRow = $tokenResult->fetch(PDO::FETCH_ASSOC);

 $tokenList[] = $tokenRow['DeviceToken'];
      }
}

$SendNoticeArray = array( array( "player" => $playerRow['User1'], "token" => $tokenList[0]), array( "player" => $playerRow['User2'], "token" => $tokenList[1]),array( "player" => $playerRow['User3'], "token" => $tokenList[2]),array( "player" => $playerRow['User4'], "token" => $tokenList[3]),array( "player" => $playerRow['User5'], "token" => $tokenList[4]));

/*

,array( "player" => $playerRow['User6'], "token" => $tokenList[5]),array( "player" => $playerRow['User7'], "token" => $tokenList[6]),array( "player" => $playerRow['User8'], "token" => $tokenList[7]),array( "player" => $playerRow['User9'], "token" => $tokenList[8]),array( "player" => $playerRow['User10'], "token" => $tokenList[9])

*/
    
$SendNoticeArray = array_unique($SendNoticeArray);


foreach ($SendNoticeArray as $I => $noticeRow) {  
    
$isFirst = ($I == 0);
$isLast = ($I == $last);   
    // SENDING NOTICE TO EACH PLAYER THAT THE GAME IS COMPLETE
    
    
$player = $noticeRow['player'];    
$deviceToken = $noticeRow['token']; 
$GameID = $gameid;
$GameBy = $playerRow['User1'];
$Alert = "gameComment";
$TurnINFO = "NA";
$userMessage = "NA";
$GameType = $GameStyle;

$message = "$username send a new message.";

if ($deviceToken == "NA") {
    //DO NOT ATTEMPT TO SEND NOTICE
} else {
//SENDING NOTICE


//$deviceToken = 'f16cb9bd07ebe1374bb8b92249ab55f909e5bc8ad65047086def84ec79ed6fa8';
/*
if ($Alert == "yourTurn") {
$message = "$player, it's your turn!";
}

if ($Alert == "newGame") {
$message = "$player, A New game has started and you're invited.";
}

if ($Alert == "userMessage") {
$message = "$player, A New game has started and you're invited.";
}
 */   

$body['aps'] = array(
                     'alert' =>  $message,
                     'badge' => 1,
                     'gameBy' => $GameBy,
                     'category' => $Alert,
                     'gameId' => $GameID,
                     'turninfo' => $TurnINFO,
                     'gameType' => $GameType
                     );
    
//Server stuff
$passphrase = 'jared';
$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);


$fp = stream_socket_client(
	'ssl://gateway.sandbox.push.apple.com:2195', $err,
	$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);


//UNCOMMMENT FOR LIVE NOTIFICATIONS, NOT SANDBOX
/*
$fp = stream_socket_client(
	'ssl://gateway.push.apple.com:2195', $err,
	$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
*/


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

$SuccessPushArray[] = $deviceToken;

    }

   }
 }


} else {


$DeviceTokenInfo = "SELECT DeviceToken FROM users WHERE email = 'jaredstevens10@yahoo.com'";

//$DeviceTokenInfo = "SELECT DeviceToken FROM users WHERE email = '".$ToUserID."'";
$tokenResult = $dbh->prepare($DeviceTokenInfo);
$tokenResult->execute();
$tokenRow = $tokenResult->fetch(PDO::FETCH_ASSOC);

$deviceToken = $tokenRow['DeviceToken'];
 
 echo '{"success":1,"toUserID":"'.$ToUserID.'","deviceToken":"'.$deviceToken.'"}';
 
 
$player = $ToUser; 
//$deviceToken = $noticeRow['token']; 
$GameID = "";
$GameBy = "";
$Alert = "userMessage";
$TurnINFO = "NA";
//$userMessage = "NA";
$userMessage = $Message;
$GameType = $GameStyle;

$message = "$ToUser, $Message";
//$message = "$ToUser, you have a new message.";

if ($deviceToken == "NA") {
    //DO NOT ATTEMPT TO SEND NOTICE
} else {
//SENDING NOTICE

//echo "Sending Now";
//$deviceToken = 'f16cb9bd07ebe1374bb8b92249ab55f909e5bc8ad65047086def84ec79ed6fa8';
/*
if ($Alert == "yourTurn") {
$message = "$player, it's your turn!";
}

if ($Alert == "newGame") {
$message = "$player, A New game has started and you're invited.";
}

if ($Alert == "userMessage") {
$message = "$player, A New game has started and you're invited.";
}
 */   

$body['aps'] = array(
                     'alert' =>  $message,
                     'badge' => 1,
                     'gameBy' => $GameBy,
                     'category' => $Alert,
                     'gameId' => $GameID,
                     'turninfo' => $TurnINFO,
                     'gameType' => $GameType
                     );
    
//Server stuff
$passphrase = 'jared';
$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);


$fp = stream_socket_client(
	'ssl://gateway.sandbox.push.apple.com:2195', $err,
	$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);


//UNCOMMMENT FOR LIVE NOTIFICATIONS, NOT SANDBOX
/*
$fp = stream_socket_client(
	'ssl://gateway.push.apple.com:2195', $err,
	$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
*/	
	
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

   }
 
 
 

}

////
if ($reply == "yes") {

if ($repliedUserID == $userID) {

} else {

$DeviceIDinfo = "SELECT DeviceToken FROM users WHERE email = '".$repliedUserID."'";

$resultToken = $dbh->prepare($DeviceIDinfo);
$resultToken->execute();
//$rowToken = $resultToken->fetch_assoc();
$rowToken = $resultToken->fetch(PDO::FETCH_ASSOC);
//$UserTurn = $result->fetch();
$deviceToken = $rowToken['DeviceToken'];

$player = $repliedUsername;    
//$deviceToken = $noticeRow['token']; 
$GameID = $gameid;
$GameBy = "NA";
$Alert = "userMessage";
$TurnINFO = "NA";
$userMessage = "NA";
$GameType = "NA";

$message = $username . " replied to one of your comments";

if ($deviceToken == "NA") {
    
    //DO NOT ATTEMPT TO SEND NOTICE
} else {
//SENDING NOTICE


//$deviceToken = 'f16cb9bd07ebe1374bb8b92249ab55f909e5bc8ad65047086def84ec79ed6fa8';
/*
if ($Alert == "yourTurn") {
$message = "$player, it's your turn!";
}

if ($Alert == "newGame") {
$message = "$player, A New game has started and you're invited.";
}

if ($Alert == "userMessage") {
$message = "$player, A New game has started and you're invited.";
}
 */   

$body['aps'] = array(
                     'alert' =>  $message,
                     'badge' => 1,
                     'gameBy' => $GameBy,
                     'category' => $Alert,
                     'gameId' => $GameID,
                     'turninfo' => $TurnINFO,
                     'gameType' => $GameType
                     );
    
//Server stuff
$passphrase = 'jared';
$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

$fp = stream_socket_client(
	'ssl://gateway.push.apple.com:2195', $err,
	$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

/*
$fp = stream_socket_client(
	'ssl://gateway.sandbox.push.apple.com:2195', $err,
	$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

*/
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

$SuccessPushArray[] = $deviceToken;

}
fclose($fp); 

    }
  }
}

    } else {
					echo '{"success":2,"error_message":"No Status Change."}';
				}
	
} else {
    
    echo '{"success":0,"error_message":"Connection Error."}';
    
}


?>