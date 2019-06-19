<?php

// Connect to DB

// Please specify the following vars in the 'security.php' file:
//$dbHost='my.host.com';
//$dbName='db_name';
//$dbUser='db_user';
//$dbPass='db_pass';
include('security.php');

$myConnect = mysql_connect($dbHost, $dbUser, $dbPass);
mysql_select_db($dbName, $myConnect);
mysql_query("SET NAMES utf8;");

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
	$players[$i]['total'] = 0;
	$players[$i]['wins'] = 0;
	$players[$i]['score_min'] = 99999;
	$players[$i]['score_avg'] = 0;
	$players[$i]['score_max'] = -99999;
	$players[$i]['hill_min'] = 99999;
	$players[$i]['hill_avg'] = 0;
	$players[$i]['hill_max'] = -99999;
	$players[$i]['money'] = 0;
	$players[$i]['money_min'] = 99999;
	$players[$i]['money_avg'] = 0;
	$players[$i]['money_max'] = -99999;
	$players[$i]['money_bal'] = 0;
	$players[$i]['money_bal_min'] = 99999;
	$players[$i]['money_bal_avg'] = 0;
	$players[$i]['money_bal_max'] = -99999;
}
mysql_free_result($result);

// Parse all games

$result = mysql_query("SELECT * FROM games_tbl ORDER BY date DESC");
$num_games = mysql_num_rows($result);
$total = 0;
$max_win = 0;
$max_win_ind = 0;
$max_win_player = 0;
$max_loss = 0;
$max_loss_ind = 0;
$max_loss_player = 0;
$max_hill = 0;
$max_hill_ind = 0;
$max_hill_player = 0;
$min_hill = 0;
$min_hill_ind = 0;
$min_hill_player = 0;
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
	
	// Total
	
	$total += $games[$i]['total'];
	$players[$games[$i]['1_name']]['total'] += $games[$i]['total'];
	$players[$games[$i]['2_name']]['total'] += $games[$i]['total'];
	$players[$games[$i]['3_name']]['total'] += $games[$i]['total'];
	if ($play4)
		$players[$games[$i]['4_name']]['total'] += $games[$i]['total'];
	
	// 1
	
	$score = 0;
	$money = 0;
	$player_id = $games[$i]['1_name'];
	
	// Money PLUS
	$money += $games[$i]['1_money_2'];
	$money += $games[$i]['1_money_3'];
	if ($play4)
		$money += $games[$i]['1_money_4'];
	$players[$player_id]['money'] += $money;
	if ($money < $players[$player_id]['money_min'])
		$players[$player_id]['money_min'] = $money;
	if ($money > $players[$player_id]['money_max'])
		$players[$player_id]['money_max'] = $money;
	
	// Money MINUS
	$money -= $games[$i]['2_money_1'];
	$money -= $games[$i]['3_money_1'];
	if ($play4)
		$money -= $games[$i]['4_money_1'];
	$players[$player_id]['money_bal'] += $money;
	$games[$i]['1_money'] = $money;
	if ($money < $players[$player_id]['money_bal_min'])
		$players[$player_id]['money_bal_min'] = $money;
	if ($money > $players[$player_id]['money_bal_max'])
		$players[$player_id]['money_bal_max'] = $money;
		
	// Result
	$score += $total_hill * 10;
	$score -= $games[$i]['1_hill'] * 10;
	$score += $money;
	$players[$player_id]['score'] += $score;
	$games[$i]['1_score'] = $score;
	if ($score < $players[$player_id]['score_min'])
		$players[$player_id]['score_min'] = $score;
	if ($score > $players[$player_id]['score_max'])
		$players[$player_id]['score_max'] = $score;
	
	// Stats
	$players[$player_id]['games']++;
	if ($score > 0)
		$players[$player_id]['wins']++;
	if ($games[$i]['1_hill'] < $players[$player_id]['hill_min'])
		$players[$player_id]['hill_min'] = $games[$i]['1_hill'];
	if ($games[$i]['1_hill'] > $players[$player_id]['hill_max'])
		$players[$player_id]['hill_max'] = $games[$i]['1_hill'];
	
	// Global stats
	if ($score > $max_win)
	{
		$max_win = $score;
		$max_win_ind = $i;
		$max_win_player = $player_id;
	}
	if ($score < $max_loss)
	{
		$max_loss = $score;
		$max_loss_ind = $i;
		$max_loss_player = $player_id;
	}
	if ($games[$i]['1_hill'] > $max_hill)
	{
		$max_hill = $games[$i]['1_hill'];
		$max_hill_ind = $i;
		$max_hill_player = $player_id;
	}
	if ($games[$i]['1_hill'] < $min_hill)
	{
		$min_hill = $games[$i]['1_hill'];
		$min_hill_ind = $i;
		$min_hill_player = $player_id;
	}
	
	// 2
	
	$score = 0;
	$money = 0;
	$player_id = $games[$i]['2_name'];
	
	// Money PLUS
	$money += $games[$i]['2_money_1'];
	$money += $games[$i]['2_money_3'];
	if ($play4)
		$money += $games[$i]['2_money_4'];
	$players[$player_id]['money'] += $money;
	if ($money < $players[$player_id]['money_min'])
		$players[$player_id]['money_min'] = $money;
	if ($money > $players[$player_id]['money_max'])
		$players[$player_id]['money_max'] = $money;
		
	// Money MINUS
	$money -= $games[$i]['1_money_2'];
	$money -= $games[$i]['3_money_2'];
	if ($play4)
		$money -= $games[$i]['4_money_2'];
	$players[$player_id]['money_bal'] += $money;
	$games[$i]['2_money'] = $money;
	if ($money < $players[$player_id]['money_bal_min'])
		$players[$player_id]['money_bal_min'] = $money;
	if ($money > $players[$player_id]['money_bal_max'])
		$players[$player_id]['money_bal_max'] = $money;
	
	// Result
	$score += $total_hill * 10;
	$score -= $games[$i]['2_hill'] * 10;
	$score += $money;
	$players[$player_id]['score'] += $score;
	$games[$i]['2_score'] = $score;
	if ($score < $players[$player_id]['score_min'])
		$players[$player_id]['score_min'] = $score;
	if ($score > $players[$player_id]['score_max'])
		$players[$player_id]['score_max'] = $score;
	
	// Stats
	$players[$player_id]['games']++;
	if ($score > 0)
		$players[$player_id]['wins']++;
	if ($games[$i]['2_hill'] < $players[$player_id]['hill_min'])
		$players[$player_id]['hill_min'] = $games[$i]['2_hill'];
	if ($games[$i]['2_hill'] > $players[$player_id]['hill_max'])
		$players[$player_id]['hill_max'] = $games[$i]['2_hill'];
	
	// Global stats
	if ($score > $max_win)
	{
		$max_win = $score;
		$max_win_ind = $i;
		$max_win_player = $player_id;
	}
	if ($score < $max_loss)
	{
		$max_loss = $score;
		$max_loss_ind = $i;
		$max_loss_player = $player_id;
	}
	if ($games[$i]['2_hill'] > $max_hill)
	{
		$max_hill = $games[$i]['2_hill'];
		$max_hill_ind = $i;
		$max_hill_player = $player_id;
	}
	if ($games[$i]['2_hill'] < $min_hill)
	{
		$min_hill = $games[$i]['2_hill'];
		$min_hill_ind = $i;
		$min_hill_player = $player_id;
	}
	
	// 3
	
	$score = 0;
	$money = 0;
	$player_id = $games[$i]['3_name'];
	
	// Money PLUS
	$money += $games[$i]['3_money_1'];
	$money += $games[$i]['3_money_2'];
	if ($play4)
		$money += $games[$i]['3_money_4'];
	$players[$player_id]['money'] += $money;
	if ($money < $players[$player_id]['money_min'])
		$players[$player_id]['money_min'] = $money;
	if ($money > $players[$player_id]['money_max'])
		$players[$player_id]['money_max'] = $money;
	
	// Money MINUS
	$money -= $games[$i]['1_money_3'];
	$money -= $games[$i]['2_money_3'];
	if ($play4)
		$money -= $games[$i]['4_money_3'];
	$players[$player_id]['money_bal'] += $money;
	$games[$i]['3_money'] = $money;
	if ($money < $players[$player_id]['money_bal_min'])
		$players[$player_id]['money_bal_min'] = $money;
	if ($money > $players[$player_id]['money_bal_max'])
		$players[$player_id]['money_bal_max'] = $money;
	
	// Result
	$score += $total_hill * 10;
	$score -= $games[$i]['3_hill'] * 10;
	$score += $money;
	$players[$player_id]['score'] += $score;
	$games[$i]['3_score'] = $score;
	if ($score < $players[$player_id]['score_min'])
		$players[$player_id]['score_min'] = $score;
	if ($score > $players[$player_id]['score_max'])
		$players[$player_id]['score_max'] = $score;
	
	// Stats
	$players[$player_id]['games']++;
	if ($score > 0)
		$players[$player_id]['wins']++;
	if ($games[$i]['3_hill'] < $players[$player_id]['hill_min'])
		$players[$player_id]['hill_min'] = $games[$i]['3_hill'];
	if ($games[$i]['3_hill'] > $players[$player_id]['hill_max'])
		$players[$player_id]['hill_max'] = $games[$i]['3_hill'];
	
	// Global stats
	if ($score > $max_win)
	{
		$max_win = $score;
		$max_win_ind = $i;
		$max_win_player = $player_id;
	}
	if ($score < $max_loss)
	{
		$max_loss = $score;
		$max_loss_ind = $i;
		$max_loss_player = $player_id;
	}
	if ($games[$i]['3_hill'] > $max_hill)
	{
		$max_hill = $games[$i]['3_hill'];
		$max_hill_ind = $i;
		$max_hill_player = $player_id;
	}
	if ($games[$i]['3_hill'] < $min_hill)
	{
		$min_hill = $games[$i]['3_hill'];
		$min_hill_ind = $i;
		$min_hill_player = $player_id;
	}
	
	if ($play4)
	{
		// 4
		
		$score = 0;
		$money = 0;
		$player_id = $games[$i]['4_name'];
		
		// Money PLUS
		$money += $games[$i]['4_money_1'];
		$money += $games[$i]['4_money_2'];
		$money += $games[$i]['4_money_3'];
		$players[$player_id]['money'] += $money;
		if ($money < $players[$player_id]['money_min'])
			$players[$player_id]['money_min'] = $money;
		if ($money > $players[$player_id]['money_max'])
			$players[$player_id]['money_max'] = $money;
		
		// Money MINUS
		$money -= $games[$i]['1_money_4'];
		$money -= $games[$i]['2_money_4'];
		$money -= $games[$i]['3_money_4'];
		$players[$player_id]['money_bal'] += $money;
		$games[$i]['4_money'] = $money;
		if ($money < $players[$player_id]['money_bal_min'])
			$players[$player_id]['money_bal_min'] = $money;
		if ($money > $players[$player_id]['money_bal_max'])
			$players[$player_id]['money_bal_max'] = $money;
		
		// Result
		$score += $total_hill * 10;
		$score -= $games[$i]['4_hill'] * 10;
		$score += $money;
		$players[$player_id]['score'] += $score;
		$games[$i]['4_score'] = $score;
		if ($score < $players[$player_id]['score_min'])
			$players[$player_id]['score_min'] = $score;
		if ($score > $players[$player_id]['score_max'])
			$players[$player_id]['score_max'] = $score;
		
		// Stats
		$players[$player_id]['games']++;
		if ($score > 0)
			$players[$player_id]['wins']++;
		if ($games[$i]['4_hill'] < $players[$player_id]['hill_min'])
			$players[$player_id]['hill_min'] = $games[$i]['4_hill'];
		if ($games[$i]['4_hill'] > $players[$player_id]['hill_max'])
			$players[$player_id]['hill_max'] = $games[$i]['4_hill'];
		
		// Global stats
		if ($score > $max_win)
		{
			$max_win = $score;
			$max_win_ind = $i;
			$max_win_player = $player_id;
		}
		if ($score < $max_loss)
		{
			$max_loss = $score;
			$max_loss_ind = $i;
			$max_loss_player = $player_id;
		}
		if ($games[$i]['4_hill'] > $max_hill)
		{
			$max_hill = $games[$i]['4_hill'];
			$max_hill_ind = $i;
			$max_hill_player = $player_id;
		}
		if ($games[$i]['4_hill'] < $min_hill)
		{
			$min_hill = $games[$i]['4_hill'];
			$min_hill_ind = $i;
			$min_hill_player = $player_id;
		}
	}
}
mysql_free_result($result);
mysql_close($myConnect);

for ($i = 0; $i < $num_players; $i++)
{
	$players[$i]['score_avg'] = round($players[$i]['score'] / $players[$i]['games']);
	$players[$i]['hill_avg'] = round($players[$i]['hill'] / $players[$i]['games']);
	$players[$i]['money_avg'] = round($players[$i]['money'] / $players[$i]['games']);
	$players[$i]['money_bal_avg'] = round($players[$i]['money_bal'] / $players[$i]['games']);
}

?>
