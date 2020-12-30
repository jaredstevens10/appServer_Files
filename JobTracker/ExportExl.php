<?php
// Connection 
include_once('conn.php');

$Table = $_GET['id'];

$filename = $Table." Export.xls"; // File Name

// Download file
header("Content-Disposition: attachment; filename=\"$filename\""); 
header("Content-Type: application/vnd.ms-excel");

// Write data to file
$flag = false;
while($row = mysql_fetch_assoc($qur)) {
    if(!$flag) {
      // display field/column names as first row
      echo implode("\t", array_keys($row)) . "\r\n";
      $flag = true;
    }
    echo implode("\t", array_values($row)) . "\r\n";
  }
?>