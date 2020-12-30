<?php

header('Content-type: application/json');
if($_POST) {

$CurrentVerion = "1.0.0";
$AppVersion   = $_POST['version'];

//echo "User Version".$AppVersion;
//echo "Current User Version".$CurrentVerion;


if ($CurrentVerion == $AppVersion) {

echo '{"success":0,"version":"current"}';

} else {
echo '{"success":1,"version":"not current"}';
}




} else {
    
    echo '{"success":0,"version":"error"}';
    
}

?>