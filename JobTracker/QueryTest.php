<?php
echo "<table style='border: solid 1px black;'>";
 //echo "<tr><th>Identifier</th><th>Firstname</th><th>Lastname</th></tr>";


class TableRows extends RecursiveIteratorIterator { 
    function __construct($it) { 
        parent::__construct($it, self::LEAVES_ONLY); 
    }

    function current() {
        return "<td style='width:150px;border:1px solid black;'>" . parent::current(). "</td>";
    }

    function beginChildren() { 
        echo "<tr>"; 
    } 

    function endChildren() { 
        echo "</tr>" . "\n";
    } 
} 

//include 'include/config.php';
$servername = "localhost";
$username = "clavenso_Admin";
$password = "claven01*";
$dbname = "clavenso_ReviewMembers";

 try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT identifier FROM TESTNEW WHERE isAvailable = 'Yes' LIMIT 1"); 
    $stmt->execute();

// WHERE isAvailable = 'Yes' LIMIT 1
 // if (is_null($stmt["identifier])){
//$result=="";
//}
//else
//{
    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 
    foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) { 
if (MySQL_num_rows($result) > 0){
echo "empty";
}
else
{
        echo $v;
}
    }
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
if ($result=="")
//if (!$row['id']=="")
{
echo "This Product Review is full, try again when the next review is announced";
}
else
{
echo "</table>";
}
?> 