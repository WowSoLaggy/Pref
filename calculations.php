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


function getOpponentsInds($num_players, $own_id)
{
	$opponentsIds = array();
	for ($i = 1; $i <= $num_players; ++$i)
	{
		if ($i != $own_id)
			array_push($opponentsIds, $i);
	}
	return $opponentsIds;
}


function get_or_create_season(&$seasons, $year)
{
	foreach ($seasons as &$season)
	{
		if ($season->year == $year)
			return $season;
	}

	$new_season = new Season();
	$new_season->year = $year;
	array_push($seasons, $new_season);
	return $new_season;
}

//
// MAIN
//


// Get data

$connection = connect();

$players = getPlayers();
$num_players = count($players);

$games = getGames();
$num_games = count($games);

disconnect($connection);

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

$seasons = array();

for ($game_ind = 0; $game_ind < $num_games; ++$game_ind)
{
	$game = &$games[$game_ind];
	
	// Total
	
	$total += $game->total;
	
	// Avg hill (total_hill / num_players)
	
	$avg_hill = 0;
	for ($player_ind = 1; $player_ind <= $game->num_players; ++$player_ind)
		$avg_hill += $game->{'hill_'.$player_ind};
	$avg_hill = $avg_hill / $game->num_players;
	
	// Fill players stats
	
	for ($player_ind = 1; $player_ind <= $game->num_players; ++$player_ind)
	{
		$player_id = $game->{'name_'.$player_ind};
		$player = &$players[$player_id];
		
		// Total
		
		$player->total += $game->total;
		
		// Hill
		
		$player_hill = $game->{'hill_'.$player_ind};
		
		$player->hill += $player_hill;
		$player->hill_min = min($player->hill_min, $player_hill);
		$player->hill_max = max($player->hill_max, $player_hill);
		
		// Money / balance
		
		$opponents_inds = getOpponentsInds($game->num_players, $player_ind);
		$money_income = 0;
		$money_loss = 0;
		foreach ($opponents_inds as $opponent_ind)
		{
			$money_income += $game->{'money_'.$player_ind.'_'.$opponent_ind};
			$money_loss += $game->{'money_'.$opponent_ind.'_'.$player_ind};
		}
		
		$player->money += $money_income;
		$player->money_min = min($player->money_min, $money_income);
		$player->money_max = max($player->money_max, $money_income);
		
		$money_balance = $money_income - $money_loss;
		
		$player->balance += $money_balance;
		$player->balance_min = min($player->balance_min, $money_balance);
		$player->balance_max = max($player->balance_max, $money_balance);
		
		// Score
		
		$player_score = $avg_hill * 10;
		$player_score -= $player_hill * 10;
		$player_score += $money_balance;
		
		$game->{'score_'.$player_ind} = $player_score;
		$player->score += $player_score;
		$player->score_min = min($player->score_min, $player_score);
		$player->score_max = max($player->score_max, $player_score);
		
		// Other player's stats
		
		++$player->games;
		if ($player_score > 0)
			++$player->wins;
		
		// Global stats
		
		if ($player_score > $max_win)
		{
			$max_win = $player_score;
			$max_win_ind = $game_ind;
			$max_win_player = $player_id;
		}
		if ($player_score < $max_loss)
		{
			$max_loss = $player_score;
			$max_loss_ind = $game_ind;
			$max_loss_player = $player_id;
		}
		if ($player_hill > $max_hill)
		{
			$max_hill = $player_hill;
			$max_hill_ind = $game_ind;
			$max_hill_player = $player_id;
		}
		if ($player_hill < $min_hill)
		{
			$min_hill = $player_hill;
			$min_hill_ind = $game_ind;
			$min_hill_player = $player_id;
		}
	}
	
	// Seasons
	
	$cur_game_date = date_parse($game->date);
	$cur_game_year = $cur_game_date['year'];
	if ($cur_game_year <= 2008)
		continue;
	
	$season = &get_or_create_season($seasons, $cur_game_year);
	
	++$season->num_games;
	$season->total += $game->total;
	
	for ($player_ind = 1; $player_ind <= $game->num_players; ++$player_ind)
	{
		$player_id = $game->{'name_'.$player_ind};
		$player = &$players[$player_id];
		
		$season->players_score[$player_id] += $game->{'score_'.$player_ind};
	}
}


$current_year = date("Y");
foreach ($seasons as &$season)
{
	// Sort players by score
	arsort($season->players_score);
	
	// Add medals for all previous years
	if ($season->year >= $current_year)
		continue;
	
	// Get all players ids in descending order
	$keys = array_keys($season->players_score);
	
	$player_gold = &$players[$keys[0]];
	$player_gold->add_medal(MedalValue::Gold, $season->year);
	
	$player_silver = &$players[$keys[1]];
	$player_silver->add_medal(MedalValue::Silver, $season->year);
	
	$player_bronze = &$players[$keys[2]];
	$player_bronze->add_medal(MedalValue::Bronze, $season->year);
}


// Calculate average stats for all players

foreach ($players as &$player)
{
	$player->score_avg = round($player->score / $player->games);
	$player->hill_avg = round($player->hill / $player->games);
	$player->money_avg = round($player->money / $player->games);
	$player->balance_avg = round($player->balance / $player->games);
}

?>
