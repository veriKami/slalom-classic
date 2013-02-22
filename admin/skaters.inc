<center><b><a class=txt12>Skaters</a></b></center>

<?php //:
////////:-----------------------------------------------------------------------

if (isset($_GET['sort'])) {$_GET['sort']=intval($_GET['sort']); $so='&sort='.$_GET['sort'];} else $so='';
if (isset($_GET['ncat'])) {$_GET['ncat']=intval($_GET['ncat']); $sc='&ncat='.$_GET['ncat'];} else $sc='';

/**
 * Function
 */
function ec($i,$k){
  global $mc,$so;
 echo '<li class="'.(($k==$mc[$i][0])?'sel':'unsel').'"><a href="admin.php?mode=skaters&ncat='.$mc[$i][0].$so.'">'.$mc[$i][1].'('.$mc[$i][2].')</a></li>';
 }

$rc=mysql_query('Select c.id,c.cvalue,count(s.id) From categories c left join skaters s on(s.ncategory=c.id) group by c.id Order By c.npos,c.id'); $ncat=mysql_numrows($rc);

if ($ncat)
{//echo '<table class=catt border=0 cellpading=0 cellspacing=0><tr>';
 
 echo '<ul class="catt">';
 
 $r=mysql_query('Select count(*) From skaters');
 
 $mc[-2][0]=-1; $mc[-2][1]='All'; $mc[-2][2]=mysql_result($r,0);
 $r=mysql_query('Select count(id) From skaters where ncategory is null');
 $mc[-1][0]=0; $mc[-1][1]='Without Category'; $mc[-1][2]=mysql_result($r,0);
 ec(-2,(isset($_GET['ncat'])?$_GET['ncat']:-1));ec(-1,(isset($_GET['ncat'])?$_GET['ncat']:-1));
 for($i=0;$i<$ncat;$i++) {$mc[$i]=mysql_fetch_row($rc); ec($i,(isset($_GET['ncat'])?$_GET['ncat']:-1));}
 //echo '<tr><td class="main" colspan='.($ncat+2).'>';
 
 echo '</ul>';
 if (($_GET['ncat']==-1)or(!isset($_GET['ncat']))) $scq='';
 else if ($_GET['ncat']==0) $scq=' where c.id is null';
  else $scq=' where c.id='.$_GET['ncat'];

 $r=mysql_query('Select c.id,ifnull(c.ngroup,0),count(s.id) From categories c left join skaters s on(s.ncategory=c.id)'.$scq.' group by c.id Order By c.npos,c.id');
 
 if ($st=mysql_error()) echo $st;
 
 $jsm='jsm0=new Array();jsmi0=0;'; $ng=mysql_numrows($r);
 
 for($i=0;$i<$ng;$i++){$a=mysql_fetch_row($r); $ngroup[$i]=$a; $jsm.='jsm'.$a[0].'=new Array();jsmi'.$a[0].'=0;';}
 
 if (($_GET['ncat']==-1)or(!$_GET['ncat']))
 {$r=mysql_query('Select ifnull(ngroup,0) From title Order By id'); $ngroup[$i][0]=0; $ngroup[$i][1]=mysql_result($r,0);
  $r=mysql_query('Select count(id) From skaters where ncategory is null'); $ngroup[$i][2]=mysql_result($r,0);
  }
 else $ng=0;
 }
else
 {$scq='';$jsm='jsm0=new Array();jsmi0=0;'; $ng=0;
  }
 
 mysql_query('SET group_concat_max_len = 45000;');
 
 $jsmf='jsmf=['.mysql_result(mysql_query('select group_concat(concat("[",ncode,",\"",cvalue,"\",\"",cpath,"\",\"",c3let,"\"]") order by cvalue separator ",") from flags'),0).'];';

////////: ?>

<form name=skaters method=post action=skaters.php>

<?php //:
////////:-----------------------------------------------------------------------

if ($_GET['add']!=1) {echo '<input type=button value=" Add " class=txt onclick="window.open(\'admin.php?mode=skaters&add=1'.$so.$sc.'\',\'_self\');"> <input type=button value="Import from CSV" class=txt onclick="window.open(\'admin.php?mode=skaterscsv'.$so.$sc.'\',\'_self\');"> <input type=submit name=subbuta class=txt value=" Save ">';$std='';}
    else {$std=' disabled'; }
//else $ng=0;

function cat($name,$i,$d,$a)
{global $ncat,$mc;
 if ($ncat)
 {echo '<select class=txt id="'.$name.'" name="'.$name.'" '.($d?' disabled':'').' onchange="'.($_GET['add']!=1?'sete('.$a.'); document.getElementById(\'rand\').disabled=true;':'').'"><option value="0">not selected</option>';
  for($j=0;$j<$ncat;$j++) echo '<option value="'.$mc[$j][0].'"'.($mc[$j][0]==$i?' selected':'').'>'.$mc[$j][1].'</option>';
  echo '</select>';
  }
 }

////////: ?>

<table class=txt cellspacing=1 cellpadding=1 border=1>
<th>#<th>Number <a href=admin.php?mode=skaters&sort=2<?=$sc?>>\/</a><th>Name <a href=admin.php?mode=skaters&sort=3<?=$sc?>>\/</a><th>Name(local) <a href=admin.php?mode=skaters&sort=4<?=$sc?>>\/</a><th>Birthday <a href=admin.php?mode=skaters&sort=5<?=$sc?>>\/</a><th>Country

<?

if ($_GET['add']!=1) echo' <input type=button value="..." title="Set country to all" onclick="setf(-1)"><br><input type=button class=txt value="Set automatically" title="Try to set country automatically to all" onclick="seta()">';?><th>Place<th>Team<th>Rating <a href=admin.php?mode=skaters&sort=8<?=$sc?>>\/</a><th>Category <a href=admin.php?mode=skaters&sort=c.npos,c.id<?=$sc?>>\/</a><?
if (($_GET['add']!=1)&& ($ncat))
 {echo '<br><select class=txt onchange="setc(this.selectedIndex);document.getElementById(\'rand\').disabled=true;" title="Set group to all"><option value="-1">Set group to all</option><option value="0">not selected</option>';
  for($j=0;$j<$ncat;$j++) echo '<option>'.$mc[$j][1].'</option>';
  echo '</select>';
  }

?>

<th>Start Position <a href=admin.php?mode=skaters&sort=7<?=$sc?>>\/</a>
<? 

if ($_GET['add']!=1) echo '<br><input id="rand" type=button value="Randomize" title="Randomize Start Position" class=txt onclick="randsp();"><br><input id="rand" type=button value="Back to rating" title="Start Position by rating back" class=txt onclick="ordersp();">';

?>

<th>Operation</th>
<input type=hidden name=delid value=""><input type=hidden name="sort" value="<?=$_GET['sort']?>"><input type=hidden name="ncato" value="<?=$_GET['ncat']?>">

<?

//if ($_GET['ncat']==-1) $scq='';
//else if ($_GET['ncat']==0) $scq=' where ncategory is null';
// else $scq=' where ncategory='.$_GET['ncat'];
  $r=mysql_query('Select s.id,s.nnumber,s.cname,s.cname_local,DATE_FORMAT(s.dbday, "%d.%m.%Y"),s.cplace,s.norder,s.nrat,s.ngroup,ifnull(c.id,0),s.nflag,concat("<image src=\"",f.cpath,"\">",f.c3let),cteam From skaters s left join categories c on (s.ncategory=c.id) left join flags f on (s.nflag=f.ncode)'.$scq.' Order By '.($_GET['sort']?($_GET['sort']==5?'s.dbday':$_GET['sort']).',':'').'c.npos,c.id,s.norder,s.id');
  
  if ($st=mysql_error()) echo $st;
  $n=mysql_numrows($r);
  
  for($i=0;$i<$n;$i++)
  {$a=mysql_fetch_row($r);
   $jsm.='jsm'.$a[9].'[jsmi'.$a[9].']=new Array(); jsm'.$a[9].'[jsmi'.$a[9].'][0]='.$i.'; jsm'.$a[9].'[jsmi'.$a[9].'++][1]='.($a[7]?$a[7]:'1000000').';';
   echo '<input type=hidden name=id['.$i.'] value='.$a[0].'><input type=hidden id="eid'.$i.'" name=eid['.$i.'] value="0"><tr><td>'.$a[0].'</td>
<td><input type=text'.$std.' name=nnumber['.$i.'] size=20 maxlength=250 class=txt value="'.$a[1].'" oninput="sete('.$i.');"></td>
<td><input type=text'.$std.' name=cname['.$i.'] size=20 maxlength=250 class=txt value="'.$a[2].'" required data-errormessage="Can\'t be empty" x-moz-errormessage="Can\'t be empty" oninput="sete('.$i.'); if (this.value==\'\') this.setCustomValidity(\'Cant be empty\'); else this.setCustomValidity(\'\');"></td>
<td><input type=text'.$std.' name=cname_local['.$i.'] size=20 maxlength=250 class=txt value="'.$a[3].'" oninput="sete('.$i.');"></td>
<td><input type=text'.$std.'  id="datepicker'.$i.'" name=dbday['.$i.'] size=10 maxlength=10 class=txt value="'.$a[4].'" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01]).(0[1-9]|1[012]).[0-9]{4}" onchange="sete('.$i.');" oninput="sete('.$i.'); if (!isdate(this)) this.setCustomValidity(\'Incorrect date format\'); else this.setCustomValidity(\'\');" data-errormessage="Incorrect date format" x-moz-errormessage="Incorrect date format"></td>
<td><table class=flag border=0 cellpadding=0 cellspacing=0><tr><td align=left class=txt id="f'.$i.'">'.$a[11].'<td align=right>&nbsp;<input class=txt'.$std.' type=button onclick="setf('.$i.')" value="..."></table><input type=hidden id="flag'.$i.'" name="nflag['.$i.']" value="'.$a[10].'"></td>
<td><input type=text'.$std.' id="cplace'.$i.'" name=cplace['.$i.'] size=20 maxlength=250 class=txt value="'.$a[5].'" oninput="sete('.$i.');"></td>
<td><input type=text'.$std.' id="cteam'.$i.'" name="cteam['.$i.']" size=20 maxlength=250 class=txt value="'.$a[12].'" oninput="sete('.$i.');"></td>
<td><input type=text'.$std.' name=nrat['.$i.'] size=5 maxlength=5 class=txt value="'.$a[7].'" pattern="\-?\d+(\.\d{0,})?" oninput="sete('.$i.'); if (isNaN(this.value)) this.setCustomValidity(\'Invalid number format\'); else this.setCustomValidity(\'\');" data-errormessage="Invalid number format" x-moz-errormessage="Invalid number format"></td>
<td>'; cat('ncat['.$i.']',$a[9],$std,$i); echo'</td>
<td><input type=text'.$std.' id="o'.$a[9].'x'.$i.'" name=norder['.$i.'] size=4 maxlength=4 class=txt value="'.$a[6].'" pattern="[0-9]+" oninput="sete('.$i.'); if (isNaN(this.value)) this.setCustomValidity(\'Invalid number format\'); else this.setCustomValidity(\'\');" data-errormessage="Invalid number format" x-moz-errormessage="Invalid number format"><a id="a'.$a[9].'x'.$i.'">'.($a[8]?'Group '.$a[8]:'').'</a><input id="g'.$a[9].'x'.$i.'" type=hidden name=ngroup['.$i.'] value='.$a[8].'> </td>
<td><a class=txt id="e'.$i.'">&nbsp;</a><input type=button'.$std.' class=txt value=" Delete " onclick="document.skaters.delid.value='.$a[0].'; document.skaters.submit();"></td></tr>';
   }
  if ($_GET['add'])
  {echo '<input type=hidden name=add value="1"><tr><td></td>
<td><input type=text name=nnumberadd size=20 maxlength=250 class=txt value=""></td>
<td><input type=text name=cnameadd size=20 maxlength=250 class=txt value="" required data-errormessage="Can\'t be empty" x-moz-errormessage="Can\'t be empty" oninput="if (this.value==\'\') this.setCustomValidity(\'Cant be empty\'); else this.setCustomValidity(\'\');"></td>
<td><input type=text name=cname_localadd size=20 maxlength=250 class=txt value=""></td>
<td><input type=text  id="datepicker'.$i.'" name=dbdayadd size=10 class=txt value="" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01]).(0[1-9]|1[012]).[0-9]{4}" oninput="if (!isdate(this)) this.setCustomValidity(\'Incorrect date format\'); else this.setCustomValidity(\'\');" data-errormessage="Incorrect date format" x-moz-errormessage="Incorrect date format"></td>
<td><table class=flag border=0 cellpadding=0 cellspacing=0><tr><td align=left class=txt id="fadd"><td align=right>&nbsp;<input class=txt type=button onclick="setf(\'add\')" value="..."></table><input type=hidden id="flagadd" name="nflagadd" value=""></td>
<td><input type=text id="cplaceadd" name=cplaceadd size=20 maxlength=250 class=txt value=""></td>
<td><input type=text id="cteamadd" name=cteamadd size=20 maxlength=250 class=txt value=""></td>
<td><input type=text name=nratadd size=5 maxlength=5 class=txt value="" pattern="\-?\d+(\.\d{0,})?" oninput="if (isNaN(this.value)) this.setCustomValidity(\'Invalid number format\'); else this.setCustomValidity(\'\');" data-errormessage="Invalid number format" x-moz-errormessage="Invalid number format"></td>
<td>'; cat('ncatadd',0,0,0); echo'</td>
<td><input type=text name=norderadd size=4 maxlength=4 class=txt value="" pattern="[0-9]+" oninput="if (isNaN(this.value)) this.setCustomValidity(\'Invalid number format\'); else this.setCustomValidity(\'\');" data-errormessage="Invalid number format" x-moz-errormessage="Invalid number format"></td>
<td><a class=txt id="e0">*</a></td></tr>';
   }
  echo '<tr><td colspan=12 align=center><input type=submit name=subbut class=txt value=" Save "></td></tr>';

?>

<link type="text/css" href="jquery/css/smoothness/jquery-ui-1.8.9.custom.css" rel="Stylesheet" />	
<script type="text/javascript" src="jquery/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="jquery/js/jquery-ui-1.8.9.custom.min.js"></script>
<script>

<? 

$_GET['add']?$i=$n:$i=0; for(;$i<=$n;$i++) { 

?>

	$(function() {
		$( "#datepicker<?=$i?>" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'dd.mm.yy',
			constrainInput: true,
			gotoCurrent: true,
			defaultDate: '-4y',
			autoSize: true,
			showOn: "button",
			firstDay: 1,
			selectOtherMonths: true,
			showOtherMonths: true,
			yearRange: '-40:-4'
		});
	});

<?

}

?>

</script>

<script type="text/javascript">
var pf,req,cf=-1,<?=$jsmf?>

<? 

if ($_GET['add']==1) echo 'document.skaters.nnumberadd.focus();';

?>
  
  function isdate(d)
  {if (d.value=='') return true;
   var md=d.value.split('.');
   if (md.length!=3) return false;
   else
   {var dt = new Date(md[2],md[1]-1,md[0]);
    //alert(md[0]+"."+md[1]+"."+md[2]+"-"+dt.getDate()+"."+(dt.getMonth()+1)+"."+dt.getFullYear());
    if ((dt.getDate()!=md[0])||((dt.getMonth()+1)!=md[1])||(dt.getFullYear()!=md[2])) return false;
     else return true;
    }
   }
  function sete(i){document.getElementById('eid'+i).value=1;document.getElementById('e'+i).innerHTML="*";}
  function setc(c){if (c!=0) for (i=0;i<<?=$n?>;i++) {document.getElementById('ncat['+i+']').selectedIndex=c-1; sete(i);}}
  //function closee() {var x=document.getElementById('edit'); if (x) x.parentNode.removeChild(x); document.body.style.overflow='auto';}
  function closee()
  {var x=document.getElementById('edit');
   if (x)
   {if (pf) {var y=document.getElementById('fg'+pf); y.className="unsel"; pf=0;}
    x.style.zIndex=-1; x.style.display='none';
    }
   document.body.style.overflow='auto';
   }
  function setflag(cf,ncode,cpath,c3let)
  {document.getElementById('f'+cf).innerHTML='<img src="'+cpath+'"/>'+c3let;
   document.getElementById('flag'+cf).value=ncode;
   if (cf!='add') sete(cf);
   }
  //function closeedit(i,ncode,cpath,c3let)
  function closeedit(ncode,cpath,c3let)
  {closee();
   if ((cf>-1)||(cf=="add")) setflag(cf,ncode,cpath,c3let);
   else for(j=0;j<<?=$n?>;j++) setflag(j,ncode,cpath,c3let);
   }
  req=new Array();

<? 

for ($i=0;$i<$n;$i++) {

?>

  if (window.XMLHttpRequest) req[<?=$i?>] = new XMLHttpRequest(); else if (window.ActiveXObject) req[<?=$i?>] = new ActiveXObject("Microsoft.XMLHTTP");
  if (req[<?=$i?>] != undefined)
  {req[<?=$i?>].onreadystatechange = function()
   {var x,i,ncode,cpath,c3let;
    if (req[<?=$i?>].readyState == 4) // only if req is "loaded"
    {if (req[<?=$i?>].status == 200) // only if "OK"
     {x=req[<?=$i?>].responseXML.getElementsByTagName("flag");
      if (x)
      {ncode=parseInt(x[0].getAttribute("ncode"));
       i=parseInt(x[0].getAttribute("i"));
       //alert(i);
       cpath=x[0].getAttribute("cpath");
       c3let=x[0].getAttribute("c3let");
       setflag(i,ncode,cpath,c3let);
       }
      }
     }
    };
   }

<? 

}

?>

  function seta()
  {var c,n,i,j,s,fl;
   
   <? 

   if ($_GET['add']==1) { 

  ?>
  <?
  
   }else{

  ?>
   
   for (i=0;i<<?=$n?>;i++)
   {c=document.getElementById('cplace'+i).value; fl=1;
    for (j=0,n=jsmf.length;(j<n)&&(fl);j++) if (c.indexOf(jsmf[j][1])!=-1) {setflag(i,jsmf[j][0],jsmf[j][2],jsmf[j][3]); fl=0;}
    if (fl)
    {//if (i==0) alert(cf);
     //alert(i);
     req[i].open("GET", "getflag.php?i="+i+"&cplace="+c, true); req[i].send("");
     }
    }

   <?

   }

   ?>
   
   }
  
function gi(a) {if (a.childNodes[0]) return parseInt(a.childNodes[0].nodeValue); else return '';}
function gs(a) {if (a.childNodes[0]) return a.childNodes[0].nodeValue; else return '';}

function setf(j)
{var x,y; cf=j;
 x=document.getElementById('edit'); x.style.zIndex=3; x.style.display='block'; document.body.style.overflow='hidden';
 if ((j>-1)||(j=="add")) {if (s=document.getElementById('flag'+j).value) {y=document.getElementById('fg'+s); y.className="sel"; pf=s;}}
 
 /*var x, s, n, cl;
 n=jsmf.length;
 x=document.createElement('div'); x.id='edit'; document.body.style.overflow='hidden';
 if (j>-1) s=document.getElementById('flag'+j).value; else s=0;
 x.innerHTML='<table class="main"><tbody><tr><td class="cap">Choose Country <input type=button class=txt value=" Close " onclick="closee()"></td></tr><tr><td id="ph"></td></tr></tbody></table>';
 document.body.appendChild(x);
 x=document.getElementById('ph');
 for(i=0;i<n;i++)
 {if (jsmf[i][0]==s) cl='sel';
                else cl='unsel';
  x.innerHTML+='<span onclick="this.className=\'sel\'; closeedit(\''+j+'\',\''+jsmf[i][0]+'\',\''+jsmf[i][2]+'\',\''+jsmf[i][3]+'\')" class="'+cl+'"><img height=14 width=22 src="'+jsmf[i][2]+'"/>&nbsp;'+jsmf[i][1]+'</span>&nbsp;';
  }*/
 }


  function randsp()
  {

  <?=$jsm?>
  <?

    for ($i=0;$i<=$ng;$i++):

  ?>
   if (n=<?=$ngroup[$i][1]?>)
   {jsm<?=$ngroup[$i][0]?>.sort(function(a, b){return (b[1]==a[1]?0.5 - Math.random():b[1]-a[1])});
    c=<?=$ngroup[$i][2]?>%n; g=(<?=$ngroup[$i][2]?>-c)/n;
    if (g>c)
    {ie=0;
     for(gi=0;gi<g;gi++)
     {var r=new Array();
      ib=ie;j=0;
      if (c) {ie+=n+1;c--;}
       else  ie+=n;
      for(i=ib;i<ie;i++) {r[j++]=jsm<?=$ngroup[$i][0]?>[i];}
      for(i=ib;i<ie;i++) r.sort(function() {return 0.5 - Math.random()});
      j=0;
      for(i=ib;i<ie;i++)
      {el=document.getElementById('o<?=$ngroup[$i][0]?>x'+r[j][0]);
       el.value=i+1;
       el=document.getElementById('g<?=$ngroup[$i][0]?>x'+r[j][0]);
       el.value=gi+1;
       el=document.getElementById('a<?=$ngroup[$i][0]?>x'+r[j][0]);
       el.innerHTML='Group '+(gi+1);
       sete(r[j++][0]);
       }
      }
     }
     else
    {var r=new Array();
     j=0;ie=0;//ie=c;
     for(i=0;i<c;i++) {r[j++]=jsm<?=$ngroup[$i][0]?>[<?=$ngroup[$i][2]?>-i-1];}
     for(i=0;i<c;i++) r.sort(function() {return 0.5 - Math.random()});
     j=0;
     for(i=0;i<c;i++)
     {el=document.getElementById('o<?=$ngroup[$i][0]?>x'+r[j][0]);
      el.value=<?=$ngroup[$i][2]?>-i;
      el=document.getElementById('g<?=$ngroup[$i][0]?>x'+r[j][0]);
      el.value=g+1;
      el=document.getElementById('a<?=$ngroup[$i][0]?>x'+r[j][0]);
      el.innerHTML='Group '+(g+1);
      sete(r[j++][0]);
      }
     for(gi=0;gi<g;gi++)
     {var r=new Array();
      ib=ie;j=0;ie+=n;
      for(i=ib;i<ie;i++) {r[j++]=jsm<?=$ngroup[$i][0]?>[i];}
      for(i=ib;i<ie;i++) r.sort(function() {return 0.5 - Math.random()});
      j=0;
      for(i=ib;i<ie;i++)
      {el=document.getElementById('o<?=$ngroup[$i][0]?>x'+r[j][0]);
       el.value=i+1;
       el=document.getElementById('g<?=$ngroup[$i][0]?>x'+r[j][0]);
       el.value=gi+1;
       el=document.getElementById('a<?=$ngroup[$i][0]?>x'+r[j][0]);
       el.innerHTML='Group '+(gi+1);
       sete(r[j++][0]);
       }
      }
     }
    }
   else
   {var r=new Array();
    for(i=0;i<<?=$ngroup[$i][2]?>;i++) r[i]=i+1;
    for(i=0;i<<?=$ngroup[$i][2]?>;i++) r.sort(function() {return 0.5 - Math.random()});
    for(i=0;i<<?=$ngroup[$i][2]?>;i++)
    {el=document.getElementById('o<?=$ngroup[$i][0]?>x'+jsm<?=$ngroup[$i][0]?>[i][0]);
     el.value=r[i];
     el=document.getElementById('g<?=$ngroup[$i][0]?>x'+jsm<?=$ngroup[$i][0]?>[i][0]);
     el.value='';
     el=document.getElementById('a<?=$ngroup[$i][0]?>x'+jsm<?=$ngroup[$i][0]?>[i][0]);
     el.innerHTML='';
     sete(jsm<?=$ngroup[$i][0]?>[i][0]);
     }
    }


<?

endfor;

?>

   }


function ordersp()
  {

  <?=$jsm?>
  <?

  for ($i=0;$i<=$ng;$i++):

  ?>
   if (n=<?=$ngroup[$i][1]?>)
   {jsm<?=$ngroup[$i][0]?>.sort(function(a, b){return (b[1]==a[1]?0.5 - Math.random():b[1]-a[1])});
    c=<?=$ngroup[$i][2]?>%n; g=(<?=$ngroup[$i][2]?>-c)/n;gi=0;
    if (g>c)
    {for(i=0;i<<?=$ngroup[$i][2]?>;i++)
     {if (gi<=c) {if (i%(n+1)==0) gi++;} else {if ((i-c)%n==0) gi++;}
      el=document.getElementById('o<?=$ngroup[$i][0]?>x'+jsm<?=$ngroup[$i][0]?>[i][0]);
      el.value=i+1;
      el=document.getElementById('g<?=$ngroup[$i][0]?>x'+jsm<?=$ngroup[$i][0]?>[i][0]);
      el.value=gi;
      el=document.getElementById('a<?=$ngroup[$i][0]?>x'+jsm<?=$ngroup[$i][0]?>[i][0]);
      el.innerHTML='Group '+gi;
      sete(jsm<?=$ngroup[$i][0]?>[i][0]);
      }
     }
     else
    {for(i=0;i<<?=$ngroup[$i][2]?>;i++)
     {if (i%n==0) gi++;
      el=document.getElementById('o<?=$ngroup[$i][0]?>x'+jsm<?=$ngroup[$i][0]?>[i][0]);
      el.value=i+1;
      el=document.getElementById('g<?=$ngroup[$i][0]?>x'+jsm<?=$ngroup[$i][0]?>[i][0]);
      el.value=gi;
      el=document.getElementById('a<?=$ngroup[$i][0]?>x'+jsm<?=$ngroup[$i][0]?>[i][0]);
      el.innerHTML='Group '+gi;
      sete(jsm<?=$ngroup[$i][0]?>[i][0]);
      }
     }
    }
   else
   {jsm<?=$ngroup[$i][0]?>.sort(function(a, b){return (b[1]==a[1]?0.5 - Math.random():b[1]-a[1])});
    for(i=0;i<<?=$ngroup[$i][2]?>;i++)
    {el=document.getElementById('o<?=$ngroup[$i][0]?>x'+jsm<?=$ngroup[$i][0]?>[i][0]);
     el.value=i+1;
     el=document.getElementById('g<?=$ngroup[$i][0]?>x'+jsm<?=$ngroup[$i][0]?>[i][0]);
     el.value='';
     el=document.getElementById('a<?=$ngroup[$i][0]?>x'+jsm<?=$ngroup[$i][0]?>[i][0]);
     el.innerHTML='';
     sete(jsm<?=$ngroup[$i][0]?>[i][0]);
     }
    }

<?

endfor;

?>
   }
</script>
</table>
</form>

<?

 //mysql_query('SET group_concat_max_len = 45000;');
 $st=mysql_result(mysql_query('select group_concat(concat("<span class=\"unsel\" id=\"fg",ncode,"\" onclick=\"closeedit(",ncode,",\'",cpath,"\'",",\'",c3let,"\'",")\"><img height=14 width=22 src=\"",cpath,"\"/>&nbsp;",cvalue,"</span>") order by cvalue separator "&nbsp;") from flags'),0);
 echo '<div id="edit" style="z-index:-1; display:none;"><table class="main"><tbody><tr><td class="cap">Choose Country <input type=button class=txt value=" Close " onclick="closee()"></td></tr><tr><td id="ph">
'.$st.'
</td></tr></tbody></table></div>';
 //x=document.createElement('div'); x.id='edit'; document.body.style.overflow='hidden';
 //if (j>-1) s=document.getElementById('flag'+j).value; else s=0;
 //x.innerHTML='<table class="main"><tbody><tr><td class="cap">Choose Country <input type=button class=txt value=" Close " onclick="closee()"></td></tr><tr><td id="ph"></td></tr></tbody></table>';
 //document.body.appendChild(x);
 /*x=document.getElementById('ph');
 for(i=0;i<n;i++)
 {if (jsmf[i][0]==s) cl='sel';
                else cl='unsel';
  x.innerHTML+='<span onclick="this.className=\'sel\'; closeedit(\''+j+'\',\''+jsmf[i][0]+'\',\''+jsmf[i][2]+'\',\''+jsmf[i][3]+'\')" class="'+cl+'"><img height=14 width=22 src="'+jsmf[i][2]+'"/>&nbsp;'+jsmf[i][1]+'</span>&nbsp;';
  }*/


?>
