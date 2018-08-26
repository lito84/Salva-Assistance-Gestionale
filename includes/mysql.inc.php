<?php
// Procedure di connessione
$host="salvassicidb.mysql.db";
$user="salvassicidb";
$pass="vX5VMfEu7P";



$database="salvassicidb";
$con=mysql_connect($host,$user,$pass) or die ("Errore durante la connessione al database $database!");
$db=mysql_select_db($database,$con) or die ("Errore durante la selezione del database!");
?>