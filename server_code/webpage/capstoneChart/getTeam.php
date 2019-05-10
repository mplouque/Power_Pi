<?php
//gets the Team Name to set the title of the graph i.e. title= "Phoenix"

require_once("../config/config_local_new.php");



//recieve the curent team table name from the ajax call in index
$currTeamNumber = $_POST['num'];
// Connect to mySQL database
// args: host, username, password, database
//$con = mysqli_connect("localhost","test_user","test_user", "test");

//$con = mysqli_connect("192.168.0.19","capstone_pi_readings","capstone_pi_readings", "capstone_pi_readings");

// Try to connect
//if (!$con) {
//    die('Could not connect: ' . mysql_error());
//}

$data = array();
$i = 0;
for ($i=0; $i<count($currTeamNumber); $i++) {

	$sql = mysqli_real_escape_string(LOCAL_DB::conn(), "SELECT name, color FROM teams WHERE id = ".$currTeamNumber[$i].";");

	// Get most recent 20 entries from current team table
	$result = mysqli_query(LOCAL_DB::conn(), $sql);

	// Create an array to store table info into
	$data[] = array();

	// Store each row of the table in the array
	while($row = mysqli_fetch_assoc($result)) 
	{
	    $data[$i][] = $row;
	}

}

// Put data array in json format and echo
echo json_encode(($data));

// Close connection to database
//mysqli_close($con);

?>
