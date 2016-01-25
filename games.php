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
		
		// Output games
		
		echo '<table border="1"><td><th width=60>Пуля</th><th width=170>Игрок 1</th><th width=170>Игрок 2</th><th width=170>Игрок 3</th><th width=170>Игрок 4</th><th width=150>Дата</th></td>';
		for ($i = $num_games - 1; $i >= 0; $i--)
		{
			echo "<tr valign=center><td width=20 align=center>".($games[$i]['id'] + 1).
			"</td><td align=center>".$games[$i]['total'].
			"</td><td><img src='images/".$players[$games[$i]['1_name']]['image'].
			"' align=left hspace=10 vspace=10 width=50><p>Счёт: ".$games[$i]['1_score'].
			"<br>Гора: ".$games[$i]['1_hill'].
			"<br>Висты: ".$games[$i]['1_money']."</p>".
			"</td><td><img src='images/".$players[$games[$i]['2_name']]['image'].
			"' align=left hspace=10 vspace=10 width=50><p>Счёт: ".$games[$i]['2_score'].
			"<br>Гора: ".$games[$i]['2_hill'].
			"<br>Висты: ".$games[$i]['2_money']."</p>".
			"</td><td><img src='images/".$players[$games[$i]['3_name']]['image'].
			"' align=left hspace=10 vspace=10 width=50><p>Счёт: ".$games[$i]['3_score'].
			"<br>Гора: ".$games[$i]['3_hill'].
			"<br>Висты: ".$games[$i]['3_money']."</p>".
			"</td><td>";
			if ($games[$i]['num_players'] == 4)
				echo "<img src='images/".$players[$games[$i]['4_name']]['image'].
				"' align=left hspace=10 vspace=10 width=50><p>Счёт: ".$games[$i]['4_score'].
				"<br>Гора: ".$games[$i]['4_hill'].
				"<br>Висты: ".$games[$i]['4_money']."</p>";
			echo "</td><td align=center>".$games[$i]['date'].
			"</td></tr>";
		}
		echo '</table>';
		
		?>
		
	</body>
</html>
