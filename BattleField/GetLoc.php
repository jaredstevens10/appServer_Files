<?php


header('Content-type: application/json');
if($_POST) {
	$username   = $_POST['username'];
	//$password   = $_GET['password'];
//$latitude = $_POST['latitude'];
//$longitude = $_POST['longitude'];
	//$c_password = $_POST['c_password'];

	if($_POST['username']) {
		if ( $username == $username ) {

//echo $username;
		require('/var/www/html/Apps/AppsConfig.php'); 
$dbname = "Stevens_GeoHunters";

define('DIR','http://'.$servername.'/Apps/BattleField/');
define('SITEEMAIL','admin@'.$emailServer.'.com');


try {

	//create PDO connection 
	//$db = new PDO("mysql:host=".DBHOST.";port=8889;dbname=".DBNAME, DBUSER, DBPASS);
	$db = new PDO("mysql:host=$servername;dbname=$dbname", $db_username, $db_password);
    
    
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   // echo "Connected Successfully";
    
} catch(PDOException $e) {
	//show error
    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    exit;
}


                    
                   //  $mysqli = new mysqli($server_url, $db_user, $db_password, $db_name);
                  //  $mysqli = new PDO($server_url, $db_user, $db_password, $db_name);


			/* check connection */
//			if (mysqli_connect_errno()) {
//				error_log("Connect failed: " . mysqli_connect_error());
//				echo '{"success":0,"error_message":"' . mysqli_connect_error() . '"}';
//			} else {
				//$stmt = $mysqli->prepare("SELECT latitude, longitude FROM LocationData (username, password) VALUES (?, ?)");
				//$password = md5($password);
				//$stmt->bind_param('ss', $username, $password);

				/* execute prepared statement */
				//$stmt->execute();



$LocationInfo = "SELECT * FROM users WHERE username = '" . $username . "'";
//$LocationInfo = "SELECT * FROM LocationData WHERE username = "jared";

//$LocationInfo = "UPDATE LocationData SET username = :username, latitude = :latitude, longitude = :longitude WHERE username = 'john'";

//echo $LocationInfo;

$stmt = $db->prepare($LocationInfo);
$stmt->execute();
//$c = $stmt->fetch(PDO::FETCH_ASSOC);
//$c = $stmt->fetch(mysqli_stmt::fetch);


//$stmt = $mysqli->query($LocationInfo);
//$stmt->execute();
$C = $stmt->fetch(PDO::FETCH_ASSOC);
//$latitude = $stmt->fetchColumn();

//print_r($C);

$userlatitude = $C['latitude'];
$userlongitude = $C['longitude'];
$useraltitude = $C['altitude'];

//$stmt->bind_Param('sss',$username,$latitude,$longitude);



				if ($stmt->error) {error_log("Error: " . $stmt->error); }

				$success = $stmt->affected_rows;

				/* close statement and connection */
				//$stmt->close();

				/* close connection */
				//$db->close();
				error_log("Success: $success");

				if ($userlatitude == "") {
						echo '{"success":0,"error_message":"Username Exist."}';
				} else {
                                  error_log("User '$username' created.");
					echo "{\"success\":1,\"Latitude\":$userlatitude,\"Longitude\":$userlongitude}";
				}
			
		} else {
			echo '{"success":0,"error_message":"Passwords does not match."}';
		}
	} else {
		echo '{"success":0,"error_message":"Invalid Username."}';
	}
}else {
	echo '{"success":0,"error_message":"Invalid Data."}';
}
?>
