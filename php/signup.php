<?php
// Include config file
require_once "connection.php";

// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && isset($_SESSION["registered"]) && ($_SESSION["registered"] === true)) {
    header("location: dashboard.php");
    exit;
}
// Require https
if ($_SERVER['HTTPS'] != "on") {
    $url = "https://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    header("Location: $url");
    exit;
}
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT parentid FROM ParentsLogin WHERE loginemail = :username";
        
        if($stmt = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $username_err = "This username is already taken.";
                } elseif(!filter_var(trim($_POST["username"]), FILTER_VALIDATE_EMAIL)){
                	$username_err = "Not a valid email";
                }
                else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        unset($stmt);
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO ParentsLogin (loginemail, password) VALUES (:username, :password)";
         
        if($stmt = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
				$id = $conn->lastInsertId();
				
				// Store data in session variables
				$_SESSION["loggedin"] = true;
				$_SESSION["id"] = $id;
				$_SESSION["username"] = $username;
				$_SESSION["registered"] = false;

				/*
				if($_SESSION["loggedin"]){echo 'logged in ';};
				echo $_SESSION["id"]; echo '  ';
				echo $_SESSION["username"];
				if(!$_SESSION["registered"]) {echo ' registered';};
				*/
				
                // Redirect to parent registration page				
                header("location: parentregistration.php");
            } else {
                echo "Something went wrong. Please try again later.";
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
		<h1 class="h3 mb-3 font-weight-normal">Create an Account</h1>
		
		
			
			<label for="inputEmail" class="sr-only" <?php echo (!empty($username_err)) ? 'has-error' : ''; ?> >Email address</label>
			<input name="username" type="semail" id="inputEmail" class="form-control" placeholder="Email address" value="<?php echo $username; ?>" required autofocus>
			<span class="help-block"><?php echo $username_err; ?> </span>
			
			
			<label for="inputPassword" class="sr-only" <?php echo (!empty($password_err)) ? 'has-error' : ''; ?> >Password</label>
			<input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" value="<?php echo $password; ?>" required>
			<span class="help-block"><?php echo $password_err; ?> </span>
			
			
			<label for="inputPassword" class="sr-only" <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?> >Confirm Password</label>
			<input name="confirm_password" type="password" id="inputPassword" class="form-control" placeholder="Confirm Password" value="<?php echo $confirm_password; ?>" required>
			<span class="help-block"><?php echo $confirm_password_err; ?></span>
			
			
		<input type="submit" class="btn btn-lg btn-primary btn-block" value="Submit">
		<!-- <button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button> -->
		<hr>
		<p class="mt-5 mb-3 text-muted">&copy; Camp Izza 2019</p>
	</form>
</body>
</html>
