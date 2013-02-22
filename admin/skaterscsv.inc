<b><a class=txt>Skaters - Import from CSV</a></b>
<form name=skaters method=post action=skaters.php enctype=multipart/form-data>
<br><a class=txt>CSV-file format:Name;Birthday;Place;Rating;Number;Country;Team;</a><br><a class=txt>There Birthday is dd.mm.yyyy</a><br>
<input type=file name=csvfile class=txt onchange="chlabtext(this.value);">
<input type=submit name=subbut class=txt disabled value=" Save ">
<script type="text/javascript">
function chlabtext(st)
{if (st=="") document.skaters.subbut.disabled=true;
     else document.skaters.subbut.disabled=false;
 }
</script>
</table>
</form>
