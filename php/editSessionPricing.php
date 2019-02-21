<?php
include('connection.php');

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
			header("location: childdisplay.php");
		}
	else{
		echo 'something went wrong';
	}
		
	}
unset($conn);
}
?>