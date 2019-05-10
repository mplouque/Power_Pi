<html>
	<head>
		<title>TEST</title>
		<link rel="stylesheet" href="slider.css">
		<script type="text/javascript" src="jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="test.js"></script>
	</head>

	<body>
		<form id="controller" action="form_processor.php">
			<label class="switch">
				<input type="checkbox" id="team1" name="team1_name" value="team1_value" checked/>
				<span class = "slider round"></span>
			</label>

			<label for="team1">Team 1</label><p/>
			<br>

			<label class="switch">
				<input type="checkbox" id="team2" name="team2_name" value="team2_value"/>
				<span class = "slider round"></span>
			</label>

			<label for="team2">Team 2</label><p/>
			<br>

			<label class="switch">
				<input type="checkbox" id="team3" name="team3_name" value="team3_value"/>
				<span class = "slider round"></span>
			</label>

			<label for="team3">Team 3</label><p/>
			<br>

			<label class="switch">
				<input type="checkbox" id="team4" name="team4_name" value="team4_value"/>
				<span class = "slider round"></span>
			</label>

			<label for="team4">Team 4</label><p/>
			<br>






			<button type="submit">GO!</button>
		</form>
	</body>
</html>
