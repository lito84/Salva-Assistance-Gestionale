<?php 
require("includes/auth.inc.php");
require("includes/mysql.inc.php");
require("includes/parameters.php");

	$filename="esportazione ".date("Y-m-d", strtotime("now")).".xls";
	header( "Content-Type: application/vnd.ms-excel" );
	header( "Content-disposition: attachment; filename=".$filename );
	
	$head= 'N.'."\t".'Codice Attivazione' . "\t" . 'Cognome' . "\t" . 'Nome' . "\t" . 'CF' ."\t". 'Indirizzo'."\t". "Citta" ."\t". 'CAP'."\t".'Prodotto'."\t".'Data attivazione'."\t".'Data Scadenza'."\t"."Nome Beneficiario"."\t"."Cognome Beneficiario" ;

	$head.="\n";
	echo $head;

	$sql="SELECT codice_attivazione, clienti.nome AS nome, clienti.cognome AS cognome, codicefiscale, indirizzo, comune, cap, data_attivazione, data_scadenza, prodotto, beneficiari.nome AS nome_ben, beneficiari.cognome AS cognome_ben
FROM pratiche
LEFT JOIN clienti ON clienti.id_cliente = pratiche.id_cliente
LEFT JOIN convenzioni_prodotti ON convenzioni_prodotti.id_convenzione_prodotto = pratiche.id_prodotto_convenzione
LEFT JOIN beneficiari ON beneficiari.id_pratica = pratiche.id_pratica
LEFT JOIN prodotti ON convenzioni_prodotti.id_prodotto = prodotti.id_prodotto
LEFT JOIN comuni_gl ON clienti.citta = comuni_gl.cod_istat
WHERE data_attivazione LIKE  '2016-12-13%'";

	$res=mysql_query($sql);
	$dati="";
	$i=0;
	while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){
		$i++;
		$sql2="UPDATE pratiche SET fatturato='1' WHERE id_pratica = '$rows[id_pratica]'";
		$res2=mysql_query($sql2);

		$sql3="INSERT INTO fatturazione_richieste (id_pratica, timestamp_richiesta) VALUES ('$rows[id_pratica]', '".date("Y-m-d H:i:s", strtotime("now"))."')";
		$res3=mysql_query($sql3);

		$dati.=$i."\t".$rows["codice_attivazione"]. "\t". $rows["cognome"]."\t".$rows["nome"]."\t".date("d-m-Y", strtotime($rows["data_pagamento"]));
	
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