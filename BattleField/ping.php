<?php

//$result = ping(gateway.sandbox.push.apple.com);


//echo "result: ".$result;

/*
function ping($host,$port=2195,$timeout=6)
{
        $fsock = fsockopen($host, $port, $errno, $errstr, $timeout);
        if ( ! $fsock )
        {
echo "return false";
                return FALSE;
        }
        else
        {
echo "return true";
                return TRUE;
        }
}
*/


$fp = fsockopen('17.188.135.152', 2195, $errno, $errstr, 5);


if (!$fp) {
    // port is closed or blocked
echo "port closed " . $errstr . " " . $errno;
} else {
    // port is open and available
echo "port open";
    fclose($fp);
}


?>