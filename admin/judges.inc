<center><b><a class=txt>Judges</a></b></center>
<form name=judges method=post action=judges.php enctype=multipart/form-data>

<?php //:
////////:-----------------------------------------------------------------------

if ($_GET['add']!=1) {echo '<input type=hidden name=delid value=""><br><input type=button value=" Add " class=txt onclick="window.open(\'admin.php?mode=judges&add=1\',\'_self\');">';$std='';}
    else {$std=' disabled';}

////////: ?>

<table class=txt cellspacing=1 cellpadding=1 border=1>
<th>#<th>Number(login)<a href=admin.php?mode=judges&sort=2>\/</a><th>Name <a href=admin.php?mode=judges&sort=3>\/</a><th>Name(local) <a href=admin.php?mode=judges&sort=4>\/</a><th>Is penalty judge?<th>Password<th>Operation</th>

<?php //:
////////:-----------------------------------------------------------------------

  $r=mysql_query('Select id,nnumber,cname,cname_local,npenalty,cpass From judges Order By '.($_GET['sort']?$_GET['sort']:'nnumber,id'));
  if ($st=mysql_error()) echo $st;
  
  $n=mysql_numrows($r); $ni=0;
  
  for($i=0;$i<$n;$i++){
    $a=mysql_fetch_row($r);
    echo '<input type=hidden name=id['.$i.'] value='.$a[0].'><tr><td>'.$a[0].'</td>
<td><input type=text'.$std.' name=nnumber['.$i.'] size=10 maxlength=20 class=txt value="'.$a[1].'" required pattern="[0-9]+" oninput="if (isNaN(this.value)) this.setCustomValidity(\'Invalid number format\'); else this.setCustomValidity(\'\');" data-errormessage="Invalid number format" x-moz-errormessage="Invalid number format"></td>
<td><input type=text'.$std.' name=cname['.$i.'] size=20 maxlength=250 class=txt value="'.$a[2].'" required data-errormessage="Can\'t be empty" x-moz-errormessage="Can\'t be empty" oninput="if (this.value==\'\') this.setCustomValidity(\'Cant be empty\'); else this.setCustomValidity(\'\');"></td>
<td><input type=text'.$std.' name=cname_local['.$i.'] size=20 maxlength=250 class=txt value=""></td>
<td align=center><input type=radio'.$std.' name=npenalty value='.$i.($a[4]?' checked':'').'></td>
<td><input type=text'.$std.' name=cpass['.$i.'] size=20 maxlength=250 class=txt value="'.$a[5].'" required data-errormessage="Can\'t be empty" x-moz-errormessage="Can\'t be empty" oninput="if (this.value==\'\') this.setCustomValidity(\'Cant be empty\'); else this.setCustomValidity(\'\');"></td>
<td><input type=submit'.$std.' class=txt value=" Delete " onclick="document.judges.delid.value='.$a[0].';"></td></tr>';
   }
  
  if ($_GET['add']){
    $ni=0; 
    echo '<input type=hidden name=add value="1"><tr><td></td>
<td><input type=text name=nnumberadd size=10 maxlength=20 class=txt value="" required pattern="[0-9]+" oninput="if (isNaN(this.value)) this.setCustomValidity(\'Invalid number format\'); else this.setCustomValidity(\'\');" data-errormessage="Invalid number format" x-moz-errormessage="Invalid number format"></td>
<td><input type=text name=cnameadd size=20 maxlength=250 class=txt value=""required data-errormessage="Can\'t be empty" x-moz-errormessage="Can\'t be empty" oninput="if (this.value==\'\') this.setCustomValidity(\'Cant be empty\'); else this.setCustomValidity(\'\');"></td>
<td><input type=text name=cname_localadd size=20 maxlength=250 class=txt value=""></td>
<td align=center><input type=radio name=npenaltyadd class=txt value="0" disabled title="Unavailable until is saved"></td>
<td><input type=text name=cpassadd size=20 maxlength=250 class=txt value="" required data-errormessage="Can\'t be empty" x-moz-errormessage="Can\'t be empty" oninput="if (this.value==\'\') this.setCustomValidity(\'Cant be empty\'); else this.setCustomValidity(\'\');"></td>
<td></td></tr>';
   }
  echo '<tr><td colspan=8 align=center><input type=submit name=subbut class=txt value=" Save "></td></tr>';

////////: ?>

<script type="text/javascript">
<?php //:
////////:-----------------------------------------------------------------------

if ($_GET['add']==1) echo 'document.judges.nnumberadd.focus();';

////////: ?>
</script>
</table>
</form>
