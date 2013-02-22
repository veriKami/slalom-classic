<center><b><a class=txt>Configuration</a></b></center>
<form name=config method=post action=title.php enctype=multipart/form-data>
<? $r=mysql_query('Select id,cname,ngroup,cftpfile,cplace,DATE_FORMAT(ddate, "%d.%m.%Y"),cdiscip,ccategory,ntype,njshowpen
                   ,coalesce(nname,1), nname_local, nplace, nteam, nnumber, nflag,nplayendsound From title Order By id');
   if ($st=mysql_error()) echo $st;
   $n=mysql_numrows($r);
   if ($n>1) {echo 'Configuration corrupt';}
   else 
   {$n=0;
    $sel[$n++]='result of all judges';
    $sel[$n++]='result without min and max judges';
    /*$sel[$n++]='result of all judges with rating of place';
    $sel[$n++]='result without min and max judges with rating of place';*/
    $a=mysql_fetch_row($r);    
    echo '<table class=txt border=0 cellspacing=0 cellpadding=0><tr><td><input type=hidden name=id value='.$a[0].'><input type=hidden name=refresh value=0>Title of competition<td><input type=text name=cname size=40 maxlength=250 class=txt value="'.htmlspecialchars($a[1]).'" required data-errormessage="Can\'t be empty" x-moz-errormessage="Can\'t be empty" oninput="if (this.value==\'\') this.setCustomValidity(\'Cant be empty\'); else this.setCustomValidity(\'\');"></td>
<tr><td>Place of competition<td><input type=text name=cplace size=40 maxlength=250 class=txt value="'.htmlspecialchars($a[4]).'"></td>
<tr><td>Date<td><input type=text id="datepicker" name=ddate size=10 maxlength=10 class=txt value="'.$a[5].'" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01]).(0[1-9]|1[012]).[0-9]{4}" oninput="if (!isdate(this)) this.setCustomValidity(\'Incorrect date format\'); else this.setCustomValidity(\'\');" data-errormessage="Incorrect date format" x-moz-errormessage="Incorrect date format"></td>
<tr><td>Name of discipline<td><input type=text name=cdiscip size=40 maxlength=250 class=txt value="'.htmlspecialchars($a[6]).'"></td>
<tr><td>Category<td><input type=text name=ccategory size=40 maxlength=250 class=txt value="'.htmlspecialchars($a[7]).'"></td>
<tr><td>Count of skaters in each subgroup<td><input type=text name=ngroup size=4 maxlength=2 class=txt value="'.$a[2].'" pattern="[0-9]+" oninput="if (isNaN(this.value)) this.setCustomValidity(\'Invalid number format\'); else this.setCustomValidity(\'\');" data-errormessage="Invalid number format" x-moz-errormessage="Invalid number format"></td>
<tr><td>Path to ftp file<td><input type=text name=cftpfile size=40 maxlength=250 class=txt value="'.$a[3].'"></td>
<tr><td>Type of result<td><select name=ntype class=txt>';
    for ($i=0;$i<$n;$i++) echo '<option value='.$i.($a[8]==$i?' selected':'').'>'.$sel[$i].'</option>';
    echo '</select></td>
<tr><td><label for="nj">Show penalties in judge panel</label><td><input type=checkbox id="nj" name=njshowpen value=1'.($a[9]?' checked':'').'></td>
<tr><td><label for="ps">Play sound on end of performance in judge panel</label><td><input type=checkbox id="ps" name=nps value=1'.($a[16]?' checked':'').'></td>
<tr><td>Show data in results
    <td><input type=checkbox id="nf" name=nflag value=1'.($a[15]?' checked':'').'><label for="nf">&nbsp;Country</label>
  &nbsp;<input type=checkbox id="nnum" name=nnumber value=1'.($a[14]?' checked':'').'><label for="nnum">&nbsp;Number</label>
  &nbsp;<input type=checkbox id="nn" name=nname value=1'.($a[10]?' checked':'').' onclick="this.checked=true;"><label for="nn">&nbsp;Name</label>
  &nbsp;<input type=checkbox id="nln" name=nnamel value=1'.($a[11]?' checked':'').'><label for="nln">&nbsp;Local Name</label>
  &nbsp;<input type=checkbox id="np" name=nplace value=1'.($a[12]?' checked':'').'><label for="np">&nbsp;Place</label>
  &nbsp;<input type=checkbox id="nt" name=nteam value=1'.($a[13]?' checked':'').'><label for="nt">&nbsp;Team</label>
    </td>
<tr><td colspan=2><input type=submit name=subbut class=txt value=" Save " onclick="document.forms[0].refresh.value=0;"> <input type=submit class=txt value="Refresh index" onclick="document.forms[0].refresh.value=1;">';
    }
?>
<link type="text/css" href="jquery/css/smoothness/jquery-ui-1.8.9.custom.css" rel="Stylesheet" />	
<script type="text/javascript" src="jquery/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="jquery/js/jquery-ui-1.8.9.custom.min.js"></script>
<script>
	$(function() {
		$( "#datepicker" ).datepicker({
			dateFormat: 'dd.mm.yy',
			constrainInput: true,
			gotoCurrent: true,
			autoSize: true,
			showOn: "button",
			firstDay: 1,
			selectOtherMonths: true,
			showOtherMonths: true
		});
	});
</script>
<script type="text/javascript">
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
</script>
</form>
