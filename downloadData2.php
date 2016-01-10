<?php

// Database Connection
	/*
    $servername = '127.0.0.1';
	$username = "root";
	$password = "admin123";
	$dbname = "sensorvalues";
*/
	$servername = "localhost";
	$username = "diptendu91";
	$password = "diptendu91";
	$dbname = "sensordata";

$connection=mysqli_connect($servername, $username, $password, $dbname);

echo mysql_error();

//or die("Database Connection Failed");
/*$selectdb=mysql_select_db($dbname) or 
die("Database could not be selected"); 
$result=mysql_select_db($dbname)
or die("database cannot be selected <br>");
*/
// Fetch Record from Database

$output = "";
$table = ""; // Enter Your Table Name 
$for = '1';
if(isset($_GET["for"])) {
	$for = $_GET['for'];	
};
	
$query='';

	$now = new DateTime('now');
   $month = $now->format('m');
   $year = $now->format('Y'); //date("Y")
	$day = $now->format('d');	
	switch ($for) {
		case "4":
			$query = "select year,avg(cVoc) as 'VOCs',avg(cNh3H2s) as 'NH3 and H2S',
					avg(cOdour1) as 'Odour 1' ,avg(cOdour2) as 'Odour 2',
					avg(temp) as Temperature ,avg(humi) as Humidity 
					from sensorvalues where year in (2015,2016) and
					cVoc < 1023 and cNh3H2s < 1023 and cOdour1 < 1023 and cOdour2 < 1023 and
					temp < 100 and  humi < 100 group by year";
			break;
		case "3":
			$query = "select month,year,avg(cVoc) as 'VOCs',avg(cNh3H2s) as 'NH3 and H2S',
					avg(cOdour1) as 'Odour 1' ,avg(cOdour2) as 'Odour 2',
					avg(temp) as Temperature ,avg(humi) as Humidity 
					from sensorvalues where year in (2015,2016) and
					cVoc < 1023 and cNh3H2s < 1023 and cOdour1 < 1023 and cOdour2 < 1023 and
					temp < 100 and  humi < 100 group by month,year";
			break;
		case "2":
			$query = "select date,month,year,avg(cVoc) as 'VOCs',avg(cNh3H2s) as 'NH3 and H2S',
					avg(cOdour1) as 'Odour 1' ,avg(cOdour2) as 'Odour 2',
					avg(temp) as Temperature ,avg(humi) as Humidity 
					from sensorvalues where year in (2015,2016) and
					cVoc < 1023 and cNh3H2s < 1023 and cOdour1 < 1023 and cOdour2 < 1023 and
					temp < 100 and  humi < 100 group by date,month,year";
			break;
		default:
			$query = "select date,month,year,cVoc as 'VOCs',cNh3H2s as 'NH3 and H2S',
					cOdour1 as 'Odour 1' ,cOdour2 as 'Odour 2',
					temp as Temperature ,humi as Humidity   from sensorvalues where year in (2015,2016) and
					cVoc < 1023 and cNh3H2s < 1023 and cOdour1 < 1023 and cOdour2 < 1023 and
					temp < 100 and  humi < 100";
	}

$sql = mysqli_query($connection,$query);

//$columns_total = mysqli_num_rows($sql);
$columns_total = $sql->field_count;


// Get The Field Name


$output .= '"Ess Enviro Pvt Ltd",
Landfill Site Odour Monitoring Report,
Issued to,
"Pune Municipal Corporation, Indradhanushya Environment & Citizen Centre",
"PMC, Rajendranagar",
Pune 411030,

"Name of site :  Disha Project, PMC kachra Depot, Ramtekdi Industrial Area.",
"Name of instrument used: SAQMS- ODOUR",
"Name of website where data can be accessed: sensors.essenviro.com"';

$output .="\n";
$output .="\n";

for ($i = 0; $i < $columns_total; $i++) {
	$properties = mysqli_fetch_field_direct($sql, $i);
	$heading = is_object($properties) ? $properties->name : null;
	$output .= '"'.$heading.'",';
}
$output .="\n";

// Get Records from the table

while ($row = mysqli_fetch_assoc($sql)) {
	/*for ($i = 0; $i < $columns_total; $i++) {
		$output .='"'.$row["$i"].'",';
	}
	$output .="\n";*/
	foreach($row as $key => $value) {
       // print "$key = $value <br />";
	   switch($key) {
		   
		   case 'VOCs':
				 if($value != 0) { 
					$output .='"'.((4897.7 /$value) - 4.6).'",';	
				 } else {
					 $output .='"0",';						 
				 }	
				break;
		   case 'NH3 and H2S':
				if($value != 0) { 
					$output .='"'.((1347.13 /$value) - 1.25).'",';
				} else {
					 $output .='"0",';						 
				}			
				break;
			case 'Odour 1':
				if($value != 0) { 
					$output .='"'.((47834.42 /$value) -  44.385).'",';	
				} else {
					 $output .='"0",';						 
				}	
				break;
			case 'Odour 2':
				if($value != 0) { 
					$output .='"'.((115468.88 /$value) - 107.14).'",';	
				} else {
					 $output .='"0",';						 
				}	
				break;		
			default:
				$output .='"'.$value.'",';	
				break;	
	   }
	   
     }
	 $output .="\n";
}

$todaydate = $now->format('Y-m-d');
$filename = "LandFil Gas Landfill Gas Monitoring Data ".($for == 4 ? 'Yearly Average ' : ($for == 3 ? 'Monthly Average ' : ($for == 2 ? 'Daily Average ' : 'All Data '))).$todaydate.".csv";
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);

echo $output;
exit;

?>