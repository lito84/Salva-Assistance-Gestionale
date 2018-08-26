<?php 
require("includes/mysql.inc.php");
require("includes/parameters.php");
require("PHPMailer/class.phpmailer.php"); // Gestione email 
require("PHPMailer/class.smtp.php"); // Gestione email 
require_once 'libraries/PHPExcel.php';
require_once 'libraries/PHPExcel/IOFactory.php';
require_once 'libraries/PHPExcel/Writer/Excel2007.php';

$sql="SELECT * 
FROM  `anagraficastruttura` 
WHERE EmailStruttura
IN (

SELECT email
FROM dentisti_migliorsalute
)";

$res=mysql_query($sql);
while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){

	$struttura=addslashes("[DENT] ".$rows["RagioneSocialeStruttura"]);
	$indirizzo=addslashes($rows["IndirizzoOperativaStruttura"]);
	$citta=addslashes($rows["CittaOperativaStruttura"]);
	$pr=$rows["ProvinciaOperativaStruttura"];
	$cap=$rows["CapOperativaStruttura"];
	$email=addslashes($rows["EmailStruttura"]);
	$referente=addslashes($rows["NominativoConvenzioneStruttura"]);
	$telefono=$rows["Telefono1Struttura"];
	$stato="Da contattare";
	$note="";
	$sql1="INSERT INTO anagrafica_da_confermare (struttura, indirizzo, citta, pr, cap, email, referente, telefono, stato, note) VALUES ('$struttura','$indirizzo','$citta','$pr','$cap','$email','$referente','$telefono','$stato','$note')";
	$res1=mysql_query($sql1);
}
?>