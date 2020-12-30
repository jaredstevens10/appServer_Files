

<?php require('../JobTracker/includes/config.php'); 
// define variables and set to empty values
$nameErr = $emailErr = $genderErr = $websiteErr = "";
$name = $email = $gender = $comment = $website = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   if (empty($_POST["name"])) {
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


try {
  //  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
   // $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // sql to create table
  //  UNSIGNED AUTO_INCREMENT PRIMARY KEY, lastname VARCHAR(255) NOT NULL, email VARCHAR(255), Taken VARCHAR (255), Complete VARCHAR (255), reg_date TIMESTAMP

/*

$sql = "CREATE TABLE $name (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, identifier VARCHAR(30),
    username VARCHAR(30) NOT NULL,
    facebookUN VARCHAR(30) NOT NULL, contactnumber VARCHAR(30),
    email VARCHAR(50), IsAvailable VARCHAR(30) NOT NULL DEFAULT 'Yes', Complete VARCHAR(30) NOT NULL DEFAULT 'No', confirmation VARCHAR(30) NOT NULL,
   reg_date TIMESTAMP
    )";

    // use exec() because no results are returned
    $conn->exec($sql);
    
    
    
   	$file = $_FILES['file']['tmp_name'];
		$handle = fopen($file, "r");
		$c = 0;
		while(($filesop = fgetcsv($handle, 1000, ",")) !== false)
		{
			$id = $filesop[0];
			$identifier = $filesop[1];
$username = $filesop[2];
$lastname = $filesop[3];
$email = $filesop[4];
$IsAvailable = $filesop[5];
$Complete = $filesop[6];
$reg_date = $filesop[7];


	*/		
//ORIGINAL SQL STATEMENT
			//$sql_import = $conn->prepare("INSERT INTO $name (id, identifier, firstname, lastname, email, IsAvailable, Complete, reg_date) VALUES ('$id', '$identifier', '$firstname', '$lastname', '$email', '$IsAvailable', '$Complete', '$reg_date')");



$DateApt2 = $_POST['DateApt'];

//$DateApt = date("yyyy-mm-dd", strtotime($DateApt2));

$DateApt = DateTime::createFromFormat('m/d/Y', $DateApt2)->format('Y-m-d');


$id = $_POST['name'];
$TimeApt = $_POST['TimeApt'];
$customername = $_POST['customername'];

$sql_import = $conn->prepare("INSERT INTO JobData (id,DateApt, TimeApt, customername) VALUES ('$id','$DateApt', '$TimeApt', '$customername')");
//$conn->prepare($sql_import);


//ORIGINAL SQL STATEMENT
//$sql_import->bindParam($id,$identifier,$firstname,$lastname,$email,$IsAvailable,$Complete,$reg_date);


$sql_import->bindParam($id,$DateApt,$TimeApt,$customername);
//$sql->bindParam('$email', 'email@email.com');
$sql_import->execute();


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
header('Location: ../Reviews/ImportNewReview.php');
//exit;


}
else			
{

?>
  <script type="text/javascript">
    alert("Sorry! There is some problem.");
    //history.back();
  </script>
//echo "Sorry! There is some problem.";
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
				<h2>Assign New Job</h2>
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
				<input type="text" name="customername" id="customername" class="form-control input-lg" placeholder="Enter Customer Name" value="<?php if(isset($error)){ echo $_POST['customerusername']; } ?>" tabindex="2">
				</div>



                <div class="form-group">
					<input type="text" name="DateApt" id="datepicker" class="form-control input-lg" placeholder="Select Appointment Date" value="<?php if(isset($error)){ echo $_POST['DateApt']; } ?>" tabindex="3" /> 
				</div>


            <div class="form-group">
              
                <input name="TimeApt" id="basicExample" type="text" class="form-control input-lg" data-scroll-default="6:00am" placeholder="Select Appointment Time" value="<?php if(isset($error)){ echo $_POST['TimeApt']; } ?>" tabindex="4"/> <br /> <br />
            </div>

            <script>
                $(function() {
                    $('#basicExample').timepicker();
                });
            </script>

  
    <!--      	<div class="form-group">
					<input type="file" name="file" id="file" class="form-control input-lg" placeholder="Select .csv file to import" tabindex="5" /> <br /> <br />
				</div>
     -->
				
					
				<hr>
				<div class="row">
					<div class="col-xs-6 col-md-6"><input type="submit" name="submit" value="Submit" class="btn btn-primary btn-block btn-lg" tabindex="5"></div>
				</div>
			</form>


<br style="margin-bottom:240px;"/>




		</div>

<br style="margin-bottom:500px;"/>




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


//Started but not finished
$completeQuery = "SELECT * FROM $rows WHERE checkedin = 'yes' AND checkedout = 'yes'";

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

echo "<form target='_blank' action=" . $FormAction . " method='POST'>";
echo "<tr>";
echo "<td align='center'>" . $rows . "</td>"; 
echo "<td align='center'>" . $Total_count . "</td>";
echo "<td align='center'>" . $row_count . "</td>";
echo "<td align='center'>" . $Incomplete_count . "</td>";
echo "<td align='center'>" . $complete_count . "</td>";
echo "<td align='center'>" . $Status_Button . "</td>";
echo "</form>";
echo "<form target='_blank' action=" . $FormActionText . " method='POST'>";
echo "<td align='center'>" . $Textbutton . "</td>";
//echo "<td align='center'>" . $CheckUser_Count . " " . $CheckCompleted_Count . "</td>";

echo("</tr>");
echo "</form>";

//echo $_SESSION['username']; 

//}

// ***** THIS ENDS THE SECTION SHOWING THE CURRENT PRODUCTS AND THEIR STATUS'

?>

<hr>

<?php


// ***** THIS SHOWS THE CURRENT PRODUCTS AND THEIR STATUS

//$query = $db->prepare("SELECT DISTINCT TABLE_NAME, COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME LIKE 'IsAvailable%' AND TABLE_SCHEMA='clavenso_ReviewMembers'");
$query = $db->prepare("SELECT DISTINCT username FROM JobData ORDER BY username");
$query->execute();


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


$tabledata = array();
$Status = NULL;
$file_ending = "xls";
$rows = "JobData";

//BEGIN WHILE STATEMENT LOOP FOR EACH TABLE
while($row_users = $query->fetch(PDO::FETCH_COLUMN, PDO::FETCH_ORI_NEXT)){
//while($row_users = $query->fetch(PDO::FETCH_ASSOC)){


$tabledata[] = $row_users;

//All Jobs
$TotalQuery = "SELECT * FROM $rows WHERE username = '" . $row_users . "'";

$GetTotalCount = $db->query($TotalQuery);
//$GetTotalCount->execute();
$Total_count = $GetTotalCount->rowCount();

//Available jobs
$CountQuery = "SELECT * FROM $rows WHERE username = '" . $row_users . "'";

$GetCount = $db->query($CountQuery);
//$GetCount->execute();
$row_count = $GetCount->rowCount();

//Started but not finished
$IncompleteQuery = "SELECT * FROM $rows WHERE checkedin = 'yes' AND checkedout = 'no' AND username = '" . $row_users . "'";


$IncompleteCount = $db->query($IncompleteQuery);
//$IncompleteCount->execute();
$Incomplete_count = $IncompleteCount->rowCount();


//Started but not finished
$completeQuery = "SELECT * FROM $rows WHERE checkedin = 'yes' AND checkedout = 'yes' AND username = '" . $row_users . "'";


$completeCount = $db->query($completeQuery);
//$IncompleteCount->execute();
$complete_count = $completeCount->rowCount();


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

}
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

echo "<form target='_blank' action=" . $FormAction . " method='POST'>";
echo "<tr>";
echo "<td align='center'>" . $row_users . "</td>"; 
echo "<td align='center'>" . $Total_count . "</td>";
echo "<td align='center'>" . $row_count . "</td>";
echo "<td align='center'>" . $Incomplete_count . "</td>";
echo "<td align='center'>" . $complete_count . "</td>";
echo "<td align='center'>" . $Status_Button . "</td>";
echo "</form>";
echo "<form target='_blank' action=" . $FormActionText . " method='POST'>";
echo "<td align='center'>" . $Textbutton . "</td>";
//echo "<td align='center'>" . $CheckUser_Count . " " . $CheckCompleted_Count . "</td>";

echo("</tr>");
echo "</form>";

//echo $_SESSION['username']; 

//}

// ***** THIS ENDS THE SECTION SHOWING THE CURRENT PRODUCTS AND THEIR STATUS'

?>


	</div>

<br style="margin-bottom:240px;"/>



</div>






<?php 
//include header template
require('../JobTracker/layout/footer.php'); 
?>

