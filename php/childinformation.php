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


if($_SERVER["REQUEST_METHOD"] == "POST"){
	$_SESSION['childid'] = $_POST['childid'];
	
	$stmtAmount = $conn->query("SELECT currentyear FROM YearlySessionWeeks");
	$row2 = $stmtAmount->fetch(PDO::FETCH_ASSOC);
	$registeredyear = $row2["currentyear"];
	
	$sql = "UPDATE Children SET school=:school, grade=:grade, shirtsize=:shirtsize, numshirts=:numshirts " 
		."WHERE childid=".$_POST["childid"];
	
	$stmt = $conn->prepare($sql);
	$stmt->execute(array(
				':school' => $_POST['school'],
				':grade' => $_POST['grade'],
				':shirtsize' => $_POST['shirtsize'],
				':numshirts' => $_POST['numshirts']
				));
				
	
	$sql = "UPDATE ChildrenDynamic SET grade=:grade WHERE childid=".$_POST["childid"];
		
		if($stmt = $conn->prepare($sql)){
			try{
				if($stmt->execute(array(
					':grade' => $_POST['grade']
					))
					){
					//after successful insertion redirect to childdisplay.php
					unset($conn);
					header("location: camperregschedule.php");
					}
			} catch(PDOException $exception){
					if($exception->getCode() == 23000) {
						$sql = "UPDATE ChildrenDynamic SET grade=:grade";
						$stmt = $conn->prepare($sql);
						$stmt->execute(array(
								':grade' => $_POST['grade']
						));
						unset($conn);
						header("location: camperregschedule.php");
					}
					else {echo $exception->getcode();}
			}
		} else {
				echo "oops something went wrong";
		}
}
	
if($_SERVER["REQUEST_METHOD"] == "GET"){
	$childid = $_GET['childid'];

	$sql = "SELECT * FROM Children WHERE childid=".$_GET['childid'];

	$stmt = $conn->query($sql);
	$child = $stmt->fetch(PDO::FETCH_ASSOC);
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
	<link rel="stylesheet" href="childinformation.css">
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
<div class="container" style = "background: white; margin-top: 20px">
    <h1 style = "padding-top: 40px;text-align: center;">Camper Information</h1>
  	<div class="container" style="padding-bottom: 10px">
  		<!--Camper Information-->
  		<div class="row margin-data">
  			<div class="col">
	  				<span class="input-group-text"><p style = "font-family:times; font-size:25px;padding-top: 10px;">Camper Information</p></span>
	  		</div>
	  	</div>
  		<!--Camper School-->
  		<!--Camper Grade-->
  		<div class="row initial-task-padding">
	  		<div class="col">
	  			<p>Current School:<b style = "color: #DC143C;">*</b></p>
	  		</div>
		</div>
		<div class="row no-task-padding">
	  		<div class="col">
				<input name="school" type="text" times-label="CCI" class="form-control" <?php if($child['school'] != NULL){ echo 'value="'.$child['school'].'"';}?> required>
			</div>
		</div>

		<div class="row initial-task-padding">
	  		<div class="col">
	  			<p>Grade in Fall:<b style = "color: #DC143C;">*</b></p>
	  		</div>
		</div>
		<div class="row no-task-padding">
			<div class="col">
				<select name="grade" class="form-control form-control-md" required>
					  <option>K</option>
					  <option>1</option>
					  <option>2</option>
					  <option>3</option>
					  <option>4</option>
					  <option>5</option>
					  <option>6</option>
					  <option>7</option>
					  <option>8</option>
				</select>
			</div>
		</div>

  		<!--Camper T-Shirt Size-->
  		<!--Camper T-Shirt Number-->
  		<div class="row initial-task-padding">
	  		<div class="col">
	  			<p>T-Shirt Size:<b style = "color: #DC143C;">*</b></p>
	  		</div>
		</div>
		<div class="row no-task-padding">
	  		<div class="col">
	  			<select name="shirtsize" class="form-control form-control-md" required>
					  <option value="xs">Child X-Small(4-5)</option>
					  <option value="s">Child Small(5-6)</option>
					  <option value="m">Child Medium(7-8)</option>
					  <option value="lg">Child X-Large(9-10)</option>
					  <option value="xl">Child X-Large(11-12)</option>
				</select>
			</div>
		</div>

		<div class="row initial-task-padding">
	  		<div class="col">
	  			<p># of T-Shirts:<b style = "color: #DC143C;">*</b></p>
	  		</div>
		</div>
		<div class="row no-task-padding">
			<div class="col">
				<select name="numshirts" class="form-control form-control-md" required>
					  <option value=1>1 T-Shirt: Free</option>
					  <option value=2>2 T-Shirts: $15</option>
					  <option value=3>3 T-Shirts: $30</option>
					  <option value=4>4 T-Shirts: $45</option>
					  <option value=5>5 T-Shirts: $60</option>
				</select>
			</div>
		</div>

	<div class="row margin-data" style = "padding-bottom: 30px;" align="center">
		<div class="col">
			<input type="submit" class="btn-xl" align="center" value="Next">
		</div>
	</div>
	</div>
	<input name="childid" type="hidden" value="<?php echo $_GET["childid"]; ?>">
	</form>


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

	<!--Javascript here-->
	<script type="text/javascript">

		$(".dropdown-menu a").click(function() {
		  $(this).parents(".dropdown").find('.btn').html($(this).text());
		  $(this).parents(".dropdown").find('.btn').val($(this).data('value'));
		});

	</script>

</body>

</html>