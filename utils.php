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

?>
