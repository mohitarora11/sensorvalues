<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
        <meta name="viewpoint" content= "width=device-width, initial-scale=1.0">
        <title> Landfil Gas Realtime Monitoring </title>
        <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
		<style type="text/css">
			h5 {line-height:20px;display:none}
		</style>
    </head>
 <body>
<?php isset($_GET["for"]) ? $for = $_GET['for'] : $for = 0; ?>
<script type="text/javascript">
var data = 
	<?php
		require 'getSensorData.php';
		$data = getAllSensorData();
		echo json_encode($data);
	?>;
</script>
 <script src="js/Chart.min.js"></script>

	<nav class="navbar navbar-default" id="navbar">	
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="http://www.sweepenviro.com/">ESS Enviro Pvt Ltd</a> 
			</div>
            <ul class="nav navbar-nav  navbar-right">
				<li>	
					<a href="http://www.punecorporation.org/">Pune Municipal Corporation</a>				
				</li>
				<li style="padding-top:5px">
					<select  class="form-control" onchange="doAction(this.value);">
						<option value="" >All Data</option>
						<option value="2" <?php if($for == 2) echo "selected=selected" ?>>Daily</option>
						<option value="3" <?php if($for == 3) echo "selected=selected" ?>>Monthly</option>
						<option value="4" <?php if($for == 4) echo "selected=selected" ?>>Yearly</option>
					</select>
				</li>
				
				
			</ul>		
			
		</div>
	</nav>


<div class="container-fluid">
	<h1>
		<center>Landfill Gas Monitoring Data</center>
	</h1>
	<h5>
		<center>
		Ess Enviro Pvt Ltd<br/>
		Landfill Site Odour Monitoring Report<br/>
		Issued to <br/>
		Pune Municipal Corporation, Indradhanushya Environment & Citizen Centre" <br/>
		PMC, Rajendranagar Pune 411030<br/>

		Name of site :  Disha Project, PMC kachra Depot, Ramtekdi Industrial Area.<br/>
		Name of instrument used: SAQMS- ODOUR<br/>
		Name of website where data can be accessed: sensors.essenviro.com<br/>
		</center>
	</h5>
<center id="dwnloadbuton">
	<a class="btn btn-default btn-lg" href="downloadData2.php?for=<?php echo $for; ?>">
		<span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> Download Data
	</a>

</center>
<br/><br/>
	<div class="row">		
		<div class="col-md-3 col-sm-5 col-xs-12">
			<h4>Composite VOCs</h4>
			<canvas id="canvas1" width="600" height="400"></canvas>
		</div>		
		<div class="col-md-3 col-sm-5 col-xs-12 col-md-offset-1 col-sm-offset-1">
			<h4>Composite NH3 and H2S.</h4>
			<canvas id="canvas2" width="600" height="400"></canvas>
		</div>
		<div class="col-md-3 col-sm-5 col-xs-12 col-md-offset-1 ">
			<h4>Temperature</h4>
			<canvas id="canvas3" width="600" height="400"></canvas>
		</div>
		<div class="col-md-3 col-sm-5 col-xs-12 col-md-offset-0 col-sm-offset-1">
			<h4>Composite Odour 1</h4>
			<canvas id="canvas4" width="600" height="400"></canvas>
		</div>
		<div class="col-md-3 col-sm-5 col-md-offset-1 col-xs-12  ">
			<h4>Composite Odour 2</h4>
			<canvas id="canvas5" width="600" height="400"></canvas>
		</div>		 
		<div class="col-md-3 col-sm-5 col-xs-12 col-md-offset-1 col-sm-offset-1">
			<h4>Humidity</h4>
			<canvas id="canvas6" width="600" height="400"></canvas>
		</div>
	</div>
	<div class="row">
		<center>
			<button id="printbutton" type="button" class="btn btn-default btn-lg" aria-label="Left Align">
				<span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print
			</button>
			<button id="refreshbutton" type="button" style="display:none" class="btn btn-default btn-lg" aria-label="Left Align">
				<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>Refresh
			</button>	
			
		</center>
		<br/>
	</div>
</div>
	
<script type="text/javascript">
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
        window.location=top.window.location.origin+top.window.location.pathname +'?for=' + val;
	}
	
	document.getElementById("printbutton").addEventListener("click", function(){
		document.getElementById("dwnloadbuton").style.display = 'none';
		document.getElementById("printbutton").style.display = 'none';
		document.getElementById("refreshbutton").style.display = 'block';
		document.getElementById("navbar").style.display = 'none';
		document.getElementsByTagName('h1')[0].style.display = 'none';
		document.getElementsByTagName('h5')[0].style.display = 'block';
		
	});
	
	document.getElementById("refreshbutton").addEventListener("click", function(){
		document.getElementById("dwnloadbuton").style.display = 'block';
		document.getElementById("printbutton").style.display = 'block';
		document.getElementById("refreshbutton").style.display = 'none';
		document.getElementById("navbar").style.display = 'block';
		document.getElementsByTagName('h1')[0].style.display = 'block';
		document.getElementsByTagName('h5')[0].style.display = 'none';
	});
	
</script>

</body>

</html>


    