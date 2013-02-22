<b><a class=txt>Types of Marks</a></b>
<? if ($_GET['add']!=1) {echo '<br><input type=button value=" Add " class=txt onclick="window.open(\'admin.php?mode=type_marks&add=1\',\'_self\');">'; $std='';}
    else $std=' disabled';?>
<table class=txt cellspacing=1 cellpadding=1 border=1>
<th>#<th>Name<th>Position<th>Operation</th>
<form name=type_marks method=post action=type_marks.php>
<input type=hidden name=delid value="">
<?
  $r=mysql_query('Select id,cvalue,npos From type_marks Order By npos,id');
  $n=mysql_numrows($r);
  for($i=0;$i<$n;$i++)
  {$a=mysql_fetch_row($r);
   echo '<tr><td>'.$a[0].'</td><td><input type=hidden name=id['.$i.'] value='.$a[0].'>
<input type=text'.$std.' name=cvalue['.$i.'] size=20 maxlength=250 class=txt value="'.$a[1].'" required data-errormessage="Can\'t be empty" x-moz-errormessage="Can\'t be empty" oninput="if (this.value==\'\') this.setCustomValidity(\'Cant be empty\'); else this.setCustomValidity(\'\');"></td>
<td><input type=text'.$std.' name=npos['.$i.'] size=4 maxlength=4 class=txt value="'.$a[2].'" pattern="\-?\d+(\.\d{0,})?" oninput="if (isNaN(this.value)) this.setCustomValidity(\'Invalid number format\'); else this.setCustomValidity(\'\');" data-errormessage="Invalid number format" x-moz-errormessage="Invalid number format"></td>
<td><input type=submit'.$std.' class=txt value=" Delete " onclick="document.type_marks.delid.value='.$a[0].';"></td></tr>';
   }
  if ($_GET['add'])
  {echo '<input type=hidden name=add value="1"><tr><td></td>
<td><input type=text name=cvalueadd size=20 maxlength=250 class=txt value="" required data-errormessage="Can\'t be empty" x-moz-errormessage="Can\'t be empty" oninput="if (this.value==\'\') this.setCustomValidity(\'Cant be empty\'); else this.setCustomValidity(\'\');"></td>
<td><input type=text name=nposadd size=4 maxlength=4 class=txt value="" pattern="\-?\d+(\.\d{0,})?" oninput="if (isNaN(this.value)) this.setCustomValidity(\'Invalid number format\'); else this.setCustomValidity(\'\');" data-errormessage="Invalid number format" x-moz-errormessage="Invalid number format"></td>
<td></td></tr>';
   }
  echo '<tr><td colspan=4 align=center><input type=submit name=subbut class=txt value=" Save "></td></tr>';
?>

<script type="text/javascript">
<? if ($_GET['add']==1) echo ' document.type_marks.cvalueadd.focus();';?>
</script>
</form>
</table>
