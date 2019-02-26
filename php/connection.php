<?php
$servername = "35.236.84.4";
$username = "campizza";
$password = "Yusuf20@";
$dbname = "campizzatest"; //campizza for live; campizzatest for testing 


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}
?>