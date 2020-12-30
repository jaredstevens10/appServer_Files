<?php

header('Content-type: application/json');
//if($_POST) {

if($_GET) {

/*
$username   = $_POST['username'];
$Email = $_POST['email'];
$setting = $_POST['setting'];
$TeamName = $_POST['teamname'];
$Lat = $_POST['lat'];
$Long = $_POST['long'];
$Alt = $_GET['alt'];

$TeamLat = $_POST['teamlat'];
$TeamLong = $_POST['teamlong'];
$TeamAlt = $_POST['teamalt'];
*/




//$password   = $_GET['password'];
//$c_password = $_GET['c_password'];

//$privacy = $_GET['privacy'];
//$admin = "no";
$deviceToken = $_GET['token'];

$username   = $_GET['username'];
$Email = $_GET['email'];
$setting = $_GET['setting'];
$TeamNameStart = $_GET['teamname'];
$Lat = $_GET['lat'];
$Long = $_GET['long'];
$Alt = $_GET['alt'];

$TeamLat = $_GET['teamlat'];
$TeamLong = $_GET['teamlong'];
$TeamAlt = $_GET['teamalt'];

$TeamName = rawurldecode($TeamNameStart);

//$playerID = $_POST['playerid'];

$health = "100";


$privacy = "no";
$points = 50;
$level = 1;



//$imageNameStart = 'user';

$missionsStart = '{"data":[{"id":"NA","info":[{"location":[{"longitude":"NA","latitude":"NA"}],"status":"NA","level":"NA","objective":"NA","xp":"NA", "imageURL": "NA", "objectURL": "NA", "textureURL": "NA"}]},{"id":"1","info":[{"location":[{"longitude":"-81.340586","latitude":"28.812932","altitude":"0.000000"}],"status":"incomplete","level":"1","objective":"Locate Hammer","xp":"25", "imageURL": "MissionMapHammer", "objectURL": "Hammer", "textureURL": "Metal.jpg"}]}]}';



$adminStart = '{"data":[{"id":"NA","info":[{"username":"NA","email":"NA"}]},{"id":"NA","info":[{"username":"'.$username.'","email":"'.$Email.'"}]}]}';


$membersStart = '{"data":[{"id":"NA","info":[{"location":[{"longitude":"NA","latitude":"NA","altitude":"NA"}],"username":"NA","email":"NA","title":"NA","status":"NA"}]},{"id":"1","info":[{"location":[{"longitude":"'.$Long.'","latitude":"'.$Lat.'","altitude":"'.$Alt.'"}],"username":"'.$username.'","email":"'.$Email.'","title":"Founder","status":"active"}]}]}';



//$setting   = $_POST['setting'];
//$setting   = $_GET['setting'];
//$playerID = $_GET['playerid'];

//if($_POST['email']) {
if($_GET['email']) {    
  //  if ( $password == $c_password ) {

    if ( 1 == 1 ) {
    
//echo "password";
    
    try {


			require('/var/www/html/Apps/AppsConfig.php'); 
$dbname = "Stevens_GeoHunters";

define('DIR','http://'.$servername.'/Apps/BattleField/');
define('SITEEMAIL','admin@'.$emailServer.'.com');

        /*** connect to db ***/
        //$dbh = new PDO("mysql:host=localhost;dbname=testblob", 'clavenso_admin', 'claven01*');
        $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $db_username, $db_password);
        //set the error mode
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($setting == "checkName") {


   $sql = "SELECT id FROM TeamInfo WHERE teamName='$TeamName' LIMIT 1";
    $available = $dbh->prepare($sql);
    $available->execute();
    $u_count = $available->rowCount();

if ($u_count > 0){
    $success = 7;
    //echo '{"success":0,"error_message":"Team Name is already in use."}';

     } else {
    $success = 8;
 // echo '{"success":1,"error_message":"Email Address is ok to use."}';
   }

  } else {


$sqlUN = "SELECT teamName FROM TeamInfo WHERE teamName LIKE '$username' LIMIT 1";
    $availableUN = $dbh->prepare($sqlUN);
    $availableUN->execute();
    $un_count = $availableUN->rowCount();

if ($un_count > 0){
    $success = 9;
    $UniqueID = 0;
    //echo '{"success":0,"error_message":"Email Address is already in use."}';

} else {

    /*
    $sql = "SELECT id FROM TeamInfo WHERE teamName='$TeamName' LIMIT 1";
    $available = $dbh->prepare($sql);
    $available->execute();
    $u_count = $available->rowCount();
    */
    
    
    $sql = "SELECT id FROM TeamInfo WHERE teamName='$TeamName' LIMIT 1";
    $available = $dbh->prepare($sql);
    $available->execute();
    $e_count = $available->rowCount();
//echo "E_Count = ".$e_count;
    
    
    /*
    if ($u_count > 0){ 
       // echo '{"success":0,"error_message":"Username already taken."}';



$time = date('Y-m-d H:i:s', time());

$TimeUpdateInfo = "UPDATE TeamInfo SET username = :Username, lastvisitdate = :Time, DeviceToken = :Token, email = :Email WHERE email = \"$Email\"";
$stmt = $dbh->prepare($TimeUpdateInfo);
$stmt->bindParam(":Username", $username);
$stmt->bindParam(":Time", $time);
$stmt->bindParam(":Token", $deviceToken);
$stmt->bindParam(":Email", $Email);
$stmt->execute();


        echo '{"success":0,"error_message":"Welcome Back User."}';
        exit();
	}
	
	*/

    if ($e_count > 0){ 
        echo '{"success":0,"error_message":"Team Name is already in use, please log in to manage your team."}';
        exit();
	}

       /*** connect to db ***/
        //$dbh = new PDO("mysql:host=localhost;dbname=testblob", 'clavenso_admin', 'claven01*');
      //  $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

$time = date('Y-m-d H:i:s', time());

$password = password_hash($password, PASSWORD_BCRYPT);

//$password = md5($password);


        /*** set the error mode ***/
        /*** prepare the sql ***/
        $stmt = $dbh->prepare("INSERT INTO TeamInfo (teamName, members, level, health, missions, admins, latitude, longitude, altitude) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $TeamName);
        $stmt->bindParam(2, $membersStart);
        $stmt->bindParam(3, $level);
        $stmt->bindParam(4, $health);
        $stmt->bindParam(5, $missionsStart);
        $stmt->bindParam(6, $adminStart);
        $stmt->bindParam(7, $TeamLat);
        $stmt->bindParam(8, $TeamLong);
        $stmt->bindParam(9, $TeamAlt);
 

        /*** execute the query ***/
        $stmt->execute();
        $UniqueID = $dbh->lastInsertId();
        $success = $stmt->rowCount();
        
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
					//echo '{"success":1,"uniqueID":$UniqueID}';

if ($success == 7) {

echo '{"success":0,"error_message":"Team Name is already in use."}';


} else if ($success == 9) {

echo "{\"success\":0,\"error_message\":\"username, $username, is already in use.\",\"uniqueID\":$UniqueID}";



} else if ($success == 8) {

echo '{"success":1,"error_message":"Team Name is ok to use."}';



} else {
					echo '{"success":1,"uniqueID":'.$UniqueID.'}';

}
				} else {
					echo '{"success":0,"error_message":"Invalid Data."}';
				}


   } 
   else 
   {
        echo '{"success":0,"error_message":"Passwords Do Not Match."}';
   }         
}

else 
{

    echo '{"success":0,"error_message":"Invalid Data."}';
}
} 
else 
{
    echo '{"success":0,"error_message":"Network Error."}';

}

?>