<html>
	<head>
		<title>Клуб анонимных преферансистов</title>
		<meta charset="utf-8"/>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	
	<body>
	
		<h2>Главная страница</h2>
		<br>
		<h3>Топ игроков</h3>
	
		<table border="1">
			<tr><td width=20 align=center>1</td><td width=100>Егоров</td><td width=50 align=right>352</td></tr>
			<tr><td align=center>2</td><td>Юля</td><td align=right>70</td></tr>
			<tr><td align=center>3</td><td>Дегть</td><td align=right>-196</td></tr>
			<tr><td align=center>4</td><td>Козлов</td><td align=right>-224</td></tr>
		</table>
		
		<br>
		<h3>Общая статистика</h3>
		
		<table border="0">
			<tr><td width=220 align=left>Всего сыграно игр:</td><td>5</td>
			<tr><td>Всего участвовало игроков:</td><td>4</td>
		</table>
		
		<?php
		$dbHost='localhost';
		$dbName='pref';
		$dbUser='root';
		$dbPass='AfterWorld';
		
		$myConnect = mysql_connect($dbHost, $dbUser, $dbPass);
		mysql_select_db($dbName, $myConnect);
		
		$qwer = mysql_query("SELECT id FROM games_tbl WHERE 1_name=3 OR 2_name=3 OR 3_name=3 OR 4_name=3;", $myConnect);
		$arr=mysql_fetch_array($qwer);
		echo $arr[0].' '.$arr[1];
		mysql_close($myConnect);
		?>
		
	</body>
</html>
