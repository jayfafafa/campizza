<?php
include ('connection.php');

if($_SERVER["REQUEST_METHOD"] == "POST"){
	$passwordPreHash = rand(99999, 2147000000);
	$password = password_hash($passwordPreHash, PASSWORD_DEFAULT);
	
	$loginemail = "";
	$loginemail_err = "";
	
	$sql = "UPDATE ParentsLogin SET password =:password WHERE loginemail =:loginemail";
	if($stmt = $conn->prepare($sql)){
			$stmt->bindParam(":password", $password, PDO::PARAM_STR);
            $stmt->bindParam(":loginemail", $_POST['loginemail'], PDO::PARAM_STR);
		if($stmt->execute()) {
			$to = $_POST['loginemail'];
			$subject = "CampIzza Password Reset";  
			$message = $passwordPreHash;  
			$from = "Reset@campizza.com";  
			$headers = "From: $from";  
			mail($to,$subject,$message,$headers);
			$message = "Password has been successfully reset, Check your email!";
			echo "<script type='text/javascript'>alert('$message'); window.location ='login.php'; </script>";
			//header("Location: login.php");
		}
	}

	
	
}
unset($conn);
?>


<!doctype html>
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
		<form class="form-signin" <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<img class="mb-4" src="https://static.wixstatic.com/media/46af7c_6c86140c4f8e479e95cb12c1bddfa5f1~mv2.gif" alt="" width="183" height="136">
			<h1 class="h3 mb-3 font-weight-normal">Forgot Passsword?</h1>
			<label for="inputEmail" class="sr-only" >Email address</label>
			<input name="loginemail" type="email" id="inputEmail" class="form-control" placeholder="Email address" value="<?php echo $loginemail; ?>" required autofocus>
			<!-- <span class="help-block"><?php echo $loginemail_err; ?></span> -->
			<br>
			<button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
			<p class="mt-5 mb-3 text-muted">&copy; Camp Izza 2019</p>
		</form>
	</body>
	
</html>
