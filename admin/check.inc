<?php //:
////////:

session_start();

if ((!isset($_SESSION['user_name'])) or ($_SESSION['ip']!=$_SERVER['REMOTE_ADDR'])){
    die('<a href=index.php>Login</a>');
}

////////: ?>
