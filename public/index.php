<?php


function get_page_str()
{
  include('utils.php');
  
  $str = get_header_str();
  $str .= '
    <frameset rows="100, *, 30" border="0" frameborder="0">
      <frame src="header.php" name="top" scrolling="no" noresize>
      <frameset cols="190, *">
        <frame src="menu.php" name="menu" scrolling="no" noresize>
        <frame src="home.php" name="content" scrolling="auto" noresize>
      </frameset>
      <frame src="footer.php" name="footer" scrolling="no" noresize>
    </frameset></html>';
	return $str;
} // get_page_str()


//
// MAIN
//


$str = get_page_str();
echo($str);

?>
