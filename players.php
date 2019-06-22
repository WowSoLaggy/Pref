<html>
	<head>
		<title>Клуб "Паровоз Козлова"</title>
		<meta charset="utf-8"/>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	
	<body class="light">
	
		<h2>Список игроков</h2>
		<br>
		
		<?php
		
		// Calculate players and games
		
		include('calculations.php');
		
		// Output Top-players
		
		echo '<table border="1"><td><th>Имя</th><th>Общий счёт<br>(мин/ср/макс)</th><th>Игры<br>(Сумма пуль)</th><th>Участие/<br>Победы</th>
		<th>Общая гора<br>(мин/ср/макс)</th><th>Баланс вистов<br>(мин/ср/макс)</th><th>Всего вистов<br>(мин/ср/макс)</th><th>Медали</th></td>';
		
		for ($player_ind = 0; $player_ind < $num_players; $player_ind++)
		{
			$str = "<tr><td width=20 align=center>".($player_ind + 1)."</td>";
			$str .= 
					"<td width=160><img src='images/".$players[$player_ind]->image.
					"' align=absmiddle hspace=10 vspace=10 width=50>".$players[$player_ind]->name.
					"</td>";
			$str .=
					"<td width=110 align=center><b><font size='+1'>".round($players[$player_ind]->score)."</font></b><br>(".
					round($players[$player_ind]->score_min)."/".round($players[$player_ind]->score_avg)."/".round($players[$player_ind]->score_max).
					")</td>";
			$str .=
					"<td width=110 align=center>".$players[$player_ind]->games."<br>(".$players[$player_ind]->total.
					")</td>";
			$str .=
					"<td width=75 align=center>".round($players[$player_ind]->games / $num_games * 100)."%/".
					round($players[$player_ind]->wins / $players[$player_ind]->games * 100).
					"%</td>";
			$str .=
					"<td width=120 align=center>".$players[$player_ind]->hill."<br>(".
					$players[$player_ind]->hill_min."/".round($players[$player_ind]->hill_avg)."/".$players[$player_ind]->hill_max.
					")</td>";
			$str .=
					"<td width=120 align=center>".$players[$player_ind]->balance."<br>(".
					$players[$player_ind]->balance_min."/".round($players[$player_ind]->balance_avg)."/".$players[$player_ind]->balance_max.
					")</td>";
			$str .=
					"<td width=120 align=center>".$players[$player_ind]->money."<br>(".
					$players[$player_ind]->money_min."/".round($players[$player_ind]->money_avg)."/".$players[$player_ind]->money_max.
					")</td>";
			
			// Medals
			$str .= "<td width=160 align=center>";
			
			for ($i = 0; $i < $players[$player_ind]->medals_gold; ++$i)
				$str .= "<img src='images/medal_gold.png' width=15>";
			$str .= " ";
			for ($i = 0; $i < $players[$player_ind]->medals_silver; ++$i)
				$str .= "<img src='images/medal_silver.png' width=15>";
			$str .= " ";
			for ($i = 0; $i < $players[$player_ind]->medals_bronze; ++$i)
				$str .= "<img src='images/medal_bronze.png' width=15>";
			
			$str .= "</td>";
			
			$str .= "</tr>";
			
			echo $str;
		}
		echo '</table>';
		
		?>
		
		<br>
		Пояснения:<br>
		<ol>
			<li>Победой считается игра, где окончательный счёт игрока больше нуля.</li>
			<li>Общая гора - сумма по горе за все игры БЕЗ списания в конце игры.</li>
			<li>Баланс вистов - общая сумма всех вистов, написанных игроком на всех остальных, и ответных вистов, написанных на игрока.</li>
			<li>Всего вистов - сумма всех вистов, написанных игроком на всех остальных игроков за все игры. Не включает в себя ответные висты на игрока.</li>
			<li>Поле "Участие/Победы" (например "95%/61%") следует читать так: участвовал в 95 процентах игр, из них выиграл 61 процент игр.</li>
			<li>Козлов - жмот.</li>
		</ol>
		
	</body>
</html>
