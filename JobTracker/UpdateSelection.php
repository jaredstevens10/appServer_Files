<?php require('../JobTracker/includes/config.php'); 

session_start();


$JobNumber = $_GET['id'];

if($_POST){

$AssignRep = $_POST['AssignRep'];
$_SESSION['AssignRep'] = $AssignRep;

echo $AssignRep;

}

//echo $sql_table; 
//echo $sql_username;


//if form has been submitted process it

//define page title
$title = 'Confirm Selection';

//include header template
require('../JobTracker/layout/header.php'); 
?>


<div class="container">

	<div class="row">

	    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
			<form role="form" method="post" action="" autocomplete="off">
<h1 align="center"><b>Job Tracker</b></h1>
<h1 align="center"><b>Confirm Assignment</b></h1>
				<a align="center" style="text-align: center"><font size="4">Press "Submit" to confirm the Assignment of this job</font></a>
<br>

<?php

if(isset($_GET['action']) && $_GET['action'] == 'complete'){
					echo "<a class='bg-success'><font size='4'>Job Assigned.  You can now close this page.</font></a>";
}


				//check for any errors
				if(isset($error)){
					foreach($error as $error){
						echo '<p class="bg-danger">'.$error.'</p>';
					}
				}

				//if action is joined show sucess
?>

<form action="" method="post">
<div class="row">

<?php

if(isset($error)) {
foreach($error as $error) {
echo '<p class="bg-danger">'.$error.'</p>';

   }
}

$Name = $AssignRep;
//Echo $Name;

?>



<div class="form-group">

<br>



<br>

<?php
echo "<input type='hidden' value=".$Name.">";
?>


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

$Name2 = $Name;
echo $Name2;
$RepName = $_SESSION['AssignedRep'];
//$RepName = $AssignRep;
echo $RepName;

//echo "Submit button pushed";
//exit;

//if(strlen($_POST['confirmation']) < 1) {
//$error[] = 'Please enter a valid confirmation number.';

//}

//else

//{


$Complete = "Yes";
$time = date('h:i:s', time());


$DateAssigned = date("Y-m-d");
//echo $DateAssigned2;
//$DateAssigned = DateTime::createFromFormat('m/d/Y', $DateAssigned2)->format('Y-m-d');
//$DateAssigned = "'".$DateAssigned2."'";

echo $DateAssigned;

$ProductCodeComplete = "UPDATE JobData SET DateAssigned = :Date, username = :username WHERE jobnumber = '" . $JobNumber . "'";

//$ProductCodeInsert = "UPDATE TESTONE SET email=?, userEmail=?, facebookUN=?, IsAvailable=? WHERE identifier=?"


$sql_insert = $db->prepare($ProductCodeComplete);

$sql_insert->bindParam(":Date", $DateAssigned);
$sql_insert->bindParam(":username", $AssignRep);


$sql_insert->execute();
//echo "complete";	


//header("Location: ../JobTracker/UpdateSelection.php?action=complete&username=" . $AssignRep . "&id=" . $JobNumber);
exit;





	//}


if(isset($_POST['cancel'])){
header('Location: ../JobTracker/addnewjob.php');
}	


}

//include header template
require('../JobTracker/layout/footer.php'); 
?>

