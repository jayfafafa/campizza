<?php
include('connection.php');

if($_SERVER["REQUEST_METHOD"] == "POST") {
	$sql = "UPDATE Children SET firstname=:firstname, lastname=:lastname,"
		."gender=:gender, dob=:dob, doctorname=:doctorname, "
		."doctorphone=:doctorphone, insurance=:insurance, policyholder=:policyholder, illnesses=:illnesses, "
		."allergies=:allergies, medication=:medication, medicationnames=:medicationnames, activities=:activities, "
		."activitiesnames=:activitiesnames, medicaltreatments=:medicaltreatments, "
		."medicaltreatmentsnames=:medicaltreatmentsnames, immunizations=:immunizations, "
		."tetanusdate=:tetanusdate, comments=:comments WHERE childid=".$_POST['childid'];
		
		$data = [
			':firstname' => $_POST['firstname'],
			':lastname' => $_POST['lastname'],
			':gender' => $_POST['gender'],
			':dob' => $_POST['dob'],
			':doctorname' => $_POST['doctorname'],
			':doctorphone' => $_POST['doctorphone'],
			':insurance' => $_POST['insurance'],
			':policyholder' => $_POST['policyholder'],
			':illnesses' => $_POST['illnesses'],
			':allergies' => $_POST['allergies'],
			':medication' => $_POST['medication'],
			':medicationnames' => $_POST['medicationnames'],
			':activities' => $_POST['activities'],
			':activitiesnames' => $_POST['activitiesnames'],
			':medicaltreatments' => $_POST['medicaltreatments'],
			':medicaltreatmentsnames' => $_POST['medicaltreatmentsnames'],
			':immunizations' => $_POST['immunizations'],
			':tetanusdate' => $_POST['tetanusdate'],
			':comments' => $_POST['comments']
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