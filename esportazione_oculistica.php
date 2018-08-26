<?php 
require("includes/auth.inc.php");
require("includes/mysql.inc.php");
require("includes/parameters.php");

$output="Ragione Sociale;Indirizzo;Citta;Provincia;Telefono;Email\n";

$sql="SELECT * FROM servizi_strutture_migliorsalute LEFT JOIN servizi_migliorsalute ON servizi_strutture_migliorsalute.id_servizio = servizi_migliorsalute.id_servizio WHERE servizio LIKE '%oculist%' GROUP BY id_struttura ";
$res=mysql_query($sql);
while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){
	$sql1="SELECT RagioneSocialeStruttura, IndirizzoOperativaStruttura, CittaOperativaStruttura, ProvinciaOperativaStruttura, Telefono1Struttura, EmailStruttura FROM anagraficastruttura WHERE IdAnagraficaStruttura='$rows[id_struttura]'";
	$res1=mysql_query($sql1);
	$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);

	$output.=utf8_encode($rows1["RagioneSocialeStruttura"]).";".utf8_encode($rows1["IndirizzoOperativaStruttura"]).";".utf8_encode($rows1["CittaOperativaStruttura"]).";".utf8_encode($rows1["ProvinciaOperativaStruttura"]).";".utf8_encode($rows1["Telefono1Struttura"]).";".utf8_encode($rows1["EmailStruttura"])."\n";
}

header("Content-type: text/x-csv");
		header("Content-Disposition: inline; filename=\"ListaOculistica.csv\"");
		header("Content-Disposition: attachment; filename=\"ListaOculistica.csv\"");
		echo $output;	
?>