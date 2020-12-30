<?php

ini_set ("display_errors", "1"); 
error_reporting(E_ALL);  

$firstName = $_POST["firstName"];
$lastName = $_POST["lastName"];
$userId = $_POST["userId"];

//$target_dir = "wp-content/uploads/2015/02";

//$target_dir = "home/clavenso/public_html/Apps/Pics&Quotes/GameData";

//$target_dir1 = "../BattleField/GameData";
$target_dir1 = "/var/www/html/Apps/BattleField/GameData";


require('/var/www/html/Apps/AppsConfig.php'); 
$dbname = "Stevens_GeoHunters";

define('DIR','http://'.$servername.'/Apps/BattleField/');
define('SITEEMAIL','admin@'.$emailServer.'.com');


if(!file_exists($target_dir1))

//$target_dir = "../Apps/Pics&Quotes/GameData";if(!file_exists($target_dir))
{
mkdir($target_dir1, 0777, true);
}

$target_dir = $target_dir1 . "/" . basename($_FILES["file"]["name"]);

if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_dir)) 
{
echo json_encode([
"Message" => "The file ". basename( $_FILES["file"]["name"]). " has been uploaded to file path ".$target_dir1.".",
"Status" => "OK",
"userId" => $_REQUEST["userId"]
]);

} else {

echo json_encode([
"Message" => "Sorry, there was an error uploading your file.",
"Status" => "Error",
"userId" => $_REQUEST["userId"]
]);

}
?>