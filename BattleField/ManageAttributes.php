<?php

header('Content-type: application/json');

/*
if($_GET) {

$email   = $_GET['email'];
$ID = $_GET['id'];
$Awareness   = $_GET['awareness'];
$Charisma   = $_GET['charisma'];
$Credibility  = $_GET['credibility'];
$Endurance   = $_GET['endurance'];
$Intelligence = $_GET['intelligence'];
$Speed = $_GET['speed'];
$Strength = $_GET['strength'];
$Vision = $_GET['vision'];

$Action = $_GET['action'];

*/


if($_POST) {

$email   = $_POST['email'];
$ID = $_POST['id'];
$Awareness   = $_POST['awareness'];
$Charisma   = $_POST['charisma'];
$Credibility   = $_POST['credibility'];
$Endurance   = $_POST['endurance'];
$Intelligence = $_POST['intelligence'];
$Speed = $_POST['speed'];
$Strength = $_POST['strength'];
$Vision = $_POST['vision'];

$Action = $_POST['action'];


$CurrentPoints = $_POST['currentPoints'];




$itemTypeName = "attributes";



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



/*
if ($ID == "") {
//echo "SkillsID = blank";
$count = 0;
foreach( $manage_array['data'] as $key){
    $count += count( $key);
}

$ID = strval($count++);


} 
*/


$GoSearch = SearchItemName($manage_array, $ID);
//echo "was player found = ".$GoSearch;

if ($GoSearch) {




if ($Action == "update") {

$GoSearchIndex = SearchItemNameindex($manage_array, $ID);
$manage = (array)json_decode($FriendsData, true);

if (isset($manage['data'][$GoSearchIndex])) {
//echo "Status was ".$manage['data'][$GoSearchIndex]['info']['status'];
      $manage['data'][$GoSearchIndex]['info'][0]['awareness'] = $Awareness;
      $manage['data'][$GoSearchIndex]['info'][0]['charisma'] = $Charisma;
      $manage['data'][$GoSearchIndex]['info'][0]['credibility'] = $Credibility;
      $manage['data'][$GoSearchIndex]['info'][0]['endurance'] = $Endurance;
      $manage['data'][$GoSearchIndex]['info'][0]['intelligence'] = $Intelligence;
      $manage['data'][$GoSearchIndex]['info'][0]['speed'] = $Speed;
      $manage['data'][$GoSearchIndex]['info'][0]['strength'] = $Strength;
      $manage['data'][$GoSearchIndex]['info'][0]['vision'] = $Vision;
//echo "Statis is NOW".$manage['data'][$GoSearchIndex]['info']['status'];
}

//unset($manage['data'][$GoSearchIndex]);
$NewFriendsEncodeDelete = json_encode($manage);

$stmt99 = $dbh->prepare("UPDATE users SET ".$itemTypeName." = '".$NewFriendsEncodeDelete."', attributePoints = '".$CurrentPoints."' WHERE email = '".$email."'");
$stmt99->execute();
echo '{"success":1,"error_message":"attributes updated"}';
exit;

}


if ($Action == "addPoints") {



$stmt99 = $dbh->prepare("UPDATE users SET attributePoints = '".$CurrentPoints."' WHERE email = '".$email."'");
$stmt99->execute();
echo '{"success":1,"error_message":"attributes points added"}';
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



echo '{"success":3,"error_message":"'.$ID.' is not currently listed"}';
exit;

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
			

echo '{"success":1,"Added New Skill":"'.$ID.'"}';

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


    

  