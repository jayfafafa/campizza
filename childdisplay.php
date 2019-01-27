<?php
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: dashboard.php");
    exit;


include ('connection.php');

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
						<h3>Child Display</h3>
					</div>
					<div class="ml-auto">
						<input class="btn btn-outline-danger top-buffer" type="submit" value="Sign Out">
					</div>
				</div>
				<div class="row"><p>&nbsp&nbsp&nbsp&nbsp&nbsp&nbspThis page allows you to add, remove, and edit your child information.</p>
				</div>
				<hr>
				<div class="row">
						<div class="col">
					    </div>
						<div class="col-md-4" style="padding-bottom: 20px;">
							<div class="card">
								<div class="card-header">
								    <div style="text-align: center;">
								        <div class="col" style="text-align: center; font-size: 45px;">
										    <img src="download.png" alt="blankimage">
										</div>
								    </div>
								</div>
					            <div class="card-body text-center">
					            	<a type="button" class="btn btn-sm btn-outline-secondary" style="text-align:center;border-color: white">Click Here to Add Child</a>
					            </div>
					        </div>
					    </div>
					    <div class="col">
					    </div>
				</div>
<?php
$parentid=$_SESSION['id'];
$stmt = $conn->query("SELECT Children.firstname, Children.lastname, ChildrenDynamic.week1am, ChildrenDynamic.week1pm, ChildrenDynamic.week2am, ChildrenDynamic.week2pm, ChildrenDynamic.week3am, ChildrenDynamic.week3am, ChildrenDynamic.week4pm, ChildrenDynamic.week4pm, ChildrenDynamic.week5am, ChildrenDynamic.week5pm, ChildrenDynamic.week6am, ChildrenDynamic.week6pm, ChildrenDynamic.week7am, ChildrenDynamic.week7pm, ChildrenDynamic.week8am, ChildrenDynamic.week8pm, ChildrenDynamic.extendedcare 
	FROM Parents, Children, ChildrenDynamic 
	WHERE Parents.parentid = Children.parentid AND Children.childid = ChildrenDynamic.childid AND Parents.parentid=" . $parentid);

$stmtAmount = $conn->query("SELECT activeweeks FROM YearlySessionWeeks");
$row2 = $stmtAmount->fetch(PDO:FETCH_ASSOC);
$activeweeks = $row2["activeweeks"];

while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {

?>
				<div class="row">
					    <div class="col">
							<div class="card">
					            <div class="card-header">
					            	<table class="table table-bordered" style = "background: white;">
									  <thead>
									    <tr>
									      <th scope="col"></th>
									      <th scope="col">AM</th>
									      <th scope="col">PM</th>
									      <th scope="col">Extended</th>
									    </tr>
									  </thead>
									  <tbody>
<?php
	for($x = 1; $x <= $activeweeks; $x++){
		echo '<tr>';
		echo '<th scope="row">Week '.$x.'</th>';
		if ($row['week'.$x.'am'] == 1)
			echo '<td>R</td>';
		elseif($row['week'.$x.'pm'] == 2)
			echo '<td>W</td>';
		else
			echo '<td></td>';
		echo '</tr>';

	}

?>
									</tbody>
									</table>
					            </div>

					            <button type="button" class="btn btn-sm btn-outline-secondary" style="border-color: gray">Edit Schedule</button>
					            <div class="card-body">
					              <div class="d-flex justify-content-between align-items-center">
					              	<p class="card-text"></p>
					              	<h3><?php echo $row['firstname'] . " " . $row["lasstname"] ?></h3>
					                <div class="btn-group">
						                  <button type="button" class="btn btn-sm btn-outline-secondary">Edit </button>
						                  <button type="button" class="btn btn-sm btn-outline-secondary">Delete</button>
					                </div>
					              </div>
					            </div>
					        </div>
					    </div>
				</div>
<?php
} //end while
?>



	</div>
</div>


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