<?
$stfb='<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="./style.css" rel="stylesheet" type="text/css">
<title>Slalom Classic</title>
<script type="text/javascript">
if (window.XMLHttpRequest) req = new XMLHttpRequest(); else if (window.ActiveXObject) req = new ActiveXObject("Microsoft.XMLHTTP");
if (req != undefined)
 {req.onreadystatechange = function()
  {if (req.readyState == 4) // only if req is "loaded"
   {if (req.status == 200) // only if "OK"
    {x=req.responseText;
     a=x.lastIndexOf("</t>");
     if (a!=-1)
     {b=x.lastIndexOf("<t>");
      if ((b!=-1)&&(a>b))
      {g=parseInt(x.substring(b+3,a));
       if ((!isNaN(g))&&(g>t)){document.getElementById("t").innerHTML = x.substring(0,b);t=g;}
       }
      }
     }
    }
   };
  d=setTimeout("load()",2000);
  }

function load() {req.open("GET", u+"?t="+new Date().getTime(), true); req.send(""); d=setTimeout("load()",2000);}

if (window.XMLHttpRequest) req2 = new XMLHttpRequest(); else if (window.ActiveXObject) req2 = new ActiveXObject("Microsoft.XMLHTTP");
if (req2 != undefined)
 {req2.onreadystatechange = function()
  {if (req2.readyState == 4) // only if req is "loaded"
   {if (req2.status == 200) // only if "OK"
    {g=parseInt(req2.responseText);
     if ((!isNaN(g))&&(g>t2)) location.reload(true);
     }
    }
   };
  d2=setTimeout("load2()",60000);
  }

function load2()
 {req2.open("GET", "ch.html?t="+new Date().getTime(), true); req2.send("");
  d2=setTimeout("load2()",60000);
  }

</script></head><body class=rev><center>';
$strf2b='<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="./style.css" rel="stylesheet" type="text/css">
<title>Slalom Classic</title>
<meta http-equiv="refresh" content="3"/>
</head><body class=rev>';
$stfbo='<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="./style.css" rel="stylesheet" type="text/css">
<title>Slalom Classic</title>
<meta http-equiv="refresh" content="60"/>
</head><body class=rev>';
require('../connect.php');
$r=mysql_query('Select cname,cftpfile,ngroup,cplace,DATE_FORMAT(ddate, "%d.%m.%Y"),cdiscip,ccategory,ntype,nflag,nnumber,nname,nname_local,nplace,nteam From title Order By id');
$t=mysql_fetch_row($r);
if ($t[0])
{$stfbo.='<div class=txt20 style="font-weight:700;">'.$t[0].'</div><div class=txt14>'.$t[3].($t[4]?', '.$t[4]:'').'<br>'.$t[5].'</div><br>';
 $stfb.='<div class=txt20 style="font-weight:700;">'.$t[0].'</div><div class=txt14>'.$t[3].($t[4]?', '.$t[4]:'').'<br>'.$t[5].'</div><br>';
 $strf2b.='<div class=txt20 style="font-weight:700;">'.$t[0].'</div><div class=txt14>'.$t[3].($t[4]?', '.$t[4]:'').'<br>'.$t[5].'</div><br>';
 $cftpfile=$t[1];
 $ntype=$t[7];
 $nflag=$t[8];
 $nnum=$t[9];
 $nname=1;//$nname=$t[10];
 $nnamel=$t[11];
 $nplace=$t[12];
 $nteam=$t[13];
 }
$stfbo.='<br><table border=1 cellpadding=6 cellspacing=0><tr><th>Category<th>Results<th>Results without Next<th>Result, Top5 and the Next<th>Result and the Next</th>';
$r=mysql_query('Select cvalue From type_marks order by npos,id');
$ntm=mysql_numrows($r); $stm=''; //$nc=0;
while($a=mysql_fetch_row($r)) {$stm.='<th>'.$a[0];}//$nc++;}
$r=mysql_query('Select CONCAT("Judge ",nnumber) From judges where npenalty=0 order by nnumber,id');
$nj=mysql_numrows($r); $sjf=''; $sjf2='';
for ($j=0;$j<$nj;$j++)
{$a=mysql_fetch_row($r);
 $sjf.='<th colspan='.($ntm+2).'>'.$a[0];
 $sjf2.='<th colspan=2>'.$a[0];
 }
function cmp($a, $b)
 {global $nj;
  if ($a[5][0]==$b[5][0])
  {$k=0;
   for ($j=0;$j<$nj;$j++) {if ($a[2][$j]<$b[2][$j]) $k--; elseif ($a[2][$j]>$b[2][$j]) $k++;}
   if ($k==0) {$a[7][0]=1; $b[7][0]=1; return ($a[6][0]<$b[6][0])?-1:1; } //compared
    else return $k;
   }
  return ($a[5][0]<$b[5][0])?-1:1;
  }
function im($a)
{global $nnum,$nname,$nflag,$nplace,$nteam,$nnamel;
 $st=($nnum?$a[0].'&nbsp;':'').($nflag?$a[1].'&nbsp;':'').($nname?$a[2].'&nbsp;':'').($nnamel?$a[3].'&nbsp;':'').($nplace?'('.$a[4].')&nbsp;':'').($nteam?$a[5].'&nbsp;':'');
 return ($st?substr($st,0,-6):'');
 }

$rc=mysql_query('Select id,cvalue From categories Order By npos,id');
$nct=mysql_numrows($rc);
for($ic=0;$ic<$nct;$ic++)
{$c=mysql_fetch_row($rc);  
///loop category
$stfbo.='<tr><td>'.$c[1].'<td><a class="white" href="index'.$c[0].'.html">Link</a><td><a class="white" href="indexw'.$c[0].'.html">Link</a><td><a class="white" href="indext'.$c[0].'.html">Link</a><td><a class="white" href="indexwt'.$c[0].'.html">Link</a></td>';
 
$stf=$stfb.'<div id="cat" class=txt14>'.$c[1].'</div><br>';
$strf2=$strf2b.'<div id="cat" class=txt14>'.$c[1].'</div><br>';
$sttop5='';$stcurf2='';
$r=mysql_query('Select count(*) From skaters s where ncategory='.$c[0]);
$ns=mysql_result($r,0);


$stf.='<table border=1 class=txt cellspacing=0 cellpadding=2><tr><th rowspan=2>#<th rowspan=2>Skater<th rowspan=2>Penalty'.$sjf.'<th rowspan=2>Sum Place<tr>';
$sttabf2='<table border=1 class=txt cellspacing=0 cellpadding=2><tr>'.$sjf.'<th rowspan=2>Penalty<th rowspan=2>Place<tr>';
//$nc=($nc+2)*$nj;
for ($j=0;$j<$nj;$j++) 
{$stf.=$stm.'<th>Total<th>Place';
 $sttabf2.=$stm.'<th>Mark<th>Place';
 }
$stf.='<tbody id="t">';
$stff=''; $stffe=''; $stfe=$stf; $stffp='';

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
$mpl=10000; $maxc=100; $minc=0;
$stest='';
for ($j=0;$j<$ntm+2;$j++) $stest.='<td>&nbsp;';
if ($ns)
{unset($sj); 
 $r=mysql_query('select s.cname,
			j.id,
			if(s.npenalty is not null and s.mid='.($ntm*$nj).', Sum(m.nvalue)-s.npenalty, null),
			GROUP_CONCAT(concat_ws("","<td>",ifnull(m.nvalue,"&nbsp;")) order by tm.npos,tm.id separator ""),
			s.npenalty,s.id,s.norder,
			s.nnumber, concat("<img src=\"",f.cpath,"\">",f.c3let), s.cplace, concat("(",s.cteam,")"), concat("(",s.cname_local,")")
	        from (select s.*,count(m.id) as mid from skaters s left join marks m on (m.nskater=s.id) group by s.id) s left join flags f on (s.nflag=f.ncode) inner join judges j inner join type_marks tm left join marks m on (m.njudge=j.id and m.nskater=s.id and m.ntype=tm.id)
		where s.ncategory='.$c[0].' and j.npenalty=0
		group by s.id,j.nnumber
	        order by j.nnumber,3 desc,s.norder,s.id');
 for ($j=0;$j<$nj;$j++)
 {$k=0; $prev=$maxc; $kn=0;
  for ($s=0;$s<$ns;$s++)
  {$a=mysql_fetch_row($r);
   if ($a[2]==$prev) $kn++;
    else {$prev=$a[2]; $k+=$kn+1; $kn=0;}
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
 foreach($sj as $s=>$m)//  for ($s=0;$s<$ns;$s++)
 {$sum=0;$min=$maxc; $max=$minc;
  for ($j=0;$j<$nj;$j++)
  {$sum+=$sj[$s][2][$j];
   if ($ntype==1) {if ($sj[$s][2][$j]<$min) $min=$sj[$s][2][$j]; if ($sj[$s][2][$j]>$max) $max=$sj[$s][2][$j];}
   }
  $sj[$s][5][0]=$sum;//sum place
  if ($ntype==1) $sj[$s][5][0]-=$min+$max;
  }
 uasort($sj,'cmp');
 $rm=mysql_query('select id from skaters where ncategory='.$c[0].' and ttime is not null order by ttime desc limit 1');
 if (($am=mysql_fetch_row($rm)) and ($am[0])) {$lastid=$am[0];$fl=0;} else {$lastid=0;$fl=1;}
 $k=0;$kn=0;$c1=$maxc;$fl=1;//$sttop5='';$stcurf2='';
 foreach($sj as $s=>$m)//for ($s=0;$s<$ns;$s++)
 {if (($c1==$sj[$s][5][0])and($sj[$s][7][0]==1)) {$kn++;}
   else {$c1=$sj[$s][5][0];$k+=$kn+1;$kn=0;}
  $st='';
  for ($i=0;$i<$nj;$i++)
  {$st.=$sj[$s][4][$i];
   //$stf2.=$sj[$s][4][$i];
   }
  //$lastid==$sj[$s][6][0]
  $stf.='<tr'.($lastid==$s?' style="font-weight: 700;"':'').'><td>'.($sj[$s][5][0]<$mpl?$k:'&nbsp;').'<td>'.im($sj[$s][0]).'<td>'.(isset($sj[$s][1][0])?$sj[$s][1][0]:'&nbsp;').$st.'<td>'.($sj[$s][5][0]<$mpl?$sj[$s][5][0]:'&nbsp;');
  $stff.='<tr'.($lastid==$s?' style="font-weight: 700;"':'').'><td>'.($sj[$s][5][0]<$mpl?$k:'&nbsp;').'<td>'.im($sj[$s][0]).'<td>'.(isset($sj[$s][1][0])?$sj[$s][1][0]:'&nbsp;').$st.'<td>'.($sj[$s][5][0]<$mpl?$sj[$s][5][0]:'&nbsp;');
  if ($sj[$s][5][0]<$mpl) {$stfe=$stf;$stffe=$stff; $stffp.='<tr><td>'.($sj[$s][5][0]<$mpl?$k:'&nbsp;').'<td>'.$sj[$s][0][0].'<td>'.$sj[$s][0][2].'<td>'.$sj[$s][0][1].'('.$sj[$s][0][4].')<td>'.$sj[$s][0][1].'<td>'.$sj[$s][0][4];}
  if (($k<=5)and($sj[$s][5][0]<$mpl)) $sttop5.='<tr'.($lastid==$s?' style="font-weight: 700;"':'').'><td>'.$k.'<td>'.im($sj[$s][0]);
  if (($fl)and($sj[$s][5][0]>=$mpl))
  {$fl=0;
   $stnextf2='<br><p class=txt13><b>Next skater: '.im($sj[$s][0]).'</p>';
   }
  
  if ($lastid==$s) 
  {$fl=1;
   $sttabf2.='<tr style="color: yellow; font-weight:700;">'.$st.'<td>'.$sj[$s][1][0].'<td>'.($sj[$s][5][0]<$mpl?$k:'&nbsp;').'</table>';
   $stcurf2='<div class=txt20 style="color: yellow; font-weight:700;">'.im($sj[$s][0]).'</div>';
   }
  }
 }

$t=time();
$lock='../admin/index'.$c[0].'lock';
while (file_exists($lock)) usleep(100000);
$ilf=fopen($lock,'w');
fwrite($ilf, '1');
fclose($ilf);
$f=fopen('../index'.$c[0].'.html', 'w');
fwrite($f,$stf.'</table><br><a class="white" href="index.html">Home</a></center><script type="text/javascript">var t='.$t.',t2='.$t.',u="ix'.$c[0].'.html";</script></body></html>');
fclose($f);
unlink($lock);

$lock='../admin/indexw'.$c[0].'lock';
while (file_exists($lock)) usleep(100000);
$ilf=fopen($lock,'w');
fwrite($ilf, '1');
fclose($ilf);
$f=fopen('../indexw'.$c[0].'.html', 'w');
fwrite($f,$stfe.'</table><br><a class="white" href="index.html">Home</a></center><script type="text/javascript">var t='.$t.',t2='.$t.',u="ixw'.$c[0].'.html";</script></body></html>');
fclose($f);
unlink($lock);

$lock='../admin/ix'.$c[0].'lock';
while (file_exists($lock)) usleep(100000);
$ilf=fopen($lock,'w');
fwrite($ilf, '1');
fclose($ilf);
$f=fopen('../ix'.$c[0].'.html', 'w');
fwrite($f,$stff.'<t>'.$t.'</t>');
fclose($f);
unlink($lock);

$lock='../admin/ixw'.$c[0].'lock';
while (file_exists($lock)) usleep(100000);
$ilf=fopen($lock,'w');
fwrite($ilf, '1');
fclose($ilf);
$f=fopen('../ixw'.$c[0].'.html', 'w');
fwrite($f,$stffe.'<t>'.$t.'</t>');
fclose($f);
unlink($lock);

$lock='../admin/fp'.$c[0].'lock';
while (file_exists($lock)) usleep(100000);
$ilf=fopen($lock,'w');
fwrite($ilf, '1');
fclose($ilf);
$f=fopen('../fp'.$c[0].'.html', 'w');
fwrite($f,$stffp.'<t>'.$t.'</t>');
fclose($f);
unlink($lock);

$lock='../admin/indext'.$c[0].'lock';
while (file_exists($lock)) usleep(100000);
$i2lf=fopen($lock,'w');
fwrite($i2lf, '1');
fclose($i2lf);
$f2=fopen('../indext'.$c[0].'.html', 'w');
fwrite($f2,$strf2);
if ($stcurf2) fwrite($f2,$stcurf2.$sttabf2);
if ($stnextf2) fwrite($f2,$stnextf2);
if ($sttop5) fwrite($f2,'<br><table border=1 cellspacing=0 cellpadding=2 class=txt><caption class=top5>Top 5</caption><tr><th>#<th>Name'.$sttop5.'</table>');
fwrite($f2,'<br><a class="white" href="index.html">Home</a></body></html>');
fclose($f2);
unlink($lock);

$lock='../admin/indexwt'.$c[0].'lock';
while (file_exists($lock)) usleep(100000);
$i2lf=fopen($lock,'w');
fwrite($i2lf, '1');
fclose($i2lf);
$f2=fopen('../indexwt'.$c[0].'.html', 'w');
fwrite($f2,$strf2);
if ($stcurf2) fwrite($f2,$stcurf2.$sttabf2);
if ($stnextf2) fwrite($f2,$stnextf2);
fwrite($f2,'<br><a class="white" href="index.html">Home</a></body></html>');
fclose($f2);
unlink($lock);

//end loop
}
require('gennull.php');

$lock='../admin/indexlock';
while (file_exists($lock)) usleep(100000);
$ilf=fopen($lock,'w');
fwrite($ilf, '1');
fclose($ilf);
$f=fopen('../index.html', 'w');
fwrite($f,$stfbo.'</table></center></body></html>');
fclose($f);
unlink($lock);

if ($cftpfile)
{$cpf=fopen('../admin/copy','w');
 fwrite($cpf, $cftpfile);
 fclose($cpf);
 //ftp://rollersport:cahphai8ohghu8chuL3k@rollersport.ru/rollercup2011/index.html
 }
 else if (file_exists('../admin/copy')) unlink('../admin/copy');

?>
