<?
require ('check.inc');
require('../connect.php');
error_reporting(0);
mysql_query('SET group_concat_max_len = 25000;');
$r=mysql_query('select concat("<flag i=\"'.$_GET['i'].'\" ncode=\"",f.ncode,"\" cvalue=\"",f.cvalue,"\" cpath=\"",f.cpath,"\" c3let=\"",f.c3let,"\"/>") from flags f left join flags_syn s on (f.ncode=s.nflag) where s.cvalue="'.$_GET['cplace'].'" order by s.id limit 1');
if (mysql_numrows($r))
{header('Content-Type: text/xml');
 header ('Cache-Control: no-cache');
 header ('Cache-Control: no-store' , false);
 echo '<?xml version="1.0" encoding="UTF-8"?>'.mysql_result($r,0);
 }
else echo '';
?>
