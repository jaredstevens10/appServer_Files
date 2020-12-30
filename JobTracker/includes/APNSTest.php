<?php

/*
$fp = fsockopen('184.224.137.57', 80, $errno, $errstr, 5);
if (!$fp) {
    echo "Port is closed";
} else {
  echo "Port is open";
    // port is open and available
    fclose($fp);
}
*/

$host = 'siteground205.com';
$ports = array(21, 25, 80, 81, 110, 443, 3306, 2195);

foreach ($ports as $port)
{
    $connection = @fsockopen($host, $port);

    if (is_resource($connection))
    {
        echo '<h2>' . $host . ':' . $port . ' ' . '(' . getservbyport($port, 'tcp') . ') is open.</h2>' . "\n";

        fclose($connection);
    }

    else
    {
        echo '<h2>' . $host . ':' . $port . ' is not responding.</h2>' . "\n";
    }
}



?>