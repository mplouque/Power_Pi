<?php

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


function echoPage($s)
{
	$pageString=
	"<html> 
		<head>
			<title>Home Screen</title>
			<link rel=\"stylesheet\" href=\"slider.css\">
			<link rel=\"stylesheet\" href=\"main.css\">
			<script type=\"text/javascript\" src=\"jquery-1.9.1.min.js\"></script>
			<script type=\"text/javascript\" src=\"test.js\"></script>

		</head>
		<body>";

	$pageString.=$s;

	$pageString.="
		</body>
	</html>";
	
	echo $pageString; 
}

$numTeams=getNumTeams();
$workingString="";
$idsString="";

for ($i=0; $i < $numTeams; $i++)
{
	$idsString.=($i+1);
	if (($i+1)!= $numTeams)
	{
			$idsString.=",";
	}

}

//frameborder = \"0\" height = \"".$graphHeight."%\" width = \"".$graphWidth."%\" align = \"middle\"

$workingString.="<div class=\"halfheight\"><div class=\"halfwidth\">";
$workingString.="<iframe src=\"capstoneChart/indexNewMatt.php?id=[".$idsString."]\" class=\"homeGraph\" scrolling=\"no\"></iframe></div>";
$workingString.="<div class=\"halfwidth\">";
$workingString.="<iframe src=\"capstoneChart/totalConcurrentGraphNewMatt.php?id=[".$idsString."]\" class=\"homeGraph\" scrolling=\"no\"></iframe></div></div>";
$workingString.="<div class=\"halfheight\">";
$workingString.="<iframe src=\"capstoneChart/totalEnergyUsedGraphNewMatt.php?id=[".$idsString."]\" class=\"homeGraph\" scrolling=\"no\"></iframe></div>";

//footer stuff
$workingString.="<div class=\"wrapper\">
					<div class=\"footer\">
						<h3><a href=\"register.php\">Home View 1</a></h3>
	  					<h3><a href=\"other.php\">Home View 2</a></h3>
	  					<h3><a href=\"other2.php\">Show All Teams</a></h3>
	  					<h3><a href=\"other2.php\">Add Teams</a></h3>
	  					<h3><a href=\"other2.php\">Log Out</a></h3>
					</div>
	 			</div>";

echoPage($workingString)

?>