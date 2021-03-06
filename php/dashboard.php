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
if($row['auth'] == 1){
    header('location: admindashboard.php');
}

// Require https
if ($_SERVER['HTTPS'] != "on") {
    $url = "https://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    header("Location: $url");
    exit;
}

?>
<html lang="en">

<head>
	<title>Camp Izza | Summer Day Camp | Irvine, CA</title>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!--
	Icons made by Payungkead (https://www.flaticon.com/packs/interface-button-6) from Flaticon (https://www.flaticon.com/) is licensed by Creative Commons BY 3.0 (http://creativecommons.org/licenses/by/3.0/)
	-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fredericka+the+Great">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
	<link rel="stylesheet" href="registrationstyle.css">

</head>

<body class="dashboardbg">

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
<form action="logout.php" method "post">
	<div class="container">
		<div class="row">
			<div class="d-flex top-buffer">
				<h1> Welcome to your dashboard!</h1>
			</div>
			<div class="ml-auto">
				<a class="btn btn-warning top-buffer" href="changepassword.php" role="button">Change Password</a>
				<input class="btn btn-danger top-buffer" type="submit" value="Sign Out">
			</div>
		</div>
		<hr>
	</div>
</form>
	
	<div class="container">
		<div class="row no-gutters">
			<div class="col">
				<div class="card border-info mb-3 mx-auto" style="width: 150px; height: 256px;">
					<a class="cardlink" href="./childdisplay.php"></a>
					<img src="027-profile.png" class="card-img-top" alt="...">
					<div class="card-body">
						<h5 class="card-title">Manage Campers</h5>
						<p class="card-text"></p>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="card border-info mb-3 mx-auto" style="width: 150px; height: 256px;">
				<a class="cardlink" href="./editparent.php"></a>
					<img src="026-pencil.png" class="card-img-top" alt="...">
					<div class="card-body">
						<h5 class="card-title">Edit Profile</h5>
						<p class="card-text"></p>
					</div>
				</div>
			</div>
		</div>
	</div>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

	<div class="footer">
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