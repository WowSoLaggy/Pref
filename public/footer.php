<?php


function get_page_str()
{
  include('utils.php');
  
  $str = get_header_str();
  $str .= '
    <body class="dark">
      <div align=right>WowSoLaggy, 2016-'.date("Y").' (c)</div>
    </body></html>';
	return $str;
} // get_page_str()


//
// MAIN
//


$str = get_page_str();
echo($str);

?>
