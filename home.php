<html>
	<head>
		<title>Клуб анонимных преферансистов</title>
		<meta charset="utf-8"/>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	
	<body>
	
		<h2>Главная страница</h2>
		<br>
		
		<?php
		
		// Calculate players and games
		
		include('calculations.php');
		
		// Output stat
		
		echo '<h3>Общая статистика</h3><table border="0">
			<tr><td width=220 align=left>Всего сыграно игр:</td><td>'.$num_games.'</td>
			<tr><td>Всего участвовало игроков:</td><td>'.$num_players.'</td>
			</table><br>';
		
		// Output Top-players
		
		$players_sorted = $players;
		function scoreSort($a, $b)
		{
			return ($b['score'] - $a[score]);
		}
		usort($players_sorted, "scoreSort");
		
		echo '<h3>Топ игроков</h3><table border="1"><td><th>Имя</th><th>Общий счёт</th></td>';
		for ($i = 0; $i < $num_players; $i++)
		{
			echo "<tr><td width=20 align=center>".($i + 1).
			"</td><td width=160><img src='images/".$players_sorted[$i]['image'].
			"' align=absmiddle hspace=10 vspace=10 width=50>".$players_sorted[$i]['name'].
			"</td><td width=100 align=center>".$players_sorted[$i]['score']."</td></tr>";
		}
		echo '</table>';
		
		?>
		
	</body>
</html>
