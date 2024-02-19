<?php


function get_page_str()
{
  // Calculate players and games

  include('utils.php');
	include('calculations.php');

  // Header

	$str = get_header_str();
  $str .= '<body class="light">';
  $str .= '<h2>Статистика игроков</h2>';

  // players stats graph

  $str .= '<h4>Общий счёт</h4>';

  $rseasons = array_reverse($seasons);
  $str .= '<canvas id="canvas_chart"></canvas>';
  $str .= '<script>';
  $str .= 'var seasons_labels=["до н.э."]; var seasons_data=[]; var seasons_players=[];';

  // Init data arrays
  $score_sum = array();
  for ($player_ind = 0; $player_ind < $num_players; $player_ind++)
  {
    // Initialize array of sesons' results for player
    $str .= 'seasons_data['.$player_ind.']=[];';
    
    // Add undated score as the initial value
    if (!isset($score_sum[$player_ind]))
      $score_sum[$player_ind] = 0;
    if (!isset($undated_score[$player_ind]))
      $undated_score[$player_ind] = 0;
    
    $score_sum[$player_ind] += $undated_score[$player_ind];
    $str .= 'seasons_data['.$player_ind.'].push('.round($score_sum[$player_ind]).');';

    $str .= 'seasons_players['.$player_ind.']="'.$players[$player_ind]->name.'";';
  }

  // Fill chart
  foreach ($rseasons as &$season)
  {
    // Label
    $str .= 'seasons_labels.push("'.$season->year.'");';

    // Score
    for ($player_ind = 0; $player_ind < $num_players; $player_ind++)
    {
      if (!isset($score_sum[$player_ind]))
        $score_sum[$player_ind] = 0;
      if (!isset($season->players_score[$player_ind]))
        $season->players_score[$player_ind] = 0;
      
      $score_sum[$player_ind] += $season->players_score[$player_ind];
      $str .= 'seasons_data['.$player_ind.'].push("'.round($score_sum[$player_ind]).'");';
    }
  }
  $str .= '</script>';
  $str .= '<script src="players.js"></script>';
		
  // Output players

  $str .= '<h4>Подробная статистика</h4>';
  $str .= '<table border="1"><td><th>Имя</th><th>Общий счёт<br>'.
    '(мин/ср/макс)</th><th>Игры<br>(Сумма пуль)</th>'.
    '<th>Участие/<br>Победы</th><th>Общая гора<br>'.
    '(мин/ср/макс)</th><th>Баланс вистов<br>(мин/ср/макс)'.
    '</th><th>Всего вистов<br>(мин/ср/макс)</th><th>Медали</th></td>';
  
  for ($player_ind = 0; $player_ind < $num_players; $player_ind++)
  {
    $str .= "<tr><td width=20 align=center>".($player_ind + 1)."</td>";
    $str .= 
        "<td width=160>".
        draw_player_name_extended_str($players[$player_ind]).
        "</td>";
    $str .=
        "<td width=110 align=center><b><font size='+1'>".round($players[$player_ind]->score)."</font></b><br>(".
        round($players[$player_ind]->score_min)."/".round($players[$player_ind]->score_avg)."/".round($players[$player_ind]->score_max).
        ")</td>";
    $str .=
        "<td width=110 align=center>".$players[$player_ind]->games."<br>(".$players[$player_ind]->total.
        ")</td>";
    $str .=
        "<td width=75 align=center>".round($players[$player_ind]->games / $num_games * 100)."%/".
        round($players[$player_ind]->wins / $players[$player_ind]->games * 100).
        "%</td>";
    $str .=
        "<td width=120 align=center>".$players[$player_ind]->hill."<br>(".
        $players[$player_ind]->hill_min."/".round($players[$player_ind]->hill_avg)."/".$players[$player_ind]->hill_max.
        ")</td>";
    $str .=
        "<td width=120 align=center>".$players[$player_ind]->balance."<br>(".
        $players[$player_ind]->balance_min."/".round($players[$player_ind]->balance_avg)."/".$players[$player_ind]->balance_max.
        ")</td>";
    $str .=
        "<td width=120 align=center>".$players[$player_ind]->money."<br>(".
        $players[$player_ind]->money_min."/".round($players[$player_ind]->money_avg)."/".$players[$player_ind]->money_max.
        ")</td>";
    
    // Medals
    $str .= "<td width=160 align=center>";
    
    draw_medals_to_str($str, $players[$player_ind]);
    
    $str .= "</td>";
    
    $str .= "</tr>";
  }
  $str .= '</table>';
  
  $str .= '<br>Пояснения:<br>
    <ol>
      <li>Победой считается игра, где окончательный счёт игрока больше нуля.</li>
      <li>Общая гора - сумма по горе за все игры БЕЗ списания в конце игры.</li>
      <li>Баланс вистов - общая сумма всех вистов, написанных игроком на всех остальных, и ответных вистов, написанных на игрока.</li>
      <li>Всего вистов - сумма всех вистов, написанных игроком на всех остальных игроков за все игры. Не включает в себя ответные висты на игрока.</li>
      <li>Поле "Участие/Победы" (например "95%/61%") следует читать так: участвовал в 95 процентах игр, из них выиграл 61 процент игр.</li>
      <li>Козлов - жмот.</li>
    </ol>';
		
	$str .=	'</body></html>';

  return $str;
} // get_page_str()


//
// MAIN
//


$str = get_page_str();
echo($str);

?>
