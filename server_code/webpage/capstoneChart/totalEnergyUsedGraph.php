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
		[
		]
	});

	
	
	// get new data every 2 seconds
	var updateInterval = 2000;

	// get the current team table from get pararmeters
	var id = JSON.parse("<?php echo $_GET['id'] ?>");
	console.log(id);

	//var colors = ["#ff598f", "#ff598f", "#e0e300", "#01dddd", "#00bfaf", "#21c34b", "#9c21c3", "#c34b21", "#2148c3", "#4e0d1d", "#99c321", "#c39c21", "#4b21c3", "#826816", "#823216", "#668216", "#308216"];

	let colors = [];

	// ajax call to get team name for team info table
	$.ajax({
		url:"getTeam.php",
		type: "POST",
	    dataType:'json',
	    data: ({num: id}),
		// If connection is successful, we have name of team
		success: function (jsonData)
		{
			console.log(jsonData);
			let name = [];
			for(var i=0; i<jsonData.length; i++) {
				console.log(`jsondata[${i}].teamname=${jsonData[i].name})`);
				name.push(jsonData[i][0].name);
				colors.push(jsonData[i][0].color);
			}
			console.log(name);
			name = name.join(", ");


			// render empty chart
			chart.render();
			// capitalize title string
			//var newTitle = name.replace(/\b\w/g, l => l.toUpperCase())
			// change chart title to team

			chart.title.set("text", name);
			//chart.data[0].set("lineColor", colors[idNum]);
			//chart.data[0].set("markerColor", colors[idNum]);

			console.log("chart rendered");
		}
	});
    //////
    //////
    //delete this later
    // my test table is called data, not a number :(
	var fakeid = "team" + id;
	let teamid = [];
	for (var i=0; i<id.length; i++) {
		teamid[i] = `team${id[i]}_data`;
	}
	console.log(`teamid=${JSON.stringify(teamid)}`);
	
		// this runs ev}ery 2 seconds
	var updateChart = function () 
	{
		// ajax call, sends id(team table), receives data in json format
		$.ajax({
			url:"getData.php",
			type: "POST",
		    dataType:'json',
		    data: ({table: teamid}),
			// If connection is successful, we have json data of most recent 20 data
			success: function (jsonData)
			{
				//console.log(jsonData);
				// jsonData is array of data from newest to oldest
				// reverse and store in currListRows
				var currListRows = [];
				for (var j = 0; j<jsonData.length; j++) {
					currListRows[j] = [];
				    for(var i = jsonData[j].length-1; i >= 0; i--)
				    {
				        currListRows[j].push(jsonData[j][i]);
				    }
				}

				console.log(currListRows);
				
				// make datapoints(list of points for chart) 0 to clear the list
				//chart.options.data[0].dataPoints.length = 0;

				// key is current index of loop
				// json array2 is currListRows, use title of column to reference that item
				for (var i = 0; i < currListRows.length; i++) {
					chart.options.data[i] = {
						type: "line",
						lineColor: colors[i],
						markerColor: colors[i],
						lineThickness: 3,
						dataPoints: []
					}
					chart.options.data[i].dataPoints.length = 0;
					$.each(currListRows[i], function(key, jsonArray2)
					{
						// format timestamp so chart can use it
						var oldDate = (jsonArray2.nowTS).split(/[- :]/);
						// -1 because javascript has months 0-11, +3 because it tiries to convert to central time
						var newDate = new Date(Date.UTC((oldDate[0]), (oldDate[1])-1, (oldDate[2]), (oldDate[3]), (oldDate[4]), (oldDate[5])));

						// add the data point we formatted this loop to the list of datapoints
						chart.options.data[i].dataPoints.push({x: newDate, y: Number(jsonArray2.watts), markerType: "circle"});
					});
					console.log(chart.options.data[i]);
				}
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
<div id="chartContainer" style="height:100%; width:100%; min-height: 100%;"></div>