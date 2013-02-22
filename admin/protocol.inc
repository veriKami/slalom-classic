<?php //:
////////:-----------------------------------------------------------------------

if (isset($_GET['ncat'])) {
  $_GET['ncat']=intval($_GET['ncat']); 
  $sc='&ncat='.$_GET['ncat'];
} else {
  $sc='';
}

/**
* Function
*/
function ec($i,$k){
  global $mc,$so,$cc; 
  if ($k==$mc[$i][0]) {
    $cat='sel'; 
    $cc=$mc[$i][1];
  } else $cat='unsel';
 echo '<li class="'.$cat.'"><a href="admin.php?mode=protocol&ncat='.$mc[$i][0].$so.'">'.$mc[$i][1].'('.$mc[$i][2].')</a></li>';
}

$rc = mysql_query('Select c.id,c.cvalue,count(s.id) From categories c left join skaters s on(s.ncategory=c.id) group by c.id Order By c.npos,c.id'); 
$ncat=mysql_numrows($rc);

if ($ncat)
{//echo '<table class=catt border=0 cellpading=0 cellspacing=0><tr>';
 echo '<ul class="catt">';
 $r=mysql_query('Select count(*) From skaters');
 //$mc[-2][0]=-1; $mc[-2][1]='All'; $mc[-2][2]=mysql_result($r,0);
 $r=mysql_query('Select count(id) From skaters where ncategory is null');
 $mc[-1][0]=0; $mc[-1][1]='Without Category'; $mc[-1][2]=mysql_result($r,0);
 //ec(-2,(isset($_GET['ncat'])?$_GET['ncat']:-1));
 ec(-1,(isset($_GET['ncat'])?$_GET['ncat']:-1));
 for($i=0;$i<$ncat;$i++) {$mc[$i]=mysql_fetch_row($rc); ec($i,(isset($_GET['ncat'])?$_GET['ncat']:-1));}
 //echo '<tr><td class="main" colspan='.($ncat+2).'>';
 echo '</ul>';
 if (($_GET['ncat']==-1)or(!isset($_GET['ncat']))) $scq='';
 else if ($_GET['ncat']==0) $scq=' where c.id is null';
  else $scq=' where c.id='.$_GET['ncat'];

 /*$r=mysql_query('Select c.id,ifnull(c.ngroup,0),count(s.id) From categories c left join skaters s on(s.ncategory=c.id)'.$scq.' group by c.id Order By c.npos,c.id');
 if ($st=mysql_error()) echo $st;
 $jsm='jsm0=new Array();jsmi0=0;'; $ng=mysql_numrows($r);
 for($i=0;$i<$ng;$i++){$a=mysql_fetch_row($r); $ngroup[$i]=$a; $jsm.='jsm'.$a[0].'=new Array();jsmi'.$a[0].'=0;';}
 if (($_GET['ncat']==-1)or(!$_GET['ncat']))
 {$r=mysql_query('Select ifnull(ngroup,0) From title Order By id'); $ngroup[$i][0]=0; $ngroup[$i][1]=mysql_result($r,0);
  $r=mysql_query('Select count(id) From skaters where ncategory is null'); $ngroup[$i][2]=mysql_result($r,0);
  }
 else $ng=0;*/
 }
else
 {//$scq='';$jsm='jsm0=new Array();jsmi0=0;'; $ng=0;
  }

if (isset($_GET['ncat'])) {

$r=mysql_query('Select cname,cftpfile,ngroup,cplace,DATE_FORMAT(ddate, "%d.%m.%Y"),cdiscip,ccategory,ntype,nflag,nnumber,nname,nname_local,nplace,nteam From title Order By id');
$t=mysql_fetch_row($r);

if ($t[0]) {$st='<div class=txt20 style="font-weight:700;">'.$t[0].'</div><div class=txt14>'.$t[3].($t[4]?', '.$t[4]:'').'<br>'.$t[5].', '.$cc.'</div>';}
$t=time();

////////: ?>

<script type="text/javascript">
var t=<?=$t?>,t2=<?=$t?>,req,req2,fl=1;;
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
       if (((!isNaN(g))&&(g>t))||(fl))
       {y=document.getElementById("t"); y.innerHTML = x.substring(0,b); t=g; fl=0;
        document.getElementById("th").innerHTML='<th>Rank<th>Skater ID<th>Skater<th id="cr">Country(Region)<th id="c">Country<th id="r">Region';
        yy=document.getElementById("tt"); n=yy.rows.length-1;
        if(document.getElementById("ncr").checked==false)
        {j=document.getElementById("cr").cellIndex;
         for (i=n; i >= 0; i--) yy.rows[i].deleteCell(j);
         }
        if(document.getElementById("nc").checked==false)
        {j=document.getElementById("c").cellIndex;
         for (i=n; i >= 0; i--) yy.rows[i].deleteCell(j);
         }
        if(document.getElementById("nr").checked==false)
        {j=document.getElementById("r").cellIndex;
         for (i=n; i >= 0; i--) yy.rows[i].deleteCell(j);
         }
        }
       }
      }
     }
    }
   };
  load();
  //d=setTimeout("load()",2000);
  }

function load() {
  req.open("GET", "../fp<?php //:
////////:-----------------------------------------------------------------------

    print $_GET['ncat']

////////: ?>.html?t="+new Date().getTime(), true); 
  req.send(""); d=setTimeout("load()",2000);}

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
  load2();
  }

function load2()
 {req2.open("GET", "../ch.html?t="+new Date().getTime(), true); req2.send("");
  d2=setTimeout("load2()",60000);
  }

</script>

<input class=txt type=checkbox id="ncr" value=1 checked onclick="fl=1; load();"><label class=txt for="ncr">&nbsp;Country (Region)</label>&nbsp;<input class=txt type=checkbox id="nc" value=1 onclick="fl=1; load();"><label class=txt for="nc">&nbsp;Country</label>&nbsp;<input class=txt type=checkbox id="nr" value=1 onclick="fl=1; load();"><label class=txt for="nr">&nbsp;Region</label>
<table id="tt" border=1 class=txt cellspacing=0 cellpadding=2><caption><?=$st?></caption><tr id="th"><th>Rank<th>Skater ID<th>Skater<th id="cr">Country(Region)<th id="c">Country<th id="r">Region<tbody id="t"></table>


<?php //:
////////:-----------------------------------------------------------------------
    }
////////: ?>
