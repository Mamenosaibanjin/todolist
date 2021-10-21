<?php
define('HOSTNAME', 'localhost');
define('USERNAME', 'root');
define('PASSWORD', '');
define('DATABASE', 'todo');
$dbLink = mysqli_connect(HOSTNAME, USERNAME, PASSWORD) or
die("Konnte DB-Server nicht erreichen");

mysqli_query($dbLink, "SET character_set_results=utf8");
mb_language('uni');
mb_internal_encoding('UTF-8');
mysqli_select_db($dbLink, DATABASE) or
die("Konnte Datenbank nicht auswählen");

mysqli_query($dbLink, "set names 'utf8'");
?>
