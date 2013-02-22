<?php //:
////////:

require('check.inc');
require('../connect.php');

if (!$_POST['id']) mysql_query('insert into title (cname,ntype,ngroup,cftpfile,cplace,ddate,cdiscip,ccategory,njshowpen,nflag,nnumber,nname,nname_local,nplace,nteam) values ("
'.$_POST['cname'].'",'.$_POST['ntype'].'
,'.($_POST['ngroup']?$_POST['ngroup']:'NULL').'
,'.($_POST['cftpfile']?'"'.mysql_real_escape_string($_POST['cftpfile']).'"':'NULL').'
,'.($_POST['cplace']?'"'.mysql_real_escape_string($_POST['cplace']).'"':'NULL').'
,'.($_POST['ddate']?'str_to_date("'.$_POST['ddate'].'", "%d.%m.%Y")':'NULL').'
,'.($_POST['cdiscip']?'"'.mysql_real_escape_string($_POST['cdiscip']).'"':'NULL').'
,'.($_POST['ccategory']?'"'.mysql_real_escape_string($_POST['ccategory']).'"':'NULL').'
,'.($_POST['njshowpen']?'1':'0').'
,'.($_POST['nps']?'1':'0').'
,'.($_POST['nflag']?'1':'0').'
,'.($_POST['nnumber']?'1':'0').'
,'.($_POST['nname']?'1':'0').'
,'.($_POST['nnamel']?'1':'0').'
,'.($_POST['nplace']?'1':'0').'
,'.($_POST['nteam']?'1':'0').')');

else if (!$_POST['refresh']) mysql_query('Update title Set 
cname="'.$_POST['cname'].'",ntype='.$_POST['ntype'].'
,ngroup='.($_POST['ngroup']?$_POST['ngroup']:'NULL').'
,cftpfile='.($_POST['cftpfile']?'"'.mysql_real_escape_string($_POST['cftpfile']).'"':'NULL').'
,cplace='.($_POST['cplace']?'"'.mysql_real_escape_string($_POST['cplace']).'"':'NULL').'
,ddate='.($_POST['ddate']?'str_to_date("'.$_POST['ddate'].'", "%d.%m.%Y")':'NULL').'
,cdiscip='.($_POST['cdiscip']?'"'.mysql_real_escape_string($_POST['cdiscip']).'"':'NULL').'
,ccategory='.($_POST['ccategory']?'"'.mysql_real_escape_string($_POST['ccategory']).'"':'NULL').'
,njshowpen='.($_POST['njshowpen']?'1':'0').'
,nplayendsound='.($_POST['nps']?'1':'0').'
,nflag='.($_POST['nflag']?'1':'0').'
,nnumber='.($_POST['nnumber']?'1':'0').'
,nname='.($_POST['nname']?'1':'0').'
,nname_local='.($_POST['nnamel']?'1':'0').'
,nplace='.($_POST['nplace']?'1':'0').'
,nteam='.($_POST['nteam']?'1':'0').'
 Where id='.$_POST['id']);

if ($st=mysql_error()) {
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
  header('Location: admin.php?mode=title');
}

?>
