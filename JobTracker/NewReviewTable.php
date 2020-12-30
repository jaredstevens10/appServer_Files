<html>
<head>
	<style type="text/css">
	body
	{
		margin: 0;
		padding: 0;
		background-color: gray;
		text-align:center;
	}
	.top-bar
		{
			width: 100%;
			height: auto;
			text-align: center;
			background-color:#FFF;
			border-bottom: 1px solid #000;
			margin-bottom: 20px;
		}
	.inside-top-bar
		{
			margin-top: 5px;
			margin-bottom: 5px;
		}
	.link
		{
			font-size: 18px;
			text-decoration: none;
			background-color: gray;
			color: #FFF;
			padding: 5px;
		}
	.link:hover
		{
			background-color: #9688B2;
		}
	</style>
	
	<script>
	// <!-- (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	//  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	//  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	//  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	//  ga('create', 'UA-60962033-1', 'auto');
	//  ga('send', 'pageview');
    //-->
	</script>
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
	<div class="top-bar">
		<div class="inside-top-bar">
			<br>
			<a><font size="5"><b>48 Hour Reviews<br>Add New Item to 

Reivew</font></b></a>
			<br><br>
		<!--	<a href="http://www.eggslab.net/import-excel-file-data-in-mysql-

database-using-php" class="link">&larr; Back to Article</a> | <a 

href="http://demos.eggslab.net/" class="link">More Demos &rarr;</a>
		-->
        </div>
	</div>
    <div style="border:1px dashed #333333; width:300px; margin:0 auto; padding:10px; 

background:white;">
    



	<form name="post" method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Table Name: <input type="text" name="name" value="<?php echo $name;?>">
   <span class="error"><?php echo $nameErr;?></span>
   <br>
   <span class="error"><?php echo $genderErr;?></span>
   <input type="file" name="file" /><br /> <br>
    <input type="submit" name="submit" value="Submit" />
    </form>
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
    email VARCHAR(50), IsAvailable VARCHAR(30), Complete VARCHAR(30),
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
			
			$sql_import = $conn->prepare("INSERT INTO $name (id, identifier, firstname, lastname, email, IsAvailable, Complete, reg_date) VALUES ('$id', '$identifier', '$firstname', '$lastname', '$email', '$IsAvailable', '$Complete', '$reg_date')");
//$conn->prepare($sql_import);

$sql_import->bindParam($id,$identifier,$firstname,$lastname,$email,$IsAvailable,$Complete,$reg_date);
//$sql->bindParam('$email', 'email@email.com');
$sql_import->execute();
			$c = $c + 1;
		}
		
			if($sql_import){
//echo $sql_import;
				echo "You database has imported successfully. You have 

inserted ". $c ." records";
			}else{
//echo $sql_import;
				echo "Sorry! There is some problem.";
                //echo $sql;
			} 
    
    
    
    echo 'The new Review Table ' . $Name . ' was created successfully';
    }
catch(PDOException $e)
    {
    echo $sql . '<br>' . $e->getMessage();
    }


	}
?>
    
    </div>
    <hr style="margin-top:300px;" />	
    
    <div align="center" style="font-size:18px; background: white;"><a></a></div>

</body>
</html>