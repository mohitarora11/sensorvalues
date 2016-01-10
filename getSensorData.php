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
					   
					  "cVoc"  => ($row["cVoc"] <= 0 ? 0 :  ((4897.7 / $row["cVoc"]) - 4.6))
					  ,"cNh3H2s" => ($row["cVoc"] <= 0 ? 0 :  ((1347.13 / $row["cNh3H2s"]) - 1.25))
					  ,"cOdour1" => ($row["cVoc"] <= 0 ? 0 :  ((47834.42 / $row["cOdour1"]) - 44.385))
					  ,"cOdour2" => ($row["cVoc"] <= 0 ? 0 :  ((115468.88 / $row["cOdour2"]) -  107.14))
					  ,"temp"  => $row["temp"]
					  ,"humi"    => $row["humi"]					  
					  ,"min"     => isset($row["min"]) ? $row["min"]  : "" 
					  ,"hr"      => isset($row["hr"]) ? $row["hr"]  : "" 
					  ,"date"    => isset($row["date"]) ? $row["date"]  : "" 
					  ,"month"   =>  isset($row["month"]) ? $row["month"] : "" 
					  ,"year"    => $row["year"]
			);
			
			

			/*$row= array(
				foreach($row as $key => $value) {    
				   switch($key) {				   
					   case 'cVoc':
							$value != 0 ? "cVoc"  => ((4897.7 /$value) - 4.6) : "cVoc"  => 0;	
							break;
					   case 'cNh3H2s':
							$value != 0 ? ",cNh3H2s"  => ((1347.13 /$value) - 1.25) : ",cNh3H2s"  => 0;						 									
							break;
						case 'cOdour1':
							$value != 0 ? ",cOdour1"  => ((47834.42 /$value) -  44.385) : ",cOdour1"  => 0;						 																
							break;
						case 'cOdour2':
							$value != 0 ? ",cOdour2"  => ((115468.88 /$value) - 107.14) : ",cOdour2"  => 0;		
							break;		
						default:
							",".$key => $value;
							break;	
				   }	   
				}
			);*/	
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