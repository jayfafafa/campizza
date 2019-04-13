<?php
// Initialize the session
session_start();

include('connection.php');

$result = $conn->query("SELECT auth FROM ParentsLogin WHERE parentid=".$_SESSION['id']);
$row = $result->fetch(PDO::FETCH_ASSOC);
if($row['auth'] != 1){
    header('location: dashboard.php');
}
 
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

?>

<html>
<head>
<style type="text/css">
	th,td{white-space:nowrap;}
</style>
</head>
<body>

<table border="1">
	<!-- <tr style="background-color:#ccc">
    	<td colspan='37'><strong>CHILD INFORMATION</strong></th>
        <td colspan='29'><strong>PARENT INFORMATION</strong></th>
    </tr> -->
	<tr>
		<?php

            foreach ($_SESSION['attributes'] as $k => $v){
                if(isset($_POST[$k])){
                    echo '<th>'.$v.'</th>';
                }
            }

        ?>
    </tr>

<?php

$result = $conn->query("SELECT * FROM Parents, Children, ChildrenDynamic WHERE Parents.parentid=Children.parentid AND Children.childid=ChildrenDynamic.childid");
$num = $result->rowCount();


unset($conn);
$i=0;
while ($i < $num) {

	$row = $result->fetch(PDO::FETCH_ASSOC);
	
	// $parentid = $row['parentid'];
	// $regtime = $row['regtime'];
	// $location = $row['location'];
	// $guardian1namefirst = $row['guardiannamefirst1']; //changed
 //    $guardian1namelast = $row['guardiannamelast1'];
	// $guardian2namefirst = $row['guardiannamefirst2'];//changed
 //    $guardian2namelast = $row['guardiannamelast2'];
	// $address1 = $row['address1'];
	// $address2 = $row['address2'];
 //    $country = $row['country'];//changed
	// $city = $row['city'];
	// $state = $row['state'];
	// $zip = $row['zippostalcode'];//changed
	// $guardianemail1 = $row['guardianemail1'];
	// $guardianemail2 = $row['guardianemail2'];
	// $guardian1phone1 = $row['guardian1phone1'];
	// $guardian1phone2 = $row['guardian1phone2'];
	// $guardian2phone1 = $row['guardian2phone1'];
 //    $guardian2phone2 = $row['guardian2phone2'];
	// $emergencyname1first = $row['emergencynamefirst1'];
 //    $emergencyname1last = $row['emergencynamelast1'];
	// $emergencyrelationship1 = $row['emergencyrelationship1'];
	// $emergencyphone1 = $row['emergencyphone1'];
	// $emergencyauthorized1 = $row['emergencyauthorized1'];
	// $emergencyname2first = $row['emergencynamefirst2'];
 //    $emergencyname2last = $row['emergencynamelast2'];
	// $emergencyrelationship2 = $row['emergencyrelationship2'];
	// $emergencyphone2 = $row['emergencyphone2'];
	// $emergencyauthorized2 = $row['emergencyauthorized2'];
	
	// $childid = $row['childid'];
	// $firstname = $row['firstname'];
	// $lastname = $row['lastname'];
	// $gender = $row['gender'];
	// $dob = $row['dob'];//changed
	// /*$dobmonth = $row['dobmonth'];
	// $dobday = $row['dobday'];
	// $dobyear = $row['dobyear'];*/
	// $school = $row['school'];
	// $grade = $row['grade'];
	// $shirtsize = $row['shirtsize'];
	// $numshirts = $row['numshirts'];

	// $week1am = $row['week1am'];
	// $week1pm = $row['week1pm'];
	// $week2am = $row['week2am'];
	// $week2pm = $row['week2pm'];
	// $week3am = $row['week3am'];
	// $week3pm = $row['week3pm'];
	// $week4am = $row['week4am'];
	// $week4pm = $row['week4pm'];
	// $week5am = $row['week5am'];
	// $week5pm = $row['week5pm'];
	// $week6am = $row['week6am'];
	// $week6pm = $row['week6pm'];
	// $extendedcare = $row['extendedcare'];
	// $doctorname = $row['doctorname'];
	// $doctorphone = $row['doctorphone'];
	// $insurance = $row['insurance'];
	// $policyholder = $row['policyholder'];
	// $illnesses = $row['illnesses'];
	// $allergies = $row['allergies'];
	// $medication = $row['medication'];
	// $medicationnames = $row['medicationnames'];
	// $activities = $row['activities'];
	// $activitiesnames = $row['activitiesnames'];
	// $medicaltreatments = $row['medicaltreatments'];
	// $medicaltreatmentsnames = $row['medicaltreatmentsnames'];
	// $immunizations = $row['immunizations'];
	// $tetanusdate = $row['tetanusdate'];
	// $comments = $row['comments'];
	
?>

	<tr>
       <?php
       
            foreach($_POST as $k => $v){
                echo '<td>'.$row[$k].'</td>';
            }

       ?> 

        <!-- <td><?php if ($childid != "") echo $childid; else echo "&nbsp;" ?></td>
        <td><?php if ($firstname != "") echo $firstname; else echo "&nbsp;" ?></td>
        <td><?php if ($lastname != "") echo $lastname; else echo "&nbsp;" ?></td>
        <td><?php if ($gender != "") echo $gender; else echo "&nbsp;" ?></td>
        <td><?php if ($dob != "") echo $dob; else echo "&nbsp;" ?></td>
        <td><?php if ($school != "") echo $school; else echo "&nbsp;" ?></td>
        <td><?php if ($grade != "") echo $grade; else echo "&nbsp;" ?></td>
        <td><?php if ($shirtsize != "") echo $shirtsize; else echo "&nbsp;" ?></td>
        <td><?php if ($numshirts != "") echo $numshirts; else echo "&nbsp;" ?></td>
        <td><?php if ($week1am != "") echo $week1am; else echo "&nbsp;" ?></td>
        <td><?php if ($week1pm != "") echo $week1pm; else echo "&nbsp;" ?></td>
        <td><?php if ($week2am != "") echo $week2am; else echo "&nbsp;" ?></td>
        <td><?php if ($week2pm != "") echo $week2pm; else echo "&nbsp;" ?></td>
        <td><?php if ($week3am != "") echo $week3am; else echo "&nbsp;" ?></td>
        <td><?php if ($week3pm != "") echo $week3pm; else echo "&nbsp;" ?></td>
        <td><?php if ($week4am != "") echo $week4am; else echo "&nbsp;" ?></td>
        <td><?php if ($week4pm != "") echo $week4pm; else echo "&nbsp;" ?></td>
        <td><?php if ($week5am != "") echo $week5am; else echo "&nbsp;" ?></td>
        <td><?php if ($week5pm != "") echo $week5pm; else echo "&nbsp;" ?></td>
        <td><?php if ($week6am != "") echo $week6am; else echo "&nbsp;" ?></td>
        <td><?php if ($week6pm != "") echo $week6pm; else echo "&nbsp;" ?></td>
        <td><?php if ($extendedcare != "") echo $extendedcare; else echo "&nbsp;" ?></td>
        <td><?php if ($doctorname != "") echo $doctorname; else echo "&nbsp;" ?></td>
        <td><?php if ($doctorphone != "") echo $doctorphone; else echo "&nbsp;" ?></td>
        <td><?php if ($insurance != "") echo $insurance; else echo "&nbsp;" ?></td>
        <td><?php if ($policyholder != "") echo $policyholder; else echo "&nbsp;" ?></td>
        <td><?php if ($illnesses != "") echo $illnesses; else echo "&nbsp;" ?></td>
        <td><?php if ($allergies != "") echo $allergies; else echo "&nbsp;" ?></td>
        <td><?php if ($medication != "") echo $medication; else echo "&nbsp;" ?></td>
        <td><?php if ($medicationnames != "") echo $medicationnames; else echo "&nbsp;" ?></td>
        <td><?php if ($activities != "") echo $activities; else echo "&nbsp;" ?></td>
        <td><?php if ($activitiesnames != "") echo $activitiesnames; else echo "&nbsp;" ?></td>
        <td><?php if ($medicaltreatments != "") echo $medicaltreatments; else echo "&nbsp;" ?></td>
        <td><?php if ($medicaltreatmentsnames != "") echo $medicaltreatmentsnames; else echo "&nbsp;" ?></td>
        <td><?php if ($immunizations != "") echo $immunizations; else echo "&nbsp;" ?></td>
        <td><?php if ($tetanusdate != "") echo $tetanusdate; else echo "&nbsp;" ?></td>
        <td><?php if ($comments != "") echo $comments; else echo "&nbsp;" ?></td>

        <td><?php if ($parentid != "") echo $parentid; else echo "&nbsp;" ?></td>
        <td><?php if ($regtime != "") echo $regtime; else echo "&nbsp;" ?></td>
        <td><?php if ($location != "") echo $location; else echo "&nbsp;" ?></td>
        <td><?php if ($guardian1namefirst != "") echo $guardian1namefirst; else echo "&nbsp;" ?></td>
        <td><?php if ($guardian1namelast != "") echo $guardian1namelast; else echo "&nbsp;" ?></td>
        <td><?php if ($guardian2namefirst != "") echo $guardian2namefirst; else echo "&nbsp;" ?></td>
        <td><?php if ($guardian2namelast != "") echo $guardian2namelast; else echo "&nbsp;" ?></td>
        <td><?php if ($address1 != "") echo $address1; else echo "&nbsp;" ?></td>
        <td><?php if ($address2 != "") echo $address2; else echo "&nbsp;" ?></td>
        <td><?php if ($country != "") echo $country; else echo "&nbsp;" ?></td>
        <td><?php if ($city != "") echo $city; else echo "&nbsp;" ?></td>
        <td><?php if ($state != "") echo $state; else echo "&nbsp;" ?></td>
        <td><?php if ($zip != "") echo $zip; else echo "&nbsp;" ?></td>
        <td><?php if ($guardianemail1 != "") echo $guardianemail1; else echo "&nbsp;" ?></td>
        <td><?php if ($guardianemail2 != "") echo $guardianemail2; else echo "&nbsp;" ?></td>
        <td><?php if ($guardian1phone1 != "") echo $guardian1phone1; else echo "&nbsp;" ?></td>
        <td><?php if ($guardian1phone2 != "") echo $guardian1phone2; else echo "&nbsp;" ?></td>
        <td><?php if ($guardian2phone1 != "") echo $guardian2phone1; else echo "&nbsp;" ?></td>
        <td><?php if ($guardian2phone2 != "") echo $guardian2phone2; else echo "&nbsp;" ?></td>
        <td><?php if ($emergencyname1first != "") echo $emergencyname1first; else echo "&nbsp;" ?></td>
        <td><?php if ($emergencyname1last != "") echo $emergencyname1last; else echo "&nbsp;" ?></td>
        <td><?php if ($emergencyrelationship1 != "") echo $emergencyrelationship1; else echo "&nbsp;" ?></td>
        <td><?php if ($emergencyphone1 != "") echo $emergencyphone1; else echo "&nbsp;" ?></td>
        <td><?php if ($emergencyauthorized1 != "") echo $emergencyauthorized1; else echo "&nbsp;" ?></td>
        <td><?php if ($emergencyname2first != "") echo $emergencyname2first; else echo "&nbsp;" ?></td>
        <td><?php if ($emergencyname2last != "") echo $emergencyname2last; else echo "&nbsp;" ?></td>
        <td><?php if ($emergencyrelationship2 != "") echo $emergencyrelationship2; else echo "&nbsp;" ?></td>
        <td><?php if ($emergencyphone2 != "") echo $emergencyphone2; else echo "&nbsp;" ?></td>
        <td><?php if ($emergencyauthorized2 != "") echo $emergencyauthorized2; else echo "&nbsp;" ?></td> -->

    </tr>
<?php

$i++;
}
?>

</table>

</body>
</html>