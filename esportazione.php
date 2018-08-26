<?php 
require("includes/auth.inc.php");
require("includes/mysql.inc.php");
require("includes/parameters.php");

	$filename="esportazione ".date("Y-m-d", strtotime("now")).".xls";
	header( "Content-Type: application/vnd.ms-excel" );
	header( "Content-disposition: attachment; filename=".$filename );
	
	$head= 'N.'."\t".'Codice Attivazione' . "\t" . 'Prodotto' . "\t" .'Cognome' . "\t" . 'Nome' . "\t" . 'Data pagamento' ;

	if($_SESSION["id_utente"]=="058"){ //Cherry Box 
		$head.="\t"."Codice ID";
	}
	$head.="\n";
	echo $head;

	$sql="SELECT *, clienti.cognome AS cognome, clienti.nome AS nome, utenti.nome AS agente, clienti.email AS email FROM pratiche LEFT JOIN clienti ON pratiche.id_cliente = clienti.id_cliente LEFT JOIN convenzioni_prodotti ON pratiche.id_prodotto_convenzione = convenzioni_prodotti.id_convenzione_prodotto LEFT JOIN convenzioni ON convenzioni.id_convenzione = convenzioni_prodotti.id_convenzione LEFT JOIN utenti ON convenzioni.id_utente = utenti.id_utente WHERE utenti.id_utente='$_SESSION[id_utente]' AND pratiche.pagato AND pratiche.attivo AND pratiche.fatturato='0'";

	$res=mysql_query($sql);
	$dati="";
	$i=0;
	while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){
		$i++;
		$sql2="UPDATE pratiche SET fatturato='1' WHERE id_pratica = '$rows[id_pratica]'";
		$res2=mysql_query($sql2);

		$sql3="INSERT INTO fatturazione_richieste (id_pratica, timestamp_richiesta) VALUES ('$rows[id_pratica]', '".date("Y-m-d H:i:s", strtotime("now"))."')";
		$res3=mysql_query($sql3);

		$sql4="SELECT * FROM prodotti LEFT JOIN convenzioni_prodotti ON convenzioni_prodotti.id_prodotto = prodotti.id_prodotto WHERE id_convenzione_prodotto = '$rows[id_prodotto_convenzione]'";
		$res4=mysql_query($sql4);
		$rows4=mysql_fetch_array($res4, MYSQL_ASSOC);

		$dati.=$i."\t".$rows["codice_attivazione"]. "\t". $rows4["prodotto"]."\t".$rows["cognome"]."\t".$rows["nome"]."\t".date("d-m-Y", strtotime($rows["data_pagamento"]));
	
		if($_SESSION["id_utente"]=="058"){ //Cherry Box
			$sql1="SELECT valore FROM pratiche_meta WHERE id_pratica='$rows[id_pratica]' AND chiave = 'Codice incaricato'";
			$res1=mysql_query($sql1);
			$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
			$valore=$rows1["valore"];

			$dati.="\t".$valore;
		} 
		$dati.="\n";
	}

	echo $dati;	
	exit();
?>