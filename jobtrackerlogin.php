<?php

header('Content-type: application/json');
if($_POST) {
	$username   = $_POST['username'];
	$password   = $_POST['password'];

	if($username && $password) {

                     $db_name     = 'clavenso_JobTracker';
			$db_user     = 'clavenso_Admin';
			$db_password = 'claven01*';
			/* $server_url  = '181.224.137.57'; */
                     $server_url = 'localhost';


			$mysqli = new mysqli('localhost', $db_user, $db_password, $db_name);

			/* check connection */

			if (mysqli_connect_errno()) {
				error_log("Connect failed: " . mysqli_connect_error());
				echo '{"success":0,"error_message":"' . mysqli_connect_error() . '"}';
			} else {
				if ($stmt = $mysqli->prepare("SELECT username, admin, email FROM EmployeeData WHERE username = ? and password = ?")) {

					$password = md5($password);

					/* bind parameters for markers */
					$stmt->bind_param("ss", $username, $password);

					/* execute query */
					$stmt->execute();

					/* bind result variables */
					$stmt->bind_result($id,$admin,$email);

					/* fetch value */
					$stmt->fetch();

					/* close statement */
					$stmt->close();
				}

				/* close connection */
				$mysqli->close();

				if ($id) {
					error_log("User $username: password match.");
					echo "{\"success\":1,\"admin\":\"".$admin."\",\"email\":\"".$email."\"}";
				} else {
					error_log("User $username: password doesn't match.");
					echo '{"success":0,"error_message":"Invalid Username/Password"}';
				}
			}
	} else {
		echo '{"success":0,"error_message":"Invalid Username/Password."}';
	}
}else {
	echo '{"success":0,"error_message":"Invalid Data."}';
}
?>
