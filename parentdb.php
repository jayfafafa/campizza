<?php
include("registerparent.html");

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

$sql = "INSERT INTO Parents (parentid, regtime, location, guardiannamefirst1,"
		."guardiannamelast1, guardiannamefirst2, guardiannamelast2, address1, address2, city, "
		."state, zip, email1, email2, emailtype2, phone1, phonetype1, phone2, "
		."phone3, phone4, phonetype4, emergencynamefirst1, "
		."emergencynamelast1, emergencyrelationship1, emergencyphone1, emergencyauthorized1, "
		."emergencynamefirst2, emergencynamelast2, emergencyrelationship2, emergencyphone2, "
		."emergencyauthorized2)"
        . "VALUES (:parentid, :regtime, :location, :mothernamefirst,"
		.":mothernamelast, :fathernamefirst, :fathernamelast, :address1, :address2, :city,"
		." :state, :zip, :email1, :emailtype1, :email2, :emailtype2, :phone1, :phonetype1, :phone2,"
		." :phonetype2, :phone3, :phonetype3, :phone4, :phonetype4, :emergencynamefirst1, "
		.":emergencynamelast1, :emergencyrelationship1, :emergencyphone1, :emergencyauthorized1, "
		.":emergencynamefirst2, :emergencynamelast2, :emergencyrelationship2, :emergencyphone2, "
		.":emergencyauthorized2)"

$stmt = $conn->prepare($sql);
$stmt->execute(array(
    ':product' => $_POST['product'],
    ':quantity' => $_POST['quantity'],
    ':first' => $_POST['first'],
    ':last' => $_POST['last'],
    ':email' => $_POST['email'],
    ':phone' => $_POST['phone'],
    ':shipping' => $_POST['shipping'],
    ':state' => $_POST['state'],
    ':city' => $_POST['city'],
    ':zip' => $_POST['zip'],
    ':country' => $_POST['country'],
    ':shippingmethod' => $_POST['shippingmethod'],
    ':cardOwner' => $_POST['cardOwner'],
    ':cardNumber' => $_POST['cardNumber'],
    ':securityCode' => $_POST['securityCode'],
    ':expMonth' => $_POST['expMonth'],
    ':expYear' => $_POST['expYear']
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
