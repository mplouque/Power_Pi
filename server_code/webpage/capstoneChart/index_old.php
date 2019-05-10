<!DOCTYPE HTML>
<html>
<head>
<script type="text/javascript" src="jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="canvasjs.min.js"></script>
<script type="text/javascript">

window.onload = function () 
{
	
	var dps = []; // dataPoints

	// all the stuff to make the chart pretty
	var chart = new CanvasJS.Chart("chartContainer", 
	{
		backgroundColor: "#e5e5e5",		
		title :
		{
			text: "POWER PI"
		},
		axisX:
		{
	        title: "Time",
	        labelFormatter: function (e)
	        {
	        	// how much time/data info to display along the axis
				return CanvasJS.formatDate( e.value, "hh:mm:ss T");
			},
	        gridThickness: 1,
	        lineThickness: 2
		},

		axisY: 
		{
			title: "Value",
			includeZero: false,
	        lineThickness: 2

		},      
		data: 
		[{
			type: "line",
			lineColor: "#6666FF",
			lineThickness: 3,
			dataPoints: dps
		}]
	});

	
	
	// get new data every 2 seconds
	var updateInterval = 2000;

	// get the current team table from get pararmeters
	var id = "<?php echo $_GET['id'] ?>";
	console.log(id);


	// ajax call to get team name for team info table
	$.ajax({
		url:"getTeam.php",
		type: "POST",
	    dataType:'json',
	    data: ({num: id}),
		// If connection is successful, we have name of team
		success: function (jsonData)
		{
			console.log(jsonData[0]);
			var name = jsonData[0].name;
			var hexColor = jsonData[0].color;
			// render empty chart
			chart.render();
			// capitalize title string
			var newTitle = name.replace(/\b\w/g, l => l.toUpperCase())
			// change chart title to team
			chart.title.set("text", newTitle);

			chart.data[0].set("lineColor", hexColor);
			chart.data[0].set("markerColor", hexColor);
			console.log("chart rendered")
		}
	});
    //////
    //////
    //delete this later
    // my test table is called data, not a number :(
	var fakeid = "team" + id;
	//var id = 'data';
	var tableName = "team"+id+"_data";

	// this runs every 2 seconds
	var updateChart = function () 
	{
		// ajax call, sends id(team table), receives data in json format
		$.ajax({
			url:"getData.php",
			type: "POST",
		    dataType:'json',
		    data: ({table: tableName}),
			// If connection is successful, we have json data of most recent 20 data
			success: function (jsonData)
			{
				console.log(jsonData);
				// jsonData is array of data from newest to oldest
				// reverse and store in currListRows
				var currListRows = [];
			    for(var i = jsonData.length-1; i >= 0; i--)
			    {
			        currListRows.push(jsonData[i]);
			    }			
				
				// make dps(list of points for chart) 0 to clear the list
				dps.length = 0;

				// key is current index of loop
				// json array2 is currListRows, use title of column to reference that item
				$.each(currListRows, function(key, jsonArray2)
				{
					// format timestamp so chart can use it
					var oldDate = (jsonArray2.nowTS).split(/[- :]/);
					// -1 because javascript has months 0-11, +3 because it tiries to convert to central time
					var newDate = new Date(Date.UTC((oldDate[0]), (oldDate[1])-1, (oldDate[2]), (oldDate[3]), (oldDate[4]), (oldDate[5])));

					// add the data point we formatted this loop to the list of datapoints
					dps.push({x: newDate, y: Number(jsonArray2.watts), markerType: "circle"});
				});	
				// after formatting all 20 points, we can render the chart
				chart.render();
				console.log("chart rendered2")
			}
		});

	};

	updateChart();
	setInterval(function(){updateChart()}, updateInterval);

}
</script>
</head>
<body>
<!-- <div id="chartContainer" style="height:100%; width:100%; min-height: 100%;"> -->
<div id="chartContainer" style="height: 100vh; width: 100vw;">
</div>
</body>