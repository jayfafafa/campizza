<?php
// Initialize the session
session_start();

include('connection.php');

$result = $conn->query("SELECT auth FROM ParentsLogin WHERE parentid=".$_SESSION['id']);
$row = $result->fetch(PDO::FETCH_ASSOC);
if($row['auth'] != 1){
    header('location: dashboard.php');
}
 
// Check if the user is logged in, if not then redirect him to login page
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

$_SESSION['attributes'] = array(
	'childid' => 'Child ID',
	'firstname' => 'First Name',
	'lastname' => 'Last Name',
	'gender' => 'Gender',
	'dob' => 'Date of Birth',
	'school' => 'School',
	'grade' => 'Grade',
	'shirtsize' => 'Shirt Size',
	'numshirts' => '# of Shirts',
	'week1am' => 'Week1AM',
	'week1pm' => 'Week1PM',
	'week2am' => 'Week2AM',
	'week2pm' => 'Week2PM',
	'week3am' => 'Week3AM',
	'week3pm' => 'Week3PM',
	'week4am' => 'Week4AM',
	'week4pm' => 'Week4PM',
	'week5am' => 'Week5AM',
	'week5pm' => 'Week5PM',
	'week6am' => 'Week6AM',
	'week6pm' => 'Week6PM',
	'week7am' => 'Week7AM',
	'week7pm' => 'Week7PM',
	'week8am' => 'Week8AM',
	'week8pm' => 'Week8PM',
	'extendedcare' => 'Extended Care',
	'doctorname' => 'Doctor Name',
	'doctorphone' => 'Doctor Phone',
	'insurance' => 'Insurance',
	'policyholder' => 'Policy Holder',
	'illnesses' => 'Illnesses',
	'allergies' => 'Allergies and/or Dietary Restrictions',
	'medication' => 'Medication Names',
	'activities' => 'Activities',
	'activitiesnames' => 'Activites Names',
	'medicaltreatments' => 'Medical Treatments',
	'medicaltreatmentsnames' => 'Medical Treatments Names',
	'immunizations' => 'Immunizations',
	'tetanusdate' => 'Tetanus',
	'comments' => 'Comments',
	'parentid' => 'Parent ID',
	'regtime' => 'Registration Time',
	'location' => 'Location',
	'guardiannamefirst1' => 'Guardian1 First Name',
	'guardiannamelast1' => 'Guardian1 Last Name',
	'guardiannamefirst2' => 'Guardian2 First Name',
	'guardiannamelast2' => 'Guardian2 Last Name',
	'address1' => 'Address1',
	'address2' => 'Address2',
	'country' => 'Country',
	'city' => 'City',
	'state' => 'State',
	'zippostalcode' => 'Zip/Postal Code',
	'guardianemail1' => 'Guardian Email1',
	'guardianemail2' => 'Guardian Email2',
	'emergencynamefirst1' => 'Emergency First Name 1',
	'emergencynamelast1' => 'Emergency Last Name 1',
	'emergencyrelationship1' => 'Emergency Relationship 1',
	'emergencyphone1' => 'Emergency Phone 1',
	'emergencyauthorized1' => 'Emergency Authorized 1',
	'emergencynamefirst2' => 'Emergency First Name 2',
	'emergencynamelast2' => 'Emergency Last Name 2',
	'emergencyrelationship2' => 'Emergency Relationship 2',
	'emergencyphone2' => 'Emergency Phone 2',
	'emergencyauthorized2' => 'Emergency Authorized 2',
	'price' => 'Amount Paid',
	'credit' => 'Credit'
	);

?>

<!doctype html>
<html lang="en">

<head>
	<title>Camp Izza | Summer Day Camp | Irvine, CA</title>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fredericka+the+Great">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
	<link rel="stylesheet" href="registrationstyle.css">
	<link rel="stylesheet" href="registerparent.css">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

</head>

<script language="JavaScript">
function toggle(source) {
  checkboxes = document.getElementsByClassName("form-check-input");
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
</script>

<body>

	<nav class="navbar navbar-expand-sm navbar-light bg-white">
		<div class="container">
			<a class="navbar-brand" href="http://campizza.com">
				<img src="https://static.wixstatic.com/media/46af7c_6c86140c4f8e479e95cb12c1bddfa5f1~mv2.gif" width="70" height="44" alt="">
			</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
				<div class="navbar-nav mx-auto">
					<a class="nav-item nav-link" href="http://campizza.com">Home</a>
					<a class="nav-item nav-link" href="http://campizza.com/calendar">Activities</a>
					<a class="nav-item nav-link" href="http://campizza.com/camp-fees">Fees</a>
					<a class="nav-item nav-link" href="http://campizza.com/contact">Contact</a>
				</div>
			</div>
		
		</div>
	</nav>

	<form action="roster.php" method="post">
		<div class="container" style = "background: white; margin-top: 20px;">

			<h2>Choose the columns you want to view</h2>
			<div class="row margin-data">
				<div class="col">

				<input type="checkbox" onClick="toggle(this)" /> Toggle All<br/>
				<br>
				
					<div class="row">
					  <div class="col-4">
						<div class="list-group" id="list-tab" role="tablist">
						  <a class="list-group-item list-group-item-action active" id="list-personal-list" data-toggle="list" href="#list-personal" role="tab" aria-controls="personal">Personal Details</a>
						  <a class="list-group-item list-group-item-action" id="list-weeks-list" data-toggle="list" href="#list-weeks" role="tab" aria-controls="weeks">Weeks</a>
						  <a class="list-group-item list-group-item-action" id="list-medical-list" data-toggle="list" href="#list-medical" role="tab" aria-controls="medical">Medical Info</a>
						  <a class="list-group-item list-group-item-action" id="list-parentguard-list" data-toggle="list" href="#list-parentguard" role="tab" aria-controls="parentguard">Parent/Guardian</a>
						  <a class="list-group-item list-group-item-action" id="list-emergency-list" data-toggle="list" href="#list-emergency" role="tab" aria-controls="emergency">Emergency</a>
						  <a class="list-group-item list-group-item-action" id="list-payments-list" data-toggle="list" href="#list-payments" role="tab" aria-controls="payments">Payments</a>
						</div>
					  </div>
					  <div class="col-8">
						<div class="tab-content" id="nav-tabContent">
						
							<!-- Personal Details Tab -->
							<div class="tab-pane fade show active" id="list-personal" role="tabpanel" aria-labelledby="list-personal-list">
							<?php

							foreach (array_slice($_SESSION['attributes'], 0, 9) as $k => $v){
								echo '<div class="form-check">';
								echo '<input type="checkbox" class="form-check-input" id="attribute" name="'.$k.'" value=1>'.$v.'<br>';
								echo '</div>';
							}

							?>
							</div>
						  
							<!-- Weeks Tab -->
							<div class="tab-pane fade" id="list-weeks" role="tabpanel" aria-labelledby="list-weeks-list">
							<?php

							foreach (array_slice($_SESSION['attributes'], 9, 17) as $k => $v){
								echo '<div class="form-check">';
								echo '<input type="checkbox" class="form-check-input" id="attribute" name="'.$k.'" value=1>'.$v.'<br>';
								echo '</div>';
							}

							?>
							</div>
							
							<!-- Medical Info Tab -->
							<div class="tab-pane fade" id="list-medical" role="tabpanel" aria-labelledby="list-medical-list">
							<?php

							foreach (array_slice($_SESSION['attributes'], 26, 14) as $k => $v){
								echo '<div class="form-check">';
								echo '<input type="checkbox" class="form-check-input" id="attribute" name="'.$k.'" value=1>'.$v.'<br>';
								echo '</div>';
							}

							?>
							</div>
							
							<!-- Parent/Guardian Tab -->
							<div class="tab-pane fade" id="list-parentguard" role="tabpanel" aria-labelledby="list-parentguard-list">
							<?php

							foreach (array_slice($_SESSION['attributes'], 40, 15) as $k => $v){
								echo '<div class="form-check">';
								echo '<input type="checkbox" class="form-check-input" id="attribute" name="'.$k.'" value=1>'.$v.'<br>';
								echo '</div>';
							}

							?>
							</div>
							
							<!-- Emergency Tab -->
							<div class="tab-pane fade" id="list-emergency" role="tabpanel" aria-labelledby="list-emergency-list">
							<?php

							foreach (array_slice($_SESSION['attributes'], 55, 10) as $k => $v){
								echo '<div class="form-check">';
								echo '<input type="checkbox" class="form-check-input" id="attribute" name="'.$k.'" value=1>'.$v.'<br>';
								echo '</div>';
							}

							?>
							</div>
							
							<!-- Payments Tab -->
							<div class="tab-pane fade" id="list-payments" role="tabpanel" aria-labelledby="list-payments-list">
							<?php

							foreach (array_slice($_SESSION['attributes'], 65, 2) as $k => $v){
								echo '<div class="form-check">';
								echo '<input type="checkbox" class="form-check-input" id="attribute" name="'.$k.'" value=1>'.$v.'<br>';
								echo '</div>';
							}

							?>
							</div>
						  
						</div>
					  </div>
					</div>
				</div>
			</div>
			<br>
			<input type="submit" value="Submit">
			<br>

		</div>
	</form>



</body>
</html>