<?php
include('connection.php');

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
			header("location: childdisplay.php");
		}
	else{
		echo 'something went wrong';
	}
		
	}
unset($conn);
}
?>