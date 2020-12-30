<?php


header('Content-type: application/json');
if($_POST) {
//if($_GET) {
$username   = $_POST['username'];
$email   = $_POST['email'];
$category   = $_POST['category'];



//$username   = $_GET['username'];
//$category   = $_GET['category'];
	
	//$c_password = $_POST['c_password'];

	if($_POST['username']) {
//if($_GET['email']) {
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


//$LocationInfo = "SELECT * FROM users WHERE (email = '".$email."' AND category = '".$category."')";
$LocationInfo = "SELECT * FROM GameItems WHERE (username = '".$username."' AND category = '".$category."')";

//$LocationInfo = "SELECT * FROM users WHERE email = '".$email."'";

// ORDER BY DateApt ASC, TimeApt ASC";

$stmt = $db->prepare($LocationInfo);
$stmt->execute();

//$c = $stmt->fetch(PDO::FETCH_ASSOC);
//$c = $stmt->fetch(mysqli_stmt::fetch);
//$stmt = $mysqli->query($LocationInfo);
//$stmt->execute();
//$C = $stmt->fetch(PDO::FETCH_ASSOC);
//$C = $stmt->fetchall();


echo"{\"success\":1,\"Items\":[";

while($rows = $stmt->fetch(PDO::FETCH_ASSOC)){

//print_r($row);
//$latitude = $stmt->fetchColumn();

//print_r($rows);



echo "{\"id\":\"$rows[id]\",\"name\":\"$rows[name]\",\"type\":\"$rows[type]\",\"category\":\"$rows[category]\",\"power\":\"$rows[power]\",\"range\":\"$rows[range]\",\"speed\":\"$rows[speed]\",\"viewrange\":\"$rows[viewrange]\"},";


//  ,\"Turn5\":\"$rows[Turn5]\"
//  ,\"phone\":\"NA\"

//echo "{\"customername\": \"$rows[customername]\"";
//, \"DateApt\":\"$rows[DateApt]\",\"TimeApt\":\"$rows[DateTime]\",";


}

echo "{\"id\":\"0\",\"name\":\"NA\",\"type\":\"NA\",\"category\":\"NA\"}]}";


$C = $stmt->fetch(PDO::FETCH_ASSOC);




				if ($stmt->error) {error_log("Error: " . $stmt->error); }

				$success = $stmt->affected_rows;

				/* close statement and connection */
				//$stmt->close();

				/* close connection */
				//$db->close();
				error_log("Success: $success");

				if ($username == "") {
						//echo '{"success":0,"error_message":"Username Exist."}';
				} else {
error_log("User '$username' created.");

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
