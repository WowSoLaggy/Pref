<?php

include_once('classes.php');


function add(&$player, $award)
{
  array_push($player->personal_awards, $award);
}


function grant_personal_awards(&$players)
{
  $egorov = &$players[0];
  $degt = &$players[1];
  $kozlov = &$players[2];
  $yulya = &$players[3];
  $nik = &$players[4];
  
  // Participation in 100 in 2019 year
  
  add($egorov, '100_in_2019');
  add($degt, '100_in_2019');
  add($kozlov, '100_in_2019');
  add($yulya, '100_in_2019');
  
  // Special 'crazy' for Yulya
  
  add($yulya, 'crazy');
}


?>
