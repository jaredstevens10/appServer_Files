<?php
ob_start();
session_start();

//set timezone
date_default_timezone_set('Europe/London');

//database credentials
//define('DBHOST','localhost');
//define('DBUSER','clavenso_Admin');
//define('DBPASS','claven01*');
//define('DBNAME','clavenso_JobTracker');
$servername = "localhost";
$username = "clavenso_Admin";
//$username = "root";
//$password = "";
$password = "claven01*";
$dbname = "clavenso_JobTracker";
//$dbname = "members";

//application address
define('DIR','http://clavensolutions.com/Apps/JobTracker');
define('SITEEMAIL','admin@clavensolutions.com');

try {

	//create PDO connection 
	//$db = new PDO("mysql:host=".DBHOST.";port=8889;dbname=".DBNAME, DBUSER, DBPASS);
	$db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    
    
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   // echo "Connected Successfully";
    
} catch(PDOException $e) {
	//show error
    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    exit;
}

//include the user class, pass in the database connection
//include('../classes/adminuser.php');
//$adminuser = new AdminUser($db);


include('../classes/user.php');
include('classes/user.php');
$user = new User($db); 


?>


