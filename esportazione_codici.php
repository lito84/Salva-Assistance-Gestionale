<?php 
require("includes/auth.inc.php");
require("includes/mysql.inc.php");
require("includes/parameters.php");
	 $sql="SELECT * FROM convenzioni_prodotti_codici_lotti LEFT JOIN convenzioni_prodotti ON convenzioni_prodotti.id_convenzione_prodotto = convenzioni_prodotti_codici_lotti.id_prodotto_convenzione LEFT JOIN convenzioni ON convenzioni.id_convenzione = convenzioni_prodotti.id_convenzione LEFT JOIN utenti ON utenti.id_utente = convenzioni.id_utente WHERE convenzioni_prodotti_codici_lotti.id_lotto='$_GET[id_lotto]'";

      $res=mysql_query($sql);

	$rows=mysql_fetch_array($res, MYSQL_ASSOC);

	$filename="Codici ".$rows["lotto"].".xls";
	header( "Content-Type: application/vnd.ms-excel" );
	header( "Content-disposition: attachment; filename=".$filename );
	
	$head= 'Codice Attivazione' ;

	$head.="\n";
	echo $head;

	
	$dati="";
	$sql1="SELECT * FROM pratiche WHERE id_lotto = '$_GET[id_lotto]'";
	$res1=mysql_query($sql1);
	while($rows1=mysql_fetch_array($res1, MYSQL_ASSOC)){

		$dati.=$rows1["codice_attivazione"];
	
		$dati.="\n";
	}

	echo $dati;	
	
?>