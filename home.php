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
		
		// Output Top-players
		
		$players_sorted = $players;
		function scoreSort($a, $b)
		{
			$medals_diff = $b->medals_score - $a->medals_score;
			if ($medals_diff != 0)
				return $medals_diff;
			$score_diff = $b->score - $a->score;
			return $score_diff;
		}
		usort($players_sorted, "scoreSort");

		// Players
		
		// Header
		echo '<div id="block_top"><h3>Топ игроков</h3><table border="1"><td><th>Имя</th><th>Медали<br>(зол/сер/бронз)</th><th>Игры</th><th>Общий счёт</th></td>';
		
		for ($i = 0; $i < $num_players; $i++)
		{
			$str = "<tr>";
			$str .= "<td width=20 align=center>".($i + 1)."</td>";
			$str .= "<td width=160><img src='images/".$players_sorted[$i]->image.
				"' align=absmiddle hspace=10 vspace=10 width=50>".$players_sorted[$i]->name."</td>";
			$str .=
					"<td width=120 align=center>".$players_sorted[$i]->medals_gold."/".$players_sorted[$i]->medals_silver."/".$players_sorted[$i]->medals_bronze.
					"</td>";
			$str .= "<td width=50 align=center>".$players_sorted[$i]->games."</td>";
			$str .= "<td width=100 align=center>".round($players_sorted[$i]->score)."</td>";
			$str .= "</tr>";
			
			echo $str;
		}
		echo '</table></div>';
		
		// Output stat
		
		echo '<div id="block_stat"><h3>Общая статистика</h3><table border="0">
			<tr><td width=220 align=left>Всего сыграно игр:</td><td>'.$num_games.'</td></tr>
			<tr><td>Общая длина всех пуль:</td><td>'.$total.'</td></tr>
			<tr><td>Всего участвовало игроков:</td><td>'.$num_players.'</td></tr>
			<tr><td>Наибольшая победа:</td><td><a class="anchor_link" href="games.php#anchor_game_'.
			($num_games - $max_win_ind).'">'.round($max_win).' ('.$players[$max_win_player]->name.')</a></td></tr>
			<tr><td>Наибольший проигрыш:</td><td><a class="anchor_link" href="games.php#anchor_game_'.
			($num_games - $max_loss_ind).'">'.round($max_loss).' ('.$players[$max_loss_player]->name.')</a></td></tr>
			<tr><td>Наибольшая гора:</td><td><a class="anchor_link" href="games.php#anchor_game_'.
			($num_games - $max_hill_ind).'">'.$max_hill.' ('.$players[$max_hill_player]->name.')</a></td></tr>
			<tr><td>Наименьшая гора:</td><td><a class="anchor_link" href="games.php#anchor_game_'.
			($num_games - $min_hill_ind).'">'.$min_hill.' ('.$players[$min_hill_player]->name.')</a></td></tr>
			</table></div>';
		
		?>
		
	</body>
</html>
