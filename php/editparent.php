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

include('connection.php');

if($_SERVER["REQUEST_METHOD"] == "POST") {
	$sql = "UPDATE Parents SET guardiannamefirst1=:guardiannamefirst1,"
		."guardiannamelast1=:guardiannamelast1, guardiannamefirst2=:guardiannamefirst2, guardiannamelast2=:guardiannamelast2, address1=:address1, address2=:address2,"
		."country=:country, city=:city, "
		."state=:state, zippostalcode=:zippostalcode, guardianemail1=:guardianemail1, guardianemail2=:guardianemail2, guardian1phone1=:guardian1phone1, guardian1phone2=:guardian1phone2,"
		."guardian2phone1=:guardian2phone1, guardian2phone2=:guardian2phone2, emergencynamefirst1=:emergencynamefirst1, emergencynamelast1=:emergencynamelast1,"
		."emergencyrelationship1=:emergencyrelationship1, emergencyphone1=:emergencyphone1, emergencyauthorized1=:emergencyauthorized1, "
		."emergencynamefirst2=:emergencynamefirst2, emergencynamelast2=:emergencynamelast2, emergencyrelationship2=:emergencyrelationship2, emergencyphone2=:emergencyphone2, "
		."emergencyauthorized2=:emergencyauthorized2 WHERE parentid=".$_SESSION['id'];
		
		
		
		
		
		
		$emergencyauthorized1 = 0;
		$emergencyauthorized2 = 0;
		
		if(isset($_POST['emergencyauthorized1'])){
			$emergencyauthorized1 = $_POST['emergencyauthorized1'];
		}
		
		if(isset($_POST['emergencyauthorized2'])){
			$emergencyauthorized2 = $_POST['emergencyauthorized2'];
		}
		
		
		
		$data = [
		':guardiannamefirst1' => $_POST['guardiannamefirst1'],
		':guardiannamelast1' => $_POST['guardiannamelast1'],
		':guardiannamefirst2' => $_POST['guardiannamefirst2'],
		':guardiannamelast2' => $_POST['guardiannamelast2'],
		':address1' => $_POST['address1'],
		':address2' => $_POST['address2'],
		':country' => $_POST['country'],
		':city' => $_POST['city'],
		':state' => $_POST['state'],
		':zippostalcode' => $_POST['zippostalcode'],
		':guardianemail1' => $_POST['email1'],
		':guardianemail2' => $_POST['email2'],
		':guardian1phone1' => $_POST['guardianphone1'],
		':guardian1phone2' => $_POST['guardianphone2'],
		':guardian2phone1' => $_POST['phone3'],
		':guardian2phone2' => $_POST['phone4'],
		':emergencynamefirst1' => $_POST['emergencynamefirst1'],
		':emergencynamelast1' => $_POST['emergencynamelast1'],
		':emergencyrelationship1' => $_POST['emergencyrelationship1'],
		':emergencyphone1' => $_POST['emergencyphone1'],
		':emergencyauthorized1' => $emergencyauthorized1,
		':emergencynamefirst2' => $_POST['emergencynamefirst2'],
		':emergencynamelast2' => $_POST['emergencynamelast2'],
		':emergencyrelationship2' => $_POST['emergencyrelationship2'],
		':emergencyphone2' => $_POST['emergencyphone2'],
		':emergencyauthorized2' => $emergencyauthorized2
	];
		
	if($stmt = $conn->prepare($sql)){
		if($stmt->execute($data)){
			header("location: dashboard.php");
		}
	else{
		echo 'something went wrong';
	}
		
	}
unset($conn);
}

$sql = "SELECT * FROM Parents WHERE parentid=".$_SESSION['id'];

$stmt = $conn->query($sql);
$parent = $stmt->fetch(PDO::FETCH_ASSOC);
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


<form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
	<!-- Html Lookout -->
<div class="container" style = "background: white; margin-top: 20px;">

    <h1 style = "padding-top: 40px;text-align: center;">Registration for Camp Izza</h1>
    <div class="ml-auto">
		<a class="btn btn-primary top-buffer" href="dashboard.php" role="button">< Back to Dashboard</a>
							
	</div>

  	<div class="container">


  	<!-- Login Info Top Part -->
		<!--<div class="row margin-data">
  			<div class="col">
	  				<span class="input-group-text"><p style = "font-family:courier new; font-size:25px;padding-top: 10px;">Login Information</p></span>
  			</div>
  		</div> -->
		<!-- Password for Login -->
			<!-- <div class="row initial-task-padding">
				<div class="col">
			    	<p>Password:</p>
			    </div>
			</div>

			<div class="row no-task-padding">
				<div class="col">
				    <input name="password" type="text" times-label="password" class="form-control" required>
				</div>

			</div> -->
		<!-- Password Confirmation for Login -->
		<!-- 			<div class="row initial-task-padding">
				<div class="col">
			    	<p>Confirm Password:</p>
			    </div>
			</div>

			<div class="row no-task-padding">
				<div class="col">
				    <input name="secondPassword" type="text" times-label="password" class="form-control" required>
				</div>

			</div> -->
  	<!-- Guardian Top Part -->
  		<div class="row margin-data">
  			<div class="col">
	  				<span class="input-group-text"><p style = "font-family:times; font-size:25px;padding-top: 10px;">Primary Guardian</p></span>
  			</div>
  		</div>
	  	<!-- First and Last Name of Guardian-->
	  		<div class="row initial-task-padding">
		  		<div class="col">
		  			<p>First Name:<b style = "color: #DC143C;">*</b></p>
		  		</div>
	  		</div>
	  		<div class="row no-task-padding">
		  		<div class="col">
					<input name="guardiannamefirst1" type="text" times-label="First Name" class="form-control" <?php if($parent['guardiannamefirst1'] != NULL){ echo 'value='.$parent['guardiannamefirst1'];}?> required>
				</div>
			</div>

			<div class="row task-padding">
				<div class="col">
					<p>Last Name:<b style = "color: #DC143C;">*</b></p>
				</div>
	  		</div>
	  		<div class="row no-task-padding">
				<div class="col">
					<input name="guardiannamelast1" type="text" times-label="Last Name" class="form-control" <?php if($parent['guardiannamelast1'] != NULL){ echo 'value='.$parent['guardiannamelast1'];}?> required>
				</div>
			</div>
		<!-- Email and Phone number of Guardian-->
			<div class="row task-padding">
				<div class="col">
			    	<p>Email address:<b style = "color: #DC143C;">*</b></p>
			    </div>
			</div>

			<div class="row no-task-padding">
				<div class="col">
				    <input name="email1" type="email" times-label="Email address" class="form-control" <?php if($parent['guardianemail1'] != NULL){ echo 'value='.$parent['guardianemail1'];}?> required>
				</div>

			</div>


			<div class="row task-padding">
				<div class="col">
			    	<p>Phone Number 1: (e.g 1234567890)<b style = "color: #DC143C;">*</b></p>
			    </div>
			</div>

			<div class="row no-task-padding">
				<div class="col">
					<div class="input-group mb-3">
					  <input name="guardianphone1" type="tel" pattern="[0-9]{3}[0-9]{3}[0-9]{4}" class="form-control" aria-label="Text input with segmented dropdown button" <?php if($parent['guardian1phone1'] != NULL){ echo 'value='.$parent['guardian1phone1'];}?> required>
					</div>
				</div>
			</div>
			
			<div class="row task-padding">
				<div class="col">
			    	<p>Phone Number 2: (e.g 1234567890)<b style = "color: #DC143C;">*</b></p>
			    </div>
			</div>

			<div class="row no-task-padding">
				<div class="col">
					<div class="input-group mb-3">
					  <input name="guardianphone2" type="tel" pattern="[0-9]{3}[0-9]{3}[0-9]{4}" class="form-control" aria-label="Text input with segmented dropdown button" <?php if($parent['guardian1phone2'] != NULL){ echo 'value='.$parent['guardian1phone2'];}?> required>
					</div>
				</div>
			</div>
	<!-- Guardian Top Part -->
  		<div class="row margin-data">
  			<div class="col">
	  				<span class="input-group-text"><p style = "font-family:times; font-size:25px;padding-top: 10px;">Secondary Guardian</p></span>
  			</div>
  		</div>
	  	<!-- First and Last Name of Guardian-->
	  		<div class="row initial-task-padding">
		  		<div class="col">
		  			<p>First Name:</p>
		  		</div>
	  		</div>
	  		<div class="row no-task-padding">
		  		<div class="col">
					<input name="guardiannamefirst2" type="text" times-label="First Name" class="form-control" <?php if($parent['guardiannamefirst2'] != NULL){ echo 'value='.$parent['guardiannamefirst2'];}?> >
				</div>
			</div>

			<div class="row task-padding">
				<div class="col">
					<p>Last Name:</p>
				</div>
	  		</div>
	  		<div class="row no-task-padding">
				<div class="col">
					<input name="guardiannamelast2" type="text" times-label="Last Name" class="form-control" <?php if($parent['guardiannamelast2'] != NULL){ echo 'value='.$parent['guardiannamelast2'];}?> >
				</div>
			</div>
		<!-- Email and Phone number of Guardian-->
			<div class="row task-padding">
				<div class="col">
			    	<p>Email address:</p>
			    </div>
			</div>

			<div class="row no-task-padding">
				<div class="col">
				    <input name="email2" type="email" times-label="Email address" class="form-control" <?php if($parent['guardianemail2'] != NULL){ echo 'value='.$parent['guardianemail2'];}?> >
				</div>


			</div>

			<div class="row task-padding">
				<div class="col">
			    	<p>Phone Number: (e.g 1234567890)</p>
			    </div>
			</div>

			<div class="row no-task-padding">
				<div class="col">
					<div class="input-group mb-3">
					  <input name="phone3" type="tel" pattern="[0-9]{3}[0-9]{3}[0-9]{4}" class="form-control" aria-label="Text input with segmented dropdown button" <?php if($parent['guardian2phone1'] != NULL){ echo 'value='.$parent['guardian2phone1'];}?> >
					</div>
				</div>
			</div>


			<div class="row task-padding">
				<div class="col">
			    	<p>Phone Number 2: (e.g 1234567890)</p>
			    </div>
			</div>

			<div class="row no-task-padding">
				<div class="col">
					<div class="input-group mb-3">
					  <input name="phone4" type="tel" pattern="[0-9]{3}[0-9]{3}[0-9]{4}" class="form-control" aria-label="Text input with segmented dropdown button" <?php if($parent['guardian2phone2'] != NULL){ echo 'value='.$parent['guardian2phone2'];}?> >
					</div>
				</div>
			</div>
	<!-- Address Part International/US Area-->
		<div class="row margin-data">
  			<div class="col">
	  				<span class="input-group-text"><p style = "font-family:times; font-size:25px;padding-top: 10px;">Area of Residence</p></span>
  			</div>
  		</div>


		<!-- US Area Address 1 -->
		  		<div class="row initial-task-padding">
					<div class="col">
				    	<p>Address 1:<b style = "color: #DC143C;">*</b></p>
				    </div>
				</div>

				<div class="row no-task-padding">
					<div class="col">
					    <input name="address1" type="text" times-label="Address 1" class="form-control" <?php if($parent['address1'] != NULL){ echo 'value='.$parent['address1'];}?> >
					</div>
				</div>
		<!-- Address 2 -->
		  		<div class="row task-padding">
					<div class="col">
				    	<p>Address 2:</p>
				    </div>
				</div>

				<div class="row no-task-padding">
					<div class="col">
					    <input name="address2" type="text" times-label="Address 2" class="form-control" <?php if($parent['address2'] != NULL){ echo 'value='.$parent['address2'];}?> >
					</div>
				</div>
		<!-- City-->
				<div class="row task-padding">
					<div class="col">
			  			<p>City:<b style = "color: #DC143C;">*</b></p>
			  		</div>
		  		</div>
		  		<div class="row no-task-padding">
			  		<div class="col">
						<input name="city" type="text" times-label="City" class="form-control" <?php if($parent['city'] != NULL){ echo 'value='.$parent['city'];}?> >
					</div>
				</div>
		<!--State-->
				<div class="row initial-task-padding">
					<div class="col">
						<p>State: (if applicable) </p>
					</div>
		  		</div>
		  		<div class="row no-task-padding">
			  		<div class="col">
			  			<select name="state" class="form-control form-control-md">
							  <option>Alabama</option>
							  <option>Alaska</option>
							  <option>Arizona</option>
							  <option>Arkansas</option>
							  <option>California</option>
							  <option>Colorado</option>
							  <option>Connecticut</option>
							  <option>Delaware</option>
							  <option>Florida</option>
							  <option>Georgia</option>
							  <option>Hawaii</option>
							  <option>Idaho</option>
							  <option>Illinois</option>
							  <option>Indiana</option>
							  <option>Iowa</option>
							  <option>Kansas</option>
							  <option>Kentucky</option>
							  <option>Louisiana</option>
							  <option>Maine</option>
							  <option>Maryland</option>
							  <option>Massachusetts</option>
							  <option>Michigan</option>
							  <option>Minnesota</option>
							  <option>Mississippi</option>
							  <option>Missouri</option>
							  <option>Montana</option>
							  <option>Nebraska</option>
							  <option>Nevada</option>
							  <option>New Hampshire</option>
							  <option>New Jersey</option>
							  <option>New Mexico</option>
							  <option>New York</option>
							  <option>North Carolina</option>
							  <option>North Dakota</option>
							  <option>Ohio</option>
							  <option>Oklahoma</option>
							  <option>Oregon</option>
							  <option>Pennsylvania</option>
							  <option>Rhode Island</option>
							  <option>South Carolina</option>
							  <option>South Dakota</option>
							  <option>Tennessee</option>
							  <option>Texas</option>
							  <option>Utah</option>
							  <option>Vermont</option>
							  <option>Virginia</option>
							  <option>Washington</option>
							  <option>West Virginia</option>
							  <option>Wisconsin</option>
							  <option>Wyoming</option>

						</select>
						
					</div>
			
				</div>
		

		<!-- Country,Zip -->
				<div class="row task-padding">
			  		<div class="col">
			  			<p>Country:<b style = "color: #DC143C;">*</b></p>
			  		</div>
		  		</div>
		  		<div class="row no-task-padding">
			  		<div class="col">
						<input name="country" type="text" times-label="City" class="form-control" <?php if($parent['country'] != NULL){ echo 'value='.$parent['country'];}?> >
					</div>

				</div>

				<div class="row task-padding">
					<div class="col">
						<p>Postal Code:<b style = "color: #DC143C;">*</b></p>
					</div>
		  		</div>
		  		<div class="row no-task-padding">
					<div class="col" style="padding-bottom: 40px;">
						<input name="zippostalcode" type="number" times-label="Zip" class="form-control" <?php if($parent['zippostalcode'] != NULL){ echo 'value='.$parent['zippostalcode'];}?> >
					</div>
				</div>
	<!-- Emergency Contact Top Part -->
  		<div class="row margin-data">
  			<div class="col">
	  				<span class="input-group-text"><p style = "font-family:times; font-size:25px;padding-top: 10px;">Emergency Contact 1:</p></span>
  			</div>
  		</div>
	  	<!-- First and Last Name of Guardian-->
	  		<div class="row initial-task-padding">
		  		<div class="col">
		  			<p>First Name:<b style = "color: #DC143C;">*</b></p>
		  		</div>
	  		</div>
	  		<div class="row no-task-padding">
		  		<div class="col">
					<input name="emergencynamefirst1" type="text" times-label="First Name" class="form-control" <?php if($parent['emergencynamefirst1'] != NULL){ echo 'value='.$parent['emergencynamefirst1'];}?> required>
				</div>
			</div>

			<div class="row task-padding">
				<div class="col">
					<p>Last Name:<b style = "color: #DC143C;">*</b></p>
				</div>
	  		</div>
	  		<div class="row no-task-padding">
				<div class="col">
					<input name="emergencynamelast1" type="text" times-label="Last Name" class="form-control" <?php if($parent['emergencynamelast1'] != NULL){ echo 'value='.$parent['emergencynamelast1'];}?> required>
				</div>
			</div>
		<!-- Relationship-->
			<div class="row task-padding">
				<div class="col">
			    	<p>Relationship:<b style = "color: #DC143C;">*</b></p>
			    </div>
			</div>

			<div class="row no-task-padding">
				<div class="col">
				    <input name="emergencyrelationship1" type="text" times-label="relationship" class="form-control" <?php if($parent['emergencyrelationship1'] != NULL){ echo 'value='.$parent['emergencyrelationship1'];}?> required>
				</div>

			</div>


			<div class="row task-padding">
				<div class="col">
			    	<p>Phone Number: (e.g 1234567890)<b style = "color: #DC143C;">*</b></p>
			    </div>
			</div>
		<!--Phone Number-->
			<div class="row no-task-padding">
				<div class="col">
					<div class="input-group mb-3">
					  <input name="emergencyphone1" type="tel" pattern="[0-9]{3}[0-9]{3}[0-9]{4}" class="form-control" aria-label="Text input with segmented dropdown button" <?php if($parent['emergencyphone1'] != NULL){ echo 'value='.$parent['emergencyphone1'];}?> required>
					</div>
				</div>
			</div>

			<div class="form-check">
			    <input name="emergencyauthorized1" type="checkbox" class="form-check-input" id="exampleCheck1" value=1 <?php if($parent['emergencyauthorized1'] != 0){ echo "checked"; }?> >
			    <label class="form-check-label" for="exampleCheck1">This person is authorized to pick up my camper(s).</label>
			  </div>
	<!-- Emergency Contact Top Part -->
  		<div class="row margin-data">
  			<div class="col">
	  				<span class="input-group-text"><p style = "font-family:times; font-size:25px;padding-top: 10px;">Emergency Contact 2:</p></span>
  			</div>
  		</div>
	  	<!-- First and Last Name of Guardian-->
	  		<div class="row initial-task-padding">
		  		<div class="col">
		  			<p>First Name:<b style = "color: #DC143C;">*</b></p>
		  		</div>
	  		</div>

	  		<div class="row no-task-padding">
		  		<div class="col">
					<input name="emergencynamefirst2" type="text" times-label="First Name" class="form-control" <?php if($parent['emergencynamefirst2'] != NULL){ echo 'value='.$parent['emergencynamefirst2'];}?> >
				</div>
			</div>

			<div class="row initial-task-padding">
				<div class="col">
					<p>Last Name:<b style = "color: #DC143C;">*</b></p>
				</div>
	  		</div>

	  		<div class="row no-task-padding">
				<div class="col">
					<input name="emergencynamelast2" type="text" times-label="Last Name" class="form-control" <?php if($parent['emergencynamelast2'] != NULL){ echo 'value='.$parent['emergencynamelast2'];}?> >
				</div>
			</div>
		<!-- relationship-->
			<div class="row task-padding">
				<div class="col">
			    	<p>Relationship:<b style = "color: #DC143C;">*</b></p>
			    </div>
			</div>

			<div class="row no-task-padding">
				<div class="col">
				    <input name="emergencyrelationship2" type="text" times-label="Email address" class="form-control" <?php if($parent['emergencyrelationship2'] != NULL){ echo 'value='.$parent['emergencyrelationship2'];}?> >
				</div>
			</div>
		<!--Phone Number-->
			<div class="row task-padding">
				<div class="col">
			    	<p>Phone Number: (e.g 1234567890)<b style = "color: #DC143C;">*</b></p>
			    </div>
			</div>

			<div class="row no-task-padding">
				<div class="col">
					<div class="input-group mb-3">
							<input name="emergencyphone2" type="tel" pattern="[0-9]{3}[0-9]{3}[0-9]{4}" class="form-control" aria-label="Text input with segmented dropdown button" <?php if($parent['emergencyphone2'] != NULL){ echo 'value='.$parent['emergencyphone2'];}?> >
					</div>
				</div>
			</div>
			<div class="form-check">
			    <input name="emergencyauthorized2" type="checkbox" class="form-check-input" id="exampleCheck2" value=1 <?php if($parent['emergencyauthorized2'] != 0){ echo "checked"; }?> >
			    <label class="form-check-label" for="exampleCheck2">This person is authorized to pick up my camper(s).</label>
			</div>
	<!-- Submit -->
		<div class="row margin-data" style = "padding-bottom: 50px;padding-top: 10px;" align="center">
			<div class="col">
				<input id="submit" type="submit" class="btn-xl" align="center" >
			</div>
		</div>
	</div>
</div>
</form>

	<!--Javascript here-->
	<script type="text/javascript">
		$(".dropdown-menu a").click(function(){
		  $(this).parents(".dropdown").find('.btn').html($(this).text() + ' <span class="caret"></span>');
		  $(this).parents(".dropdown").find('.btn').val($(this).data('value'));
		});
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