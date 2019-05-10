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

$sql = "INSERT INTO Week".$_POST['week'].$_POST['year']."Attendance (name, sch_att, mon, tues, wed, thurs, fri, illnesses, allergies, medication, activities, comments) 
	VALUES(:name, :sch_att, :mon, :tues, :wed, :thurs, :fri, :illnesses, :allergies, :medication, :activities, :comments)";


$data = [
			':name' => $_POST['name'],
			':sch_att' => 'UNKNOWN',
			':mon' => '',
			':tues' => '',
			':wed' => '',
			':thurs' => '',
			':fri' => '',
			':illnesses' => '',
			':allergies' => '',
			':medication' => '',
			':activities' => '',
			':comments' => ''
		];


$stmt = $conn->prepare($sql);
$stmt->execute($data);

unset($conn);


header('Location: /attendanceSheet.php?week='.$_POST['week'].'&year='.$_POST['year']);

?>