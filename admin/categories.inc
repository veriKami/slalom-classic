<b><a class=txt>Categories</a></b>

<?php //:
////////:-----------------------------------------------------------------------

if ($_GET['add']!=1) {
  echo '<br><input type=button value=" Add " class=txt onclick="window.open(\'admin.php?mode=categories&add=1\',\'_self\');">'; $std='';
} else {
  $std=' disabled';
}

////////: ?>

<table class=txt cellspacing=1 cellpadding=1 border=1>
<th>#<th>Name<th>Position<th>Count of skaters in each subgroup<th>Operation</th>
<form name=categories method=post action=categories.php>
<input type=hidden name=delid value="">

<?php //:
////////:-----------------------------------------------------------------------

  $r = mysql_query('Select id,cvalue,npos,ngroup From categories Order By npos,id');
  $n = mysql_numrows($r);
  
  for($i=0;$i<$n;$i++){
    $a=mysql_fetch_row($r);
    echo '<tr><td>'.$a[0].'</td><td><input type=hidden name=id['.$i.'] value='.$a[0].'>
<input type=text'.$std.' name=cvalue['.$i.'] size=20 maxlength=250 class=txt value="'.$a[1].'" required data-errormessage="Can\'t be empty" x-moz-errormessage="Can\'t be empty" oninput="if (this.value==\'\') this.setCustomValidity(\'Cant be empty\'); else this.setCustomValidity(\'\');"></td>
<td><input type=text'.$std.' name=npos['.$i.'] size=4 maxlength=4 class=txt value="'.$a[2].'" pattern="\-?\d+(\.\d{0,})?" oninput="if (isNaN(this.value)) this.setCustomValidity(\'Invalid number format\'); else this.setCustomValidity(\'\');" data-errormessage="Invalid number format" x-moz-errormessage="Invalid number format"></td>
<td><input type=text'.$std.' name=ngroup['.$i.'] size=4 maxlength=3 class=txt value="'.$a[3].'" pattern="[0-9]+" oninput="if (isNaN(this.value)) this.setCustomValidity(\'Invalid number format\'); else this.setCustomValidity(\'\');" data-errormessage="Invalid number format" x-moz-errormessage="Invalid number format"></td>
<td><input type=submit'.$std.' class=txt value=" Delete " onclick="document.categories.delid.value='.$a[0].';"></td></tr>';
   }

  if ($_GET['add']){
    echo '<input type=hidden name=add value="1"><tr><td></td>
<td><input type=text name=cvalueadd size=20 maxlength=250 class=txt value="" required data-errormessage="Can\'t be empty" x-moz-errormessage="Can\'t be empty" oninput="if (this.value==\'\') this.setCustomValidity(\'Cant be empty\'); else this.setCustomValidity(\'\');"></td>
<td><input type=text name=nposadd size=4 maxlength=4 class=txt value="" pattern="\-?\d+(\.\d{0,})?" oninput="if (isNaN(this.value)) this.setCustomValidity(\'Invalid number format\'); else this.setCustomValidity(\'\');" data-errormessage="Invalid number format" x-moz-errormessage="Invalid number format"></td>
<td><input type=text name=ngroupadd size=4 maxlength=3 class=txt value="" pattern="[0-9]+" oninput="if (isNaN(this.value)) this.setCustomValidity(\'Invalid number format\'); else this.setCustomValidity(\'\');" data-errormessage="Invalid number format" x-moz-errormessage="Invalid number format"></td>
<td></td></tr>';
   }

  echo '<tr><td colspan=5 align=center><input type=submit name=subbut class=txt value=" Save "></td></tr>';

////////: ?>

<script type="text/javascript">

<?php //:
////////:-----------------------------------------------------------------------

if ($_GET['add']==1) echo ' document.categories.cvalueadd.focus();';

////////: ?>

</script>
</form>
</table>
