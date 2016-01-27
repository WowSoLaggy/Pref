<html>
	<head>
		<title>Клуб "Паровоз Козлова"</title>
		<meta charset="utf-8"/>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	
	<body class="light">
	
		<h2>Главная страница</h2>
		
		<?php
		
		// Calculate players and games
		
		include('calculations.php');
		
		// Output stat
		
		echo '<div id="block_stat"><h3>Общая статистика</h3><table border="0">
			<tr><td width=220 align=left>Всего сыграно игр:</td><td>'.$num_games.'</td></tr>
			<tr><td>Общая длина всех пуль:</td><td>'.$total.'</td></tr>
			<tr><td>Всего участвовало игроков:</td><td>'.$num_players.'</td></tr>
			<tr><td>Наибольшая победа:</td><td><a class="anchor_link" href="games.php#anchor_game_'.$max_win_ind.'">'.round($max_win).'</a></td></tr>
			<tr><td>Наибольший проигрыш:</td><td><a class="anchor_link" href="games.php#anchor_game_'.$max_loss_ind.'">'.round($max_loss).'</a></td></tr>
			<tr><td>Наибольшая гора:</td><td><a class="anchor_link" href="games.php#anchor_game_'.$max_hill_ind.'">'.$max_hill.'</a></td></tr>
			</table></div>';
		
		// Output Top-players
		
		$players_sorted = $players;
		function scoreSort($a, $b)
		{
			return ($b['score'] - $a[score]);
		}
		usort($players_sorted, "scoreSort");
		
		echo '<div id="block_top"><h3>Топ игроков</h3><table border="1"><td><th>Имя</th><th>Игры</th><th>Общий счёт</th></td>';
		for ($i = 0; $i < $num_players; $i++)
		{
			echo "<tr><td width=20 align=center>".($i + 1).
			"</td><td width=160><img src='images/".$players_sorted[$i]['image'].
			"' align=absmiddle hspace=10 vspace=10 width=50>".$players_sorted[$i]['name'].
			"</td><td width=50 align=center>".$players_sorted[$i]['games'].
			"</td><td width=100 align=center>".round($players_sorted[$i]['score'])."</td></tr>";
		}
		echo '</table></div>';
		
		?>
		
	</body>
</html>
