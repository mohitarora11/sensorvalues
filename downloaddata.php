<?php

require 'getAllSensorData.php';

function outputCSV($data) {

	$outputBuffer = fopen("php://output", 'w');
	ob_start();
        
        // set csv header array_slice($data,1))
       // fputcsv($outputBuffer, array_keys(array_slice($data,1)));
        
        //echo var_dump($data);
        
        foreach($data as $val) {
            fputcsv($outputBuffer, $val);
        }
        fclose($outputBuffer);
        
        $csv = ob_get_clean();
        return $csv;
    }

function downloadCSV() {
	    $filename = "LandfillGasMonitoringData";
	
	    header("Content-type: text/csv");
	    header("Content-Disposition: attachment; filename={$filename}.csv");
	    header("Pragma: no-cache");
	    header("Expires: 0");
	    
	    $data = getAllSensorData();
	
	    return outputCSV($data);
    }    



$csv = downloadCSV();
echo $csv;

//echo "okies";
?>