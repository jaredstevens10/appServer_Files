<?php

header('Content-type: application/json');


if($_POST) {

	$username   = $_POST['username'];
	$password   = $_POST['password'];
	$c_password = $_POST['c_password'];
    $Email = $_POST['email'];
    $privacy = $_POST['privacy'];
    $admin = "no";
$deviceToken = $_POST['token'];
$setting   = $_POST['setting'];

$Awareness   = $_POST['awareness'];
$Charisma   = $_POST['charisma'];
$Credibility  = $_POST['credibility'];
$Endurance   = $_POST['endurance'];
$Intelligence = $_POST['intelligence'];
$Speed = $_POST['speed'];
$Strength = $_POST['strength'];
$Vision = $_POST['vision'];
$AttributePoints = $_POST['attributePoints'];


/*

if($_GET) {
$username   = $_GET['username'];
	$password   = $_GET['password'];
	$c_password = $_GET['c_password'];
    $Email = $_GET['email'];
    $privacy = $_GET['privacy'];
    $admin = "no";
$deviceToken = $_GET['token'];
$setting = $_GET['setting'];

$Awareness   = $_GET['awareness'];
$Charisma   = $_GET['charisma'];
$Credibility  = $_GET['credibility'];
$Endurance   = $_GET['endurance'];
$Intelligence = $_GET['intelligence'];
$Speed = $_GET['speed'];
$Strength = $_GET['strength'];
$Vision = $_GET['vision'];
$AttributePoints = $_GET['attributePoints'];

*/

//$playerID = $_POST['playerid'];

$privacy = "no";
$points = 50;
$level = 1;
$friendStart = '{"data":[{"name":"NA","playerid":"NA"}]}';

$itemInventoryStart = '{"data":[{"item":"NA","itemURL":"NA","itemURL100":"NA","category":"NA","count":"NA","ammoCount":"NA","level":"NA","range":"NA","viewRange":"NA","power":"NA","speed":"NA"},{"item":"Fist","itemURL":"Fist","itemURL100":"Fist100","category":"weapon","count":"NA","ammoCount":"NA","level":"1","range":"1","viewRange":"1","power":"1","speed":"1"}]}';

$TerritoryStart = '{"data":[{"id":"NA","info":[{"Point1":[{"longitude":"NA","latitude":"NA","altitude":"NA"}],"Point2":[{"longitude":"NA","latitude":"NA","altitude":"NA"}],"Point3":[{"longitude":"NA","latitude":"NA","altitude":"NA"}],"Point4":[{"longitude":"NA","latitude":"NA","altitude":"NA"}],"Point5":[{"longitude":"NA","latitude":"NA","altitude":"NA"}]}]}]}';

$bestfriendStart = '{"data": [{"username": "NA","userid": "NA","status":"NA"}]}';


$imageNameStart = 'user';

$missionStart = '{"data":[{"id":"NA","info":[{"location":[{"longitude":"NA","latitude":"NA","altitude":"NA"}],"name":"NA","status":"NA","level":"NA","objective":"NA","xp":"NA", "imageURL": "NA", "objectURL": "NA", "textureURL": "NA", "category": "NA", "categoryTitle": "NA"}]}]}';

$skillsStart = '{"data":[{"id":"NA","info":[{"status":"NA","level":"NA","description":"NA","title":"NA","imageURL":"NA"}]},{"id":"1","info":[{"status":"unlocked","level":"1","description":"This ability helps with opening secured items and locations","title":"Lock Picking","imageURL":"NA","xp":"50"}]},{"id":"2","info":[{"status":"locked","level":"1","description":"The ability to move around with minimal detection","title":"Stealth","imageURL":"NA","xp":"50"}]}]}';

$attributesStart = '{"data":[{"id":"1","info":[{"awareness":"'.$Awareness.'","charisma":"'.$Charisma.'","credibility":"'.$Credibility.'","endurance":"'.$Endurance.'","intelligence":"'.$Intelligence.'","speed":"'.$Speed.'","strength":"'.$Strength.'","vision":"'.$Vision.'"}]}]}';

//echo $attributesStart;


/*
$targetStart = '{"data":[{"id":"NA","info":[{"location":[{"longitude":"NA","latitude":"NA","altitude":"NA"}],"status":"NA","level":"NA","objective":"NA","xp":"NA", "imageURL": "NA", "objectURL": "NA", "textureURL": "NA"}]},{"id":"1","info":[{"location":[{"longitude":"-81.340586","latitude":"28.812932","altitude":"0.000000"}],"status":"incomplete","level":"1","objective":"Locate Hammer","xp":"25", "imageURL": "MissionMapHammer", "objectURL": "Hammer", "textureURL": "Metal.jpg"}]},{"id":"2","info":[{"location":[{"longitude":"-81.340486","latitude":"28.812632","altitude":"0.000000"}],"status":"incomplete","level":"1","objective":"Locate Hammer Outside","xp":"25", "imageURL": "MissionMapOutside", "objectURL": "Hammer", "textureURL": "Metal.jpg"}]}]}';
*/

$targetStart = '{"data":[{"id":"NA","info":[{"location":[{"longitude":"NA","latitude":"NA","altitude":"NA"}],"status":"NA","level":"NA","objective":"NA","xp":"NA", "imageURL": "NA", "objectURL": "NA", "textureURL": "NA","targetname":"NA","lastdate":"NA"}]},{"id":"1","info":[{"location":[{"longitude":"-81.340586","latitude":"28.812932","altitude":"0.000000"}],"status":"incomplete","level":"1","objective":"Enemy 1","xp":"25", "imageURL": "MissionMapHammer", "objectURL": "Hammer", "textureURL": "Metal.jpg", "targetname":"John Doe","lastdate":"2017-01-03 12:11:07"}]},{"id":"2","info":[{"location":[{"longitude":"-81.340486","latitude":"28.812632","altitude":"0.000000"}],"status":"complete","level":"1","objective":"Enemy 2", "xp":"25", "imageURL": "MissionMapOutside", "objectURL": "Hammer", "textureURL": "Metal.jpg","targetname":"Bill Smith","lastdate":"2017-01-05 12:09:07"}]}]}';

$cameraStart = '{"data":[{"id":"NA","info":[{"location":[{"longitude":"NA","latitude":"NA","altitude":"NA"}],"targetname":"NA","targetID":"NA","startTime":"NA","endTime":"NA","ownername":"NA","ownerID":"NA","level":"NA","range":"NA","status":"NA"}]}]}';


$istargettingStart = '{"data":[{"id":"NA","info":[{"location":[{"longitude":"NA","latitude":"NA","altitude":"NA"}],"targetname":"NA","targetID":"NA"}]},{"id":"1","info":[{"location":[{"longitude":"-81.340586","latitude":"28.812932","altitude":"0.000000"}],"targetname":"John Doe","targetID":"JohnDoe@gmail.com"}]}]}';


//$setting   = $_POST['setting'];
//$setting   = $_GET['setting'];
//$playerID = $_GET['playerid'];

if($_POST['email']) {
//if($_GET['email']) {    
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

if ($setting == "checkemail") {


    $sql = "SELECT id FROM users WHERE email='$Email' LIMIT 1";
    $available = $dbh->prepare($sql);
    $available->execute();
    $u_count = $available->rowCount();

if ($u_count > 0){
    $success = 7;
    //echo '{"success":0,"error_message":"Email Address is already in use."}';

     } else {
    $success = 8;
 // echo '{"success":1,"error_message":"Email Address is ok to use."}';
   }

  } else {


$sqlUN = "SELECT username FROM users WHERE username LIKE '$username' LIMIT 1";
    $availableUN = $dbh->prepare($sqlUN);
    $availableUN->execute();
    $un_count = $availableUN->rowCount();

if ($un_count > 0){
    $success = 9;
    $UniqueID = 0;
    //echo '{"success":0,"error_message":"Email Address is already in use."}';

} else {


    $sql = "SELECT id FROM users WHERE email='$Email' LIMIT 1";
    $available = $dbh->prepare($sql);
    $available->execute();
    $u_count = $available->rowCount();
    
    
    $sql = "SELECT id FROM users WHERE username='$username' LIMIT 1";
    $available = $dbh->prepare($sql);
    $available->execute();
    $e_count = $available->rowCount();
//echo "E_Count = ".$e_count;
    
    if ($u_count > 0){ 
       // echo '{"success":0,"error_message":"Username already taken."}';



$time = date('Y-m-d H:i:s', time());

$TimeUpdateInfo = "UPDATE users SET username = :Username, lastvisitdate = :Time, DeviceToken = :Token, email = :Email WHERE email = \"$Email\"";
$stmt = $dbh->prepare($TimeUpdateInfo);
$stmt->bindParam(":Username", $username);
$stmt->bindParam(":Time", $time);
$stmt->bindParam(":Token", $deviceToken);
$stmt->bindParam(":Email", $Email);
$stmt->execute();


        echo '{"success":0,"error_message":"Welcome Back User."}';
        exit();
	}

    if ($e_count > 0){ 
        echo '{"success":0,"error_message":"Email Address is already in use, if you have forgotten your password please reset password."}';
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
        $stmt = $dbh->prepare("INSERT INTO users (username, password, email, privacy, DeviceToken, lastvisitdate, points, level, friends, bestfriends, itemInventory, userTerritory, missions, imageName, targets, isTargetting, cameras, skills, attributes, attributePoints) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $username);
        $stmt->bindParam(2, $password);
        $stmt->bindParam(3, $Email);
        $stmt->bindParam(4, $privacy);
        $stmt->bindParam(5, $deviceToken);
        $stmt->bindParam(6, $time);
        $stmt->bindParam(7, $points);
        $stmt->bindParam(8, $level);
        $stmt->bindParam(9, $bestfriendStart);
        $stmt->bindParam(10, $friendStart);
        $stmt->bindParam(11, $itemInventoryStart);
        $stmt->bindParam(12, $TerritoryStart);
        $stmt->bindParam(13, $missionStart);
        $stmt->bindParam(14, $imageNameStart);
        $stmt->bindParam(15, $targetStart);
        $stmt->bindParam(16, $istargettingStart);
        $stmt->bindParam(17, $cameraStart);
        $stmt->bindParam(18, $skillsStart);
        $stmt->bindParam(19, $attributesStart);
        $stmt->bindParam(20, $AttributePoints);



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

echo '{"success":0,"error_message":"Email Address is already in use."}';


} else if ($success == 9) {

echo "{\"success\":0,\"error_message\":\"username, $username, is already in use.\",\"uniqueID\":$UniqueID}";



} else if ($success == 8) {

echo '{"success":1,"error_message":"Email Address is ok to use."}';



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