<?
require ('check.inc');
require('../connect.php');

if ($_SESSION['np']) {mysql_query('Update skaters Set npenalty='.$_POST['mark'][0].',ttime=NOW() Where id='.$_POST['skid']);$p=2;}
else for($i=0;$i<count($_POST['mark']);$i++)
{mysql_query('insert into marks (njudge,ntype,nskater,nvalue) values ('.$_SESSION['id'].','.$_POST['ntype'][$i].','.$_POST['skid'].',"'.$_POST['mark'][$i].'")');
 $r=mysql_query('select count(id) from skaters where id='.$_POST['skid'].' and ttime is not null');
 $p=mysql_result($r,0);
 }
$r=mysql_query('select count(id),(select count(id) from judges where npenalty=0)*(select count(id) from type_marks) from marks where nskater='.$_POST['skid']);
$m=mysql_fetch_row($r);
if ($st=mysql_error()) echo $st;
 else { if (($p)and($m[0])and($m[0]==$m[1])) require ('../admin/genindex.php');
        //else if ($p==2) require ('../admin/genindext.php');
	header('Location: judge.php#c'.$_POST['c']);}
?>
