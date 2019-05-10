<?php

	/***********************************************
	 * config_pp.php                                  *
	 *                                             *
	 * This is the configuration for the database. *
	 ***********************************************/

	// make sure that this file cannot be directly accessed
	if (stristr(htmlentities($_SERVER["PHP_SELF"]), "config.php")) {
		header("Location: index.php");
		exit();
	}


	// database options
	define('DB_SERVER2', '192.168.0.19');
	define('DB_USERNAME2', 'capstone_pi_readings');
	define('DB_PASSWORD2', 'capstone_pi_readings');
	define('DB_NAME2', 'capstone_pi_readings');

	/**********************************
	 * DO NOT EDIT THE OPTIONS BELOW! *
	 **********************************/

	// attempt to connect to the database
	$conn2 = mysqli_connect(DB_SERVER2, DB_USERNAME2, DB_PASSWORD2, DB_NAME2);
	 
	// check the connection
	if ($conn2 === false)
		die("ERROR: Could not connect: " . mysqli_connect_error());






?>