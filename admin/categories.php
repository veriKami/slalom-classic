<?
require ('check.inc');
require('../connect.php');
if ($_POST['delid']) {mysql_query('delete from categories where id='.$_POST['delid']); mysql_query('update skaters set ncategory=NULL where ncategory='.$_POST['delid']);}
if ($_POST['add']) mysql_query('insert into categories (cvalue'.($_POST['nposadd']?',npos':'').''.($_POST['ngroupadd']?',ngroup':'').') values ("'.$_POST['cvalueadd'].'"'.($_POST['nposadd']?','.$_POST['nposadd']:'').($_POST['ngroupadd']?','.$_POST['ngroupadd']:'').')');
if ((!$_POST['delid']) and (!$_POST['add']))
{for($i=0;$i<count($_POST['id']);$i++) mysql_query('Update categories Set cvalue="'.$_POST['cvalue'][$i].'"'.($_POST['npos'][$i]?',npos='.$_POST['npos'][$i]:',npos=null').($_POST['ngroup'][$i]?',ngroup='.$_POST['ngroup'][$i]:',ngroup=null').' Where id='.$_POST['id'][$i]);
 }
if ($st=mysql_error()) echo $st;
 else { require ('genindex.php');
	header("Location: admin.php?mode=categories");}
?>
