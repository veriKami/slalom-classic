<?
require ('check.inc');
require('../connect.php');
if ($_SESSION['np']) {$r=mysql_query('Update skaters Set ttimeb='.($_GET['s']?'NOW(), ttimel='.$_GET['time']:'null, ttimel=null').' Where id='.$_GET['id']);}
if ($r) echo '1';
 else echo '0';

?>
