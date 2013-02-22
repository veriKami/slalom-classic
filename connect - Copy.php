<?
setlocale(LC_ALL, "ru_RU.UTF8");
$dbhost = '127.0.0.1';
$dbname = 'slalom';
$dbuser = 'slalom';
$dbpasswd = '12345678';
mysql_connect($dbhost,$dbuser,$dbpasswd); 
mysql_select_db($dbname);
?>