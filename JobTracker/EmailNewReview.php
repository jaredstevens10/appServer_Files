<?php require('../includes/config.php'); 



$query = $db->prepare("SELECT DISTINCT TABLE_NAME, COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME LIKE 'IsAvailable%' AND TABLE_SCHEMA='clavenso_ReviewMembers'");
//$query = $db->prepare("Show Tables");
$query->execute();


$tabledata = array();
$Status = NULL;


//BEGIN WHILE STATEMENT LOOP FOR EACH TABLE
while($rows = $query->fetch(PDO::FETCH_COLUMN, PDO::FETCH_ORI_NEXT)){

$tabledata[] = $rows;
$CountQuery = "SELECT * FROM $rows WHERE 

IsAvailable = 'Yes'";



//echo "start emailing";

$recipients = ("SELECT email, username FROM " . $rows . " WHERE IsAvailable = 'No' AND Complete = 'No'"); 

$email_list = $db->query($recipients); 
foreach($email_list as $row) { 
$to = $row['email'];
$user = $row['username']; 
$subject = "Reminder: You need to complete your review - " . $rows;
$additionalheaders = "From: <".SITEEMAIL.">\r\n";
$additionalheaders .= "Reply-To: ".SITEEMAIL."";
//$headers = "From: Claven Solutions <admin@clavensolutions.com>\r\n";
$body = "This is a reminder to complete your 48 hour review\n\n Click here to complete your review link:\n\n ".DIR."UpdateSelection.php?id=$rows&user=$user\n\n Thanks \n\n";
//$message = "You need to finish the review....";
  if ( mail($to,$subject,$body,$addionalheaders) ) {
   echo "Email was sent successfully";
   } else {
   echo "Email delivery has failed!";
   }
} 
}
echo "complete emailing";

?> 