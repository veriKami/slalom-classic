<?php //:
////////:

require('check.inc');
require('../connect.php');

if ($_POST['delid']) {
  mysql_query('delete from mark where njudge='.$_POST['delid']);
  mysql_query('delete from judges where id='.$_POST['delid']);
}

if ($_POST['add']){
  $qv = 'cname,nnumber,cpass';
  $qd = '"'.$_POST['cnameadd'].'",'.$_POST['nnumberadd'].',"'.$_POST['cpassadd'].'"';
  if ($_POST['cname_localadd']) {
    $qv .= ',cname_local'; 
    $qd .= ',"'.$_POST['cname_localadd'].'"';
  }
  mysql_query('insert into judges ('.$qv.') values ('.$qd.')');
}

if ((!$_POST['delid']) and (!$_POST['add'])){
  for($i=0;$i<count($_POST['id']);$i++){
    $q = '';
    if ($_POST['cname_local'][$i]) {
      $q.=',cname_local="'.$_POST['cname_local'][$i].'"';
    }
    mysql_query('Update judges Set cname="'.$_POST['cname'][$i].'",nnumber='.$_POST['nnumber'][$i].',cpass="'.$_POST['cpass'][$i].'",npenalty='.($_POST['npenalty']==$i?'1':'0').' Where id='.$_POST['id'][$i]);  
  }
 }

if ($st=mysql_error()){
  echo $st;
} else {
  $lock='chlock';
  while (file_exists($lock)) usleep(100000);
  
  $ilf = fopen($lock,'w');
  fwrite($ilf, 1);
  fclose($ilf);
  
  $f = fopen('../ch.html', 'w');
  fwrite($f,time());
  fclose($f);
  unlink($lock);
  
  require ('genindex.php');
  header('Location: admin.php?mode=judges');
}

?>
