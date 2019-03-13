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

if($_SESSION['total'] < 0){
	$_SESSION['credit'] = $_SESSION['credit'] + ($_SESSION['total']*-1);
}

//get session week information for Updating table & Dynamically generating week information in page
$sqlWeekInfo = "SELECT * FROM YearlySessionWeeks";
$stmtWeekInfo = $conn->query($sqlWeekInfo);
$weekInfo = $stmtWeekInfo->fetch(PDO::FETCH_ASSOC);

$sqlBalance = "SELECT price, credit FROM ChildrenDynamic WHERE childid=".$_SESSION['childid']." AND registeredyear=".$weekInfo['currentyear'];
$stmtBalance = $conn->query($sqlBalance);
$balance = $stmtBalance->fetch(PDO::FETCH_ASSOC);

$data[':price'] = $balance['price'] + $_SESSION['total'];
$data[':credit'] = $_SESSION['credit'];

if($balance['credit'] > $_SESSION['credit']){
	$data[':price'] = $data[':price'] + ($balance['credit'] - $_SESSION['credit']);
}

	if(isset($_POST['paid']) && $_POST['paid'] == "True") {
		if($stmt = $conn->prepare($sql)){
			if($stmt->execute($data)){
				header("location: childdisplay.php");
			}
			else{
				echo "there was a problemo";
			}
			
		}
	} elseif($_SESSION['total'] <= 0) {
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

$_SESSION['data'] = [];
$_SESSION['query'] = '';
$_SESSION['total'] = 0;
$_SESSION['credit'] = 0;
unset($conn)



?>