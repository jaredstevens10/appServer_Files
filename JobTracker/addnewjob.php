<?php require('../JobTracker/includes/config.php'); 
// define variables and set to empty values

//session_start();


//set timezone
date_default_timezone_set('Europe/London');

$nameErr = $emailErr = $genderErr = $websiteErr = "";
$name = $id = $customnername = $DateApt = $TimeApt = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

   if (empty($_POST["id"])) {
     $nameErr = "Job ID is required";
   } else {
     $name = test_input($_POST["name"]);
     // check if name only contains letters and whitespace
   /*  if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
       $nameErr = "Only letters and white space allowed"; 
     }
  */
   }
   
 
}

function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
?>
	    




<!--

<h2>Job Assign Portal</h2>
				<p><a href='../Reviews/index.php'>Back to home page</a></p>
				<hr>
-->



<!--
<form name="post" method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
   Table Name: <input type="text" name="name" value="<?php echo $name;?>">
   <span class="error"><?php echo $nameErr;?></span>
   <br>
   <span class="error"><?php echo $genderErr;?></span>
   <input type="file" name="file" /><br /> <br>
    <input type="submit" name="submit" value="Submit" />
    </form>
-->

<?php
	include ("../JobTracker/connection.php");

	
	if(isset($_POST["submit"]))
	{
//echo "submit button it";

try {
  //  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
   // $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // sql to create table
  //  UNSIGNED AUTO_INCREMENT PRIMARY KEY, lastname VARCHAR(255) NOT NULL, email VARCHAR(255), Taken VARCHAR (255), Complete VARCHAR (255), reg_date TIMESTAMP

		
//ORIGINAL SQL STATEMENT
			//$sql_import = $conn->prepare("INSERT INTO $name (id, identifier, firstname, lastname, email, IsAvailable, Complete, reg_date) VALUES ('$id', '$identifier', '$firstname', '$lastname', '$email', '$IsAvailable', '$Complete', '$reg_date')");


//$stmt2 = $conn->("SELECT LAST_INSERT_ID(id) FROM JobData");
//$LastID = $stmt2->fetch(PDO::FETCH_NUM);
//$LastID = $LastID[0];



$DateApt2 = $_POST['DateApt'];

//$DateApt = date("yyyy-mm-dd", strtotime($DateApt2));

$DateApt = DateTime::createFromFormat('m/d/Y', $DateApt2)->format('Y-m-d');

//$DateApt = $_POST['DateApt'];
//echo $LastID;

//$LAST_INSERT_ID();


$id = $_POST['name'];
$TimeApt = $_POST['TimeApt'];
$customername = $_POST['customername'];

$street = $_POST['addressname'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip = $_POST['zip'];
$email = $_POST['email'];
$phone = $_POST['phone1'].$_POST['phone'];



$address = $street."., ".$city.", ".$state." ".$zip;

//echo $address;
//echo "<br>";
//$address = '201 S. Division St., Ann Arbor, MI 48104'; // Google HQ
$prepAddr = str_replace(' ','+',$address);

$geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');

$output= json_decode($geocode);

$lat = $output->results[0]->geometry->location->lat;
$long = $output->results[0]->geometry->location->lng;

//echo $address.'<br>Lat: '.$lat.'<br>Long: '.$long;





//$Null = "NULL";

$sql_import = $conn->prepare("INSERT INTO JobData (id, jobnumber, DateApt, TimeApt, customername, latitude, longitude, street, city, state, zip, email, phone) VALUES (null, '".$id."', '$DateApt', '$TimeApt', '$customername', '$lat', '$long', '$street', '$city', '$state', '$zip', '$email', '$phone')");

//$conn->prepare($sql_import);
//$id = MySQL_insert_id();

//ORIGINAL SQL STATEMENT
//$sql_import->bindParam($id,$identifier,$firstname,$lastname,$email,$IsAvailable,$Complete,$reg_date);


//$sql_import->bindParam($id,$DateApt,$TimeApt,$customername);
//$id = $conn->lastInsertID();
//echo $id;

//$sql->bindParam('$email', 'email@email.com');
$sql_import->execute();
//echo "executed imported";


/*
			$c = $c + 1;
		}
*/		
			if($sql_import){
//echo $sql_import;


?>
  <script type="text/javascript">
    alert("The new job: number <?php echo $id;?> was created successfully.");
    //history.back();
  </script>
<?php


/*
$sql_delete_blank = $conn->prepare("DELETE FROM $name WHERE identifier = ''");
$sql_delete_blank->execute();

$sql_delete_blank2 = $conn->prepare("DELETE FROM $name WHERE identifier = 'identifier'");
$sql_delete_blank2->execute();
*/
//echo "test";

//header('Location: ../JobTracker/addnewjob.php');
//exit;


}
else			
{

?>
  <script type="text/javascript">
    alert("Sorry! There is some problem.");
    //history.back();
  </script>
echo "Sorry! There is some problem.";
 //echo $sql;
<?php
		} 
    
  //  echo 'The new Review Table ' . $Name . ' was created successfully';
    


}
catch(PDOException $e)
    {
    echo $sql . '<br>' . $e->getMessage();
    }


} 

//header('Location: ../JobTracker/addnewjob.php');
//exit;


//define page title
$title = 'Add New job';

//include header template
require('../JobTracker/layout/header.php'); 
?>


<head>

  <meta charset="utf-8">

  <title>jQuery UI Datepicker - Default functionality</title>



  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

  <script src="//code.jquery.com/jquery-1.10.2.js"></script>

  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

  <link rel="stylesheet" href="/resources/demos/style.css">

  <script>

  $(function() {
    $( "#datepicker" ).datepicker();
  });

  </script>



<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

  <script type="text/javascript" src="jquery.timepicker.js"></script>
  <link rel="stylesheet" type="text/css" href="jquery.timepicker.css" />

  <script type="text/javascript" src="lib/bootstrap-datepicker.js"></script>
  <link rel="stylesheet" type="text/css" href="lib/bootstrap-datepicker.css" />

  <script type="text/javascript" src="lib/site.js"></script>
  <link rel="stylesheet" type="text/css" href="lib/site.css" />


</head>


	
<div class="container">

	<div class="row">

	    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">

<form role="form" name="post" method="post" enctype="multipart/form-data" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">


		<!--	<form role="form" method="post" action="" autocomplete="off">  -->
				<h2>Add New Job</h2>
				<p><a href='../JobTracker/Reviews/index.php'>Back to home page</a></p>
				<hr>

				<?php
				//check for any errors
				if(isset($error)){
					foreach($error as $error){
						echo '<p class="bg-danger">'.$error.'</p>';
					}
				}

				if(isset($_GET['action'])){

					//check the action
					switch ($_GET['action']) {
						case 'export':
					//		echo "<h2 class='bg-success'>Your account is now active you may now log in.</h2>";
							break;
						case 'reset':
					//		echo "<h2 class='bg-success'>Please check your inbox for a reset link.</h2>";
							break;
						case 'resetAccount':
					//		echo "<h2 class='bg-success'>Password changed, you may now login.</h2>";
							break;
					}

				}

				
				?>

				<div class="form-group">
					<input type="text" name="name" id="name" class="form-control input-lg" placeholder="Enter Job Number" value="<?php if(isset($error)){ echo $_POST['id']; } ?>" tabindex="1">
				</div>

                <div class="form-group">
				<input type="text" name="customername" id="customername" class="form-control input-lg" placeholder="Customer Name" value="<?php if(isset($error)){ echo $_POST['customerusername']; } ?>" tabindex="2">
				</div>
<div class="row">
					<div class="col-xs-4 col-sm-4 col-md-4">

<div class="form-group">
				<input type="text" name="phone1" id="phone1" class="form-control input-lg" placeholder="Area Code" value="<?php if(isset($error)){ echo $_POST['phone']; } ?>" tabindex="3">
				</div>
</div>
<div class="col-xs-6 col-sm-6 col-md-6">

<div class="form-group">
				<input type="text" name="phone" id="phone" class="form-control input-lg" placeholder="Phone Number" value="<?php if(isset($error)){ echo $_POST['phone']; } ?>" tabindex="4">
				</div>
</div>
</div>




<div class="form-group">
				<input type="text" name="email" id="email" class="form-control input-lg" placeholder="Email Address" value="<?php if(isset($error)){ echo $_POST['email']; } ?>" tabindex="5">
				</div>



                <div class="form-group">
				<input type="text" name="addressname" id="addressname" class="form-control input-lg" placeholder="Street Address" value="<?php if(isset($error)){ echo $_POST['addressname']; } ?>" tabindex="6">
				</div>

                <div class="form-group">
				<input type="text" name="city" id="city" class="form-control input-lg" placeholder="City" value="<?php if(isset($error)){ echo $_POST['city']; } ?>" tabindex="7">
				</div>  

               <div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6">
						<div class="form-group">
							<input type="text" name="state" id="state" class="form-control input-lg" placeholder="State" tabindex="8">
						</div>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6">
						<div class="form-group">
							<input type="text" name="zip" id="Zip" class="form-control input-lg" placeholder="Zip" tabindex="9">
						</div>
					</div>
				</div>
<div class="row">
<div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
					<input type="text" name="DateApt" id="datepicker" class="form-control input-lg" placeholder="Appointment Date" value="<?php if(isset($error)){ echo $_POST['DateApt']; } ?>" tabindex="10" /> 
		</div>
       </div>

<div class="col-xs-6 col-sm-6 col-md-6">

            <div class="form-group">
              
                <input name="TimeApt" id="basicExample" type="text" class="form-control input-lg" data-scroll-default="6:00am" placeholder="Appointment Time" value="<?php if(isset($error)){ echo $_POST['TimeApt']; } ?>" tabindex="11"/> <br /> <br />
            </div>
      </div>
</div>


            <script>
                $(function() {
                    $('#basicExample').timepicker();
                });
            </script>

  
    <!--      	<div class="form-group">
					<input type="file" name="file" id="file" class="form-control input-lg" placeholder="Select .csv file to import" tabindex="12" /> <br /> <br />
				</div>
     -->
				
					
				<hr>
				<div class="row">
					<div class="col-xs-6 col-md-6"><input type="submit" name="submit" value="Submit" class="btn btn-primary btn-block btn-lg" tabindex="13"></div>
				</div>
			</form>

		</div>


<br>
<br>

<hr>

	</div>

</div>




<?php


// ***** THIS SHOWS THE CURRENT PRODUCTS AND THEIR STATUS

//$query = $db->prepare("SELECT DISTINCT TABLE_NAME, COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME LIKE 'IsAvailable%' AND TABLE_SCHEMA='clavenso_ReviewMembers'");


//$query->execute();


echo("<br>
<div align='center'>
<table border='1'>
<col width='200'>
<col width='180'>
<col width='180'>
<col width='180'>
<col width='150'>
<col width='150'>
<tr>
<th style='text-align: center'>Item Name</th>
<th style='text-align: center'>Total # Jobs</th>
<th style='text-align: center'># Unassigned Jobs</th>
<th style='text-align: center'># Jobs in Process</th>
<th style='text-align: center'># Completed Jobs</th>
<th style='text-align: center'>Export Excel</th>
<th style='text-align: center'>Export Text</th>
</tr>

<br>
<br>
</div>");


//$tabledata = array();
$Status = NULL;
$file_ending = "xls";
$rows = "JobData";

//BEGIN WHILE STATEMENT LOOP FOR EACH TABLE
//while($rows = $query->fetch(PDO::FETCH_COLUMN, PDO::FETCH_ORI_NEXT)){

//$tabledata[] = $rows;




//All Jobs
$TotalQuery = "SELECT * FROM $rows";

$GetTotalCount = $db->query($TotalQuery);
//$GetTotalCount->execute();
$Total_count = $GetTotalCount->rowCount();

//Available jobs
$CountQuery = "SELECT * FROM $rows WHERE username = ''";

$GetCount = $db->query($CountQuery);
//$GetCount->execute();
$row_count = $GetCount->rowCount();

//Started but not finished
$IncompleteQuery = "SELECT * FROM $rows WHERE checkedin = 'yes' AND checkedout = 'no'";

$IncompleteCount = $db->query($IncompleteQuery);
//$IncompleteCount->execute();
$Incomplete_count = $IncompleteCount->rowCount();



// CHECKS IF USER ALREADY HAS SIGNED UP TO REVIEW THIS PRODUCT
//$CheckUserQuery = "SELECT * FROM $rows WHERE username = '" . $ActiveUser . "'";
//$CheckUser = $conn->query($CheckUserQuery);
//$CheckUser->execute();
//$CheckUser_Count = $CheckUser->rowCount();
//$CheckUser_Count = ($CheckUser->fetchColumn() > 0) ? true : false;

// CHECKS IF USER ALREADY HAS COMPLETED THEIR REVIEW
//$CheckCompletedQuery = "SELECT * FROM $rows WHERE username = '" . $ActiveUser . "' AND Complete = 'Yes'";
//$CheckCompleted = $db->query($CheckCompletedQuery);
//$CheckCompleted->execute();
//$CheckCompleted_Count = $CheckCompleted->rowCount();


//$CheckCompleted_Count = ($CheckCompleted->fetchColumn() > 0) ? true : false;


//if ($CheckUser_Count == 1) {
//if ($CheckCompleted_Count == 1) {
//$Status = "Complete";
//$Status_Button = "Complete";
//} 
//else 
//{$Status = "In Process";
//$Status_Button = "<input type='submit' style='color: blue; border: none; background-color: transparent; cursor: pointer; border: none;' id='" . $rows . "'; name='" . $rows . "button'; value='" . //$Status . "'; onclick='return ConfirmChoice2();'>";

//$FormAction = "UpdateSelection.php?id=" . $rows . "&user=" . $ActiveUser;

//$sql_table = $rows;
//$sql_username = $ActiveUser;

//$_SESSION['id'] = $sql_id;
//$_SESSION['memberuser'] = $sql_username; 

//}
//}
//else
//{




$Status = "Export";
$Status_Button = "<input type='submit' style='color: blue; border: none; background-color: transparent; cursor: pointer; border: none;' id='" . $rows . "'; name='submit'; value='" . $Status . "'>";

$FormAction = "ExportSelection.php?id=" . $rows;
//$FormAction = "ExportExl.php?id=" . $rows;

$Status2 = "Text";
$Textbutton = "<input type='submit' style='color: blue; border: none; background-color: transparent; cursor: pointer; border: none;' id='" . $rows . "'; name='submit'; value='" . $Status2 . "'>";

$FormActionText = "ExportText.php?id=" . $rows;







$sql_table = $rows;

$sql_username = $ActiveUser;

$_SESSION['id'] = $sql_id;
$_SESSION['memberuser'] = $sql_username; 

//onclick='return ConfirmChoice();'

//}

$query_items = "username = " . $ActiveUser;

echo "<form action=" . $FormAction . " method='POST'>";
echo "<tr>";
echo "<td align='center'>" . $rows . "</td>"; 
echo "<td align='center'>" . $Total_count . "</td>";
echo "<td align='center'>" . $row_count . "</td>";
echo "<td align='center'>" . $Incomplete_count . "</td>";
echo "<td align='center'>" . $complete_count . "</td>";
echo "<td align='center'>" . $Status_Button . "</td>";
echo "</form>";
echo "<form action=" . $FormActionText . " method='POST'>";
echo "<td align='center'>" . $Textbutton . "</td>";
//echo "<td align='center'>" . $CheckUser_Count . " " . $CheckCompleted_Count . "</td>";

echo("</tr>");
echo "</form>";

//echo $_SESSION['username']; 

//}

// ***** THIS ENDS THE SECTION SHOWING THE CURRENT PRODUCTS AND THEIR STATUS'

?>



<?php


// ***** THIS SHOWS THE CURRENT PRODUCTS AND THEIR STATUS

//$query = $db->prepare("SELECT DISTINCT TABLE_NAME, COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME LIKE 'IsAvailable%' AND TABLE_SCHEMA='clavenso_ReviewMembers'");
//$query = $db->prepare("SELECT DISTINCT username FROM JobData WHERE NOT username = '' ORDER BY username");


$sql_query = "SELECT DISTINCT username FROM JobData WHERE NOT username = '' ORDER BY username";


$stm = $db->prepare($sql_query);


//$users = $db->query($sql_query);
//$users = $stm->fetch(PDO::FETCH_ASSOC);



//$query->execute();


echo("<br>
<div align='center'>
<table border='1'>
<col width='200'>
<col width='180'>
<col width='180'>
<col width='180'>
<col width='150'>
<col width='150'>
<tr>
<th style='text-align: center'>Employee Name</th>
<th style='text-align: center'>Total # Jobs</th>
<th style='text-align: center'># Assigned Jobs</th>
<th style='text-align: center'># Jobs in Process</th>
<th style='text-align: center'># Completed Jobs</th>
<th style='text-align: center'>On Time %</th>
<th style='text-align: center'>Avg Time Per Job</th>
<th style='text-align: center'>Revenue Per Hour</th>
<th style='text-align: center'>Optional Sales</th>
<th style='text-align: center'>Time UTL%</th>
<th style='text-align: center'>Customer Service Scores</th>
</tr>

<br>
<br>
</div>");


$tabledata = array();
$Status = NULL;
$file_ending = "xls";
$rows = "JobData";

$stm->execute();


//BEGIN WHILE STATEMENT LOOP FOR EACH TABLE
while($row = $stm->fetch(PDO::FETCH_ASSOC)){

$tabledata[] = $row;
//echo $row['username'] . "<br>";

//print_r($tabledata);


$user = $row['username'];

//All Jobs
$TotalQuery = "SELECT * FROM $rows WHERE username = '".$user."'";

$GetTotalCount = $db->query($TotalQuery);
//$GetTotalCount->execute();
$Total_count = $GetTotalCount->rowCount();




//Available jobs
$CountQuery = "SELECT * FROM $rows WHERE username = '".$user."'";

$GetCount = $db->query($CountQuery);
//$GetCount->execute();
$row_count = $GetCount->rowCount();

//Started but not finished
$IncompleteQuery = "SELECT * FROM $rows WHERE checkedin = 'yes' AND checkedout = 'no' AND username = '".$user."'";

$IncompleteCount = $db->query($IncompleteQuery);
//$IncompleteCount->execute();
$Incomplete_count = $IncompleteCount->rowCount();


//Started but not finished
$completeQuery = "SELECT * FROM $rows WHERE checkedin = 'yes' AND checkedout = 'yes' AND username = '".$user."'";


$completeCount = $db->query($completeQuery);
//$IncompleteCount->execute();
$complete_count = $completeCount->rowCount();




// CHECKS IF USER ALREADY HAS SIGNED UP TO REVIEW THIS PRODUCT
//$CheckUserQuery = "SELECT * FROM $rows WHERE username = '" . $ActiveUser . "'";
//$CheckUser = $conn->query($CheckUserQuery);
//$CheckUser->execute();
//$CheckUser_Count = $CheckUser->rowCount();
//$CheckUser_Count = ($CheckUser->fetchColumn() > 0) ? true : false;

// CHECKS IF USER ALREADY HAS COMPLETED THEIR REVIEW
//$CheckCompletedQuery = "SELECT * FROM $rows WHERE username = '" . $ActiveUser . "' AND Complete = 'Yes'";
//$CheckCompleted = $db->query($CheckCompletedQuery);
//$CheckCompleted->execute();
//$CheckCompleted_Count = $CheckCompleted->rowCount();


//$CheckCompleted_Count = ($CheckCompleted->fetchColumn() > 0) ? true : false;


//if ($CheckUser_Count == 1) {
//if ($CheckCompleted_Count == 1) {
//$Status = "Complete";
//$Status_Button = "Complete";
//} 
//else 
//{$Status = "In Process";
//$Status_Button = "<input type='submit' style='color: blue; border: none; background-color: transparent; cursor: pointer; border: none;' id='" . $rows . "'; name='" . $rows . "button'; value='" . //$Status . "'; onclick='return ConfirmChoice2();'>";

//$FormAction = "UpdateSelection.php?id=" . $rows . "&user=" . $ActiveUser;

//$sql_table = $rows;
//$sql_username = $ActiveUser;

//$_SESSION['id'] = $sql_id;
//$_SESSION['memberuser'] = $sql_username; 

//}

 

//else
//{




$Status = "TBD Stats";
$Status_Button = "<input type='submit' style='color: blue; border: none; background-color: transparent; cursor: pointer; border: none;' id='" . $row . "'; name='submit'; value='" . $Status . "'>";

$FormAction = "ExportSelection.php?id=" . $rows;
//$FormAction = "ExportExl.php?id=" . $rows;

$Status2 = "TBD Stats";
$Textbutton = "<input type='submit' style='color: blue; border: none; background-color: transparent; cursor: pointer; border: none;' id='" . $rows . "'; name='submit'; value='" . $Status2 . "'>";

$FormActionText = "ExportText.php?id=" . $rows;







$sql_table = $rows;

$sql_username = $ActiveUser;

$_SESSION['id'] = $sql_id;
$_SESSION['memberuser'] = $sql_username; 

//onclick='return ConfirmChoice();'

//}

$query_items = "username = " . $ActiveUser;

echo "<form target='_blank' action=" . $FormAction . " method='POST'>";
echo "<tr>";
echo "<td align='center'>" . $user . "</td>"; 
echo "<td align='center'>" . $Total_count . "</td>";
echo "<td align='center'>" . $row_count . "</td>";
echo "<td align='center'>" . $Incomplete_count . "</td>";
echo "<td align='center'>" . $complete_count . "</td>";
echo "<td align='center'>" . $Status_Button . "</td>";
echo "</form>";
//echo "<form target='_blank' action=" . $FormActionText . " method='POST'>";
echo "<form target='_blank' action=" . $FormActionText . " method='POST'>";

//echo "<td align='center'>"  "</td>";
echo "<td align='center'>" . $Textbutton . "</td>";
//echo "<td align='center'>" . $CheckUser_Count . " " . $CheckCompleted_Count . "</td>";

echo("</tr>");
echo "</form>";

//echo $_SESSION['username']; 

}

// ***** THIS ENDS THE SECTION SHOWING THE CURRENT PRODUCTS AND THEIR STATUS'

?>





<?php


// ***** THIS SHOWS THE CURRENT PRODUCTS AND THEIR STATUS

//$query = $db->prepare("SELECT DISTINCT TABLE_NAME, COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME LIKE 'IsAvailable%' AND TABLE_SCHEMA='clavenso_ReviewMembers'");
//$query = $db->prepare("SELECT DISTINCT username FROM JobData WHERE NOT username = '' ORDER BY username");


$sql_query_all = "SELECT * FROM JobData";


$stm = $db->prepare($sql_query_all);


//$users = $db->query($sql_query);
//$users = $stm->fetch(PDO::FETCH_ASSOC);



//$query->execute();


echo("<br>
<div align='center'>
<table border='1'>
<col width='200'>
<col width='180'>
<col width='180'>
<col width='180'>
<col width='150'>
<col width='150'>
<tr>
<th style='text-align: center'>Customer Name</th>
<th style='text-align: center'>Appointment Date</th>
<th style='text-align: center'>Appointment Time</th>
<th style='text-align: center'>Assigned Employee</th>
<th style='text-align: center'>Action</th>
<th style='text-align: center'>Result</th>
<th style='text-align: center'></th>
</tr>

<br>
<br>
</div>");


$tabledata = array();
$Status = NULL;
$file_ending = "xls";
$rows = "JobData";

$stm->execute();


//BEGIN WHILE STATEMENT LOOP FOR EACH TABLE
while($row = $stm->fetch(PDO::FETCH_ASSOC)){

$tabledata[] = $row;
//echo $row['username'] . "<br>";

//print_r($tabledata);

$JobNumber = $row['jobnumber'];
$user = $row['customername'];
$rep = $row['username'];
$Date = $row['DateApt'];
$Time = $row['TimeApt'];
//$employee = $row['username'];


/*

if ( $rep == '' ) {



/////////////////create drop down list of employees



$JobStatus = "Unassigned";



} else { $JobStatus = "Assigned"; }

*/

///////////////




if ($rep == '') {

//if ($CheckCompleted_Count == 1) {
$Action = "Assign";
$JobStatus = "Select";

//$JobStatus = "<select name='rep' id='rep'>

//$JobStatus_Button = "Unassigned";


$JobStatus_Button = "<input type='submit' style='color: blue; border: none; background-color: transparent; cursor: pointer; border: none;' id='" . $JobNumber . "'; name='" . $rep . "button'; value='" . $JobStatus . "'; onclick='return ConfirmChoice2();'>";

$FormAction = "AssignJob.php?id=" . $JobNumber . "&user=" . $rep;

$sql_table = $rows;
$sql_username = $ActiveUser;

$_SESSION['id'] = $sql_id;
$_SESSION['memberuser'] = $sql_username; 


} 
else 
{
$Action = "Update";
$JobStatus = $rep;

//$JobStatus = "<select name='rep' id='rep'>"

$JobStatus_Button = "<input type='submit' style='color: blue; border: none; background-color: transparent; cursor: pointer; border: none' id='" . $JobNumber . "'; name='" . $rep . "button'; value='" . $JobStatus . "'; onclick='return ConfirmChoice2();'>";

//$FormAction = "UpdateSelection.php?id=" . $rows . "&user=" . $ActiveUser;
//$FormAction = "UpdateSelection.php?id=" . $JobNumber . "&user=" . $rep;
$FormAction = $DropDownPost;
$DropDownPost = "UpdateSelection.php?id=" . $JobNumber . "&user=" . $Selected_rep;

$sql_table = $rows;
$sql_username = $ActiveUser;

$_SESSION['id'] = $sql_id;
$_SESSION['memberuser'] = $sql_username; 

}


//All Jobs
$TotalQuery = "SELECT * FROM $rows WHERE username = '".$user."'";

$GetTotalCount = $db->query($TotalQuery);
//$GetTotalCount->execute();
$Total_count = $GetTotalCount->rowCount();

//Available jobs
$CountQuery = "SELECT * FROM $rows WHERE username = '".$user."'";

$GetCount = $db->query($CountQuery);
//$GetCount->execute();
$row_count = $GetCount->rowCount();

//Started but not finished
$IncompleteQuery = "SELECT * FROM $rows WHERE checkedin = 'yes' AND checkedout = 'no' AND username = '".$user."'";

$IncompleteCount = $db->query($IncompleteQuery);
//$IncompleteCount->execute();
$Incomplete_count = $IncompleteCount->rowCount();


//Started but not finished
$completeQuery = "SELECT * FROM $rows WHERE checkedin = 'yes' AND checkedout = 'yes' AND username = '".$user."'";


$completeCount = $db->query($completeQuery);
//$IncompleteCount->execute();
$complete_count = $completeCount->rowCount();







$Status = "TBD Stats";
$Status_Button = "<input type='submit' style='color: blue; border: none; background-color: transparent; cursor: pointer; border: none;' id='" . $row . "'; name='submit'; value='" . $Status . "'>";

//$Action = "Update";
$Selected_Rep = $_POST['rep'];
$Action_Button = "<input type='submit' style='color: blue; border: none; background-color: transparent; cursor: pointer; border: none;' id='" . $JobNumber . "'; name='submit'; value='" . $Action . "'>";

//$FormAction = "UpdateSelection.php?id=" . $JobNumber . "&user=" . $Selected_Rep;
//$FormAction = $DropDownPost;


//$FormAction = "UpdateSelection.php?id=" . $JobNumber . "&user=". $_POST['AssignRep']; 

$FormAction = "AssignJob.php?id=" . $JobNumber; 





$Status2 = "TBD Stats";
$Textbutton = "<input type='submit' style='color: blue; border: none; background-color: transparent; cursor: pointer; border: none;' id='" . $rows . "'; name='submit'; value='" . $Status2 . "'>";

$FormActionText = "ExportText.php?id=" . $rows;







$sql_table = $rows;

$sql_username = $ActiveUser;

$_SESSION['id'] = $sql_id;
$_SESSION['memberuser'] = $sql_username; 

//onclick='return ConfirmChoice();'

//}

$query_items = "username = " . $ActiveUser;

echo "<form target='_blank' action=" . $FormAction . " method='POST'>";
//echo "<form target='_blank' action='UpdateSelection.php' method='POST'>";
echo "<tr>";
echo "<td align='center'>" . $user . "</td>"; 
echo "<td align='center'>" . $Date . "</td>";
echo "<td align='center'>" . $Time . "</td>";
echo "<td align='center'><select name='AssignRep' id='AssignRep' style='Width: 100px' 'text-align: center'>";

//$DropDown_List = "<select name=" . $JobNumber.  "id=" . $JobNumber . "style='Width: 100px' 'text-align: center'>";

//echo "<td align='center'>" . $DropDown_List;
echo "<option>" . $JobStatus . "</option>";

//Get Employee Names

$AllEmployees = "SELECT DISTINCT username FROM EmployeeData";
$EmployeeData = $db->query($AllEmployees);
while($EmployeeName = $EmployeeData->fetch(PDO::FETCH_COLUMN, PDO::FETCH_ORI_NEXT)) {

Echo "<option>" . $EmployeeName . "</option>";
//Echo $EmployeeName;

}
echo "</select>";
//echo $Get['AssignRep'];
//if (isset($_GET['AssignRep'])) {
//echo value;
//}

//echo "<input type='Submit' name='Submit2'/>";
echo "</td>";
//echo "</form>";

echo "<td align='center'>" . $Action_Button . "</td>";

echo "<td align='center'>" . $Status_Button . "</td>";
echo "</form>";

//echo "<form target='_blank' action=" . $FormActionText . " method='POST'>";
echo "<form target='_blank' action=" . $FormActionText . " method='POST'>";

//echo "<td align='center'>"  "</td>";
echo "<td align='center'>" . $Textbutton . "</td>";
//echo "<td align='center'>" . $CheckUser_Count . " " . $CheckCompleted_Count . "</td>";

echo("</tr>");
echo "</form>";

//echo $_SESSION['username']; 

}

// ***** THIS ENDS THE SECTION SHOWING THE CURRENT PRODUCTS AND THEIR STATUS'

//header('Location: ../JobTracker/addnewjob.php');


?>




<?php 
//include header template
require('../JobTracker/layout/footer.php'); 
?>

