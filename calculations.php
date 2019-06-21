<?php

include('classes.php');

// Connects to the DB
function connect()
{
	// Please specify the following vars in the 'security.php' file:
	//$dbHost = 'my.host.com';
	//$dbName = 'db_name';
	//$dbUser = 'db_user';
	//$dbPass = 'db_pass';
	include('security.php');

	if (!isset($dbHost) || !isset($dbUser) || !isset($dbPass) || !isset($dbName))
		throw new Exception('Cannot connect to DB: Please check the connection settings in the "security.php" file');
	
	$connection = mysql_connect($dbHost, $dbUser, $dbPass);
	mysql_select_db($dbName, $connection);
	mysql_query("SET NAMES utf8;");
	
	return $connection;
}

// Disconnects from the DB
function disconnect($connection)
{
	mysql_close($connection);
}


// Returns array of all players
function getPlayers()
{
	$players = array();
	
	$result = mysql_query("SELECT id, name, image FROM players_tbl");
	$num_players = mysql_num_rows($result);
	for ($i = 0; $i < $num_players; $i++)
	{
		$player = new Player();
		
		$player->id = mysql_result($result, $i, 'id');
		$player->name = mysql_result($result, $i, 'name');
		$player->image = mysql_result($result, $i, 'image');
		
		array_push($players, $player);
	}
	mysql_free_result($result);
	
	return $players;
}

// Returns array of all games
function getGames()
{
	$games = array();

	$result = mysql_query("SELECT * FROM games_tbl ORDER BY date DESC");
	$num_games = mysql_num_rows($result);
	for ($i = 0; $i < $num_games; $i++)
	{
		$game = new Game();
		
		$game->id = mysql_result($result, $i, 'id');
		$game->total = mysql_result($result, $i, 'total');
		$game->num_players = mysql_result($result, $i, 'num_players');
		$game->date = mysql_result($result, $i, 'date');
		
		$game->name_1 = mysql_result($result, $i, '1_name');
		$game->name_2 = mysql_result($result, $i, '2_name');
		$game->name_3 = mysql_result($result, $i, '3_name');
		$game->name_4 = mysql_result($result, $i, '4_name');
		
		$game->hill_1 = mysql_result($result, $i, '1_hill');
		$game->hill_2 = mysql_result($result, $i, '2_hill');
		$game->hill_3 = mysql_result($result, $i, '3_hill');
		$game->hill_4 = mysql_result($result, $i, '4_hill');
		
		$game->money_1_2 = mysql_result($result, $i, '1_money_2');
		$game->money_1_3 = mysql_result($result, $i, '1_money_3');
		$game->money_1_4 = mysql_result($result, $i, '1_money_4');
		
		$game->money_2_1 = mysql_result($result, $i, '2_money_1');
		$game->money_2_3 = mysql_result($result, $i, '2_money_3');
		$game->money_2_4 = mysql_result($result, $i, '2_money_4');
		
		$game->money_3_1 = mysql_result($result, $i, '3_money_1');
		$game->money_3_2 = mysql_result($result, $i, '3_money_2');
		$game->money_3_4 = mysql_result($result, $i, '3_money_4');
		
		$game->money_4_1 = mysql_result($result, $i, '4_money_1');
		$game->money_4_2 = mysql_result($result, $i, '4_money_2');
		$game->money_4_3 = mysql_result($result, $i, '4_money_3');
		
		array_push($games, $game);
	}
	mysql_free_result($result);

	return $games;
}


//
// MAIN
//


$connection = connect();

$players = getPlayers();
$num_players = count($players);

$games = getGames();
$num_games = count($games);

// Parse all games

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
for ($game_ind = 0; $game_ind < $num_games; ++$game_ind)
{
	$total_hill = 0;
	for ($player_ind = 1; $player_ind <= $games[$game_ind]->num_players; ++$player_ind)
	{
		$player_id = $games[$game_ind]->{'name_'.$player_ind};
		$player = &$players[$player_id];
		
		$player_hill = $games[$game_ind]->{'hill_'.$player_ind};
		$player->hill += $player_hill;
		$total_hill += $player_hill;
	}
	$total_hill = $total_hill / $games[$game_ind]->num_players;
	
	/////////
	/////////
	// OLD
	/////////
	/////////
	
	
	$play4 = ($games[$game_ind]->num_players == 4);

	// Total

	$total += $games[$game_ind]->total;
	$players[$games[$game_ind]->name_1]->total += $games[$game_ind]->total;
	$players[$games[$game_ind]->name_2]->total += $games[$game_ind]->total;
	$players[$games[$game_ind]->name_3]->total += $games[$game_ind]->total;
	if ($play4)
		$players[$games[$game_ind]->name_4]->total += $games[$game_ind]->total;

	// 1

	$score = 0;
	$money = 0;
	$player_id = $games[$game_ind]->name_1;

	// Money PLUS
	$money += $games[$game_ind]->money_1_2;
	$money += $games[$game_ind]->money_1_3;
	if ($play4)
		$money += $games[$game_ind]->money_1_4;
	$players[$player_id]->money += $money;
	if ($money < $players[$player_id]->money_min)
		$players[$player_id]->money_min = $money;
	if ($money > $players[$player_id]->money_max)
		$players[$player_id]->money_max = $money;

	// Money MINUS
	$money -= $games[$game_ind]->money_2_1;
	$money -= $games[$game_ind]->money_3_1;
	if ($play4)
		$money -= $games[$game_ind]->money_4_1;
	$players[$player_id]->balance += $money;
	$games[$game_ind]->money_1 = $money;
	if ($money < $players[$player_id]->balance_min)
		$players[$player_id]->balance_min = $money;
	if ($money > $players[$player_id]->balance_max)
		$players[$player_id]->balance_max = $money;

	// Result
	$score += $total_hill * 10;
	$score -= $games[$game_ind]->hill_1 * 10;
	$score += $money;
	$players[$player_id]->score += $score;
	$games[$game_ind]->score_1 = $score;
	if ($score < $players[$player_id]->score_min)
		$players[$player_id]->score_min = $score;
	if ($score > $players[$player_id]->score_max)
		$players[$player_id]->score_max = $score;

	// Stats
	$players[$player_id]->games++;
	if ($score > 0)
		$players[$player_id]->wins++;
	if ($games[$game_ind]->hill_1 < $players[$player_id]->hill_min)
		$players[$player_id]->hill_min = $games[$game_ind]->hill_1;
	if ($games[$game_ind]->hill_1 > $players[$player_id]->hill_max)
		$players[$player_id]->hill_max = $games[$game_ind]->hill_1;

	// Global stats
	if ($score > $max_win)
	{
		$max_win = $score;
		$max_win_ind = $game_ind;
		$max_win_player = $player_id;
	}
	if ($score < $max_loss)
	{
		$max_loss = $score;
		$max_loss_ind = $game_ind;
		$max_loss_player = $player_id;
	}
	if ($games[$game_ind]->hill_1 > $max_hill)
	{
		$max_hill = $games[$game_ind]->hill_1;
		$max_hill_ind = $game_ind;
		$max_hill_player = $player_id;
	}
	if ($games[$game_ind]->hill_1 < $min_hill)
	{
		$min_hill = $games[$game_ind]->hill_1;
		$min_hill_ind = $game_ind;
		$min_hill_player = $player_id;
	}

	// 2

	$score = 0;
	$money = 0;
	$player_id = $games[$game_ind]->name_2;

	// Money PLUS
	$money += $games[$game_ind]->money_2_1;
	$money += $games[$game_ind]->money_2_3;
	if ($play4)
		$money += $games[$game_ind]->money_2_4;
	$players[$player_id]->money += $money;
	if ($money < $players[$player_id]->money_min)
		$players[$player_id]->money_min = $money;
	if ($money > $players[$player_id]->money_max)
		$players[$player_id]->money_max = $money;

	// Money MINUS
	$money -= $games[$game_ind]->money_1_2;
	$money -= $games[$game_ind]->money_3_2;
	if ($play4)
		$money -= $games[$game_ind]->money_4_2;
	$players[$player_id]->balance += $money;
	$games[$game_ind]->money_2 = $money;
	if ($money < $players[$player_id]->balance_min)
		$players[$player_id]->balance_min = $money;
	if ($money > $players[$player_id]->balance_max)
		$players[$player_id]->balance_max = $money;

	// Result
	$score += $total_hill * 10;
	$score -= $games[$game_ind]->hill_2 * 10;
	$score += $money;
	$players[$player_id]->score += $score;
	$games[$game_ind]->score_2 = $score;
	if ($score < $players[$player_id]->score_min)
		$players[$player_id]->score_min = $score;
	if ($score > $players[$player_id]->score_max)
		$players[$player_id]->score_max = $score;

	// Stats
	$players[$player_id]->games++;
	if ($score > 0)
		$players[$player_id]->wins++;
	if ($games[$game_ind]->hill_2 < $players[$player_id]->hill_min)
		$players[$player_id]->hill_min = $games[$game_ind]->hill_2;
	if ($games[$game_ind]->hill_2 > $players[$player_id]->hill_max)
		$players[$player_id]->hill_max = $games[$game_ind]->hill_2;

	// Global stats
	if ($score > $max_win)
	{
		$max_win = $score;
		$max_win_ind = $game_ind;
		$max_win_player = $player_id;
	}
	if ($score < $max_loss)
	{
		$max_loss = $score;
		$max_loss_ind = $game_ind;
		$max_loss_player = $player_id;
	}
	if ($games[$game_ind]->hill_2 > $max_hill)
	{
		$max_hill = $games[$game_ind]->hill_2;
		$max_hill_ind = $game_ind;
		$max_hill_player = $player_id;
	}
	if ($games[$game_ind]->hill_2 < $min_hill)
	{
		$min_hill = $games[$game_ind]->hill_2;
		$min_hill_ind = $game_ind;
		$min_hill_player = $player_id;
	}

	// 3

	$score = 0;
	$money = 0;
	$player_id = $games[$game_ind]->name_3;

	// Money PLUS
	$money += $games[$game_ind]->money_3_1;
	$money += $games[$game_ind]->money_3_2;
	if ($play4)
		$money += $games[$game_ind]->money_3_4;
	$players[$player_id]->money += $money;
	if ($money < $players[$player_id]->money_min)
		$players[$player_id]->money_min = $money;
	if ($money > $players[$player_id]->money_max)
		$players[$player_id]->money_max = $money;

	// Money MINUS
	$money -= $games[$game_ind]->money_1_3;
	$money -= $games[$game_ind]->money_2_3;
	if ($play4)
		$money -= $games[$game_ind]->money_4_3;
	$players[$player_id]->balance += $money;
	$games[$game_ind]->money_3 = $money;
	if ($money < $players[$player_id]->balance_min)
		$players[$player_id]->balance_min = $money;
	if ($money > $players[$player_id]->balance_max)
		$players[$player_id]->balance_max = $money;

	// Result
	$score += $total_hill * 10;
	$score -= $games[$game_ind]->hill_3 * 10;
	$score += $money;
	$players[$player_id]->score += $score;
	$games[$game_ind]->score_3 = $score;
	if ($score < $players[$player_id]->score_min)
		$players[$player_id]->score_min = $score;
	if ($score > $players[$player_id]->score_max)
		$players[$player_id]->score_max = $score;

	// Stats
	$players[$player_id]->games++;
	if ($score > 0)
		$players[$player_id]->wins++;
	if ($games[$game_ind]->hill_3 < $players[$player_id]->hill_min)
		$players[$player_id]->hill_min = $games[$game_ind]->hill_3;
	if ($games[$game_ind]->hill_3 > $players[$player_id]->hill_max)
		$players[$player_id]->hill_max = $games[$game_ind]->hill_3;

	// Global stats
	if ($score > $max_win)
	{
		$max_win = $score;
		$max_win_ind = $game_ind;
		$max_win_player = $player_id;
	}
	if ($score < $max_loss)
	{
		$max_loss = $score;
		$max_loss_ind = $game_ind;
		$max_loss_player = $player_id;
	}
	if ($games[$game_ind]->hill_3 > $max_hill)
	{
		$max_hill = $games[$game_ind]->hill_3;
		$max_hill_ind = $game_ind;
		$max_hill_player = $player_id;
	}
	if ($games[$game_ind]->hill_3 < $min_hill)
	{
		$min_hill = $games[$game_ind]->hill_3;
		$min_hill_ind = $game_ind;
		$min_hill_player = $player_id;
	}

	if ($play4)
	{
		// 4

		$score = 0;
		$money = 0;
		$player_id = $games[$game_ind]->name_4;

		// Money PLUS
		$money += $games[$game_ind]->money_4_1;
		$money += $games[$game_ind]->money_4_2;
		$money += $games[$game_ind]->money_4_3;
		$players[$player_id]->money += $money;
		if ($money < $players[$player_id]->money_min)
			$players[$player_id]->money_min = $money;
		if ($money > $players[$player_id]->money_max)
			$players[$player_id]->money_max = $money;

		// Money MINUS
		$money -= $games[$game_ind]->money_1_4;
		$money -= $games[$game_ind]->money_2_4;
		$money -= $games[$game_ind]->money_3_4;
		$players[$player_id]->balance += $money;
		$games[$game_ind]->money_4 = $money;
		if ($money < $players[$player_id]->balance_min)
			$players[$player_id]->balance_min = $money;
		if ($money > $players[$player_id]->balance_max)
			$players[$player_id]->balance_max = $money;

		// Result
		$score += $total_hill * 10;
		$score -= $games[$game_ind]->hill_4 * 10;
		$score += $money;
		$players[$player_id]->score += $score;
		$games[$game_ind]->score_4 = $score;
		if ($score < $players[$player_id]->score_min)
			$players[$player_id]->score_min = $score;
		if ($score > $players[$player_id]->score_max)
			$players[$player_id]->score_max = $score;

		// Stats
		$players[$player_id]->games++;
		if ($score > 0)
			$players[$player_id]->wins++;
		if ($games[$game_ind]->hill_4 < $players[$player_id]->hill_min)
			$players[$player_id]->hill_min = $games[$game_ind]->hill_4;
		if ($games[$game_ind]->hill_4 > $players[$player_id]->hill_max)
			$players[$player_id]->hill_max = $games[$game_ind]->hill_4;

		// Global stats
		if ($score > $max_win)
		{
			$max_win = $score;
			$max_win_ind = $game_ind;
			$max_win_player = $player_id;
		}
		if ($score < $max_loss)
		{
			$max_loss = $score;
			$max_loss_ind = $game_ind;
			$max_loss_player = $player_id;
		}
		if ($games[$game_ind]->hill_4 > $max_hill)
		{
			$max_hill = $games[$game_ind]->hill_4;
			$max_hill_ind = $game_ind;
			$max_hill_player = $player_id;
		}
		if ($games[$game_ind]->hill_4 < $min_hill)
		{
			$min_hill = $games[$game_ind]->hill_4;
			$min_hill_ind = $game_ind;
			$min_hill_player = $player_id;
		}
	}
}

disconnect($connection);

for ($player_ind = 0; $player_ind < $num_players; $player_ind++)
{
	$players[$player_ind]->score_avg = round($players[$player_ind]->score / $players[$player_ind]->games);
	$players[$player_ind]->hill_avg = round($players[$player_ind]->hill / $players[$player_ind]->games);
	$players[$player_ind]->money_avg = round($players[$player_ind]->money / $players[$player_ind]->games);
	$players[$player_ind]->balance_avg = round($players[$player_ind]->balance / $players[$player_ind]->games);
}

?>
