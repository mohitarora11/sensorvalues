<?php

function getAllSensorData() {
	$ret = array();
	$servername = "localhost";
	$username = "diptendu91";
	$password = "diptendu91";
	$dbname = "sensordata";

	
	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	// Check connection
	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
	}
	
	$sql = "SELECT * FROM sensorvalues";
	$result = mysqli_query($conn, $sql);
	
	
	
	
	
	if (mysqli_num_rows($result) >0) {
	                
	                
	                while($row = mysqli_fetch_assoc($result)) {
				//echo "hi";
				$ok = "hI";
				
			        $row= array(
			        	       "entryNo" => $row["entryNo"]
				              ,"nodeId" => $row["nodeId"]
				              ,"cVoc"  => $row["cVoc"]
				              ,"cNh3H2s" => $row["cNh3H2s"]
				              ,"cOdour1" => $row["cOdour1"]
				              ,"cOdour2" => $row["cOdour2"]
				              ,"temp"  => $row["temp"]
				              ,"humi"    => $row["humi"]
				              ,"sec"     => $row["sec"]
				              ,"min"     => $row["min"]
				              ,"hr"      => $row["hr"]
				              ,"date"    => $row["date"]
				              ,"month"   => $row["month"]
				              ,"year"    => $row["year"]
				        );
				        
			         array_push($ret,$row);
	
	    		}
	    
	 		
	} else {
		//
	}
	 
	//echo "hello world";
	
	
	mysqli_close($conn);
	
	return $ret;

}

//echo "ok";

?>