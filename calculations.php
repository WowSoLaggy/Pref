<?php

$dbHost='localhost';
$dbName='pref';
$dbUser='root';
$dbPass='AfterWorld';
$myConnect = mysql_connect($dbHost, $dbUser, $dbPass);
mysql_select_db($dbName, $myConnect);
mysql_query("SET NAMES cp1251;");

// Get player list

$result = mysql_query("SELECT id, name, image FROM players_tbl");
$num_players = mysql_num_rows($result);
for ($i = 0; $i < $num_players; $i++)
{
	$players[$i]['id'] = mysql_result($result, $i, 'id');
	$players[$i]['name'] = mysql_result($result, $i, 'name');
	$players[$i]['image'] = mysql_result($result, $i, 'image');
	$players[$i]['hill'] = 0;
	$players[$i]['score'] = 0;
}
mysql_free_result($result);

// Parse all games

$result = mysql_query("SELECT * FROM games_tbl");
$num_games = mysql_num_rows($result);
for ($i = 0; $i < $num_games; $i++)
{
	$games[$i]['id'] = mysql_result($result, $i, 'id');
	$games[$i]['total'] = mysql_result($result, $i, 'total');
	$games[$i]['num_players'] = mysql_result($result, $i, 'num_players');
	$games[$i]['1_name'] = mysql_result($result, $i, '1_name');
	$games[$i]['2_name'] = mysql_result($result, $i, '2_name');
	$games[$i]['3_name'] = mysql_result($result, $i, '3_name');
	$games[$i]['4_name'] = mysql_result($result, $i, '4_name');
	$games[$i]['1_hill'] = mysql_result($result, $i, '1_hill');
	$games[$i]['2_hill'] = mysql_result($result, $i, '2_hill');
	$games[$i]['3_hill'] = mysql_result($result, $i, '3_hill');
	$games[$i]['4_hill'] = mysql_result($result, $i, '4_hill');
	$games[$i]['1_money_2'] = mysql_result($result, $i, '1_money_2');
	$games[$i]['1_money_3'] = mysql_result($result, $i, '1_money_3');
	$games[$i]['1_money_4'] = mysql_result($result, $i, '1_money_4');
	$games[$i]['2_money_1'] = mysql_result($result, $i, '2_money_1');
	$games[$i]['2_money_3'] = mysql_result($result, $i, '2_money_3');
	$games[$i]['2_money_4'] = mysql_result($result, $i, '2_money_4');
	$games[$i]['3_money_1'] = mysql_result($result, $i, '3_money_1');
	$games[$i]['3_money_2'] = mysql_result($result, $i, '3_money_2');
	$games[$i]['3_money_4'] = mysql_result($result, $i, '3_money_4');
	$games[$i]['4_money_1'] = mysql_result($result, $i, '4_money_1');
	$games[$i]['4_money_2'] = mysql_result($result, $i, '4_money_2');
	$games[$i]['4_money_3'] = mysql_result($result, $i, '4_money_3');
	$games[$i]['date'] = mysql_result($result, $i, 'date');
	
	if ($games[$i]['num_players'] == 3)
	{
		// Hill
		
		$players[$games[$i]['1_name']]['hill'] += $games[$i]['1_hill'];
		$players[$games[$i]['2_name']]['hill'] += $games[$i]['2_hill'];
		$players[$games[$i]['3_name']]['hill'] += $games[$i]['3_hill'];
		$total_hill = ($games[$i]['1_hill'] + $games[$i]['2_hill'] + $games[$i]['3_hill']) / 3;
		
		// 1
		
		$players[$games[$i]['1_name']]['score'] += $total_hill * 10;
		$players[$games[$i]['1_name']]['score'] -= $games[$i]['1_hill'] * 10;
		$players[$games[$i]['1_name']]['score'] += $games[$i]['1_money_2'];
		$players[$games[$i]['1_name']]['score'] += $games[$i]['1_money_3'];
		$players[$games[$i]['1_name']]['score'] -= $games[$i]['2_money_1'];
		$players[$games[$i]['1_name']]['score'] -= $games[$i]['3_money_1'];
		
		// 2
		
		$players[$games[$i]['2_name']]['score'] += $total_hill * 10;
		$players[$games[$i]['2_name']]['score'] -= $games[$i]['2_hill'] * 10;
		$players[$games[$i]['2_name']]['score'] += $games[$i]['2_money_1'];
		$players[$games[$i]['2_name']]['score'] += $games[$i]['2_money_3'];
		$players[$games[$i]['2_name']]['score'] -= $games[$i]['1_money_2'];
		$players[$games[$i]['2_name']]['score'] -= $games[$i]['3_money_2'];
		
		// 3
		
		$players[$games[$i]['3_name']]['score'] += $total_hill * 10;
		$players[$games[$i]['3_name']]['score'] -= $games[$i]['3_hill'] * 10;
		$players[$games[$i]['3_name']]['score'] += $games[$i]['3_money_1'];
		$players[$games[$i]['3_name']]['score'] += $games[$i]['3_money_2'];
		$players[$games[$i]['3_name']]['score'] -= $games[$i]['1_money_3'];
		$players[$games[$i]['3_name']]['score'] -= $games[$i]['2_money_3'];
	}
	else if ($games[$i]['num_players'] == 4)
	{
		// Hill
		
		$players[$games[$i]['1_name']]['hill'] += $games[$i]['1_hill'];
		$players[$games[$i]['2_name']]['hill'] += $games[$i]['2_hill'];
		$players[$games[$i]['3_name']]['hill'] += $games[$i]['3_hill'];
		$players[$games[$i]['4_name']]['hill'] += $games[$i]['4_hill'];
		$total_hill = ($games[$i]['1_hill'] + $games[$i]['2_hill'] +
			$games[$i]['3_hill'] + $games[$i]['4_hill']) / 4;
		
		// 1
		
		$players[$games[$i]['1_name']]['score'] += $total_hill * 10;
		$players[$games[$i]['1_name']]['score'] -= $games[$i]['1_hill'] * 10;
		$players[$games[$i]['1_name']]['score'] += $games[$i]['1_money_2'];
		$players[$games[$i]['1_name']]['score'] += $games[$i]['1_money_3'];
		$players[$games[$i]['1_name']]['score'] += $games[$i]['1_money_4'];
		$players[$games[$i]['1_name']]['score'] -= $games[$i]['2_money_1'];
		$players[$games[$i]['1_name']]['score'] -= $games[$i]['3_money_1'];
		$players[$games[$i]['1_name']]['score'] -= $games[$i]['4_money_1'];
		
		// 2
		
		$players[$games[$i]['2_name']]['score'] += $total_hill * 10;
		$players[$games[$i]['2_name']]['score'] -= $games[$i]['2_hill'] * 10;
		$players[$games[$i]['2_name']]['score'] += $games[$i]['2_money_1'];
		$players[$games[$i]['2_name']]['score'] += $games[$i]['2_money_3'];
		$players[$games[$i]['2_name']]['score'] += $games[$i]['2_money_4'];
		$players[$games[$i]['2_name']]['score'] -= $games[$i]['1_money_2'];
		$players[$games[$i]['2_name']]['score'] -= $games[$i]['3_money_2'];
		$players[$games[$i]['2_name']]['score'] -= $games[$i]['4_money_2'];
		
		// 3
		
		$players[$games[$i]['3_name']]['score'] += $total_hill * 10;
		$players[$games[$i]['3_name']]['score'] -= $games[$i]['3_hill'] * 10;
		$players[$games[$i]['3_name']]['score'] += $games[$i]['3_money_1'];
		$players[$games[$i]['3_name']]['score'] += $games[$i]['3_money_2'];
		$players[$games[$i]['3_name']]['score'] += $games[$i]['3_money_4'];
		$players[$games[$i]['3_name']]['score'] -= $games[$i]['1_money_3'];
		$players[$games[$i]['3_name']]['score'] -= $games[$i]['2_money_3'];
		$players[$games[$i]['3_name']]['score'] -= $games[$i]['4_money_3'];
		
		// 4
		
		$players[$games[$i]['4_name']]['score'] += $total_hill * 10;
		$players[$games[$i]['4_name']]['score'] -= $games[$i]['4_hill'] * 10;
		$players[$games[$i]['4_name']]['score'] += $games[$i]['4_money_1'];
		$players[$games[$i]['4_name']]['score'] += $games[$i]['4_money_2'];
		$players[$games[$i]['4_name']]['score'] += $games[$i]['4_money_3'];
		$players[$games[$i]['4_name']]['score'] -= $games[$i]['1_money_4'];
		$players[$games[$i]['4_name']]['score'] -= $games[$i]['2_money_4'];
		$players[$games[$i]['4_name']]['score'] -= $games[$i]['3_money_4'];
	}
}
mysql_free_result($result);
mysql_close($myConnect);

?>
