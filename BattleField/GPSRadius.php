<?php
/* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  */
/*  Selection of points within specified radius of given lat/lon      (c) Chris Veness 2008-2014  */
/* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  */

          require('/var/www/html/Apps/AppsConfig.php'); 
$dbname = "Stevens_GeoHunters";

define('DIR','http://'.$servername.'/Apps/BattleField/');
define('SITEEMAIL','admin@'.$emailServer.'.com');

  //  require 'inc/dbparams.inc.php';  // defines $dsn, $username, $password
  //  $db = new PDO($dsn, $dbuser, $dbpassword);

    $db = new PDO("mysql:host=$servername;dbname=$dbname", $db_username, $db_password);

    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

    $lat = $_GET['lat']; // latitude of centre of bounding circle in degrees
    $lon = $_GET['lon']; // longitude of centre of bounding circle in degrees
    $rad = $_GET['rad']; // radius of bounding circle in kilometers




 //   $R = 6371;  // earth's mean radius, km
 $R = 3959;  // earth's mean radius, miles

    // first-cut bounding box (in degrees)
    $maxLat = $lat + rad2deg($rad/$R);
    $minLat = $lat - rad2deg($rad/$R);

    // compensate for degrees longitude getting smaller with increasing latitude
    $maxLon = $lon + rad2deg($rad/$R/cos(deg2rad($lat)));
    $minLon = $lon - rad2deg($rad/$R/cos(deg2rad($lat)));

////
/*
echo $lat." ";
echo "<br>";
echo $lon." ";
echo "<br>";
echo $rad." ";
echo "<br>";
echo "<br>";


echo "MaxLat = ".$maxLat." ";
echo "<br>";


echo "minLat = ".$minLat." ";
echo "<br>";

echo "MaxLon = ".$maxLon." ";
echo "<br>";


echo "minLon = ".$minLon." ";
echo "<br>";
*/
////

// $sql = "Select id, latitude, longitude From LocationData WHERE latitude >= 27";


    $sql = "SELECT id, username, latitude, longitude, acos(sin(:lat)*sin(radians(latitude)) + cos(:lat)*cos(radians(latitude))*cos(radians(longitude)-:lon)) * :R As D From (Select id, username, latitude, longitude FROM users WHERE latitude Between :minLat And :maxLat And longitude Between :minLon And :maxLon) As FirstCut Where acos(sin(:lat)*sin(radians(latitude)) + cos(:lat)*cos(radians(latitude))*cos(radians(longitude)-:lon)) * :R < :rad Order by D";


//echo "sql Statement = ".$sql;

    $params = array(
        'lat'    => deg2rad($lat),
        'lon'    => deg2rad($lon),
        'minLat' => $minLat,
        'minLon' => $minLon,
        'maxLat' => $maxLat,
        'maxLon' => $maxLon,
        'rad'    => $rad,
        'R'      => $R,
    );
    $points = $db->prepare($sql);
    $points->execute($params);

////
/*
$C = $points->fetch(PDO::FETCH_ASSOC);
$userlatitude = $C['latitude'];
$id = $C['id'];
echo "user latitude = ".$userlatitude."and id = ".$id;
////
 <td><?= $point->username ?></td>
  <td><?= $point->health ?></td>
        <td><?= $point->stealth ?></td>

*/
?>

<html>
<table>
    <? foreach ($points as $point): ?>
    <tr>
        <td><?= $point->Postcode ?></td>
        <td><?= number_format($point->D,1) ?></td>
        <td><?= number_format($point->latitude,3) ?></td>
        <td><?= number_format($point->longitude,3) ?></td> 
    </tr>
    <? endforeach ?>
</table>
</html>