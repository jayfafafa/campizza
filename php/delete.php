<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}   else if ( ( isset($_SESSION["loggedin"]) && isset($_SESSION["registered"]) ) && ( $_SESSION["loggedin"] === true && $_SESSION["registered"] === false) ){
	//delete session registered
    header("location: parentregistration.php");
    exit;
}
include('connection.php');

	$sql = "DELETE FROM `Children` WHERE `childid` =".$_GET['childid'];
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	header("location: childdisplay.php");
	
unset($conn);
?>