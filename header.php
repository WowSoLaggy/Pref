<?php


function get_page_str()
{
  include('utils.php');
  
  $str = get_header_str();
  $str .= '
    <body class="dark">
      <div id="logo_block"><img id="logo" src="images/kand.png"></div>
      <div id="logo_title"><img src="images/title.png"></div>
    </body></html>';
	return $str;
} // get_page_str()


//
// MAIN
//


$str = get_page_str();
echo($str);

?>
