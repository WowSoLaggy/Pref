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
			
			echo "<hr><h3>Сезон ".$season->year."</h3>";
			
			// Players
			
			$str = "<table border=0><tr>";
			$str .= '<td valign=top width=500><h4>Топ игроков</h4><table border="1">';
			$str .= '<td><th>Имя</th><th>Счёт</th></td>';
			
			$keys = array_keys($season->players_score);
			$place = 1;
			foreach ($keys as $key)
			{
				$str .= "<tr>";
				$str .= "<td width=20 align=center>".$place."</td>";
				$str .= 
					"<td width=160><img src='images/".$players[$key]->image.
					"' align=absmiddle hspace=10 vspace=10 width=50>".$players[$key]->name.
					"</td>";
				$str .= "<td width=60 align=center><b><font size='+1'>".round($season->players_score[$key])."</font></b></td>";
				$str .= "</tr>";
				
				++$place;
			}
			
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
