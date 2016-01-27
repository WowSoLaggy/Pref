<html>
	<head>
		<title>Клуб анонимных преферансистов</title>
		<meta charset="utf-8"/>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	
	<body>
	
		<h2>Список игр</h2>
		<br>
		
		<?php
		
		// Calculate players and games
		
		include('calculations.php');
		
		function draw_table($startIndex, $endIndex)
		{
			echo '<table border="1"><td><th width=60>Пуля</th><th width=170>Игрок 1</th><th width=170>Игрок 2</th><th width=170>Игрок 3</th><th width=170>Игрок 4</th><th width=150>Дата</th></td>';
			for ($i = $startIndex; $i < $endIndex; $i++)
			{
				echo "<tr valign=center><td width=20 align=center>".($num_games - $i).
				"</td><td align=center>".$games[$i]['total'].
				"</td><td";
				
				if ($games[$i]['1_score'] > 0)
					echo " bgcolor=#009900";
				else if ($games[$i]['1_score'] < 0)
					echo " bgcolor=#664400";
				
				echo "><img src='images/".$players[$games[$i]['1_name']]['image'].
				"' align=left hspace=10 vspace=10 width=50><p><b>Счёт: ".
				round($games[$i]['1_score']).
				"</b><br><small>Гора: ".$games[$i]['1_hill'].
				"<br>Висты: ".$games[$i]['1_money']."</small></p>".
				"</td><td";
				
				if ($games[$i]['2_score'] > 0)
					echo " bgcolor=#009900";
				else if ($games[$i]['2_score'] < 0)
					echo " bgcolor=#664400";
				
				echo "><img src='images/".$players[$games[$i]['2_name']]['image'].
				"' align=left hspace=10 vspace=10 width=50><p><b>Счёт: ".
				round($games[$i]['2_score']).
				"</b><br><small>Гора: ".$games[$i]['2_hill'].
				"<br>Висты: ".$games[$i]['2_money']."</small></p>".
				"</td><td";
				
				if ($games[$i]['3_score'] > 0)
					echo " bgcolor=#009900";
				else if ($games[$i]['3_score'] < 0)
					echo " bgcolor=#664400";
				
				echo "><img src='images/".$players[$games[$i]['3_name']]['image'].
				"' align=left hspace=10 vspace=10 width=50><p><b>Счёт: ".
				round($games[$i]['3_score']).
				"</b><br><small>Гора: ".$games[$i]['3_hill'].
				"<br>Висты: ".$games[$i]['3_money']."</small></p>".
				"</td><td";
				
				if ($games[$i]['num_players'] == 4)
				{
					if ($games[$i]['4_score'] > 0)
						echo " bgcolor=#009900";
					else if ($games[$i]['4_score'] < 0)
						echo " bgcolor=#664400";
				
					echo "><img src='images/".$players[$games[$i]['4_name']]['image'].
					"' align=left hspace=10 vspace=10 width=50><p><b>Счёт: ".
					round($games[$i]['4_score']).
					"</b><br><small>Гора: ".$games[$i]['4_hill'].
					"<br>Висты: ".$games[$i]['4_money']."</small></p>";
				}
				else
					echo ">";
				
				echo "</td><td align=center>".$games[$i]['date'].
				"</td></tr>";
			}
			echo '</table>';
		} // drawTable()
		
		// Output games
		
		draw_table(0, $num_games);
		
		?>
		
	</body>
</html>
