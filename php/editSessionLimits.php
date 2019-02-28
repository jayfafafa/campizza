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

if($_SERVER["REQUEST_METHOD"] == "POST") {
	
	$sql = "UPDATE YearlySessionLimits SET ";
	$data = [];
	
	//Create query && Populate data array for existing non-null/empty values
	if ($_POST['dateslimitam'] != "" ) {
		$sql = $sql." dateslimitam=:dateslimitam,";
		$data[":dateslimitam"] = $_POST["dateslimitam"];
	}
	if ($_POST['dateslimitpm'] != "" ) {
		$sql = $sql." dateslimitpm=:dateslimitpm,";
		$data[":dateslimitpm"] = $_POST["dateslimitpm"];
	}
	if ($_POST['treeslimitam'] != "" ) {
		$sql = $sql." treeslimitam=:treeslimitam,";
		$data[":treeslimitam"] = $_POST["treeslimitam"];
	}
	if ($_POST['treeslimitpm'] != "" ) {
		$sql = $sql." treeslimitpm=:treeslimitpm,";
		$data[":treeslimitpm"] = $_POST["treeslimitpm"];
	}
	if ($_POST['coconutslimitam'] != "" ) {
		$sql = $sql." coconutslimitam=:coconutslimitam,";
		$data[":coconutslimitam"] = $_POST["coconutslimitam"];
	}
	if ($_POST['coconutslimitpm'] != "" ) {
		$sql = $sql." coconutslimitpm=:coconutslimitpm,";
		$data[":coconutslimitpm"] = $_POST["coconutslimitpm"];
	}
	if ($_POST['youngleaderslimitam'] != "" ) {
		$sql = $sql." youngleaderslimitam=:youngleaderslimitam,";
		$data[":youngleaderslimitam"] = $_POST["youngleaderslimitam"];
	}
	if ($_POST['youngleaderslimitpm'] != "" ) {
		$sql = $sql." youngleaderslimitpm=:youngleaderslimitpm,";
		$data[":youngleaderslimitpm"] = $_POST["youngleaderslimitpm"];
	}
	
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