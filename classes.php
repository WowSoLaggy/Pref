<?php


const MIN_VALUE = -999999;
const MAX_VALUE = 999999;

const VALUE_GOLD = 10000;
const VALUE_SILVER = 100;
const VALUE_BRONZE = 1;


class Player
{
	public $id = 0;
	public $name = "";
	public $image = "";
	
	public $games = 0;
	public $wins = 0;
	
	public $total = 0;
	
	public $medals_gold = 0;
	public $medals_silver = 0;
	public $medals_bronze = 0;
	public $medals_score = 0;
	
	public $score = 0;
	public $score_min = MAX_VALUE;
	public $score_avg = 0;
	public $score_max = MIN_VALUE;
	
	public $hill = 0;
	public $hill_min = MAX_VALUE;
	public $hill_avg = 0;
	public $hill_max = MIN_VALUE;
	
	public $money = 0;
	public $money_min = MAX_VALUE;
	public $money_avg = 0;
	public $money_max = MIN_VALUE;
	
	public $balance = 0;
	public $balance_min = MAX_VALUE;
	public $balance_avg = 0;
	public $balance_max = MIN_VALUE;
}


class Game
{
	public $id = 0;
	public $total = 0;
	public $num_players = 3;
	public $date = '2008-12-31';
	
	public $name_1 = 0;
	public $name_2 = 0;
	public $name_3 = 0;
	public $name_4 = 0;
	
	public $hill_1 = 0;
	public $hill_2 = 0;
	public $hill_3 = 0;
	public $hill_4 = 0;
	
	public $money_1_2 = 0;
	public $money_1_3 = 0;
	public $money_1_4 = 0;
	
	public $money_2_2 = 0;
	public $money_2_3 = 0;
	public $money_2_4 = 0;
	
	public $money_3_1 = 0;
	public $money_3_2 = 0;
	public $money_3_4 = 0;
	
	public $money_4_1 = 0;
	public $money_4_2 = 0;
	public $money_4_3 = 0;
}


class Season
{
	public $year = 2008;
	
	public $num_games = 0;
	public $total = 0;
	
	public $players_score = array();
}


?>
