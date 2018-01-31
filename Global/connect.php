<?php

$servername = "localhost";
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

?>
