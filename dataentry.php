<?php
$servername = "localhost";
$username = "diptendu91";
$password = "diptendu91";
$dbname = "sensordata";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

if(isset($_REQUEST['nodeId']))   
{
$entryNo=$_REQUEST['entryNo'];
$nodeId=$_REQUEST['nodeId'];
$cVoc=$_REQUEST['cVoc'];
$cNh3H2s=$_REQUEST['cNh3H2s'];
$cOdour1=$_REQUEST['cOdour1'];
$cOdour2=$_REQUEST['cOdour2'];
$temp=$_REQUEST['temp'];
$humi=$_REQUEST['humi'];
$sec=$_REQUEST['sec'];
$min=$_REQUEST['min'];
$hr=$_REQUEST['hr'];
$date=$_REQUEST['date'];
$month=$_REQUEST['month'];
$year=$_REQUEST['year'];
$sql = "INSERT INTO sensorvalues (entryNo, nodeId, cVoc, cNh3H2s, cOdour1, cOdour2, temp, humi, sec, min, hr, date, month, year) VALUES ($entryNo, $nodeId, $cVoc, $cNh3H2s, $cOdour1, $cOdour2, $temp, $humi, $sec, $min, $hr, $date, $month, $year);";




if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
}
?>