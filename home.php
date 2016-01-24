<html>
	<head>
		<title>Клуб анонимных преферансистов</title>
		<meta charset="utf-8"/>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	
	<body>
	
		<h2>Главная страница</h2>
		<br>
		
		<?php
		$dbHost='localhost';
		$dbName='pref';
		$dbUser='root';
		$dbPass='AfterWorld';
		$myConnect = mysql_connect($dbHost, $dbUser, $dbPass);
		mysql_select_db($dbName, $myConnect);
		
		$result = mysql_query("SELECT id, name FROM players_tbl");
		$count = mysql_num_rows($result);
		for ($i = 0; $i < $count; $i++)
		{
			$players[$i]['id'] = mysql_result($result, $i, 'id');
			$players[$i]['name'] = mysql_result($result, $i, 'name');
		}
		
		echo '<h3>Топ игроков</h3><table border="1">';
		for ($i = 0; $i < $count; $i++)
			echo "<tr><td width=20 align=center>".$players[$i]['id']."</td><td width=100>".$players[$i]['name']."</td><td width=50 align=right>352</td></tr>";
		echo '</table>';
		
		mysql_free_result($result);
		mysql_close($myConnect);
		
		?>
		
		<br>
		<h3>Общая статистика</h3>
		
		<table border="0">
			<tr><td width=220 align=left>Всего сыграно игр:</td><td>5</td>
			<tr><td>Всего участвовало игроков:</td><td>4</td>
		</table>
		
	</body>
</html>
