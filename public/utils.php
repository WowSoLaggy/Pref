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


function get_month_str($month)
{
	switch ($month)
	{
		case 1: return "янв";
		case 2: return "фев";
		case 3: return "мар";
		case 4: return "апр";
		case 5: return "май";
		case 6: return "июн";
		case 7: return "июл";
		case 8: return "авг";
		case 9: return "сен";
		case 10: return "окт";
		case 11: return "ноя";
		case 12: return "дек";
	}
	
	throw new Exception("Can't parse month index: ".$month.".");
}

function get_header_str()
{
  $str = '
    <html><head><title>Клуб "Паровоз Козлова"</title>
    <meta charset="utf-8"/>
    <link rel="icon" href="favicon.ico" type="image/ico"/>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="./../libs/Chart.js"></script>

    <!-- Yandex.Metrika counter -->
    <script type="text/javascript" >
      (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
      m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
      (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

      ym(62412520, "init", {
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true
      });
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/62412520" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->

    </head>';
	return $str;
}

?>
