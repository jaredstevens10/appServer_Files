<?php

header('Content-type: application/json');

/*
if($_GET) {

$email   = $_GET['email'];
$MissionID = $_GET['missionID'];
$Lat   = $_GET['lat'];
$Long   = $_GET['long'];
$Alt   = $_GET['alt'];
$Level   = $_GET['level'];
$Status   = $_GET['status'];
$ObjectiveStart   = $_GET['objective'];
$XP   = $_GET['xp'];
$Action = $_GET['action'];
$MissionName = $_GET['missionname'];
*/


if($_POST) {

$email   = $_POST['email'];
$MissionID = $_POST['missionID'];
$Lat   = $_POST['lat'];
$Long   = $_POST['long'];
$Alt   = $_POST['alt'];
$Level   = $_POST['level'];
$Status   = $_POST['status'];
$ObjectiveStart   = $_POST['objective'];
$XP   = $_POST['xp'];
$Action = $_POST['action'];
$MissionNameStart = $_POST['missionname'];
$ImageName = $_POST['imagename'];
$radius = $_POST['radius'];
$Category = $_POST['category'];
$CategoryTitle = $_POST['categorytitle'];


$Objective = rawurldecode($ObjectiveStart);
$MissionName = rawurldecode($MissionNameStart);



//$radius = 0.05;
$angle = deg2rad(mt_rand(0, 359));
$pointRadius = mt_rand(0*100, $radius*100) / 100;
$NewLat = $Lat + (sin($angle) * $pointRadius);
$NewLong = $Long + (cos($angle) * $pointRadius);

$itemTypeName = "missions";



$time = date('Y-m-d H:i:s', time());

		require('/var/www/html/Apps/AppsConfig.php'); 
$dbname = "Stevens_GeoHunters";

define('DIR','http://'.$servername.'/Apps/BattleField/');
define('SITEEMAIL','admin@'.$emailServer.'.com');


try {

	//create PDO connection 
	//$db = new PDO("mysql:host=".DBHOST.";port=8889;dbname=".DBNAME, DBUSER, DBPASS);
	$dbh = new PDO("mysql:host=$servername;dbname=$dbname", $db_username, $db_password);


	//if no errors have been created carry on
	if(!isset($error)){

		//create the activasion code
		$token = md5(uniqid(rand(),true));



$stmtF = $dbh->prepare("Select ".$itemTypeName." FROM users WHERE email = \"".$email."\"");


//$stmtF = $dbh->prepare("Select \"".$FriendType."\" FROM Members WHERE PlayerID = \"".$playerID."\"");
//$stmtF = $dbh->prepare("Select friends FROM Members WHERE PlayerID = \"".$playerID."\"");

$stmtF->execute();
$rowF = $stmtF->fetch(PDO::FETCH_ASSOC);
$FriendsData = $rowF[$itemTypeName];
    

$FriendsArray = json_decode(json_encode($FriendsData), true);
$manage_array = get_object_vars(json_decode($FriendsData));


if ($MissionID == "") {
echo "MissionID = blank";
$count = 0;
foreach( $manage_array['data'] as $key){
    $count += count( $key);
}

$MissionID = strval($count++);


//$TerritoryID = count($manage_array['data']);
} 

//echo "Mission ID = ".$MissionID;

$GoSearch = SearchItemName($manage_array, $MissionID);
//echo "was player found = ".$GoSearch;

if ($GoSearch) {


if ($Action == "delete") {

$GoSearchIndex = SearchItemNameindex($manage_array, $MissionID);

$manage = (array)json_decode($FriendsData, true);

unset($manage['data'][$GoSearchIndex]);

$NewFriendsEncodeDelete = json_encode($manage);

//Echo "new array = ".$NewFriendsEncode;

$stmt99 = $dbh->prepare("UPDATE users SET ".$itemTypeName." = '".$NewFriendsEncodeDelete."' WHERE email = '".$email."'");
$stmt99->execute();
echo '{"success":1,"error_message":"'.$MissionID.' has been removed"}';

exit;
} 



if ($Action == "updateStatus") {

$GoSearchIndex = SearchItemNameindex($manage_array, $MissionID);
$manage = (array)json_decode($FriendsData, true);

if (isset($manage['data'][$GoSearchIndex])) {
//echo "Status was ".$manage['data'][$GoSearchIndex]['info']['status'];
      $manage['data'][$GoSearchIndex]['info'][0]['status'] = $Status;
//echo "Statis is NOW".$manage['data'][$GoSearchIndex]['info']['status'];
}

//unset($manage['data'][$GoSearchIndex]);
$NewFriendsEncodeDelete = json_encode($manage);

$stmt99 = $dbh->prepare("UPDATE users SET ".$itemTypeName." = '".$NewFriendsEncodeDelete."' WHERE email = '".$email."'");
$stmt99->execute();
echo '{"success":1,"error_message":"'.$MissionID.': Ammo = '.$ammoCount.'"}';
exit;

}

if ($Action == "updateLevel") {

$GoSearchIndex = SearchItemNameindex($manage_array, $MissionID);
$manage = (array)json_decode($FriendsData, true);

if (isset($manage['data'][$GoSearchIndex])) {
//echo "Ammo was ".$manage['data'][$GoSearchIndex]['ammoCount'];
      $manage['data'][$GoSearchIndex]['info'][0]['level'] = $Level;
//echo "Ammo was is NOW".$manage['data'][$GoSearchIndex]['ammoCount'];
}

//unset($manage['data'][$GoSearchIndex]);
$NewFriendsEncodeDelete = json_encode($manage);

$stmt99 = $dbh->prepare("UPDATE users SET ".$itemTypeName." = '".$NewFriendsEncodeDelete."' WHERE email = '".$email."'");
$stmt99->execute();
echo '{"success":1,"error_message":"'.$MissionID.': Level = '.$level.'"}';
exit;

}


if ($Action == "updateObjective") {

$GoSearchIndex = SearchItemNameindex($manage_array, $MissionID);
$manage = (array)json_decode($FriendsData, true);

if (isset($manage['data'][$GoSearchIndex])) {
//echo "Ammo was ".$manage['data'][$GoSearchIndex]['ammoCount'];
      $manage['data'][$GoSearchIndex]['info'][0]['objective'] = $Objective;
//echo "Ammo was is NOW".$manage['data'][$GoSearchIndex]['ammoCount'];
}

//unset($manage['data'][$GoSearchIndex]);
$NewFriendsEncodeDelete = json_encode($manage);

$stmt99 = $dbh->prepare("UPDATE users SET ".$itemTypeName." = '".$NewFriendsEncodeDelete."' WHERE email = '".$email."'");
$stmt99->execute();
echo '{"success":1,"error_message":"'.$MissionID.'":"count":"'.$count.'"}';
exit;

}

if ($Action == "updateLocation") {

$GoSearchIndex = SearchItemNameindex($manage_array, $MissionID);
$manage = (array)json_decode($FriendsData, true);

if (isset($manage['data'][$GoSearchIndex])) {

//print_r($manage['data'][$GoSearchIndex]['info'][0]['location'])/;

//echo "Info was ".$manage['data'][$GoSearchIndex]['info'][0]['location'][0]['latitude']."\n";

//echo "Latitude was ".$manage['data'][$GoSearchIndex]['info']['location']['latitude']."\n";
//echo "Longitude was ".$manage['data'][$GoSearchIndex]['info']['location']['longitude']."\n";
      $manage['data'][$GoSearchIndex]['info'][0]['location'][0]['latitude'] = $Lat;
      $manage['data'][$GoSearchIndex]['info'][0]['location'][0]['longitude'] = $Long;
      $manage['data'][$GoSearchIndex]['info'][0]['location'][0]['altitude'] = $Alt;
//echo "Latitude is NOW".$manage['data'][$GoSearchIndex]['info']['location']['latitude']."\n";
//echo "Longitude is NOW".$manage['data'][$GoSearchIndex]['info']['location']['longitude']."\n";
}



//unset($manage['data'][$GoSearchIndex]);
$NewFriendsEncodeDelete = json_encode($manage);
//echo "New Mission Array: ".$NewFriendsEncodeDelete;


$stmt99 = $dbh->prepare("UPDATE users SET ".$itemTypeName." = '".$NewFriendsEncodeDelete."' WHERE email = '".$email."'");
$stmt99->execute();
echo '{"success":1,"error_message":"'.$MissionID.'":"count":"'.$count.'"}';


exit;

}


if ($Action == "refreshLocation") {

$GoSearchIndex = SearchItemNameindex($manage_array, $MissionID);
$manage = (array)json_decode($FriendsData, true);

$angle = deg2rad(mt_rand(0, 359));
$pointRadius = mt_rand(0*100, $radius*100) / 100;
$NewLat = $Lat + (sin($angle) * $pointRadius);
$NewLong = $Long + (cos($angle) * $pointRadius);
$NewAlt = 0.000000;

if (isset($manage['data'][$GoSearchIndex])) {

//print_r($manage['data'][$GoSearchIndex]['info'][0]['location'])/;
//echo "Info was ".$manage['data'][$GoSearchIndex]['info'][0]['location'][0]['latitude']."\n";
//echo "Latitude was ".$manage['data'][$GoSearchIndex]['info']['location']['latitude']."\n";
//echo "Longitude was ".$manage['data'][$GoSearchIndex]['info']['location']['longitude']."\n";
      $manage['data'][$GoSearchIndex]['info'][0]['location'][0]['latitude'] = $NewLat;
      $manage['data'][$GoSearchIndex]['info'][0]['location'][0]['longitude'] = $NewLong;
      $manage['data'][$GoSearchIndex]['info'][0]['location'][0]['altitude'] = $NewAlt;
//echo "Latitude is NOW".$manage['data'][$GoSearchIndex]['info']['location']['latitude']."\n";
//echo "Longitude is NOW".$manage['data'][$GoSearchIndex]['info']['location']['longitude']."\n";
}



//unset($manage['data'][$GoSearchIndex]);
$NewFriendsEncodeDelete = json_encode($manage);
//echo "New Mission Array: ".$NewFriendsEncodeDelete;


$stmt99 = $dbh->prepare("UPDATE users SET ".$itemTypeName." = '".$NewFriendsEncodeDelete."' WHERE email = '".$email."'");
$stmt99->execute();
echo '{"success":1,"error_message":"'.$MissionID.'":"count":"'.$count.'"}';


exit;

}





/*
if ($Action == "add") {
if ($FriendType == "bestfriends")  {
echo '{"success":3,"error_message":"'.$itemName.' is already in our inventory"}';
exit;
} else {
echo '{"success":3,"error_message":"'.$itemName.' is already in our inventory"}';
exit;
}
}
*/

} else {

//echo "player was not found";

if ($Action == "delete") {

echo '{"success":3,"error_message":"'.$MissionID.' is not currently listed"}';
exit;
} else {

/*
$radius = 0.05;
$angle = deg2rad(mt_rand(0, 359));
$pointRadius = mt_rand(0*100, $radius*100) / 100;
$NewLat = $Lat + (sin($angle) * $pointRadius);
$NewLong = $Long + (cos($angle) * $pointRadius);

*/

//echo "New Lat: ".$NewLat;
//echo "New Long: ".$NewLong;


$ImageURLtest = "Gun";
$ObjectURLtest = "testObject";
$TextureURLtest = "testTexture";

$manage = (array)json_decode($FriendsData, true);

$LocationInfo[] = Array('longitude' => $NewLong, 'latitude' => $NewLat, 'altitude' => $NewAlt);

//$Point2Info[] = Array('longitude' => $PointLong2, 'latitude' => $PointLat2);
//$Point3Info[] = Array('longitude' => $PointLong3, 'latitude' => $PointLat3);
//$Point4Info[] = Array('longitude' => $PointLong4, 'latitude' => $PointLat4);
//$Point5Info[] = Array('longitude' => $PointLong5, 'latitude' => $PointLat5);
//,\"missionCategory\":\"$MissionCategory\",\"categoryTitle\":\"$CategoryTitle\"

$AllMissionInfo[] = Array('location' => $LocationInfo, 'name' => $MissionName, 'status' => $Status, 'level' => $Level, 'objective' => $Objective, 'xp' => $XP, 'imageURL' => $ImageName, 'objectURL' => $ObjectURLtest, 'textureURL' => $TextureURLtest, 'category' => $Category, 'categoryTitle' => $CategoryTitle);


$manage['data'][] = Array(
    'id' => $MissionID,
    'info' => $AllMissionInfo
);



$NewFriendsEncode = json_encode($manage);

//echo $NewFriendsEncode;

$stmt5 = $dbh->prepare("UPDATE users SET ".$itemTypeName." = '".$NewFriendsEncode."' WHERE email = '".$email."'");

        /*** execute the query ***/
$stmt5->execute();
$success = $stmt5->rowCount();
//$success = 1;


  }
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
			

echo '{"success":1,"Added Mission":"'.$MissionID.'"}';

exit;

				} else {
					echo '{"success":2,"error_message":"No Status Change."}';
				}
	
} else {
    
    echo '{"success":0,"error_message":"Connection Error."}';
    
}



function search($array, $key, $value)
{
    $results = array();

    if (is_array($array)) {
        if (isset($array[$key]) && $array[$key] == $value) {
            $results[] = $array;
        }

        foreach ($array as $subarray) {
            $results = array_merge($results, search($subarray, $key, $value));
}

    }

    return $results;
}




function objToArray($obj, &$arr){
    if(!is_object($obj) && !is_array($obj)){
        $arr = $obj;
        return $arr;
    }

    foreach ($obj as $key => $value)
    {
        if (!empty($value))
        {
            $arr[$key] = array();
            objToArray($value, $arr[$key]);
        }
        else
        {
            $arr[$key] = $value;
        }
    }
    return $arr;
}





function SearchItemNameindex($array, $SearchID) {
$IDindex = 0;

foreach ($array['data'] as $key=>$value) {
//echo "ID Index current value = ".$IDindex;
if ($value->id == $SearchID) {
return $IDindex;
  }
$IDindex++;

}

return 0;
}


function SearchItemName($array, $SearchID) {
foreach ($array['data'] as $key=>$value) {
if ($value->id == $SearchID) {
return true;
  }
}
return false;
}




?>


    

  