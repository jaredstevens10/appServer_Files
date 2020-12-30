<?php

header('Content-type: application/json');


if($_POST) {

$TargetUserID   = $_POST['targetuserid'];
$MyUserID = $_POST['myuserid'];
$Action = $_POST['action'];
$Status = $_POST['status'];
$TargetUserName = $_POST['targetusername'];

/*
if($_GET) {

$TargetUserID   = $_GET['targetuserid'];
$MyUserID = $_GET['myuserid'];
$Action = $_GET['action'];
$Status = $_GET['status'];
$TargetUserName = $_GET['targetusername'];
*/


$itemTypeName = "friends";



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



$stmtF = $dbh->prepare("Select ".$itemTypeName." FROM users WHERE email = \"".$MyUserID."\"");


//$stmtF = $dbh->prepare("Select \"".$FriendType."\" FROM Members WHERE PlayerID = \"".$playerID."\"");
//$stmtF = $dbh->prepare("Select friends FROM Members WHERE PlayerID = \"".$playerID."\"");

$stmtF->execute();
$rowF = $stmtF->fetch(PDO::FETCH_ASSOC);
$FriendsData = $rowF[$itemTypeName];
    

$FriendsArray = json_decode(json_encode($FriendsData), true);
$manage_array = get_object_vars(json_decode($FriendsData));


if ($TargetUserID == "") {
echo "TargetUserID = blank";
$count = 0;
foreach( $manage_array['data'] as $key){
    $count += count( $key);
}

//$TargetUserID = strval($count++);


//$TerritoryID = count($manage_array['data']);
} 

//echo "Mission ID = ".$MissionID;

$GoSearch = SearchItemName($manage_array, $TargetUserID);
//echo "was player found = ".$GoSearch;

if ($GoSearch) {

if ($Action == "check") {

$GoSearchIndex = SearchItemNameindex($manage_array, $TargetUserID);
$manage = (array)json_decode($FriendsData, true);

$UserAllyStatus = $manage['data'][$GoSearchIndex]['status'];

echo '{"success":1,"error_message":"'.$TargetUserID.' was found","UserAllyStatus":"'.$UserAllyStatus.'"}';

exit;
}


if ($Action == "delete") {

$GoSearchIndex = SearchItemNameindex($manage_array, $TargetUserID);

$manage = (array)json_decode($FriendsData, true);

unset($manage['data'][$GoSearchIndex]);

$NewFriendsEncodeDelete = json_encode($manage);

//Echo "new array = ".$NewFriendsEncode;

$stmt99 = $dbh->prepare("UPDATE users SET ".$itemTypeName." = '".$NewFriendsEncodeDelete."' WHERE email = '".$MyUserID."'");
$stmt99->execute();

echo '{"success":1,"error_message":"'.$TargetUserID.' has been removed"}';

exit;
} 



if ($Action == "updateStatus") {

$GoSearchIndex = SearchItemNameindex($manage_array, $TargetUserID);
$manage = (array)json_decode($FriendsData, true);

if (isset($manage['data'][$GoSearchIndex])) {
//echo "Status was ".$manage['data'][$GoSearchIndex]['info']['status'];
      $manage['data'][$GoSearchIndex]['status'] = $Status;
//echo "Statis is NOW".$manage['data'][$GoSearchIndex]['info']['status'];
}

//unset($manage['data'][$GoSearchIndex]);
$NewFriendsEncodeDelete = json_encode($manage);

$stmt99 = $dbh->prepare("UPDATE users SET ".$itemTypeName." = '".$NewFriendsEncodeDelete."' WHERE email = '".$MyUserID."'");
$stmt99->execute();
echo '{"success":1,"error_message":"'.$TargetUserID.'","NewStatus":"'.$Status.'"}';
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

if ($Action == "check") {


echo '{"success":1,"error_message":"'.$TargetUserID.' was Not found","UserAllyStatus":"unknown"}';

exit;

}

if ($Action == "delete") {

echo '{"success":3,"error_message":"'.$TargetUserID.' is not currently listed"}';
exit;
} else {


$manage = (array)json_decode($FriendsData, true);

//$LocationInfo[] = Array('longitude' => $Long, 'latitude' => $Lat);

//$Point2Info[] = Array('longitude' => $PointLong2, 'latitude' => $PointLat2);
//$Point3Info[] = Array('longitude' => $PointLong3, 'latitude' => $PointLat3);
//$Point4Info[] = Array('longitude' => $PointLong4, 'latitude' => $PointLat4);
//$Point5Info[] = Array('longitude' => $PointLong5, 'latitude' => $PointLat5);

//$AllMissionInfo[] = Array('location' => $LocationInfo, 'status' => $Status, 'level' => $Level, 'objective' => $Objective, 'xp' => $XP);


$manage['data'][] = Array(
    'username' => $TargetUserName,
    'userid' => $TargetUserID,
    'status' => $Status
);



$NewFriendsEncode = json_encode($manage);

$stmt5 = $dbh->prepare("UPDATE users SET ".$itemTypeName." = '".$NewFriendsEncode."' WHERE email = '".$MyUserID."'");

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
if ($value->userid == $SearchID) {
return $IDindex;
  }
$IDindex++;

}

return 0;
}


function SearchItemName($array, $SearchID) {
foreach ($array['data'] as $key=>$value) {
if ($value->userid == $SearchID) {
return true;
  }
}
return false;
}
?>