<?php 
include ("connection.php");

$servername = "localhost";
$username = "clavenso_Admin";
//$username = "root";
//$password = "";
$password = "claven01*";
$dbname = "clavenso_ReviewMembers";
//$dbname = "members";

$db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//$query = $db->prepare('show tables');
//$query->execute();

function list_tables()
{
   // $sql = "SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA='clavenso_ReviewMembers'";
$sql = 'show tables';

    if($db->is_connected)
    {
        $query = $db->pdo->query($sql);
       return $query->fetchAll(PDO::FETCH_COLUMN);
echo $query;
    }
    return FALSE;
}




?>