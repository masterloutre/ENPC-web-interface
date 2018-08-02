<?php
//$servername = "tdlog.enpc.fr";
$servername = "localhost";

// $username = "admin_millenaire4";
// $password = "MuShahf4ool5";
$username = "root";
$password = "";

try {
    $db = new PDO("mysql:host=$servername;dbname=millenaire4;charset=utf8", $username, $password);
    // set the PDO error mode to exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully <br>";
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
}
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
?>
