<?php

header('Content-type: application/json');
if($_POST) {
	$username   = $_POST['username'];
	$password   = $_POST['password'];
	//$token   = $_POST['token'];
	$playeridemail   = $_POST['email'];
    $Action = $_POST['action'];
//$email = "NA@NA.com";

//	if($username && $password) {

	if(1 == 1) {

 		require('/var/www/html/Apps/AppsConfig.php'); 
$dbname = "Stevens_GeoHunters";

define('DIR','http://'.$servername.'/Apps/BattleField/');
define('SITEEMAIL','admin@'.$emailServer.'.com');


try {

	//create PDO connection 
	//$db = new PDO("mysql:host=".DBHOST.";port=8889;dbname=".DBNAME, DBUSER, DBPASS);
	$db = new PDO("mysql:host=$servername;dbname=$dbname", $db_username, $db_password);
    
    
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   // echo "Connected Successfully";
    
} catch(PDOException $e) {
	//show error
   // echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    exit;
}

/*
if (password_verify($password, $hashAndSalt)) {
   // Verified
}
*/
        
        if ($Action == "sync") {
            
            $time = date('Y-m-d H:i:s', time());
            
            $TimeUpdateInfo = "UPDATE users SET lastvisitdate = :Time WHERE username = \"$username\"";

//        $TimeUpdateInfo = "UPDATE Members SET lastvisitdate = :Time, DeviceToken = :Token, PlayerID = :PlayerID WHERE PlayerID = \"$playerid\"";
            
            //$TimeUpdateInfo = "UPDATE Members SET username = :Username, lastvisitdate = :Time, DeviceToken = :Token, PlayerID = :PlayerID WHERE PlayerID = \"$playerid\"";
            $stmt = $db->prepare($TimeUpdateInfo);
            //$stmt->bindParam(":Username", $username);
            $stmt->bindParam(":Time", $time);
            $stmt->bindParam(":Token", $token);
            //$stmt->bindParam(":PlayerID", $playerid);
            $stmt->execute();

           echo '{"success":1,"updated":"synced"}'; 
            
        } else {

//$hashedpassword = password_hash($password, PASSWORD_BCRYPT);
$OrigPassword = password_hash($password, PASSWORD_BCRYPT);

	 //$UserInfo = "SELECT username, email, PlayerID FROM Members WHERE PlayerID = \"$playerid\" and password = \"$hashedpassword\"";

	 $UserInfo = "SELECT password, username, email FROM users WHERE email = \"$playeridemail\"";

// and password = \"$hashedpassword\"";


                $stmt = $db->prepare($UserInfo);

                $stmt->execute();
                
               // $stmt->bind_result($checkUsername, $checkPlayerid, $email);

       $UserRow = $stmt->fetch(PDO::FETCH_ASSOC);
       //$CheckPlayerID = $UserRow[PlayerID];
       $CheckPlayerEmail = $UserRow[email];
       $CheckPlayerPassword = $UserRow[password];
      $TheUsername = $UserRow[username];


if (password_verify($password, $CheckPlayerPassword)) {
   $DoesMatch = "true";
} else {

$DoesMatch = "false";
}



	if ($CheckPlayerEmail == $playeridemail) {
					error_log("User $username: password match.");


$time = date('Y-m-d H:i:s', time());

$TimeUpdateInfo = "UPDATE users SET lastvisitdate = :Time WHERE email = \"$playeridemail\"";


//$TimeUpdateInfo = "UPDATE users SET lastvisitdate = :Time, DeviceToken = :Token WHERE email = \"$playeridemail\"";
//$TimeUpdateInfo = "UPDATE Members SET lastvisitdate = :Time, DeviceToken = :Token, PlayerID = :PlayerID WHERE PlayerID = \"$playerid\"";
//$TimeUpdateInfo = "UPDATE Members SET username = :Username, lastvisitdate = :Time, DeviceToken = :Token, PlayerID = :PlayerID WHERE PlayerID = \"$playerid\"";


$stmt = $db->prepare($TimeUpdateInfo);
//$stmt->bindParam(":Username", $username);
$stmt->bindParam(":Time", $time);
//$stmt->bindParam(":Token", $token);
//$stmt->bindParam(":PlayerID", $playerid);
$stmt->execute();


//UPDATE ISFUN TO 'YES'

if ($DoesMatch == "true" ) {
echo "{\"success\":1,\"email\":\"$CheckPlayerEmail\",\"theusername\":\"".$TheUsername."\"}";

 // echo "{\"success\":1,\"theusername\":\"".$TheUsername."\",\"playerid\":\"".$playerid."\",\"email\":\"".$CheckPlayerEmail."\",\"isFun\":\"yes\",\"storedPW\":\"".$CheckPlayerPassword."\",\"OrigPW\":\"".$password."\",\"DoesMatch\":\"".$DoesMatch."\"}";

} else {
//echo '{"success":0,"error_message":"password does not match"}';

echo "{\"success\":0,\"error_message\":\"password does not match\",\"check password\":\"$CheckPlayerPassword\",\"Original password\":\"$OrigPassword\"}";
}


					//echo "{\"success\":1}";
				} else {
					error_log("User $username: password doesn't match.");
					echo "{\"success\":0,\"error_message\":\"password does not match\",\"check password\":\"$CheckPlayerPassword\",\"Original password\":\"$OrigPassword\"}";
				}
			

}
} else {
	echo '{"success":0,"error_message":"Network Error."}';
}


    
} else {
	echo '{"success":0,"error_message":"Network Error."}';
}
?>