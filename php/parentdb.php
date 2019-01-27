<?php
if(isset($_POST['guardiannamefirst1'])){
	header('Location: login.html');
	exit;
} else {
	header('Location: registerparent.html');
}
//include("registerparent.html");

date_default_timezone_set('America/Los_Angeles');
$regtime = date('m/d/Y h:i:s a', time());
include("connection.php");

$sql = "INSERT INTO Parents (regtime, location, guardiannamefirst1,"
		."guardiannamelast1, guardiannamefirst2, guardiannamelast2, address1, address2,"
		."internationaladdress1, internationaladdress2, country, city, "
		."state, zippostalcode, guardianemail1, guardianemail2, guardian1phone1, guardian1phone2,"
		."guardian2phone1, guardian2phone2, emergencynamefirst1, emergencynamelast1,"
		."emergencyrelationship1, emergencyphone1, emergencyauthorized1, "
		."emergencynamefirst2, emergencynamelast2, emergencyrelationship2, emergencyphone2, "
		."emergencyauthorized2,balance)"
        . "VALUES (:regtime, :location, :guardiannamefirst1,"
		.":guardiannamelast1, :guardiannamefirst2, :guardiannamelast2, :address1, :address2,"
		.":internationaladdress1, :internationaladdress2, :country, :city, "
		.":state, :zippostalcode, :guardianemail1, :guardianemail2, :guardian1phone1, :guardian1phone2,"
		.":guardian2phone1, :guardian2phone2, :emergencynamefirst1, :emergencynamelast1,"
		.":emergencyrelationship1, :emergencyphone1, :emergencyauthorized1, "
		.":emergencynamefirst2, :emergencynamelast2, :emergencyrelationship2, :emergencyphone2, "
		.":emergencyauthorized2, :balance)";

$data = [
	':regtime' => $regtime,
    ':location' => NULL,
    ':guardiannamefirst1' => $_POST['guardiannamefirst1'],
    ':guardiannamelast1' => $_POST['guardiannamelast1'],
    ':guardiannamefirst2' => $_POST['guardiannamefirst2'],
    ':guardiannamelast2' => $_POST['guardiannamelast2'],
    ':address1' => $_POST['address1'],
    ':address2' => $_POST['address2'],
    ':internationaladdress1' => $_POST['internationaladdress1'],
    ':internationaladdress2' => $_POST['internationaladdress2'],
    ':country' => $_POST['country'],
    ':city' => $_POST['city'],
    ':state' => NULL,
    ':zippostalcode' => $_POST['zip'],
    ':guardianemail1' => $_POST['email1'],
    ':guardianemail2' => $_POST['email2'],
    ':guardian1phone1' => $_POST['guardianphone1'],
    ':guardian1phone2' => $_POST['guardianphone2'],
    ':guardian2phone1' => NULL,
    ':guardian2phone2' => NULL,
    ':emergencynamefirst1' => $_POST['emergencynamefirst1'],
    ':emergencynamelast1' => $_POST['emergencynamelast1'],
    ':emergencyrelationship1' => $_POST['emergencyrelationship1'],
    ':emergencyphone1' => $_POST['emergencyphone1'],
    ':emergencyauthorized1' => "yes",
    ':emergencynamefirst2' => $_POST['emergencynamefirst2'],
    ':emergencynamelast2' => $_POST['emergencynamelast2'],
    ':emergencyrelationship2' => $_POST['emergencyrelationship2'],
    ':emergencyphone2' => $_POST['emergencyphone2'],
    ':emergencyauthorized2' => "no",
    ':balance' => 0
];

$stmt = $conn->prepare($sql)->execute($data);

echo 'this is broken';

// Close connection
unset($conn);

?>