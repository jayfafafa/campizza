<?php
require('fpdf/fpdf.php');

class PDF extends FPDF
{
// Page template setter
function Header()
{
    // Template set
    $this->Image('erfTemplate.png', -5, -5, 215, 310);
	$this->SetRightMargin(0.1);
}
}

include ("fpdf/connection.php"); //setup connection with database


// query database

$res =  $conn->query("SELECT * FROM Parents, Children, ChildrenDynamic WHERE Parents.parentid=Children.parentid AND Children.childid=ChildrenDynamic.childid AND Children.childid=2");
$row = $res->fetch(PDO::FETCH_ASSOC);

$dateSql =  $conn->query("SELECT * FROM YearlySessionWeeks");
$dates = $dateSql->fetch(PDO::FETCH_ASSOC);

unset($conn); //unset connection to database


// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',8);

// Position data locations and populate locations with data from database
$pdf->SetXY(5, 34); 
$pdf->Write(0, $row['firstname'] ." ". $row['lastname']); 
$pdf->SetXY(105, 34); 
$pdf->Write(0, $row['grade']);
$pdf->SetXY(139, 34); 
$pdf->Write(0, $row['school']);

$pdf->SetXY(5, 46); 
$pdf->Write(0, $row['address1']);
$pdf->SetXY(105, 46); 
$pdf->Write(0, $row['dob']);
$pdf->SetXY(155, 46); 
$dob = new DateTime($row['dob']);
$currentDate = new DateTime();
$difference = $currentDate->diff($dob);
$pdf->Write(0, $difference->y); //calculate age via dob - dateobj
$pdf->SetXY(172, 46); 
$pdf->Write(0, $row['gender']);

$pdf->SetXY(18, 54); 
$pdf->Write(0, $row['guardiannamefirst1']. " ".$row['guardiannamelast1']);
$pdf->SetXY(118, 54); 
$pdf->Write(0, $row['guardian1phone1']);
$pdf->SetXY(168, 54); 
$pdf->Write(0, $row['guardian1phone2']);

$pdf->SetXY(18, 63); 
$pdf->Write(0, $row['guardiannamefirst2']." ".$row['guardiannamelast2']);
$pdf->SetXY(118, 63); 
$pdf->Write(0, $row['guardian2phone1']);
$pdf->SetXY(168, 63); 
$pdf->Write(0, $row['guardian2phone2']);

$pdf->SetXY(18, 71); 
$pdf->Write(0, $row['guardianemail1']);

$pdf->SetXY(18, 79); 
$pdf->Write(0, $row['guardianemail2']);


$pdf->SetXY(5, 102); 
$pdf->Write(0, $row['emergencynamefirst1']." ".$row['emergencynamelast1']);
$pdf->SetXY(87, 102); 
$pdf->Write(0, $row['emergencyphone1']);
$pdf->SetXY(157, 102); 
$pdf->Write(0, $row['emergencyrelationship1']);

$pdf->SetXY(5, 111); 
$pdf->Write(0, $row['emergencynamefirst2']." ".$row['emergencynamelast2']);
$pdf->SetXY(87, 111); 
$pdf->Write(0, $row['emergencyphone2']);
$pdf->SetXY(157, 111); 
$pdf->Write(0, $row['emergencyrelationship2']);


$pdf->SetXY(24, 145); 
$pdf->Write(0, $row['doctorname']);
$pdf->SetXY(121, 145); 
$pdf->Write(0, $row['doctorphone']);
$pdf->SetXY(172, 145); 
$pdf->Write(0, $row['insurance']);

$pdf->SetXY(42, 154); 
$pdf->Write(0, $row['illnesses']);
$pdf->SetXY(123, 154); 
$pdf->Write(0, $row['policyholder']);

$pdf->SetXY(5, 166); 
$pdf->Write(0, $row['medication']);
$pdf->SetXY(73, 166); 
$pdf->Write(0, $row['medicationnames']);
$pdf->SetXY(140, 166); 
$pdf->Write(0, $row['allergies']);

$pdf->SetXY(33, 178); 
$pdf->Write(0, $row['activities']);
$pdf->SetXY(73, 178); 
$pdf->Write(0, $row['activitiesnames']);
$pdf->SetXY(140, 178); 
$pdf->Write(0, $row['immunizations']);

$pdf->SetXY(5, 190); 
$pdf->Write(0, $row['medicaltreatments']);
$pdf->SetXY(73, 190); 
$pdf->Write(0, $row['medicaltreatmentsnames']);
$pdf->SetXY(140, 190); 
$pdf->Write(0, $row['tetanusdate']);

$weekstart = substr($dates['week1start'], 5);
$weekend = substr($dates['week1end'], 5);


$reginfo = "Not Registered";
if ($row['week1am'] == 1 && $row['week1pm'] == 1) {
	$reginfo = "8:30am - 4:00pm";
} else if ($row['week1am'] == 1) {
	$reginfo = "8:30am - 12:00pm";
} else if ($row['week1pm'] == 1) {
	$reginfo = 	"12:30pm - 4:00pm";
}

$pdf->SetXY(4, 204); 
$pdf->Write(0, "Week 1: ".$weekstart." - ".$weekend);
$pdf->SetXY(4, 208); 
$pdf->Write(0, $reginfo);

$weekstart = substr($dates['week2start'], 5);
$weekend = substr($dates['week2end'], 5);

$reginfo = "Not Registered";
if ($row['week2am'] == 1 && $row['week2pm'] == 1) {
	$reginfo = "8:30am - 4:00pm";
} else if ($row['week2am'] == 1) {
	$reginfo = "8:30am - 12:00pm";
} else if ($row['week2pm'] == 1) {
	$reginfo = 	"12:30pm - 4:00pm";
}

$pdf->SetXY(48, 204);
$pdf->Write(0, "Week 2: ".$weekstart." - ".$weekend);
$pdf->SetXY(48, 208); 
$pdf->Write(0, $reginfo);

$weekstart = substr($dates['week3start'], 5);
$weekend = substr($dates['week3end'], 5);

$reginfo = "Not Registered";
if ($row['week3am'] == 1 && $row['week3pm'] == 1) {
	$reginfo = "8:30am - 4:00pm";
} else if ($row['week3am'] == 1) {
	$reginfo = "8:30am - 12:00pm";
} else if ($row['week3pm'] == 1) {
	$reginfo = 	"12:30pm - 4:00pm";
}

$pdf->SetXY(90, 204); 
$pdf->Write(0, "Week 3: ".$weekstart." - ".$weekend);
$pdf->SetXY(90, 208); 
$pdf->Write(0, $reginfo);

$weekstart = substr($dates['week4start'], 5);
$weekend = substr($dates['week4end'], 5);

$reginfo = "Not Registered";
if ($row['week4am'] == 1 && $row['week4pm'] == 1) {
	$reginfo = "8:30am - 4:00pm";
} else if ($row['week4am'] == 1) {
	$reginfo = "8:30am - 12:00pm";
} else if ($row['week4pm'] == 1) {
	$reginfo = 	"12:30pm - 4:00pm";
}

$pdf->SetXY(131, 204); 
$pdf->Write(0, "Week 4: ".$weekstart." - ".$weekend);
$pdf->SetXY(131, 208); 
$pdf->Write(0, $reginfo);

$weekstart = substr($dates['week5start'], 5);
$weekend = substr($dates['week5end'], 5);

$reginfo = "Not Registered";
if ($row['week5am'] == 1 && $row['week5pm'] == 1) {
	$reginfo = "8:30am - 4:00pm";
} else if ($row['week5am'] == 1) {
	$reginfo = "8:30am - 12:00pm";
} else if ($row['week5pm'] == 1) {
	$reginfo = 	"12:30pm - 4:00pm";
}

$pdf->SetXY(173, 204); 
$pdf->Write(0, "Week 5: ".$weekstart." - ".$weekend);
$pdf->SetXY(173, 208); 
$pdf->Write(0, $reginfo);

$weekstart = substr($dates['week6start'], 5);
$weekend = substr($dates['week6end'], 5);

$reginfo = "Not Registered";
if ($row['week6am'] == 1 && $row['week6pm'] == 1) {
	$reginfo = "8:30am - 4:00pm";
} else if ($row['week6am'] == 1) {
	$reginfo = "8:30am - 12:00pm";
} else if ($row['week6pm'] == 1) {
	$reginfo = 	"12:30pm - 4:00pm";
}

$pdf->SetXY(4, 216); 
$pdf->Write(0, "Week 6: ".$weekstart." - ".$weekend);
$pdf->SetXY(4, 220); 
$pdf->Write(0, $reginfo);
//$pdf->SetXY(48, 216); 
//$pdf->Write(0, "Enter week2pm data");
//$pdf->SetXY(90, 216); 
//$pdf->Write(0, "Enter week3pm data");
//$pdf->SetXY(131, 216); 
//$pdf->Write(0, "Enter week4pm data");
//$pdf->SetXY(173, 216); 
//$pdf->Write(0, "Enter week5pm");

if ($row['extendedcare'] == 1) {
    $extcare = "Yes";
} 
else {
    $extcare = "No";
}
$pdf->SetXY(65, 228); 
$pdf->Write(0, $extcare);

$pdf->SetXY(21, 236); 
$pdf->Write(0, $row['comments']);

$pdf->Output();


?>