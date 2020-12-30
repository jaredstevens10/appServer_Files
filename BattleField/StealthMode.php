<?php


header('Content-type: application/json');
if($_POST) {
	$username   = $_POST['username'];
	//$password   = $_GET['password'];
$stealth = $_POST['stealth'];
//$longitude = $_POST['longitude'];
	//$c_password = $_POST['c_password'];

	if($_POST['username']) {
		if ( $username == $username ) {

//echo "connecting";
			require('/var/www/html/Apps/AppsConfig.php'); 
$dbname = "Stevens_GeoHunters";

define('DIR','http://'.$servername.'/Apps/BattleField/');
//define('SITEEMAIL','admin@'.$emailServer.'.com');

			/* $mysqli = new mysqli('localhost', $clavenso_Admin, $claven01*, $clavenso_TestDB); */
                    
                     $mysqli = new mysqli($server_url, $db_user, $db_password, $db_username);
                   // $mysqli = new PDO($server_url, $db_user, $db_password, $db_name);


			/* check connection */
			if (mysqli_connect_errno()) {
				error_log("Connect failed: " . mysqli_connect_error());

				echo '{"success":0,"error_message":"' . mysqli_connect_error() . '"}';
			} else {
				//$stmt = $mysqli->prepare("INSERT INTO LocationData (username, password) VALUES (?, ?)");
				//$password = md5($password);
				//$stmt->bind_param('ss', $username, $password);

				/* execute prepared statement */
				//$stmt->execute();



$LocationInfo = "UPDATE users SET username = '" . $username . "', stealth = '" . $stealth . "' WHERE username = '" . $username . "'";

//$LocationInfo = "UPDATE LocationData SET username = :username, latitude = :latitude, longitude = :longitude WHERE username = 'john'";



//echo $LocationInfo;

$stmt = $mysqli->prepare($LocationInfo);
$password = md5($password);

//echo $stmt;
//$stmt->bindParam();
//$stmt->bind_Param(":userName", $username);


//$stmt->bind_Param('sss',$username,$latitude,$longitude);
$stmt->bind_Param($username,$latitude,$longitude);

//$stmt->bind_Param(":password", $password);

$stmt->execute();



				if ($stmt->error) {error_log("Error: " . $stmt->error); }

				$success = $stmt->affected_rows;

				/* close statement and connection */
				$stmt->close();

				/* close connection */
				$mysqli->close();


				error_log("Success: $success");

				if ($success > 0) {
					error_log("User '$username' created.");
					echo '{"success":1}';
				} else {
					echo '{"success":0,"error_message":"No Location Change."}';
				}
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
