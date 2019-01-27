<?php 

// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

include('connection.php');

$sql = "SELECT * FROM Children WHERE id=".$_POST['childid'];

$stmt = $conn->query($sql);
$child = $stmt->fetch(PDO:FETCH_ASSOC);

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
<div class="container" style = "background: white; margin-top: 20px;">
    <!-- Camp Registration Header -->
    <h1 align="center" style = "padding-top: 40px;">Register a Camper</h1>
  	<div class="container">
    <!-- Camper Information -->
    	<div class="row margin-data">
  			<div class="col">
	  				<span class="input-group-text"><p style = "font-family:courier new; font-size:25px;padding-top: 10px;">Camper Information</p></span>
  			</div>
  		</div>
    	<!-- Camper Name -->
    		<div class="row initial-task-padding">
		  		<div class="col">
		  			<p>First Name:</p>
		  		</div>
				<div class="col">
					<p>Last Name:</p>
				</div>
	  		</div>
	  		<div class="row no-task-padding">
		  		<div class="col">
					<input type="text" name="firstname" times-label="First Name" class="form-control" <?php if($child['firstname'] != NULL){ echo 'value='.$parent['firstname'];}?> required>
				</div>
				<div class="col">
					<input type="text" name="lastname" times-label="Last Name" class="form-control" <?php if($child['lastname'] != NULL){ echo 'value='.$parent['lastname'];}?> required>
				</div>
			</div>
    	<!-- Camper Gender/Camper Birthday -->
    		<div class="row task-padding">
    			<div class="col">
    				<p>Gender:</p>
				</div>
				<div class="col-7">
						<p>Date of Birth: (e.g. 2019-01-26) </p>
				</div>
			</div>
			<div class="row">
		  		<div class="col-5 button-padding">
					<div class="dropdown">
					  <button class="btn btn-light btn-md btn-block border-secondary" name="gender" type="button" id="dropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" required>Select One
					  </button>
					    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
						    <a class="dropdown-item" data-value="a">Female</a>
						    <a class="dropdown-item" data-value="b">Male</a>
						</div>
					</div>
				</div>
				<div class='col-7'>
			            <div class="form-group">
			                <div class='input-group date' >
			                    <input type='date' name="dob" class="form-control" <?php if($child['dob'] != NULL){ echo 'value='.$parent['dob'];}?> required />
			                </div>
			            </div>
			    </div>

			</div>
    
    	<!-- Health Information -->
    		<div class="row margin-data">
	  			<div class="col">
		  				<span class="input-group-text"><p style = "font-family:courier new; font-size:25px;padding-top: 10px;">Health Information</p></span>
	  			</div>
  			</div>
    		<!-- Doctor Name/Doctor # -->
	    		<div class="row initial-task-padding">
			  		<div class="col">
			  			<p>Primary Physicians Name:</p>
			  		</div>
					<div class="col">
						<p>Phone Number: (e.g 1234567890)</p>
					</div>
		  		</div>
		  		<div class="row no-task-padding">
			  		<div class="col">
						<input type="text" name="doctorname" times-label="Full Name" class="form-control" <?php if($child['doctorname'] != NULL){ echo 'value='.$parent['doctorname'];}?> required>
					</div>
					<div class="col">
						<input type="text" name="doctorphone" times-label="Physician Number" class="form-control" <?php if($child['doctorphone'] != NULL){ echo 'value='.$parent['doctorphone'];}?> required>
					</div>
				</div>

			<!-- Insurance Information -->
    		<!-- Insurance Carrier/Policy Holder's Name -->
    		<div class="row initial-task-padding">
		  		<div class="col">
		  			<p>Insurance Carrier:</p>
		  		</div>
				<div class="col">
					<p>Policy Holder's Name:</p>
				</div>
	  		</div>
	  		<div class="row no-task-padding">
		  		<div class="col">
					<input type="text" name="insurance" times-label="Insurance" class="form-control" <?php if($child['insurance'] != NULL){ echo 'value='.$parent['insurance'];}?> required>
				</div>
				<div class="col">
					<input type="text" name="policyholder" times-label="PolicyHoldersName" class="form-control" <?php if($child['policyholder'] != NULL){ echo 'value='.$parent['policyholder'];}?> required>
				</div>
			</div>
  
    	<!-- Health Questions -->
    		<div class="row margin-data">
	  			<div class="col">
		  				<span class="input-group-text"><p style = "font-family:courier new; font-size:25px;padding-top: 10px;">Health Questions</p></span>
	  			</div>
  			</div>
    		<!-- Chronic conditions or illnesses -->
	    		<div class="row initial-task-padding">
			  		<div class="col">
			  			<p>Does your child have any chronic conditions or illnesses of which we should be aware of?</p>
			  		</div>
		  		</div>
		  		<div class="row no-task-padding">
			  		<div class="col">
						<input type="text" name="illnesses" times-label="CCI" class="form-control" <?php if($child['illnesses'] != NULL){ echo 'value='.$parent['illnesses'];}?> >
					</div>
				</div>

    		<!-- Allergies and/or Dietary Restrictions -->
	    		<div class="row initial-task-padding">
			  		<div class="col">
			  			<p>Does your child have any allergies and/or dietary restrictions of which we should be aware of?</p>
			  		</div>
		  		</div>
		  		<div class="row no-task-padding">
			  		<div class="col">
						<input type="text" name="allergies" times-label="CCI" class="form-control" <?php if($child['allergies'] != NULL){ echo 'value='.$parent['allergies'];}?> >
					</div>
				</div>

    		<!-- Will your child be taking any medication at camp? -->
	    		<div class="row initial-task-padding">
			  		<div class="col">
			  			<p>Will your child be taking any medication at camp? If yes, please list medications</p>
			  		</div>
		  		</div>
		  		<div class="row no-task-padding">
		  			<div class="col-4">
						<div class="dropdown">
						  <button class="btn btn-light btn-md btn-block border-secondary" name="medication" type="button" id="dropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" required>Select One
						  </button>
						    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
							    <a class="dropdown-item" data-value="a">Yes</a>
							    <a class="dropdown-item" data-value="b">No</a>
							  </div>
						</div>
					</div>
			  		<div class="col">
						<input type="text" name="medicationnames" times-label="CCI" class="form-control" <?php if($child['medicationnames'] != NULL){ echo 'value='.$parent['medicationnames'];}?> >
					</div>
				</div>

    		<!-- Are there any activities at camp that your child cannot participate in? If yes, which activities -->
	    		<div class="row initial-task-padding">
				  		<div class="col">
				  			<p>Are there any activities at camp that your child cannot participate in? If yes, which activities</p>
				  		</div>
			  	</div>
		  		<div class="row no-task-padding">
		  			<div class="col-4">
						<div class="dropdown">
						  <button class="btn btn-light btn-md btn-block border-secondary" name="medication" type="button" id="dropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" required>Select One
						  </button>
						    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
							    <a class="dropdown-item" data-value="a">Yes</a>
							    <a class="dropdown-item" data-value="b">No</a>
							  </div>
						</div>
					</div>
			  		<div class="col">
						<input type="text" name="activitiesnames" times-label="CCI" class="form-control" <?php if($child['activitiesnames'] != NULL){ echo 'value='.$parent['activitiesnames'];}?> >
					</div>
				</div>

    		<!-- Has your child undergone any medical treatments?-->
    			<div class="row initial-task-padding">
				  		<div class="col">
				  			<p>Has your child undergone any medical treatments? If yes, which treatments.</p>
				  		</div>
			  	</div>
		  		<div class="row no-task-padding">
		  			<div class="col-4">
						<div class="dropdown">
						  <button class="btn btn-light btn-md btn-block border-secondary" name="medication" type="button" id="dropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" required>Select One
						  </button>
						    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
							    <a class="dropdown-item" data-value="a">Yes</a>
							    <a class="dropdown-item" data-value="b">No</a>
							  </div>
						</div>
					</div>
			  		<div class="col">
						<input type="text" name="medicaltreatmentsnames" times-label="CCI" class="form-control" <?php if($child['medicaltreatmentsnames'] != NULL){ echo 'value='.$parent['medicaltreatmentsnames'];}?> >
					</div>
				</div>

    		<!-- Has your child recieved all current immunizations? (Needs a yes)-->
    		    <div class="row initial-task-padding">
				  		<div class="col">
				  			<p>Has your child recieved all current immunizations?</p>
				  		</div>
			  	</div>
		  		<div class="row no-task-padding">
		  			<div class="col-4">
						<div class="dropdown">
						  <button class="btn btn-light btn-md btn-block border-secondary" name="medication" type="button" id="dropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" required>Select One
						  </button>
						    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
							    <a class="dropdown-item" data-value="a">Yes</a>
							    <a class="dropdown-item" data-value="b">No</a>
							  </div>
						</div>
					</div>
				</div>
    		<!-- Tetanus shot Date-->
    		<div class="row initial-task-padding">
				  		<div class="col">
				  			<p>What is the date of last tetanus shot? (e.g. 2019-01-26 approximate date if necessary)</p>
				  		</div>
			  	</div>
		  		<div class="row no-task-padding">
					<div class='col'>
			            <div class="form-group">
			                <div class='input-group date'>
			                    <input type='date' name="tetanusdate" class="form-control" <?php if($child['tetanusdate'] != NULL){ echo 'value='.$parent['tetanusdate'];}?> />
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
		  				<span class="input-group-text"><p style = "font-family:courier new; font-size:25px;padding-top: 10px;">Extra Comments</p></span>
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
				<textarea class="form-control" name="comments" placeholder="Comments." <?php if($child['comments'] != NULL){ echo 'value='.$parent['comments'];}?> ></textarea>
			</div>
		</div>
	</div>


	<!-- Submit -->
		<div class="row margin-data" style = "padding-bottom: 50px;padding-top: 10px;" align="center">
			<div class="col">
				<button type="button" class="btn-xl" align="center" >Submit</button>
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