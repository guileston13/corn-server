<?php
$healthy = $this->db->query("SELECT * from dataset where name ='Healthy'")->num_rows();
$phospuros = $this->db->query("SELECT * from dataset where name ='Phosphorus'")->num_rows();
$phosmonth2 = $this->db->query("SELECT SUM(status) as num from dataset where name='Phosphorus' AND monthname(time)='February'")->result();
$phosmonth3 = $this->db->query("SELECT SUM(status) as num from dataset where name='Phosphorus' AND monthname(time)='March'")->result();
$phosmonth4 = $this->db->query("SELECT SUM(status) as num from dataset where name='Phosphorus' AND monthname(time)='April'")->result();
$phosmonth5 = $this->db->query("SELECT SUM(status) as num from dataset where name='Phosphorus' AND monthname(time)='May'")->result();
$phosmonth6 = $this->db->query("SELECT SUM(status) as num from dataset where name='Phosphorus' AND monthname(time)='June'")->result();
$phosmonth7 = $this->db->query("SELECT SUM(status) as num from dataset where name='Phosphorus' AND monthname(time)='July'")->result();
$phosmonth8 = $this->db->query("SELECT SUM(status) as num from dataset where name='Phosphorus' AND monthname(time)='August'")->result();


$healthymonth2 = $this->db->query("SELECT SUM(status) as num from dataset where name='Healthy' AND monthname(time)='February'")->result();
$healthymonth3 = $this->db->query("SELECT SUM(status) as num from dataset where name='Healthy' AND monthname(time)='March'")->result();
$healthymonth4 = $this->db->query("SELECT SUM(status) as num from dataset where name='Healthy' AND monthname(time)='April'")->result();
$healthymonth5 = $this->db->query("SELECT SUM(status) as num from dataset where name='Healthy' AND monthname(time)='May'")->result();
$healthymonth6 = $this->db->query("SELECT SUM(status) as num from dataset where name='Healthy' AND monthname(time)='June'")->result();
$healthymonth7 = $this->db->query("SELECT SUM(status) as num from dataset where name='Healthy' AND monthname(time)='July'")->result();
$healthymonth8 = $this->db->query("SELECT SUM(status) as num from dataset where name='Healthy' AND monthname(time)='August'")->result();

$pf = $phosmonth2[0]->num;
$dataPoints = array( 
	array("label"=>"Healthy", "y"=>$healthy),
	array("label"=>"Phosporus", "y"=>$phospuros),
	// array("label"=>"IE", "y"=>8.47),
	// array("label"=>"Safari", "y"=>6.08),
	// array("label"=>"Edge", "y"=>4.29),
	// array("label"=>"Others", "y"=>4.59)
)


?>
<!DOCTYPE HTML>
<html>
<head>
<script>
window.onload = function() {
 
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	title: {
		text: "Corn Health Information"
	},
	subtitles: [{
		text: "March 2023"
	}],
	data: [{
		type: "bar",
		yValueFormatString: "#,##0.00\" count\"",
		indexLabel: "{label} ({y})",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
var chart1 = new CanvasJS.Chart("pieChart", {
	animationEnabled: true,
	title: {
		text: "Corn Health Information"
	},
	subtitles: [{
		text: "March 2023"
	}],
	data: [{
		type: "pie",
		yValueFormatString: "#,##0.00\" count\"",
		indexLabel: "{label} ({y})",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart1.render();

var chart2 = new CanvasJS.Chart("monthly", {
	animationEnabled: true,
	title:{
		text: "Monthy Reading of Health and Phosphorus"
	},
	axisX: {
		valueFormatString: "MMM,YY"
	},
	axisY: {
		title: "Number of Phosphorus",
		suffix: " #"
	},
	legend:{
		cursor: "pointer",
		fontSize: 16,
		itemclick: toggleDataSeries
	},
	toolTip:{
		shared: true
	},
	data: [{
		name: "Phosphorus",
		type: "spline",
		yValueFormatString: "#0.## #",
		showInLegend: true,
		dataPoints: [
			{ x: new Date(2023,2), y: <?php echo json_encode($pf, JSON_NUMERIC_CHECK); ?> },
			{ x: new Date(2023,3), y: <?php echo json_encode($phosmonth3[0]->num, JSON_NUMERIC_CHECK); ?> },
			{ x: new Date(2023,4), y: <?php echo json_encode($phosmonth4[0]->num, JSON_NUMERIC_CHECK); ?> },
			{ x: new Date(2023,5), y: <?php echo json_encode($phosmonth5[0]->num, JSON_NUMERIC_CHECK); ?> },
			{ x: new Date(2023,6), y: <?php echo json_encode($phosmonth6[0]->num, JSON_NUMERIC_CHECK); ?> },
			{ x: new Date(2023,7), y: <?php echo json_encode($phosmonth7[0]->num, JSON_NUMERIC_CHECK); ?> },
			{ x: new Date(2023,8), y: <?php echo json_encode($phosmonth8[0]->num, JSON_NUMERIC_CHECK); ?> }
		]
	},
	{
		name: "Healthy",
		type: "spline",
		yValueFormatString: "#0.## #",
		showInLegend: true,
		dataPoints: [
			{ x: new Date(2023,2), y: <?php echo json_encode($healthymonth2[0]->num, JSON_NUMERIC_CHECK); ?> },
			{ x: new Date(2023,3), y: <?php echo json_encode($healthymonth3[0]->num, JSON_NUMERIC_CHECK); ?> },
			{ x: new Date(2023,4), y: <?php echo json_encode($healthymonth4[0]->num, JSON_NUMERIC_CHECK); ?> },
			{ x: new Date(2023,5), y: <?php echo json_encode($healthymonth5[0]->num, JSON_NUMERIC_CHECK); ?> },
			{ x: new Date(2023,6), y: <?php echo json_encode($healthymonth6[0]->num, JSON_NUMERIC_CHECK); ?> },
			{ x: new Date(2023,7), y: <?php echo json_encode($healthymonth7[0]->num, JSON_NUMERIC_CHECK); ?> },
			{ x: new Date(2023,8), y: <?php echo json_encode($healthymonth8[0]->num, JSON_NUMERIC_CHECK); ?> }
		]
	},
	]
});
chart2.render();

	function toggleDataSeries(e){
		if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
			e.dataSeries.visible = false;
		}
		else{
			e.dataSeries.visible = true;
		}
		chart2.render();
	}
}




</script>

<h1><center>Corn indentifier</center>	</h1>
</head>
<body>
<div id="monthly" style="height: 370px; width: 100%;"></div>

<div id="pieChart" style="height: 370px; width: 100%;"></div>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>


<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>             