<?php
// Initialize the session
session_start();

include('connection.php');
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}   else if ( ( isset($_SESSION["loggedin"]) && isset($_SESSION["registered"]) ) && ( $_SESSION["loggedin"] === true && $_SESSION["registered"] === false) ){
    //delete session registered
    header("location: parentregistration.php");
    exit;
}

$result = $conn->query("SELECT auth FROM ParentsLogin WHERE parentid=".$_SESSION['id']);
$row = $result->fetch(PDO::FETCH_ASSOC);
if($row['auth'] != 1){
    header('location: dashboard.php');
}

// Require https
if ($_SERVER['HTTPS'] != "on") {
    $url = "https://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    header("Location: $url");
    exit;
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
	<link rel="stylesheet" href="adminyearlyedit.css">

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

	<!--HTML-->
	<div style="background-color: white; margin-top: 20px;margin-left: 10px;margin-right: 10px;padding-left: 20px;padding-right: 20px;padding-bottom: 70px; margin-bottom: 20px;">
		<div class="container">
			<div class="row">
				<div class="d-flex top-buffer">
					<h1><b>Camp Information Editor</b></h1>
				</div>
			</div>
			<div class = "row align-items-center" style="padding: 10px 2px;">
				<button class="tablink" onclick="openPage('GroupLimits', this, 'red')" id="defaultOpen">Group Info.</button>
				<button class="tablink" onclick="openPage('CampWeeks', this, 'green')">Camp Info.</button>
				<button class="tablink" onclick="openPage('SessionPricing', this, 'blue')">Price Info.</button>
			
				<div class="tab">
					<div id="GroupLimits" class="tabcontent">
					  <h3 style="padding: 30px 40px;"><b>Group Limits</b></h3>
					  <hr>
					  	<form action="editSessionLimits.php" method="post">
					  		<div class="row" align="center">
								<div class="col">
									<div class="card">
										  <div class="card-body">
										    <h5 class="card-title"><b>Group 1: Dates</b></h5>
											  	<div class="row">
													<div class="col-4" align="right">
												  		<p style="padding-top: 20px;">AM Limit</p>
												  	</div>
											  		<div class="col-6">
												  		<input class="form-control" type="text" name="dateslimitam">
												  	</div>
												</div>
												<div class = "row">
													<div class="col-4" align="right">
												  		<p style="padding-top: 20px;">PM Limit</p>
												  	</div>
													<div class="col-6">
												  		<input class="form-control" type="text" name="dateslimitpm">
												  	</div>
												</div>
										  </div>
									</div>
								</div>
								<div class="col">
									<div class="card">
										  <div class="card-body">
										    <h5 class="card-title"><b>Group 2: Coconuts</b></h5>
											  	<div class="row">
													<div class="col-4" align="right">
												  		<p style="padding-top: 20px;">AM Limit</p>
												  	</div>
											  		<div class="col-6">
												  		<input class="form-control" type="text" name="coconutslimitam">
												  	</div>
												</div>
												<div class = "row">
													<div class="col-4" align="right">
												  		<p style="padding-top: 20px;">PM Limit</p>
												  	</div>
													<div class="col-6">
												  		<input class="form-control" type="text" name="coconutslimitpm">
												  	</div>
												</div>
										  </div>
									</div>
								</div>
							</div>
												  		<div class="row" align="center">
								<div class="col">
									<div class="card">
										  <div class="card-body">
										    <h5 class="card-title"><b>Group 3: Trees</b></h5>
											  	<div class="row">
													<div class="col-4" align="right">
												  		<p style="padding-top: 20px;">AM Limit</p>
												  	</div>
											  		<div class="col-6">
												  		<input class="form-control" type="text" name="treeslimitam">
												  	</div>
												</div>
												<div class = "row">
													<div class="col-4" align="right">
												  		<p style="padding-top: 20px;">PM Limit</p>
												  	</div>
													<div class="col-6">
												  		<input class="form-control" type="text" name="treeslimitpm">
												  	</div>
												</div>
										  </div>
									</div>
								</div>
								<div class="col">
									<div class="card">
										  <div class="card-body">
										    <h5 class="card-title"><b>Group 4: Young Leaders</b></h5>
											  	<div class="row">
													<div class="col-4" align="right">
												  		<p style="padding-top: 20px;">AM Limit</p>
												  	</div>
											  		<div class="col-6">
												  		<input class="form-control" type="text" name="youngleaderslimitam">
												  	</div>
												</div>
												<div class = "row">
													<div class="col-4" align="right">
												  		<p style="padding-top: 20px;">PM Limit</p>
												  	</div>
													<div class="col-6">
												  		<input class="form-control" type="text" name="youngleaderslimitpm">
												  	</div>
												</div>
										  </div>
									</div>
								</div>
							</div>
					    <div class="row margin-data align-items-center" style = "padding-top: 20px;padding-bottom: 70px;">
							<div class="col" align="center">
								<input type="submit" class="btn-xl" align="center" value="Save">
							</div>
					</div>
					</form>
				</div>
			</div>

			
			<div class="tab">
				<div id="CampWeeks" class="tabcontent">
					<h3 style="padding: 30px 40px;"><b>Camp Dates</b></h3>
					<form action="editSessionDates.php" method="post">
						<hr>
							<div class="row" align="center">
								<div class="col">
									<div class="card">
										  <div class="card-body">
										    <h5 class="card-title"><b>Week 1</b></h5>
											  	<div class="row">
													<div class="col-4" align="right">
												  		<p style="padding-top: 20px;">Start</p>
												  	</div>
											  		<div class="col-6">
												  		<input class="form-control" type="text" name="week1start">
												  	</div>
												</div>
												<div class = "row">
													<div class="col-4" align="right">
												  		<p style="padding-top: 20px;">End</p>
												  	</div>
													<div class="col-6">
												  		<input class="form-control" type="text" name="week1end">
												  	</div>
												</div>
										  </div>
									</div>
								</div>
								<div class="col">
									<div class="card">
										  <div class="card-body">
										    <h5 class="card-title"><b>Week 2</b></h5>
											  	<div class="row">
													<div class="col-4" align="right">
												  		<p style="padding-top: 20px;">Start</p>
												  	</div>
											  		<div class="col-6">
												  		<input class="form-control" type="text" name="week2start">
												  	</div>
												</div>
												<div class = "row">
													<div class="col-4" align="right">
												  		<p style="padding-top: 20px;">End</p>
												  	</div>
													<div class="col-6">
												  		<input class="form-control" type="text" name="week2end">
												  	</div>
												</div>
										  </div>
									</div>
								</div>
							</div>
							<div class="row" align="center">
								<div class="col">
									<div class="card">
										  <div class="card-body">
										    <h5 class="card-title"><b>Week 3</b></h5>
											  	<div class="row">
													<div class="col-4" align="right">
												  		<p style="padding-top: 20px;">Start</p>
												  	</div>
											  		<div class="col-6">
												  		<input class="form-control" type="text" name="week3start">
												  	</div>
												</div>
												<div class = "row">
													<div class="col-4" align="right">
												  		<p style="padding-top: 20px;">End</p>
												  	</div>
													<div class="col-6">
												  		<input class="form-control" type="text" name="week3end">
												  	</div>
												</div>
										  </div>
									</div>
								</div>
								<div class="col">
									<div class="card">
										  <div class="card-body">
										    <h5 class="card-title"><b>Week 4</b></h5>
											  	<div class="row">
													<div class="col-4" align="right">
												  		<p style="padding-top: 20px;">Start</p>
												  	</div>
											  		<div class="col-6">
												  		<input class="form-control" type="text" name="week4start">
												  	</div>
												</div>
												<div class = "row">
													<div class="col-4" align="right">
												  		<p style="padding-top: 20px;">End</p>
												  	</div>
													<div class="col-6">
												  		<input class="form-control" type="text" name="week4end">
												  	</div>
												</div>
										  </div>
									</div>
								</div>
							</div>
							<div class="row" align="center">
								<div class="col">
									<div class="card">
										  <div class="card-body">
										    <h5 class="card-title"><b>Week 5</b></h5>
											  	<div class="row">
													<div class="col-4" align="right">
												  		<p style="padding-top: 20px;">Start</p>
												  	</div>
											  		<div class="col-6">
												  		<input class="form-control" type="text" name="week5start">
												  	</div>
												</div>
												<div class = "row">
													<div class="col-4" align="right">
												  		<p style="padding-top: 20px;">End</p>
												  	</div>
													<div class="col-6">
												  		<input class="form-control" type="text" name="week5end">
												  	</div>
												</div>
										  </div>
									</div>
								</div>
								<div class="col">
									<div class="card">
										  <div class="card-body">
										    <h5 class="card-title"><b>Week 6</b></h5>
											  	<div class="row">
													<div class="col-4" align="right">
												  		<p style="padding-top: 20px;">Start</p>
												  	</div>
											  		<div class="col-6">
												  		<input class="form-control" type="text" name="week6start">
												  	</div>
												</div>
												<div class = "row">
													<div class="col-4" align="right">
												  		<p style="padding-top: 20px;">End</p>
												  	</div>
													<div class="col-6">
												  		<input class="form-control" type="text" name="week6end">
												  	</div>
												</div>
										  </div>
									</div>
								</div>
							</div>
							<div class="row" align="center">
								<div class="col">
									<div class="card">
										  <div class="card-body">
										    <h5 class="card-title"><b>Week 7</b></h5>
											  	<div class="row">
													<div class="col-4" align="right">
												  		<p style="padding-top: 20px;">Start</p>
												  	</div>
											  		<div class="col-6">
												  		<input class="form-control" type="text" name="week7start">
												  	</div>
												</div>
												<div class = "row">
													<div class="col-4" align="right">
												  		<p style="padding-top: 20px;">End</p>
												  	</div>
													<div class="col-6">
												  		<input class="form-control" type="text" name="week7end">
												  	</div>
												</div>
										  </div>
									</div>
								</div>
								<div class="col">
									<div class="card">
										  <div class="card-body">
										    <h5 class="card-title"><b>Week 8</b></h5>
											  	<div class="row">
													<div class="col-4" align="right">
												  		<p style="padding-top: 20px;">Start</p>
												  	</div>
											  		<div class="col-6">
												  		<input class="form-control" type="text" name="week8start">
												  	</div>
												</div>
												<div class = "row">
													<div class="col-4" align="right">
												  		<p style="padding-top: 20px;">End</p>
												  	</div>
													<div class="col-6">
												  		<input class="form-control" type="text" name="week8end">
												  	</div>
												</div>
										  </div>
									</div>
								</div>
							</div>
							<div class="row" align="center">
								<div class="col">
									<div class="card">
										  <div class="card-body">
										    <h5 class="card-title"><b>Other Edits</b></h5>
											  	<div class="row">
													<div class="col-6" align="right">
												  		<p style="padding-top: 20px;">Number of Active Weeks</p>
												  	</div>
											  		<div class="col-4">
												  		<input class="form-control" type="text" name="activeweeks">
												  	</div>
												</div>
												<div class = "row">
													<div class="col-6" align="right">
												  		<p style="padding-top: 20px;">Current Year</p>
												  	</div>
													<div class="col-4">
												  		<input class="form-control" type="text" name="currentyear">
												  	</div>
												</div>
												<div class = "row">
													<div class="col-6" align="right">
												  		<p style="padding-top: 20px;">Holiday week (1-8)</p>
												  	</div>
													<div class="col-4">
												  		<input class="form-control" type="text" name="holidayweek">
												  	</div>
												</div>
										  </div>
									</div>
								</div>
							</div>
							<div class="row margin-data align-items-center" style = "padding-top: 20px;padding-bottom: 70px;">
								<div class="col" align="center">
									<input type="submit" class="btn-xl" align="center" value="Save">
								</div>
							</div>
							</form>
						</div>
				</div>

			<div class="tab">
				<div id="SessionPricing" class="tabcontent">
				  <h3 style="padding: 30px 40px;"><b>Yearly Session Pricing</b></h3>
				  	<form action="editSessionPricing.php" method="post">
					  <hr>
					  <div class="row" align="center">
								<div class="col">
									<div class="card" style="background: #5F5F5F; color: white;">
										  <div class="card-body">
										    <h5 class="card-title"><b>Just In Case: Pricings</b></h5>
											  	<div class="row">
													<div class="col-6" align="right">
												  		<p style="padding-top: 20px;">One Day AM Pricing</p>
												  	</div>
											  		<div class="col-4">
												  		<input class="form-control" type="text" name="onedayam">
												  	</div>
												</div>
												<div class = "row">
													<div class="col-6" align="right">
												  		<p style="padding-top: 20px;">One Day PM Pricing</p>
												  	</div>
													<div class="col-4">
												  		<input class="form-control" type="text" name="onedaypm">
												  	</div>
												</div>
												<div class = "row">
													<div class="col-6" align="right">
												  		<p style="padding-top: 20px;">One Day Full Pricing</p>
												  	</div>
													<div class="col-4">
												  		<input class="form-control" type="text" name="onedayfull">
												  	</div>
												</div>
										  </div>
									</div>
								</div>
							</div>
					  <div class="row" align="center">
								<div class="col">
									<div class="card">
										  <div class="card-body">
										    <h5 class="card-title"><b>Pricing For One Week (Early)</b></h5>
											  	<div class="row">
													<div class="col-6" align="right">
												  		<p style="padding-top: 20px;">AM Early Pricing</p>
												  	</div>
											  		<div class="col-4">
												  		<input class="form-control" type="text" name="oneweekamearly">
												  	</div>
												</div>
												<div class = "row">
													<div class="col-6" align="right">
												  		<p style="padding-top: 20px;">PM Early Pricing</p>
												  	</div>
													<div class="col-4">
												  		<input class="form-control" type="text" name="oneweekpmearly">
												  	</div>
												</div>
												<div class = "row">
													<div class="col-6" align="right">
												  		<p style="padding-top: 20px;">Full Early Pricing</p>
												  	</div>
													<div class="col-4">
												  		<input class="form-control" type="text" name="oneweekfullearly">
												  	</div>
												</div>
										  </div>
									</div>
								</div>
								<div class="col">
									<div class="card">
										  <div class="card-body">
										    <h5 class="card-title"><b>Pricing For One Week (Late)</b></h5>
											  	<div class="row">
													<div class="col-6" align="right">
												  		<p style="padding-top: 20px;">AM Late Pricing</p>
												  	</div>
											  		<div class="col-4">
												  		<input class="form-control" type="text" name="oneweekamlate">
												  	</div>
												</div>
												<div class = "row">
													<div class="col-6" align="right">
												  		<p style="padding-top: 20px;">PM Late Pricing</p>
												  	</div>
													<div class="col-4">
												  		<input class="form-control" type="text" name="oneweekpmlate">
												  	</div>
												</div>
												<div class = "row">
													<div class="col-6" align="right">
												  		<p style="padding-top: 20px;">Full Late Pricing</p>
												  	</div>
													<div class="col-4">
												  		<input class="form-control" type="text" name="oneweekfulllate">
												  	</div>
												</div>
										  </div>
									</div>
								</div>
							</div>
							<div class="row" align="center">
								<div class="col">
									<div class="card">
										  <div class="card-body">
										    <h5 class="card-title"><b>Pricing For Holiday Week (Early)</b></h5>
											  	<div class="row">
													<div class="col-6" align="right">
												  		<p style="padding-top: 20px;">AM Early Pricing</p>
												  	</div>
											  		<div class="col-4">
												  		<input class="form-control" type="text" name="holidayweekamearly">
												  	</div>
												</div>
												<div class = "row">
													<div class="col-6" align="right">
												  		<p style="padding-top: 20px;">PM Early Pricing</p>
												  	</div>
													<div class="col-4">
												  		<input class="form-control" type="text" name="holidayweekpmearly">
												  	</div>
												</div>
												<div class = "row">
													<div class="col-6" align="right">
												  		<p style="padding-top: 20px;">Full Early Pricing</p>
												  	</div>
													<div class="col-4">
												  		<input class="form-control" type="text" name="holidayweekfullearly">
												  	</div>
												</div>
										  </div>
									</div>
								</div>
								<div class="col">
									<div class="card">
										  <div class="card-body">
										    <h5 class="card-title"><b>Pricing For Holiday Week (Late)</b></h5>
											  	<div class="row">
													<div class="col-6" align="right">
												  		<p style="padding-top: 20px;">AM Late Pricing</p>
												  	</div>
											  		<div class="col-4">
												  		<input class="form-control" type="text" name="holidayweekamlate">
												  	</div>
												</div>
												<div class = "row">
													<div class="col-6" align="right">
												  		<p style="padding-top: 20px;">PM Late Pricing</p>
												  	</div>
													<div class="col-4">
												  		<input class="form-control" type="text" name="holidayweekpmlate">
												  	</div>
												</div>
												<div class = "row">
													<div class="col-6" align="right">
												  		<p style="padding-top: 20px;">Full Late Pricing</p>
												  	</div>
													<div class="col-4">
												  		<input class="form-control" type="text" name="holidayweekfulllate">
												  	</div>
												</div>
										  </div>
									</div>
								</div>
							</div>
							<div class="row" align="center">
								<div class="col">
									<div class="card">
										  <div class="card-body">
										    <h5 class="card-title"><b>Other Edits</b></h5>
											  	<div class="row">
													<div class="col-6" align="right">
												  		<p style="padding-top: 20px;">Extended Care Pricing</p>
												  	</div>
											  		<div class="col-4">
												  		<input class="form-control" type="text" name="extendedcare">
												  	</div>
												</div>
												<div class = "row">
													<div class="col-6" align="right">
												  		<p style="padding-top: 20px;">Extra Shirt Pricing</p>
												  	</div>
													<div class="col-4">
												  		<input class="form-control" type="text" name="extrashirt">
												  	</div>
												</div>
										  </div>
									</div>
								</div>
							</div>
							<div class="row margin-data align-items-center" style = "padding-top: 20px;padding-bottom: 70px;">
								<div class="col" align="center">
									<input type="submit" class="btn-xl" align="center" value="Save">
								</div>
							</div>
					</form>
				</div>
			</div>

		</div>
	</div>















    <script type="text/javascript">
    	function openPage(pageName, elmnt, color) {
		  // Hide all elements with class="tabcontent" by default */
		  var i, tabcontent, tablinks;
		  tabcontent = document.getElementsByClassName("tabcontent");
		  for (i = 0; i < tabcontent.length; i++) {
		    tabcontent[i].style.display = "none";
		  }

		  // Remove the background color of all tablinks/buttons
		  tablinks = document.getElementsByClassName("tablink");
		  for (i = 0; i < tablinks.length; i++) {
		    tablinks[i].style.backgroundColor = "";
		  }

		  // Show the specific tab content
		  document.getElementById(pageName).style.display = "block";

		}

		// Get the element with id="defaultOpen" and click on it
		document.getElementById("defaultOpen").click();



    </script>


    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>




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
				Camp Izza is a 501 (c)(3) non-profit organization registered in the state of California with federal tax id #26-2174441
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