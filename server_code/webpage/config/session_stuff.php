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

$time = $_SERVER['REQUEST_TIME'];

/**
* for a 30 minute timeout, specified in seconds
*/
//the below variables must all be the same
//commmented out vars are located in php.ini
//session.gc_maxlifetime = 30;
//session.cookie_lifetime = 30;
$timeout_duration = 180;

/**
* Here we look for the user's LAST_ACTIVITY timestamp. If
* it's set and indicates our $timeout_duration has passed,
* blow away any previous $_SESSION data and start a new one.
*/
if (isset($_SESSION['LAST_ACTIVITY']) && 
($time - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) 
{	
	session_unset();
	session_destroy();
	session_start();
	header("location: logout.php");
}

/**
* Finally, update LAST_ACTIVITY so that our timeout
* is based on it and not the user's login time.
*/
$_SESSION['LAST_ACTIVITY'] = $time;

?>
