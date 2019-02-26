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
	$sql = "UPDATE YearlySessionPricing SET oneweekamearly=:oneweekamearly, oneweekpmearly=:oneweekpmearly, oneweekfullearly=:oneweekfullearly, "
	."oneweekamlate=:oneweekamlate, oneweekpmlate=:oneweekpmlate, oneweekfulllate=:oneweekfulllate, "
	."holidayweekamlate=:holidayweekamlate, holidayweekpmlate=:holidayweekpmlate, holidayweekfulllate=:holidayweekfulllate, "
	."holidayweekamearly=:holidayweekamearly, holidayweekpmearly=:holidayweekpmearly, holidayweekfullearly=:holidayweekfullearly, "
	."onedayam=:onedayam, onedaypm=:onedaypm, onedayfull=:onedayfull, extendedcare=:extendedcare, extrashirt=:extrashirt";
		
	//Populate data array
	$data = [
		":oneweekamearly" => $_POST["oneweekamearly"],
		":oneweekpmearly" => $_POST["oneweekpmearly"],
		":oneweekfullearly" => $_POST["oneweekfullearly"],
		":oneweekamlate" => $_POST["oneweekamlate"],
		":oneweekpmlate" => $_POST["oneweekpmlate"],
		":oneweekfulllate" => $_POST["oneweekfulllate"],
		":holidayweekamearly" => $_POST["holidayweekamearly"],
		":holidayweekpmearly" => $_POST["holidayweekpmearly"],
		":holidayweekfullearly" => $_POST["holidayweekfullearly"],
		":holidayweekamlate" => $_POST["holidayweekamlate"],
		":holidayweekpmlate" => $_POST["holidayweekpmlate"],
		":holidayweekfulllate" => $_POST["holidayweekfulllate"],
		":onedayam" => $_POST["onedayam"],
		":onedaypm" => $_POST["onedaypm"],
		":onedayfull" => $_POST["onedayfull"],
		":extendedcare" => $_POST["extendedcare"],
		":extrashirt" => $_POST["extrashirt"]
		
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