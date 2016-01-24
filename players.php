<html>
	<head>
		<title>Клуб анонимных преферансистов</title>
		<meta charset="utf-8"/>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	
	<body>
	
		<h2>Список игроков</h2>
		<br>
		
		<?php
		
		// Calculate players and games
		
		include('calculations.php');
		
		// Output Top-players
		
		echo '<table border="1"><td><th></th><th>Имя</th><th>Счёт</th></td>';
		for ($i = 0; $i < $num_players; $i++)
			echo "<tr><td width=20 align=center>".($i + 1).
			"</td><td width=160><img src='images/".$players_sorted[$i]['image'].
			"' align=absmiddle hspace=10 vspace=10 width=50>".$players_sorted[$i]['name'].
			"</td><td width=60 align=center>".$players_sorted[$i]['score']."</td></tr>";
		echo '</table>';
		
		?>
		
	</body>
</html>
