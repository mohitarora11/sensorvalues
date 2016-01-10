<?php

function getAllSensorData() {
	$ret = array();
	
	/*$servername = "localhost";
	$username = "diptendu91";
	$password = "diptendu91";
	$dbname = "sensordata";
*/
	$servername = '127.0.0.1';
	$username = "root";
	$password = "admin123";
	$dbname = "sensorvalues";
	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	// Check connection
	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
	}
	
	
	$query='';
	$for = 0;
	if(isset($_GET["for"])) {
		$for = $_GET['for'];	
	};
	$now = new DateTime('now');
   $month = $now->format('m');
   $year = $now->format('Y'); //date("Y")
	$day = $now->format('d');	
	
	switch ($for) {
		case "4":
			$query = "select year,avg(cVoc) as 'cVoc',avg(cNh3H2s) as 'cNh3H2s',
					avg(cOdour1) as 'cOdour1',avg(cOdour2) as 'cOdour2',
					avg(temp) as 'temp',avg(humi) as 'humi'
					from sensorvalues where year in (2015,2016) and
					cVoc < 1023 and cNh3H2s < 1023 and cOdour1 < 1023 and cOdour2 < 1023 and
					temp < 100 and  humi < 100 group by year";
			break;
		case "3":
			$query = "select month,year,avg(cVoc) as 'cVoc',avg(cNh3H2s) as 'cNh3H2s',
					avg(cOdour1) as 'cOdour1',avg(cOdour2) as 'cOdour2',
					avg(temp) as 'temp',avg(humi) as 'humi'
					from sensorvalues where year in (2015,2016) and
					cVoc < 1023 and cNh3H2s < 1023 and cOdour1 < 1023 and cOdour2 < 1023 and
					temp < 100 and  humi < 100 group by month,year";
		case "2":
			$query = "select date,month,year,avg(cVoc) as 'cVoc',avg(cNh3H2s) as 'cNh3H2s',
					avg(cOdour1) as 'cOdour1',avg(cOdour2) as 'cOdour2',
					avg(temp) as 'temp',avg(humi) as 'humi'
					from sensorvalues where year in (2015,2016) and
					cVoc < 1023 and cNh3H2s < 1023 and cOdour1 < 1023 and cOdour2 < 1023 and
					temp < 100 and  humi < 100 group by date,month,year limit 10";	
			break;		
		default:
			$query = "SELECT * FROM ( SELECT * FROM sensorvalues ORDER BY entryNo DESC limit 10) sub ORDER BY entryNo ASC";
			break;
	}

	
	//$sql = "SELECT * FROM ( SELECT * FROM sensorvalues ORDER BY entryNo DESC limit 10) sub ORDER BY entryNo ASC";
	$result = mysqli_query($conn, $query);
	
	if (mysqli_num_rows($result) >0) {
		while($row = mysqli_fetch_assoc($result)) {
				//echo "hi";
		    $row= array(
					   //"entryNo" => isset($row["entryNo"]) ? 
					  //,"nodeId" => $row["nodeId"]
					  "cVoc"  => $row["cVoc"]
					  ,"cNh3H2s" => $row["cNh3H2s"]
					  ,"cOdour1" => $row["cOdour1"]
					  ,"cOdour2" => $row["cOdour2"]
					  ,"temp"  => $row["temp"]
					  ,"humi"    => $row["humi"]
					  //,"sec"     => $row["sec"]
					  ,"min"     => isset($row["min"]) ? $row["min"]  : "" 
					  ,"hr"      => isset($row["hr"]) ? $row["hr"]  : "" 
					  ,"date"    => isset($row["date"]) ? $row["date"]  : "" 
					  ,"month"   =>  isset($row["month"]) ? $row["month"] : "" 
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