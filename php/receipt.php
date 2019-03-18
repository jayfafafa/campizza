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

$sqlChildName = "SELECT firstname, lastname FROM Children WHERE childid=".$_SESSION['childid'];
$stmtChildName = $conn->query($sqlChildName);
$childName = $stmtChildName->fetch(PDO::FETCH_ASSOC);

$data[':price'] = $balance['price'] + $_SESSION['total'];
$data[':credit'] = $_SESSION['credit'];

$creditDif = 0;

if($balance['credit'] > $_SESSION['credit']){
	$creditDif = ($balance['credit'] - $_SESSION['credit']);
	$data[':price'] = $data[':price'] + ($balance['credit'] - $_SESSION['credit']);
}

$sqlEmail = "SELECT guardianemail1, guardianemail2 FROM Parents WHERE parentid=".$_SESSION['id'];
$stmtEmail = $conn->query($sqlEmail);
$email = $stmtEmail->fetch(PDO::FETCH_ASSOC);

$to = $email['guardianemail1'];
if($email['guardianemail2'] != NULL && $email['guardianemail2'] != ''){
	$to .= ','.$email['guardianemail2'];
}

$subject = 'Camp Izza Registration Receipt';

$headers = "From: campizza@gmail.com\r\n";
$headers = "Content-Type: text/html; charset=UTF-8\r\n";

$message = '<!doctype html>
<html lang="en">

<style>
	.center {
	  text-align: center;
	}
</style>

<div class="center">
	<img src="https://static.wixstatic.com/media/46af7c_6c86140c4f8e479e95cb12c1bddfa5f1~mv2.gif" alt="" width="183" height="136">
	<br />
	<h1>Thank you for registering for Camp Izza!</h1>
	<h2>This is your registration receipt. Please retain a copy of this for your personal records.</h2>
	<hr>';

$message.='<p>
	<b>Camper:</b>'
	.$childName['firstname'].' '.$childName['lastname']
	.'<br>
	<b>Enrolled Sessions:</b>
	<br>';

$morningStart = '8:30am';
$morningEnd = '12:00pm';
$afternoonStart = '12:30pm';
$afternoonEnd = '4:00pm';

if($data[':extendedcare'] == 1){
	$morningStart = '7:30am';
	$afternoonEnd = '5:30pm';
}

for($x = 1; $x <= 8; $x++){
	if($data[':week'.$x.'am'] == 1 && $data[':week'.$x.'pm'] == 1){
		$message .= 'Week '.$x.': '.substr($weekInfo['week'.$x.'start'], 5,2).'/'.substr($weekInfo['week'.$x.'start'], 8,2).'-'
		.substr($weekInfo['week'.$x.'end'], 5,2).'/'.substr($weekInfo['week'.$x.'end'], 8,2)
		.' Full Day: '.$morningStart.' - '.$afternoonEnd.'<br>';
	}
	elseif($data[':week'.$x.'am'] == 1){
		$message .= 'Week '.$x.': '.substr($weekInfo['week'.$x.'start'], 5,2).'/'.substr($weekInfo['week'.$x.'start'], 8,2).'-'
		.substr($weekInfo['week'.$x.'end'], 5,2).'/'.substr($weekInfo['week'.$x.'end'], 8,2)
		.' Morning: '.$morningStart.' - '.$morningEnd.'<br>';
	}
	elseif($data[':week'.$x.'pm'] == 1){
		$message .= 'Week '.$x.': '.substr($weekInfo['week'.$x.'start'], 5,2).'/'.substr($weekInfo['week'.$x.'start'], 8,2).'-'
		.substr($weekInfo['week'.$x.'end'], 5,2).'/'.substr($weekInfo['week'.$x.'end'], 8,2)
		.' Afternoon: '.$afternoonStart.' - '.$afternoonEnd.'<br>';
	}
}
	
$message .= '<br>
	<b>Summary of this Transaction:</b>
	<br>
	Paid with Paypal: $'.$_SESSION['total']
	.'<br>
	Paid with Credit: $'.$creditDif
	.'<br>
	Total Paid: $'.$data[':price']
	.'<br>
	Remaining Credit on Account: $'.$_SESSION['credit']
	.'</p>';

$message.='	<hr>
	If you have any comments or concerns, please contact us!
	<br>
	Phone: 949-422-8123
	<br>
	Email: info@campizza.com
	<br>
	Camp Izza is a 501 (c)(3) non-profit organization registered in the state of California with federal tax id #26-2174441
	<br>
	© 2019 Camp Izza
	
</div>';

mail($to, $subject, $message, $headers);

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