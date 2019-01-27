<?php
$servername = "rugged-sunbeam-229808:us-west2:campizza";
$username = "campizza";
$password = "Yusuf20@";
try {
    $conn = new PDO("mysql:host=$servername;dbname=$username", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}
?>