<html>
	<head>
		<title>Клуб "Паровоз Козлова"</title>
		<meta charset="utf-8"/>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>

	<body class="light">

		<h2>Сезоны</h2>
		<br>

		<?php
		
		include('calculations.php');
		
		
		function draw_season(&$season)
		{
			global $players;
			
			echo "<h3>Сезон ".$season->year."</h3>";
			
			// Players
			
			$str = "<table border = 2><tr>";
			$str .= '<td valign=top width=500><h4>Топ игроков</h4><table border="1">';
			
			$keys = array_keys($season->players_score);
			foreach ($keys as $key)
				$str .= '<tr><td width=120 align=left>'.$players[$key]->name.'</td><td>'.round($season->players_score[$key]).'</td></tr>';
			
			$str .= '</table></td>';
			
			// Stats
			
			$str .= '<td valign=top><h4>Статистика сезона</h4><table border="0">';
			
			$str .= '<tr><td width=220 align=left>Cыграно игр:</td><td>'.$season->num_games.'</td></tr>';
			$str .= '<tr><td>Длина всех пуль:</td><td>'.$season->total.'</td></tr>';
			
			$str .= '</table></td></tr></table><br>';
			
			echo $str;
		}
		
		
		//
		// MAIN
		//

		
		function year_sort($a, $b)
		{
			return ($b->year - $a->year);
		}
		usort($seasons, "year_sort");

		foreach ($seasons as &$season)
			draw_season($season);
		
		?>

	</body>
</html>
