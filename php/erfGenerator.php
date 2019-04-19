<?php
require('fpdf/fpdf.php');

class PDF extends FPDF
{
// Page template setter
function Header()
{
    // Template set
    $this->Image('erfTemplate.png', -5, -5, 215, 310);
}
}

include ("connection.php"); //setup connection with database


// query database

$res =  $conn->query("SELECT * FROM Parents, Children, ChildrenDynamic WHERE Parents.parentid=Children.parentid AND Children.childid=ChildrenDynamic.childid");
$row = $res->fetch(PDO::FETCH_ASSOC);


unset($conn); //unset connection to database

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',10);

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
$pdf->Write(0, "Enter Age"); //calculate age via dob - dateobj
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
$pdf->Write(0, "Enter Emergency Email 1");

$pdf->SetXY(5, 111); 
$pdf->Write(0, $row['emergencynamefirst2']." ".$row['emergencynamelast2']);
$pdf->SetXY(87, 111); 
$pdf->Write(0, $row['emergencyphone2']);
$pdf->SetXY(157, 111); 
$pdf->Write(0, "Enter Emergency Email 2");


$pdf->SetXY(24, 145); 
$pdf->Write(0, "Enter Doctor name");
$pdf->SetXY(121, 145); 
$pdf->Write(0, "Enter phone number");
$pdf->SetXY(172, 145); 
$pdf->Write(0, "Enter carrier");

$pdf->SetXY(42, 154); 
$pdf->Write(0, "Enter illnesses");
$pdf->SetXY(123, 154); 
$pdf->Write(0, "Enter policyholder name");

$pdf->SetXY(5, 166); 
$pdf->Write(0, "Enter medications yes/no");
$pdf->SetXY(73, 166); 
$pdf->Write(0, "Enter medication names");
$pdf->SetXY(140, 166); 
$pdf->Write(0, "Enter allergies/diets");

$pdf->SetXY(33, 178); 
$pdf->Write(0, "Enter activities yes/no");
$pdf->SetXY(73, 178); 
$pdf->Write(0, "Enter activity names");
$pdf->SetXY(140, 178); 
$pdf->Write(0, "Enter immunizations yes/no");

$pdf->SetXY(5, 190); 
$pdf->Write(0, "Enter medical treatments yes/no");
$pdf->SetXY(73, 190); 
$pdf->Write(0, "Enter treatment names");
$pdf->SetXY(140, 190); 
$pdf->Write(0, "Enter tetanus date");


$pdf->SetXY(4, 204); 
$pdf->Write(0, "Enter week1am data");
$pdf->SetXY(48, 204); 
$pdf->Write(0, "Enter week2am data");
$pdf->SetXY(90, 204); 
$pdf->Write(0, "Enter week3am data");
$pdf->SetXY(131, 204); 
$pdf->Write(0, "Enter week4am data");
$pdf->SetXY(173, 204); 
$pdf->Write(0, "Enter week5am");

$pdf->SetXY(4, 212); 
$pdf->Write(0, "Enter week1pm data");
$pdf->SetXY(48, 212); 
$pdf->Write(0, "Enter week2pm data");
$pdf->SetXY(90, 212); 
$pdf->Write(0, "Enter week3pm data");
$pdf->SetXY(131, 212); 
$pdf->Write(0, "Enter week4pm data");
$pdf->SetXY(173, 212); 
$pdf->Write(0, "Enter week5pm");

$pdf->SetXY(65, 220); 
$pdf->Write(0, "Enter extended care yes/no");

$pdf->SetXY(21, 229); 
$pdf->Write(0, "Enter additional comments");

$pdf->Output();


?>