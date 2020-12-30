<?php

header('Content-type: application/json');
if($_POST) {
$email   = $_POST['email'];

//if($_GET) {
//$email   = $_GET['email'];

/*
$servername = "localhost";
$A_username = "clavenso_Admin";
$A_password = "claven01*";
$dbname = "clavenso_GeoHunters";
//$dbname = "members";

//application address
define('DIR','http://clavensolutions.com/Apps/BattleField/');
define('DIRNEW','http://clavensolutions.com/picsandquotes/');
define('SITEEMAIL','admin@clavensolutions.com');
*/

require('/var/www/html/Apps/AppsConfig.php'); 
$dbname = "Stevens_GeoHunters";

define('DIR','http://'.$servername.'/Apps/BattleField/');
define('SITEEMAIL','admin@'.$emailServer.'.com');


try {

	//create PDO connection 
	//$db = new PDO("mysql:host=".DBHOST.";port=8889;dbname=".DBNAME, DBUSER, DBPASS);
	$db = new PDO("mysql:host=$servername;dbname=$dbname", $db_username, $db_password);


	//email validation
	if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){

//if(!filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)){


	    $error[] = 'Please enter a valid email address';
	} else {
		$stmt = $db->prepare('SELECT email FROM users WHERE email = :email');
		
                $stmt->execute(array(':email' => $_POST['email']));

               // $stmt->execute(array(':email' => $_GET['email']));

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(empty($row['email'])){
			$error[] = 'Email provided is not on recognized.';
		}
			
	}

	//if no errors have been created carry on
	if(!isset($error)){

		//create the activasion code
		$token = md5(uniqid(rand(),true));



    
    			$stmt = $db->prepare("UPDATE users SET resetToken = :token, resetComplete='No' WHERE email = :email");
			$stmt->execute(array(
				':email' => $row['email'],
				':token' => $token
			));

			//send email
			$to = $row['email'];
			$subject = "BattleField - Password Reset";




//$message = '<html><body>';
 
//$message .= '<table width="100%"; rules="all" style="border:1px solid #3A5896;" cellpadding="10">';
 
//$message .= "<tr><td><img src='http://www.clavensolutions.com/picsandquotes/layout/css/images/PQLogoShadow.png' alt='Pics & Quotes' /></td></tr>";
 
//$message = "<tr><td colspan=2>Someone requested that your Pics & Quotes password be reset. \n\nIf this was a mistake, just ignore this email and nothing will happen.\n\n <br><br> To reset your password, visit the following address: ".DIRNEW."resetPassword.php?key=$token</td></tr>";


$message = "Someone requested that your password be reset. \n\nIf this was a mistake, just ignore this email and nothing will happen.\n\nTo reset your password, visit the following address: ".DIRNEW."resetPassword.php?key=$token";

 
//$message .= "<br><br><I>Pics & Quotes</I>"; 

//$message .= "<tr><td colspan=2 font='colr:#999999;'><I>www.clavensolutions.com<br>Pics & Quotes</I></td></tr>";
 
//$message .= "</table>";
 
//$message .= "</body></html>";

			
			
			
			
			
			$additionalheaders = "From: <".SITEEMAIL.">\r\n";
			$additionalheaders .= "Reply-To: $".SITEEMAIL."";

 //$additionalheaders .= "MIME-Version: 1.0\r\n";
 //$additionalheaders .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

			mail($to, $subject, $message, $additionalheaders);

			//redirect to index page
			//header('Location: ../Reviews/login.php?action=reset');
			//exit;

		//else catch the exception and show the error.

        $success = $stmt->rowCount();
        //Exit;
        }
        }
catch(Exception $e)
{
         {
            echo '{"success":0,"error_message":'.$e->getMessage().'}';
         }
        
        
}

if ($success > 0) {
				//	error_log("User '$username' created.");
					echo '{"success":1}';
				} else {
					echo '{"success":0,"error_message":"Invalid Data."}';
				}
	

}


?>
