<?php //:
////////:

require('check.inc');
require('../connect.php');

if ($_SESSION['np']){

  $sth   = '<th>Penalty';
  $qd    = 's.npenalty';
  $qf    = '';
  $qo    = '';
  $ntm   = 1;
  $ntms  = 4;
  $tdres = '';
  $jsm   = '';

} else {

  $r  = mysql_query('Select njshowpen,nplayendsound From title Order By id');
  $sp = mysql_result($r, 0);
  $ps = mysql_result($r, 0, 1);
	
  if ($_GET['skid']){
    $r = mysql_query('Select ifnull(ncategory,0) From skaters where id='. $_GET['skid']);
    $c = mysql_result($r, 0);
  }
	
  $sth = '';
  $i   = 0;
  $qd  = 'm.nvalue';
  $qf  = 'inner join type_marks tm left join marks m on (m.njudge='. $_SESSION['id'] .' and s.id=m.nskater and tm.id=m.ntype)';
  $qo  = ',tm.npos,tm.id';
	$rtm = mysql_query('Select cvalue,id From type_marks Order By npos,id');
	$ntm = mysql_numrows($rtm);

  while ($a = mysql_fetch_row($rtm)){
    $sti[$i++] = $a[1];
    $sth      .= '<th>'. $a[0];
  }
	
  if ($sp) {
    $sth  .= '<th>Sum<th>Penalty';
    $tdres = '<th id="res">&nbsp;<th id="pen">&nbsp;<th id="tot">&nbsp;';
    $ntms  = $ntm+7;
  } else {
    $tdres = '<th id="res">&nbsp;';
    $ntms  = $ntm+5;
  }
	
  $sth .= '<th>Total';
	$jsm  = 'r=new Array();c=new Array();';
}

////////:///////////////////////////////////////////////////////////////////////
?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="../style.css" rel="stylesheet" type="text/css">
<title>Slalom Classic Judgment</title>
<style>
tr.red{background-color:red;}
tr.any{}
tr.any:hover{background-color:#F88017;cursor:pointer;}
</style>
<script type="text/javascript">

<?php //:-----------------------------------------------------------------------
    if ((!$_SESSION['np']) and ($_GET['skid'])) { 
////////: ?> 

var ps = 1;
if (window.XMLHttpRequest) req = new XMLHttpRequest(); else if (window.ActiveXObject) req = new ActiveXObject("Microsoft.XMLHTTP");
if (req != undefined)
 {req.onreadystatechange = function()
  {if (req.readyState == 4) // only if req is "loaded"
   {if (req.status == 200) // only if "OK"
    {x=req.responseXML.getElementsByTagName("skater");
     if (x) {st=x[0].getAttribute('npenalty'); eop=parseInt(x[0].getAttribute('eop'));}
     else {st="&nbsp;"; eop=0;}
     if ((eop)&&(ps)) {ps=0; <?if ($ps) echo 'playSound("911_1245282216.mp3");';?>}
     <?if($sp){?>
     document.getElementById("pen").innerHTML = st;
     pen=parseFloat(document.getElementById("pen").innerHTML);
     res=parseFloat(document.getElementById("res").innerHTML);
     if ((isNaN(pen))||(isNaN(res))) {tot="&nbsp";r[<?=$c?>][cur][1]=-1;} else {tot=res-pen;r[<?=$c?>][cur][1]=tot;}
     document.getElementById("tot").innerHTML=tot;
     sortpl(<?=$c?>);
     <?}?>
     }
    }
   };
  //load();
  }
function load(){req.open("GET", "getpen.php?id=<?=$_GET['skid']?>", true); req.send(""); d=setTimeout("load()",1000);}

<?php //:-----------------------------------------------------------------------
    } else if ($_SESSION['np']) {
////////: ?>

if (window.XMLHttpRequest) req = new XMLHttpRequest(); else if (window.ActiveXObject) req = new ActiveXObject("Microsoft.XMLHTTP");
if (req != undefined)
 {req.onreadystatechange = function()
  {if (req.readyState == 4) // only if req is "loaded"
   {if (req.status == 200) // only if "OK"
    {}
    }
   };
  }
function setstart(s){req.open("GET", "setstart.php?s="+s+"&time="+time+"&id=<?=$_GET['skid']?>", true); req.send("");}

<?php //:-----------------------------------------------------------------------
    }
////////: ?>

</script>
</head>
<body>
<center>Judgment Panel<br>

<?php //:
////////:-----------------------------------------------------------------------

$r = mysql_query('Select s.id,s.nnumber,s.cname,s.cname_local,s.dbday,s.cplace,s.norder,'.$qd.',s.ngroup,c.cvalue,ifnull(c.id,0),s.npenalty,date_add(coalesce(ttimeb,now()),interval coalesce(ttimel,100) second)<now(),concat("<image src=\"",f.cpath,"\">",f.c3let)
		 From skaters s '.$qf.' left join categories c on (s.ncategory=c.id) left join flags f on (s.nflag=f.ncode)
		 Order By c.npos,c.id,s.norder,s.id'.$qo);

if ($st=mysql_error()) echo $st;
//echo '<table border=1 class=txt cellspacing=0 cellpadding=2><th>#<th>Skater<th>Group'.$sth.'</th>'; 
//for($i=0;$i<$n;$i++)
$ncat = -1;
$ci   = 0;

while ($a=mysql_fetch_row($r)){
  if ($ncat!=$a[10]){
    $si=0;
    if ($ncat!=-1) {
      echo '</table><br>';
    }
  
  //echo '<br><a id="c'.$a[10].'">'.$a[9].'</a><br><table id='.$a[10].' border=1 class=txt cellspacing=0 cellpadding=2><tr><th>#<th>Skater<th>Group'.$sth.($a[10]==$c?'<th>Place':'').'</th>';
  echo '<br><a id="c'. $a[10] .'">'. $a[9] .'</a><br><table id='. $a[10] .' border=1 class=txt cellspacing=0 cellpadding=2><tr><th>#<th>Skater<th>Group'. $sth . (!$_SESSION['np'] ? '<th>Place' : '') .'</th>';
  
  $ncat = $a[10];
  $jsm .= 'r['. $a[10] .']=new Array(); c['.$ci++.']='.$a[10].';';
  }
  
  echo '<tr valign=middle ';
  
  if ($a[0]==$_GET['skid']){
  
    echo 'class="red"'; 
    $spj = ($a[12] ? 'ps=0;' : '');
  
  } elseif (!isset($a[7])) echo 'class="any" onclick="window.open(\'judge.php?skid='.$a[0].'#c'.$a[10].'\',\'_self\');"';
  
  echo '><td>'. (isset($a[6]) ? $a[6] : '&nbsp;') .'<td>'.($a[13]?$a[13].' ':'').$a[2].($a[3]?' ('.$a[3].')':'').($a[5]?' ('.$a[5].')':'').'<td>'.($a[8]?'Group '.$a[8]:'&nbsp;').'</td>';//.($a[1]?$a[1].'. ':'')
  
  if (($a[0] == $_GET['skid']) and (!isset($a[7]))){
    echo '<form name=judges method=post action=judge_add.php enctype=multipart/form-data><span id="dummy"></span><input type=hidden name=skid value='.$_GET['skid'].'><input type=hidden name="c" value='.$a[10].'>';
    $jsm .= 'r['. $a[10] .']['. $si .']=['. $a[0] .',-1];cur='. $si .';';
    
    for ($i=0;$i<$ntm;$i++) echo '<td><input type=hidden name=ntype['.$i.'] value='.$sti[$i].'><input type=text id="i'.$i.'" class=txt name=mark['.$i.'] value="" onkeyup="s['.$i.']=(this.value==\'\'?0:1); testok();" onchange="s['.$i.']=(isNaN(this.value)?0:1); testok();" onkeypress="return numbersonly(event);">';
    for ($i=1;$i<$ntm;$i++) mysql_fetch_row($r);
    
    echo $tdres.(!$_SESSION['np']?'<th id="p'.$_GET['skid'].'">&nbsp;':'').'<tr><td align=center colspan='.$ntms.'><input type=submit name=subbut class=txt disabled value=" Save "></form>';

////////: ?>

<script type="text/javascript">
  var s=new Array();
  var state=0,time=100,t,tb,cur=<?=$a[0]?>;
  for(i=0;i<<? echo $ntm;?>;i++) s[i]=0;
  document.getElementById('i0').focus();
  
  function numbersonly(e)
    {var unicode=e.charCode? e.charCode : e.keyCode;
     target = (e.target) ? e.target : e.srcElement;
     if ((unicode!=8) && (unicode!=9) && (unicode!=46) && ((unicode<48) || (unicode>57)) && ((unicode>40) || (unicode<37)) ) return false;
      else if ((unicode==46) && (target.value.indexOf(".")!=-1)) return false;
     }
  function testok()
  {fl=0; i=0; res=0;tot=0;
   while((i<<? echo $ntm;?>) && (fl==0))
   {res+=parseFloat(document.getElementById('i'+i).value);
    if (s[i++]==0) fl=1;
    }
   if (fl==0) 
   {

<?php //:
////////:-----------------------------------------------------------------------

    if (!$_SESSION['np']) {
      echo 'document.getElementById("res").innerHTML=res;';
      if ($sp) echo 'pen=parseFloat(document.getElementById("pen").innerHTML);
		       if (isNaN(pen)) {tot="&nbsp"; r['.$c.']['.$si.'][1]=-1;}
			else {tot=res-pen;r['.$c.']['.$si.'][1]=tot;}
		       document.getElementById("tot").innerHTML=tot;'; 
        
        else echo 'r['.$c.']['.$si.'][1]=res;';
        echo 'sortpl('.$c.');';
        }

////////: ?>

    document.judges.subbut.disabled=false;
    }
   else 
   {document.judges.subbut.disabled=true; 
    
<?php //:
////////:-----------------------------------------------------------------------

    if (!$_SESSION['np']) 
       {echo 'document.getElementById("res").innerHTML="&nbsp;";';
        if($sp) echo 'document.getElementById("tot").innerHTML="&nbsp;";r['.$c.']['.$si.'][1]=-1;';
        else echo 'r['.$c.']['.$si.'][1]=-1;';
        echo 'sortpl('.$c.');';
        }

////////: ?>

    }
   }
  function timer()
  {tb=document.getElementById('timerbut');
   if (state==0)
   {state=1; tb.value=' Pause ';
    setstart(1);
    starttimer();
    }
   else if (state==1)
   {state=0; tb.value=' Start ';
    setstart(0);
    stoptimer();
    }
   }
  function starttimer()
  {if (--time==-10)
   {clearTimeout(t); state=0; time=100; tb.value=' Start ';
    document.getElementById('timerpad').innerHTML='<font color=red>-10 sec</font>';
    }
    else
   {if (time==0) playSound('911_1245282216.mp3');
    document.getElementById('timerpad').innerHTML=time+' sec';
    t=setTimeout('starttimer()',1000);
    }
   }
  function stoptimer()
  {clearTimeout(t);
   if (time>20) document.getElementById('timerpad').innerHTML='<font color=red>'+time+' sec</font>';
    else document.getElementById('timerpad').innerHTML=time+' sec';
   }
  function cleartimer()
  {clearTimeout(t); state=0; time=100; tb.value=' Start ';
   document.getElementById('timerpad').innerHTML='100 sec';
   }

  function getMimeType(agt)
  {var mimeType = "application/x-mplayer2"; //default
   //if (navigator.mimeTypes && agt.indexOf("windows")==-1) if (navigator.mimeTypes["audio/mpeg"].enabledPlugin) mimeType="audio/mpeg";
   return mimeType
   }
  function playSound(soundfile)
  {mimeType = getMimeType(navigator.userAgent.toLowerCase());
   document.getElementById('dummy').innerHTML='<embed src="'+soundfile+'" type="'+mimeType+'" hidden="true" autostart="true" loop="false" />';
   }
  
</script>


<?php //:
////////:-----------------------------------------------------------------------
   
   } else {

    echo '<td>'.(isset($a[7])?$a[7]:'&nbsp;');
   
    if (!$_SESSION['np']) {
      unset($total);
    
      if (isset($a[7])) $total=$a[7];
    
      for ($y=0;$y<$ntm-1;$y++) {
        $a=mysql_fetch_row($r);
        echo '<td>'.(isset($a[7])?$a[7]:'&nbsp;');
        if (isset($a[7])) $total+=$a[7];
      }
      
      echo '<td>'.(isset($total)?str_replace(',','.',$total):'&nbsp;');
      
      if ($sp) echo '<td>'. (isset($a[11]) ? $a[11] : '&nbsp;') .'<td>'. (((isset($total)) and (isset($a[11]))) ? str_replace(',', '.', $total-$a[11]) : '&nbsp;');
      
      //if ($c==$a[10]) {$jsm.='r['.$si.']=['.$a[0].','.($sp?(((isset($total))and(isset($a[11])))?str_replace(',','.',$total-$a[11]):'-1'):(isset($total)?str_replace(',','.',$total):'-1')).'];'; echo '<td align=center id="p'.$a[0].'">&nbsp;';}

      {
        $jsm .= 'r['. $a[10] .']['. $si .']=['. $a[0] .','.($sp ? (((isset($total)) and (isset($a[11]))) ? str_replace(',', '.', $total-$a[11]) : '-1') : (isset($total) ? str_replace(',', '.', $total) : '-1')) .'];';
        echo '<td align=center id="p'. $a[0] .'">&nbsp;';
      }
    }
  }
  $si++;
}

echo '</table><br>';

if (($_SESSION['np']) and ($_GET['skid'])) {
  echo '<div style="position: fixed; right: 20px;top: 20px;border: solid black 1px;padding: 5px;-moz-border-radius: 6px;-khtml-border-radius: 6px;-webkit-border-radius: 6px;background: #DDD;"><span id="dummy"></span>Timer<br><a id="timerpad">100 sec</a><br><input id="timerbut" type=button value=" Start " onclick="timer();">&nbsp;<input type=button value=" Reset " onclick="cleartimer();"></div>';
}

////////: ?>

<script type="text/javascript">

<?php //:
////////:-----------------------------------------------------------------------

if ((!$_SESSION['np']) and ($_GET['skid'])) echo 'load();';
if (!$_SESSION['np']){

  echo $jsm.$spj; 

////////: ?>

function sortpl(ci)
  {ri=r[ci].slice();prev=-1;k=0;
   ri.sort(function(a, b){return b[1]-a[1];});
   var n=ri.length;
   for(var i=0;i<n;i++)
   {if (ri[i][1]!=-1)
    {if (ri[i][1]==prev){k++;document.getElementById('p'+ri[i][0]).innerHTML=i+1-k;}
     else {prev=ri[i][1]; k=0; document.getElementById('p'+ri[i][0]).innerHTML=i+1;}
     }
    else document.getElementById('p'+ri[i][0]).innerHTML='&nbsp;';
    }
   }
for (var i=0;i<<?=$ci?>;i++) {sortpl(c[i]);}

<?php //:
////////:-----------------------------------------------------------------------
    }
////////: ?>
</script>

<br><input type=button value="Exit from Judgment Panel" onclick="window.open('index.php?exit=1','_self');">
</center>

<script type="text/javascript">
var el=document.createElement("input"),fls='';
if (typeof el.checkValidity!="function") {fls+="Your browser doesn't support validation!<br>";}
el.setAttribute('oninput', 'return;');
if (typeof el.oninput!="function") {fls+='Your browser doesn\'t support "oninput"!<br>';}
el.setAttribute('required', 'required');
if (typeof el.required!="boolean") {fls+='Your browser doesn\'t support "required" attribute!<br>';}
el.setAttribute('pattern', '.+');
if (typeof el.pattern!="string") {fls+='Your browser doesn\'t support "pattern" attribute!<br>';}
if (typeof el.validity!="object") {fls+='Your browser doesn\'t support "validity" object!<br>';}
if (typeof el.validity.patternMismatch!="boolean") {fls+='Your browser doesn\'t support "validity.patternMismatch" property!<br>';}
if (fls)
{var x=document.createElement('div'); x.id='edit'; document.body.style.overflow='hidden';
 x.innerHTML='<br><br><br><table class="main"><tr><td>'+fls+'<tr><td style="color: red;">You need to use another browser.</td></table>';
 document.body.appendChild(x);
 }
</script>

</body>
</html>
