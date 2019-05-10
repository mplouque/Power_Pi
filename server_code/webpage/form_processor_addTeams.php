<?php 
	// make sure that this file cannot be directly accessed
	/*if (stristr(htmlentities($_SERVER["PHP_SELF"]), "form_processor.php")) 
	{
		header("Location: index.php");
		exit();
	}*/
require_once "config/session_stuff.php";
require_once "config/config_local_new.php";



function getNumTeams()
{
	
	$numTeams=0;

	$sql = "SELECT * FROM `teams` ORDER BY id";
	//echo "here";
	if ($result = mysqli_query(LOCAL_DB::conn(), $sql))
	{
		if (mysqli_num_rows($result) > 0) 
		{
            while($row = mysqli_fetch_assoc($result)) 
            {

               $numTeams++;
               //echo "state " . $row["state"]. "<br>";
            }
        }
        else 
        {
            $numTeams=-1;//echo "0 results";
        }
        // mysqli_close($conn);
	}
	else
	{
		$numTeams = -1;
	}
	// close the db connection
	//mysqli_close($conn);
	//mysqli_close(LOCAL_DB::conn());

	return$numTeams;

}

function getTeamIPs()
{
	$ipList = array();
	$numTeams=0;

	$sql = "SELECT `ip` FROM `teams` ORDER BY id";
	//echo "here";
	if ($result = mysqli_query(LOCAL_DB::conn(), $sql))
	{
		if (mysqli_num_rows($result) > 0) 
		{
            while($row = mysqli_fetch_assoc($result)) 
            {

               array_push($ipList, $row['ip']);
               //echo "state " . $row["state"]. "<br>";
            }
        }
        else 
        {
            $numTeams=-1;//echo "0 results";
        }
        // mysqli_close($conn);
	}
	else
	{
		$numTeams = -1;
	}
	// close the db connection
	//mysqli_close($conn);
	//mysqli_close(LOCAL_DB::conn());



	return$ipList;
}






$numTeamsCurr = getNumTeams();


//counter=1
//loop forever
	//blank sql query
	//check the values
		//if null
			//break
			
		//if not valid
			//error

		//if valid
			//set them in the sql query
			//excute the sql query

	//counter++


$sqlVal = "";
$a = array();

$counter = 1;
while (True)
{
	$teamNameVal = "";
	$teamIpVal= "";
	$teamString = "team".$counter;
	$teamColorVal = "";
	if (isset($_GET[$teamString."_name"]) && $_GET[$teamString."_name"] != "")
	{
		$teamNameVal = $_GET[$teamString."_name"];
	}
	else
	{
		break;
	}

	if (isset($_GET[$teamString."_ip"]) && $_GET[$teamString."_ip"] != "")
	{
		$teamIpVal = $_GET[$teamString."_ip"];
	}
	else
	{
		break;
	}
	if (isset($_GET[$teamString."_color"]) && $_GET[$teamString."_color"] != "")
	{
		$teamColorVal = $_GET[$teamString."_color"];
	}
	else
	{
		break;
	}
	$teamClearVal = isset($_GET[$teamString."_clear"]);
	

	echo $teamNameVal;
	echo "<br>";
	echo $teamIpVal;
	echo "<br>";
	echo $teamColorVal;
	echo "<br>";
	//$sqlVal.="INSERT INTO `teams` (name,ip) VALUES (".$teamNameVal.",".$teamIpVal.");";
	//echo $sqlVal;
	array_push($a, $teamNameVal, $teamIpVal, $teamColorVal, $teamClearVal);
	echo implode(",",$a);
	echo "<br>";
	echo "<br>";
	$counter++;
}



/////////////////SQL///////////////////////////
$sql = "DELETE FROM `teams`";
echo "here";
if ($stmt = LOCAL_DB::conn()->prepare($sql))
{
	echo "here2";
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


// prepare a sql statement
for ($i = 1; $i<$counter; $i++)
{
	$sql = "INSERT INTO `teams` (id,name,ip, color) VALUES (?,?,?,?)";
	echo "here";
	if ($stmt2 = mysqli_prepare(LOCAL_DB::conn(), $sql))
	{
		echo "here2";
		// bind variables to the sql statement as parameters
		mysqli_stmt_bind_param($stmt2, "isss", $p1,$p2,$p3,$p4);
		echo "here3";
		// set parameters
		$p1 = $i;
		$p2 = $a[($i-1)*4];
		$p3 = $a[($i-1)*4+1];
		$p4 = $a[($i-1)*4+2];

		// attempt to execute the sql statement
		if (mysqli_stmt_execute($stmt2))
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
mysqli_stmt_close($stmt2);
	
}

//if the team already exists drop the table
for ($i = 1; $i<=$numTeamsCurr; $i++)
{
	$currTeam = "team".$i."_data";
	$sql = "DROP TABLE IF EXISTS ".$currTeam;
	if ($stmt3 = mysqli_prepare(LOCAL_DB::conn(), $sql))
	{
		echo "table_drop_prepared ";

		// attempt to execute the sql statement
		if (mysqli_stmt_execute($stmt3))
			// redirect to the login page
			//header("location: login.php");
			echo "Tables Dropped successfully";
		else
			echo "Oops!  Something went wrong with dropping tables.  Please try again later.";
	}
	else
	{
		echo "HERE";
	}
}
// close the sql statement
mysqli_stmt_close($stmt3);


//create tables for each teams data to be stored on the webserver
for ($i = 1; $i<$counter; $i++)
{
	$currTeam = "team".$i."_data";
	$sql = "CREATE TABLE $currTeam (`id` int(10) NOT NULL AUTO_INCREMENT,`amps` float(7,4) NOT NULL,`watts` float(7,4) NOT NULL, `wattHours` float(21,4) NOT NULL, `timestamp` timestamp NOT NULL, `nowTS` datetime NOT NULL, PRIMARY KEY (`id`))";
	if ($stmt4 = mysqli_prepare(LOCAL_DB::conn(), $sql))
	{
		echo "table_prepared ";

		// attempt to execute the sql statement
		if (mysqli_stmt_execute($stmt4))
			// redirect to the login page
			//header("location: login.php");
			echo "Table Created successfully";
		else
			echo "Oops!  Something went wrong with table creation.  Please try again later.";
	}
	else
	{
		echo "HERE";
	}
}
// close the sql statement
mysqli_stmt_close($stmt4);


$ipList = getTeamIPs();
for ($i = 1; $i<$counter; $i++)
{
	if ($a[($i-1)*4+3])
	{
		//clear the table
		$sql = "TRUNCATE TABLE data";

		$remotePiConn = mysqli_connect($ipList[($i-1)], 'capstone_pi_readings','capstone_pi_readings','capstone_pi_readings');
		
		if ($stmt5 = mysqli_prepare($remotePiConn, $sql))
		{
			if (mysqli_stmt_execute($stmt5))
			{
				echo "Data table dumped remotely successfully";
			}
			else
			{
				echo "Table clear was unsuccessful";
			}
		}
		else
		{
			echo "Statement prepare failed";
		}

	}
}

mysqli_stmt_close($stmt5);



header("location: AddTeamForm.php")



/*
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

*/

?>