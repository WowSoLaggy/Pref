<?php


function get_page_str()
{
  include('utils.php');
  
  $str = get_header_str();
  $str .= '
    <body class="menu">
      <div><img style="margin: 10px 0px 15px 0px;" src="images/menu.png"></div>
      <div><a href="home.php" target="content"><img class="menu_image" src="images/btn_menu_main.png"></a></div>
      <div><a href="players.php" target="content"><img class="menu_image" src="images/btn_menu_players.png"></a></div>
      <div><a href="games.php" target="content"><img class="menu_image" src="images/btn_menu_games.png"></a></div>
      <div><a href="seasons.php" target="content"><img class="menu_image" src="images/btn_menu_seasons.png"></a></div>
    </body></html>';

	return $str;
} // get_page_str()


//
// MAIN
//


$str = get_page_str();
echo($str);

?>
