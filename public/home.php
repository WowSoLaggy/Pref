<?php


function get_page_str()
{
  include('utils.php');
  include('calculations.php');
  
  $str = get_header_str();
  $str .= '
    <body class="light"><h2>Главная страница</h2>';

  // Output Top-players
  
  $players_sorted = $players;
  function scoreSort($a, $b)
  {
    $medals_diff = $b->medals_score - $a->medals_score;
    if ($medals_diff != 0)
      return $medals_diff;
    $score_diff = $b->score - $a->score;
    return $score_diff;
  }
  usort($players_sorted, "scoreSort");

  // Header
  $str .= '
    <div id="block_top"><h3>Топ игроков</h3><table border="1"><td>
    <th>Имя</th><th>Игры</th><th>Общий счёт</th><th>Медали</th></td>';
  
  for ($player_ind = 0; $player_ind < $num_players; ++$player_ind)
  {
    $str .= '
      <tr>
      <td width=20 align=center>'.($player_ind + 1).'</td>
      <td width=160>'.
      draw_player_name_extended_str($players_sorted[$player_ind]).
      '</td>
      <td width=50 align=center>'.$players_sorted[$player_ind]->games.'</td>
      <td width=100 align=center><b><font size="+1">'.
      round($players_sorted[$player_ind]->score).'</font></b></td>';
    
    // Medals
    $str .= '<td width=160 align=center>';
    draw_medals_to_str($str, $players_sorted[$player_ind]);
    
    $str .= '</td></tr>';
  }

  $str .= '</table></div>';
  
  // Output stat
  
  $str .= '
    <div id="block_stat"><h3>Общая статистика</h3><table border="0">
    <tr><td width=220 align=left>Всего сыграно игр:</td><td>'.$num_games.'</td></tr>
    <tr><td>Общая длина всех пуль:</td><td>'.$total.'</td></tr>
    <tr><td>Всего участвовало игроков:</td><td>'.$num_players.'</td></tr>
    <tr><td>Наибольшая победа:</td><td><a class="anchor_link" href="games.php#anchor_game_'.
    $max_win_id.'">'.round($max_win).' ('.$players[$max_win_player]->name.')</a></td></tr>
    <tr><td>Наибольший проигрыш:</td><td><a class="anchor_link" href="games.php#anchor_game_'.
    $max_loss_id.'">'.round($max_loss).' ('.$players[$max_loss_player]->name.')</a></td></tr>
    <tr><td>Наибольшая гора:</td><td><a class="anchor_link" href="games.php#anchor_game_'.
    $max_hill_id.'">'.$max_hill.' ('.$players[$max_hill_player]->name.')</a></td></tr>
    <tr><td>Наименьшая гора:</td><td><a class="anchor_link" href="games.php#anchor_game_'.
    $min_hill_id.'">'.$min_hill.' ('.$players[$min_hill_player]->name.')</a></td></tr>
    </table></div>';

  $str .= '</body></html>';    
	return $str;
} // get_page_str()


//
// MAIN
//


$str = get_page_str();
echo($str);

?>
