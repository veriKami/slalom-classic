<?php //:
////////:

session_start();

if ((!isset($_SESSION['id'])) or ($_SESSION['ip'] != $_SERVER['REMOTE_ADDR'])){
    die('<a href=index.php>Login</a>');
}

?>
