<?php


// Include config file
require_once "connection.php";

// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true){
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

// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Password must have atleast 6 characters.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm the password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
        
    // Check input errors before updating the database
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Prepare an update statement
        $sql = "UPDATE ParentsLogin SET password = :password WHERE parentid = :id";
        
        if($stmt = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
            
            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: login.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        unset($stmt);
    }
    
    // Close connection
    unset($conn);
}


?>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- Original Authors: Mark Otto, Jacob Thornton, and Bootstrap contributors -->
		<title>Camp Izza | Summer Day Camp | Irvine, CA</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fredericka+the+Great">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
		<link rel="stylesheet" href="registrationstyle.css">

		<style>
		  .bd-placeholder-img {
			font-size: 1.125rem;
			text-anchor: middle;
		  }

		  @media (min-width: 768px) {
			.bd-placeholder-img-lg {
			  font-size: 3.5rem;
			}
		  }
		</style>
		<!-- Custom styles for this template -->
		<link href="signin.css" rel="stylesheet">
	</head>

<body class="text-center">
	<form class="form-signin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
		<img class="mb-4" src="https://static.wixstatic.com/media/46af7c_6c86140c4f8e479e95cb12c1bddfa5f1~mv2.gif" alt="" width="183" height="136">
		<h1 class="h3 mb-3 font-weight-normal">Change password</h1>
			
			
			<label for="inputPassword" class="sr-only" <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?> >New Password</label>
			<input name="new_password" type="password" id="inputPassword" class="form-control" placeholder="New Password" value="<?php echo $new_password; ?>" required>
			<span class="help-block"><?php echo $new_password_err; ?></span>
			
			
			<label for="inputPassword" class="sr-only" <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?> >Confirm New Password</label>
			<input name="confirm_password" type="password" id="inputPassword" class="form-control" placeholder="Confirm New Password" value="<?php echo $confirm_password; ?>" required>
			<span class="help-block"><?php echo $confirm_password_err; ?></span>
			
			
		<input type="submit" class="btn btn-lg btn-primary btn-block" value="Submit">
		<!-- <button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button> -->
		<hr>
		<p class="mt-5 mb-3 text-muted">&copy; Camp Izza 2019</p>
	</form>
</body>
</html>
