<?php
session_start();

include ('connection.php');

// Check if the user is already logged in, if yes then redirect him to welcome page
if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true){
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

$stmtAmount = $conn->query("SELECT currentyear FROM YearlySessionWeeks");
$campInfo = $stmtAmount->fetch(PDO::FETCH_ASSOC);
$year = $campInfo["currentyear"];

if($_SERVER["REQUEST_METHOD"] == "POST") {
	$sql = "UPDATE ChildrenDynamic SET additionalpaid=:additionalpaid WHERE childid=".$_POST['childid']." AND registeredyear=".$year;
		
		$data = [
			':additionalpaid' => $_POST['amount']
	];
		
	if($stmt = $conn->prepare($sql)){
		if($stmt->execute($data)){
			header("location: childdashboardAdmin.php");
		}
	else{
		echo 'something went wrong';
	}
		
	}
unset($conn);
}