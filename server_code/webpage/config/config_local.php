<?php

/***********************************************
 * config_local.php                                  *
 *                                             *
 * This is the configuration for the database. *
 ***********************************************/

// make sure that this file cannot be directly accessed
if (stristr(htmlentities($_SERVER["PHP_SELF"]), "config.php")) {
	header("Location: index.php");
	exit();
}

// database options
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'capstone_login');
define('DB_PASSWORD', 'capstone_login');
define('DB_NAME', 'capstone_login');

/**********************************
 * DO NOT EDIT THE OPTIONS BELOW! *
 **********************************/

// attempt to connect to the database
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// check the connection
if ($conn === false)
	die("ERROR: Could not connect: " . mysqli_connect_error());


?>
