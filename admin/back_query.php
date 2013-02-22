<?php //:
////////:

if ($ntype==1) {
    $tq = '-max(jp.nplace)-min(jp.nplace)'; 
    $to = 'isnull(s2a),s2a,';
} elseif ($ntype==0) {
    $tq = '';
    $to = '';
}//$to='isnull(s2),s2,s1 desc,s3 desc,isnull(s4),s4,';

$r = mysql_query('select s.id,s.nnumber,s.cname,s.cname_local,s.dbday,s.cplace,s.norder,
s.jpnresult as s1,
s.jpnplace as s2,
s.m1nvalue as s3,
s.npenalty as s4, a[10]
m.nvalue as s5,
jpm.nresult as s6,
jpm.nplace as s7,
s.ttime,
s.flag and s.flagp as flago,
s.jpnplacea as s2a
from (select s.id as id,s.nnumber as nnumber,s.cname as cname,s.cname_local as cname_local,s.dbday as dbday,s.cplace as cplace,s.norder as norder,sum(jp.nresult) as jpnresult,sum(jp.nplace)'.$tq.' as jpnplace,sum(jp.nplace) as jpnplacea,sum(m1.nvalue) as m1nvalue,s.npenalty as npenalty, s.ttime as ttime,if(count(jp.nplace)=count(jp.nresult),1,0) as flag,if(s.npenalty is not null,1,0) as flagp
		 from judgeplace jp left join skaters s on (jp.nskater=s.id)
		 left join marks m1 on (m1.njudge=jp.njudge and m1.nskater=s.id and m1.ntype=(select id from type_marks order by npos,id limit 1)) where jp.descr='.$descr.' group by s.id) s

     inner join judges j inner join type_marks tm left join marks m on (m.njudge=j.id and m.nskater=s.id and m.ntype=tm.id)
     left join judgeplace jpm on (jpm.descr='.$descr.' and s.id=jpm.nskater and jpm.njudge=j.id)
		where j.npenalty=0
	        order by isnull(s2),s2,'.$to.'s3 desc,s.norder,s.id,j.nnumber,tm.npos,tm.id
');
 
// if ($st=mysql_error()) echo $st;

$k       = 0;
$kn      = 0;
$c1      = 0;
$c2      = 10000;
$c3      = 10000;
$c4      = 10000;
$fl      = 1;
$sttop5  = '';
$stcurf2 = '';

for ($s=0;$s<$ns;$s++){
  $st   = '';
  $stf2 = '';
  for ($i=0;$i<$nj;$i++){
    for ($j=0;$j<$ntm;$j++){
      $a   = mysql_fetch_row($r);
      $st .= '<td>'.($a[11]?$a[11]:'&nbsp;');
    }
   $st   .='<td>'.($a[12]?$a[12]:'&nbsp;').'<td>'.($a[13]?$a[13]:'&nbsp;');
   $stf2 .='<th>'.($a[12]?$a[12]:'&nbsp;').'<th>'.($a[13]?$a[13]:'&nbsp;');
  }
  
  //if (($c1==$a[8])and($c2==$a[7])and($c3==$a[9])and($c4==$a[10]))$kn++;
  if (($c1==$a[8]) and ($c3==$a[9])) {
    $kn++;
  } else {
    $c1=$a[8];$c2=$a[7];$c3=$a[9];$c4=$a[10];$k+=$kn+1;$kn=0;
  }

  $stf  .= '<tr'.($lastid==$a[0]?' style="font-weight: 700;"':'').'><td>'.($a[15]?$k:'&nbsp;').'<td>'.($a[1]?'#'.$a[1]:$a[6]).' '.$a[2].($a[3]?' ('.$a[3].')':'').($a[5]?' ('.$a[5].')':'').'<td>'.(isset($a[10])?$a[10]:'&nbsp;').$st.'<td>'.($a[7]?$a[7]:'&nbsp;').'<td>'.($a[8]?$a[8]:'&nbsp;');
  $stff .= '<tr'.($lastid==$a[0]?' style="font-weight: 700;"':'').'><td>'.($a[15]?$k:'&nbsp;').'<td>'.($a[1]?'#'.$a[1]:$a[6]).' '.$a[2].($a[3]?' ('.$a[3].')':'').($a[5]?' ('.$a[5].')':'').'<td>'.(isset($a[10])?$a[10]:'&nbsp;').$st.'<td>'.($a[7]?$a[7]:'&nbsp;').'<td>'.($a[8]?$a[8]:'&nbsp;');
  
  if ($a[15]) {
    $stfe  = $stf;
    $stffe = $stff;
  }
  if (($k<=5) and ($a[15])) {
    $sttop5 .= '<tr'.($lastid==$a[0]?' style="font-weight: 700;"':'').'><td>'.($a[1]?$a[1]:$a[6]).'<td>'.$a[2].($a[3]?' ('.$a[3].')':'').'<td>'.$a[5].'<td>'.$k;
  }
  if ($lastid == $a[0]) {
    $sttabf2 .= '<tr style="color: yellow; font-weight:700;">'.$stf2.'<td>'.$a[10].'<td>'.($a[15]?$k:'&nbsp;').'</table>';
    $stcurf2  = '<Div class=txt20 style="color: yellow; font-weight:700;">'.($a[1]?'#'.$a[1]:$a[6]).' '.$a[2].($a[3]?' ('.$a[3].')':'').($a[5]?' ('.$a[5].')':'').'</div>';
  }
  if (($fl)and(!isset($a[14]))){
    $fl = 0;
    $stnextf2 = '<br><p class=txt13><b>Next skater: '.($a[1]?'#'.$a[1]:$a[6]).' '.$a[2].($a[3]?' ('.$a[3].')':'').($a[5]?' ('.$a[5].')':'').'</p>';
  }

}

$r = mysql_query('delete from judgeplace where descr='. $descr);

?>
