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
	$players[$i]['games'] = 0;
	$players[$i]['wins'] = 0;
	$players[$i]['hill_min'] = 0;
	$players[$i]['hill_avg'] = 0;
	$players[$i]['hill_max'] = 0;
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
	
	$play4 = ($games[$i]['num_players'] == 4);
	
	// Hill
	
	$players[$games[$i]['1_name']]['hill'] += $games[$i]['1_hill'];
	$players[$games[$i]['2_name']]['hill'] += $games[$i]['2_hill'];
	$players[$games[$i]['3_name']]['hill'] += $games[$i]['3_hill'];
	if (!$play4)
		$total_hill = ($games[$i]['1_hill'] + $games[$i]['2_hill'] + $games[$i]['3_hill']) / 3;
	else
	{
		$players[$games[$i]['4_name']]['hill'] += $games[$i]['4_hill'];
		$total_hill = ($games[$i]['1_hill'] + $games[$i]['2_hill'] +
			$games[$i]['3_hill'] + $games[$i]['4_hill']) / 4;
	}
	
	// 1
	
	$score = 0;
	$score += $total_hill * 10;
	$score -= $games[$i]['1_hill'] * 10;
	$score += $games[$i]['1_money_2'];
	$score += $games[$i]['1_money_3'];
	if ($play4)
		$score += $games[$i]['1_money_4'];
	$score -= $games[$i]['2_money_1'];
	$score -= $games[$i]['3_money_1'];
	if ($play4)
		$score -= $games[$i]['4_money_1'];
	$players[$games[$i]['1_name']]['score'] += $score;
	$players[$games[$i]['1_name']]['games']++;
	if ($score > 0)
		players[$games[$i]['1_name']]['wins']++;
	if ($games[$i]['1_hill'] < players[$games[$i]['1_name']]['hill_min'])
		players[$games[$i]['1_name']]['hill_min'] = $games[$i]['1_hill'];
	if ($games[$i]['1_hill'] > players[$games[$i]['1_name']]['hill_max'])
		players[$games[$i]['1_name']]['hill_max'] = $games[$i]['1_hill'];
	players[$games[$i]['1_name']]['hill_avg'] = players[$games[$i]['1_name']]['hill'] /
		$players[$games[$i]['1_name']]['games'];
	
	// 2
	
	$score = 0;
	$score += $total_hill * 10;
	$score -= $games[$i]['2_hill'] * 10;
	$score += $games[$i]['2_money_1'];
	$score += $games[$i]['2_money_3'];
	if ($play4)
		$score += $games[$i]['2_money_4'];
	$score -= $games[$i]['1_money_2'];
	$score -= $games[$i]['3_money_2'];
	if ($play4)
		$score -= $games[$i]['4_money_2'];
	$players[$games[$i]['2_name']]['score'] += $score;
	$players[$games[$i]['2_name']]['games']++;
	if ($score > 0)
		players[$games[$i]['2_name']]['wins']++;
	if ($games[$i]['2_hill'] < players[$games[$i]['2_name']]['hill_min'])
		players[$games[$i]['2_name']]['hill_min'] = $games[$i]['2_hill'];
	if ($games[$i]['2_hill'] > players[$games[$i]['2_name']]['hill_max'])
		players[$games[$i]['2_name']]['hill_max'] = $games[$i]['2_hill'];
	players[$games[$i]['2_name']]['hill_avg'] = players[$games[$i]['2_name']]['hill'] /
		$players[$games[$i]['2_name']]['games'];
	
	// 3
	
	$score = 0;
	$score += $total_hill * 10;
	$score -= $games[$i]['3_hill'] * 10;
	$score += $games[$i]['3_money_1'];
	$score += $games[$i]['3_money_2'];
	if ($play4)
		$score += $games[$i]['3_money_4'];
	$score -= $games[$i]['1_money_3'];
	$score -= $games[$i]['2_money_3'];
	if ($play4)
		$score -= $games[$i]['4_money_3'];
	$players[$games[$i]['3_name']]['score'] += $score;
	$players[$games[$i]['3_name']]['games']++;
	if ($score > 0)
		players[$games[$i]['3_name']]['wins']++;
	if ($games[$i]['3_hill'] < players[$games[$i]['3_name']]['hill_min'])
		players[$games[$i]['3_name']]['hill_min'] = $games[$i]['3_hill'];
	if ($games[$i]['3_hill'] > players[$games[$i]['3_name']]['hill_max'])
		players[$games[$i]['3_name']]['hill_max'] = $games[$i]['3_hill'];
	players[$games[$i]['3_name']]['hill_avg'] = players[$games[$i]['3_name']]['hill'] /
		$players[$games[$i]['3_name']]['games'];
	
	if ($play4)
	{
		// 4
		
		$score = 0;
		$score += $total_hill * 10;
		$score -= $games[$i]['4_hill'] * 10;
		$score += $games[$i]['4_money_1'];
		$score += $games[$i]['4_money_2'];
		$score += $games[$i]['4_money_3'];
		$score -= $games[$i]['1_money_4'];
		$score -= $games[$i]['2_money_4'];
		$score -= $games[$i]['3_money_4'];
		$players[$games[$i]['4_name']]['score'] += $score;
		$players[$games[$i]['4_name']]['games']++;
		if ($score > 0)
			players[$games[$i]['4_name']]['wins']++;
		if ($games[$i]['4_hill'] < players[$games[$i]['4_name']]['hill_min'])
			players[$games[$i]['4_name']]['hill_min'] = $games[$i]['4_hill'];
		if ($games[$i]['4_hill'] > players[$games[$i]['4_name']]['hill_max'])
			players[$games[$i]['4_name']]['hill_max'] = $games[$i]['4_hill'];
		players[$games[$i]['4_name']]['hill_avg'] = players[$games[$i]['4_name']]['hill'] /
			$players[$games[$i]['4_name']]['games'];
	}
}
mysql_free_result($result);
mysql_close($myConnect);

?>
