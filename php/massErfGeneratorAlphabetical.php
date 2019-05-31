<?php
require("connection.php"); //setup connection with database
require("imageScaler.php");


// query database
$yearlysql = $conn->query("SELECT * FROM YearlySessionWeeks");
$yearlyInfoRes = $yearlysql->fetch(PDO::FETCH_ASSOC); 
$currYear = $yearlyInfoRes["currentyear"];


$res = $conn->query("SELECT * FROM Parents, Children, ChildrenDynamic WHERE Parents.parentid=Children.parentid AND Children.childid=ChildrenDynamic.childid and ChildrenDynamic.registeredyear=$currYear ORDER BY lastname ASC");
$users = $res->fetchAll(PDO::FETCH_ASSOC);

$dateSql = $conn->query("SELECT * FROM YearlySessionWeeks");
$dates = $dateSql->fetch(PDO::FETCH_ASSOC);

unset($conn); //unset connection to database
$pdf = new PDF();

foreach ($users as $row) {
	
		if($row['price'] > 0) {
		
		// Instanciation of inherited class
		$pdf->AddPage("P");
		$pdf->centreImage("erfTemplate.png");
		$pdf->AddFont("Questrial", "", "QuestrialRegular.php"); // Add custom font - Questrial
		$pdf->SetFont('Questrial','',8);

		// Position data locations and populate locations with data from database
		$pdf->SetXY(16, 54); 
		$pdf->Write(0, $row['firstname'] ." ". $row['lastname']); 
		$pdf->SetXY(109, 54); 
		$pdf->Write(0, $row['grade']);
		$pdf->SetXY(139, 54); 
		$pdf->Write(0, $row['school']);

		$pdf->SetXY(16, 64); 
		$pdf->Write(0, $row['address1']);
		$ogdob = $row['dob'];
		$splitdob = explode("-", $ogdob);
		$newdob = $splitdob[1]."/".$splitdob[2]."/".$splitdob[0];
		$pdf->SetXY(109, 64);
		$pdf->Write(0, $newdob);
		$dob = new DateTime($row['dob']);
		$currentDate = new DateTime();
		$difference = $currentDate->diff($dob);
		$pdf->SetXY(154, 64);
		$pdf->Write(0, $difference->y); //calculate age via dob - dateobj
		$pdf->SetXY(169, 64); 
		$pdf->Write(0, $row['gender']);

		$pdf->SetXY(28, 70); 
		$pdf->Write(0, $row['guardiannamefirst1']. " ".$row['guardiannamelast1']);
		$pdf->SetXY(120, 70); 
		$pdf->Write(0, $row['guardian1phone1']);
		$pdf->SetXY(165, 70); 
		$pdf->Write(0, $row['guardian1phone2']);

		$pdf->SetXY(28, 77); 
		$pdf->Write(0, $row['guardiannamefirst2']." ".$row['guardiannamelast2']);
		$pdf->SetXY(120, 77); 
		$pdf->Write(0, $row['guardian2phone1']);
		$pdf->SetXY(165, 77); 
		$pdf->Write(0, $row['guardian2phone2']);

		$pdf->SetXY(27, 84); 
		$pdf->Write(0, $row['guardianemail1']);

		$pdf->SetXY(27, 91); 
		$pdf->Write(0, $row['guardianemail2']);


		$pdf->SetXY(16, 110); 
		$pdf->Write(0, $row['emergencynamefirst1']." ".$row['emergencynamelast1']);
		$pdf->SetXY(91, 110); 
		$pdf->Write(0, $row['emergencyphone1']);
		$pdf->SetXY(154, 110); 
		$pdf->Write(0, $row['emergencyrelationship1']);

		$pdf->SetXY(16, 117); 
		$pdf->Write(0, $row['emergencynamefirst2']." ".$row['emergencynamelast2']);
		$pdf->SetXY(91, 117); 
		$pdf->Write(0, $row['emergencyphone2']);
		$pdf->SetXY(154, 117); 
		$pdf->Write(0, $row['emergencyrelationship2']);


		$pdf->SetXY(34, 145); 
		$pdf->Write(0, $row['doctorname']);
		$pdf->SetXY(122, 145); 
		$pdf->Write(0, $row['doctorphone']);
		$pdf->SetXY(168, 145); 
		$pdf->Write(0, $row['insurance']);

		$pdf->SetXY(50, 151); 
		$pdf->Write(0, $row['illnesses']);
		$pdf->SetXY(124, 151); 
		$pdf->Write(0, $row['policyholder']);

		$pdf->SetXY(16, 162); 
		$pdf->Write(0, $row['medication']);
		$pdf->SetXY(78, 162); 
		$pdf->Write(0, $row['medicationnames']);
		$pdf->SetXY(139, 162); 
		$pdf->Write(0, $row['allergies']);

		$pdf->SetXY(44, 172); 
		$pdf->Write(0, $row['activities']);
		$pdf->SetXY(78, 172); 
		$pdf->Write(0, $row['activitiesnames']);
		$pdf->SetXY(139, 172); 
		$pdf->Write(0, $row['immunizations']);

		$pdf->SetXY(16, 181); 
		$pdf->Write(0, $row['medicaltreatments']);
		$pdf->SetXY(78, 181); 
		$pdf->Write(0, $row['medicaltreatmentsnames']);
		$ogtet = $row['tetanusdate'];
		$splittet = explode("-", $ogtet);
		$newtet = $splittet[1]."/".$splittet[2]."/".$splittet[0];
		$pdf->SetXY(139, 181); 
		$pdf->Write(0, $newtet);

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

		$pdf->SetXY(18, 193); 
		$pdf->Write(0, $regdate);
		$pdf->SetXY(24, 196); 
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

		$pdf->SetXY(64, 193);
		$pdf->Write(0, $regdate);
		$pdf->SetXY(68, 196); 
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

		$pdf->SetXY(114, 193); 
		$pdf->Write(0, $regdate);
		$pdf->SetXY(117, 196); 
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

		$pdf->SetXY(160, 193); 
		$pdf->Write(0, $regdate);
		$pdf->SetXY(165, 196); 
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

		$pdf->SetXY(20, 201); 
		$pdf->Write(0, $regdate);
		$pdf->SetXY(24, 204); 
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

		$pdf->SetXY(64, 201); 
		$pdf->Write(0, $regdate);
		$pdf->SetXY(68, 204); 
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

		$pdf->SetXY(114, 201); 
		$pdf->Write(0, $regdate);
		$pdf->SetXY(117, 204); 
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

		$pdf->SetXY(160, 201); 
		$pdf->Write(0, $regdate);
		$pdf->SetXY(165, 204); 
		$pdf->Write(0, $reginfo);

		if ($row['extendedcare'] == 1) {
			$extcare = "Yes";
		} 
		else {
			$extcare = "No";
		}
		$pdf->SetXY(71, 213); 
		$pdf->Write(0, $extcare);

		$pdf->SetXY(31, 219); 
		$pdf->Write(0, $row['comments']);
	}

	}

$pdf->Output();
?>