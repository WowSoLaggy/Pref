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
		
		echo '<table border="1"><td><th>Имя</th><th>Общий счёт</th><th>Игры</th><th>Победы</th>
		<th>Гора<br>(мин/ср/макс)</th></td>';
		for ($i = 0; $i < $num_players; $i++)
			echo "<tr><td width=20 align=center>".($i + 1).
			"</td><td width=160><img src='images/".$players[$i]['image'].
			"' align=absmiddle hspace=10 vspace=10 width=50>".$players[$i]['name'].
			"</td><td width=80 align=center>".$players[$i]['score'].
			"</td><td width=50 align=center>".$players[$i]['games'].
			"</td><td width=60 align=center>".(round($players[$i]['wins'] / $players[$i]['games'] * 100)).
			"%</td><td width=120 align=center>".
			$players[$i]['hill_min']."/".(round($players[$i]['hill_avg']))."/".$players[$i]['hill_max'].
			"</td></tr>";
		echo '</table>';
		
		?>
		
	</body>
</html>
