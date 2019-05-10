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

$sql = "SELECT * FROM Children WHERE childid=".$_GET['childid'];

$stmt = $conn->query($sql);
$child = $stmt->fetch(PDO::FETCH_ASSOC);
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
	<link rel="stylesheet" href="StudentRegistration.css">

	    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
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
	
<form action="editchilddb.php" method="post">
<div class="container" style = "background: white; margin-top: 20px;">
    <!-- Camp Registration Header -->
    <h1 align="center" style = "padding-top: 40px;">Register a Camper</h1>
  	<div class="container">
    <!-- Camper Information -->
    	<div class="row margin-data">
  			<div class="col">
	  				<span class="input-group-text"><p style = "font-family:times; font-size:25px;padding-top: 10px;">Camper Information</p></span>
  			</div>
  		</div>
    	<!-- Camper Name -->
    		<div class="row initial-task-padding">
		  		<div class="col">
		  			<p>First Name:<b style = "color: #DC143C;">*</b></p>
		  		</div>
	  		</div>
	  		<div class="row no-task-padding">
		  		<div class="col">
					<input type="text" name="firstname" times-label="First Name" class="form-control" <?php if($child['firstname'] != NULL){ echo 'value='.$child['firstname'];}?> required>
				</div>
			</div>
			<div class="row initial-task-padding">
				<div class="col">
					<p>Last Name:<b style = "color: #DC143C;">*</b></p>
				</div>
	  		</div>
	  		<div class="row no-task-padding">
				<div class="col">
					<input type="text" name="lastname" times-label="Last Name" class="form-control" <?php if($child['lastname'] != NULL){ echo 'value='.$child['lastname'];}?> required>
				</div>
			</div>

    	<!-- Camper Gender/Camper Birthday -->
    		<div class="row task-padding">
    			<div class="col">
    				<p>Gender:<b style = "color: #DC143C;">*</b></p>
				</div>
			</div>
			<div class="row">
		  		<div class="col">
					<select class="form-control form-control-md" name="gender">
						<?php
							if($child['gender']=="Male"){
								echo '<option value="Female">Female</option>
										<option value="Male" selected="selected">Male</option>';
							} else{
								echo '<option value="Female" selected="selected">Female</option>
										<option value="Male">Male</option>'
							}

						?>
						<!--<option value="Female">Female</option>
						<option value="Male">Male</option>-->
					</select>
				</div>
			</div>

			<div class="row task-padding">
				<div class="col">
						<p>Date of Birth:<b style = "color: #DC143C;">*</b> </p>
				</div>
			</div>
			<div class="row">
				<div class='col'>
			            <div class="form-group">
			                <div class='input-group date' >
			                    <input type='date' name="dob" class="form-control" <?php if($child['dob'] != NULL){ echo 'value='.$child['dob'];}?> required />
			                </div>
			            </div>
			    </div>
			</div>
    
    	<!-- Health Information -->
    		<div class="row margin-data">
	  			<div class="col">
		  				<span class="input-group-text"><p style = "font-family:times; font-size:25px;padding-top: 10px;">Health Information</p></span>
	  			</div>
  			</div>
    		<!-- Doctor Name/Doctor # -->
	    		<div class="row initial-task-padding">
			  		<div class="col">
			  			<p>Primary Physicians Name:<b style = "color: #DC143C;">*</b></p>
			  		</div>
		  		</div>
		  		<div class="row no-task-padding">
			  		<div class="col">
						<input type="text" name="doctorname" times-label="Full Name" class="form-control" <?php if($child['doctorname'] != NULL){ echo 'value='.$child['doctorname'];}?> required>
					</div>
				</div>

				<div class="row task-padding">
					<div class="col">
						<p>Phone Number: (e.g 1234567890) <b style = "color: #DC143C;">*</b></p>
					</div>
		  		</div>
		  		<div class="row no-task-padding">
					<div class="col">
						<input type="tel" pattern="[0-9]{3}[0-9]{3}[0-9]{4}" name="doctorphone" times-label="Physician Number" class="form-control" <?php if($child['doctorphone'] != NULL){ echo 'value='.$child['doctorphone'];}?> required>
					</div>
				</div>

			<!-- Insurance Information -->
    		<!-- Insurance Carrier/Policy Holder's Name -->
    		<div class="row initial-task-padding">
		  		<div class="col">
		  			<p>Insurance Carrier:<b style = "color: #DC143C;">*</b></p>
		  		</div>
	  		</div>
	  		<div class="row no-task-padding">
		  		<div class="col">
					<input type="text" name="insurance" times-label="Insurance" class="form-control" <?php if($child['insurance'] != NULL){ echo 'value='.$child['insurance'];}?> required>
				</div>
			</div>
			<div class="row initial-task-padding">
				<div class="col">
					<p>Policy Holder's Name:<b style = "color: #DC143C;">*</b></p>
				</div>
	  		</div>
	  		<div class="row no-task-padding">
				<div class="col">
					<input type="text" name="policyholder" times-label="PolicyHoldersName" class="form-control" <?php if($child['policyholder'] != NULL){ echo 'value='.$child['policyholder'];}?> required>
				</div>
			</div>
  
    	<!-- Health Questions -->
    		<div class="row margin-data">
	  			<div class="col">
		  				<span class="input-group-text"><p style = "font-family:times; font-size:25px;padding-top: 10px;">Health Questions</p></span>
	  			</div>
  			</div>
    		<!-- Chronic conditions or illnesses -->
	    		<div class="row initial-task-padding">
			  		<div class="col">
			  			<p>Does your child have any chronic conditions or illnesses of which we should be aware of?<b style = "color: #DC143C;">*</b></p>
			  		</div>
		  		</div>
		  		<div class="row no-task-padding">
			  		<div class="col">
						<input type="text" name="illnesses" times-label="CCI" class="form-control" <?php if($child['illnesses'] != NULL){ echo 'value='.$child['illnesses'];}?> >
					</div>
				</div>

    		<!-- Allergies and/or Dietary Restrictions -->
	    		<div class="row initial-task-padding">
			  		<div class="col">
			  			<p>Does your child have any allergies and/or dietary restrictions of which we should be aware of?<b style = "color: #DC143C;">*</b></p>
			  		</div>
		  		</div>
		  		<div class="row no-task-padding">
			  		<div class="col">
						<input type="text" name="allergies" times-label="CCI" class="form-control" <?php if($child['allergies'] != NULL){ echo 'value='.$child['allergies'];}?> >
					</div>
				</div>

    		<!-- Will your child be taking any medication at camp? -->
	    		<div class="row initial-task-padding">
			  		<div class="col">
			  			<p>Will your child be taking any medication at camp? If yes, please list medications<b style = "color: #DC143C;">*</b></p>
			  		</div>
		  		</div>
		  		<div class="row no-task-padding">
		  			<div class="col-2">
						<select class="form-control form-control-lg" name="medication">
						<option>Yes</option>
						<option>No</option>
						</select>
					</div>
					<div class="col">
						<input type="text" name="medicationnames" times-label="CCI" class="form-control" <?php if($child['medicationnames'] != NULL){ echo 'value='.$child['medicationnames'];}?> >
					</div>
				</div>


    		<!-- Are there any activities at camp that your child cannot participate in? If yes, which activities -->
	    		<div class="row initial-task-padding">
				  		<div class="col">
				  			<p>Are there any activities at camp that your child cannot participate in? If yes, which activities<b style = "color: #DC143C;">*</b></p>
				  		</div>
			  	</div>
		  		<div class="row no-task-padding">
		  			<div class="col-2">
						<select class="form-control form-control-lg" name="activities">
						<option>Yes</option>
						<option>No</option>
						</select>
					</div>
					<div class="col">
						<input type="text" name="activitiesnames" times-label="CCI" class="form-control" <?php if($child['activitiesnames'] != NULL){ echo 'value='.$child['activitiesnames'];}?> >
					</div>
				</div>

    		<!-- Has your child undergone any medical treatments?-->
    			<div class="row initial-task-padding">
				  		<div class="col">
				  			<p>Has your child undergone any medical treatments? If yes, which treatments.<b style = "color: #DC143C;">*</b></p>
				  		</div>
			  	</div>
		  		<div class="row no-task-padding">
		  			<div class="col-2">
						<select class="form-control form-control-lg" name="medicaltreatments">
						<option>Yes</option>
						<option>No</option>
						</select>
					</div>
					<div class="col">
						<input type="text" name="medicaltreatmentsnames" times-label="CCI" class="form-control" <?php if($child['medicaltreatmentsnames'] != NULL){ echo 'value='.$child['medicaltreatmentsnames'];}?> >
					</div>
				</div>

    		<!-- Has your child recieved all current immunizations? (Needs a yes)-->
    		    <div class="row initial-task-padding">
				  		<div class="col">
				  			<p>Has your child recieved all current immunizations?<b style = "color: #DC143C;">*</b></p>
				  		</div>
			  	</div>
		  		<div class="row no-task-padding">
		  			<div class="col-2">
						<select class="form-control form-control-lg" name="immunizations">
						<option>Yes</option>
						<option>No</option>
					</select>
					</div>
				</div>
    		<!-- Tetanus shot Date-->
    		<div class="row initial-task-padding">
				  		<div class="col">
				  			<p>What is the date of last tetanus shot? (approximate date if necessary)<b style = "color: #DC143C;">*</b></p>
				  		</div>
			  	</div>
		  		<div class="row no-task-padding">
					<div class='col'>
			            <div class="form-group">
			                <div class='input-group date'>
			                    <input type='date' name="tetanusdate" class="form-control" <?php if($child['tetanusdate'] != NULL){ echo 'value='.$child['tetanusdate'];}?> />
			                    <!-- <span class="input-group-addon">
			                        <span class="glyphicon glyphicon-calendar"></span>
			                    </span> -->
			                </div>
			            </div>
			    	</div>
				</div>
    <!-- Comments -->
    <div class="row margin-data">
	  			<div class="col">
		  				<span class="input-group-text"><p style = "font-family:times; font-size:25px;padding-top: 10px;">Extra Comments</p></span>
	  			</div>
  			</div>
    	<!-- Additional Comments about Camper -->
    	<div class="row initial-task-padding">
			  		<div class="col">
			  			<p>Do you have any additional comments about this camper?</p>
			  		</div>
		</div>
		<div class="row no-task-padding">
			<div class="col">
				<textarea class="form-control" name="comments" placeholder="Comments." <?php if($child['comments'] != NULL){ echo 'value='.$child['comments'];}?> ></textarea>
			</div>
		</div>
	</div>
	
	<!-- Pass along child id -->
	<input type="hidden" name="childid" value="<?php echo $_GET['childid'];?>">


	<!-- Submit -->
		<div class="row margin-data" style = "padding-bottom: 50px;padding-top: 10px;" align="center">
			<div class="col">
				<input type="submit" class="btn-xl" align="center" value="Submit" >
			</div>
		</div>
	</div>
</form>

	<!--Javascript here-->
	<script type="text/javascript">

		$(".dropdown-menu a").click(function() {
		  $(this).parents(".dropdown").find('.btn').html($(this).text());
		  $(this).parents(".dropdown").find('.btn').val($(this).data('value'));
		});

	</script>


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