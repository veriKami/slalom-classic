<?
require ('check.inc');
require('../connect.php');
if ($_POST['delid']) mysql_query('delete from type_marks where id='.$_POST['delid']);
if ($_POST['add']) mysql_query('insert into type_marks (cvalue'.($_POST['nposadd']?',npos':'').') values ("'.$_POST['cvalueadd'].'"'.($_POST['nposadd']?','.$_POST['nposadd']:'').')');
if ((!$_POST['delid']) and (!$_POST['add']))
{for($i=0;$i<count($_POST['id']);$i++) mysql_query('Update type_marks Set cvalue="'.$_POST['cvalue'][$i].'"'.($_POST['npos'][$i]?',npos='.$_POST['npos'][$i]:',npos=null').' Where id='.$_POST['id'][$i]);
 }
if ($st=mysql_error()) echo $st;
 else {$lock='chlock';
       while (file_exists($lock)) usleep(100000);
       $ilf=fopen($lock,'w');
       fwrite($ilf, 1);
       fclose($ilf);
       $f=fopen('../ch.html', 'w');
       fwrite($f,time());
       fclose($f);
       unlink($lock);
       require ('genindex.php');
       header("Location: admin.php?mode=type_marks");}
?>
