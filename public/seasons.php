<?php


function get_page_str()
{
	function draw_season(&$str, &$season, $draw_medals, &$players)
	{
		$str .= "<hr><h3>Сезон ".$season->number." (".$season->year.")</h3>";

		// Players

		$str .= "<table border=0><tr>";
		$str .= '<td valign=top width=500><h4>Топ игроков</h4><table border="1">';
		$str .= '<td><th>Имя</th><th>Счёт</th></td>';

		$keys = array_keys($season->players_score);
		$place = 1;
		foreach ($keys as $key)
		{
			$str .= "<tr>";
			$str .= "<td width=50 align=center>";
			if ($draw_medals)
			{
				if ($place == 1)
					$str .= "<img src='images/medal_gold.png' width=15>";
				else if ($place == 2)
					$str .= "<img src='images/medal_silver.png' width=15>";
				else if ($place == 3)
					$str .= "<img src='images/medal_bronze.png' width=15>";
				else
					$str .= $place;
			}
			else
				$str .= $place;

			$str .= "</td>";
			$str .= 
				"<td width=160><img src='images/".$players[$key]->image.
				"' align=absmiddle hspace=10 vspace=10 width=50>".$players[$key]->name.
				"</td>";
			$str .= "<td width=60 align=center><b><font size='+1'>".round($season->players_score[$key])."</font></b></td>";
			$str .= "</tr>";

			++$place;
		}

		$str .= '</table></td>';

		// Stats

		$str .= '<td valign=top><h4>Статистика сезона</h4><table border="0">';

		$str .= '<tr><td width=220 align=left>Cыграно игр:</td><td>'.$season->num_games.'</td></tr>';
		$str .= '<tr><td>Длина всех пуль:</td><td>'.$season->total.'</td></tr>';

		$str .= '</table></td></tr></table><br>';
	} // draw_season()

	
	include('utils.php');
	include('calculations.php');


	$str = get_header_str();
  $str .= '<body class="light">';
  $str .= '<h2>Сезоны</h2>';
  
  // Seasons' statistics graph

  $rseasons = array_reverse($seasons);
  $str .= '<h4>Количество игр по сезонам</h4>';
  $str .= '<canvas id="canvas_chart"></canvas>';
  $str .= '<script>';
  $str .= 'var seasons_labels=[]; var seasons_data=[];';
  foreach ($rseasons as &$season)
  {
    $str .= 'seasons_labels.push("'.$season->year.'");';
    $str .= 'seasons_data.push("'.$season->num_games.'");';
  }
  $str .= '</script>';
  $str .= '<script src="seasons.js"></script>';

  // Output seasons

	$current_year = date("Y");
	
	foreach ($seasons as &$season)
		draw_season($str, $season, $season->year != $current_year, $players);

	$str .=	'</body></html>';

	return $str;
} // get_page_str()


//
// MAIN
//


$str = get_page_str();
echo($str);

?>
