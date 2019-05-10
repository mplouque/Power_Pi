<?php
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


	return$numTeams;
}


function fillStateArray()
{

	$a=array();

	$sql = "SELECT * FROM `power_load` ORDER BY id";
	//echo "here";
	if ($result = mysqli_query(LOCAL_DB::conn(), $sql))
	{
		if (mysqli_num_rows($result) > 0) 
		{
            while($row = mysqli_fetch_assoc($result)) 
            {

               array_push($a,$row["state"]);
               //echo "state " . $row["state"]. "<br>";
            }
        }
        else 
        {
           //echo "0 results";
        }
        // mysqli_close($conn);
	}
	else
	{
		
	}
	// close the db connection
	//mysqli_close($conn);


	return$a;

}


function echoPage($s)
{
	$pageString=
	"<html> 
		<head>
			<title>Dynamic Dashboard</title>
			<link rel=\"stylesheet\" href=\"slider.css\">
			<link rel=\"stylesheet\" href=\"main.css\">
			<script type=\"text/javascript\" src=\"jquery-1.9.1.min.js\"></script>
			<script type=\"text/javascript\" src=\"test.js\"></script>
		</head>
		<body>
			<form id=\"controller\" action=\"form_processor.php\">";

	$pageString.=$s;

	$pageString.="
				<button type=\"submit\">GO!</button>
			</form>
		</body>
	</html>";
	
	echo $pageString; 
}

//needs to instead ping the db to figure out how many teams
$numTeams=getNumTeams();
$workingString="";
$stateArray = fillStateArray();
//echoPage("<p>Hello<br></p>");
function graphMath($numTeams)
{
	//if more than 4 teams
	if ($numTeams>=4)
	{
		//3 teams per row 
		$width = 100/3;
	}
	else
	{
		$width = 100;
	}
	$height = 50;
	$retVal = array($height, $width);
	return $retVal;
}

//math for graphs
$graphHeight = (graphMath($numTeams))[0];
$graphWidth = (graphMath($numTeams))[1];


for ($i=0; $i<$numTeams; $i++)
{
	$teamString = "team".$i+1;
	//\" frameborder = \"0\" height = \"500\" width = \"100%\" align = \"middle\"
	$workingString.="<div class = \"halfheight thirdwidth_down\">";
		$workingString.="<iframe src=\"capstoneChart/indexNewMatt.php?id=[".($i+1)."]\" scrolling=\"no\"></iframe>";
		#button stuff
		$workingString.="<div>";
			/*if ($stateArray[$i] == "on")
			{
				$workingString.="
				<label class=\"switch\">
						<input type=\"checkbox\" id=\"".$teamString."\" name=\"".$teamString."_name\" value=\"".$teamString."_value\" checked/>
						<span class = \"slider round\"></span>
				</label>

				<label for=\"".$teamString."\">Team ".($i+1)."</label><p/>
				<br>";
			}
			else if ($stateArray[$i] == "off")
			{
				$workingString.="
				<label class=\"switch\">
						<input type=\"checkbox\" id=\"".$teamString."\" name=\"".$teamString."_name\" value=\"".$teamString."_value\" />
						<span class = \"slider round\"></span>
				</label>

				<label for=\"".$teamString."\">Team ".($i+1)."</label><p/>
				<br>";
			}
			else
			{
				//error
			}*/
		$workingString.="</div>";
	$workingString.="</div>";


	/*if ($stateArray[$i] == "on")
	{
		$workingString.="
		<label class=\"switch\">
				<input type=\"checkbox\" id=\"".$teamString."\" name=\"".$teamString."_name\" value=\"".$teamString."_value\" checked/>
				<span class = \"slider round\"></span>
		</label>

		<label for=\"".$teamString."\">Team ".($i+1)."</label><p/>
		<br>";
	}
	else if ($stateArray[$i] == "off")
	{
		$workingString.="
		<label class=\"switch\">
				<input type=\"checkbox\" id=\"".$teamString."\" name=\"".$teamString."_name\" value=\"".$teamString."_value\" />
				<span class = \"slider round\"></span>
		</label>

		<label for=\"".$teamString."\">Team ".($i+1)."</label><p/>
		<br>";
	}
	else
	{
		//error
	}*/
	
}

//footer stuff
$workingString.="<div class=\"wrapper\">
					<div class=\"footer\">
						<h3><a href=\"HomeView1.php\">Home View 1</a></h3>
	  					<h3><a href=\"HomeView2.php\">Home View 2</a></h3>
	  					<h3><a href=\"dynamicDashboard.php\">Show All Teams</a></h3>
	  					<h3><a href=\"AddTeamForm.php\">Add Teams</a></h3>
	  					<h3><a href=\"logout.php\">Log Out</a></h3>
					</div>
	 			</div>";


echoPage($workingString)
?>