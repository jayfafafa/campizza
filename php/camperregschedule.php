<?php 

// Initialize the session
session_start();
 
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
include ('connection.php');
/* //get session week information for Updating table & Dynamically generating week information in page
$sqlWeekInfo = "SELECT * FROM YearlySessionWeeks";
$stmtWeekInfo = $conn->query($sqlWeekInfo);
$weekInfo = $stmtWeekInfo->fetch(PDO::FETCH_ASSOC);

date_default_timezone_set('America/Los_Angeles');
$currDate = date('Y-m-d', time()); */

//get session week information for Updating table & Dynamically generating week information in page
	$sqlWeekInfo = "SELECT * FROM YearlySessionWeeks";
	$stmtWeekInfo = $conn->query($sqlWeekInfo);
	$weekInfo = $stmtWeekInfo->fetch(PDO::FETCH_ASSOC);

if($_SERVER["REQUEST_METHOD"] == "POST") {
	//Calculate total
	
	$sql = "UPDATE ChildrenDynamic SET week1am=:week1am, week1pm=:week1pm, week2am=:week2am,"
		."week2pm=:week2pm, week3am=:week3am, week3pm=:week3pm, week4am=:week4am, "
		."week4pm=:week4pm, week5am=:week5am, week5pm=:week5pm, week6am=:week6am, "
		."week6pm=:week6pm, week7am=:week7am, week7pm=:week7pm, week8am=:week8am, week8pm=:week8pm, "
		."extendedcare=:extendedcare, price=:price, credit=:credit WHERE childid=".$_SESSION['childid']." AND registeredyear=".$weekInfo['currentyear'];
		
		$week1am = 0;
		$week2am = 0;
		$week3am = 0;
		$week4am = 0;
		$week5am = 0;
		$week6am = 0;
		$week7am = 0;
		$week8am = 0;
		$week1pm = 0;
		$week2pm = 0;
		$week3pm = 0;
		$week4pm = 0;
		$week5pm = 0;
		$week6pm = 0;
		$week7pm = 0;
		$week8pm = 0;
		$extendedcare = 0;
		
		if(isset($_POST['week1am'])){
			$week1am = $_POST['week1am'];
		}
		if(isset($_POST['week2am'])){
			$week2am = $_POST['week2am'];
		}
		if(isset($_POST['week3am'])){
			$week3am = $_POST['week3am'];
		}
		if(isset($_POST['week4am'])){
			$week4am = $_POST['week4am'];
		}
		if(isset($_POST['week5am'])){
			$week5am = $_POST['week5am'];
		}
		if(isset($_POST['week6am'])){
			$week6am = $_POST['week6am'];
		}
		if(isset($_POST['week7am'])){
			$week7am = $_POST['week7am'];
		}
		if(isset($_POST['week8am'])){
			$week8am = $_POST['week8am'];
		}
		if(isset($_POST['week1pm'])){
			$week1pm = $_POST['week1pm'];
		}
		if(isset($_POST['week2pm'])){
			$week2pm = $_POST['week2pm'];
		}
		if(isset($_POST['week3pm'])){
			$week3pm = $_POST['week3pm'];
		}
		if(isset($_POST['week4pm'])){
			$week4pm = $_POST['week4pm'];
		}
		if(isset($_POST['week5pm'])){
			$week5pm = $_POST['week5pm'];
		}
		if(isset($_POST['week6pm'])){
			$week6pm = $_POST['week6pm'];
		}
		if(isset($_POST['week7pm'])){
			$week7pm = $_POST['week7pm'];
		}
		if(isset($_POST['week8pm'])){
			$week8pm = $_POST['week8pm'];
		}
		if(isset($_POST['extendedcare'])){
			$extendedcare = $_POST['extendedcare'];
		}

		$sqlNew = "SELECT price, credit FROM ChildrenDynamic WHERE childid=".$_SESSION['childid']." AND registeredyear=".$weekInfo['currentyear'];
		$stmt = $conn->query($sqlNew);
		$child = $stmt->fetch(PDO::FETCH_ASSOC);
		$currentPrice = $child['price'];
		$currentBalance = $child['credit'];
		
		$data = [
			':week1am' => $week1am,
			':week1pm' => $week1pm,
			':week2am' => $week2am,
			':week2pm' => $week2pm,
			':week3am' => $week3am,
			':week3pm' => $week3pm,
			':week4am' => $week4am,
			':week4pm' => $week4pm,
			':week5am' => $week5am,
			':week5pm' => $week5pm,
			':week6am' => $week6am,
			':week6pm' => $week6pm,
			':week7am' => $week7am,
			':week7pm' => $week7pm,
			':week8am' => $week8am,
			':week8pm' => $week8pm,
			':extendedcare' => $extendedcare,
			':price' => $currentPrice,
			':credit' => $currentBalance
	];
	
/*	//getting shirt information
	$sqlShirts = "SELECT numshirts FROM Children WHERE childid=".$_SESSION['childid'];
	$stmtShirts = $conn->query($sqlShirts);
	$numShirts = $stmtShirts->fetch(PDO::FETCH_ASSOC);
	
	$prices = array(
			'week1' => 0,
			'week2' => 0,
			'week3' => 0,
			'week4' => 0,
			'week5' => 0,
			'week6' => 0,
			'week7' => 0,
			'week8' => 0
	);
	
	if( strtotime($currDate) < strtotime($weekInfo['week1start']) ) {
		$eOrL = 'early';
	} else {
		$eOrL = 'late';
	}
	
	if( $data[':extendedcare'] == 1) {
		$extendedCareCost = $yearlyPrices['extendedcare'];
	} else {
		$extendedCareCost = 0;
	}
	
	for($x = 1; $x <= $weekInfo['activeweeks']; $x++){ //Including extended care
		if($data[':week'.$x.'am'] == 1 && $data[':week'.$x.'pm'] == 1 ) { //both am & pm [full day]
			if('week'.$x == $weekInfo['holidayweek']) $prices['week'.$x] = $yearlyPrices['holidayweekfull'.$eOrL] + $extendedCareCost; //Holiday Full
			else $prices['week'.$x] = $yearlyPrices['oneweekfull'.$eOrL] + $extendedCareCost; //not holiday
		} else if($data[':week'.$x.'am'] == 1) { //week# am only
			if('week'.$x == $weekInfo['holidayweek']) $prices['week'.$x] = $yearlyPrices['holidayweekam'.$eOrL] + $extendedCareCost; //am HOliday
			else $prices['week'.$x] = $yearlyPrices['oneweekam'.$eOrL] + $extendedCareCost; //am reg
		} else {//week# pm only
			if('week'.$x == $weekInfo['holidayweek']) $prices['week'.$x] = $yearlyPrices['holidayweekpm'.$eOrL] + $extendedCareCost;//pm HOliday
			else $prices['week'.$x] = $yearlyPrices['oneweekpm'.$eOrL] + $extendedCareCost;//pm reg
		}
	}

	$total = $numShirts['numshirts'] * $yearlyPrices['extrashirt'];
	foreach($prices as $x){$total += $x;} */

	if($stmt = $conn->prepare($sql)){
		$_SESSION['query']=$sql;
		$_SESSION['data']=$data;
		//$_SESSION['total']=$total;
		//$_SESSION['prices']=$prices;
		//foreach($data as $x){echo $x;}
		header("location: checkout.php");
		
	}

}

$activeweeks = $weekInfo["activeweeks"];

date_default_timezone_set('America/Los_Angeles');
$currDate = date('Y-m-d', time());

if( strtotime($currDate) < strtotime($weekInfo['week1start']) ) {
	$eOrL = 'early';
} else {
	$eOrL = 'late';
}

//yearly pricing / total calculation -- seperate 
$sqlPrice = "SELECT * FROM YearlySessionPricing";
$stmtPrices = $conn->query($sqlPrice);
$yearlyPrices = $stmtPrices->fetch(PDO::FETCH_ASSOC);


$extendedCareCost = $yearlyPrices['extendedcare'];

$sqlCurrentScheduleInfo = "SELECT * FROM ChildrenDynamic WHERE childid=".$_SESSION['childid']." AND registeredyear=".$weekInfo['currentyear'];
$stmtCurrentScheduleInfo = $conn->query($sqlCurrentScheduleInfo);
$currentInfo = $stmtCurrentScheduleInfo->fetch(PDO::FETCH_ASSOC);


//Session Limiting
$sqlLimitsDates = "SELECT * FROM DatesSessionInfo"; //K-1
$rLimitsDates = $conn->query($sqlLimitsDates);
$limitsDates = $rLimitsDates->fetch(PDO::FETCH_ASSOC);

$sqlLimitsCoconuts = "SELECT * FROM CoconutsSessionInfo"; //2-3
$rLimitsCoconuts = $conn->query($sqlLimitsCoconuts);
$limitsCoconuts = $rLimitsCoconuts->fetch(PDO::FETCH_ASSOC);

$sqlLimitsTrees = "SELECT * FROM TreesSessionInfo"; //4-5
$rLimitsTrees = $conn->query($sqlLimitsTrees);
$limitsTrees = $rLimitsTrees->fetch(PDO::FETCH_ASSOC);

$sqlLimitsYLeaders = "SELECT * FROM YoungLeadersSessionInfo"; //6-8
$rLimitsYLeaders = $conn->query($sqlLimitsYLeaders);
$limitsYLeaders = $rLimitsYLeaders->fetch(PDO::FETCH_ASSOC);

$sqlLimits = "SELECT * FROM YearlySessionLimits";
$rLimits = $conn->query($sqlLimits);
$sessionLimits = $rLimits->fetch(PDO::FETCH_ASSOC);

$sqlGrade = "SELECT grade FROM Children WHERE childid=".$_SESSION['childid'];
$rGrade = $conn->query($sqlGrade);
$gradeList = $rGrade->fetch(PDO::FETCH_ASSOC);
$grade=$gradeList['grade'];



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
	<link rel="stylesheet" href="camperregschedule.css">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

    <style type="text/css">
    	.custom-checkbox-lg .custom-control-label::before,
		.custom-checkbox-lg .custom-control-label::after {
		  width: 30px;
		  height: 30px;
		}
		td input[type="checkbox"] {
		    float: left;
		    margin: 0 auto;
		    width: 100%;
		}
    </style>
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

	<!-- Html Lookout -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
<div class="container" style = "background: white; margin-top: 20px; padding-bottom: 50px;">
    <h1 style = "padding-top: 40px;text-align: center;">Camper Registration Schedule</h1>
  	<div class="container">
  		<!--Camper Schedule-->
  		<div class="row margin-data">
  			<div class="col-md-8 offset-md-2">
		  		<div class="row margin-data">
		  			<div class="col">
		  			</div>
		  		</div>
		  		<!-- Figure -->
		  		<div class="card">
		  			<!-- <div class="card-body text-center">
		  				<small class="text-muted" style="padding-top: 10px;padding-bottom: 10px;background:white;">Clicking on A.M. and P.M. allows the student to be there for a full day <br>A.M. = 8:30am - 12:00pm<br> P.M. = 12:30pm - 4:00pm <br> A.M + P.M = 8:30am - 4:00pm<br> Extended care begins from 7:00am to 8:30am and/or 4:00pm to 5:30pm</small>
		  			</div> -->
					<div class="card-footer" style="background: white;">
					  	<div style='overflow: auto;' class="card-body">
						    <table class="table table-bordered">
							  <thead>
							    <tr>
							      <th style = "width:35%" scope="col">For Full day, select Morning and Afternoon</th>
							      <th style = "width:28%" scope="col">Morning: 8:30am - 12:00pm</th>
							      <th style = "width:28%" scope="col">Afternoon: 12:30pm - 4:00pm</th>
							      <th style = "width:9%" scope="col">Total</th>
							    </tr>
							  </thead>
							  <tbody>
<?php
for($x = 1; $x <= $activeweeks; $x++){

	$currentWeekAM = 'week'.$x.'am';
	$currentWeekPM = 'week'.$x.'pm';
	$sessionFullAM = FALSE;
	$sessionFullPM = FALSE;

	if(($grade == 'K' || $grade == '1') && $limitsDates[$currentWeekAM] >= $sessionLimits['dateslimitam']){
		$sessionFullAM = TRUE;
	}
	if(($grade == 'K' || $grade == '1') && $limitsDates[$currentWeekPM] >= $sessionLimits['dateslimitpm']){
		$sessionFullPM = TRUE;
	}
	if(($grade == '2' || $grade == '3') && $limitsCoconuts[$currentWeekAM] >= $sessionLimits['coconutslimitam']){
		$sessionFullAM = TRUE;
	}
	if(($grade == '2' || $grade == '3') && $limitsCoconuts[$currentWeekPM] >= $sessionLimits['coconutslimitpm']){
		$sessionFullPM = TRUE;
	}
	if(($grade == '4' || $grade == '5') && $limitsTrees[$currentWeekAM] >= $sessionLimits['treeslimitam']){
		$sessionFullAM = TRUE;
	}
	if(($grade == '4' || $grade == '5') && $limitsTrees[$currentWeekPM] >= $sessionLimits['treeslimitpm']){
		$sessionFullPM = TRUE;
	}
	if(($grade == '6' || $grade == '7' || $grade == '8') && $limitsYLeaders[$currentWeekAM] >= $sessionLimits['youngleaderslimitam']){
		$sessionFullAM = TRUE;
	}
	if(($grade == '6' || $grade == '7' || $grade == '8') && $limitsYLeaders[$currentWeekPM] >= $sessionLimits['youngleaderslimitpm']){
		$sessionFullPM = TRUE;
	}


		echo '<tr>';
		echo '<th scope="row"><div style="padding-top:5px">Week '.$x.': '.substr($weekInfo['week'.$x.'start'], 5,2).'/'.substr($weekInfo['week'.$x.'start'], 8,2).'-'
		.substr($weekInfo['week'.$x.'end'], 5,2).'/'.substr($weekInfo['week'.$x.'end'], 8,2).'</div></th>';
		echo '<td>';
	    echo '<div class="custom-control custom-checkbox custom-checkbox-lg">';
	    if ($sessionFullAM && $currentInfo['week'.$x.'am'] == 0){
		    echo '<p>FULL</p>';
		    echo '<input type="hidden" name="week'.$x.'am" id="week'.$x.'a">';
		}else{
			if($currentInfo['week'.$x.'am'] == 0){
				echo '<input name="week'.$x.'am" class="custom-control-input" type="checkbox" value="1" id="week'.$x.'a" onchange= "doalert(this)"> <label class="custom-control-label" for="week'.$x.'a"></label>';
			}else{
				echo '<input name="week'.$x.'am" class="custom-control-input" type="checkbox" value="1" id="week'.$x.'a" onchange= "doalert(this)" checked> <label class="custom-control-label" for="week'.$x.'a"></label>';
			}
			echo "<p></p>";
		}
		echo '</div>';
	    echo '</td>';
	    echo '<td>';
	    echo '<div class="custom-control custom-checkbox custom-checkbox-lg">';
	    if($sessionFullPM && $currentInfo['week'.$x.'pm'] == 0){
		    echo '<p>FULL</p>';
		    echo '<input type="hidden" name="week'.$x.'pm" id="week'.$x.'b" value="0">';
	    }else{
		    if($currentInfo['week'.$x.'pm'] == 0){
				echo '<input name="week'.$x.'pm" class="custom-control-input" type="checkbox" value="1" id="week'.$x.'b" onchange= "doalert(this)"> <label class="custom-control-label" for="week'.$x.'b"></label>';
			}else{
				echo '<input name="week'.$x.'pm" class="custom-control-input" type="checkbox" value="1" id="week'.$x.'b" onchange= "doalert(this)" checked> <label class="custom-control-label" for="week'.$x.'b"></label>';
			}
			echo "<p></p>";
		}
		echo '</div>';
	    echo '</td>';
	    echo '<td id="week'.$x.'price">0</td>';
	    echo '</tr>';

	}
?>
							    <tr>
							      <th>Extended Care<br>7:00am to 8:30am and/or 4:00pm to 5:30pm</th>
							      <td colspan="2">
							      	<div class="custom-control custom-checkbox custom-checkbox-lg">
									  <input name="extendedcare" class="custom-control-input" type="checkbox" value="1" id="extcare" onchange= "doalert(this)">
									  <label class="custom-control-label" for="extcare"></label>
									</div>
							      </td>
							    </tr>

							  </tbody>
							</table>
					  	</div>
					</div>
		</div>
		</div>

			</div>
		</div>

		<div class="row margin-data" style = "padding-bottom: 30px;" align="center">
			<div class="col">
				<input type="submit" class="btn-xl" align="center" value="Next">
			</div>
		</div>
		</div>

  	</div>
</div>
</form>

	<!--Javascript here-->
	<script type="text/javascript">
		document.getElementById('extcare').click();
		document.getElementById('extcare').click();

		function doalert(checkboxElem) {
		//Not Extended Care
		var holWeek = <?php echo json_encode($weekInfo['holidayweek']);?>;
		if(document.getElementById('extcare').checked == false)
		{
			for (var i = 1; i <= 6; i++) {
				if(document.getElementById("week"+String(i)+"a").checked == true && 
					document.getElementById("week"+String(i)+"b").checked == true)
				{
					if(String(i) == holWeek ) { //holiday week full 
						$('#week'+String(i)+'price').text(<?php echo $yearlyPrices['holidayweekfull'.$eOrL]; ?>);
					} else { //non-holiday week full
						$('#week'+String(i)+'price').text(<?php echo $yearlyPrices['oneweekfull'.$eOrL]; ?>);
					}
				}
				else if (document.getElementById("week"+String(i)+"a").checked == true && 
					document.getElementById("week"+String(i)+"b").checked == false)
				{
					if(String(i) == holWeek )  { //holiday week am
						$('#week'+String(i)+'price').text(<?php echo $yearlyPrices['holidayweekam'.$eOrL]; ?>);
					} else { //non-holiday week am
						$('#week'+String(i)+'price').text(<?php echo $yearlyPrices['oneweekam'.$eOrL]; ?>);
					}
				}
				else if (document.getElementById("week"+String(i)+"a").checked == false && 
					document.getElementById("week"+String(i)+"b").checked == true)
				{
					if(String(i) == holWeek ) { //holiday week pm
						$('#week'+String(i)+'price').text(<?php echo $yearlyPrices['holidayweekpm'.$eOrL]; ?>);
					} else { //non-holiday week pm
						$('#week'+String(i)+'price').text(<?php echo $yearlyPrices['oneweekpm'.$eOrL]; ?>);
					}
				}
				else
				{
					$('#week'+String(i)+'price').text(0);
				}
			}
		}
		else
		{
			for (var i = 1; i <= 6; i++) {
				if(document.getElementById("week"+String(i)+"a").checked == true && 
					document.getElementById("week"+String(i)+"b").checked == true)
				{
					if(String(i) == holWeek ) { //holiday week full 
						$('#week'+String(i)+'price').text(<?php echo $yearlyPrices['holidayweekfull'.$eOrL] + ( $extendedCareCost * 4.00 ); ?>);
					} else { //non-holiday week full
						$('#week'+String(i)+'price').text(<?php echo $yearlyPrices['oneweekfull'.$eOrL] + ( $extendedCareCost * 5.00 ); ?>);
					}
				}
				else if (document.getElementById("week"+String(i)+"a").checked == true && 
					document.getElementById("week"+String(i)+"b").checked == false)
				{
					if(String(i) == holWeek )  { //holiday week am
						$('#week'+String(i)+'price').text(<?php echo $yearlyPrices['holidayweekam'.$eOrL] + ( $extendedCareCost * 4.00 ); ?>);
					} else { //non-holiday week am
						$('#week'+String(i)+'price').text(<?php echo $yearlyPrices['oneweekam'.$eOrL] + ( $extendedCareCost * 5.00 ); ?>);
					}
				}
				else if (document.getElementById("week"+String(i)+"a").checked == false && 
					document.getElementById("week"+String(i)+"b").checked == true)
				{
					if(String(i) == holWeek ) { //holiday week pm
						$('#week'+String(i)+'price').text(<?php echo $yearlyPrices['holidayweekpm'.$eOrL] + ( $extendedCareCost * 4.00 ); ?>);
					} else { //non-holiday week pm
						$('#week'+String(i)+'price').text(<?php echo $yearlyPrices['oneweekpm'.$eOrL] + ( $extendedCareCost * 5.00 ); ?>);
					}
				}
				else
				{
					$('#week'+String(i)+'price').text(0);
				}
			}
		}
	}
	</script>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

	<div class="footer top-buffer">
		<div class="container">
			<div class="row align-items-center">
				<div class="col">
					<a class="footerphone">
						Call us:<br>
						949-422-8123
					</a>
				</div>
				<div class="vertline"></div>
				<div class="col">
				<p>Camp Izza is a 501 (c)(3) non-profit organization registered in the state of California with federal tax id #26-2174441</p>
				</div>
				<div class="vertline"></div>
				<div class="col">
				© 2019 Camp Izza
				</div>
			</div>
		</div>
	</div>



</body>

</html>