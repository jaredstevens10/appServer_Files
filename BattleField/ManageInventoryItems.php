<?php

header('Content-type: application/json');

/*
if($_GET) {

$email   = $_GET['email'];
$itemName = $_GET['itemName'];
$itemURL = $_GET['itemURL'];
$itemURL100 = $_GET['itemURL100'];
$category = $_GET['category'];
$count = $_GET['count'];
$ammoCount = $_GET['ammoCount'];
$level = $_GET['level'];
$Action = $_GET['action'];
*/


if($_POST) {

$email   = $_POST['email'];
$itemName = $_POST['itemName'];
$itemURL = $_POST['itemURL'];
$itemURL100 = $_POST['itemURL100'];
$category = $_POST['category'];
$count = $_POST['count'];
$ammoCount = $_POST['ammoCount'];
$level = $_POST['level'];
$Action = $_POST['action'];

$range = $_POST['range'];
$viewRange = $_POST['viewRange'];
$power = $_POST['power'];
$speed = $_POST['speed'];



$itemTypeName = "itemInventory";


/*
$username = $_POST['username'];
$userID = $_POST['userID'];
$date = $_POST['date'];
$comments2 = $_POST['comment'];
$reply = $_POST['reply'];
$repliedUsername = $_POST['replyuser'];
$repliedUserID = $_POST['replyuserID'];
$comments = rawurldecode($comments2);
*/


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


$GoSearch = SearchItemName($manage_array, $itemName);
//echo "was player found = ".$GoSearch;

if ($GoSearch) {


if ($Action == "delete") {

$GoSearchIndex = SearchItemNameindex($manage_array, $itemName);

$manage = (array)json_decode($FriendsData, true);

unset($manage['data'][$GoSearchIndex]);

$NewFriendsEncodeDelete = json_encode($manage);

//Echo "new array = ".$NewFriendsEncode;

$stmt99 = $dbh->prepare("UPDATE users SET ".$itemTypeName." = '".$NewFriendsEncodeDelete."' WHERE email = '".$email."'");
$stmt99->execute();
echo '{"success":1,"error_message":"'.$itemName.' has been removed"}';

exit;
} 



if ($Action == "updateAmmo") {

$GoSearchIndex = SearchItemNameindex($manage_array, $itemName);
$manage = (array)json_decode($FriendsData, true);

if (isset($manage['data'][$GoSearchIndex])) {
//echo "Ammo was ".$manage['data'][$GoSearchIndex]['ammoCount'];
      $manage['data'][$GoSearchIndex]['ammoCount'] = $ammoCount;
//echo "Ammo was is NOW".$manage['data'][$GoSearchIndex]['ammoCount'];
}

//unset($manage['data'][$GoSearchIndex]);
$NewFriendsEncodeDelete = json_encode($manage);

$stmt99 = $dbh->prepare("UPDATE users SET ".$itemTypeName." = '".$NewFriendsEncodeDelete."' WHERE email = '".$email."'");
$stmt99->execute();
echo '{"success":1,"error_message":"'.$itemName.': Ammo = '.$ammoCount.'"}';
exit;

}

if ($Action == "updateLevel") {

$GoSearchIndex = SearchItemNameindex($manage_array, $itemName);
$manage = (array)json_decode($FriendsData, true);

if (isset($manage['data'][$GoSearchIndex])) {
//echo "Ammo was ".$manage['data'][$GoSearchIndex]['ammoCount'];
      $manage['data'][$GoSearchIndex]['level'] = $level;
//echo "Ammo was is NOW".$manage['data'][$GoSearchIndex]['ammoCount'];
}

//unset($manage['data'][$GoSearchIndex]);
$NewFriendsEncodeDelete = json_encode($manage);

$stmt99 = $dbh->prepare("UPDATE users SET ".$itemTypeName." = '".$NewFriendsEncodeDelete."' WHERE email = '".$email."'");
$stmt99->execute();
echo '{"success":1,"error_message":"'.$itemName.': Level = '.$level.'"}';
exit;

}


if ($Action == "updateCount") {

$GoSearchIndex = SearchItemNameindex($manage_array, $itemName);
$manage = (array)json_decode($FriendsData, true);

if (isset($manage['data'][$GoSearchIndex])) {
//echo "Ammo was ".$manage['data'][$GoSearchIndex]['ammoCount'];
      $manage['data'][$GoSearchIndex]['count'] = $count;
//echo "Ammo was is NOW".$manage['data'][$GoSearchIndex]['ammoCount'];
}

//unset($manage['data'][$GoSearchIndex]);
$NewFriendsEncodeDelete = json_encode($manage);

$stmt99 = $dbh->prepare("UPDATE users SET ".$itemTypeName." = '".$NewFriendsEncodeDelete."' WHERE email = '".$email."'");
$stmt99->execute();
echo '{"success":1,"error_message":"'.$itemName.': Count = '.$count.'"}';
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

echo '{"success":3,"error_message":"'.$itemName.' is not currently listed"}';
exit;
} else {


$manage = (array)json_decode($FriendsData, true);

$manage['data'][] = Array(
    'item' => $itemName,
    'itemURL' => $itemURL,
    'itemURL100' => $itemURL100,
    'category' => $category,
    'count' => $count,
    'ammoCount' => $ammoCount,
    'level' => $level,
    'range' => $range,
    'viewRange' => $viewRange,
    'power' => $power,
    'speed' => $speed
);


$NewFriendsEncode = json_encode($manage);

$stmt5 = $dbh->prepare("UPDATE users SET ".$itemTypeName." = '".$NewFriendsEncode."' WHERE email = '".$email."'");

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
if ($value->item == $SearchID) {
return $IDindex;
  }
$IDindex++;

}

return 0;
}


function SearchItemName($array, $SearchID) {
foreach ($array['data'] as $key=>$value) {
if ($value->item == $SearchID) {
return true;
  }
}
return false;
}
?>