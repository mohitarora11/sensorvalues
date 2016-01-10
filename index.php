<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewpoint" content= "width=device-width, initial-scale=1.0">
        <title> Landfil Gas Realtime Monitoring </title>
        <LINK href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">

    </head>
 <body>

<script>

var data = 
<?php

require 'getSensorData.php';
$data = getAllSensorData();
echo json_encode($data);

?>;
</script>
<style type="text/css">
#id_ul_nav li{
	list-style:none;
}
#id_ul_nav li select {
    float: right;
    margin: 6px 0 0 15px;
    width: auto;
}
</style>

<nav class="navbar navbar-default">
		<nav class="container fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="http://www.sweepenviro.com/">ESS Enviro Pvt Ltd</a> 
			</div>
			<ul id="id_ul_nav">
				<li>
				<select class="form-control" onchange="doAction(this.value);">
					<option value=''>All Data</option>
					<option value='2'>Daily</option>
					<option value='3'>Monthly</option>
					<option value='4'>Yearly</option>
				</select>
				<a class="navbar-brand navbar-right" href="http://www.punecorporation.org/">Pune Municipal Corporation</a>
				
				</li>
			</ul>
		</nav>
</nav>

<h1><center>Landfill Gas Monitoring Data</center></h1>
<center>
<a class="btn btn-default btn-lg" href="downloadData2.php?for=4">
    <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> Yearly Data
</a>
<a class="btn btn-default btn-lg" href="downloadData2.php?for=3">
    <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> Monthly Data
</a>
<a class="btn btn-default btn-lg" href="downloadData2.php?for=2">
    <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> Daily Data
</a>
<a class="btn btn-default btn-lg" href="downloadData2.php?for=1">
    <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> All Data
</a>

</center>
 <script src="js/Chart.min.js"></script>

<style>
.floatLeft {
    float:left;
    width:30%;
    margin:1em;
}

.clearBoth {
    Clear:both;
}

</style>



	
    <div  class="floatLeft">
        <h4>Composite VOCs</h4>
        <canvas id="canvas1" width="600" height="400"></canvas>
    </div>
    
    <div class="floatLeft">
        <h4>Composite NH3 and H2S.</h4>
        <canvas id="canvas2" width="600" height="400"></canvas>
    </div>

    <div class="floatLeft">
        <h4>Temperature</h4>
        <canvas id="canvas3" width="600" height="400"></canvas>

    </div>

<div  class="clearBoth"></div>



    <div  class="floatLeft">
        <h4>Composite Odour 1</h4>
        <canvas id="canvas4" width="600" height="400"></canvas>
    </div>
    <div class="floatLeft">
        <h4>Composite Odour 2</h4>
        <canvas id="canvas5" width="600" height="400"></canvas>
    </div>
     
    <div class="floatLeft">
        <h4>Humidity</h4>
        <canvas id="canvas6" width="600" height="400"></canvas>
    </div>


<?php isset($_GET["for"]) ? $for = $_GET['for'] : $for = 0; ?>
	
<script>
var randomScalingFactor = function(){ return Math.round(Math.random()*100)};

function getRandData() {
    return [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
}

function getRandomChartData(label) {
    return {
    labels : ["00","10","20","30","40","50","60"],
    datasets : [
            {
            label: label,
            fillColor : "rgba(151,187,205,0.2)",
            strokeColor : "rgba(151,187,205,1)",
            pointColor : "rgba(151,187,205,1)",
            pointStrokeColor : "#fff",
            pointHighlightFill : "#fff", pointHighlightStroke : "rgba(151,187,205,1)",
            data : getRandData()

            
            }
        ]
    }
    
}
var fordata = <?php echo $for; ?>;
function getNextChartData(i) {
    lblData = [];
    chartData = [];
    data_mapping = {
    	1:"cVoc",
    	2:"cNh3H2s",
    	3:"temp",
    	4:"cOdour1",
    	5:"cOdour2",
    	6:"humi",
    	
    }
    for(j in data) {
    	switch (fordata) {
			case 4:
				lblData.push(data[j]['year']);
				break;
			case 3:
				lblData.push(data[j]['month']+"-"+data[j]['year']);
				break;
			case 2:
				lblData.push(data[j]['date']+"-"+data[j]['month']+"-"+data[j]['year']);
				break;
			default:	
				lblData.push(data[j]['hr']+":"+data[j]['min']);
				break;
		}			
    	chartData.push(data[j][data_mapping[i]]);
    }
    return {
    labels : lblData,
    datasets : [
            {
            label: "Chart "+i,
            fillColor : "rgba(151,187,205,0.2)",
            strokeColor : "rgba(151,187,205,1)",
            pointColor : "rgba(151,187,205,1)",
            pointStrokeColor : "#fff",
            pointHighlightFill : "#fff", pointHighlightStroke : "rgba(151,187,205,1)",
            data : chartData

            
            }
        ]
    }
    
}

var lineChartData1 = getNextChartData(1) //composite VOCs
var lineChartData2 = getNextChartData(2) //composite NH3 and H2S
var lineChartData3 = getNextChartData(3) //temperature
var lineChartData4 = getNextChartData(4) //composite odour 1
var lineChartData5 = getNextChartData(5) //composite odour 2
var lineChartData6 = getNextChartData(6) //composite odour 3




window.onload = function(){
    var ctx1 = document.getElementById("canvas1").getContext("2d");
    var ctx2 = document.getElementById("canvas2").getContext("2d");
    var ctx3 = document.getElementById("canvas3").getContext("2d");
    var ctx4 = document.getElementById("canvas4").getContext("2d");
    var ctx5 = document.getElementById("canvas5").getContext("2d");
    var ctx6 = document.getElementById("canvas6").getContext("2d");




    window.myLine1 = new Chart(ctx1).Line(lineChartData1, {responsive: true});
    window.myLine2 = new Chart(ctx2).Line(lineChartData2, {responsive: true});
    window.myLine3 = new Chart(ctx3).Line(lineChartData3, {responsive: true});
    window.myLine4 = new Chart(ctx4).Line(lineChartData4, {responsive: true});
    window.myLine5 = new Chart(ctx5).Line(lineChartData5, {responsive: true});
    window.myLine6 = new Chart(ctx6).Line(lineChartData6, {responsive: true});

}



    function doAction(val){
        //Forward browser to new url
        window.location=top.window.location.origin+top.window.location.pathname +'?for=' + val;
    }

      
</script>

 


</body>

</html>


    