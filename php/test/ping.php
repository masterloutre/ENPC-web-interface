<?php

$ip = 172.21.0.50;
$ping = exec("ping -n 1 $ip");
if(ereg("perte 100%", $ping))
{
echo '<span style="color: red">NON</span>';
}
else
{
echo '<span style="color: green">OUI</span>';
}
