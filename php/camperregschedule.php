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
include ('connection.php');
/* //get session week information for Updating table & Dynamically generating week information in page
$sqlWeekInfo = "SELECT * FROM YearlySessionWeeks";
$stmtWeekInfo = $conn->query($sqlWeekInfo);
$weekInfo = $stmtWeekInfo->fetch(PDO::FETCH_ASSOC);

date_default_timezone_set('America/Los_Angeles');
$currDate = date('Y-m-d', time()); */

if($_SERVER["REQUEST_METHOD"] == "POST") {
	//Calculate total
	
	$sql = "UPDATE ChildrenDynamic SET week1am=:week1am, week1pm=:week1pm, week2am=:week2am,"
		."week2pm=:week2pm, week3am=:week3am, week3pm=:week3pm, week4am=:week4am, "
		."week4pm=:week4pm, week5am=:week5am, week5pm=:week5pm, week6am=:week6am, "
		."week6pm=:week6pm, week7am=:week7am, week7pm=:week7pm, week8am=:week8am, week8pm=:week8pm, "
		."extendedcare=:extendedcare WHERE childid=".$_SESSION['childid'];
		
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
			':extendedcare' => $extendedcare
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

$stmtAmount = $conn->query("SELECT * FROM YearlySessionWeeks");
$campInfo = $stmtAmount->fetch(PDO::FETCH_ASSOC);
$activeweeks = $campInfo["activeweeks"];

date_default_timezone_set('America/Los_Angeles');
$currDate = date('Y-m-d', time());

	
//get session week information for Updating table & Dynamically generating week information in page
$sqlWeekInfo = "SELECT * FROM YearlySessionWeeks";
$stmtWeekInfo = $conn->query($sqlWeekInfo);
$weekInfo = $stmtWeekInfo->fetch(PDO::FETCH_ASSOC);

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
		  			<div class="card-body text-center">
		  				<small class="text-muted" style="padding-top: 10px;padding-bottom: 10px;background:white;">Clicking on A.M. and P.M. allows the student to be there for a full day <br>A.M. = 8:30am - 12:00pm<br> P.M. = 12:30pm - 4:00pm <br> A.M + P.M = 8:30am - 4:00pm<br> Extended care begins from 7:00am to 8:30am and/or 4:00pm to 5:30pm</small>
		  			</div>
					<div class="card-footer" style="background: white;">
					  	<div class="card-body">
						    <table class="table table-bordered">
							  <thead>
							    <tr>
							      <th scope="col"></th>
							      <th scope="col">AM</th>
							      <th scope="col">PM</th>
							      <th scope="col">Total</th>
							    </tr>
							  </thead>
							  <tbody>
<?php
for($x = 1; $x <= $activeweeks; $x++){
		echo '<tr>';
		echo '<th scope="row">Week '.$x.': '.substr($campInfo['week'.$x.'start'], 5,2).'/'.substr($campInfo['week'.$x.'start'], 8,2).'-'
		.substr($campInfo['week'.$x.'end'], 5,2).'/'.substr($campInfo['week'.$x.'end'], 8,2).'</th>';
		echo '<td>';
	    echo '<div class="form-check">';
		echo '<input name="week'.$x.'am" class="form-check-input" type="checkbox" value="1" id="week'.$x.'a" onchange= "doalert(this)">';
		echo '</div>';
	    echo '</td>';
	    echo '<td>';
	    echo '<div class="form-check">';
		echo '<input name="week'.$x.'pm" class="form-check-input" type="checkbox" value="1" id="week'.$x.'b" onchange= "doalert(this)">';
		echo '</div>';
	    echo '</td>';
	    echo '<td id="week'.$x.'price">0</td>';
	    echo '</tr>';

	}
?>							    <!-- <tr>
							      <th scope="row">Week 1</th>
							      <td>
							     	<div class="form-check">
									  <input name="week1am" class="form-check-input" type="checkbox" value="1" id="week1a" onchange= "doalert(this)">
									</div>
							      </td>
							      <td>
							      	<div class="form-check">
									  <input name="week1pm" class="form-check-input" type="checkbox" value="1" id="week1b" onchange= "doalert(this)">
									</div>
							      </td>
							      <td id="week1price">0</td>
							    </tr>

							    <tr>
							      <th scope="row">Week 2</th>
							      <td>
							     	<div class="form-check">
									  <input name="week2am" class="form-check-input" type="checkbox" value="1" id="week2a" onchange= "doalert(this)">
									</div>
							      </td>
							      <td>
							      	<div class="form-check">
									  <input name="week2pm" class="form-check-input" type="checkbox" value="1" id="week2b" onchange= "doalert(this)">
									</div>
							      </td>
							      <td id="week2price">0</td>
							    </tr>
							    <tr>
							      <th scope="row">Week 3</th>
							      <td>
							     	<div class="form-check">
									  <input name="week3am" class="form-check-input" type="checkbox" value="1" id="week3a" onchange= "doalert(this)">
									</div>
							      </td>
							      <td>
							      	<div class="form-check">
									  <input name="week3pm" class="form-check-input" type="checkbox" value="1" id="week3b" onchange= "doalert(this)">
									</div>
							      </td>
							      <td id="week3price">0</td>
							    </tr>
							    <tr>
							      <th scope="row">Week 4</th>
							      <td>
							     	<div class="form-check">
									  <input name="week4am" class="form-check-input" type="checkbox" value="1" id="week4a" onchange= "doalert(this)">
									</div>
							      </td>
							      <td>
							      	<div class="form-check">
									  <input name="week4pm" class="form-check-input" type="checkbox" value="1" id="week4b" onchange= "doalert(this)">
									</div>
							      </td>
							      <td id="week4price">0</td>
							    </tr>
							    <tr>
							      <th scope="row">Week 5</th>
							      <td>
							     	<div class="form-check">
									  <input name="week5am" class="form-check-input" type="checkbox" value="1" id="week5a" onchange= "doalert(this)">
									</div>
							      </td>
							      <td>
							      	<div class="form-check">
									  <input name="week5pm" class="form-check-input" type="checkbox" value="1" id="week5b" onchange= "doalert(this)">
									</div>
							      </td>
							      <td id="week5price">0</td>
							    </tr>
							    <tr>
							      <th scope="row">Week 6</th>
							      <td>
							     	<div class="form-check">
									  <input name="week6am" class="form-check-input" type="checkbox" value="1" id="week6a" onchange= "doalert(this)">
									</div>
							      </td>
							      <td>
							      	<div class="form-check">
									  <input name="week6pm" class="form-check-input" type="checkbox" value="1" id="week6b" onchange= "doalert(this)">
									</div>
							      </td>
							      <td id="week6price">0</td>
							    </tr> -->
							    <tr>
							      <th>Extended Care</th>
							      <td colspan="3">
							      	<div class="form-check">
									  <input name="extendedcare" class="form-check-input" type="checkbox" value="1" id="extcare" onchange= "doalert(this)">
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
				if(document.getElementById("week"+String(i)+"a").checked == true && document.getElementById("week"+String(i)+"b").checked == true)
				{
					if("week"+String(i) == holWeek ) { //holiday week full 
						$('#week'+String(i)+'price').text(<?php echo $yearlyPrices['holidayweekfull'.$eOrL]; ?>);
					} else { //non-holiday week full
						$('#week'+String(i)+'price').text(<?php echo $yearlyPrices['oneweekfull'.$eOrL]; ?>);
					}
				}
				else if (document.getElementById("week"+String(i)+"a").checked == true && document.getElementById("week"+String(i)+"b").checked == false) 
				{
					if("week"+String(i) == holWeek )  { //holiday week am
						$('#week'+String(i)+'price').text(<?php echo $yearlyPrices['holidayweekam'.$eOrL]; ?>);
					} else { //non-holiday week am
						$('#week'+String(i)+'price').text(<?php echo $yearlyPrices['oneweekam'.$eOrL]; ?>);
					}
				}
				else if (document.getElementById("week"+String(i)+"a").checked == false && document.getElementById("week"+String(i)+"b").checked == true) 
				{
					if("week"+String(i) == holWeek ) { //holiday week pm
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
				if(document.getElementById("week"+String(i)+"a").checked == true && document.getElementById("week"+String(i)+"b").checked == true)
				{
					if("week"+String(i) == holWeek ) { //holiday week full 
						$('#week'+String(i)+'price').text(<?php echo $yearlyPrices['holidayweekfull'.$eOrL] + $extendedCareCost; ?>);
					} else { //non-holiday week full
						$('#week'+String(i)+'price').text(<?php echo $yearlyPrices['oneweekfull'.$eOrL] + $extendedCareCost; ?>);
					}
				}
				else if (document.getElementById("week"+String(i)+"a").checked == true && document.getElementById("week"+String(i)+"b").checked == false) 
				{
					if("week"+String(i) == holWeek )  { //holiday week am
						$('#week'+String(i)+'price').text(<?php echo $yearlyPrices['holidayweekam'.$eOrL] + $extendedCareCost; ?>);
					} else { //non-holiday week am
						$('#week'+String(i)+'price').text(<?php echo $yearlyPrices['oneweekam'.$eOrL] + $extendedCareCost; ?>);
					}
				}
				else if (document.getElementById("week"+String(i)+"a").checked == false && document.getElementById("week"+String(i)+"b").checked == true) 
				{
					if("week"+String(i) == holWeek ) { //holiday week pm
						$('#week'+String(i)+'price').text(<?php echo $yearlyPrices['holidayweekpm'.$eOrL] + $extendedCareCost; ?>);
					} else { //non-holiday week pm
						$('#week'+String(i)+'price').text(<?php echo $yearlyPrices['oneweekpm'.$eOrL] + $extendedCareCost; ?>);
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