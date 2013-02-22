<?php //:
////////:

require('check.inc');
require('../connect.php');

/**
 * Function
 */
function cp1251_to_utf8($s){ 
  if ((strtolower(mb_detect_encoding($s,'UTF-8,CP1251'))) == "windows-1251") { 
    $c209 = chr(209);
    $c208 = chr(208);
    $c129 = chr(129); 
    for($i=0; $i<strlen($s); $i++) 
      { 
      $c=ord($s[$i]); 
      if ($c>=192 and $c<=239) $t.=$c208.chr($c-48); 
      elseif ($c>239) $t.=$c209.chr($c-112); 
      elseif ($c==184) $t.=$c209.$c209; 
      elseif ($c==168)    $t.=$c208.$c129; 
      else $t.=$s[$i]; 
      } 
    return $t; 
    } 
  else 
    { 
    return $s; 
    } 
   }

//print_r($_FILES['csvfile']);

/**
 * Function
 */
function qr($st) {
  if (trim($st,'"'))
  if ((strtolower(mb_detect_encoding($st,'UTF-8,CP1251'))) == "windows-1251") return '"'.mysql_real_escape_string(trim(iconv('CP1251','UTF-8//TRANSLIT//IGNORE',trim($st,'"')))).'"';
  elseif ((strtolower(mb_detect_encoding($st,'UTF-8,CP1251'))) == "utf-8") return '"'.mysql_real_escape_string(trim($st,'"')).'"';
      else return 'NULL';
 else return 'NULL';
 }

/**
 * Function
 */
function qt($st) {
  $st=trim($st,'"'); 
  if ($st) return '"'.$st.'"'; 
  else return 'NULL';
}

/**
 * Function
 */
function qc($st) {
  $st=trim($st,'"');
  if ($st) return 'coalesce((select ncode from flags where lower(cvalue)=lower("'.$st.'") or lower(c3let)=lower("'.$st.'") or lower(c2let)=lower("'.$st.'") limit 1),(select nflag from flags_syn where cvalue="'.$st.'" order by id desc limit 1))'; 
  else return 'NULL';
}

/**
 * Function
 */
function qd($st) {
  if (trim($st,'"')) return 'str_to_date("'.trim($st,'"').'", "%d.%m.%Y")'; 
  else return 'NULL';
}

/**
 * Function
 */
function parsecsv($st, $d=';', $enc='"', $esc='\\'){
  $n=strlen($st); $sta=''; $k=0;
  if ($st[0]==$enc) $state=1;
  else $state=0;
  for($i=0;$i<$n;$i++)
  {//echo $st[$i];
  if ($state==0)
   if($st[$i]==$d) {$data[$k++]=$sta; $sta=''; if ($st[$i+1]==$enc) {$state=1; $i++;}}
    else if ($st[$i]==$esc) {if ($st[$i+1]==$d) {$sta.=$d; $i++;} else $sta.=$esc;}
     else $sta.=$st[$i];
  else if ($state==1)
   if ($st[$i]==$enc) {$data[$k++]=$sta; $sta=''; $state=2;}
    else if ($st[$i]==$esc) {if ($st[$i+1]==$enc) {$sta.=$enc; $i++;} else $sta.=$esc;}
     else $sta.=$st[$i];
   else if ($state==2) if($st[$i]==$d) {$state=0;}
  }
 if (($sta!="\n")and($st[$i-1]!=$d)and(($state==0)or($state==2))) $data[$k++]=substr($sta,0,-1);
 return $data;
 }


if ($_FILES['csvfile']['name']){
  ini_set('auto_detect_line_endings',TRUE);
   if ($handle = fopen($_FILES['csvfile']['tmp_name'], 'r')){
   while ($stc = fgets($handle))//($data = fgetcsv($handle, 1000, ';'))
   {
   $data=parsecsv($stc);//explode(';',$st);
   if (count($data))
   //{print_r($data);echo '<br>';}
   //echo 'insert into skaters (cname,dbday,cplace,nrat,nnumber,nflag,cteam) values ('.qr($data[0]).','.qd($data[1]).','.qr($data[2]).','.qt($data[3]).','.qr($data[4]).','.qc($data[5]).','.qr($data[6]).')<br>';
   mysql_query('insert into skaters (cname,dbday,cplace,nrat,nnumber,nflag,cteam) values ('.qr($data[0]).','.qd($data[1]).','.qr($data[2]).','.qt($data[3]).','.qr($data[4]).','.qc($data[5]).','.qr($data[6]).')');
   if ($st=mysql_error()) echo '<br>'.$st;
   }
  }
 fclose($handle);
 unlink($_FILES['csvfile']['tmp_name']);
 }

if ($_POST['delid']) {mysql_query('delete from marks where nskater='.$_POST['delid']); mysql_query('delete from skaters where id='.$_POST['delid']);}

if ($_POST['add']){
  $qv='cname';
  $qd='"'.$_POST['cnameadd'].'"';
 if ($_POST['cname_localadd']) {$qv.=',cname_local'; $qd.=',"'.$_POST['cname_localadd'].'"';}
 if ($_POST['cplaceadd']) {$qv.=',cplace'; $qd.=',"'.$_POST['cplaceadd'].'"';}
 if ($_POST['cteamadd']) {$qv.=',cteam'; $qd.=',"'.$_POST['cteamadd'].'"';}
 if ($_POST['dbdayadd']) {$qv.=',dbday'; $qd.=',str_to_date("'.$_POST['dbdayadd'].'", "%d.%m.%Y")';}
 if ($_POST['nnumberadd']) {$qv.=',nnumber'; $qd.=',"'.$_POST['nnumberadd'].'"';}
 if ($_POST['norderadd']) {$qv.=',norder'; $qd.=','.$_POST['norderadd'];}
 if ($_POST['nratadd']) {$qv.=',nrat'; $qd.=','.$_POST['nratadd'];}
 if ($_POST['ncatadd']) {$qv.=',ncategory'; $qd.=','.$_POST['ncatadd'];}
 if ($_POST['nflagadd']) {$qv.=',nflag'; $qd.=','.$_POST['nflagadd']; if ($_POST['cplaceadd']) mysql_query('insert into flags_syn (nflag,cvalue) values ('.$_POST['nflagadd'].',"'.$_POST['cplaceadd'].'") ON DUPLICATE KEY UPDATE nflag="'.$_POST['nflagadd'].'"');}
 mysql_query('insert into skaters ('.$qv.') values ('.$qd.')');
 }

if ((!$_POST['delid']) and (!$_POST['add']) and (!$_FILES["csvfile"]["name"])){
  for($i=0;$i<count($_POST['id']);$i++)
  if ($_POST['eid'][$i])
  {
  $q=$_POST['cname'][$i].'"';
  if ($_POST['cname_local'][$i]) {$q.=',cname_local="'.$_POST['cname_local'][$i].'"';} else {$q.=',cname_local=NULL';}
  if ($_POST['cplace'][$i]) {$q.=',cplace="'.$_POST['cplace'][$i].'"';} else {$q.=',cplace=NULL';}
  if ($_POST['cteam'][$i]) {$q.=',cteam="'.$_POST['cteam'][$i].'"';} else {$q.=',cteam=NULL';}
  if ($_POST['dbday'][$i]) {$q.=',dbday=str_to_date("'.$_POST['dbday'][$i].'", "%d.%m.%Y")';} else {$q.=',dbday=NULL';}
  if ($_POST['nnumber'][$i]) {$q.=',nnumber="'.$_POST['nnumber'][$i].'"';} else {$q.=',nnumber=NULL';}
  if ($_POST['norder'][$i]) {$q.=',norder='.$_POST['norder'][$i];} else {$q.=',norder=NULL';}
  if ($_POST['nrat'][$i]) {$q.=',nrat='.$_POST['nrat'][$i];} else {$q.=',nrat=NULL';}
  if ($_POST['ncat'][$i]) {$q.=',ncategory='.$_POST['ncat'][$i];} else {$q.=',ncategory=NULL';}
  if ($_POST['ngroup'][$i]) {$q.=',ngroup='.$_POST['ngroup'][$i];} else {$q.=',ngroup=NULL';}
  if ($_POST['nflag'][$i]) {$q.=',nflag='.$_POST['nflag'][$i]; if ($_POST['cplace'][$i]) mysql_query('insert into flags_syn (nflag,cvalue) values ('.$_POST['nflag'][$i].',"'.$_POST['cplace'][$i].'") ON DUPLICATE KEY UPDATE nflag='.$_POST['nflag'][$i]);} else {$q.=',nflag=NULL';}
  mysql_query('Update skaters Set cname="'.$q.' Where id='.$_POST['id'][$i]);  
  }
 }

if ($st=mysql_error()) {
  echo $st;
} else {
  require ('genindex.php');
  header('Location: admin.php?mode=skaters'.($_POST['ncato']!=''?'&ncat='.$_POST['ncato']:'').($_POST['sort']?'&sort='.$_POST['sort']:''));
}

?>
