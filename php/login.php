<?php

// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(  (isset($_SESSION["loggedin"]) && isset($_SESSION["registered"]) ) && ( $_SESSION["loggedin"] === true && $_SESSION["registered"] === true )){
    header("location: dashboard.php");
    exit;
}   else if ( ( isset($_SESSION["loggedin"]) && isset($_SESSION["registered"]) ) && ( $_SESSION["loggedin"] === true && $_SESSION["registered"] === false) ){
	//delete session registered
    header("location: parentregistration.php");
    exit;
}
 
// Include config file
require_once "connection.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT parentid, loginemail, password FROM ParentsLogin WHERE loginemail = :username";
        
        if($stmt = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Check if username exists, if yes then verify password
                if($stmt->rowCount() == 1){
                    if($row = $stmt->fetch()){
                        $id = $row["parentid"];
                        $username = $row["loginemail"];
                        $hashed_password = $row["password"];
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
							
								$sqlRegistered = "SELECT * FROM Parents WHERE parentid=".$id;
								$stmtRegistered = $conn->prepare($sqlRegistered);
								$stmtRegistered->execute();
								if($stmtRegistered->rowCount() == 1) {
									$_SESSION['registered'] = true;
									//Redirect user to welcome page
									header("location: dashboard.php");
								} else {
									$_SESSION['registered'] = false;
									header("location: parentregistration.php");
								}
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
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
		<h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
		
			<span class="help-block"><?php echo $username_err; ?></span>
			<label for="inputEmail" class="sr-only">Email address</label>
			<input <?php echo (!empty($username_err)) ? 'has-error' : ''; ?> name="username" type="email" id="inputEmail" class="form-control" placeholder="Email address" value="<?php echo $username; ?>" required autofocus>

			
			
			<label for="inputPassword" class="sr-only">Password</label>
			<input  <?php echo (!empty($password_err)) ? 'has-error' : ''; ?> name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
			<span class="help-block"><?php echo $password_err; ?></span>
			
		<input type="submit" class="btn btn-lg btn-primary btn-block" value="Sign in">
		<!-- <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button> -->
		<hr>
		<a class="btn btn-sm btn-warning btn-block" href="/signup.php" role="button">New? Register here!</a>
		<a class="btn btn-sm btn-outline-info btn-block" href="/forgot.php" role="button">Forgot Password</a>
		<p class="mt-5 mb-3 text-muted">&copy; Camp Izza 2019</p>
	</form>
</body>
</html>
