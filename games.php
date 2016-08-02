<html>
	<head>
		<title>Клуб "Паровоз Козлова"</title>
		<meta charset="utf-8"/>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	
	<body class="light">
	
		<?php
		
		function draw_table($startIndex, $endIndex)
		{
			global $players, $games, $num_games;
		
			echo '<table border="1"><td><th width=60>Пуля</th><th width=170>Игрок 1</th><th width=170>Игрок 2</th><th width=170>Игрок 3</th><th width=170>Игрок 4</th><th width=100>Дата</th></td>';
			for ($i = $startIndex; $i <= $endIndex; $i++)
			{
				echo "<tr valign=center><td width=30 align=center><a class='anchor' name='anchor_game_".($num_games - $i).
				"'><div class='game_index_label'>".($num_games - $i).
				//"'><div class='game_index_label'>".$games[$i]['id'].
				"</div></a></td><td align=center>".$games[$i]['total'].
				"</td><td";
				
				if ($games[$i]['1_score'] > 0)
					echo " bgcolor=#6EBA17";
				else if ($games[$i]['1_score'] < 0)
					echo " bgcolor=#9E7A17";
				
				echo "><img src='images/".$players[$games[$i]['1_name']]['image'].
				"' align=left hspace=10 vspace=10 width=50><p><b>Счёт: ".
				round($games[$i]['1_score']).
				"</b><br><small>Гора: ".$games[$i]['1_hill'].
				"<br>Висты: ".$games[$i]['1_money']."</small></p>".
				"</td><td";
				
				if ($games[$i]['2_score'] > 0)
					echo " bgcolor=#6EBA17";
				else if ($games[$i]['2_score'] < 0)
					echo " bgcolor=#9E7A17";
				
				echo "><img src='images/".$players[$games[$i]['2_name']]['image'].
				"' align=left hspace=10 vspace=10 width=50><p><b>Счёт: ".
				round($games[$i]['2_score']).
				"</b><br><small>Гора: ".$games[$i]['2_hill'].
				"<br>Висты: ".$games[$i]['2_money']."</small></p>".
				"</td><td";
				
				if ($games[$i]['3_score'] > 0)
					echo " bgcolor=#6EBA17";
				else if ($games[$i]['3_score'] < 0)
					echo " bgcolor=#9E7A17";
				
				echo "><img src='images/".$players[$games[$i]['3_name']]['image'].
				"' align=left hspace=10 vspace=10 width=50><p><b>Счёт: ".
				round($games[$i]['3_score']).
				"</b><br><small>Гора: ".$games[$i]['3_hill'].
				"<br>Висты: ".$games[$i]['3_money']."</small></p>".
				"</td><td";
				
				if ($games[$i]['num_players'] == 4)
				{
					if ($games[$i]['4_score'] > 0)
						echo " bgcolor=#6EBA17";
					else if ($games[$i]['4_score'] < 0)
						echo " bgcolor=#9E7A17";
				
					echo "><img src='images/".$players[$games[$i]['4_name']]['image'].
					"' align=left hspace=10 vspace=10 width=50><p><b>Счёт: ".
					round($games[$i]['4_score']).
					"</b><br><small>Гора: ".$games[$i]['4_hill'].
					"<br>Висты: ".$games[$i]['4_money']."</small></p>";
				}
				else
					echo ">";
				
				$month_rus = "";
				$month_ind = date_parse($games[$i]['date'])['month'];
				switch ($month_ind)
				{
					case 1: $month_rus = "янв"; break;
					case 2: $month_rus = "фев"; break;
					case 3: $month_rus = "мар"; break;
					case 4: $month_rus = "апр"; break;
					case 5: $month_rus = "май"; break;
					case 6: $month_rus = "июн"; break;
					case 7: $month_rus = "июл"; break;
					case 8: $month_rus = "авг"; break;
					case 9: $month_rus = "сен"; break;
					case 10: $month_rus = "окт"; break;
					case 11: $month_rus = "ноя"; break;
					case 12: $month_rus = "дек"; break;
				}
				
				echo "</td><td align=center>".date_parse($games[$i]['date'])['day']." ".$month_rus." ".date_parse($games[$i]['date'])['year'].
				"</td></tr>";
			}
			echo '</table>';
		} // drawTable()
		
		
		// Calculate players and games
		
		include('calculations.php');
		
		// Header
		
		$year_start = date_parse($games[0]['date'])['year'];
		$year_end = date_parse($games[$num_games - 1]['date'])['year'];
		echo "<div id='block_games_title'><h2>Список игр</h2></div>";
		echo "<div id='block_years'>[ ";
		for ($i = $year_start; $i >= $year_end; $i--)
		{
			echo "<a class='anchor_link' href='#anchor_".$i."'>".$i."</a>";
			if ($i > $year_end)
				echo " ";
		}
		echo " ]</div>";
		
		// Output games year-by-year
		
		$cur_year = date_parse($games[0]['date'])['year'];
		$start_index = 0;
		for ($i = 0; $i < $num_games; $i++)
		{
			$year = date_parse($games[$i]['date'])['year'];
			
			if ($year != $cur_year)
			{
				echo "<div class='block_year'><h3><a class='anchor' name='anchor_".$cur_year."'>".$cur_year." год</a></h3><br>";
				draw_table($start_index, $i - 1);
				$start_index = $i;
				$cur_year = $year;
				echo "<br></div>";
			}
			else if ($i == $num_games - 1)
			{
				echo "<div class='block_year'><h3><a class='anchor' name='anchor_".$cur_year."'>".$cur_year." год</a></h3><br>";
				draw_table($start_index, $i);
				$start_index = $i;
				$cur_year = $year;
				echo "<br></div>";
			}
		}

		?>
		
	</body>
</html>
