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

$sql = "SELECT * FROM YearlySessionLimits WHERE id=0";
$sql1 = "SELECT * FROM YearlySessionWeeks WHERE id=0";
$sql2 = "SELECT * FROM YearlySessionPricing WHERE id=0";


$stmt = $conn->query($sql);
$stmt1 = $conn->query($sql1);
$stmt2 = $conn->query($sql2);

$limits = $stmt->fetch(PDO::FETCH_ASSOC);
$weeks = $stmt1->fetch(PDO::FETCH_ASSOC);
$price = $stmt2->fetch(PDO::FETCH_ASSOC);
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
	<div class="container" style="background-color: white; padding-left: 40px;padding-right: 40px;padding-bottom: 70px; margin-bottom: 20px; margin-top:20px!important;margin: auto">
		<div class="container">
			<div class="row">
				<div class="d-flex top-buffer">
					<h1><b>Camp Information Editor</b></h1>
				</div>
				<div class="ml-auto" style="padding-top: 20px;">
						<form action="logout.php" method "post">
							<a class="btn btn-primary top-buffer" href="dashboard.php" role="button">< Back to Dashboard</a>
							<input class="btn btn-danger top-buffer" type="submit" value="Sign Out">
						</form>
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
					  		<div class="row" align="center" style="padding-bottom:50px; margin: auto;">
								<div class="col">
									<div class="card" style = "background: white; margin:auto; font-size: 20px">
										  <div class="card-body">
										    <h5 class="card-title"><b>Group 1: Dates</b></h5>
											  	<div class="row">
													<div class="col-4" align="right">
												  		<p style="padding-top: 20px;">AM Limit</p>
												  	</div>
											  		<div class="col-6">
												  		<input class="form-control" type="text" name="dateslimitam" <?php if($limits['dateslimitam'] != NULL){ echo 'value='.$limits['dateslimitam'];}?> >
												  	</div>
												</div>
												<div class = "row">
													<div class="col-4" align="right">
												  		<p style="padding-top: 20px;">PM Limit</p>
												  	</div>
													<div class="col-6">
												  		<input class="form-control" type="text" name="dateslimitpm" <?php if($limits['dateslimitpm'] != NULL){ echo 'value='.$limits['dateslimitpm'];}?>>
												  	</div>
												</div>
										  </div>
									</div>
								</div>
								<div class="col">
									<div class="card" style = "background: white; margin:auto; font-size: 20px">
										  <div class="card-body">
										    <h5 class="card-title"><b>Group 2: Coconuts</b></h5>
											  	<div class="row">
													<div class="col-4" align="right">
												  		<p style="padding-top: 20px;">AM Limit</p>
												  	</div>
											  		<div class="col-6">
												  		<input class="form-control" type="text" name="coconutslimitam"<?php if($limits['coconutslimitam'] != NULL){ echo 'value='.$limits['coconutslimitam'];}?> >
												  	</div>
												</div>
												<div class = "row">
													<div class="col-4" align="right">
												  		<p style="padding-top: 20px;">PM Limit</p>
												  	</div>
													<div class="col-6">
												  		<input class="form-control" type="text" name="coconutslimitpm" <?php if($limits['coconutslimitpm'] != NULL){ echo 'value='.$limits['coconutslimitpm'];}?> >
												  	</div>
												</div>
										  </div>
									</div>
								</div>
							</div>
							<div class="row" align="center">
								<div class="col">
									<div class="card" style = "background: white; margin:auto; font-size: 20px">
										  <div class="card-body">
										    <h5 class="card-title"><b>Group 3: Trees</b></h5>
											  	<div class="row">
													<div class="col-4" align="right">
												  		<p style="padding-top: 20px;">AM Limit</p>
												  	</div>
											  		<div class="col-6">
												  		<input class="form-control" type="text" name="treeslimitam" <?php if($limits['treeslimitam'] != NULL){ echo 'value='.$limits['treeslimitam'];}?> >
												  	</div>
												</div>
												<div class = "row">
													<div class="col-4" align="right">
												  		<p style="padding-top: 20px;">PM Limit</p>
												  	</div>
													<div class="col-6">
												  		<input class="form-control" type="text" name="treeslimitpm" <?php if($limits['treeslimitpm'] != NULL){ echo 'value='.$limits['treeslimitpm'];}?> >
												  	</div>
												</div>
										  </div>
									</div>
								</div>
								<div class="col">
									<div class="card" style = "background: white; margin:auto; font-size: 20px">
										  <div class="card-body">
										    <h5 class="card-title"><b>Group 4: Young Leaders</b></h5>
											  	<div class="row">
													<div class="col-4" align="right">
												  		<p style="padding-top: 20px;">AM Limit</p>
												  	</div>
											  		<div class="col-6">
												  		<input class="form-control" type="text" name="youngleaderslimitam" <?php if($limits['youngleaderslimitam'] != NULL){ echo 'value='.$limits['youngleaderslimitam'];}?> >
												  	</div>
												</div>
												<div class = "row">
													<div class="col-4" align="right">
												  		<p style="padding-top: 20px;">PM Limit</p>
												  	</div>
													<div class="col-6">
												  		<input class="form-control" type="text" name="youngleaderslimitpm" <?php if($limits['youngleaderslimitpm'] != NULL){ echo 'value='.$limits['youngleaderslimitpm'];}?> >
												  	</div>
												</div>
										  </div>
									</div>
								</div>
							</div>
					    <div class="row margin-data align-items-center" style = "font-size:20px; padding-top: 20px;padding-bottom: 70px;">
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
									<div class="card" style = "background: white; margin:auto; font-size: 15px">
										  <div class="card-body">
										    <h5 class="card-title"><b>Week 1</b></h5>
											  	<div class="row">
													<div class="col-4" align="right">
												  		<p style="padding-top: 20px;">Start</p>
												  	</div>
											  		<div class="col-7">
												  		<input class="form-control" type="text" name="week1start" <?php if($weeks['week1start'] != NULL){ echo 'value='.$weeks['week1start'];}?> >
												  	</div>
												</div>
												<div class = "row">
													<div class="col-4" align="right">
												  		<p style="padding-top: 20px;">End</p>
												  	</div>
													<div class="col-7">
												  		<input class="form-control" type="text" name="week1end" <?php if($weeks['week1end'] != NULL){ echo 'value='.$weeks['week1end'];}?> >
												  	</div>
												</div>
										  </div>
									</div>
								</div>
								<div class="col">
									<div class="card" style = "background: white; margin:auto; font-size: 15px">
										  <div class="card-body">
										    <h5 class="card-title"><b>Week 2</b></h5>
											  	<div class="row">
													<div class="col-4" align="right">
												  		<p style="padding-top: 20px;">Start</p>
												  	</div>
											  		<div class="col-7">
												  		<input class="form-control" type="text" name="week2start" <?php if($weeks['week2start'] != NULL){ echo 'value='.$weeks['week2start'];}?> >
												  	</div>
												</div>
												<div class = "row">
													<div class="col-4" align="right">
												  		<p style="padding-top: 20px;">End</p>
												  	</div>
													<div class="col-7">
												  		<input class="form-control" type="text" name="week2end" <?php if($weeks['week2end'] != NULL){ echo 'value='.$weeks['week2end'];}?> >
												  	</div>
												</div>
										  </div>
									</div>
								</div>
							</div>
							<div class="row" align="center">
								<div class="col">
									<div class="card" style = "background: white; margin:auto; font-size: 15px">
										  <div class="card-body">
										    <h5 class="card-title"><b>Week 3</b></h5>
											  	<div class="row">
													<div class="col-4" align="right">
												  		<p style="padding-top: 20px;">Start</p>
												  	</div>
											  		<div class="col-7">
												  		<input class="form-control" type="text" name="week3start" <?php if($weeks['week3start'] != NULL){ echo 'value='.$weeks['week3start'];}?> >
												  	</div>
												</div>
												<div class = "row">
													<div class="col-4" align="right">
												  		<p style="padding-top: 20px;">End</p>
												  	</div>
													<div class="col-7">
												  		<input class="form-control" type="text" name="week3end" <?php if($weeks['week3end'] != NULL){ echo 'value='.$weeks['week3end'];}?> >
												  	</div>
												</div>
										  </div>
									</div>
								</div>
								<div class="col">
									<div class="card" style = "background: white; margin:auto; font-size: 15px">
										  <div class="card-body">
										    <h5 class="card-title"><b>Week 4</b></h5>
											  	<div class="row">
													<div class="col-4" align="right">
												  		<p style="padding-top: 20px;">Start</p>
												  	</div>
											  		<div class="col-7">
												  		<input class="form-control" type="text" name="week4start" <?php if($weeks['week4start'] != NULL){ echo 'value='.$weeks['week4start'];}?> >
												  	</div>
												</div>
												<div class = "row">
													<div class="col-4" align="right">
												  		<p style="padding-top: 20px;">End</p>
												  	</div>
													<div class="col-7">
												  		<input class="form-control" type="text" name="week4end" <?php if($weeks['week4end'] != NULL){ echo 'value='.$weeks['week4end'];}?> >
												  	</div>
												</div>
										  </div>
									</div>
								</div>
							</div>
							<div class="row" align="center">
								<div class="col">
									<div class="card" style = "background: white; margin:auto; font-size: 15px">
										  <div class="card-body">
										    <h5 class="card-title"><b>Week 5</b></h5>
											  	<div class="row">
													<div class="col-4" align="right">
												  		<p style="padding-top: 20px;">Start</p>
												  	</div>
											  		<div class="col-7">
												  		<input class="form-control" type="text" name="week5start" <?php if($weeks['week5start'] != NULL){ echo 'value='.$weeks['week5start'];}?> >
												  	</div>
												</div>
												<div class = "row">
													<div class="col-4" align="right">
												  		<p style="padding-top: 20px;">End</p>
												  	</div>
													<div class="col-7">
												  		<input class="form-control" type="text" name="week5end" <?php if($weeks['week5end'] != NULL){ echo 'value='.$weeks['week5end'];}?> >
												  	</div>
												</div>
										  </div>
									</div>
								</div>
								<div class="col">
									<div class="card" style = "background: white; margin:auto; font-size: 15px">
										  <div class="card-body">
										    <h5 class="card-title"><b>Week 6</b></h5>
											  	<div class="row">
													<div class="col-4" align="right">
												  		<p style="padding-top: 20px;">Start</p>
												  	</div>
											  		<div class="col-7">
												  		<input class="form-control" type="text" name="week6start" <?php if($weeks['week6start'] != NULL){ echo 'value='.$weeks['week6start'];}?> >
												  	</div>
												</div>
												<div class = "row">
													<div class="col-4" align="right">
												  		<p style="padding-top: 20px;">End</p>
												  	</div>
													<div class="col-7">
												  		<input class="form-control" type="text" name="week6end" <?php if($weeks['week6end'] != NULL){ echo 'value='.$weeks['week6end'];}?> >
												  	</div>
												</div>
										  </div>
									</div>
								</div>
							</div>
							<div class="row" align="center">
								<div class="col">
									<div class="card" style = "background: white; margin:auto; font-size: 15px">
										  <div class="card-body">
										    <h5 class="card-title"><b>Week 7</b></h5>
											  	<div class="row">
													<div class="col-4" align="right">
												  		<p style="padding-top: 20px;">Start</p>
												  	</div>
											  		<div class="col-7">
												  		<input class="form-control" type="text" name="week7start" <?php if($weeks['week7start'] != NULL){ echo 'value='.$weeks['week7start'];}?> >
												  	</div>
												</div>
												<div class = "row">
													<div class="col-4" align="right">
												  		<p style="padding-top: 20px;">End</p>
												  	</div>
													<div class="col-7">
												  		<input class="form-control" type="text" name="week7end" <?php if($weeks['week7end'] != NULL){ echo 'value='.$weeks['week7end'];}?> >
												  	</div>
												</div>
										  </div>
									</div>
								</div>
								<div class="col">
									<div class="card" style = "background: white; margin:auto; font-size: 15px">
										  <div class="card-body">
										    <h5 class="card-title"><b>Week 8</b></h5>
											  	<div class="row">
													<div class="col-4" align="right">
												  		<p style="padding-top: 20px;">Start</p>
												  	</div>
											  		<div class="col-7">
												  		<input class="form-control" type="text" name="week8start" <?php if($weeks['week8start'] != NULL){ echo 'value='.$weeks['week8start'];}?> >
												  	</div>
												</div>
												<div class = "row">
													<div class="col-4" align="right">
												  		<p style="padding-top: 20px;">End</p>
												  	</div>
													<div class="col-7">
												  		<input class="form-control" type="text" name="week8end" <?php if($weeks['week8end'] != NULL){ echo 'value='.$weeks['week8end'];}?> >
												  	</div>
												</div>
										  </div>
									</div>
								</div>
							</div>
							<div class="row" align="center">
								<div class="col">
									<div class="card" style = "background: white; margin:auto; font-size: 15px;">
										  <div class="card-body">
										    <h5 class="card-title"><b>Other Edits</b></h5>
											  	<div class="row">
													<div class="col-6" align="right">
												  		<p style="padding-top: 20px;">Number of Active Weeks</p>
												  	</div>
											  		<div class="col-4">
												  		<input class="form-control" type="text" name="activeweeks" <?php if($weeks['activeweeks'] != NULL){ echo 'value='.$weeks['activeweeks'];}?> >
												  	</div>
												</div>
												<div class = "row">
													<div class="col-6" align="right">
												  		<p style="padding-top: 20px;">Current Year</p>
												  	</div>
													<div class="col-4">
												  		<input class="form-control" type="text" name="currentyear" <?php if($weeks['currentyear'] != NULL){ echo 'value='.$weeks['currentyear'];}?> >
												  	</div>
												</div>
												<div class = "row">
													<div class="col-6" align="right">
												  		<p style="padding-top: 20px;">Holiday week (1-8)</p>
												  	</div>
													<div class="col-4">
												  		<input class="form-control" type="text" name="holidayweek" <?php if($weeks['holidayweek'] != NULL){ echo 'value='.$weeks['holidayweek'];}?> >
												  	</div>
												</div>
										  </div>
									</div>
								</div>
							</div>
							<div class="row margin-data align-items-center" style = "font-size:20px;padding-top: 20px;padding-bottom: 70px;">
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
									<div class="card" style="background: #5F5F5F; color: white; margin:auto; font-size: 15px;">
										  <div class="card-body">
										    <h5 class="card-title"><b>Just In Case: Pricings</b></h5>
											  	<div class="row">
													<div class="col-5" align="right">
												  		<p style="padding-top: 20px;">One Day AM Pricing</p>
												  	</div>
											  		<div class="col-7">
												  		<input class="form-control" type="text" name="onedayam"  <?php if($price['onedayam'] != NULL){ echo 'value='.$price['onedayam'];}?> >
												  	</div>
												</div>
												<div class = "row">
													<div class="col-5" align="right">
												  		<p style="padding-top: 20px;">One Day PM Pricing</p>
												  	</div>
													<div class="col-7">
												  		<input class="form-control" type="text" name="onedaypm"  <?php if($price['onedaypm'] != NULL){ echo 'value='.$price['onedaypm'];}?> >
												  	</div>
												</div>
												<div class = "row">
													<div class="col-5" align="right">
												  		<p style="padding-top: 20px;">One Day Full Pricing</p>
												  	</div>
													<div class="col-7">
												  		<input class="form-control" type="text" name="onedayfull"  <?php if($price['onedayfull'] != NULL){ echo 'value='.$price['onedayfull'];}?> >
												  	</div>
												</div>
										  </div>
									</div>
								</div>
							</div>
					  <div class="row" align="center">
								<div class="col">
									<div class="card" style = "background: white; margin:auto; font-size: 15px">
										  <div class="card-body">
										    <h5 class="card-title"><b>Pricing For One Week (Early)</b></h5>
											  	<div class="row">
													<div class="col-5" align="right">
												  		<p style="padding-top: 20px;">AM Early Pricing</p>
												  	</div>
											  		<div class="col-7">
												  		<input class="form-control" type="text" name="oneweekamearly" <?php if($price['oneweekamearly'] != NULL){ echo 'value='.$price['oneweekamearly'];}?> >
												  	</div>
												</div>
												<div class = "row">
													<div class="col-5" align="right">
												  		<p style="padding-top: 20px;">PM Early Pricing</p>
												  	</div>
													<div class="col-7">
												  		<input class="form-control" type="text" name="oneweekpmearly" <?php if($price['oneweekpmearly'] != NULL){ echo 'value='.$price['oneweekpmearly'];}?> >
												  	</div>
												</div>
												<div class = "row">
													<div class="col-5" align="right">
												  		<p style="padding-top: 20px;">Full Early Pricing</p>
												  	</div>
													<div class="col-7">
												  		<input class="form-control" type="text" name="oneweekfullearly" <?php if($price['oneweekfullearly'] != NULL){ echo 'value='.$price['oneweekfullearly'];}?> >
												  	</div>
												</div>
										  </div>
									</div>
								</div>
								<div class="col">
									<div class="card" style = "background: white; margin:auto; font-size: 15px">
										  <div class="card-body">
										    <h5 class="card-title"><b>Pricing For One Week (Late)</b></h5>
											  	<div class="row">
													<div class="col-5" align="right">
												  		<p style="padding-top: 20px;">AM Late Pricing</p>
												  	</div>
											  		<div class="col-7">
												  		<input class="form-control" type="text" name="oneweekamlate" <?php if($price['oneweekamlate'] != NULL){ echo 'value='.$price['oneweekamlate'];}?> >
												  	</div>
												</div>
												<div class = "row">
													<div class="col-5" align="right">
												  		<p style="padding-top: 20px;">PM Late Pricing</p>
												  	</div>
													<div class="col-7">
												  		<input class="form-control" type="text" name="oneweekpmlate" <?php if($price['oneweekpmlate'] != NULL){ echo 'value='.$price['oneweekpmlate'];}?> >
												  	</div>
												</div>
												<div class = "row">
													<div class="col-5" align="right">
												  		<p style="padding-top: 20px;">Full Late Pricing</p>
												  	</div>
													<div class="col-7">
												  		<input class="form-control" type="text" name="oneweekfulllate" <?php if($price['oneweekfulllate'] != NULL){ echo 'value='.$price['oneweekfulllate'];}?> >
												  	</div>
												</div>
										  </div>
									</div>
								</div>
							</div>
							<div class="row" align="center">
								<div class="col">
									<div class="card" style = "background: white; margin:auto; font-size: 15px">
										  <div class="card-body">
										    <h5 class="card-title"><b>Pricing For Holiday Week (Early)</b></h5>
											  	<div class="row">
													<div class="col-5" align="right">
												  		<p style="padding-top: 20px;">AM Early Pricing</p>
												  	</div>
											  		<div class="col-7">
												  		<input class="form-control" type="text" name="holidayweekamearly" <?php if($price['holidayweekamearly'] != NULL){ echo 'value='.$price['holidayweekamearly'];}?> >
												  	</div>
												</div>
												<div class = "row">
													<div class="col-5" align="right">
												  		<p style="padding-top: 20px;">PM Early Pricing</p>
												  	</div>
													<div class="col-7">
												  		<input class="form-control" type="text" name="holidayweekpmearly" <?php if($price['holidayweekpmearly'] != NULL){ echo 'value='.$price['holidayweekpmearly'];}?> >
												  	</div>
												</div>
												<div class = "row">
													<div class="col-5" align="right">
												  		<p style="padding-top: 20px;">Full Early Pricing</p>
												  	</div>
													<div class="col-7">
												  		<input class="form-control" type="text" name="holidayweekfullearly" <?php if($price['holidayweekfullearly'] != NULL){ echo 'value='.$price['holidayweekfullearly'];}?> >
												  	</div>
												</div>
										  </div>
									</div>
								</div>
								<div class="col">
									<div class="card" style = "background: white; margin:auto; font-size: 15px">
										  <div class="card-body">
										    <h5 class="card-title"><b>Pricing For Holiday Week (Late)</b></h5>
											  	<div class="row">
													<div class="col-5" align="right">
												  		<p style="padding-top: 20px;">AM Late Pricing</p>
												  	</div>
											  		<div class="col-7">
												  		<input class="form-control" type="text" name="holidayweekamlate" <?php if($price['holidayweekamlate'] != NULL){ echo 'value='.$price['holidayweekamlate'];}?> >
												  	</div>
												</div>
												<div class = "row">
													<div class="col-5" align="right">
												  		<p style="padding-top: 20px;">PM Late Pricing</p>
												  	</div>
													<div class="col-7">
												  		<input class="form-control" type="text" name="holidayweekpmlate" <?php if($price['holidayweekpmlate'] != NULL){ echo 'value='.$price['holidayweekpmlate'];}?> >
												  	</div>
												</div>
												<div class = "row">
													<div class="col-5" align="right">
												  		<p style="padding-top: 20px;">Full Late Pricing</p>
												  	</div>
													<div class="col-7">
												  		<input class="form-control" type="text" name="holidayweekfulllate" <?php if($price['holidayweekfulllate'] != NULL){ echo 'value='.$price['holidayweekfulllate'];}?> >
												  	</div>
												</div>
										  </div>
									</div>
								</div>
							</div>
							<div class="row" align="center">
								<div class="col">
									<div class="card" style = "background: white; margin:auto; font-size: 15px">
										  <div class="card-body">
										    <h5 class="card-title"><b>Other Edits</b></h5>
											  	<div class="row">
													<div class="col-5" align="right">
												  		<p style="padding-top: 20px;">Extended Care Pricing</p>
												  	</div>
											  		<div class="col-7">
												  		<input class="form-control" type="text" name="extendedcare" <?php if($price['extendedcare'] != NULL){ echo 'value='.$price['extendedcare'];}?> >
												  	</div>
												</div>
												<div class = "row">
													<div class="col-5" align="right">
												  		<p style="padding-top: 20px;">Extra Shirt Pricing</p>
												  	</div>
													<div class="col-7">
												  		<input class="form-control" type="text" name="extrashirt" <?php if($price['extrashirt'] != NULL){ echo 'value='.$price['extrashirt'];}?> >
												  	</div>
												</div>
										  </div>
									</div>
								</div>
							</div>
							<div class="row margin-data align-items-center" style = "font-size:20px;padding-top: 20px;padding-bottom: 70px;">
								<div class="col" align="center">
									<input type="submit" class="btn-xl" align="center" value="Save">
								</div>
							</div>
					</form>
				</div>
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