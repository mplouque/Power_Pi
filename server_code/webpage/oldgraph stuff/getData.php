<?php

// Connect to mySQL database
// args: host, username, password, database
//$con = mysqli_connect("localhost","test_user","test_user", "test");

$con = mysqli_connect("192.168.0.19","capstone_pi_readings","capstone_pi_readings", "capstone_pi_readings");

// Try to connect
if (!$con) {
    die('Could not connect: ' . mysql_error());
}

// Get everything from table
$result = mysqli_query($con, "SELECT * FROM data ORDER BY timestamp DESC LIMIT 1");


// Create an array to store table info into
$data = array();

// Store each row of the table in the array
while($row = mysqli_fetch_assoc($result)) 
{
    $data[] = $row;
}

// Put data array in json format
echo json_encode(($data));

// Close connection to database
mysqli_close($con);

?>
