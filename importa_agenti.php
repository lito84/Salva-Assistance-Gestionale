<?php 
require("includes/mysql.inc.php");
require("includes/parameters.php");
require("PHPMailer/class.phpmailer.php"); // Gestione email 
require("PHPMailer/class.smtp.php"); // Gestione email 
require_once 'libraries/PHPExcel.php';
require_once 'libraries/PHPExcel/IOFactory.php';
require_once 'libraries/PHPExcel/Writer/Excel2007.php';

$sql="SELECT * 
FROM  convenzioni_old 
WHERE IDUtente>'11' ";

$res=mysql_query($sql);
while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){
/*
	$username=addslashes(utf8_encode($rows["Username"]));
	$password=addslashes(utf8_encode($rows["Password"]));
	$nomecompleto=addslashes(utf8_encode($rows["NomeCompleto"]));
	$livello=$rows["IdLivello"];
	$email=addslashes(utf8_encode($rows["Email"]));
	$codiceinnova=addslashes(utf8_encode($rows["CodiceInnova"]));
	$cf=addslashes(utf8_encode($rows["CodiceFiscale"]));
	$partitaiva=addslashes(utf8_encode($rows["PartitaIVA"]));
	$regione=addslashes(utf8_encode($rows["RegioneSL"]));
	$provincia=addslashes(utf8_encode($rows["ProvinciaSL"]));

	$comune=addslashes(utf8_encode($rows["ComuneSL"]));
	$cap=addslashes(utf8_encode($rows["CapSL"]));
	$indirizzo=addslashes(utf8_encode($rows["IndirizzoSL"]));
	$ragionesociale=addslashes(utf8_encode($rows["RagioneSociale"]));

	$sql1="INSERT INTO utenti (nome, login, password, id_ruolo, email, cf, partitaiva, ragionesociale, indirizzo, citta, provincia, cap, regione, codice_innova) VALUES ('$nomecompleto','$username','$password','$livello','$email','$cf','$partitaiva','$ragionesociale','$indirizzo','$citta','$provincia','$cap','$regione','$codiceinnova')";

	echo $sql1;

	if($res1=mysql_query($sql1)){
		$id=mysql_insert_id();

		$sql2="UPDATE agenti_old SET nuovo_id='$id' WHERE IDUtente = '$rows[IDUtente]'";
		$res2=mysql_query($sql2);

	}*/


	$sql1="SELECT nuovo_id FROM agenti_old WHERE IDUtente = '$rows[IDUtente]'";
	$res1=mysql_query($sql1);
	$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
	
	echo $sql1;

	$sql2="UPDATE convenzioni_old SET IDUtente='$rows1[nuovo_id]' WHERE IDCoupon='$rows[IDCoupon]'";
	$res2=mysql_query($sql2);

}
?>