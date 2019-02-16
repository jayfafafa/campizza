<?php

// Initialize the session
session_start();
 
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}   else if ( ( isset($_SESSION["loggedin"]) && isset($_SESSION["registered"]) ) && ( $_SESSION["loggedin"] === true && $_SESSION["registered"] === false) ){
	//delete session registered
    header("location: parentregistration.php");
    exit;
}

// Require https
if ($_SERVER['HTTPS'] != "on") {
    $url = "https://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    header("Location: $url");
    exit;
}
include ('connection.php');

$sql = $_SESSION['query'];
$data = $_SESSION['data'];

$data[':price'] = $_SESSION['total'];

	if(isset($_POST['paid']) && $_POST['paid'] == "True") {
		if($stmt = $conn->prepare($sql)){
			if($stmt->execute($data)){
				header("location: childdisplay.php");
			}
			else{
				echo "there was a problemo";
			}
			
		}
	} else {
		header("location: childdisplay.php");
	}


unset($conn)



?>