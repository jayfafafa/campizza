<?php
session_start();

include ('connection.php');

// Check if the user is already logged in, if yes then redirect him to welcome page
if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true){
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
<html lang="en">

<head>
	<title>Camp Izza | Summer Day Camp | Irvine, CA</title>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fredericka+the+Great">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
	<link rel="stylesheet" href="registrationstyle.css">
	<link rel="stylesheet" href="childdisplay.css">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
	<!-- <script type="text/javascript" src="/delete.js"></script> -->

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
	<div style="background-color: white; padding-left: 40px;padding-right: 40px;padding-bottom: 70px; padding-top: 30px;margin-bottom: 20px; margin-top:20px!important;margin: 20px 20px">
			<div class="row">
					<div class="d-flex top-buffer">
						<h3>Camper Dashboard</h3>
					</div>
					<div class="ml-auto">
						<form action="logout.php" method "post">
							<a class="btn btn-primary top-buffer" href="dashboard.php" role="button">< Back to Dashboard</a>
							<input class="btn btn-danger top-buffer" type="submit" value="Sign Out">
						</form>
					</div>
				</div>
				<div class="row"><p align="center">This page allows you to add, remove, and edit your camper information.</p>
				</div>
				<hr>
				<div class="row">
					<div class="col my-auto" style="padding-bottom: 20px;">
						<a href="./childregistration.php" role="button" class="btn btn-success" >+ Click Here to Add Camper</a>
					</div>        
				</div>
<?php
$parentid=$_SESSION['id'];

$stmt = $conn->query("SELECT childid, parentid, firstname, lastname 
	FROM Children");

$stmtAmount = $conn->query("SELECT * FROM YearlySessionWeeks");
$campInfo = $stmtAmount->fetch(PDO::FETCH_ASSOC);
$activeweeks = $campInfo["activeweeks"];

while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
	$stmtParentInfo = $conn->query("SELECT * FROM Parents WHERE parentid=".$row['parentid']);
	$parentInfo = $stmtParentInfo->fetch(PDO::FETCH_ASSOC);
?>
				<div class="row" style="padding-bottom:50px; margin: auto;">
					    <div class="col">
							<div class="card" style="border-color:black">
								<div class="row">
								<div class="col">
									<h2 style="padding-top: 20px; padding-right:50px; padding-left: 50px"><?php echo $row['firstname'] . " " . $row['lastname'] ?></h2>
								</div>
								<div class="col-8" style="text-align: right;">
									<button style="font-size:15px;margin-top: 25px; margin-right: 10px;margin-left: 40px" onclick="location.href = '/childinformation.php?childid=<?php echo $row['childid'] ?>';" class="btn btn-sm btn-success" style="border-color: gray">Add/Edit Summer Session Schedule</button>
						            <a style="margin-top: 25px; margin-right: 10px;font-size:15px;" href="editchild.php?childid=<?php echo $row['childid']; ?>" role="button" class="btn btn-sm btn-secondary">Edit Camper</a>
						            <button style="font-size:15px;margin-top: 25px; margin-right: 10px" onclick="deleteChildById(<?php echo $row['childid']; ?>)" id="deletecamper" class="btn btn-sm btn-danger">Delete Camper</button>
						        </div>
						        </div>
						        <hr>
								<div class="card-body" style="border-color:black">
					              <div class="d-flex justify-content-between align-items-center">
					              	<a class="card-text"></a>
					              	<div class="col">
					              		<h5 style="margin: auto">Address</h5>
					              		<?php echo $parentInfo['address1'] . "<br>" . $parentInfo['city'] ?>
					              	</div>
					              	<div class="col">
					              		<h5 style="margin: auto" >Guardian 1</h5>
					              		<?php echo $parentInfo['guardiannamefirst1'] . " " . $parentInfo['guardiannamelast1'] . "<br>" . $parentInfo["guardianemail1"] ?>
					              	</div>
					              	<div class="col">
						              	<?php 
						              	if (($parentInfo['guardiannamefirst2'] == "") Or ($parentInfo["guardianemail2"] == ""))
						              	{
						              		echo "";
						              	}
						              	else
						              	{
						              		echo "<h5 style='margin: auto'>Guardian 2</h5>";
						              		echo $parentInfo['guardiannamefirst2'] . " " . $parentInfo['guardiannamelast2'] . "<br>" . $parentInfo["guardianemail2"];
						              	}
						           		?>
					              	</div>
					              	</div>
					              </div>
					            <div style='overflow: auto;' class="card-header" style="border-color:black">
					            	<h5 style="margin: auto">Summer Session Schedule:</h5>
					            	<table class="table table-bordered " style = "background: white; margin:auto">
									  <thead>
									    <tr>
									      <th scope="col"></th>
									      <th scope="col" >Morning: 8:30am-12:00pm</th>
									      <th scope="col">Afternoon: 12:30pm-4:00pm</th>
									      <th scope="col" >Extended Care: 7:00am-8:30am OR 4:00-5:30pm</th>
									    </tr>
									  </thead>
									  <tbody>
<?php
	$stmtDynamic = $conn->query("SELECT ChildrenDynamic.week1am, ChildrenDynamic.week1pm, ChildrenDynamic.week2am, ChildrenDynamic.week2pm, ChildrenDynamic.week3am, ChildrenDynamic.week3pm, ChildrenDynamic.week4am, ChildrenDynamic.week4pm, ChildrenDynamic.week5am, ChildrenDynamic.week5pm, ChildrenDynamic.week6am, ChildrenDynamic.week6pm, ChildrenDynamic.week7am, ChildrenDynamic.week7pm, ChildrenDynamic.week8am, ChildrenDynamic.week8pm, ChildrenDynamic.extendedcare, ChildrenDynamic.price, ChildrenDynamic.credit
	FROM Children, ChildrenDynamic, YearlySessionWeeks
	WHERE Children.childid = ChildrenDynamic.childid AND Children.childid =".$row['childid']." AND ChildrenDynamic.registeredyear = YearlySessionWeeks.currentYear");
	
	$registerInfo = $stmtDynamic->fetch(PDO::FETCH_ASSOC);

	for($x = 1; $x <= $activeweeks; $x++){
		echo '<tr>';
		echo '<th scope="row">Week '.$x.': '.substr($campInfo['week'.$x.'start'], 5,2).'/'.substr($campInfo['week'.$x.'start'], 8,2).'-'
		.substr($campInfo['week'.$x.'end'], 5,2).'/'.substr($campInfo['week'.$x.'end'], 8,2).'</th>';
		if ($registerInfo['week'.$x.'am'] == 1)
			echo '<td style="color: green;">REGISTERED</td>';
		elseif($registerInfo['week'.$x.'am'] == 2)
			echo '<td>WAITLISTED</td>';
		else
			echo '<td style="color: red;">NOT REGISTERED</td>';
		
		if ($registerInfo['week'.$x.'pm'] == 1)
			echo '<td style="color: green;">REGISTERED</td>';
		elseif($registerInfo['week'.$x.'pm'] == 2)
			echo '<td>WAITLISTED</td>';
		else
			echo '<td style="color: red;">NOT REGISTERED</td>';
		
		if ($registerInfo['extendedcare'] == 1 && ($registerInfo['week'.$x.'pm'] == 1 || $registerInfo['week'.$x.'am'] == 1))
			echo '<td style="color: green;">REGISTERED</td>';
		else
			echo '<td style="color: red;">NOT REGISTERED</td>';
		echo '</tr>';

	}

?>
									</tbody>
									</table>
					            </div>
						        <div class="row">
						        	<div class="col-4">
						            <div class="d-flex justify-content-between align-items-center">
						            	<h3 style="padding-left: 20px; margin-top: 20px">Amount Paid: $<?php echo $registerInfo['price']?></h3>
						            </div>
						            <div class="d-flex justify-content-between align-items-center">
						            	<h3 style="padding-left: 20px; margin-bottom: 20px;">Credit: $<?php echo $registerInfo['credit']?></h3><br>
						            </div>
						            </div>
						            <div class="col" style="padding-left: 20px; margin:auto">
						            <div class="row">
						 
						            <form action="erfGenerator.php" method="post" id="erfform">									
										<div class="col-2"></div>
						            	<div class="col">
											<input type="hidden" name="childid" value="<?php echo $row['childid'] ?>">
						            		<!-- <a class="btn btn-primary top-buffer" href="" type="submit" form="erfform" style="margin:auto" role="button">Generate Emergency Form</a> -->
											<input class="btn btn-primary top-buffer" type="submit" style="margin:auto" value="Generate Emergency Form" >
						            	</div>
									</form>
										
										
										
						            <form action="updateAdditionalPaid.php" method="post">
						            	<div class="col-2"></div>
						            	<div class="col">
						            		Update Credit: <input type="number" step="0.01" name="amount">
						            		<input type="hidden" name="childid" value="<?php echo $row['childid'] ?>">
						            		<input type="submit" value="Submit" >
						            	</div>
						            </form>

						            </div>
						            </div>
						            </div>
					            </div>
					        </div>
					    </div>
				</div>
<?php
}
 //end while
?>



	</div>
</div>


<script type='text/javascript'>
	function deleteChildById(idChild) {
		if(window.confirm('Are you sure you want to delete this camper? This cannot be undone.')) {
			window.location ='delete.php?childid='+idChild;
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

<?php
unset($conn);
?>
