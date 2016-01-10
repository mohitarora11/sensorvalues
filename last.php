<?php


$servername = "localhost";
$username = "diptendu91";
$password = "diptendu91";
$dbname = "sensordata";
echo "hello world";

 
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


$conn->close();
}
?>