<?php 
	// make sure that this file cannot be directly accessed
	/*if (stristr(htmlentities($_SERVER["PHP_SELF"]), "form_processor.php")) 
	{
		header("Location: index.php");
		exit();
	}*/
//require_once "config/session_stuff.php";
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

function getTeamPowerState($team)
{
	$teamState="";
	echo "THIS IS THE TEAM:".$team."<br>";
	$sql = "SELECT `state` FROM `power_load` WHERE id = ".$team;
	//echo "here";
	if ($result = mysqli_query(LOCAL_DB::conn(), $sql))
	{
		if (mysqli_num_rows($result) > 0) 
		{
            echo "HERENOW";
            while($row = mysqli_fetch_assoc($result)) 
            {
            	echo"INWHILE";
            	$teamState = $row["state"];
               	echo "state " . $row["state"]. "<br>";
            }
        }
        else 
        {
            echo "WRONG COMMAND DUMBASS";
        }
        // mysqli_close($conn);
	}
	else
	{
		echo "CONNS DEAD";
	}
	// close the db connection
	//mysqli_close($conn);
	//mysqli_close(LOCAL_DB::conn());


	return $teamState;
}

$ipList = getTeamIPs();
echo "IPLIST IS:".implode($ipList,",")."<br>";
$numTeams = getNumTeams();
echo "NUMTEAMS IS:".$numTeams."<br>";

$sqlVal = "";
if ($_SERVER["REQUEST_METHOD"] == "GET")
{
	if (isset($_GET['team']))
	{
		$currTeam = $_GET['team'];
		echo $currTeam;
		//get the state for that team
		$teamVal = getTeamPowerState($currTeam);
		echo "TEAM POWER STATE".$teamVal."<br>";
		if ($teamVal == "on")
		{
			$sqlVal = "off";
		}
		else if ($teamVal == "off")
		{
			$sqlVal = "on";
		}
		else
		{
			$sqlVal = "invalid";
		}

	}
	else
	{
		$teamVal = "error";
		$sqlVal = "error";
	}
	echo $sqlVal; 


	// check for input errors before inserting data into the database

	// prepare a sql statement
	$sql = "INSERT INTO power_load (state) VALUES (?)";
	echo "here";

	$remotePiConn = mysqli_connect($ipList[($currTeam-1)], 'capstone_pi_readings','capstone_pi_readings','capstone_pi_readings');


	if ($stmt = mysqli_prepare($remotePiConn, $sql))
	{
		echo "here2";
		// bind variables to the sql statement as parameters
		mysqli_stmt_bind_param($stmt, "s", $param_onoff);
		echo "here3";
		// set parameters
		$param_onoff = $sqlVal;

		// attempt to execute the sql statement
		if (mysqli_stmt_execute($stmt))
		{
			// redirect to the login page
			//header("location: login.php");
			echo "Value inserted successfully";
			$sql3="DELETE FROM power_load WHERE id = ".$currTeam;
			if ($stmt3 = mysqli_prepare(LOCAL_DB::conn(), $sql3))
			{
				// attempt to execute the sql statement
				if (mysqli_stmt_execute($stmt3))
				{
					echo "Value DELETED Locally successfully";
					$sql2 = "INSERT INTO power_load (id,state) VALUES (?,?)";
					if ($stmt2 = mysqli_prepare(LOCAL_DB::conn(), $sql2))
					{
						echo "here2";
						// bind variables to the sql statement as parameters
						mysqli_stmt_bind_param($stmt2, "ss", $param_team, $param_onoff);
						echo "here3";
						// set parameters
						$param_onoff = $sqlVal;
						$param_team = $currTeam;

						// attempt to execute the sql statement
						if (mysqli_stmt_execute($stmt2))
						{
							echo "Value inserted Locally successfully";
						}
						else
						{
							echo "Oops!  Something went wrong.  Please try again later.";
						}
					}
					else
					{
						echo "HERE";
					}
				}
				else
				{
					echo "VALUE DELETION FAILED";
				}
			}

			
		}
	}		

	// close the sql statement
	mysqli_stmt_close($stmt);


	// close the db connection
	mysqli_close($remotePiConn);

}
else
{
	echo "NOT GET";
}


?>