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
else 
{
	header("location: HomeView1.php");
}

?>

