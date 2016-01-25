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
		
		echo '<table border="1"><td><th>Игрок 1</th><th>Игрок 2</th><th>Игрок 3</th><th>Игрок 4</th><th>До скольки</th></td>';
		for ($i = $num_games; $i >= 0; $i--)
		{
			echo "<tr><td width=20 align=center>".$games[$i]['id'].
			"</td></tr>";
		}
		echo '</table>';
		
		?>
		
	</body>
</html>
