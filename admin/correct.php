<?
require ('check.inc');
require('../connect.php');
if ($_GET['del']==1) {mysql_query('Delete from marks;');mysql_query('Update skaters Set npenalty=NULL,ttime=NULL,ttimeb=NULL;');}
else
{if ($_GET['deli'])
 {mysql_query('Delete from marks where nskater='.$_GET['deli']);mysql_query('Update skaters Set npenalty=NULL,ttime=NULL,ttimeb=NULL where id='.$_GET['deli']);}
 else if ($_POST['skid']) mysql_query('Update skaters Set npenalty="'.$_POST['npenalty'].'" Where id='.$_POST['skid']);
  else if ($_POST['mid']) mysql_query('Update marks Set nvalue="'.$_POST['nvalue'].'" Where id='.$_POST['mid']);
 
 }
if ($st=mysql_error()) echo $st;
 else { require ('genindex.php');
	header("Location: admin.php?mode=correction");}
?>
