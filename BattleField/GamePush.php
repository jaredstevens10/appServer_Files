<?php

//////////





/////////////

header('Content-type: application/json');



if($_POST) {


//$deviceToken = '61c2b39d5c1e7555cee8ed09d16afc1ec4d15b8b4f62038b36e508a07d6f33ae';

$player = $_POST['player'];
$deviceToken = $_POST['token'];
$AttackFrom = $_POST['attackfrom'];
$GameID = $_POST['attackpower'];
$Alert = $_POST['alert'];
$userMessage = $_POST['message'];


/*

if($_GET) {


//$deviceToken = 'cd709e03d85823af923a21d63863bbc123a1456b1f31633873d46d68450a6d86';

$player = $_GET['player'];
$deviceToken = $_GET['token'];
$AttackFrom = $_GET['attackfrom'];
$GameID = $_GET['attackpower'];
$Alert = $_GET['alert'];
$userMessage = $_GET['message'];



$deviceToken = '61c2b39d5c1e7555cee8ed09d16afc1ec4d15b8b4f62038b36e508a07d6f33ae';

*/


if ($Alert == "didAttack") {
$message = "$player, $AttackFrom is Attacking you!";
$Sound = "Hurt.caf";
}

if ($Alert == "willAttack") {
$message = "$player, $AttackFrom is attacking on you.  You have 15 seconds to respond.";
$Sound = "Hurt.caf";
}

if ($Alert == "userMessage") {
$message = "$player, $userMessage  -$AttackFrom";
}

if ($Alert == "cancelAttack") {
$message = "$player, $AttackFrom has decided not to attack you.";
}

if ($Alert == "fightingBack") {
$message = "$player, $AttackFrom is counter attacking you.  Look out!";
}
    
$body['aps'] = array(
                     'alert' =>  $message,
                     'badge' => 1,
                     'attackedBy' => $AttackFrom,
                     'category' => $Alert,
                     'sound' => $Sound
                     );
    
//'action-loc-key' => 'Open', 'body' =>


//$body['category'] = 'message';
//$body['key'] = 'profile';
//$body['article'] = "test article";
//$body['category'] = 'dates';
//$body['category'] = 'daily_dates';
//$body['sender'] = 'jamesHAW';
//$body['sender'] = 'jerrytest35';
    
//Server stuff
$passphrase = 'jared';
$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

//echo $ctx;
$fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

//echo "err: ".$err;
//echo "errstr: ".$errstr;
//echo $fp;
if (!$fp)

        $errorResults = "Failed to connect: " . $err . " " . $errstr; 
       // echo "{\"success\":0,\"error_message\":\"". $errorResults . "\"}";
//$errorResults = "Failed to connect: " . $err . " " . $errstr; 

// . " " 
	//exit("Failed to connect: $err $errstr" . PHP_EOL);

//exit();
//echo 'Connected to APNS' . PHP_EOL;
$payload = json_encode($body);
// Build the binary notification


$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
// Send it to the server
$result = fwrite($fp, $msg, strlen($msg));
if (!$result) {
	//echo 'Message not delivered' . PHP_EOL;
echo '{"success":0,"Message not delivered":"Error Sending."}';
}
else {
	//echo 'Message successfully delivered' . PHP_EOL;
echo "{\"success\":1}"; 
//echo "{\"success\":1,\"turn\":\"'".$NextUser."'\",\"token\":\"'".$DeviceToken."'\"}";
}
fclose($fp);
} else {
	echo '{"success":0,"error_message":"Invalid Data."}';
}

    
?>