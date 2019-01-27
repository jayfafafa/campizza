<?php 

// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

include('connection.php');

$sql = "SELECT * FROM Parents WHERE id=".$_SESSION['id'];

$stmt = $conn->query($sql);
$parent = $stmt->fetch(PDO:FETCH_ASSOC);

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


<form role="form" method="post" action="parentdb.php">
	<!-- Html Lookout -->
<div class="container" style = "background: white; margin-top: 20px;">

    <h1 style = "padding-top: 40px;text-align: center;">Registration for Camp Izza</h1>

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
	  				<span class="input-group-text"><p style = "font-family:courier new; font-size:25px;padding-top: 10px;">Primary Guardian</p></span>
  			</div>
  		</div>
	  	<!-- First and Last Name of Guardian-->
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
					<input name="guardiannamefirst1" type="text" times-label="First Name" class="form-control" <?php if($parent['guardiannamefirst1'] != NULL){ echo 'value='.$parent['guardiannamefirst1'];}?> required>
				</div>
				<div class="col">
					<input name="guardiannamelast1" type="text" times-label="Last Name" class="form-control" <?php if($parent['guardiannamelast1'] != NULL){ echo 'value='.$parent['guardiannamelast1'];}?> required>
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
				    <input name="email1" type="text" times-label="Email address" class="form-control" <?php if($parent['guardianemail1'] != NULL){ echo 'value='.$parent['guardianemail1'];}?> required>
				</div>

			</div>


			<div class="row task-padding">
				<div class="col">
			    	<p>Phone Number 1:</p>
			    </div>
			</div>

			<div class="row no-task-padding">
				<div class="col">
					<div class="input-group mb-3">
					  <div class="input-group-prepend">
					    <select name="phonetype1">
						  <option value="Type">Type</option>
						  <option value="Home">Home</option>
						  <option value="Cell">Cell</option>
						  <option value="Work">Work</option>
						</select>
					  </div>
					  <input name="guardianphone1" type="text" class="form-control" aria-label="Text input with segmented dropdown button" <?php if($parent['guardian1phone1'] != NULL){ echo 'value='.$parent['guardian1phone1'];}?> required>
					</div>
				</div>
			</div>
			
			<div class="row task-padding">
				<div class="col">
			    	<p>Phone Number 2:</p>
			    </div>
			</div>

			<div class="row no-task-padding">
				<div class="col">
					<div class="input-group mb-3">
					  <div class="input-group-prepend">
					    <select name="phonetype2">
						  <option value="Type">Type</option>
						  <option value="Home">Home</option>
						  <option value="Cell">Cell</option>
						  <option value="Work">Work</option>
						</select>
					  </div>
					  <input name="guardianphone2" type="text" class="form-control" aria-label="Text input with segmented dropdown button" <?php if($parent['guardian1phone2'] != NULL){ echo 'value='.$parent['guardian1phone2'];}?> required>
					</div>
				</div>
			</div>
	<!-- Guardian Top Part -->
  		<div class="row margin-data">
  			<div class="col">
	  				<span class="input-group-text"><p style = "font-family:courier new; font-size:25px;padding-top: 10px;">Secondary Guardian</p></span>
  			</div>
  		</div>
	  	<!-- First and Last Name of Guardian-->
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
					<input name="guardiannamefirst2" type="text" times-label="First Name" class="form-control" <?php if($parent['guardiannamefirst2'] != NULL){ echo 'value='.$parent['guardiannamefirst2'];}?> >
				</div>
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
				    <input name="email2" type="text" times-label="Email address" class="form-control" <?php if($parent['guardianemail2'] != NULL){ echo 'value='.$parent['guardianemail2'];}?> >
				</div>


			</div>

			<div class="row task-padding">
				<div class="col">
			    	<p>Phone Number:</p>
			    </div>
			</div>

			<div class="row no-task-padding">
				<div class="col">
					<div class="input-group mb-3">
					  <div class="input-group-prepend">
					    <select name="phonetype3">
						  <option value="Type">Type</option>
						  <option value="Home">Home</option>
						  <option value="Cell">Cell</option>
						  <option value="Work">Work</option>
						</select>
					  </div>
					  <input name="phone3" type="text" class="form-control" aria-label="Text input with segmented dropdown button" <?php if($parent['guardian2phone1'] != NULL){ echo 'value='.$parent['guardian2phone1'];}?> >
					</div>
				</div>
			</div>


			<div class="row task-padding">
				<div class="col">
			    	<p>Phone Number 2:</p>
			    </div>
			</div>

			<div class="row no-task-padding">
				<div class="col">
					<div class="input-group mb-3">
					  <div class="input-group-prepend">
					    <select name="phonetype4">
						  <option value="Type">Type</option>
						  <option value="Home">Home</option>
						  <option value="Cell">Cell</option>
						  <option value="Work">Work</option>
						</select>
					  </div>
					  <input name="phone4" type="text" class="form-control" aria-label="Text input with segmented dropdown button" <?php if($parent['guardian2phone2'] != NULL){ echo 'value='.$parent['guardian2phone2'];}?> required>
					</div>
				</div>
			</div>
	<!-- Address Part International/US Area-->
		<div class="row margin-data">
  			<div class="col">
	  				<span class="input-group-text"><p style = "font-family:courier new; font-size:25px;padding-top: 10px;">Area of Residence</p></span>
  			</div>
  		</div>


		<!-- US Area Address 1 -->
		  		<div class="row initial-task-padding">
					<div class="col">
				    	<p>Address 1:</p>
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
			  			<p>City:</p>
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
			  			<div class="dropdown show">
						  <a name="state" class="btn btn-secondary btn-md btn-block dropdown-toggle" ole="button" data-toggle="dropdown" id="dropdownMenuLink" aria-haspopup="true" aria-expanded="false">State
						  </a>
						    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
							    <a class="dropdown-item" data-value="Alabama">Alabama</a>
							    <a class="dropdown-item" data-value="Alaska">Alaska</a>
							    <a  data-value="Arizona" class="dropdown-item">Arizona</a>
							    <a  data-value="Arkansas" class="dropdown-item">Arkansas</a>
							    <a  class="dropdown-item" data-value="California">California</a>
							    <a  class="dropdown-item" data-value="Colorado">Colorado</a>
							    <a  class="dropdown-item" data-value="Connecticut">Connecticut</a>
							    <a  class="dropdown-item" data-value="Delaware">Delaware</a>
							    <a  class="dropdown-item" data-value="Florida">Florida</a>
							    <a  class="dropdown-item" data-value="Georgia">Georgia</a>
							    <a  class="dropdown-item" data-value="Hawaii">Hawaii</a>
							    <a  class="dropdown-item" data-value="Idaho">Idaho </a>
							    <a  class="dropdown-item" data-value="Illinois">Illinois</a>
							    <a  class="dropdown-item" data-value="Indiana">Indiana</a>
							    <a  class="dropdown-item" data-value="Iowa">Iowa</a>
							    <a  class="dropdown-item" data-value="Kansas">Kansas</a>
							    <a  class="dropdown-item" data-value="Kentucky">Kentucky</a>
							    <a  class="dropdown-item" data-value="Louisiana">Louisiana</a>
							    <a  class="dropdown-item" data-value="Maine">Maine</a>
							    <a  class="dropdown-item" data-value="Maryland">Maryland</a>
							    <a  class="dropdown-item" data-value="Massachusetts">Massachusetts</a>
							    <a  class="dropdown-item" data-value="Michigan">Michigan</a>
							    <a  class="dropdown-item" data-value="Minnesota">Minnesota</a>
							    <a  class="dropdown-item" data-value="Mississippi">Mississippi </a>
							    <a  class="dropdown-item" data-value="Missouri">Missouri</a>
							    <a  class="dropdown-item" data-value="Montana">Montana</a>
							    <a  class="dropdown-item" data-value="Nebraska">Nebraska</a>
							    <a  class="dropdown-item" data-value="Nevada">Nevada</a>
							    <a  class="dropdown-item" data-value="New Hampshire">New Hampshire</a>
							    <a  class="dropdown-item" data-value="New Jersey">New Jersey</a>
							    <a  class="dropdown-item" data-value="New Mexico">New Mexico</a>
							    <a  class="dropdown-item" data-value="New York">New York</a>
							    <a  class="dropdown-item" data-value="North Carolina">North Carolina</a>
							    <a  class="dropdown-item" data-value="North Dakota">North Dakota</a>
							    <a  class="dropdown-item" data-value="Ohio">Ohio</a>
							    <a  class="dropdown-item" data-value="Oklahoma">Oklahoma </a>
							    <a  class="dropdown-item" data-value="Oregon">Oregon</a>
							    <a  class="dropdown-item" class="dropdown-item" data-value="Pennsylvania">Pennsylvania</a>
							    <a  class="dropdown-item" data-value="Rhode Island">Rhode Island</a>
							    <a  class="dropdown-item" data-value="South Carolina">South Carolina</a>
							    <a  class="dropdown-item" data-value="South Dakota">South Dakota</a>
							    <a  class="dropdown-item" data-value="Tennessee">Tennessee</a>
							    <a  class="dropdown-item" data-value="Texas">Texas</a>
							    <a  class="dropdown-item" data-value="Utah">Utah</a>
							    <a  class="dropdown-item" data-value="Vermont">Vermont</a>
							    <a  class="dropdown-item" data-value="Virginia">Virginia</a>
							    <a  class="dropdown-item" data-value="Washington">Washington</a>
							    <a  class="dropdown-item" data-value="West Virginia">West Virginia </a>
							    <a  class="dropdown-item" data-value="Wisconsin">Wisconsin</a>
							    <a  class="dropdown-item" data-value="Wyoming">Wyoming</a>
							  </div>
						</div>
						
					</div>
			
				</div>
		

		<!-- Country,Zip -->
				<div class="row task-padding">
			  		<div class="col">
			  			<p>Country:</p>
			  		</div>
					<div class="col">
						<p>Postal Code:</p>
					</div>
		  		</div>
		  		<div class="row no-task-padding">
			  		<div class="col">
						<input name="country" type="text" times-label="City" class="form-control" <?php if($parent['country'] != NULL){ echo 'value='.$parent['country'];}?> >
					</div>

					<div class="col" style="padding-bottom: 40px;">
						<input name="postalcode" type="text" times-label="Zip" class="form-control" <?php if($parent['zippostalcode'] != NULL){ echo 'value='.$parent['zippostalcode'];}?> >
					</div>
				</div>

		</div>
	<!-- Emergency Contact Top Part -->
  		<div class="row margin-data">
  			<div class="col">
	  				<span class="input-group-text"><p style = "font-family:courier new; font-size:25px;padding-top: 10px;">Emergency Contact 1:</p></span>
  			</div>
  		</div>
	  	<!-- First and Last Name of Guardian-->
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
					<input name="emergencynamefirst1" type="text" times-label="First Name" class="form-control" <?php if($parent['emergencynamefirst1'] != NULL){ echo 'value='.$parent['emergencynamefirst1'];}?> required>
				</div>
				<div class="col">
					<input name="emergencynamelast1" type="text" times-label="Last Name" class="form-control" <?php if($parent['emergencynamelast1'] != NULL){ echo 'value='.$parent['emergencynamelast1'];}?> required>
				</div>
			</div>
		<!-- Relationship-->
			<div class="row task-padding">
				<div class="col">
			    	<p>Relationship:</p>
			    </div>
			</div>

			<div class="row no-task-padding">
				<div class="col">
				    <input name="emergencyrelationship1" type="text" times-label="relationship" class="form-control" <?php if($parent['emergencyrelationship1'] != NULL){ echo 'value='.$parent['emergencyrelationship1'];}?> required>
				</div>

			</div>


			<div class="row task-padding">
				<div class="col">
			    	<p>Phone Number:</p>
			    </div>
			</div>
		<!--Phone Number-->
			<div class="row no-task-padding">
				<div class="col">
					<div class="input-group mb-3">
					  <div class="input-group-prepend">
					    <select name="emergencyphonetype1">
						  <option value="Type">Type</option>
						  <option value="Home">Home</option>
						  <option value="Cell">Cell</option>
						  <option value="Work">Work</option>
						</select>
					  </div>
					  <input name="emergencyphone1" type="text" class="form-control" aria-label="Text input with segmented dropdown button" <?php if($parent['emergencyphone1'] != NULL){ echo 'value='.$parent['emergencyphone1'];}?> required>
					</div>
				</div>
			</div>

			<div class="form-check">
			    <input type="checkbox" class="form-check-input" id="exampleCheck1" <?php if($parent['emergencyauthorized1'] != NULL){ echo "checked" }?> >
			    <label class="form-check-label" for="exampleCheck1">I give permission to this individual to pick up my child.</label>
			  </div>
	<!-- Emergency Contact Top Part -->
  		<div class="row margin-data">
  			<div class="col">
	  				<span class="input-group-text"><p style = "font-family:courier new; font-size:25px;padding-top: 10px;">Emergency Contact 2:</p></span>
  			</div>
  		</div>
	  	<!-- First and Last Name of Guardian-->
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
					<input name="emergencynamefirst2" type="text" times-label="First Name" class="form-control" <?php if($parent['emergencynamefirst2'] != NULL){ echo 'value='.$parent['emergencynamefirst2'];}?> >
				</div>
				<div class="col">
					<input name="emergencynamelast2" type="text" times-label="Last Name" class="form-control" <?php if($parent['emergencynamelast2'] != NULL){ echo 'value='.$parent['emergencynamelast2'];}?> >
				</div>
			</div>
		<!-- relationship-->
			<div class="row task-padding">
				<div class="col">
			    	<p>Relationship:</p>
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
			    	<p>Phone Number:</p>
			    </div>
			</div>

			<div class="row no-task-padding">
				<div class="col">
					<div class="input-group mb-3">
						<div class="input-group-prepend">
						    <select name="emergencyphonetype2">
							  <option value="Type">Type</option>
							  <option value="Home">Home</option>
							  <option value="Cell">Cell</option>
							  <option value="Work">Work</option>
							</select>
						</div>
							<input name="emergencyphone2" type="text" class="form-control" aria-label="Text input with segmented dropdown button" <?php if($parent['emergencyphone2'] != NULL){ echo 'value='.$parent['emergencyphone2'];}?> >
					</div>
				</div>
			</div>
			<div class="form-check">
			    <input type="checkbox" class="form-check-input" id="exampleCheck2" <?php if($parent['emergencyauthorized2'] != NULL){ echo "checked" }?> >
			    <label class="form-check-label" for="exampleCheck2">I give permission to this individual to pick up my child.</label>
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