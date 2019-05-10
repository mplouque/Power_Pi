<?php

// initialize the session
session_start();
 
// check if the user is logged in
// if not, redirect to the login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
{
	header("location: login.php");
	exit;
}

?>
 
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Welcome</title>
		<link rel="stylesheet" href="bootstrap.css">
		<link rel="stylesheet" href="slider.css">
		
		<style type="text/css">
			body
			{
				font: 14px sans-serif;
				text-align: center;
			}
		</style>
	</head>
	<body>
		<div class="page-header">
			<h1><b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>'s' Dashboard</h1>
		</div>
		<div>

			<h2> Control Panel </h2>

			<iframe src="test.php" frameborder = "0" height = "300" width = "100%" align = "middle" scrolling = "yes" ></iframe>
			<br>

			<iframe src="graph.html" frameborder = "0" height = "500" width = "100%" align = "middle"></iframe>


			
		</div>
		
		<p>
			<a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
			<a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
		</p>
	</body>
</html>
