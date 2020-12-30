<?php require('../includes/config.php'); 
// define variables and set to empty values
$nameErr = $emailErr = $genderErr = $websiteErr = "";
$name = $email = $gender = $comment = $website = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   if (empty($_POST["name"])) {
     $nameErr = "Table Name is required";
   } else {
     $name = test_input($_POST["name"]);
     // check if name only contains letters and whitespace
     if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
       $nameErr = "Only letters and white space allowed"; 
     }
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

<h2>Import New Review Table</h2>
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
	include ("connection.php");


//maybe delete below??

//maybe delete above??


	
	if(isset($_POST["submit"]))
	{


try {
  //  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
   // $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // sql to create table
  //  UNSIGNED AUTO_INCREMENT PRIMARY KEY, lastname VARCHAR(255) NOT NULL, email VARCHAR(255), Taken VARCHAR (255), Complete VARCHAR (255), reg_date TIMESTAMP

$sql = "CREATE TABLE $name (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, identifier VARCHAR(30),
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    email VARCHAR(50), IsAvailable VARCHAR(30) NOT NULL DEFAULT 'Yes', Complete VARCHAR(30) NOT NULL DEFAULT 'No',
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
$firstname = $filesop[2];
$lastname = $filesop[3];
$email = $filesop[4];
$IsAvailable = $filesop[5];
$Complete = $filesop[6];
$reg_date = $filesop[7];
			
//ORIGINAL SQL STATEMENT
			//$sql_import = $conn->prepare("INSERT INTO $name (id, identifier, firstname, lastname, email, IsAvailable, Complete, reg_date) VALUES ('$id', '$identifier', '$firstname', '$lastname', '$email', '$IsAvailable', '$Complete', '$reg_date')");


			$sql_import = $conn->prepare("INSERT INTO $name (id, identifier) VALUES ('$id', '$identifier')");
//$conn->prepare($sql_import);


//ORIGINAL SQL STATEMENT
//$sql_import->bindParam($id,$identifier,$firstname,$lastname,$email,$IsAvailable,$Complete,$reg_date);


$sql_import->bindParam($id,$identifier);
//$sql->bindParam('$email', 'email@email.com');
$sql_import->execute();
			$c = $c + 1;
		}
		
			if($sql_import){
//echo $sql_import;



?>
  <script type="text/javascript">
    alert("The new table <?php echo $name;?> was created and the file import was successful.  You have inserted <?php echo $c;?>  records.");
    //history.back();
  </script>
<?php


$sql_delete_blank = $conn->prepare("DELETE FROM $name WHERE identifier = ''");
$sql_delete_blank->execute();

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
$title = 'Import Review File';

//include header template
require('../layout/header.php'); 
?>

	
<div class="container">

	<div class="row">

	    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">

<form role="form" name="post" method="post" enctype="multipart/form-data" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">


		<!--	<form role="form" method="post" action="" autocomplete="off">  -->
				<h2>Import New Review Table</h2>
				<p><a href='../Reviews/index.php'>Back to home page</a></p>
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
						case 'active':
							echo "<h2 class='bg-success'>Your account is now active you may now log in.</h2>";
							break;
						case 'reset':
							echo "<h2 class='bg-success'>Please check your inbox for a reset link.</h2>";
							break;
						case 'resetAccount':
							echo "<h2 class='bg-success'>Password changed, you may now login.</h2>";
							break;
					}

				}

				
				?>

				<div class="form-group">
					<input type="text" name="name" id="name" class="form-control input-lg" placeholder="New Review Table Name" value="<?php if(isset($error)){ echo $_POST['username']; } ?>" tabindex="1">
				</div>

				<div class="form-group">
					<input type="file" name="file" id="file" class="form-control input-lg" placeholder="Select .csv file to import" tabindex="3" /> <br /> <br />
				</div>
				
					
				<hr>
				<div class="row">
					<div class="col-xs-6 col-md-6"><input type="submit" name="submit" value="Submit" class="btn btn-primary btn-block btn-lg" tabindex="4"></div>
				</div>
			</form>
		</div>
	</div>



</div>



<?php


// ***** THIS SHOWS THE CURRENT PRODUCTS AND THEIR STATUS

$query = $db->prepare("SELECT DISTINCT TABLE_NAME, COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME LIKE 'IsAvailable%' AND TABLE_SCHEMA='clavenso_ReviewMembers'");
$query->execute();


echo("<br>
<div align='center'>
<table border='1'>
<col width='200'>
<col width='180'>
<col width='180'>
<col width='180'>
<col width='150'>
<tr>
<th style='text-align: center'>Item Name</th>
<th style='text-align: center'>Total # Reviews</th>
<th style='text-align: center'># Unselected Codes</th>
<th style='text-align: center'># incomplete Reviews</th>
<th style='text-align: center'>Action</th>
</tr>
</div>");


$tabledata = array();
$Status = NULL;
$file_ending = "xls";


//BEGIN WHILE STATEMENT LOOP FOR EACH TABLE
while($rows = $query->fetch(PDO::FETCH_COLUMN, PDO::FETCH_ORI_NEXT)){

$tabledata[] = $rows;
$TotalQuery = "SELECT * FROM $rows";

$GetTotalCount = $db->query($TotalQuery);
//$GetTotalCount->execute();
$Total_count = $GetTotalCount->rowCount();


$CountQuery = "SELECT * FROM $rows WHERE IsAvailable = 'Yes'";

$GetCount = $db->query($CountQuery);
//$GetCount->execute();
$row_count = $GetCount->rowCount();


$IncompleteQuery = "SELECT * FROM $rows WHERE Complete = 'No'";

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



//EXCEL EXPORT CODE

///*

//$Export_Query = "SELECT * FROM $rows";
//$filename = $rows;
//header("Content-Disposition: attachment; filename=\"$filename\".xls");
//header("Content-Type: application/vnd.ms-excel");

// Write data to file

//$flag = false;
//while ($excelrow = $Export_Query->fetch(PDO::FETCH_ASSOC)) {
//    if (!$flag) {
//       display field/column names as first row
//        echo implode("\t", array_keys($row)) . "\r\n";
//        $flag = true;
//    }
//    echo implode("\t", array_values($row)) . "\r\n";
//  }

//END EXCEL EXPORT CODE


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
echo "<td align='center'>" . $Status_Button . "</td>";
//echo "<td align='center'>" . $CheckUser_Count . " " . $CheckCompleted_Count . "</td>";

echo("</tr>");
echo "</form>";



//echo $_SESSION['username']; 

}

// ***** THIS ENDS THE SECTION SHOWING THE CURRENT PRODUCTS AND THEIR STATUS'


?>



<?php 
//include header template
require('../layout/footer.php'); 
?>

