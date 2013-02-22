<?
require ('check.inc');
require('../connect.php');
$r=mysql_query('select concat_ws("","<skater npenalty=\"",npenalty,"\" ttime=\"",ttime,"\" ttimeb=\"",ttimeb,"\" eop=\"",date_add(coalesce(ttimeb,now()),interval coalesce(ttimel,100) second)<now(),"\"/>")  from skaters where id='.$_GET['id']);
//$p=mysql_result($r,0);
if (mysql_numrows($r))
{header('Content-Type: text/xml');
 header ('Cache-Control: no-cache');
 header ('Cache-Control: no-store' , false);
 echo '<?xml version="1.0" encoding="UTF-8"?>'.mysql_result($r,0);
 }
else echo '';

?>
