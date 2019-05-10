<!DOCTYPE HTML>
<html>
<head>
<!--<style> html, body {margin:0;padding:0;height:100%;} </style>-->
<script type="text/javascript" src="jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="canvasjs.min.js"></script>
<link rel="stylesheet" href="../main.css">
<script type="text/javascript">

window.onload = function ()
{
	var dps = []; // dataPoints
	let newTS = new Date(0);
	let oldTS = new Date(0);

	// all the stuff to make the chart pretty
	var chart = new CanvasJS.Chart("chartContainer",
	{
		backgroundColor: "#222222",
		//backgroundColor: "#030c1c",
		title :
		{
			text: "Total Energy Used",
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
			valueFormatString:"####.###W",
			gridColor: "#DCDCDC",
			labelFontColor: "#DCDCDC",
			titleFontColor: "#DCDCDC",
			title: "WattHours",
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
			url:"getData_wattHours.php",
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



				// make datapoints(list of points for chart) 0 to clear the list
				//chart.options.data[0].dataPoints.length = 0;
				/*var totalValArr = [];
				for (var i =0; i<currListRows[0].length; i++)
				{
					totalValArr[i] = {};
					totalValArr[i].wattHours = 0;
				}

				for (var i =0; i<currListRows.length; i++)
				{

					for (var j=0; j<currListRows[i].length; j++)
					{
						totalValArr[j].wattHours+=Number(currListRows[i][j].wattHours);
						totalValArr[j].nowTS=currListRows[i][j].nowTS;
					}
				}*/

				//currListRows.length=numTeams
				//currListRows[i].length=numberofpoints for (teami+1)
				//var dict = {};
				//dict['key'] = 'value'

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
							nowTSValsDict[currListRows[i][j].nowTS] = Number(currListRows[i][j].wattHours)
						}
						else
						{
							nowTSCountDict[currListRows[i][j].nowTS] += 1;
							console.log("PLUS EQUALS1");
							nowTSValsDict[currListRows[i][j].nowTS] += Number(currListRows[i][j].wattHours)
						}

					}
				}

				console.log("This is the  CountDict");
				console.log(nowTSCountDict);
				console.log("This is the vals Dict");
				console.log(nowTSValsDict);

				/*var values = Object.keys(dictionary).map(function(key){
    					return dictionary[key];
				});*/
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
						tempPoint.wattHours = nowTSValsDict[key];
						//var tmp = key.split(/[- :]/);
					    // -1 because javascript has months 0-11, +3 because it tiries to convert to central time
					    tempPoint.nowTS = new Date(key);

						//tempPoint.nowTS = key;



						pointsToPlot.push(tempPoint);
					} else {
						//alert('We squished the bug');
					}
				}


				totalValArr = pointsToPlot;

				console.log("This is points to plot");
				console.log(pointsToPlot);

				console.log("This is totalValArr");
				console.log(totalValArr);




				//console.log(totalValArr);

				// key is current index of loop
				// json array2 is currListRows, use title of column to reference that item

				chart.options.data[0] =
				{
					type: "line",
					lineColor: "red",
					markerColor: "red",
					lineThickness: 3,
					dataPoints: []
				}
				chart.options.data[0].dataPoints.length = 0;
				$.each(totalValArr, function(key, jsonArray2)
				{
					/* This should be done earlier in the code
					// format timestamp so chart can use it
					var oldDate = (jsonArray2.nowTS).split(/[- :]/);
					// -1 because javascript has months 0-11, +3 because it tiries to convert to central time
					var newDate = new Date(Date.UTC((oldDate[0]), (oldDate[1])-1, (oldDate[2]), (oldDate[3]), (oldDate[4]), (oldDate[5])));
					console.log(`THIS IS WATTHOURS: ${jsonArray2.wattHours}`);
					*/
					// add the data point we formatted this loop to the list of datapoints
					chart.options.data[0].dataPoints.push({x: jsonArray2.nowTS, y: Number(jsonArray2.wattHours), markerType: "circle"});
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

}
</script>
</head>
<body>
<div id="chartContainer" style="height:100%; width:100%; min-height: 100%;"></div>
</body>
</html>
