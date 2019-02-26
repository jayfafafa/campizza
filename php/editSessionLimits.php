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

	//Create query
	$sql = "UPDATE YearlySessionLimits SET dateslimitam=:dateslimitam, dateslimitpm=:dateslimitpm, "
	."treeslimitam=:treeslimitam, treeslimitpm=:treeslimitpm, coconutslimitam=:coconutslimitam, coconutslimitpm=:coconutslimitpm, "
	."youngleaderslimitam=:youngleaderslimitam, youngleaderslimitpm=:youngleaderslimitpm";
		
	//Populate data array
	$data = [
		":dateslimitam" => $_POST["dateslimitam"],
		":dateslimitpm" => $_POST["dateslimitpm"],
		":treeslimitam" => $_POST["treeslimitam"],
		":treeslimitpm" => $_POST["treeslimitpm"],
		":coconutslimitam" => $_POST["coconutslimitam"],
		":coconutslimitpm" => $_POST["coconutslimitpm"],
		":youngleaderslimitam" => $_POST["youngleaderslimitam"],
		":youngleaderslimitpm" => $_POST["youngleaderslimitpm"]
	];
		
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