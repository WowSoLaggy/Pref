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
		<th>Общая гора<br>(мин/ср/макс)</th><th>Баланс вистов<br>(мин/ср/макс)</th><th>Всего вистов<br>(мин/ср/макс)</th></td>';
		for ($i = 0; $i < $num_players; $i++)
		{
			echo "<tr><td width=20 align=center>".($i + 1).
			"</td><td width=160><img src='images/".$players[$i]->image.
			"' align=absmiddle hspace=10 vspace=10 width=50>".$players[$i]->name.
			"</td><td width=110 align=center><b><font size='+1'>".round($players[$i]->score)."</font></b><br>(".
			round($players[$i]->score_min)."/".round($players[$i]->score_avg)."/".round($players[$i]->score_max).
			")</td><td width=110 align=center>".$players[$i]->games."<br>(".$players[$i]->total.
			")</td><td width=75 align=center>".round($players[$i]->games / $num_games * 100)."%/".
			round($players[$i]->wins / $players[$i]->games * 100).
			"%</td><td width=120 align=center>".$players[$i]->hill."<br>(".
			$players[$i]->hill_min."/".round($players[$i]->hill_avg)."/".$players[$i]->hill_max.
			")</td><td width=120 align=center>".$players[$i]->balance."<br>(".
			$players[$i]->balance_min."/".round($players[$i]->balance_avg)."/".$players[$i]->balance_max.
			")</td><td width=120 align=center>".$players[$i]->money."<br>(".
			$players[$i]->money_min."/".round($players[$i]->money_avg)."/".$players[$i]->money_max.
			")</td></tr>";
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
