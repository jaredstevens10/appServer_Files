<?php

header('Content-type: application/json');

/*
if($_GET) {

$username = $_GET['username'];
$email   = $_GET['email'];
$HomeID = $_GET['id'];
$Lat   = $_GET['lat'];
$Long   = $_GET['long'];
$Level   = $_GET['level'];
$Status   = $_GET['status'];
$GoldAmount   = $_GET['goldamount'];
$StartUpgrade   = $_GET['startupgrade'];
$EndUpgrade = $_GET['endupgrade'];
$Action = $_GET['action'];
*/



if($_POST) {

$username = $_POST['username'];
$email   = $_POST['email'];
$HomeID = $_POST['id'];
$Lat   = $_POST['lat'];
$Long   = $_POST['long'];
$Alt   = $_POST['alt'];
$Level   = $_POST['level'];
$Status   = $_POST['status'];
$GoldAmount   = $_POST['goldamount'];
$StartUpgrade   = $_POST['startupgrade'];
$EndUpgrade = $_POST['endupgrade'];
$Action = $_POST['action'];



$itemTypeName = "homebase";
//$itemTypeNameTwo = "isTargetting";



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


$stmtF->execute();
$rowF = $stmtF->fetch(PDO::FETCH_ASSOC);
$FriendsData = $rowF[$itemTypeName];
    

$FriendsArray = json_decode(json_encode($FriendsData), true);
$manage_array = get_object_vars(json_decode($FriendsData));


if ($HomeID == "") {
//echo "MissionID = blank";
$count = 0;
foreach( $manage_array['data'] as $key){
    $count += count( $key);
}

$HomeID = strval($count++);


//$TerritoryID = count($manage_array['data']);
} 



$GoSearch = SearchItemName($manage_array, $HomeID);

//echo "Go Search: ". $GoSearch;
//echo "was player found = ".$GoSearch;

if ($GoSearch) {


if ($Action == "delete") {

$GoSearchIndex = SearchItemNameindex($manage_array, $HomeID);

$manage = (array)json_decode($FriendsData, true);

unset($manage['data'][$GoSearchIndex]);

$NewFriendsEncodeDelete = json_encode($manage);


$stmt99 = $dbh->prepare("UPDATE users SET ".$itemTypeName." = '".$NewFriendsEncodeDelete."' WHERE email = '".$email."'");
$stmt99->execute();



echo '{"success":1,"error_message":"'.$HomeID.' has been removed"}';

exit;
} 



if ($Action == "updateStatus") {

$GoSearchIndex = SearchItemNameindex($manage_array, $HomeID);
$manage = (array)json_decode($FriendsData, true);

if (isset($manage['data'][$GoSearchIndex])) {

      $manage['data'][$GoSearchIndex]['info'][0]['status'] = $Status;

}


$NewFriendsEncodeDelete = json_encode($manage);

$stmt99 = $dbh->prepare("UPDATE users SET ".$itemTypeName." = '".$NewFriendsEncodeDelete."' WHERE email = '".$email."'");
$stmt99->execute();
echo '{"success":1,"error_message":"'.$HomeID.': Ammo = '.$ammoCount.'"}';
exit;

}

if ($Action == "updateLevel") {

$GoSearchIndex = SearchItemNameindex($manage_array, $HomeID);
$manage = (array)json_decode($FriendsData, true);

if (isset($manage['data'][$GoSearchIndex])) {
//echo "Ammo was ".$manage['data'][$GoSearchIndex]['ammoCount'];
      $manage['data'][$GoSearchIndex]['info'][0]['level'] = $Level;
//echo "Ammo was is NOW".$manage['data'][$GoSearchIndex]['ammoCount'];
}


$NewFriendsEncodeDelete = json_encode($manage);

$stmt99 = $dbh->prepare("UPDATE users SET ".$itemTypeName." = '".$NewFriendsEncodeDelete."' WHERE email = '".$email."'");
$stmt99->execute();
echo '{"success":1,"error_message":"'.$HomeID.': Level = '.$level.'"}';
exit;

}


if ($Action == "updateGoldAmount") {

$GoSearchIndex = SearchItemNameindex($manage_array, $HomeID);
$manage = (array)json_decode($FriendsData, true);

if (isset($manage['data'][$GoSearchIndex])) {
//echo "Ammo was ".$manage['data'][$GoSearchIndex]['ammoCount'];
      $manage['data'][$GoSearchIndex]['info'][0]['goldAmount'] = $GoldAmount;
//echo "Ammo was is NOW".$manage['data'][$GoSearchIndex]['ammoCount'];
}

//unset($manage['data'][$GoSearchIndex]);
$NewFriendsEncodeDelete = json_encode($manage);

$stmt99 = $dbh->prepare("UPDATE users SET ".$itemTypeName." = '".$NewFriendsEncodeDelete."' WHERE email = '".$email."'");
$stmt99->execute();
echo '{"success":1,"error_message":"'.$HomeID.'","count":0}';
exit;

}


if ($Action == "updateStartUpgrade") {

$GoSearchIndex = SearchItemNameindex($manage_array, $HomeID);
$manage = (array)json_decode($FriendsData, true);

if (isset($manage['data'][$GoSearchIndex])) {
//echo "Ammo was ".$manage['data'][$GoSearchIndex]['ammoCount'];
      $manage['data'][$GoSearchIndex]['info'][0]['startUpgrade'] = $StartUpgrade;
//echo "Ammo was is NOW".$manage['data'][$GoSearchIndex]['ammoCount'];
}

//unset($manage['data'][$GoSearchIndex]);
$NewFriendsEncodeDelete = json_encode($manage);

$stmt99 = $dbh->prepare("UPDATE users SET ".$itemTypeName." = '".$NewFriendsEncodeDelete."' WHERE email = '".$email."'");
$stmt99->execute();
echo '{"success":1,"error_message":"'.$HomeID.'","count":0}';
exit;

}

if ($Action == "updateEndUpgrade") {

$GoSearchIndex = SearchItemNameindex($manage_array, $HomeID);
$manage = (array)json_decode($FriendsData, true);

if (isset($manage['data'][$GoSearchIndex])) {
//echo "Ammo was ".$manage['data'][$GoSearchIndex]['ammoCount'];
      $manage['data'][$GoSearchIndex]['info'][0]['endUpgrade'] = $EndUpgrade;
//echo "Ammo was is NOW".$manage['data'][$GoSearchIndex]['ammoCount'];
}

//unset($manage['data'][$GoSearchIndex]);
$NewFriendsEncodeDelete = json_encode($manage);

$stmt99 = $dbh->prepare("UPDATE users SET ".$itemTypeName." = '".$NewFriendsEncodeDelete."' WHERE email = '".$email."'");
$stmt99->execute();
echo '{"success":1,"error_message":"'.$HomeID.'","count":0}';
exit;

}

if ($Action == "updateUpgradeTimes") {

$GoSearchIndex = SearchItemNameindex($manage_array, $HomeID);
$manage = (array)json_decode($FriendsData, true);

if (isset($manage['data'][$GoSearchIndex])) {
//echo "Ammo was ".$manage['data'][$GoSearchIndex]['ammoCount'];
      $manage['data'][$GoSearchIndex]['info'][0]['startUpgrade'] = $StartUpgrade;
      $manage['data'][$GoSearchIndex]['info'][0]['endUpgrade'] = $EndUpgrade;
//echo "Ammo was is NOW".$manage['data'][$GoSearchIndex]['ammoCount'];
}

//unset($manage['data'][$GoSearchIndex]);
$NewFriendsEncodeDelete = json_encode($manage);

$stmt99 = $dbh->prepare("UPDATE users SET ".$itemTypeName." = '".$NewFriendsEncodeDelete."' WHERE email = '".$email."'");
$stmt99->execute();
echo '{"success":1,"error_message":"'.$HomeID.'","count":0}';
exit;

}



if ($Action == "updateLocation") {

$GoSearchIndex = SearchItemNameindex($manage_array, $HomeID);
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
echo '{"success":1,"error_message":"'.$HomeID.'","count":1}';


exit;

}



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



$imageURL = "MissionMapOutside";
$objectURL = "Hammer";
$textureURL = "Metal.jpg";

$AllMissionInfo[] = Array('location' => $LocationInfo, 'name' => $Name, 'level' => $Level, 'goldAmount' => $GoldAmount, 'status' => $Status, 'startUpgrade' => $StartUpgrade, 'endUpgrade' => $EndUpgrade);


$manage['data'][] = Array(
    'id' => $HomeID,
    'info' => $AllMissionInfo
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