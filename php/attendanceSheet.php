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

	foreach($_POST as $key => $value){
		if ($key == "week" || $key == "year")
			continue;

		$id = explode("_", $key);
		$sql = "UPDATE Week".$_POST['week'].$_POST['year']."Attendance SET ".$id[1]."='".$value."' WHERE id=".$id[0];

		$conn->query($sql);
	}

	unset($conn);
	header('Location: /attendanceSheet.php?week='.$_POST['week'].'&year='.$_POST['year']);

}


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
	<div class="container" style="padding-bottom: 10px">

		<table border="1">
			<tr>
				<th>Name</th>
				<th>Scheduled Attendance</th>
				<th>Monday</th>
				<th>Tuesday</th>
				<th>Wednesday</th>
				<th>Thursday</th>
				<th>Friday</th>
				<th>Illnesses</th>
				<th>Allergies</th>
				<th>Medications</th>
				<th>Activities</th>
				<th>Comments</th>
		    </tr>
		    <?php

			    $sql = "SELECT * FROM Week".$_GET['week'].$_GET['year']."Attendance";
			    $result = $conn->query($sql);
			    $num = $result->rowCount();

			    $i=0;
			    while($i < $num){
			?>
		    <tr>
		    	<?php
		    		$row = $result->fetch(PDO::FETCH_ASSOC);
		    		echo "<th>".$row['name']."</th>";
		    		echo "<th>".$row['sch_att']."</th>";
		    		
		    		$days = ['mon' => 'Monday', 'tues' => 'Tuesday', "wed" => 'Wednesday', "thurs" => "Thursday", "fri" => "Friday"];

		    		foreach ($days as $k => $v){

		    			$selectedBlank='';
		    			$selectedAM='';
		    			$selectedPM='';
		    			$selectedFULL='';
		    			$selectedABS='';

		    			if($row[$k] == '')
		    				$selectedBlank = 'selected="selected"';
		    			elseif($row[$k] == 'AM')
		    				$selectedAM = 'selected="selected"';
		    			elseif($row[$k] == 'PM')
		    				$selectedPM = 'selected="selected"';
		    			elseif($row[$k] == 'FULL')
		    				$selectedFULL = 'selected="selected"';
		    			elseif($row[$k] == 'ABS')
		    				$selectedABS = 'selected="selected"';


		    			echo "<th>";
		    			echo '<select name="'.$row['id'].'_'.$k.'" class="form-control form-control-md">';
		    			echo '<option '.$selectedBlank.'></option>';
		    			echo '<option '.$selectedAM.'>AM</option>';
						echo '<option '.$selectedPM.'>PM</option>';
						echo '<option '.$selectedFULL.'>FULL</option>';
						echo '<option '.$selectedABS.'>ABS</option>';
						echo '</select>';
						echo '</th>';
		    		}

		    		echo "<th>".$row['illnesses']."</th>";
		    		echo "<th>".$row['allergies']."</th>";
		    		echo "<th>".$row['medication']."</th>";
		    		echo "<th>".$row['activities']."</th>";
		    		echo "<th>".$row['comments']."</th>";

		    	?>


		    </tr>
		    <?php
		    	$i++;
				}
				unset($conn);
		    ?>
		</table>
	</div>
	<input type="hidden" name="week" value="<?php echo $_GET['week']; ?>">
	<input type="hidden" name="year" value="<?php echo $_GET['year']; ?>">
	<input type="submit">
</form>

<form action="addChildAttendance.php" method="post">

	Child Name: <input type="text" name="name">
	<input type="hidden" name="week" value="<?php echo $_GET['week']; ?>">
	<input type="hidden" name="year" value="<?php echo $_GET['year']; ?>">
	<input type="submit">

</form>

</body>

</html>

