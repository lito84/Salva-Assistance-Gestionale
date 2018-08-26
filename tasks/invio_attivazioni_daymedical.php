<?php include("../includes/parameters.php");?>
<?php include("../includes/functions.php");?>
<?php include("../includes/getinclude.php");?>
<?php include("../includes/mysql.inc.php");?>
<?php require("../PHPMailer/class.phpmailer.php"); // Gestione email ?>
<?php require("../PHPMailer/class.smtp.php"); // Gestione email ?>
<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>

<?php
$yesterday="2017-02-13";

$sql="SELECT *, utenti.id_utente AS id_utente FROM pratiche LEFT JOIN convenzioni_prodotti ON pratiche.id_prodotto_convenzione = convenzioni_prodotti.id_convenzione_prodotto LEFT JOIN convenzioni ON convenzioni.id_convenzione = convenzioni_prodotti.id_convenzione LEFT JOIN utenti ON utenti.id_utente = convenzioni.id_utente WHERE pagato='1' AND data_attivazione LIKE '".$yesterday."%' AND convenzioni_prodotti.id_convenzione_prodotto IN ( '00061')";

$res=mysql_query($sql);

if($num=mysql_num_rows($res)>0){

$filename="ADE ".date("Y-m-d").".csv";

$file = fopen($filename, 'w');

fputcsv($file, array("IDPratica","DataInserimento","Agente","Icona","Codice fiscale","Cognome","Nome","Indirizzo","Comune","CAP","Provincia","IDCliente","IDTipoCard","Stato","ColoreStato","IDUtente","Card","Scadenza","Email","Telefono","ColoreCard","PrezzoVendita","IDStato","GiorniScadenza","IDAcquisto","Attivata","PayPalStatus","Pagata","CodiceProdotto","CodiceAttivazione","Prenotata","DataAttivazione","IDLottoPrenotazioni","ConfermataCliente","CodiceSalus","IDEstrazione","Provenienza","RinnovoAvviato","DataScadenza","DataAttivazioneCliente","RisultatoInvioMail"));


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

	$sqlcap="SELECT cap FROM cap_gl WHERE comune = '".addslashes($rows1["comune"])."'";
	$rescap=mysql_query($sqlcap);
	$rowscap=mysql_fetch_array($rescap, MYSQL_ASSOC);
	$cap=$rowscap["cap"];

	$sql2="SELECT * FROM prodotti WHERE prodotti.id_prodotto ='$rows[id_prodotto]'";
	
	$res2=mysql_query($sql2);
	$rows2=mysql_fetch_array($res2, MYSQL_ASSOC);

	$dati=array( 
		$rows["id_pratica"],
		date("d-m-Y", strtotime($rows["data_attivazione"])),
		$rows["nome"],
		" ",
		$rows1["codicefiscale"],
		$rows1["cognome"],
		$rows1["nome"],
		$rows1["indirizzo"],
		$rows1["comune"],
		$cap,
		$rows1["sigla"],
		$rows1["id_cliente"],
		$rows2["id_prodotto"],
		$attivo_label,
		$colore_label,
		$rows["id_utente"],
		$rows2["prodotto"],
		date("d-m-Y", strtotime($rows["data_scadenza"])),
		$rows1["email"],
		$rows1["telefono"],
		$rows["prezzo_cliente"],
		$stato_label,
		$giorni,
		$rows["id_pratica"],
		$attivo,
		$paypal_status,
		$pagamento_status,
		$rows["codice_attivazione"],
		$rows["codice_attivazione"],
		date("d-m-Y", strtotime($rows["data_attivazione"])),
		$rows["id_lotto"],
		"GES",
		"FALSO",
		date("d-m-Y", strtotime($rows["data_scadenza"])),
		$data_label
		);

	fputcsv($file, $dati);
}
//fclose($fp);

	$mail=new PHPMailer();
			$mail->IsSMTP();
			$mail->SMTPAuth = true; // turn on SMTP authentication
			$mail->Username = $p_smtp_user; // SMTP username
			$mail->Password = $p_smtp_password; // SMTP password
			$mail->Host=$p_smtp_server;
			$mail->From=$p_smtp_mittente_email;
			$mail->FromName=$p_smtp_mittente;
			$mail->MsgHTML("Attivazioni migliorsalute - migliorsorriso ".$yesterday);
			$mail->Subject="Attivazioni migliorsalute - migliorsorriso ".$yesterday;
			//$mail->AddAddress("segreteria@adegroup.eu", "Segreteria ADE Group");
			$mail->AddAddress("luca.merli84@gmail.com", "Segreteria ADE Group");
			$mail->AddAttachment($filename);
			//$mail->AddBCC("amministrazione@migliorsalute.it", "Amministrazione Migliorsalute");
			$mail->Send();
}		
?>