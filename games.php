<html>
	<head>
		<title>Клуб анонимных преферансистов</title>
		<meta charset="utf-8"/>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	
	<body>
	
		<h2>Список игр</h2>
		<br>
		
		Тут пока ничего нет. Но скоро будет.
		
		<?php
		
		// Calculate players and games
		
		include('calculations.php');
		
		// Output games
		
		echo '<table border="1"><td><th width=160>Игрок 1</th><th width=160>Игрок 2</th><th width=160>Игрок 3</th><th width=160>Игрок 4</th><th width=60>Пуля</th></td>';
		for ($i = $num_games - 1; $i >= 0; $i--)
		{
			echo "<tr><td width=20 align=center>".($games[$i]['id'] + 1).
			"</td><td><img src='images/".$players[$games[$id]['1_name']]['image']."' align=absmiddle hspace=10 vspace=10 width=50>".
			"</td></tr>";
		}
		echo '</table>';
		
		?>
		
	</body>
</html>
