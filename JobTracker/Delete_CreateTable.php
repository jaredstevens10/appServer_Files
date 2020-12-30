<!DOCTYPE HTML> 
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body> 

<?php
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

<h2>New Review Table</h2>
<p><span class="error">* required field.</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
   Table Name: <input type="text" name="name" value="<?php echo $name;?>">
   <span class="error">* <?php echo $nameErr;?></span>
   <br><br>
   <span class="error">* <?php echo $genderErr;?></span>
   <br><br>
   <input type="submit" name="submit" value="Submit"> 
</form>

<?php

$servername = "localhost";
$username = "clavenso_Admin";
 $password = "claven01*";
$dbname = "clavenso_ReviewMembers";


	if(isset($_POST["submit"]))
	{


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // sql to create table
  //  UNSIGNED AUTO_INCREMENT, lastname VARCHAR(255) NOT NULL, email VARCHAR(255), Taken VARCHAR (255), Complete VARCHAR (255) reg_date TIMESTAMP



$sql = "CREATE TABLE $name (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, identifier VARCHAR(30),
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    email VARCHAR(50), IsAvailable VARCHAR(30), Complete VARCHAR(30),
   reg_date TIMESTAMP
    )";


//$sql = "CREATE TABLE $name (
//    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
//    identifier VARCAR(30), 
//    firstname VARCHAR(30) NOT NULL, 
//    lastname VARCHAR(30) NOT NULL, 
//    email VARCHAR(30), 
//    IsAvailable VARCHAR (30), 
//    Complete VARCHAR(30), 
//    reg_date TIMESTAMP
//    )'";



    // use exec() because no results are returned
    $conn->exec($sql);
    echo "Table was created successfully";
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

$conn = null;


//echo '<h2>Your Input:</h2>';
//echo $name;
//echo '<br>';
}
?>

</body>
</html>