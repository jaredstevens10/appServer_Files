<?php

header('Content-type: application/json');


if($_GET) {

$username = $_GET['username'];
$email   = $_GET['email'];
$MissionID = $_GET['missionID'];
$Lat   = $_GET['lat'];
$Long   = $_GET['long'];
$Alt  = $_GET['alt'];
$Level   = $_GET['level'];
$Status   = $_GET['status'];
$Objective   = $_GET['objective'];
$XP   = $_GET['xp'];
$Action = $_GET['action'];
$TargetName = $_GET['targetname'];
$TargetEmail = $_GET['targetemail'];
$Range = $_GET['range'];

$Category = $_GET['category'];
$TeamName = $_GET['teamname'];
$MemberID = $_GET['memberid'];
$MemberTitle = $_GET['membertitle'];
$MemberStatus = $_GET['memberstatus'];
$MemberUsername = $_GET['memberusername'];
$MemberEmail = $_GET['memberemail'];
$Category = $_GET['category'];
$CategoryTitle = $_GET['categorytitle'];


$StartTime = date('Y-m-d H:i:s', time());
$EndTime = date('Y-m-d H:i:s', time());



/*
if($_POST) {

$username = $_POST['username'];
$email   = $_POST['email'];
$MissionID = $_POST['missionID'];
$Lat   = $_POST['lat'];
$Long   = $_POST['long'];
$Alt  = $_POST['alt'];
$Level   = $_POST['level'];
$Status   = $_POST['status'];
$Objective   = $_POST['objective'];
$XP   = $_POST['xp'];

$Action = $_POST['action'];
$Category = $_POST['category'];
$TeamName = $_POST['teamname'];
$MemberID = $_POST['memberid'];
$MemberTitle = $_POST['membertitle'];
$MemberStatus = $_POST['memberstatus'];
$MemberUsername = $_POST['memberusername'];
$MemberEmail = $_POST['memberemail'];

$TargetName = $_POST['targetname'];
$TargetEmail = $_POST['targetemail'];
$Range = $_POST['range'];

$Category = $_POST['category'];
$CategoryTitle = $_POST['categorytitle'];

*/



$itemTypeName = $Category;


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



$stmtF = $dbh->prepare("Select ".$itemTypeName." FROM TeamInfo WHERE teamName = \"".$TeamName."\"");



$stmtF->execute();
$rowF = $stmtF->fetch(PDO::FETCH_ASSOC);
$FriendsData = $rowF[$itemTypeName];
    
//echo $FriendsData;

$FriendsArray = json_decode(json_encode($FriendsData), true);
$manage_array = get_object_vars(json_decode($FriendsData));



if ($MissionID == "") {
//echo "MemberID = blank";
$count = 0;
foreach( $manage_array['data'] as $key){
    $count += count( $key);
}

$MemberID = strval($count++);




//$TerritoryID = count($manage_array['data']);
} 

//echo "Mission ID = ".$MissionID;

/*
if ($Category == "members") {

$GoSearch = SearchItemName($manage_array, $Email);

}
*/

$GoSearch = SearchItemName($manage_array, $MissionID);

//echo "Go Search: ". $GoSearch;
//echo "was player found = ".$GoSearch;

if ($GoSearch) {


if ($Action == "delete") {

$GoSearchIndex = SearchItemNameindex($manage_array, $MissionID);

$manage = (array)json_decode($FriendsData, true);

unset($manage['data'][$GoSearchIndex]);

$NewFriendsEncodeDelete = json_encode($manage);

//Echo "new array = ".$NewFriendsEncode;

$stmt99 = $dbh->prepare("UPDATE TeamInfo SET ".$itemTypeName." = '".$NewFriendsEncodeDelete."' WHERE teamName = '".$TeamName."'");
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

$stmt99 = $dbh->prepare("UPDATE TeamInfo SET ".$itemTypeName." = '".$NewFriendsEncodeDelete."' WHERE teamName = '".$TeamName."'");
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

$stmt99 = $dbh->prepare("UPDATE TeamInfo SET ".$itemTypeName." = '".$NewFriendsEncodeDelete."' WHERE teamName = '".$TeamName."'");
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

$stmt99 = $dbh->prepare("UPDATE TeamInfo SET ".$itemTypeName." = '".$NewFriendsEncodeDelete."' WHERE email = '".$email."'");
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
echo "New Mission Array: ".$NewFriendsEncodeDelete;


$stmt99 = $dbh->prepare("UPDATE TeamInfo SET ".$itemTypeName." = '".$NewFriendsEncodeDelete."' WHERE teamName = '".$TeamName."'");
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


$manage = (array)json_decode($FriendsData, true);

//print_r ($manage);

$LocationInfo[] = Array('longitude' => $Long, 'latitude' => $Lat, 'altitude' => $Alt);

$time = date('Y-m-d H:i:s', time());

/*
{"id":"NA","info":[{"location":[{"longitude":"NA","latitude":"NA"}],"targetname":"NA","targetID":"NA","startTime":"NA","endTime":"NA","ownername":"NA","ownerID":"NA","level":"NA","range":"NA","status":"NA"}]}
*/


$AllMissionInfo[] = Array('location' => $LocationInfo, 'username' => $MemberUsername, 'email' => $MemberEmail, 'title' => $MemberTitle, 'status' => $MemberStatus);


$manage['data'][] = Array(
    'id' => $MissionID,
    'info' => $AllMissionInfo
);



$NewFriendsEncode = json_encode($manage);

$stmt5 = $dbh->prepare("UPDATE TeamInfo SET ".$itemTypeName." = '".$NewFriendsEncode."' WHERE teamName = '".$TeamName."'");

        /*** execute the query ***/
$stmt5->execute();
$success = $stmt5->rowCount();
$success = 1;



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
			

echo '{"success":1}';

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

function SearchMemberName($array, $SearchID) {
foreach ($array['data'] as $key=>$value) {
if ($value->id == $SearchID) {
return true;
  }
}
return false;
}

?>