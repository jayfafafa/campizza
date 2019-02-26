<?php
// Initialize the session
session_start();

include('connection.php');
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}   else if ( ( isset($_SESSION["loggedin"]) && isset($_SESSION["registered"]) ) && ( $_SESSION["loggedin"] === true && $_SESSION["registered"] === false) ){
    //delete session registered
    header("location: parentregistration.php");
    exit;
}

$result = $conn->query("SELECT auth FROM ParentsLogin WHERE parentid=".$_SESSION['id']);
$row = $result->fetch(PDO::FETCH_ASSOC);
if($row['auth'] != 1){
    header('location: dashboard.php');
}

// Require https
if ($_SERVER['HTTPS'] != "on") {
    $url = "https://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    header("Location: $url");
    exit;
}

/////////////////////////////////////////////////////////////////////////////

$stmtAmount = $conn->query("SELECT * FROM YearlySessionWeeks");
$campInfo = $stmtAmount->fetch(PDO::FETCH_ASSOC);
$activeweeks = $campInfo["activeweeks"];
//testing purposes
/*
    foreach ($_POST as $key => $value) {
        if($value === "") {
			continue;
		}
        echo $key;
        echo $value;
    }
*/
//
	
if($_SERVER["REQUEST_METHOD"] == "POST") {

	//Create query according to active weeks
	$sql = "UPDATE YearlySessionWeeks SET ";
	$data = [];
	
	for($x = 1; $x <= 8; $x++){
		if ($_POST['week'.$x.'start'] != "" ) {
			$sql = $sql." week".$x."start=:week".$x."start,";
			$data[":week".$x."start"] = $_POST["week".$x."start"];
		}
		if ($_POST['week'.$x.'end'] != "") {
			$sql = $sql." week".$x."end=:week".$x."end,";
			$data[":week".$x."end"] = $_POST["week".$x."end"];
		}
	}
	
	if ($_POST['activeweeks'] != "") {
		$sql = $sql."activeweeks=:activeweeks,";
		$data[":activeweeks"] = $_POST["activeweeks"];
	}
	if ($_POST['currentyear'] != "") {
		$sql = $sql." currentyear=:currentyear,";
		$data[":currentyear"] = $_POST["currentyear"];
	}
	if ($_POST['holidayweek'] != "") {
		$sql = $sql." holidayweek=:holidayweek,";
		$data[":holidayweek"] = $_POST["holidayweek"];
	}
	
	//Populate data array according to amount of active weeks		
	$sql = substr($sql, 0, strlen($sql)-1);
	
	if($stmt = $conn->prepare($sql)){
		if($stmt->execute($data)){
			header("location: dashboard.php");
		}
		else{
			echo 'something went wrong';
		}
	}

unset($conn);
}
?>