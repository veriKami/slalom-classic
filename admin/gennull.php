<?php //:
////////:

//$rc=mysql_query('Select id,cvalue From categories Order By npos,id');
//$nct=mysql_numrows($rc);
//for($ic=0;$ic<$nct;$ic++)
{//$c=mysql_fetch_row($rc);  
///loop category

$r  = mysql_query('Select count(*) From skaters s where ncategory=0 or ncategory is null');
$ns = mysql_result($r,0);

if ($ns){
  $stfbo .= '<tr><td>No category<td><a class="white" href="indexnull.html">Link</a><td><a class="white" href="indexwnull.html">Link</a><td><a class="white" href="indextnull.html">Link</a><td><a class="white" href="indexwtnull.html">Link</a></td>';
  $stf    = $stfb;
  $strf2  = $strf2b;

  $stf     .='<table border=1 class=txt cellspacing=0 cellpadding=2><tr><th rowspan=2>#<th rowspan=2>Skater<th rowspan=2>Penalty'.$sjf.'<th rowspan=2>Total Sum<tr>';
  $sttabf2  ='<table border=1 class=txt cellspacing=0 cellpadding=2><tr>'.$sjf.'<th rowspan=2>Penalty<th rowspan=2>Place<tr>';

for ($j=0;$j<$nj;$j++) {
  $stf.=$stm.'<th>Total<th>Place';
  $sttabf2.=$stm.'<th>Mark<th>Place';
}

$stf .='<tbody id="t">';
$stff =''; $stffe=''; $stfe=$stf; $stffp='';

/*
1. Места судей
2. Общая сумма по всем судьям обеих оценок (стиль+техника-штрафы)
3. Общая сумма техники по всем судьям
4. Общая сумма штрафов (минимум)

1. Места судей
2. Общая сумма техники по всем судьям

1. Места судей
2. Сравнение мест
*/
 unset($sj); 
 $r=mysql_query('select s.cname,
			j.id,
			if(s.npenalty is not null and s.mid='.($ntm*$nj).', Sum(m.nvalue)-s.npenalty, null),
			GROUP_CONCAT(concat_ws("","<td>",ifnull(m.nvalue,"&nbsp;")) order by tm.npos,tm.id separator ""),
			s.npenalty,s.id,s.norder,
			s.nnumber, concat("<img src=\"",f.cpath,"\">",f.c3let), s.cplace, concat("(",s.cteam,")"), concat("(",s.cname_local,")")
	        from (select s.*,count(m.id) as mid from skaters s left join marks m on (m.nskater=s.id) group by s.id) s left join flags f on (s.nflag=f.ncode) inner join judges j inner join type_marks tm left join marks m on (m.njudge=j.id and m.nskater=s.id and m.ntype=tm.id)
		where (s.ncategory=0 or s.ncategory is null) and j.npenalty=0
		group by s.id,j.nnumber
	        order by j.nnumber,3 desc,s.norder,s.id');
 for ($j=0;$j<$nj;$j++){
  $k    = 0; 
  $prev = $maxc;
  $kn   = 0;
  for ($s=0;$s<$ns;$s++){
    $a=mysql_fetch_row($r);
    if ($a[2]==$prev) $kn++;
    else {$prev=$a[2]; $k+=$kn+1; $kn=0;
  }
  $sj[$a[5]][0][0]=$a[7];//($nnum?$a[7]:'');//$sj[$s][0][0]=$a[0];//number
  $sj[$a[5]][0][1]=$a[8];//($nflag?$a[8]:'');//$sj[$s][0][0]=$a[0];//flag
  $sj[$a[5]][0][2]=$a[0];//($nname?$a[0]:'');//$sj[$s][0][0]=$a[0];//name
  $sj[$a[5]][0][3]=$a[11];//($nnamel?$a[11]:'');//$sj[$s][0][0]=$a[0];//namel
  $sj[$a[5]][0][4]=$a[9];//($nplace?$a[9]:'');//$sj[$s][0][0]=$a[0];//place
  $sj[$a[5]][0][5]=$a[10];//($nteam?$a[10]:'');//$sj[$s][0][0]=$a[0];//team
  $sj[$a[5]][1][0]=isset($a[2])?$a[4]:null; //$sj[$s][1][0]=$a[4]; //penalty
  $sj[$a[5]][2][$j]=isset($a[2])?$k:$mpl;//$sj[$s][2][$j]=isset($a[2])?$k:$mpl;//judje place
  $sj[$a[5]][3][$j]=isset($a[2])?$a[2]:null;//$sj[$s][3][$j]=isset($a[2])?$a[2]:null;//judge mark
  $sj[$a[5]][4][$j]=isset($a[2])?$a[3].'<td>'.$sj[$a[5]][3][$j].'<td>'.$sj[$a[5]][2][$j]:$stest;//$sj[$s][4][$j]=isset($a[2])?$a[3].'<td>'.$sj[$s][3][$j].'<td>'.$sj[$s][2][$j]:$stest;//judjes marks for table
  $sj[$a[5]][6][0]=$a[6];//s.id
  }
}

 //  for ($s=0;$s<$ns;$s++)
 foreach($sj as $s=>$m){
  $sum = 0;
  $min = $maxc;
  $max = $minc;
  for ($j=0;$j<$nj;$j++){
    $sum += $sj[$s][2][$j];
    if ($ntype==1) {
      if ($sj[$s][2][$j]<$min) $min=$sj[$s][2][$j]; 
      if ($sj[$s][2][$j]>$max) $max=$sj[$s][2][$j];
    }
  }
  
  $sj[$s][5][0]=$sum;//sum place
  if ($ntype==1) $sj[$s][5][0]-=$min+$max;
  }
 
 uasort($sj,'cmp');
 
 $rm = mysql_query('select id from skaters where (ncategory=0 or ncategory is null) and ttime is not null order by ttime desc limit 1');
 
 if (($am=mysql_fetch_row($rm)) and ($am[0])) {
  $lastid=$am[0];
  $fl=0;
 } else {
  $lastid=0;
  $fl=1;
 }
 
 $k=0;$kn=0;$c1=$maxc;$fl=1;$sttop5='';$stcurf2='';

 //for ($s=0;$s<$ns;$s++)
 foreach($sj as $s=>$m){
  if (($c1==$sj[$s][5][0]) and ($sj[$s][7][0]==1)) {
    $kn++;
  } else {
    $c1 = $sj[$s][5][0];
    $k += $kn+1;
    $kn = 0;
  }
  
  $st='';
  
  for ($i=0;$i<$nj;$i++){
    $st .= $sj[$s][4][$i];
    //$stf2.=$sj[$s][4][$i];
  }
  
  //$lastid==$sj[$s][6][0]
  $stf  .= '<tr'.($lastid==$s?' style="font-weight: 700;"':'').'><td>'.($sj[$s][5][0]<$mpl?$k:'&nbsp;').'<td>'.im($sj[$s][0]).'<td>'.(isset($sj[$s][1][0])?$sj[$s][1][0]:'&nbsp;').$st.'<td>'.($sj[$s][5][0]<$mpl?$sj[$s][5][0]:'&nbsp;');
  $stff .= '<tr'.($lastid==$s?' style="font-weight: 700;"':'').'><td>'.($sj[$s][5][0]<$mpl?$k:'&nbsp;').'<td>'.im($sj[$s][0]).'<td>'.(isset($sj[$s][1][0])?$sj[$s][1][0]:'&nbsp;').$st.'<td>'.($sj[$s][5][0]<$mpl?$sj[$s][5][0]:'&nbsp;');
  
  if ($sj[$s][5][0]<$mpl) {$stfe=$stf;$stffe=$stff; $stffp.='<tr><td>'.($sj[$s][5][0]<$mpl?$k:'&nbsp;').'<td>'.$sj[$s][0][0].'<td>'.$sj[$s][0][2].'<td>'.$sj[$s][0][1].'('.$sj[$s][0][4].')<td>'.$sj[$s][0][1].'<td>'.$sj[$s][0][4];}
  if (($k<=5)and($sj[$s][5][0]<$mpl)) $sttop5.='<tr'.($lastid==$s?' style="font-weight: 700;"':'').'><td>'.$k.'<td>'.im($sj[$s][0]);
  if (($fl)and($sj[$s][5][0]>=$mpl)){
    $fl = 0;
    $stnextf2 = '<br><p class=txt13><b>Next skater: '.im($sj[$s][0]).'</p>';
  }
  
  if ($lastid==$s) {
    $fl = 1;
    $sttabf2 .= '<tr style="color: yellow; font-weight:700;">'.$st.'<td>'.$sj[$s][1][0].'<td>'.($sj[$s][5][0]<$mpl?$k:'&nbsp;').'</table>';
    $stcurf2  = '<div class=txt20 style="color: yellow; font-weight:700;">'.im($sj[$s][0]).'</div>';
   }
  }

$t=time();

$lock = '../admin/indexnulllock';
while (file_exists($lock)) usleep(100000);
$ilf = fopen($lock,'w');
fwrite($ilf, '1');
fclose($ilf);
$f = fopen('../indexnull.html', 'w');
fwrite($f,$stf.'</table><br><a class="white" href="index.html">Home</a></center><script type="text/javascript">var t='.$t.',t2='.$t.',u="ixnull.html";</script></body></html>');
fclose($f);
unlink($lock);

$lock = '../admin/indexwnulllock';
while (file_exists($lock)) usleep(100000);
$ilf = fopen($lock,'w');
fwrite($ilf, '1');
fclose($ilf);
$f = fopen('../indexwnull.html', 'w');
fwrite($f,$stfe.'</table><br><a class="white" href="index.html">Home</a></center><script type="text/javascript">var t='.$t.',t2='.$t.',u="ixwnull.html";</script></body></html>');
fclose($f);
unlink($lock);

$lock = '../admin/ixnulllock';
while (file_exists($lock)) usleep(100000);
$ilf = fopen($lock,'w');
fwrite($ilf, '1');
fclose($ilf);
$f = fopen('../ixnull.html', 'w');
fwrite($f,$stff.'<t>'.$t.'</t>');
fclose($f);
unlink($lock);

$lock = '../admin/ixwnulllock';
while (file_exists($lock)) usleep(100000);
$ilf = fopen($lock,'w');
fwrite($ilf, '1');
fclose($ilf);
$f = fopen('../ixwnull.html', 'w');
fwrite($f,$stffe.'<t>'.$t.'</t>');
fclose($f);
unlink($lock);

$lock = '../admin/fpnulllock';
while (file_exists($lock)) usleep(100000);
$ilf = fopen($lock,'w');
fwrite($ilf, '1');
fclose($ilf);
$f = fopen('../fpnull.html', 'w');
fwrite($f,$stffp.'<t>'.$t.'</t>');
fclose($f);
unlink($lock);

$lock = '../admin/indextnulllock';
while (file_exists($lock)) usleep(100000);
$i2lf = fopen($lock,'w');
fwrite($i2lf, '1');
fclose($i2lf);
$f2 = fopen('../indextnull.html', 'w');
fwrite($f2,$strf2);
if ($stcurf2) fwrite($f2,$stcurf2.$sttabf2);
if ($stnextf2) fwrite($f2,$stnextf2);
if ($sttop5) fwrite($f2,'<table border=1 cellspacing=0 cellpadding=2 class=txt><caption class=top5>Top 5</caption><tr><th>#<th>Name'.$sttop5.'</table>');
fwrite($f2,'<br><a class="white" href="index.html">Home</a></body></html>');
fclose($f2);
unlink($lock);

$lock = '../admin/indexwtnulllock';
while (file_exists($lock)) usleep(100000);
$i2lf = fopen($lock,'w');
fwrite($i2lf, '1');
fclose($i2lf);
$f2 = fopen('../indexwtnull.html', 'w');
fwrite($f2,$strf2);
if ($stcurf2) fwrite($f2,$stcurf2.$sttabf2);
if ($stnextf2) fwrite($f2,$stnextf2);
fwrite($f2,'<br><a class="white" href="index.html">Home</a></body></html>');
fclose($f2);
unlink($lock);

}
}

?>
