<?php

include('awards.php');
include_once('classes.php');

// Connects to the DB
function connect()
{
	// Please specify the following vars in the 'security.php' file:
	//$dbHost = 'my.host.com';
	//$dbName = 'db_name';
	//$dbUser = 'db_user';
	//$dbPass = 'db_pass';
	include('./../config/security.php');

	if (!isset($dbHost) || !isset($dbUser) || !isset($dbPass) || !isset($dbName))
		throw new Exception('Cannot connect to DB: Please check the connection settings in the "security.php" file');
	
	$link = mysqli_connect($dbHost, $dbUser, $dbPass);;
	mysqli_select_db($link, $dbName) or die('Error'. mysqli_error());
	mysqli_query($link, "SET NAMES utf8;");
	
	return $link;
}

// Disconnects from the DB
function disconnect($connection)
{
	mysqli_close($connection);
}


// Self-written (honestly copied from web) function
// that replaces 'mysql_result'
function mysqli_result($res,$row=0,$col=0){ 
    $numrows = mysqli_num_rows($res); 
    if ($numrows && $row <= ($numrows-1) && $row >=0){
        mysqli_data_seek($res,$row);
        $resrow = (is_numeric($col)) ? mysqli_fetch_row($res) : mysqli_fetch_assoc($res);
        if (isset($resrow[$col])){
            return $resrow[$col];
        }
    }
    return false;
}


// Returns array of all players
function getPlayers($connection)
{
	$players = array();
	
	$result = mysqli_query($connection, "SELECT id, name, image FROM players_tbl");
	$num_players = mysqli_num_rows($result);
	for ($i = 0; $i < $num_players; $i++)
	{
		$player = new Player();
		
		$player->id = mysqli_result($result, $i, 'id');
		$player->name = mysqli_result($result, $i, 'name');
		$player->image = mysqli_result($result, $i, 'image');
		
		array_push($players, $player);
	}
	mysqli_free_result($result);
	
	return $players;
}

// Returns array of all games
function getGames($connection)
{
	$games = array();

	$result = mysqli_query($connection, "SELECT * FROM games_tbl ORDER BY date DESC");
	$num_games = mysqli_num_rows($result);
	for ($i = 0; $i < $num_games; $i++)
	{
		$game = new Game();
		
		$game->id = mysqli_result($result, $i, 'id');
		$game->total = mysqli_result($result, $i, 'total');
		$game->num_players = mysqli_result($result, $i, 'num_players');
		$game->date = mysqli_result($result, $i, 'date');
		
		$game->name_1 = mysqli_result($result, $i, '1_name');
		$game->name_2 = mysqli_result($result, $i, '2_name');
		$game->name_3 = mysqli_result($result, $i, '3_name');
		$game->name_4 = mysqli_result($result, $i, '4_name');
		
		$game->hill_1 = mysqli_result($result, $i, '1_hill');
		$game->hill_2 = mysqli_result($result, $i, '2_hill');
		$game->hill_3 = mysqli_result($result, $i, '3_hill');
		$game->hill_4 = mysqli_result($result, $i, '4_hill');
		
		$game->money_1_2 = mysqli_result($result, $i, '1_money_2');
		$game->money_1_3 = mysqli_result($result, $i, '1_money_3');
		$game->money_1_4 = mysqli_result($result, $i, '1_money_4');
		
		$game->money_2_1 = mysqli_result($result, $i, '2_money_1');
		$game->money_2_3 = mysqli_result($result, $i, '2_money_3');
		$game->money_2_4 = mysqli_result($result, $i, '2_money_4');
		
		$game->money_3_1 = mysqli_result($result, $i, '3_money_1');
		$game->money_3_2 = mysqli_result($result, $i, '3_money_2');
		$game->money_3_4 = mysqli_result($result, $i, '3_money_4');
		
		$game->money_4_1 = mysqli_result($result, $i, '4_money_1');
		$game->money_4_2 = mysqli_result($result, $i, '4_money_2');
		$game->money_4_3 = mysqli_result($result, $i, '4_money_3');
		
		array_push($games, $game);
	}
	mysqli_free_result($result);

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

$players = getPlayers($connection);
$num_players = count($players);

$games = getGames($connection);
$num_games = count($games);



disconnect($connection);

// Sort games ascending by date

function games_sorter($a, $b)
{
	return strtotime($a->date) - strtotime($b->date);
}
usort($games, "games_sorter");

// Parse all games

$total = 0;
$max_win = 0;
$max_win_id = 0;
$max_win_player = 0;
$max_loss = 0;
$max_loss_id = 0;
$max_loss_player = 0;
$max_hill = 0;
$max_hill_id = 0;
$max_hill_player = 0;
$min_hill = 0;
$min_hill_id = 0;
$min_hill_player = 0;

$undated_score = array();
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
		
		$game->{'money_'.$player_ind} = $money_balance;
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
			$max_win_id = $game->id;
			$max_win_player = $player_id;
		}
		if ($player_score < $max_loss)
		{
			$max_loss = $player_score;
			$max_loss_id = $game->id;
			$max_loss_player = $player_id;
		}
		if ($player_hill > $max_hill)
		{
			$max_hill = $player_hill;
			$max_hill_id = $game->id;
			$max_hill_player = $player_id;
		}
		if ($player_hill < $min_hill)
		{
			$min_hill = $player_hill;
			$min_hill_id = $game->id;
			$min_hill_player = $player_id;
		}
	}
	
	// Seasons
	
	$cur_game_date = date_parse($game->date);
	$cur_game_year = $cur_game_date['year'];
  if ($cur_game_year <= 2008)
  {
    // Save score to 'undated' for games before the year 2009
    for ($player_ind = 1; $player_ind <= $game->num_players; ++$player_ind)
    {
      $player_id = $game->{'name_'.$player_ind};
      $undated_score[$player_id] += $game->{'score_'.$player_ind};
    }
    continue;
  }
	
	$season = &get_or_create_season($seasons, $cur_game_year);
	
	++$season->num_games;
	$season->total += $game->total;
	
	for ($player_ind = 1; $player_ind <= $game->num_players; ++$player_ind)
	{
		$player_id = $game->{'name_'.$player_ind};
		$season->players_score[$player_id] += $game->{'score_'.$player_ind};
    ++$season->players_num_participated_games[$player_id];
	}
}

// Sort seasons

function year_sort($a, $b)
{
	return ($b->year - $a->year);
}
usort($seasons, "year_sort");

// Assign season number

$season_number = 0;
foreach (array_reverse($seasons) as $season)
  $season->number = ++$season_number;

// Give prizes (medals)

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

// Grant personal awards
grant_personal_awards($players);


// Calculate average stats for all players

foreach ($players as &$player)
{
	$player->score_avg = round($player->score / $player->games);
	$player->hill_avg = round($player->hill / $player->games);
	$player->money_avg = round($player->money / $player->games);
	$player->balance_avg = round($player->balance / $player->games);
}

?>
