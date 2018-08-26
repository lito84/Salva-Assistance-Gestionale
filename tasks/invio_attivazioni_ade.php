<?php include("../includes/parameters.php");?>
<?php include("../includes/functions.php");?>
<?php include("../includes/getinclude.php");?>
<?php include("../includes/mysql.inc.php");?>
<?php header("Content-Type: application/vnd.ms-excel");
$filename="ADE ".date("Y-m-d").".xls";
$head=" IDPratica"."\t"."DataInserimento"."\t"."Agente"."\t"."Icona"."\t"."Cliente"."\t"."Comune"."\t"."Provincia"."\t"."IDCliente"."\t"."IDTipoCard"."\t"."Stato"."\t"."ColoreStato"."\t"."IDUtente"."\t"."Card"."\t"."Scadenza"."\t"."Email"."\t"."Telefono"."\t"."ColoreCard"."\t"."PrezzoVendita"."\t"."IDStato"."\t"."GiorniScadenza"."\t"."IDAcquisto"."\t"."Attivata"."\t"."PayPalStatus"."\t"."Pagata"."\t"."CodiceProdotto"."\t"."CodiceAttivazione"."\t"."Prenotata"."\t"."DataAttivazione"."\t"."IDLottoPrenotazioni"."\t"."ConfermataCliente"."\t"."CodiceSalus"."\t"."IDEstrazione"."\t"."Provenienza"."\t"."RinnovoAvviato"."\t"."DataScadenza"."\t"."DataAttivazioneCliente"."\t"."RisultatoInvioMail"."\n";
echo $head;
$yesterday=date("Y-m-d", strtotime("now -1 day"));

$sql="SELECT *, utenti.id_utente AS id_utente FROM pratiche LEFT JOIN convenzioni_prodotti ON pratiche.id_prodotto_convenzione = convenzioni_prodotti.id_convenzione_prodotto LEFT JOIN convenzioni ON convenzioni.id_convenzione = convenzioni_prodotti.id_convenzione LEFT JOIN utenti ON utenti.id_utente = convenzioni.id_utente WHERE pagato='1' AND data_attivazione LIKE '".$yesterday."%' AND pratiche.id_utente <> '0' ";
$res=mysql_query($sql);
$dati="";
while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){
	$now = time(); // or your date as well
     $your_date = strtotime(date("Y-m-d", strtotime($rows["data_scadenza"])));
     $datediff =  $your_date-$now;
     $giorni=floor($datediff/(60*60*24));

	$attivo = ($rows['attivo'] == '1') ? $attivo_label="Attivata" : $attivo_label="Non attivata";
	$colore = ($rows['attivo'] == '1') ? $colore_label="Blue" : $colore_label="Red";
	$stato = ($rows['attivo'] == '1') ? $stato_label="6" : $stato_label="8";
	$paypal = ($rows['pagato'] == '1' && $rows["tipo_pagamento"]=="PayPal") ? $paypal_status="Pagato" : $paypal_status="Non pagato";
	$pagamento = ($rows['pagato'] == '1') ? $pagamento_status="Pagato" : $pagamento_status="Non pagato";
	$data_richiesta = ($rows['data_richiesta_attivazione'] == '') ? $data_label="" : $data_label=date("d-m-Y", strtotime($rows["data_richiesta_attivazione"]));
	
	$sql1="SELECT * FROM clienti LEFT JOIN comuni_gl ON comuni_gl.cod_istat = clienti.citta LEFT JOIN province_gl ON comuni_gl.cod_provincia = province_gl.cod_provincia WHERE id_cliente = '$rows[id_cliente]'";
	$res1=mysql_query($sql1);
	$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);

	$sql2="SELECT * FROM prodotti WHERE prodotti.id_prodotto ='$rows[id_prodotto]'";
	
	$res2=mysql_query($sql2);
	$rows2=mysql_fetch_array($res2, MYSQL_ASSOC);

	$dati.="$rows[id_pratica]"."\t".date("d-m-Y", strtotime($rows[data_attivazione]))."\t".$rows[nome]."\t"."\t".$rows1[cognome]." ".$rows1[nome]."\t".$rows1[comune]."\t".$rows1[sigla]."\t".$rows1[id_cliente]."\t"."$rows2[id_prodotto]"."\t".$attivo_label."\t".$colore_label."\t".$rows[id_utente]."\t".$rows2[prodotto]."\t".date("d-m-Y", strtotime($rows[data_scadenza]))."\t".$rows1[email]."\t".$rows1[telefono]."\t"."\t".$rows[prezzo_cliente]."\t".$stato_label."\t".$giorni."\t".$rows[id_pratica]."\t".$attivo."\t".$paypal_status."\t".$pagamento_status."\t".$rows[codice_attivazione]."\t".$rows[codice_attivazione]."\t"."\t".date("d-m-Y", strtotime($rows[data_attivazione]))."\t".$rows[id_lotto]."\t"."\t"."\t"."\t"."GES"."\t"."FALSO"."\t".date("d-m-Y", strtotime($rows[data_scadenza]))."\t".$data_label."\n";

}
echo $dati;
header("Content-disposition: attachment; filename=".$filename);
?>