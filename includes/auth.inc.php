<?php
error_reporting(0);
include ("parameters.php");
ini_set("session.gc_maxlifetime",18000); // scadenza sessione 5 ore
session_cache_expire(300); // scadenza sessione 5 ore

session_name("Salva");
session_start();
if ($_SESSION["user_authorized"]!=true) {
	header("Location: ".$p_sito);
	exit;
}
?>