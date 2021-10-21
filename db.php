<?php
define('HOSTNAME', 'localhost');
define('USERNAME', 'root');
define('PASSWORD', '');
define('DATABASE', 'todo');
$dbLink = mysql_connect(HOSTNAME, USERNAME, PASSWORD) or
die("Konnte DB-Server nicht erreichen");

mysql_query("SET character_set_results=utf8", $dbLink);
mb_language('uni');
mb_internal_encoding('UTF-8');
mysql_select_db(DATABASE, $dbLink) or
die("Konnte Datenbank nicht auswählen");

mysql_query("set names 'utf8'",$dbLink);
?>
