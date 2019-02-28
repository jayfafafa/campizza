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


	$sql = "UPDATE YearlySessionPricing SET ";
	$data = [];
	
	
	//Create query && Populate data array for existing non-null/empty values
	if ($_POST['oneweekamearly'] != "" ) {
		$sql = $sql." oneweekamearly=:oneweekamearly,";
		$data[":oneweekamearly"] = $_POST["oneweekamearly"];
	}
	if ($_POST['oneweekpmearly'] != "" ) {
		$sql = $sql." oneweekpmearly=:oneweekpmearly,";
		$data[":oneweekpmearly"] = $_POST["oneweekpmearly"];
	}
	if ($_POST['oneweekfullearly'] != "" ) {
		$sql = $sql." oneweekfullearly=:oneweekfullearly,";
		$data[":oneweekfullearly"] = $_POST["oneweekfullearly"];
	}
	if ($_POST['oneweekamlate'] != "" ) {
		$sql = $sql." oneweekamlate=:oneweekamlate,";
		$data[":oneweekamlate"] = $_POST["oneweekamlate"];
	}
	if ($_POST['oneweekpmlate'] != "" ) {
		$sql = $sql." oneweekpmlate=:oneweekpmlate,";
		$data[":oneweekpmlate"] = $_POST["oneweekpmlate"];
	}
	if ($_POST['oneweekfulllate'] != "" ) {
		$sql = $sql." oneweekfulllate=:oneweekfulllate,";
		$data[":oneweekfulllate"] = $_POST["oneweekfulllate"];
	}
	if ($_POST['holidayweekamlate'] != "" ) {
		$sql = $sql." holidayweekamlate=:holidayweekamlate,";
		$data[":holidayweekamlate"] = $_POST["holidayweekamlate"];
	}
	if ($_POST['holidayweekpmlate'] != "" ) {
		$sql = $sql." holidayweekpmlate=:holidayweekpmlate,";
		$data[":holidayweekpmlate"] = $_POST["holidayweekpmlate"];
	}
	if ($_POST['holidayweekfulllate'] != "" ) {
		$sql = $sql." holidayweekfulllate=:holidayweekfulllate,";
		$data[":holidayweekfulllate"] = $_POST["holidayweekfulllate"];
	}
	if ($_POST['holidayweekamearly'] != "" ) {
		$sql = $sql." holidayweekamearly=:holidayweekamearly,";
		$data[":holidayweekamearly"] = $_POST["holidayweekamearly"];
	}
	if ($_POST['holidayweekpmearly'] != "" ) {
		$sql = $sql." holidayweekpmearly=:holidayweekpmearly,";
		$data[":holidayweekpmearly"] = $_POST["holidayweekpmearly"];
	}
	if ($_POST['holidayweekfullearly'] != "" ) {
		$sql = $sql." holidayweekfullearly=:holidayweekfullearly,";
		$data[":holidayweekfullearly"] = $_POST["holidayweekfullearly"];
	}
		if ($_POST['onedayam'] != "" ) {
		$sql = $sql." onedayam=:onedayam,";
		$data[":onedayam"] = $_POST["onedayam"];
	}
	if ($_POST['onedaypm'] != "" ) {
		$sql = $sql." onedaypm=:onedaypm,";
		$data[":onedaypm"] = $_POST["onedaypm"];
	}
	if ($_POST['onedayfull'] != "" ) {
		$sql = $sql." onedayfull=:onedayfull,";
		$data[":onedayfull"] = $_POST["onedayfull"];
	}
	if ($_POST['extendedcare'] != "" ) {
		$sql = $sql." extendedcare=:extendedcare,";
		$data[":extendedcare"] = $_POST["extendedcare"];
	}
	if ($_POST['extrashirt'] != "" ) {
		$sql = $sql." extrashirt=:extrashirt,";
		$data[":extrashirt"] = $_POST["extrashirt"];
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