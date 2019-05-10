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

if($_SERVER["REQUEST_METHOD"]=="POST") {

	$sql ="CREATE TABLE Week".$_POST['week'].$_POST['year']."Attendance (
	id INT(3) AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(50) NOT NULL, 
	sch_att VARCHAR(7) NOT NULL, 
	mon VARCHAR(4), 
	tues VARCHAR(4), 
	wed VARCHAR(4), 
	thurs VARCHAR(4), 
	fri VARCHAR(4), 
	illnesses VARCHAR(50), 
	allergies VARCHAR(50), 
	medication VARCHAR(50), 
	activities VARCHAR(50), 
	comments VARCHAR(200)
	)";

	try{
		$conn->query($sql);
		echo "Table created";
	} catch (PDOException $exception) {
		if($exception->getCode() == 23000) {
			// CREATE ALERT TO SAY TO DELETE CURRENT TABLE
		}
		else {echo "Error: ".$exception->getcode();}
	}

	$result = $conn->query("SELECT * FROM Children, ChildrenDynamic WHERE Children.childid=ChildrenDynamic.childid AND ChildrenDynamic.registeredyear=".$_POST['year']);
	$num = $result->rowCount();

	$sqlInsert= "INSERT INTO Week".$_POST['week'].$_POST['year']."Attendance (name, sch_att, mon, tues, wed, thurs, fri, illnesses, allergies, medication, activities, comments) 
	VALUES(:name, :sch_att, :mon, :tues, :wed, :thurs, :fri, :illnesses, :allergies, :medication, :activities, :comments)";

	$i=0;
	while ($i < $num) {

		$row = $result->fetch(PDO::FETCH_ASSOC);

		$name = $row['firstname']." ".$row['lastname'];
		
		if($row['week'.$_POST['week'].'am'] == 1 && $row['week'.$_POST['week'].'pm'] == 1)
			$sch_att = 'FULL';
		elseif ($row['week'.$_POST['week'].'am'] == 1)
			$sch_att = 'AM ONLY'; 
		elseif ($row['week'.$_POST['week'].'pm'] == 1)
			$sch_att = 'PM ONLY';
		else
			$sch_att = 'NONE';

		$data = [
			':name' => $name,
			':sch_att' => $sch_att,
			':mon' => '',
			':tues' => '',
			':wed' => '',
			':thurs' => '',
			':fri' => '',
			':illnesses' => $row['illnesses'],
			':allergies' => $row['allergies'],
			':medication' => $row['medicationnames'],
			':activities' => $row['activitiesnames'],
			':comments' => $row['comments']
		];

		if($sch_att != 'NONE'){
			$stmt = $conn->prepare($sqlInsert);
			$stmt->execute($data);
		}

		$i++;

	}
	unset($conn);
	header('Location: /attendanceSheet.php?week='.$_POST['week'].'&year='.$_POST['year']);

}

unset($conn);

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


<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

	Week (between 1 and 8): <input type="number" name="week" min="1" max="8">
	Year : <input type="number" name="year">
	<input type="submit">

</form>

</body>

</html>


