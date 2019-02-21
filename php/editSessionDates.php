<?php
include('connection.php');

$stmtAmount = $conn->query("SELECT * FROM YearlySessionWeeks");
$campInfo = $stmtAmount->fetch(PDO::FETCH_ASSOC);
$activeweeks = $campInfo["activeweeks"];

if($_SERVER["REQUEST_METHOD"] == "POST") {

	//Create query according to active weeks
	$sql = "UPDATE YearlySessionWeeks SET ";

	for($x = 1; $x <= $activeweeks; $x++){
		$sql = $sql."week".$x."start=:week".$x."start, week".$x."end=:week".$x."end, ";
	}
		
	$sql = $sql."activeweeks=:activeweeks, currentyear=:currentyear, holidayweek=:holidayweek";
		
	//Populate data array according to amount of active weeks	
	$data = [];

	for($x = 1; $x <= $activeweeks; $x++){
		array_push($data, ":week".$x."start" => $_POST["week".$x."start"], ":week".$x."end" => $_POST["week".$x."end"]);
	}

	array_push($data, ":activeweeks"=>$_POST["activeweeks"], ":currentyear"=>$_POST["currentyear"], ":holidayweek"=>$_POST["holidayweek"]);
	
		
	if($stmt = $conn->prepare($sql)){
		if($stmt->execute($data)){
			header("location: childdisplay.php");
		}
	else{
		echo 'something went wrong';
	}
		
	}
unset($conn);
}
?>