<?php 
include("../includes/mysql.inc.php");
include("../includes/mysqli.inc.php");
include("../includes/functions.php");
require("../PHPMailer/class.phpmailer.php"); // Gestione email 
require("../PHPMailer/class.smtp.php"); // Gestione email 
require("../includes/parameters.php");

function generateRandomString($length = 10) {
    $characters = '123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


if($_POST["action"]=="inserisci"){
	
	$codice_convenzione=addslashes($_POST["codice_convenzione"]);
    $id_utente=addslashes($_POST["id_utente"]);
    $descrizione=addslashes($_POST["descrizione"]);
    $landing_acquisto=addslashes($_POST["landing_acquisto"]);
    $nome_mittente=addslashes($_POST["nome_mittente"]);
    $indirizzo_mittente=addslashes($_POST["indirizzo_mittente"]);
    $fatturazione=addslashes($_POST["fatturazione"]);
     $fatturazione_agente=addslashes($_POST["fatturazione_agente"]);
    $vendita=addslashes($_POST["vendita"]);
	
	
	$sql="INSERT INTO convenzioni (codice_convenzione, id_utente, descrizione, nome_mittente, indirizzo_mittente, fatturazione,fatturazione_agente, vendita, landing_acquisto) VALUES ('$codice_convenzione','$id_utente','$descrizione','$nome_mittente','$indirizzo_mittente','$fatturazione','$fatturazione_agente','$vendita','$landing_acquisto')";
	if($res=mysql_query($sql)){
		echo mysql_insert_id();	
	}
	exit;
}


if($_POST["action"]=="modifica"){
	$codice_convenzione=addslashes($_POST["codice_convenzione"]);
    $id_utente=addslashes($_POST["id_utente"]);
    $descrizione=addslashes($_POST["descrizione"]);
    $landing_acquisto=addslashes($_POST["landing_acquisto"]);
    $nome_mittente=addslashes($_POST["nome_mittente"]);
    $indirizzo_mittente=addslashes($_POST["indirizzo_mittente"]);
    $testo_mail_adesione=addslashes($_POST["testo_mail_adesione"]);
    $testo_mail_prodotto=addslashes($_POST["testo_mail_prodotto"]);
	$fatturazione=addslashes($_POST["fatturazione"]);
	$fatturazione_agente=addslashes($_POST["fatturazione_agente"]);
	$vendita=addslashes($_POST["vendita"]);
	
	$sql="UPDATE convenzioni SET id_utente='$id_utente', descrizione='$descrizione', nome_mittente='$nome_mittente', indirizzo_mittente = '$indirizzo_mittente', fatturazione='$fatturazione', fatturazione_agente='$fatturazione_agente', vendita='$vendita', landing_acquisto='$landing_acquisto' WHERE id_convenzione='$_POST[id_convenzione]'";
	$res=mysql_query($sql);

	if($res=mysql_query($sql)){
		echo "OK";
	}
	exit;
}
if($_POST["action"]=="prodotto"){
	$prezzo_cliente=str_replace(',','.',$_POST["prezzo_cliente"]);
	$prezzo_agente=str_replace(',','.',$_POST["prezzo_agente"]);

	$sqlm="SELECT template FROM templates_email WHERE id_template='$_POST[modello_email]'";
	$resm=$mysqli->query($sqlm);
    $rowsm = $resm->fetch_assoc();	


	$sql="INSERT INTO convenzioni_prodotti (id_convenzione, id_prodotto, prezzo_cliente, iva_cliente, prezzo_agente, iva_agente, attivazione_immediata, testo_mail_prodotto) VALUES ('$_POST[id_convenzione]', '$_POST[id_prodotto]','$prezzo_cliente', '$_POST[iva_cliente]', '$prezzo_agente', '$_POST[iva_agente]','$_POST[attivazione_immediata]','".addslashes(utf8_encode($rowsm["template"]))."')";
	
	if($res=mysql_query($sql)){
		$id=mysql_insert_id();
		$sql1="SELECT * FROM prodotti_meta WHERE id_prodotto = '$_POST[id_prodotto]'";
		$res1=mysql_query($sql1);
		while($rows1=mysql_fetch_array($res1, MYSQL_ASSOC)){
			$sql2="INSERT INTO prodotti_convenzione_meta (id_prodotto_convenzione, chiave, valore) VALUES ('$id', '".addslashes($rows1["chiave"])."','".addslashes($rows1["valore"])."')";
			$res2=mysql_query($sql2);
		}

	}
	exit;
}

if($_POST["action"]=="iva_cliente"){
	$sql="UPDATE convenzioni_prodotti SET iva_cliente='$_POST[iva_cliente]' WHERE id_convenzione_prodotto='$_POST[id]'";
	$res=mysql_query($sql);
	exit;
}

if($_POST["action"]=="iva_agente"){
	$sql="UPDATE convenzioni_prodotti SET iva_agente='$_POST[iva_agente]' WHERE id_convenzione_prodotto='$_POST[id]'";
	$res=mysql_query($sql);
	exit;
}

if($_POST["action"]=="attivazione_immediata"){
	$sql="UPDATE convenzioni_prodotti SET attivazione_immediata='$_POST[attivazione_immediata]' WHERE id_convenzione_prodotto='$_POST[id]'";
	$res=mysql_query($sql);
	exit;
}


if($_POST["action"]=="salute_semplice"){
	$sql="UPDATE convenzioni_prodotti SET salute_semplice='$_POST[salute_semplice]' WHERE id_convenzione_prodotto='$_POST[id]'";
	$res=mysql_query($sql);
	exit;
}

if($_POST["action"]=="percentuale_sconto"){
	$sql="UPDATE convenzioni_prodotti SET percentuale_sconto='$_POST[percentuale_sconto]' WHERE id_convenzione_prodotto='$_POST[id]'";
	$res=mysql_query($sql);
	exit;
}

if($_POST["action"]=="prezzo_cliente"){
	$_POST["prezzo_cliente"] = str_replace(",",".",$_POST["prezzo_cliente"]);
	$sql="UPDATE convenzioni_prodotti SET prezzo_cliente='$_POST[prezzo_cliente]' WHERE id_convenzione_prodotto='$_POST[id]'";
	$res=mysql_query($sql);
	exit;
}

if($_POST["action"]=="prezzo_agente"){
	$_POST["prezzo_agente"] = str_replace(",",".",$_POST["prezzo_agente"]);
	$sql="UPDATE convenzioni_prodotti SET prezzo_agente='$_POST[prezzo_agente]' WHERE id_convenzione_prodotto='$_POST[id]'";
	$res=mysql_query($sql);
	exit;
}


if($_POST["action"]=="elimina_prodotto"){
	
	$sql="UPDATE convenzioni_prodotti SET eliminato='1' WHERE id_convenzione_prodotto='$_POST[id]'";
	$res=mysql_query($sql);
	exit;
}



if($_POST["action"]=="prezzi"){


	$prezzo_cliente_scontato=$_POST["prezzo_cliente_scontato"];
	$prezzo_cliente_prodotto=$_POST["prezzo_cliente_prodotto"];
	$prezzo_agente_prodotto=$_POST["prezzo_agente_prodotto"];
	
	$id_aliquota=$_POST["id_aliquota"];
	
	$id_convenzione_prodotto=$_POST["id_convenzione_prodotto"];
	
	/*$sql0="SELECT valore FROM aliquote_iva WHERE id_aliquota='$id_aliquota'";
	$res0=mysql_query($sql0);
	$rows0=mysql_fetch_array($res0, MYSQL_ASSOC);
	$aliquota=$rows0["valore"];

	$prezzo_cliente=number_format($imponibile_cliente+$imponibile_cliente*$aliquota/100,2,".","");
	$prezzo_agente=number_format($imponibile_agente+$imponibile_agente*$aliquota/100,2,".","");*/


	$sql="UPDATE convenzioni_prodotti SET id_aliquota='$id_aliquota', prezzo_cliente='$prezzo_cliente_prodotto', prezzo_agente='$prezzo_agente_prodotto' WHERE id_convenzione_prodotto='$id_convenzione_prodotto'";
	$res=mysql_query($sql);

	exit;

}

if($_POST["action"]=="nuovo_sconto"){

	$nuovo_codice=$_POST["nuovo_codice"];
	$nuovo_prezzo=$_POST["nuovo_prezzo"];

	if($_POST["data_limite"]!=""){
		$data_limite=$_POST["data_limite"];
		$data_limite=convertiDataUS_IT($data_limite);
	}else{
		$data_limite="";
	}
	

	$id_convenzione_prodotto=$_POST["id_convenzione_prodotto"];
	$sql="INSERT INTO  convenzioni_prodotti_sconti (id_convenzione_prodotto, codice_sconto, prezzo, data_limite) VALUES ('$id_convenzione_prodotto','$nuovo_codice','$nuovo_prezzo', '$data_limite')";
	$res=mysql_query($sql);
	exit;

}



if($_POST["action"]=="modifica_codice"){
	$id_sconto=$_POST["id_sconto"];
	$codice_sconto=$_POST["codice_sconto"];
	$sql="UPDATE convenzioni_prodotti_sconti SET codice_sconto='$codice_sconto' WHERE id_sconto='$id_sconto'";
	$res=mysql_query($sql);
	exit;
}

if($_POST["action"]=="modifica_sconto"){
	$id_sconto=$_POST["id_sconto"];
	$prezzo=$_POST["prezzo"];
	$sql="UPDATE convenzioni_prodotti_sconti SET prezzo='$prezzo' WHERE id_sconto='$id_sconto'";
	$res=mysql_query($sql);
	exit;
}


if($_POST["action"]=="modifica_data"){
	$id_sconto=$_POST["id_sconto"];
	$data_limite=$_POST["data_limite"];
	$data_limite=convertiDataUS_IT($data_limite);
	$sql="UPDATE convenzioni_prodotti_sconti SET data_limite='$data_limite' WHERE id_sconto='$id_sconto'";
	$res=mysql_query($sql);
	exit;
}

if($_POST["action"]=="preview"){
	$sql="SELECT template FROM templates_email WHERE id_template='$_POST[id_template]'";
	$res=$mysqli->query($sql);
    $rows = $res->fetch_assoc();
    echo utf8_encode($rows["template"]);
	exit;
}


if($_POST["action"]=="genera_codici"){
	$id_convenzione_prodotto=$_POST["id_convenzione_prodotto"];
	$lotto=addslashes($_POST["descrizione_lotto"]);
	$quantita=$_POST["numero_codici"];
	$pagato=$_POST["pagato"];
	$attivo=$_POST["attivo"];

	$sql="INSERT INTO convenzioni_prodotti_codici_lotti (lotto, quantita, id_prodotto_convenzione, data_inserimento) VALUES ('$lotto','$quantita','$id_convenzione_prodotto','".date("Y-m-d H:i", strtotime("now"))."') ";
	$res=mysql_query($sql);
	$id_lotto=mysql_insert_id();

	for($i=0;$i<$quantita;$i++){
		$sql1="SELECT * FROM prodotti_convenzione_meta WHERE id_prodotto_convenzione='$id_convenzione_prodotto' AND chiave='Validita'";
		$res1=mysql_query($sql1);
		$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);

		$mesi=$rows1["valore"];

		$data_scadenza=date("Y-m-d H:i", strtotime("now +".$mesi." months"));
		//Generazione record pratica

		//Inserisco il record con stato non pagato e attivo
		$sql2="INSERT INTO pratiche (id_prodotto_convenzione, id_lotto, data_inserimento, data_scadenza, pagato, attivo) VALUES ('$id_convenzione_prodotto', '$id_lotto', '".date("Y-m-d H:i", strtotime("now"))."','$data_scadenza','$pagato','$attivo')";
		$res2=mysql_query($sql2);
		$id_pratica=mysql_insert_id();
		$id_pratica=str_pad($id_pratica,10,"0", STR_PAD_LEFT);
		$codice_attivazione = generateRandomString(6).substr($id_pratica,5,5);

			//Aggiorno la pratica inserendo il codice attivazione 
			$sql3="UPDATE pratiche SET codice_attivazione = '$codice_attivazione' WHERE id_pratica = '$id_pratica'";
			$res3=mysql_query($sql3);
	}
}

if($_POST["action"]=="invia_codice"){
	$id_convenzione_prodotto=$_POST["id_convenzione_prodotto"];
	$nominativo_codice=addslashes($_POST["nominativo_codice"]);
	$email_codice=addslashes($_POST["email_codice"]);
	$pagato=$_POST["pagato"];
	$attivo=$_POST["attivo"];

		$sql1="SELECT * FROM prodotti_convenzione_meta WHERE id_prodotto_convenzione='$id_convenzione_prodotto' AND chiave='Validita'";
		$res1=mysql_query($sql1);
		$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);

		$mesi=$rows1["valore"];

		$data_scadenza=date("Y-m-d H:i", strtotime("now +".$mesi." months"));
		//Generazione record pratica

		//Inserisco il record con stato non pagato e attivo
		$sql2="INSERT INTO pratiche (id_prodotto_convenzione, id_lotto, data_inserimento, data_scadenza, pagato, attivo) VALUES ('$id_convenzione_prodotto', '99999','".date("Y-m-d H:i", strtotime("now"))."','$data_scadenza','$pagato','$attivo')";
		$res2=mysql_query($sql2);
		$id_pratica=mysql_insert_id();
		$id_pratica=str_pad($id_pratica,10,"0", STR_PAD_LEFT);
		$codice_attivazione = generateRandomString(6).substr($id_pratica,5,5);

		//Aggiorno la pratica inserendo il codice attivazione 
		$sql3="UPDATE pratiche SET codice_attivazione = '$codice_attivazione' WHERE id_pratica = '$id_pratica'";
		$res3=mysql_query($sql3);



		$sqlp="SELECT * FROM pratiche LEFT JOIN convenzioni_prodotti ON pratiche.id_prodotto_convenzione= convenzioni_prodotti.id_convenzione_prodotto LEFT JOIN prodotti ON prodotti.id_prodotto = convenzioni_prodotti.id_prodotto WHERE id_pratica='$id_pratica'";
		$resp=mysql_query($sqlp);
		$rowsp=mysql_fetch_array($resp, MYSQL_ASSOC);
		$prodotto=$rowsp["prodotto"];


		$sql4="SELECT * FROM convenzioni_prodotti_invio_codice LIMIT 0,1";
		$res4=mysql_query($sql4);
		$rows4=mysql_fetch_array($res4, MYSQL_ASSOC);

		$messaggio=utf8_decode($rows4["testo_mail_invio_codice"]);

		
		
		$campi=array("{CLIENTE}","{PRODOTTO}","{CODICEATTIVAZIONE}");
	
		$valori=array(stripslashes($nominativo_codice),$prodotto, $codice_attivazione);
				
		$messaggio=str_replace($campi,$valori,$messaggio);

		
		$mail=new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPAuth = true; // turn on SMTP authentication
		$mail->Username = $p_smtp_user; // SMTP username
		$mail->Password = $p_smtp_password; // SMTP password
		$mail->Host=$p_smtp_server;
		$mail->From=$p_smtp_mittente_email;
		$mail->FromName=$p_smtp_mittente;
		$mail->MsgHTML($messaggio);
		$mail->Port=465;
		$mail->SMTPSecure="ssl";
		$mail->AltBody=strip_tags(html_entity_decode($messaggio));
		$mail->Subject="Il tuo codice Salute Semplice";
		$mail->AddAddress($email_codice, stripslashes($nominativo_codice));
		
		
		if ($mail->Send()) {
			$mail->ClearAddresses();

			$sql1="UPDATE pratiche SET data_invio='".date("Y-m-d H:i", strtotime("now"))."', email_invio='$email_codice',nominativo_invio='$nominativo_codice' WHERE codice_attivazione='$codice_attivazione'";
			$res1=mysql_query($sql1);
			echo $codice_attivazione;	
			}
		exit;

}


if($_POST["action"]=="invio_codice"){
	$nominativo_codice=addslashes($_POST["nominativo"]);
	$email_codice=addslashes($_POST["email"]);
	$codice_attivazione=addslashes($_POST["codice_attivazione"]);
	
		$sqlp="SELECT * FROM pratiche LEFT JOIN convenzioni_prodotti ON pratiche.id_prodotto_convenzione= convenzioni_prodotti.id_convenzione_prodotto LEFT JOIN prodotti ON prodotti.id_prodotto = convenzioni_prodotti.id_prodotto WHERE codice_attivazione='$codice_attivazione'";
		$resp=mysql_query($sqlp);
		$rowsp=mysql_fetch_array($resp, MYSQL_ASSOC);
		$prodotto=$rowsp["prodotto"];


		$sql4="SELECT * FROM convenzioni_prodotti_invio_codice LIMIT 0,1";
		$res4=mysql_query($sql4);
		$rows4=mysql_fetch_array($res4, MYSQL_ASSOC);

		$messaggio=utf8_decode($rows4["testo_mail_invio_codice"]);

		$campi=array("{CLIENTE}","{PRODOTTO}","{CODICEATTIVAZIONE}");
	
		$valori=array(stripslashes($nominativo_codice),$prodotto, $codice_attivazione);
				
		$messaggio=str_replace($campi,$valori,$messaggio);


		$mail=new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPAuth = true; // turn on SMTP authentication
		$mail->Username = $p_smtp_user; // SMTP username
		$mail->Password = $p_smtp_password; // SMTP password
		$mail->Host=$p_smtp_server;
		$mail->Port=465;
		$mail->SMTPSecure="ssl";
		$mail->From=$p_smtp_mittente_email;
		$mail->FromName=$p_smtp_mittente;


		$mail->MsgHTML($messaggio);

		$mail->AltBody=strip_tags(html_entity_decode($messaggio));
		$mail->Subject="Il tuo codice SaluteSemplice";
		$mail->AddAddress($email_codice, stripslashes($nominativo_codice));
		
		
		if ($mail->Send()) {
			$mail->ClearAddresses();


			$sql1="UPDATE pratiche SET data_invio='".date("Y-m-d H:i", strtotime("now"))."', email_invio='$email_codice',nominativo_invio='$nominativo_codice' WHERE codice_attivazione='$codice_attivazione'";
			$res1=mysql_query($sql1);
			echo "OK";	
			}
		exit;

}
?>
