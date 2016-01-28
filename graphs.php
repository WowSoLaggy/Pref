<html>
	<head>
		<title>Клуб "Паровоз Козлова"</title>
		<meta charset="utf-8"/>
		<link rel="stylesheet" type="text/css" href="style.css">
		<script language="javascript" type="text/javascript" src="jquery/jquery.js"></script>
		<script language="javascript" type="text/javascript" src="jquery/jquery.flot.js"></script>
		<script type="text/javascript">

		$(function() {

			var d1 = [];
			for (var i = 0; i < 14; i += 0.5) {
				d1.push([i, Math.sin(i)]);
			}

			var d2 = [[0, 3], [4, 8], [8, 5], [9, 13]];

			// A null signifies separate line segments

			var d3 = [[0, 12], [7, 12], null, [7, 2.5], [12, 2.5]];

			$.plot("#placeholder", [ d1, d2, d3 ]);

			// Add the Flot version string to the footer

			$("#footer").prepend("Flot " + $.plot.version + " &ndash; ");
		});
	</head>
	
	<body class="light">
	
		<h2>Весёлые графики</h2>
		
		Тут, кстати, пока ничего нет.
		
	</body>
</html>
