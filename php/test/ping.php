<?php

$ip = "172.21.0.50";
echo $ip."<br>";
$ping = exec("ping -n 1 $ip");

if( preg_match("/perte 100%/", $ping) )
{
echo '<span style="color: red">NON</span><br>';
}
else
{
echo '<span style="color: green">OUI</span><br>';
}

$ip = "172.21.0.94::636";
echo $ip."<br>";
$ping = exec("ping -n 1 $ip");

if( preg_match("/perte 100%/", $ping) )
{
echo '<span style="color: red">NON</span><br>';
}
else
{
echo '<span style="color: green">OUI</span><br>';
}
