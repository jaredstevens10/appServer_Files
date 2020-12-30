<?php require('../includes/config.php'); 

session_start();

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: 

../Reviews/login.php'); } 

//define page title
$title = 'Members Page';

//include header template
require('../layout/header.php'); 
?>

<div class="container">

	<div class="row">

	    <div class="col-xs-12 col-sm-8 col-md-6 

col-sm-offset-2 col-md-offset-3">
			<h1 align="center">48 Hour 

Reviews</h1>
				<h2 align="center">Welcome <?php echo $_SESSION['username']; ?>
</h2><p><a href='../Reviews/logout.php'>Logout</a></p><hr>

		</div>
	</div>


</div>

<?php
include ("connection.php");

$select_statement = null;

if(isset($_POST['submit'])) {
  //$alert_script =  "<script>alert(\'You have to tick the box\')</script>";
 // $error = true;

header('Location: ../Reviews/ItemSelection.php' . '?id=' . $_GET['id']);

//$select_query = $db->prepare('SELECT identifier from 

} else

 {
  //$error = false;
}


//if (!$error) {
  //complete the action code/call another file.
//}



$ActiveUser = $_SESSION['username'];



$servername = "localhost";
$username = "clavenso_Admin";
//$username = "root";
//$password = "";
$password = "claven01*";
$dbname = "clavenso_ReviewMembers";
//$dbname = "members";

$db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$query = $db->prepare("SELECT DISTINCT TABLE_NAME, COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME LIKE 'IsAvailable%' AND TABLE_SCHEMA='clavenso_ReviewMembers'");
//$query = $db->prepare("Show Tables");
$query->execute();


echo("<div align='center'>
<table border='1'>
<col width='150'>
<col width='170'>
<col width='150'>
<tr>
<th style='text-align: center'>Item Name</th>
<th style='text-align: center'>Remaining 

Available</th>
<th style='text-align: center'>Action</th>
</tr>
</div>");


$tabledata = array();
$Status = NULL;


//BEGIN WHILE STATEMENT LOOP FOR EACH TABLE
while($rows = $query->fetch(PDO::FETCH_COLUMN, PDO::FETCH_ORI_NEXT)){

$tabledata[] = $rows;
$CountQuery = "SELECT * FROM $rows WHERE IsAvailable = 'Yes'";

$GetCount = $db->query($CountQuery);
//$GetCount->execute();
$row_count = $GetCount->rowCount();



// CHECKS IF USER ALREADY HAS SIGNED UP TO REVIEW THIS PRODUCT
$CheckUserQuery = "SELECT * FROM $rows WHERE username = '" . $ActiveUser . "'";
$CheckUser = $db->query($CheckUserQuery);
$CheckUser->execute();
$CheckUser_Count = $CheckUser->rowCount();
//$CheckUser_Count = ($CheckUser->fetchColumn() > 0) ? true : false;

// CHECKS IF USER ALREADY HAS COMPLETED THEIR REVIEW
$CheckCompletedQuery = "SELECT * FROM $rows WHERE username = '" . $ActiveUser . "' AND Complete = 'Yes'";
$CheckCompleted = $db->query($CheckCompletedQuery);
$CheckCompleted->execute();
$CheckCompleted_Count = $CheckCompleted->rowCount

();
//$CheckCompleted_Count = ($CheckCompleted->fetchColumn() > 0) ? true : false;


if ($CheckUser_Count == 1) {
if ($CheckCompleted_Count == 1) {
$Status = "Complete";
$Status_Button = "Complete";
} 
else 
{$Status = "In Process";
$Status_Button = "<input type='submit' style='color: blue; border: none; background-color: transparent; cursor: pointer; border: none;' id='" . $rows . "'; name='" . $rows . "button'; value='" . $Status . "'; onclick='return ConfirmChoice2();'>";

$FormAction = "UpdateSelection.php?id=" . $rows . "&user=" . $ActiveUser;

$sql_table = $rows;
$sql_username = $ActiveUser;

$_SESSION['id'] = $sql_id;
$_SESSION['memberuser'] = $sql_username; 

}
}
else
{
if ($row_count == 0) {
$Status = "Unavailable";
$Status_Button = "Unavailable";
//$Status_Button = "<input type='submit' style='color: blue; border: none; background-color: transparent; cursor: pointer; border: none;' id='" . $rows . "'; name='submit'; value='" . $Status . "'>";

}
else 
{
$Status = "Select";
$Status_Button = "<input type='submit' style='color: blue; border: none; background-color: transparent; cursor: pointer; border: none;' id='" . $rows . "'; name='submit'; value='" . $Status . "'>";
$FormAction = "ItemSelection.php?id=" . $rows . "&user=" . $ActiveUser;

$sql_table = $rows;
$sql_username = $ActiveUser;

$_SESSION['id'] = $sql_id;
$_SESSION['memberuser'] = $sql_username; 
}
//onclick='return ConfirmChoice();'
  
}

$query_items = "username = " . $ActiveUser;

echo "<form target='_blank' action=" . $FormAction . " method='POST'>";
echo "<tr>";
echo "<td align='center'>" . $rows . "</td>"; 
echo "<td align='center'>" . $row_count . "</td>";
echo "<td align='center'>" . $Status_Button . "</td>";
//echo "<td align='center'>" . $CheckUser_Count . " " . $CheckCompleted_Count . "</td>";

echo("</tr>");
echo "</form>";



//echo $_SESSION['username']; 

}

//echo $tabledata[0];
//echo ("<br>");
 
//echo $ActiveUser;

//echo count($tabledata);

?>


<script type="text/javascript">

function ConfirmChoice() 
{ 
answer = confirm("Are you sure you want to review this product?")
if (answer) 
{ 
location = "../Reviews/ItemSelection.php"
} else 
{
//do something
}

}

</script>




<?php




//include header template
require('../layout/footer.php'); 
?>

