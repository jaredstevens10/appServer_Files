<?php require('../includes/config.php'); 

session_start();


$sql_table = $_GET['id'];

$sql_username = $_GET['user'];


//echo $sql_table; 
//echo $sql_username;


//if form has been submitted process it

//define page title
$title = 'Confirm Selection';

//include header template
require('../layout/header.php'); 


$CountQuery = "SELECT * FROM $sql_table WHERE IsAvailable = 'Yes'";
$GetCount = $db->query($CountQuery);
$row_count_result = $GetCount->rowCount();

if ($row_count_result == 0 ) {



//header("Location: ../Reviews/ItemSelection.php?action=No&username=" . $sql_username . "&id=" . $sql_table);
echo "<div class='container'><div class='row'><a class='bg-danger' align='center'><font size='4'>This Product is no longer available for Review.  Please select another product.<font></a></div></div>";
exit;


}
//else 
//{

?>

<div class="container">

	<div class="row">

	    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
			<form role="form" method="post" action="" autocomplete="off">
<h1 align="center"><b>48 Hour Reviews</b></h1>
				<a align="center"><font size="5">Please press "Submit" to confirm the item you selected</font></a>
<br>



<?php

				//if action is joined show sucess
				if(isset($_GET['action']) && $_GET['action'] == 'selected'){
					echo "<a class='bg-success'><font size='4'>You have selected to review this product, please check your email for your Product Review Code.</font></a>";
}

if(isset($_GET['action']) && $_GET['action'] == 'unavailable'){
					echo "<a class='bg-danger'><font size='4'>You have already selected this product. Please return to your home page.</font></a>";

}


if(isset($_GET['action']) && $_GET['action'] == 'No'){
					echo "<a class='bg-danger'><font size='4'>The product is no longer available for review.  Please return to your member page and select another product.</font></a>";

}


				//check for any errors
				if(isset($error)){
					foreach($error as $error){
						echo '<p class="bg-danger">'.$error.'</p>';
					}
				}

			
?>

<form>
<div class="row">

<div class="form-group">

<input type="submit" name="submit1" value="Submit" class="btn btn-primary btn-block btn-lg" tabindex="1">


<input type="button" name="cancel" value="Close" class="btn btn-primary btn-block btn-lg" tabindex="2" onClick="self.close()">
</div>

</div>
</form>
</div>

</div>
</div>
				



<?php 

if(isset($_POST['submit1'])){


$CheckUser = "SELECT identifier FROM " . $sql_table . " WHERE username = '" . $sql_username . "'";
$CheckUser_stmt = $db->query($CheckUser);
$CheckUser_stmt->execute();
$CheckUser_result = $CheckUser_stmt->rowCount();

if ($CheckUser_result > 0) {

header("Location: ../Reviews/ItemSelection.php?action=unavailable&username=" . $sql_username . "&id=" . $sql_table);
exit;
}
else
{
	//very basic validation
$GetIdentifier = "SELECT identifier FROM " . $sql_table . " WHERE IsAvailable = 'Yes' LIMIT 1";

$stmt = $db->prepare($GetIdentifier);
$stmt->execute();
$identifier_result = $stmt->fetchColumn();

//echo $identifier_result;
//echo "<br>";

//ASSIGNS PRODUCT CODE
$ProductCode = $identifier_result;




$GetUserInfo = "SELECT * FROM Members WHERE username = '" . $sql_username . "'";

$userSQL = $db->prepare($GetUserInfo);
$userSQL->execute();
$user_result = $userSQL->fetch(PDO::FETCH_ASSOC);
//print_r($user_result);
$userEmail = $user_result['email'];
$userFaceBook = $user_result['facebookUN'];
$userPhone = $user_result['contactnumber'];
//echo $userEmail;
//echo $userFaceBook;
//echo $userPhone;

//ASSIGNS PRODUCT CODE
//$ProductCode = $identifier_result;



$Available = "No";


             

//$ProductCodeInsert = "INSERT INTO " . $sql_table . " (email, facebookUN, contactnumber) VALUES ('" . $userEmail . "', '" . $userFacebook . "', '" . $userPhone . "') WHERE identifier = '" . $ProductCode . "'";

$ProductCodeInsert = "UPDATE " . $sql_table . " SET username = :userName, email = :userEmail, facebookUN = :userFaceBook, contactnumber = :userPhone, IsAvailable = :Available WHERE identifier = '" . $ProductCode . "'";

//$ProductCodeInsert = "UPDATE TESTONE SET email=?, userEmail=?, facebookUN=?, IsAvailable=? WHERE identifier=?"


$sql_insert = $db->prepare($ProductCodeInsert);
//$sql_insert->bindParam($userEmail,$userFacebook,$userPhone,$IsAvailable));
$sql_insert->bindParam(":userName", $sql_username);
$sql_insert->bindParam(":userEmail", $userEmail);
$sql_insert->bindParam(":userFaceBook", $userFaceBook);
$sql_insert->bindParam(":userPhone", $userPhone);
$sql_insert->bindParam(":Available", $Available);
//$sql_insert->execute(array($userEmail,$userFaceBook,$userPhone,$IsAvailable,$ProductCode));
$sql_insert->execute();



//send email
			$to = $userEmail;
			$subject = "Review Item Selection - " . $sql_table;
			$body = "Thank you selecting this item to be reviewed.\n\n You unique Review Code is:\n\n".$ProductCode."\n\n";
			$additionalheaders = "From: <".SITEEMAIL.">\r\n";
			$additionalheaders .= "Reply-To: ".SITEEMAIL."";
			mail($to, $subject, $body, $additionalheaders);

			//redirect to index page
			header("Location: ../Reviews/ItemSelection.php?action=selected&username=" . $sql_username . "&id=" . $sql_table);
			exit;

		//else catch the exception and show the error.
		//} catch(PDOException $e) {
		//    $error[] = $e->getMessage();
	//	}




//echo "complete";	

   }

}


if(isset($_POST['cancel'])){
header('Location: ../Reviews/memberpage.php');
}	




//include header template
require('../layout/footer.php'); 
?>

