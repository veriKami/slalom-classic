<?php //:
////////:

require('check.inc');
require('../connect.php');

////////:///////////////////////////////////////////////////////////////////////
?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="../style.css" rel="stylesheet" type="text/css">
<title>Slalom Classic</title>
</head>
<body>

<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="5" align="center">
 <tr>
  <td width="80" height="100%" valign="top">
   <table width="100%" cellspacing=2 cellpadding=4  bgcolor="CFCECE" rules="rows" style="border:1px solid gray;"4>
    <tr><td nowrap><a class=menu href=admin.php?mode=title>Configuration</a></td></tr>
    <tr><td nowrap><a class=menu href=admin.php?mode=skaters>Skaters</a></td></tr>
    <tr><td nowrap><a class=menu href=admin.php?mode=judges>Judges</a></td></tr>
    <tr><td nowrap><a class=menu href=admin.php?mode=categories>Categories</a></td></tr>
    <tr><td nowrap><a class=menu href=admin.php?mode=type_marks>Type of Marks</a></td></tr>
    <tr><td nowrap><a class=menu href=admin.php?mode=correction>Manual Correction</a></td></tr>
    <tr><td nowrap><a class=menu href=admin.php?mode=protocol>Final Protocol</a></td></tr>
   </table>
  </td>
  <td height="100%" valign="top">

<?php //:
////////:-----------------------------------------------------------------------

echo '<table width="100%" border=0 cellspacing=0 cellpadding=0>
<tr bgcolor="#CFCECE"><td width="50%" align=left class=txt><b>Admin panel</b></td>
<td width="50%" align=right class=txt><a href="../index.html" target=top>Results</a>&nbsp;</td>
<tr><td colspan=2 class=txt>';

if (isset($_GET['mode'])){
  require($_GET['mode'] .'.inc');
} else if (isset($_SESSION['msg'])){
  echo "<span class='new'>{$_SESSION['msg']}</span>"; 
  unset($_SESSION['msg']);
}

echo '</td></tr>
</table>';

////////: ?>

  </td>
 </tr>
</table>
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
