<?php
include("studentregistration.html");

/*
echo '
    <div>
        <table class="product">
            <tr>
                <th></th>
                <th>Name</th>
                <th>Price</th>
            </tr>';
*/
include("connection.php");

$sql = "INSERT INTO Children (firstname, lastname, gender,"
		."dob, doctorname, "
		."doctorphone, insurance, policyholder, illnesses, allergies, medication, "
		."medicationnames, activities, activitiesnames, medicaltreatments, medicaltreatmentsnames, "
		."immunizations, tetanusdate, comments)"
        . "VALUES (:firstname, :lastname, :gender,"
		.":dob, :doctorname, "
		.":doctorphone, :insurance, :policyholder, :illnesses, :allergies, :medication, :medication, "
		.":medicationnames, :activities, :activitiesnames, :medicaltreatments, :medicaltreatmentsnames, "
		.":immunizations, :tetanusdate, :comments)"

$stmt = $conn->prepare($sql);
$stmt->execute(array(
    ':firstname' => $_POST['firstname'],
    ':lastname' => $_POST['lastname'],
    ':gender' => $_POST['gender'],
    ':dob' => $_POST['dob'],
    ':doctorname' => $_POST['doctorname'],
    ':doctorphone' => $_POST['doctorphone'],
    ':insurance' => $_POST['insurance'],
    ':policyholder' => $_POST['policyholder'],
    ':illnesses' => $_POST['illnesses'],
    ':allergies' => $_POST['allergies'],
    ':medication' => $_POST['medication'],
    ':medicationnames' => $_POST['medicationnames'],
    ':activities' => $_POST['activities']
	':activitiesnames' => $_POST['activitiesnames']
	':medicaltreatments' => $_POST['medicaltreatments']
	':medicaltreatmentsnames' => $_POST['medicaltreatmentsnames']
	':immunizations' => $_POST['immunizations']
	':tetanusdate' => $_POST['tetanusdate']
	':comments' => $_POST['comments']
/*
$stmt = $conn->query("SELECT Name,ImgSrc,Alt,Price,ID FROM Products");
while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
    echo ' <tr><td class="productImage"><a href=" ';
    echo ('/product.php?ID='.$row['ID']); //actual link (for product page)
    echo ' "> ';
    echo ' <img class="product thumbnailList" alt="';
    echo ($row['Alt']); //alt text
    echo '" src=" ';
    echo ($row['ImgSrc']); //image source link
    echo ' "></a> </td>';
    echo '<td class="product">';
    echo ($row['Name']);
    echo ' </td> <td class="product"> ';
    echo ('$'.$row['Price']);
    echo '</td> </tr>';
} 
*/

/*
echo "</table> </div>";
*/

?>
