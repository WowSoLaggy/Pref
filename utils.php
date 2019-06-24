<?php

function draw_medals_to_str(&$str, &$player)
{
	$str_gold = "";
	$str_silver = "";
	$str_bronze = "";
	
	foreach ($player->medals as &$medal)
	{
		if ($medal->value == MedalValue::Gold)
			$str_gold .= "<img src='images/medal_gold.png' width=15 title='".$medal->text."'>";
		if ($medal->value == MedalValue::Silver)
			$str_silver .= "<img src='images/medal_silver.png' width=15 title='".$medal->text."'>";
		if ($medal->value == MedalValue::Bronze)
			$str_bronze .= "<img src='images/medal_bronze.png' width=15 title='".$medal->text."'>";
	}
	
	$str .= $str_gold." ".$str_silver." ".$str_bronze;
}


function get_month_str($month)
{
	switch ($month)
	{
		case 1: return "янв";
		case 2: return "фев";
		case 3: return "мар";
		case 4: return "апр";
		case 5: return "май";
		case 6: return "июн";
		case 7: return "июл";
		case 8: return "авг";
		case 9: return "сен";
		case 10: return "окт";
		case 11: return "ноя";
		case 12: return "дек";
	}
	
	throw new Exception("Can't parse month index: ".$month.".");
}

?>
