<?php


const NO_YEAR = 0; // This year shall never happen o.O




function get_page_str()
{
  function start_new_year(&$str, $year)
  {
    $str .= "<div class='block_year'><h3><a class='anchor' name='anchor_".$year."'>".$year." год</a></h3><br>";
    $str .= '
      <table border="1"><td>
      <th width=60>Пуля</th>
      <th width=170>Игрок 1</th><th width=170>Игрок 2</th>
      <th width=170>Игрок 3</th><th width=170>Игрок 4</th>
      <th width=100>Дата</th></td>';
  }
  
  function finish_year(&$str)
  {
    $str .= '</table><br></div>';
  }
  
  function add_game(&$str, &$game, $ind_to_show, &$players)
  {
    $str .= '<tr valign=center>';
    
    $str .= '
      <td width=30 align=center>
      <a class="anchor" name="anchor_game_'.$game->id.'">
      <div class="game_index_label">'.$ind_to_show.'</div></a></td>';
    
    $str .= '<td align=center>'.$game->total.'</td>';
    
    for ($player_ind = 1; $player_ind <= $game->num_players; ++$player_ind)
    {
      $player_score = $game->{'score_'.$player_ind};
      $player_hill = $game->{'hill_'.$player_ind};
      $player_money = $game->{'money_'.$player_ind};
      $player_id = $game->{'name_'.$player_ind};
      $player_image = $players[$player_id]->image;

      $str .= '<td ';
      
      if ($player_score > 0)
        $str .= 'bgcolor=#5b9618';
      else if ($player_score < 0)
        $str .= 'bgcolor=#9E7A17';

      $str .= '
        ><img src="images/'.$player_image.
        '" align=left hspace=10 vspace=10 width=50><p>
        <b>Счёт: '.round($player_score).'</b><br>
        <small>Гора: '.$player_hill.'<br>Висты: '.$player_money.'</small>
        </p></td>';
    }
    if ($game->num_players < 4)
      $str .= '<td/>';
    
    $game_date = date_parse($game->date);
    $month_str = get_month_str($game_date['month']);
    $str .= '
      <td align=center>'.$game_date['day'].
      ' '.$month_str." ".$game_date['year'].'</td>';
    
    $str .= '</tr>';
  }

  // Calculate players and games

  include('utils.php');
  include('calculations.php');

  // Page header
  
  $str = get_header_str();
  $str .= '<body class="light">';

  // Title
  
  $str .= '<div id="block_games_title"><h2>Список игр</h2></div>';
  
  // Years links
  
  $first_game_ind = 0;
  $last_game_ind = $num_games - 1;
  
  $first_game_date = date_parse($games[$first_game_ind]->date);
  $last_game_date = date_parse($games[$last_game_ind]->date);
  
  $first_game_year = $first_game_date['year'];
  $last_game_year = $last_game_date['year'];
  
  $str .= '<div id="block_years">[';
  for ($year = $last_game_year; $year >= $first_game_year; --$year)
    $str .= ' <a class="anchor_link" href="#anchor_'.$year.'">'.$year.'</a>';
  $str .= ' ]</div>';
  
  // Output games year-by-year in descending date order (from the newest to the oldest)
  
  $cur_year = NO_YEAR;
  for ($game_ind = $last_game_ind; $game_ind >= $first_game_ind; --$game_ind)
  {
    $cur_game = &$games[$game_ind];
    $cur_game_date = date_parse($cur_game->date);
    $cur_game_year = $cur_game_date['year'];
    
    if ($cur_game_year != $cur_year)
    {
      if ($cur_year != NO_YEAR)
        finish_year($str);
      $cur_year = $cur_game_year;
      start_new_year($str, $cur_year);
    }
    
    add_game($str, $cur_game, $game_ind + 1, $players);
  }
  if ($cur_year != NO_YEAR)
    finish_year($str);

  $str .= '</body></html>';

  return $str;
} // get_page_str()


//
// MAIN
//


$str = get_page_str();
echo($str);

?>
