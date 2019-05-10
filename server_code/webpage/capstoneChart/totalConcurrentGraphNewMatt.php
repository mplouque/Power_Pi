<!DOCTYPE HTML>
<html>
<head>
<!--<style> html, body {margin:0;padding:0;height:100%;} </style>-->
<link rel="stylesheet" href="../main.css">
<script type="text/javascript" src="jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="canvasjs.min.js"></script>
<script type="text/javascript">

window.onload = function () 
{	
	var dps = []; // dataPoints

	// all the stuff to make the chart pretty
	var chart = new CanvasJS.Chart("chartContainer", 
	{
		backgroundColor: "#222222",	
		title :
		{
			text: "Current Total Power Usage",
			fontColor: "#DCDCDC",
		},
		axisX:
		{
	        title: "Time",
	        labelFormatter: function (e)
	        {
	        	// how much time/data info to display along the axis
				return CanvasJS.formatDate( e.value, "hh:mm:ss T");
			},
			gridColor: "#DCDCDC",
			labelFontColor: "#DCDCDC",
			titleFontColor: "#DCDCDC",
	        gridThickness: 1,
	        lineThickness: 2
		},

		axisY: 
		{
			title: "Watts",
			gridColor: "#DCDCDC",
			labelFontColor: "#DCDCDC",
			titleFontColor: "#DCDCDC",		
			valueFormatString:"#######W",
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

	//chart.title.set("text", "Current Total Power Usage");
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
					    // go ahead and convert timestamps to Date objects for easy comparison later
					    var tmp = jsonData[j][i].nowTS.split(/[- :]/);
					    // -1 because javascript has months 0-11, +3 because it tiries to convert to central time
					    jsonData[j][i].nowTS = new Date(Date.UTC((tmp[0]), (tmp[1])-1, (tmp[2]), (tmp[3]), (tmp[4]), (tmp[5])));
					    currListRows[j].push(jsonData[j][i]);
				    }
				}

				console.log(currListRows);
				
			
				//currListRows.length=numTeams
				//currListRows[i].length=numberofpoints for (teami+1)
				var nowTSCountDict = {};
				var nowTSValsDict = {};
				var pointsToPlot = [];

				console.log("This is the numTeams");
				console.log(currListRows.length);
				for (var i =0; i < currListRows.length; i++)
				{
					for(var j=0; j<currListRows[i].length; j++)
					{
						if (!nowTSCountDict[currListRows[i][j].nowTS])
						{
							//it isnt in the ts dict yet so add it and set the value to 1
							nowTSCountDict[currListRows[i][j].nowTS] = 1;
							nowTSValsDict[currListRows[i][j].nowTS] = Number(currListRows[i][j].watts)
						}
						else
						{
							nowTSCountDict[currListRows[i][j].nowTS] += 1;
							console.log("PLUS EQUALS1");
							nowTSValsDict[currListRows[i][j].nowTS] += Number(currListRows[i][j].watts)
						}

					}
				}

				console.log("This is the  CountDict");
				console.log(nowTSCountDict);
				console.log("This is the vals Dict");
				console.log(nowTSValsDict);

				maxCount = 0;
				for (var key in nowTSCountDict)
				{
					nowTSCountDict[key] > maxCount ? maxCount = nowTSCountDict[key] : maxCount = maxCount;
				}

				console.log("This is the max Count");
				console.log(maxCount);

				for (var key in nowTSCountDict)
				{
					if (nowTSCountDict[key] == maxCount )
					{
						var tempPoint = {}
						tempPoint.watts = nowTSValsDict[key];
						//the key is a date in string formate so convert it back a date obj
					    tempPoint.nowTS = new Date(key);
						pointsToPlot.push(tempPoint);
					} else 
					{
						//alert('We squished the bug');
					}
				}


				totalValArr = pointsToPlot;

				console.log("This is points to plot");
				console.log(pointsToPlot);

				console.log("This is totalValArr");
				console.log(totalValArr);
				
				chart.options.data[0] = 
				{
					type: "line",
					lineColor: "#ddffdd",
					markerColor: "#ddffdd",
					lineThickness: 3,
					dataPoints: []
				}
				chart.options.data[0].dataPoints.length = 0;
				$.each(totalValArr, function(key, jsonArray2)
				{
					// add the data point we formatted this loop to the list of datapoints
					chart.options.data[0].dataPoints.push({x: jsonArray2.nowTS, y: Number(jsonArray2.watts), markerType: "circle"});
				});
				console.log(chart.options.data[0]);
			
				// after formatting all 20 points, we can render the chart
				chart.render();
				console.log("chart rendered2")
			}
		});

	};

	updateChart();
	let myInterval = setInterval(updateChart, updateInterval)
	//setInterval(function(){updateChart()}, updateInterval);

}
</script>
</head>
<body>
<div id="chartContainer" style="height:100%; width:100%; min-height: 100%;"></div>
</body>