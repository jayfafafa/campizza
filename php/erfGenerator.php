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

include ("connection.php"); //setup connection with database


// query database
$childid = $_POST['childid'];
$res =  $conn->query("SELECT * FROM Parents, Children, ChildrenDynamic WHERE Parents.parentid=Children.parentid AND Children.childid=ChildrenDynamic.childid AND Children.childid=$childid");
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
$weekstart = explode("-", $weekstart);
$weekend = explode("-", $weekend);

if ($weekstart[0] == "01") {
	$weekstart[0] = "Jan";
}
else if ($weekstart[0] == "02") {
	$weekstart[0] = "Feb";
}
else if ($weekstart[0] == "03") {
	$weekstart[0] = "Mar";
}
else if ($weekstart[0] == "04") {
	$weekstart[0] = "Apr";
}
else if ($weekstart[0] == "05") {
	$weekstart[0] = "May";
}
else if ($weekstart[0] == "06") {
	$weekstart[0] = "June";
}
else if ($weekstart[0] == "07") {
	$weekstart[0] = "July";
}
else if ($weekstart[0] == "08") {
	$weekstart[0] = "Aug";
}
else if ($weekstart[0] == "09") {
	$weekstart[0] = "Sep";
}
else if ($weekstart[0] == "10") {
	$weekstart[0] = "Oct";
}
else if ($weekstart[0] == "11") {
	$weekstart[0] = "Nov";
}
else if ($weekstart[0] == "12") {
	$weekstart[0] = "Dec";
}

if ($weekstart[1] == "01") {
	$weekstart[1] = "1";
}
else if ($weekstart[1] == "02") {
	$weekstart[1] = "2";
}
else if ($weekstart[1] == "03") {
	$weekstart[1] = "3";
}
else if ($weekstart[1] == "04") {
	$weekstart[1] = "4";
}
else if ($weekstart[1] == "05") {
	$weekstart[1] = "5";
}
else if ($weekstart[1] == "06") {
	$weekstart[1] = "6";
}
else if ($weekstart[1] == "07") {
	$weekstart[1] = "7";
}
else if ($weekstart[1] == "08") {
	$weekstart[1] = "8";
}
else if ($weekstart[1] == "09") {
	$weekstart[1] = "9";
}

if ($weekend[0] == "01") {
	$weekend[0] = "Jan";
}
else if ($weekend[0] == "02") {
	$weekend[0] = "Feb";
}
else if ($weekend[0] == "03") {
	$weekend[0] = "Mar";
}
else if ($weekend[0] == "04") {
	$weekend[0] = "Apr";
}
else if ($weekend[0] == "05") {
	$weekend[0] = "May";
}
else if ($weekend[0] == "06") {
	$weekend[0] = "June";
}
else if ($weekend[0] == "07") {
	$weekend[0] = "July";
}
else if ($weekend[0] == "08") {
	$weekend[0] = "Aug";
}
else if ($weekend[0] == "09") {
	$weekend[0] = "Sep";
}
else if ($weekend[0] == "10") {
	$weekend[0] = "Oct";
}
else if ($weekend[0] == "11") {
	$weekend[0] = "Nov";
}
else if ($weekend[0] == "12") {
	$weekend[0] = "Dec";
}

if ($weekend[1] == "01") {
	$weekend[1] = "1";
}
else if ($weekend[1] == "02") {
	$weekend[1] = "2";
}
else if ($weekend[1] == "03") {
	$weekend[1] = "3";
}
else if ($weekend[1] == "04") {
	$weekend[1] = "4";
}
else if ($weekend[1] == "05") {
	$weekend[1] = "5";
}
else if ($weekend[1] == "06") {
	$weekend[1] = "6";
}
else if ($weekend[1] == "07") {
	$weekend[1] = "7";
}
else if ($weekend[1] == "08") {
	$weekend[1] = "8";
}
else if ($weekend[1] == "09") {
	$weekend[1] = "9";
}

$regdate = "";
$reginfo = "";
if ($row['week1am'] == 1 && $row['week1pm'] == 1) {
	$regdate = "Week 1: ".$weekstart[0]." ".$weekstart[1]." - ".$weekend[0]." ".$weekend[1];
	$reginfo = "8:30am - 4:00pm";
} else if ($row['week1am'] == 1) {
	$regdate = "Week 1: ".$weekstart[0]." ".$weekstart[1]." - ".$weekend[0]." ".$weekend[1];
	$reginfo = "8:30am - 12:00pm";
} else if ($row['week1pm'] == 1) {
	$regdate = "Week 1: ".$weekstart[0]." ".$weekstart[1]." - ".$weekend[0]." ".$weekend[1];
	$reginfo = 	"12:30pm - 4:00pm";
}

$pdf->SetXY(9, 204); 
$pdf->Write(0, $regdate);
$pdf->SetXY(15, 208); 
$pdf->Write(0, $reginfo);

$weekstart = substr($dates['week2start'], 5);
$weekend = substr($dates['week2end'], 5);
$weekstart = explode("-", $weekstart);
$weekend = explode("-", $weekend);

if ($weekstart[0] == "01") {
	$weekstart[0] = "Jan";
}
else if ($weekstart[0] == "02") {
	$weekstart[0] = "Feb";
}
else if ($weekstart[0] == "03") {
	$weekstart[0] = "Mar";
}
else if ($weekstart[0] == "04") {
	$weekstart[0] = "Apr";
}
else if ($weekstart[0] == "05") {
	$weekstart[0] = "May";
}
else if ($weekstart[0] == "06") {
	$weekstart[0] = "June";
}
else if ($weekstart[0] == "07") {
	$weekstart[0] = "July";
}
else if ($weekstart[0] == "08") {
	$weekstart[0] = "Aug";
}
else if ($weekstart[0] == "09") {
	$weekstart[0] = "Sep";
}
else if ($weekstart[0] == "10") {
	$weekstart[0] = "Oct";
}
else if ($weekstart[0] == "11") {
	$weekstart[0] = "Nov";
}
else if ($weekstart[0] == "12") {
	$weekstart[0] = "Dec";
}

if ($weekstart[1] == "01") {
	$weekstart[1] = "1";
}
else if ($weekstart[1] == "02") {
	$weekstart[1] = "2";
}
else if ($weekstart[1] == "03") {
	$weekstart[1] = "3";
}
else if ($weekstart[1] == "04") {
	$weekstart[1] = "4";
}
else if ($weekstart[1] == "05") {
	$weekstart[1] = "5";
}
else if ($weekstart[1] == "06") {
	$weekstart[1] = "6";
}
else if ($weekstart[1] == "07") {
	$weekstart[1] = "7";
}
else if ($weekstart[1] == "08") {
	$weekstart[1] = "8";
}
else if ($weekstart[1] == "09") {
	$weekstart[1] = "9";
}

if ($weekend[0] == "01") {
	$weekend[0] = "Jan";
}
else if ($weekend[0] == "02") {
	$weekend[0] = "Feb";
}
else if ($weekend[0] == "03") {
	$weekend[0] = "Mar";
}
else if ($weekend[0] == "04") {
	$weekend[0] = "Apr";
}
else if ($weekend[0] == "05") {
	$weekend[0] = "May";
}
else if ($weekend[0] == "06") {
	$weekend[0] = "June";
}
else if ($weekend[0] == "07") {
	$weekend[0] = "July";
}
else if ($weekend[0] == "08") {
	$weekend[0] = "Aug";
}
else if ($weekend[0] == "09") {
	$weekend[0] = "Sep";
}
else if ($weekend[0] == "10") {
	$weekend[0] = "Oct";
}
else if ($weekend[0] == "11") {
	$weekend[0] = "Nov";
}
else if ($weekend[0] == "12") {
	$weekend[0] = "Dec";
}

if ($weekend[1] == "01") {
	$weekend[1] = "1";
}
else if ($weekend[1] == "02") {
	$weekend[1] = "2";
}
else if ($weekend[1] == "03") {
	$weekend[1] = "3";
}
else if ($weekend[1] == "04") {
	$weekend[1] = "4";
}
else if ($weekend[1] == "05") {
	$weekend[1] = "5";
}
else if ($weekend[1] == "06") {
	$weekend[1] = "6";
}
else if ($weekend[1] == "07") {
	$weekend[1] = "7";
}
else if ($weekend[1] == "08") {
	$weekend[1] = "8";
}
else if ($weekend[1] == "09") {
	$weekend[1] = "9";
}

$regdate = "";
$reginfo = "";
if ($row['week2am'] == 1 && $row['week2pm'] == 1) {
	$regdate = "Week 2: ".$weekstart[0]." ".$weekstart[1]." - ".$weekend[0]." ".$weekend[1];
	$reginfo = "8:30am - 4:00pm";
} else if ($row['week2am'] == 1) {
	$regdate = "Week 2: ".$weekstart[0]." ".$weekstart[1]." - ".$weekend[0]." ".$weekend[1];
	$reginfo = "8:30am - 12:00pm";
} else if ($row['week2pm'] == 1) {
	$regdate = "Week 2: ".$weekstart[0]." ".$weekstart[1]." - ".$weekend[0]." ".$weekend[1];
	$reginfo = 	"12:30pm - 4:00pm";
}

$pdf->SetXY(60, 204);
$pdf->Write(0, $regdate);
$pdf->SetXY(64, 208); 
$pdf->Write(0, $reginfo);

$weekstart = substr($dates['week3start'], 5);
$weekend = substr($dates['week3end'], 5);
$weekstart = explode("-", $weekstart);
$weekend = explode("-", $weekend);

if ($weekstart[0] == "01") {
	$weekstart[0] = "Jan";
}
else if ($weekstart[0] == "02") {
	$weekstart[0] = "Feb";
}
else if ($weekstart[0] == "03") {
	$weekstart[0] = "Mar";
}
else if ($weekstart[0] == "04") {
	$weekstart[0] = "Apr";
}
else if ($weekstart[0] == "05") {
	$weekstart[0] = "May";
}
else if ($weekstart[0] == "06") {
	$weekstart[0] = "June";
}
else if ($weekstart[0] == "07") {
	$weekstart[0] = "July";
}
else if ($weekstart[0] == "08") {
	$weekstart[0] = "Aug";
}
else if ($weekstart[0] == "09") {
	$weekstart[0] = "Sep";
}
else if ($weekstart[0] == "10") {
	$weekstart[0] = "Oct";
}
else if ($weekstart[0] == "11") {
	$weekstart[0] = "Nov";
}
else if ($weekstart[0] == "12") {
	$weekstart[0] = "Dec";
}

if ($weekstart[1] == "01") {
	$weekstart[1] = "1";
}
else if ($weekstart[1] == "02") {
	$weekstart[1] = "2";
}
else if ($weekstart[1] == "03") {
	$weekstart[1] = "3";
}
else if ($weekstart[1] == "04") {
	$weekstart[1] = "4";
}
else if ($weekstart[1] == "05") {
	$weekstart[1] = "5";
}
else if ($weekstart[1] == "06") {
	$weekstart[1] = "6";
}
else if ($weekstart[1] == "07") {
	$weekstart[1] = "7";
}
else if ($weekstart[1] == "08") {
	$weekstart[1] = "8";
}
else if ($weekstart[1] == "09") {
	$weekstart[1] = "9";
}

if ($weekend[0] == "01") {
	$weekend[0] = "Jan";
}
else if ($weekend[0] == "02") {
	$weekend[0] = "Feb";
}
else if ($weekend[0] == "03") {
	$weekend[0] = "Mar";
}
else if ($weekend[0] == "04") {
	$weekend[0] = "Apr";
}
else if ($weekend[0] == "05") {
	$weekend[0] = "May";
}
else if ($weekend[0] == "06") {
	$weekend[0] = "June";
}
else if ($weekend[0] == "07") {
	$weekend[0] = "July";
}
else if ($weekend[0] == "08") {
	$weekend[0] = "Aug";
}
else if ($weekend[0] == "09") {
	$weekend[0] = "Sep";
}
else if ($weekend[0] == "10") {
	$weekend[0] = "Oct";
}
else if ($weekend[0] == "11") {
	$weekend[0] = "Nov";
}
else if ($weekend[0] == "12") {
	$weekend[0] = "Dec";
}

if ($weekend[1] == "01") {
	$weekend[1] = "1";
}
else if ($weekend[1] == "02") {
	$weekend[1] = "2";
}
else if ($weekend[1] == "03") {
	$weekend[1] = "3";
}
else if ($weekend[1] == "04") {
	$weekend[1] = "4";
}
else if ($weekend[1] == "05") {
	$weekend[1] = "5";
}
else if ($weekend[1] == "06") {
	$weekend[1] = "6";
}
else if ($weekend[1] == "07") {
	$weekend[1] = "7";
}
else if ($weekend[1] == "08") {
	$weekend[1] = "8";
}
else if ($weekend[1] == "09") {
	$weekend[1] = "9";
}

$regdate = "";
$reginfo = "";
if ($row['week3am'] == 1 && $row['week3pm'] == 1) {
	$regdate = "Week 3: ".$weekstart[0]." ".$weekstart[1]." - ".$weekend[0]." ".$weekend[1];
	$reginfo = "8:30am - 4:00pm";
} else if ($row['week3am'] == 1) {
	$regdate = "Week 3: ".$weekstart[0]." ".$weekstart[1]." - ".$weekend[0]." ".$weekend[1];
	$reginfo = "8:30am - 12:00pm";
} else if ($row['week3pm'] == 1) {
	$regdate = "Week 3: ".$weekstart[0]." ".$weekstart[1]." - ".$weekend[0]." ".$weekend[1];
	$reginfo = 	"12:30pm - 4:00pm";
}

$pdf->SetXY(114, 204); 
$pdf->Write(0, $regdate);
$pdf->SetXY(117, 208); 
$pdf->Write(0, $reginfo);

$weekstart = substr($dates['week4start'], 5);
$weekend = substr($dates['week4end'], 5);
$weekstart = explode("-", $weekstart);
$weekend = explode("-", $weekend);

if ($weekstart[0] == "01") {
	$weekstart[0] = "Jan";
}
else if ($weekstart[0] == "02") {
	$weekstart[0] = "Feb";
}
else if ($weekstart[0] == "03") {
	$weekstart[0] = "Mar";
}
else if ($weekstart[0] == "04") {
	$weekstart[0] = "Apr";
}
else if ($weekstart[0] == "05") {
	$weekstart[0] = "May";
}
else if ($weekstart[0] == "06") {
	$weekstart[0] = "June";
}
else if ($weekstart[0] == "07") {
	$weekstart[0] = "July";
}
else if ($weekstart[0] == "08") {
	$weekstart[0] = "Aug";
}
else if ($weekstart[0] == "09") {
	$weekstart[0] = "Sep";
}
else if ($weekstart[0] == "10") {
	$weekstart[0] = "Oct";
}
else if ($weekstart[0] == "11") {
	$weekstart[0] = "Nov";
}
else if ($weekstart[0] == "12") {
	$weekstart[0] = "Dec";
}

if ($weekstart[1] == "01") {
	$weekstart[1] = "1";
}
else if ($weekstart[1] == "02") {
	$weekstart[1] = "2";
}
else if ($weekstart[1] == "03") {
	$weekstart[1] = "3";
}
else if ($weekstart[1] == "04") {
	$weekstart[1] = "4";
}
else if ($weekstart[1] == "05") {
	$weekstart[1] = "5";
}
else if ($weekstart[1] == "06") {
	$weekstart[1] = "6";
}
else if ($weekstart[1] == "07") {
	$weekstart[1] = "7";
}
else if ($weekstart[1] == "08") {
	$weekstart[1] = "8";
}
else if ($weekstart[1] == "09") {
	$weekstart[1] = "9";
}

if ($weekend[0] == "01") {
	$weekend[0] = "Jan";
}
else if ($weekend[0] == "02") {
	$weekend[0] = "Feb";
}
else if ($weekend[0] == "03") {
	$weekend[0] = "Mar";
}
else if ($weekend[0] == "04") {
	$weekend[0] = "Apr";
}
else if ($weekend[0] == "05") {
	$weekend[0] = "May";
}
else if ($weekend[0] == "06") {
	$weekend[0] = "June";
}
else if ($weekend[0] == "07") {
	$weekend[0] = "July";
}
else if ($weekend[0] == "08") {
	$weekend[0] = "Aug";
}
else if ($weekend[0] == "09") {
	$weekend[0] = "Sep";
}
else if ($weekend[0] == "10") {
	$weekend[0] = "Oct";
}
else if ($weekend[0] == "11") {
	$weekend[0] = "Nov";
}
else if ($weekend[0] == "12") {
	$weekend[0] = "Dec";
}

if ($weekend[1] == "01") {
	$weekend[1] = "1";
}
else if ($weekend[1] == "02") {
	$weekend[1] = "2";
}
else if ($weekend[1] == "03") {
	$weekend[1] = "3";
}
else if ($weekend[1] == "04") {
	$weekend[1] = "4";
}
else if ($weekend[1] == "05") {
	$weekend[1] = "5";
}
else if ($weekend[1] == "06") {
	$weekend[1] = "6";
}
else if ($weekend[1] == "07") {
	$weekend[1] = "7";
}
else if ($weekend[1] == "08") {
	$weekend[1] = "8";
}
else if ($weekend[1] == "09") {
	$weekend[1] = "9";
}

$regdate = "";
$reginfo = "";
if ($row['week4am'] == 1 && $row['week4pm'] == 1) {
	$regdate = "Week 4: ".$weekstart[0]." ".$weekstart[1]." - ".$weekend[0]." ".$weekend[1];
	$reginfo = "8:30am - 4:00pm";
} else if ($row['week4am'] == 1) {
	$regdate = "Week 4: ".$weekstart[0]." ".$weekstart[1]." - ".$weekend[0]." ".$weekend[1];
	$reginfo = "8:30am - 12:00pm";
} else if ($row['week4pm'] == 1) {
	$regdate = "Week 4: ".$weekstart[0]." ".$weekstart[1]." - ".$weekend[0]." ".$weekend[1];
	$reginfo = 	"12:30pm - 4:00pm";
}

$pdf->SetXY(166, 204); 
$pdf->Write(0, $regdate);
$pdf->SetXY(170, 208); 
$pdf->Write(0, $reginfo);

$weekstart = substr($dates['week5start'], 5);
$weekend = substr($dates['week5end'], 5);
$weekstart = explode("-", $weekstart);
$weekend = explode("-", $weekend);

if ($weekstart[0] == "01") {
	$weekstart[0] = "Jan";
}
else if ($weekstart[0] == "02") {
	$weekstart[0] = "Feb";
}
else if ($weekstart[0] == "03") {
	$weekstart[0] = "Mar";
}
else if ($weekstart[0] == "04") {
	$weekstart[0] = "Apr";
}
else if ($weekstart[0] == "05") {
	$weekstart[0] = "May";
}
else if ($weekstart[0] == "06") {
	$weekstart[0] = "June";
}
else if ($weekstart[0] == "07") {
	$weekstart[0] = "July";
}
else if ($weekstart[0] == "08") {
	$weekstart[0] = "Aug";
}
else if ($weekstart[0] == "09") {
	$weekstart[0] = "Sep";
}
else if ($weekstart[0] == "10") {
	$weekstart[0] = "Oct";
}
else if ($weekstart[0] == "11") {
	$weekstart[0] = "Nov";
}
else if ($weekstart[0] == "12") {
	$weekstart[0] = "Dec";
}

if ($weekstart[1] == "01") {
	$weekstart[1] = "1";
}
else if ($weekstart[1] == "02") {
	$weekstart[1] = "2";
}
else if ($weekstart[1] == "03") {
	$weekstart[1] = "3";
}
else if ($weekstart[1] == "04") {
	$weekstart[1] = "4";
}
else if ($weekstart[1] == "05") {
	$weekstart[1] = "5";
}
else if ($weekstart[1] == "06") {
	$weekstart[1] = "6";
}
else if ($weekstart[1] == "07") {
	$weekstart[1] = "7";
}
else if ($weekstart[1] == "08") {
	$weekstart[1] = "8";
}
else if ($weekstart[1] == "09") {
	$weekstart[1] = "9";
}

if ($weekend[0] == "01") {
	$weekend[0] = "Jan";
}
else if ($weekend[0] == "02") {
	$weekend[0] = "Feb";
}
else if ($weekend[0] == "03") {
	$weekend[0] = "Mar";
}
else if ($weekend[0] == "04") {
	$weekend[0] = "Apr";
}
else if ($weekend[0] == "05") {
	$weekend[0] = "May";
}
else if ($weekend[0] == "06") {
	$weekend[0] = "June";
}
else if ($weekend[0] == "07") {
	$weekend[0] = "July";
}
else if ($weekend[0] == "08") {
	$weekend[0] = "Aug";
}
else if ($weekend[0] == "09") {
	$weekend[0] = "Sep";
}
else if ($weekend[0] == "10") {
	$weekend[0] = "Oct";
}
else if ($weekend[0] == "11") {
	$weekend[0] = "Nov";
}
else if ($weekend[0] == "12") {
	$weekend[0] = "Dec";
}

if ($weekend[1] == "01") {
	$weekend[1] = "1";
}
else if ($weekend[1] == "02") {
	$weekend[1] = "2";
}
else if ($weekend[1] == "03") {
	$weekend[1] = "3";
}
else if ($weekend[1] == "04") {
	$weekend[1] = "4";
}
else if ($weekend[1] == "05") {
	$weekend[1] = "5";
}
else if ($weekend[1] == "06") {
	$weekend[1] = "6";
}
else if ($weekend[1] == "07") {
	$weekend[1] = "7";
}
else if ($weekend[1] == "08") {
	$weekend[1] = "8";
}
else if ($weekend[1] == "09") {
	$weekend[1] = "9";
}

$regdate = "";
$reginfo = "";
if ($row['week5am'] == 1 && $row['week5pm'] == 1) {
	$regdate = "Week 5: ".$weekstart[0]." ".$weekstart[1]." - ".$weekend[0]." ".$weekend[1];
	$reginfo = "8:30am - 4:00pm";
} else if ($row['week5am'] == 1) {
	$regdate = "Week 5: ".$weekstart[0]." ".$weekstart[1]." - ".$weekend[0]." ".$weekend[1];
	$reginfo = "8:30am - 12:00pm";
} else if ($row['week5pm'] == 1) {
	$regdate = "Week 5: ".$weekstart[0]." ".$weekstart[1]." - ".$weekend[0]." ".$weekend[1];
	$reginfo = 	"12:30pm - 4:00pm";
}

$pdf->SetXY(9, 215); 
$pdf->Write(0, $regdate);
$pdf->SetXY(15, 219); 
$pdf->Write(0, $reginfo);

$weekstart = substr($dates['week6start'], 5);
$weekend = substr($dates['week6end'], 5);
$weekstart = explode("-", $weekstart);
$weekend = explode("-", $weekend);

if ($weekstart[0] == "01") {
	$weekstart[0] = "Jan";
}
else if ($weekstart[0] == "02") {
	$weekstart[0] = "Feb";
}
else if ($weekstart[0] == "03") {
	$weekstart[0] = "Mar";
}
else if ($weekstart[0] == "04") {
	$weekstart[0] = "Apr";
}
else if ($weekstart[0] == "05") {
	$weekstart[0] = "May";
}
else if ($weekstart[0] == "06") {
	$weekstart[0] = "June";
}
else if ($weekstart[0] == "07") {
	$weekstart[0] = "July";
}
else if ($weekstart[0] == "08") {
	$weekstart[0] = "Aug";
}
else if ($weekstart[0] == "09") {
	$weekstart[0] = "Sep";
}
else if ($weekstart[0] == "10") {
	$weekstart[0] = "Oct";
}
else if ($weekstart[0] == "11") {
	$weekstart[0] = "Nov";
}
else if ($weekstart[0] == "12") {
	$weekstart[0] = "Dec";
}

if ($weekstart[1] == "01") {
	$weekstart[1] = "1";
}
else if ($weekstart[1] == "02") {
	$weekstart[1] = "2";
}
else if ($weekstart[1] == "03") {
	$weekstart[1] = "3";
}
else if ($weekstart[1] == "04") {
	$weekstart[1] = "4";
}
else if ($weekstart[1] == "05") {
	$weekstart[1] = "5";
}
else if ($weekstart[1] == "06") {
	$weekstart[1] = "6";
}
else if ($weekstart[1] == "07") {
	$weekstart[1] = "7";
}
else if ($weekstart[1] == "08") {
	$weekstart[1] = "8";
}
else if ($weekstart[1] == "09") {
	$weekstart[1] = "9";
}

if ($weekend[0] == "01") {
	$weekend[0] = "Jan";
}
else if ($weekend[0] == "02") {
	$weekend[0] = "Feb";
}
else if ($weekend[0] == "03") {
	$weekend[0] = "Mar";
}
else if ($weekend[0] == "04") {
	$weekend[0] = "Apr";
}
else if ($weekend[0] == "05") {
	$weekend[0] = "May";
}
else if ($weekend[0] == "06") {
	$weekend[0] = "June";
}
else if ($weekend[0] == "07") {
	$weekend[0] = "July";
}
else if ($weekend[0] == "08") {
	$weekend[0] = "Aug";
}
else if ($weekend[0] == "09") {
	$weekend[0] = "Sep";
}
else if ($weekend[0] == "10") {
	$weekend[0] = "Oct";
}
else if ($weekend[0] == "11") {
	$weekend[0] = "Nov";
}
else if ($weekend[0] == "12") {
	$weekend[0] = "Dec";
}

if ($weekend[1] == "01") {
	$weekend[1] = "1";
}
else if ($weekend[1] == "02") {
	$weekend[1] = "2";
}
else if ($weekend[1] == "03") {
	$weekend[1] = "3";
}
else if ($weekend[1] == "04") {
	$weekend[1] = "4";
}
else if ($weekend[1] == "05") {
	$weekend[1] = "5";
}
else if ($weekend[1] == "06") {
	$weekend[1] = "6";
}
else if ($weekend[1] == "07") {
	$weekend[1] = "7";
}
else if ($weekend[1] == "08") {
	$weekend[1] = "8";
}
else if ($weekend[1] == "09") {
	$weekend[1] = "9";
}

$regdate = "";
$reginfo = "";
if ($row['week6am'] == 1 && $row['week6pm'] == 1) {
	$regdate = "Week 6: ".$weekstart[0]." ".$weekstart[1]." - ".$weekend[0]." ".$weekend[1];
	$reginfo = "8:30am - 4:00pm";
} else if ($row['week6am'] == 1) {
	$regdate = "Week 6: ".$weekstart[0]." ".$weekstart[1]." - ".$weekend[0]." ".$weekend[1];
	$reginfo = "8:30am - 12:00pm";
} else if ($row['week6pm'] == 1) {
	$regdate = "Week 6: ".$weekstart[0]." ".$weekstart[1]." - ".$weekend[0]." ".$weekend[1];
	$reginfo = 	"12:30pm - 4:00pm";
}

$pdf->SetXY(60, 215); 
$pdf->Write(0, $regdate);
$pdf->SetXY(64, 219); 
$pdf->Write(0, $reginfo);

$weekstart = substr($dates['week7start'], 5);
$weekend = substr($dates['week7end'], 5);
$weekstart = explode("-", $weekstart);
$weekend = explode("-", $weekend);

if ($weekstart[0] == "01") {
	$weekstart[0] = "Jan";
}
else if ($weekstart[0] == "02") {
	$weekstart[0] = "Feb";
}
else if ($weekstart[0] == "03") {
	$weekstart[0] = "Mar";
}
else if ($weekstart[0] == "04") {
	$weekstart[0] = "Apr";
}
else if ($weekstart[0] == "05") {
	$weekstart[0] = "May";
}
else if ($weekstart[0] == "06") {
	$weekstart[0] = "June";
}
else if ($weekstart[0] == "07") {
	$weekstart[0] = "July";
}
else if ($weekstart[0] == "08") {
	$weekstart[0] = "Aug";
}
else if ($weekstart[0] == "09") {
	$weekstart[0] = "Sep";
}
else if ($weekstart[0] == "10") {
	$weekstart[0] = "Oct";
}
else if ($weekstart[0] == "11") {
	$weekstart[0] = "Nov";
}
else if ($weekstart[0] == "12") {
	$weekstart[0] = "Dec";
}

if ($weekstart[1] == "01") {
	$weekstart[1] = "1";
}
else if ($weekstart[1] == "02") {
	$weekstart[1] = "2";
}
else if ($weekstart[1] == "03") {
	$weekstart[1] = "3";
}
else if ($weekstart[1] == "04") {
	$weekstart[1] = "4";
}
else if ($weekstart[1] == "05") {
	$weekstart[1] = "5";
}
else if ($weekstart[1] == "06") {
	$weekstart[1] = "6";
}
else if ($weekstart[1] == "07") {
	$weekstart[1] = "7";
}
else if ($weekstart[1] == "08") {
	$weekstart[1] = "8";
}
else if ($weekstart[1] == "09") {
	$weekstart[1] = "9";
}

if ($weekend[0] == "01") {
	$weekend[0] = "Jan";
}
else if ($weekend[0] == "02") {
	$weekend[0] = "Feb";
}
else if ($weekend[0] == "03") {
	$weekend[0] = "Mar";
}
else if ($weekend[0] == "04") {
	$weekend[0] = "Apr";
}
else if ($weekend[0] == "05") {
	$weekend[0] = "May";
}
else if ($weekend[0] == "06") {
	$weekend[0] = "June";
}
else if ($weekend[0] == "07") {
	$weekend[0] = "July";
}
else if ($weekend[0] == "08") {
	$weekend[0] = "Aug";
}
else if ($weekend[0] == "09") {
	$weekend[0] = "Sep";
}
else if ($weekend[0] == "10") {
	$weekend[0] = "Oct";
}
else if ($weekend[0] == "11") {
	$weekend[0] = "Nov";
}
else if ($weekend[0] == "12") {
	$weekend[0] = "Dec";
}

if ($weekend[1] == "01") {
	$weekend[1] = "1";
}
else if ($weekend[1] == "02") {
	$weekend[1] = "2";
}
else if ($weekend[1] == "03") {
	$weekend[1] = "3";
}
else if ($weekend[1] == "04") {
	$weekend[1] = "4";
}
else if ($weekend[1] == "05") {
	$weekend[1] = "5";
}
else if ($weekend[1] == "06") {
	$weekend[1] = "6";
}
else if ($weekend[1] == "07") {
	$weekend[1] = "7";
}
else if ($weekend[1] == "08") {
	$weekend[1] = "8";
}
else if ($weekend[1] == "09") {
	$weekend[1] = "9";
}

$regdate = "";
$reginfo = "";
if ($row['week7am'] == 1 && $row['week7pm'] == 1) {
	$regdate = "Week 7: ".$weekstart[0]." ".$weekstart[1]." - ".$weekend[0]." ".$weekend[1];
	$reginfo = "8:30am - 4:00pm";
} else if ($row['week7am'] == 1) {
	$regdate = "Week 7: ".$weekstart[0]." ".$weekstart[1]." - ".$weekend[0]." ".$weekend[1];
	$reginfo = "8:30am - 12:00pm";
} else if ($row['week7pm'] == 1) {
	$regdate = "Week 7: ".$weekstart[0]." ".$weekstart[1]." - ".$weekend[0]." ".$weekend[1];
	$reginfo = 	"12:30pm - 4:00pm";
}

$pdf->SetXY(114, 215); 
$pdf->Write(0, $regdate);
$pdf->SetXY(117, 219); 
$pdf->Write(0, $reginfo);

$weekstart = substr($dates['week8start'], 5);
$weekend = substr($dates['week8end'], 5);
$weekstart = explode("-", $weekstart);
$weekend = explode("-", $weekend);

if ($weekstart[0] == "01") {
	$weekstart[0] = "Jan";
}
else if ($weekstart[0] == "02") {
	$weekstart[0] = "Feb";
}
else if ($weekstart[0] == "03") {
	$weekstart[0] = "Mar";
}
else if ($weekstart[0] == "04") {
	$weekstart[0] = "Apr";
}
else if ($weekstart[0] == "05") {
	$weekstart[0] = "May";
}
else if ($weekstart[0] == "06") {
	$weekstart[0] = "June";
}
else if ($weekstart[0] == "07") {
	$weekstart[0] = "July";
}
else if ($weekstart[0] == "08") {
	$weekstart[0] = "Aug";
}
else if ($weekstart[0] == "09") {
	$weekstart[0] = "Sep";
}
else if ($weekstart[0] == "10") {
	$weekstart[0] = "Oct";
}
else if ($weekstart[0] == "11") {
	$weekstart[0] = "Nov";
}
else if ($weekstart[0] == "12") {
	$weekstart[0] = "Dec";
}

if ($weekstart[1] == "01") {
	$weekstart[1] = "1";
}
else if ($weekstart[1] == "02") {
	$weekstart[1] = "2";
}
else if ($weekstart[1] == "03") {
	$weekstart[1] = "3";
}
else if ($weekstart[1] == "04") {
	$weekstart[1] = "4";
}
else if ($weekstart[1] == "05") {
	$weekstart[1] = "5";
}
else if ($weekstart[1] == "06") {
	$weekstart[1] = "6";
}
else if ($weekstart[1] == "07") {
	$weekstart[1] = "7";
}
else if ($weekstart[1] == "08") {
	$weekstart[1] = "8";
}
else if ($weekstart[1] == "09") {
	$weekstart[1] = "9";
}

if ($weekend[0] == "01") {
	$weekend[0] = "Jan";
}
else if ($weekend[0] == "02") {
	$weekend[0] = "Feb";
}
else if ($weekend[0] == "03") {
	$weekend[0] = "Mar";
}
else if ($weekend[0] == "04") {
	$weekend[0] = "Apr";
}
else if ($weekend[0] == "05") {
	$weekend[0] = "May";
}
else if ($weekend[0] == "06") {
	$weekend[0] = "June";
}
else if ($weekend[0] == "07") {
	$weekend[0] = "July";
}
else if ($weekend[0] == "08") {
	$weekend[0] = "Aug";
}
else if ($weekend[0] == "09") {
	$weekend[0] = "Sep";
}
else if ($weekend[0] == "10") {
	$weekend[0] = "Oct";
}
else if ($weekend[0] == "11") {
	$weekend[0] = "Nov";
}
else if ($weekend[0] == "12") {
	$weekend[0] = "Dec";
}

if ($weekend[1] == "01") {
	$weekend[1] = "1";
}
else if ($weekend[1] == "02") {
	$weekend[1] = "2";
}
else if ($weekend[1] == "03") {
	$weekend[1] = "3";
}
else if ($weekend[1] == "04") {
	$weekend[1] = "4";
}
else if ($weekend[1] == "05") {
	$weekend[1] = "5";
}
else if ($weekend[1] == "06") {
	$weekend[1] = "6";
}
else if ($weekend[1] == "07") {
	$weekend[1] = "7";
}
else if ($weekend[1] == "08") {
	$weekend[1] = "8";
}
else if ($weekend[1] == "09") {
	$weekend[1] = "9";
}

$regdate = "";
$reginfo = "";
if ($row['week8am'] == 1 && $row['week8pm'] == 1) {
	$regdate = "Week 8: ".$weekstart[0]." ".$weekstart[1]." - ".$weekend[0]." ".$weekend[1];
	$reginfo = "8:30am - 4:00pm";
} else if ($row['week8am'] == 1) {
	$regdate = "Week 8: ".$weekstart[0]." ".$weekstart[1]." - ".$weekend[0]." ".$weekend[1];
	$reginfo = "8:30am - 12:00pm";
} else if ($row['week8pm'] == 1) {
	$regdate = "Week 8: ".$weekstart[0]." ".$weekstart[1]." - ".$weekend[0]." ".$weekend[1];
	$reginfo = 	"12:30pm - 4:00pm";
}

$pdf->SetXY(166, 215); 
$pdf->Write(0, $regdate);
$pdf->SetXY(170, 219); 
$pdf->Write(0, $reginfo);

if ($row['extendedcare'] == 1) {
    $extcare = "Yes";
} 
else {
    $extcare = "No";
}
$pdf->SetXY(65, 229); 
$pdf->Write(0, $extcare);

$pdf->SetXY(21, 237); 
$pdf->Write(0, $row['comments']);

$pdf->Output();


?>