<?php 
require("includes/mysql.inc.php");
require("includes/parameters.php");

$sql="SELECT * FROM TABLE128";

$res=mysql_query($sql);
while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){

	$struttura=addslashes(utf8_encode($rows["ragionesociale"]));
	$indirizzo=addslashes(utf8_encode($rows["indirizzo"]));
	$citta=addslashes($rows["citta"]);
	$pr=$rows["provincia"];
	$cap=$rows["cap"];
	$telefono=$rows["telefono"];
	$regione=$rows["regione"];
	$fax=$rows["fax"];
	$partitaiva=$rows["partitaiva"];
	

	$sql1="INSERT INTO anagraficastruttura (RagioneSocialeStruttura, IndirizzoOperativaStruttura, CittaOperativaStruttura, ProvinciaOperativaStruttura, CapOperativaStruttura, Telefono1Struttura,FaxStruttura, PartitaIvaStruttura, RegioneStruttura, migliorsalute, attivo, convenzione_confermata, timestamp_conferma, siglaprov, Provenienza) VALUES ('$struttura','$indirizzo','$citta','$pr','$cap','$telefono','$fax','$partitaiva','$regione','1','1','1','".date("Y-m-d H:i", strtotime("now"))."','$pr','Innova')";
	echo $sql1."<br />";

	$res1=mysql_query($sql1);
	$id=mysql_insert_id();

	$sql2="INSERT INTO circuiti_strutture (id_circuito, id_struttura) VALUES ('26','$id')";
	$res2=mysql_query($sql2);

}
?>