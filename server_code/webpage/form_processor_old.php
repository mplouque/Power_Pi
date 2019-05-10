<?php 
	// make sure that this file cannot be directly accessed
	/*if (stristr(htmlentities($_SERVER["PHP_SELF"]), "form_processor.php")) 
	{
		header("Location: index.php");
		exit();
	}*/
require_once "config/session_stuff.php";
require_once "config/config_local_new.php";

$sqlVal = "";
if ($_SERVER["REQUEST_METHOD"] == "GET")
{
	$team1Val = "";
	if (isset($_GET['team1']))
	{
		$team1Val = $_GET['team1'];
		if ($team1Val == "on")
		{
			$sqlVal = "on";
		}
		else if ($team1Val == "off")
		{
			$sqlVal = "off";
		}
		else
		{
			$sqlVal = "invalid";
		}

	}
	else
	{
		$team1Val = "error";
		$sqlVal = "error";
	}
	echo $sqlVal; 


	// check for input errors before inserting data into the database

	// prepare a sql statement
	$sql = "INSERT INTO power_load (state) VALUES (?)";
	echo "here";
	if ($stmt = mysqli_prepare($conn2, $sql))
	{
		echo "here2";
		// bind variables to the sql statement as parameters
		mysqli_stmt_bind_param($stmt, "s", $param_onoff);
		echo "here3";
		// set parameters
		$param_onoff = $sqlVal;

		// attempt to execute the sql statement
		if (mysqli_stmt_execute($stmt))
			// redirect to the login page
			//header("location: login.php");
			echo "Value inserted successfully";
		else
			echo "Oops!  Something went wrong.  Please try again later.";
	}
	else
	{
		echo "HERE";
	}

	// close the sql statement
	mysqli_stmt_close($stmt);


	// close the db connection
	mysqli_close($conn2);

}
else
{
	echo "NOT GET";
}

header("Location: test.php");



?>