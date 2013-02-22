<b><a class=txt>Manual Correction</a></b><br>

<?php //:
////////:

if ($_GET['skid']){
  $r = mysql_query('select s.id,s.nnumber,s.cname,s.cname_local,s.dbday,s.cplace,s.norder,s.npenalty,CONCAT("Judge ",j.nnumber) from skaters s, judges j where j.npenalty=1 and s.id='.$_GET['skid']);
  
  if ($st=mysql_error()) echo $st;
  if ($a=mysql_fetch_row($r)) {
    echo '<form name=correct method=post action=correct.php enctype=multipart/form-data>Skater: '.$a[6].'. '.($a[1]?$a[1].'. ':'').$a[2].($a[3]?' ('.$a[3].')':'').($a[5]?' ('.$a[5].')':'').'<br>'.$a[8].'<input type=hidden name=skid value='.$_GET['skid'].'><br>Penalty: <input type=text class=txt name=npenalty value='.$a[7].' required pattern="\d+(\.\d{0,})?" oninput="if (isNaN(this.value)) this.setCustomValidity(\'Invalid number format\'); else this.setCustomValidity(\'\');" data-errormessage="Invalid number format" x-moz-errormessage="Invalid number format"><input type=submit name=subbut class=txt value=" Save "></form>
<script type="text/javascript">
  document.correct.npenalty.focus();
</script>';
  }

} else if ($_GET['mid']){

  $r = mysql_query('select s.id,s.nnumber,s.cname,s.cname_local,s.dbday,s.cplace,s.norder,s.npenalty,CONCAT("Judge ",j.nnumber),m.nvalue,tm.cvalue
		  from skaters s, judges j, marks m, type_marks tm
		  where m.njudge=j.id and m.nskater=s.id and m.ntype=tm.id and m.id='.$_GET['mid']);
 
 if ($st=mysql_error()) echo $st;
 if ($a=mysql_fetch_row($r)){
  echo '<form name=correct method=post action=correct.php enctype=multipart/form-data>Skater: '.$a[6].'. '.($a[1]?$a[1].'. ':'').$a[2].($a[3]?' ('.$a[3].')':'').($a[5]?' ('.$a[5].')':'').'<br>'.$a[8].'<input type=hidden name=mid value='.$_GET['mid'].'><br>'.$a[10].': <input type=text class=txt name=nvalue value='.$a[9].' required pattern="\d+(\.\d{0,})?" oninput="if (isNaN(this.value)) this.setCustomValidity(\'Invalid number format\'); else this.setCustomValidity(\'\');" data-errormessage="Invalid number format" x-moz-errormessage="Invalid number format"><input type=submit name=subbut class=txt value=" Save "></form>
<script type="text/javascript">
  document.correct.nvalue.focus();  
</script>';
   }

} else {

 $r   = mysql_query('Select count(id) From skaters ');
 $a   = mysql_fetch_row($r);
 $ns  = $a[0];
 $r   = mysql_query('Select cvalue From type_marks order by npos,id');
 $ntm = mysql_numrows($r); $stm='';
 
 while($a=mysql_fetch_row($r)) $stm.='<th>'.$a[0];
 
 $r  = mysql_query('Select CONCAT("Judge ",nnumber," (",cname,")") From judges where npenalty=0 order by nnumber,id');
 $nj = mysql_numrows($r); $sj='';
 
 while($a=mysql_fetch_row($r)) $sj.='<th colspan='.$ntm.'>'.$a[0];
 
 $r = mysql_query('select s.id,s.nnumber,s.cname,s.cname_local,s.dbday,s.cplace,s.norder,s.npenalty,m.nvalue,m.id
	        from skaters s left join categories c on (s.ncategory=c.id) inner join judges j inner join type_marks tm left join marks m on (m.njudge=j.id and m.nskater=s.id and m.ntype=tm.id)
		where j.npenalty=0
	        order by c.npos,s.norder,s.id,j.nnumber,tm.npos,tm.id');
 
 if ($st=mysql_error()) echo $st;
 
 $n = mysql_numrows($r);
 echo '<table border=1 class=txt cellspacing=0 cellpadding=2><tr><th rowspan=2>#<th rowspan=2>Skater<th rowspan=2>Penalty'.$sj.'<th rowspan=2>Operation<tr>';
 
 for ($j=0;$j<$nj;$j++) echo $stm;
 
 $a = mysql_fetch_row($r);

 while($a){
  echo '<tr><td>'.$a[6].'<td>'.($a[1]?$a[1].'. ':'').$a[2].($a[3]?' ('.$a[3].')':'').($a[5]?' ('.$a[5].')':'').'<td align=center>';
  $st='<td><input type=button class=txt value=" Clear results " onclick="window.open(\'correct.php?deli='.$a[0].'\',\'_self\');"></td>';
  if (isset($a[7])) echo '<a href=admin.php?mode=correction&skid='.$a[0].'>'.$a[7].'</a>';
  for ($i=0;$i<$nj;$i++){
    for ($j=0;$j<$ntm;$j++){
      echo '<td align=center>';
      if (isset($a[8])) echo '<a href=admin.php?mode=correction&mid='.$a[9].'>'.$a[8].'</a>';
      $a = mysql_fetch_row($r);
    }
   }
  echo $st;
  }
 echo '</table><br><input type=button value=" Clear all results " onclick="window.open(\'correct.php?del=1\',\'_self\');">';
 }
 
////////: ?>
