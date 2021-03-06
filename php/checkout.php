<?php

// Initialize the session
session_start();
 
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

	$data = $_SESSION['data'];
	
	//get session week information for Updating table & Dynamically generating week information in page
	$sqlWeekInfo = "SELECT * FROM YearlySessionWeeks";
	$stmtWeekInfo = $conn->query($sqlWeekInfo);
	$weekInfo = $stmtWeekInfo->fetch(PDO::FETCH_ASSOC);

	date_default_timezone_set('America/Los_Angeles');
	$currDate = date('Y-m-d', time());
	
	//yearly pricing / total calculation -- seperate 
	$sqlPrice = "SELECT * FROM YearlySessionPricing";
	$stmtPrices = $conn->query($sqlPrice);
	$yearlyPrices = $stmtPrices->fetch(PDO::FETCH_ASSOC);
	
	//getting shirt information
	$sqlShirts = "SELECT numshirts FROM Children WHERE childid=".$_SESSION['childid'];
	$stmtShirts = $conn->query($sqlShirts);
	$numShirts = $stmtShirts->fetch(PDO::FETCH_ASSOC);
	
	$prices = array(
		'week1' => 0,
		'week2' => 0,
		'week3' => 0,
		'week4' => 0,
		'week5' => 0,
		'week6' => 0,
		'week7' => 0,
		'week8' => 0
	);
	
	if( strtotime($currDate) < strtotime($weekInfo['week1start']) ) {
		$eOrL = 'early';
	} else {
		$eOrL = 'late';
	}
	
	if( $data[':extendedcare'] == 1) {
		$extendedCareCost = $yearlyPrices['extendedcare'];
	} else {
		$extendedCareCost = 0;
	}
	
	for($x = 1; $x <= $weekInfo['activeweeks']; $x++){ //Including extended care
		if($data[':week'.$x.'am'] == 1 && $data[':week'.$x.'pm'] == 1 ) { //both am & pm [full day]
			if($x == $weekInfo['holidayweek']) $prices['week'.$x] = $yearlyPrices['holidayweekfull'.$eOrL] + ( $extendedCareCost * 4.00 ); //Holiday Full
			else $prices['week'.$x] = $yearlyPrices['oneweekfull'.$eOrL] + ( $extendedCareCost * 5.00 ); //not holiday
		} else if($data[':week'.$x.'am'] == 1) { //week# am only
			if($x == $weekInfo['holidayweek']) $prices['week'.$x] = $yearlyPrices['holidayweekam'.$eOrL] + ( $extendedCareCost * 4.00 ); //am HOliday
			else $prices['week'.$x] = $yearlyPrices['oneweekam'.$eOrL] + ( $extendedCareCost * 5.00 ); //am reg
		} else if($data[':week'.$x.'pm'] == 1){//week# pm only
			if($x == $weekInfo['holidayweek']) $prices['week'.$x] = $yearlyPrices['holidayweekpm'.$eOrL] + ( $extendedCareCost * 4.00 );//pm HOliday
			else $prices['week'.$x] = $yearlyPrices['oneweekpm'.$eOrL] + ( $extendedCareCost * 5.00 );//pm reg
		}
	}

	$shirtCost = ($numShirts['numshirts']-1) * $yearlyPrices['extrashirt'];
	$weekCost = 0;
	foreach($prices as $x){$weekCost += $x;}
	
	$total = $shirtCost + $weekCost;

	$sqlBalance = "SELECT price, credit FROM ChildrenDynamic WHERE childid=".$_SESSION['childid']." AND registeredyear=".$weekInfo['currentyear'];
	$stmtBalance = $conn->query($sqlBalance);
	$balance = $stmtBalance->fetch(PDO::FETCH_ASSOC);

	$currentBalance = $balance['price'];

	$_SESSION['total'] = $total - $currentBalance;
	$_SESSION['credit'] = $balance['credit'];

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
	<script src="r.js"></script>
    <script src="https://www.paypalobjects.com/api/checkout.js"></script>

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
<div class="container" style = "background: white; margin-top: 25px; padding-left: 20px; padding-right: 20px;">
<!--     <h3 style = "text-align: center;"></h3> -->
  	<div class="container" style="padding-bottom: 10px; border-color: black;">
  	<div class="row"> 
  		<div class="col" style="font-size: 12px;background: #f2f2f2; margin-top: 10px;">
  			<table>
  		  <tr>
		    <td colspan="2" valign="top"style="font-size: 25px; text-align: center;padding-top: 10px;padding-bottom: 5px;"><b>Terms and Conditions</b>
		    </td>
		  </tr>
		  <tr>
		    <td colspan="2" valign="top" style="padding-bottom: 3px;">I am aware of the camp activities described on the camp website and I give my permission for my child to participate in these activities, unless indicated.
		    </td>
		  </tr>
		  <tr>
		    <td colspan="2" valign="top" style="padding-bottom: 3px;"> The information submitted is true to the best of my knowledge. I understand that I am financially responsible for all fees and that all payments must be received by the first day of camp. All fees are non-refundable and there will be no refunds or exchanges for missed days. Parents are asked to notify Camp Izza if their child is ill or will not be attending as expected. Camp Director will attempt to call parents/guardians and/or emergency contacts if campers do not arrive to camp when expected.
		    </td>
		  </tr>
		  <tr>
		    <td colspan="2" valign="top" style="padding-bottom: 3px;"> I authorize Camp Izza to have and use the photos and video of the camper to be used in promotional materials. 
		    </td>
		  </tr>
		  <tr>
		    <td colspan="2" valign="top" style="padding-bottom: 3px;"> I agree to release, hold harmless, and indemnify Camp Izza, its trustees, staff, family members of employees, vendors, students, volunteers or insurers, or their heirs or representatives for any and all claims of any nature whatsoever, including, but not limited to, those related to and arising from personal injuries, illnesses, or fatality that my child may suffer or incur while he/she is on the Camp Izza campus or while using the facilities and equipment. I agree to not hold Camp Izza responsible for loss of or damage to any possessions my child brings to the camp. I hereby agree to indemnify Camp Izza against any claims of any third parties (including, but not exclusively, members of the child's family and other camp participants) for damages or losses incurred by them as a result of a child's participation in Camp Izza or presence on campus. 
		    </td>
		  </tr>
		  <tr>
		    <td colspan="2" valign="top" > I understand that registration is on a first-come, first serve basis, that my camper's spot will only be reserved upon receipt of payment and that returned checks will incur a $25 fee. <br />
		      <br />
		    </td>
		  </tr>
		</table>
  		</div>
  	</div>
  	<div class="row"> 
  		<div class = "col" style="padding:30px 30px;">
  			<div class = "row">
  				<div class = "col-6" style="text-align: left;" >Item Description
  				</div>
  				<div class="col" style="text-align: center;">Quantity</div>
  				<div class="col" style="text-align: right;">Price</div>
  			</div>
  			<hr>
  			<hr>
<?php
$stmtAmount = $conn->query("SELECT * FROM YearlySessionWeeks");
$campInfo = $stmtAmount->fetch(PDO::FETCH_ASSOC);

$stmtAmount = $conn->query("SELECT numshirts FROM Children WHERE childid=".$_SESSION['childid']);
$childInfo = $stmtAmount->fetch(PDO::FETCH_ASSOC);

unset($conn);
	for($x = 1; $x <= $weekInfo['activeweeks']; $x++){
		if ($prices['week'.$x] != 0) {


			echo "
			<div class = 'row'> 
					<div class = 'col-6'> <b style = 'font-size: 15px;text-align: left;'>Camp Week ".$x.': '.substr($campInfo['week'.$x.'start'], 5,2).'/'.substr($campInfo['week'.$x.'start'], 8,2).'-'
		.substr($campInfo['week'.$x.'end'], 5,2).'/'.substr($campInfo['week'.$x.'end'], 8,2)."</b></div>
					<div class='col' style='text-align: center;'> <b style='text-align: center; font-size: 15px;>' >1</b></div>
						<div class='col' style='text-align: right;'> <b style='text-align: right; font-size: 15px;'>$".$prices['week'.$x]."</b></div>
				</div>
				<div class = 'row'> 
					<div class = 'col-6' style = 'font-size: 10px; min-width:300px;text-align: left;' >";

			if($data[':extendedcare'] != 0){
				if($data[':week'.$x.'am'] != 0 && $data[':week'.$x.'pm'] != 0){
					echo "Full Day: 8:30am-4:00pm <br>";
					echo '+ Extended Care: 7:00am-8:30am and 4:00-5:30pm<br>';
				}
				else if($data[':week'.$x.'am'] != 0){
					echo "Morning: 8:30am-12:00pm<br>";
					echo '+ Extended Care: 7:00am-8:30am<br>';
				}
				else if($data[':week'.$x.'pm'] != 0){
					echo 'Afternoon: 12:30pm-4:00pm<br>';
					echo '+ Extended Care: 4:00-5:30pm<br>';
				}
			}
			else
			{
				if($data[':week'.$x.'am'] != 0 && $data[':week'.$x.'pm'] != 0){
				echo "Full Day: 8:30am-4:00pm <br>";
				}
				else if($data[':week'.$x.'am'] != 0){
					echo "Morning: 8:30am-12:00pm<br>";
				}
				else if($data[':week'.$x.'pm'] != 0){
					echo 'Afternoon: 12:30pm-4:00pm<br>';
				}
			}

			echo "</div>
				</div><br>";
		}
	}	
	echo "
	<div class = 'row'> 
		<div class = 'col-6'> <b style = 'font-size: 15px;text-align: left;'>Additional T-shirts</b></div>
		<div class='col' style='text-align: center;'><b style='text-align: center; font-size: 15px;'>".$childInfo['numshirts']."</b></div>
		<div class='col' style='text-align: right;'> <b style='text-align: right; font-size: 15px;'>$".$shirtCost."</b></div>
	</div>
	<p align='left' style = 'font-size: 10px;'>Each camper gets 1 free T-shirt.</p>";

	//When credit is applied some additional fields need to be shown
	$creditApplied = FALSE;

	echo "<hr><hr> <div class='row'>";

	echo "<div class='col-6'>";
	echo "</div>";

	echo "<div class='col-6 align-items-center' style='min-width: 300px'><div class='card'><p align='center' style = 'padding-top: 7px;'><b style = 'font-size: 30px;'> Order Summary</b></p><div class='card-body'>";
	//echo "<hr><hr><p align='center' style = 'padding-top: 10px' > <b>Total Amount Previously Paid: $".$currentBalance."</b>";

	echo "<div class = 'row'> 
			<div class = 'col-6'> <p style = 'padding-top: 10px'> Subtotal:</p></div>
			<div class='col' style='text-align: center;'><p style='text-align: center; font-size: 15px;'></p></div>
			<div class='col' style='text-align: right;'> <p style='text-align: right; font-size: 15px;padding-top: 10px'>$".($_SESSION['total'] + $currentBalance).".00</p></div>
		</div>";
	echo "<hr>";

	if($currentBalance > 0){
		echo "<div class = 'row'> 
			<div class = 'col-6'> <p style = 'padding-top: 10px'> Amount Previously Paid: </p></div>
			<div class='col' style='text-align: center;'><p style='text-align: center; font-size: 15px;'></p></div>
			<div class='col' style='text-align: right;'> <p style='text-align: right; font-size: 15px;padding-top: 10px'>- $".$currentBalance."</p></div>
		</div>";
	}


	if($_SESSION['credit'] > 0 && $_SESSION['total'] > 0){
		if($_SESSION['credit'] > $_SESSION['total']){
			echo "<div class = 'row'> 
			<div class = 'col-6'> <p style = 'padding-top: 10px'> Account Credit : </p></div>
			<div class='col' style='text-align: center;'><p style='text-align: center; font-size: 15px;'></p></div>
			<div class='col' style='text-align: right;'> <p style='text-align: right; font-size: 15px;padding-top: 10px'>- $".$_SESSION['total'].".00</p></div>
			</div>";
			$_SESSION['credit'] = $_SESSION['credit'] - $_SESSION['total'];
			$_SESSION['total'] = 0;
		}else{
			echo "<div class = 'row'> 
			<div class = 'col-6'> <p style = 'padding-top: 10px'> Account Credit : </p></div>
			<div class='col' style='text-align: center;'><p style='text-align: center; font-size: 15px;'></p></div>
			<div class='col' style='text-align: right;'> <p style='text-align: right; font-size: 15px;padding-top: 10px'>- $".$_SESSION['credit']."</p></div>
			</div>";
			$_SESSION['total'] = $_SESSION['total'] - $_SESSION['credit'];
			$_SESSION['credit'] = 0;
		}

		$creditApplied = TRUE;
	}

	echo "<hr>";


	if($_SESSION['total'] <= 0){
		if($creditApplied == TRUE){
			echo "<div class = 'row'> 
			<div class = 'col-6'> <p style = 'padding-top: 10px'> Remaining Account Credit: </p></div>
			<div class='col' style='text-align: center;'><p style='text-align: center; font-size: 15px;'></p></div>
			<div class='col' style='text-align: right;'> <p style='text-align: right; font-size: 15px;padding-top: 10px'>$".$_SESSION['credit'].".00</p></div></div>";
			echo "<div class = 'row'> 
			<div class = 'col-6'> <p style = 'padding-top: 10px'> Order Total Due: </p></div>
			<div class='col' style='text-align: center;'><p style='text-align: center; font-size: 15px;'></p></div>
			<div class='col' style='text-align: right;'> <p style='text-align: right; font-size: 15px;padding-top: 10px'>$".$_SESSION['total'].".00</p></div>
			</div>";
			echo "<hr>";
			echo '<div style="text-align: center;padding-top:30px;padding-bottom:20px;">';
			echo "<b style='font-size: 15px'>I agree to use my account credit to register my camper for Camp Izza.</b>";
			echo "<div class = 'row' style = 'padding-top: 20px;padding-bottom: 10px;'> <div class = 'col'></div><div class = 'col'>";
			echo '<form action="receipt.php" method="post">';
			echo '<input class="btn btn-sm btn-success" type="submit" value="Yes">';
			echo '</form></div>';
			echo "<div class = 'col'>";
			echo '<a href="childdisplay.php" role="button" class="btn btn-sm btn-danger">No</a></div>';
			echo "<div class = 'col'></div>";
			echo '</div>';
		}else{
			echo "<div class = 'row'> 
				<div class = 'col-6'> <p style = 'padding-top: 10px'> Redeemable Credit: </p></div>
				<div class='col' style='text-align: center;'><p style='text-align: center; font-size: 15px;'></p></div>
				<div class='col' style='text-align: right;'> <p style='text-align: right; font-size: 15px;padding-top: 10px'>$".abs($_SESSION['total']).".00</p></div>
			</div>";
			echo "<hr>";
			echo '<div style="text-align: center;padding-top:30px;padding-bottom:20px;">';
			echo "<b style='font-size: 15px'>Would you like to add the amount of $".abs($_SESSION['total'])." to your account?</b>";
			echo "<div class = 'row' style = 'padding-top: 20px;padding-bottom: 10px;'> <div class = 'col'></div><div class = 'col'>";
			echo '<form action="receipt.php" method="post">';
			echo '<input class="btn btn-sm btn-success" type="submit" value="Yes">';
			echo '</form></div>';
			echo "<div class = 'col'>";
			echo '<a href="childdisplay.php" role="button" class="btn btn-sm btn-danger">No</a></div>';
			echo "<div class = 'col'></div>";
			echo '</div>';
		}
	}else{
		if($creditApplied == TRUE){
			echo "<div class = 'row'> 
				<div class = 'col-6'> <p style = 'padding-top: 10px'> Remaining Account Credit: </p></div>
				<div class='col' style='text-align: center;'><p style='text-align: center; font-size: 15px;'></p></div>
				<div class='col' style='text-align: right;'> <p style='text-align: right; font-size: 15px;padding-top: 10px'>$".$_SESSION['credit'].".00</p></div>
			</div>";
		}
		echo "<div class = 'row'> 
			<div class = 'col-6'> <p style = 'padding-top: 10px'> Order Total Due: </p></div>
			<div class='col' style='text-align: center;'><p style='text-align: center; font-size: 15px;'></p></div>
			<div class='col' style='text-align: right;'> <p style='text-align: right; font-size: 15px;padding-top: 10px'>$".$_SESSION['total'].".00</p></div>
		</div>";
		echo '<div id="paypal-button" style="text-align: center;padding-top: 40px;"></div>';
		echo '<input type="hidden" name="business" value="qnq89078@cndps.com"/> ';
		echo '<div class="tab" style = "margin-top: 30px">';
		echo '<button class="tablinks" onclick="" style="background: transparent;border: none !important;font-size:0;"></button>';
		echo '</div>';

	}
	echo "</div></div></div>";
	echo "</div>";
?>

  			
	  		
			
				  
			
  			
  		</div>
  	</div>

  		
	</div>
</div>


 <!--Java Script-->
<script type="text/javascript">
 	paypal.Button.render({
	    env: 'sandbox', // Or 'production'
	    // Set up the payment:
	    client: {
            sandbox:'AUmgJ1oMDn4FsdBqxuvxi-9hIN8B5FWreuvYRhLaBmVtCek1qH-32vWCMygFSe6mhpKa8Epp-ERa73GJ',
            production: 'AZC9nSofXqQT186_jNkgK-srfaV83p8HL2TbrL2_BqAZow_9UE5rwB3LIlySSXb1wEeef0ocCIxFP1bZ'
        },
        locale: 'en_US',
			style: {
			 size: 'medium',
			 color: 'black',
			 shape: 'rect',
			 label: 'checkout',
			 tagline: 'true'
			},
	    // 1. Add a payment callback
	    payment: function(data, actions) {
	      // 2. Make a request to your server
	        return actions.payment.create({
				"transactions": [{
				    "amount": {
				      "currency": "USD",
				      "total": "<?php echo $_SESSION['total']; ?>",
				      "details": {
				        "subtotal": "<?php echo $_SESSION['total']; ?>",
				      }
				    },
				    "description": "The payment transaction description.",
					 "item_list": {
				      "items": [{
				        "name": "Camp Fees",
				        "quantity": "1",
				        "price": "<?php echo $_SESSION['total']; ?>",
				        "sku": "1",
				        "currency": "USD"
				      }]
					 }
				  }],
		  });
	    },
	    // Execute the payment:
	    // 1. Add an onAuthorize callback
	    onAuthorize: function(data, actions) {
	      // 2. Make a request to your server
	      return actions.payment.execute().then((json) => {
	      		document.getElementsByClassName('tablinks')[0].click();
                alert('Payment Complete!');
				postRefreshPage();
                //you can access information here

				
            });
        }
	  }, '#paypal-button');
	
 </script>
 
 <div id="hidden_form_container" style="display:none;"></div>
 
 
 
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