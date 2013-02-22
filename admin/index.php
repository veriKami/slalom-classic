<?
if ($_POST['auth_name'])
{require('../connect.php');
 $name=mysql_real_escape_string($_POST['auth_name']);
 $pass=mysql_real_escape_string($_POST['auth_pass']);
 if (($name=='admin') && ($pass=='lfflvbybcnhfnjh'))
 {session_start();
  $_SESSION['user_name']=$name;
  $_SESSION['ip']=$_SERVER['REMOTE_ADDR'];
  header('Location: admin.php');
  $st='';
  }
 else 
 {$st='<font color=red>Incorrect Login and/or Password</font>';
  }
 }
if ($_GET['exit'])
{session_start();
 unset($_SESSION['user_name']);
 header('Location: ../index.php');
 }
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="../style.css" rel="stylesheet" type="text/css">
<title>Slalom Classic Judgment</title>
</head>
<body onload="document.getElementById('i1').focus();">

<?
echo '<center>'.$st.'<br>';
?>
<form method="POST">
<table border=0>
<tr><td>Login:<td><input id="i1" type="text" name="auth_name"><tr><td>Password:<td><input type="password" name="auth_pass"><tr><td colspan=2 align=center><input type="submit" value=" Enter "></table>
</form>
</center>
</body>
</html>

