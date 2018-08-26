<?php include("../includes/mysql.inc.php");
	require("../includes/parameters.php");
require("../PHPMailer/class.phpmailer.php"); // Gestione email 
require("../PHPMailer/class.smtp.php"); // Gestione email 

if($_POST["action"]=="percentuale_provvigione"){
	
	$sql="SELECT percentuale FROM tipo_utenti WHERE id_tipo_contatto = '$_POST[id_ruolo]'";
	$res=mysql_query($sql);
	$rows=mysql_fetch_array($res, MYSQL_ASSOC);
	echo $rows["percentuale"];
	exit;

}


	$nome=addslashes($_POST["nome"]);
	$login=addslashes($_POST["login"]);
	$password=addslashes($_POST["password"]);
	$email=addslashes($_POST["email"]);
	$telefono=addslashes($_POST["telefono"]);
	$ragionesociale=addslashes($_POST["ragionesociale"]);
	$indirizzo=addslashes($_POST["indirizzo"]);
	$citta=addslashes($_POST["citta"]);
	$partitaiva=addslashes($_POST["partitaiva"]);
	$cf=addslashes($_POST["cf"]);
	$ruolo=addslashes($_POST["ruolo"]);
	$agente_superiore=addslashes($_POST["agente_superiore"]);
	$vendita=0;
	$percentuale=addslashes($_POST["percentuale"]);
	$stampa_prodotto=0;
	$id_convenzione=addslashes($_POST["id_convenzione"]);
	$aliquota=$_POST["aliquota"];
	if($_POST["vendita"]=="Y") $vendita=1;
	if($_POST["stampa_prodotto"]=="Y") $stampa_prodotto=1;

if($_POST["action"]=="inserisci"){
	
	$sql="INSERT INTO utenti (nome,login, password, email, telefono, ragionesociale, indirizzo, citta, partitaiva, cf, id_ruolo, vendita, agente_superiore, percentuale, stampa_prodotto, aliquota, id_convenzione) VALUES ('$nome','$login','$password','$email','$telefono','$ragionesociale','$indirizzo','$citta','$partitaiva','$cf','$ruolo','$vendita','$agente_superiore','$percentuale','$stampa_prodotto','$aliquota','$id_convenzione')";
	$res=mysql_query($sql);



	$sql0="SELECT template FROM templates_email WHERE nome='Agente'";
	$res0=mysql_query($sql0);
	$rows0=mysql_fetch_array($res0, MYSQL_ASSOC);

	$messaggio=$rows0["template"];

	$campi=array("{AGENTE}","{LINK}","{USERNAME}","{PASSWORD}");
	
		$link="https://www.salvassistance.it/gestionale";

		$valori=array($nome, $link, $login, $password);
				
		$messaggio=str_replace($campi,$valori,$messaggio);
	$mail=new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPAuth = true; // turn on SMTP authentication
		$mail->Username = $p_smtp_user; // SMTP username
		$mail->Password = $p_smtp_password; // SMTP password
		$mail->Host="ssl0.ovh.net";
	    $mail->Port=465;
	    $mail->SMTPSecure="ssl";
		$mail->From=$p_smtp_mittente_email;
		$mail->FromName=$p_smtp_mittente;
		$mail->MsgHTML($messaggio);
		$mail->AltBody=strip_tags(html_entity_decode($messaggio));
		$mail->Subject="Il tuo account Salva Assistance";
		$mail->AddAddress($email, stripslashes($nome." ".$cognome));

		
		if ($mail->Send()) {
			$mail->ClearAddresses();
		
		}


}



if($_POST["action"]=="credenziali"){
	
	$sql="SELECT * FROM utenti WHERE id_utente = '$_POST[id_utente]'";
	$res=mysql_query($sql);
	$rows=mysql_fetch_array($res, MYSQL_ASSOC);

	$nome=addslashes($rows["nome"]);
	$email=addslashes($rows["email"]);
	$login=addslashes($rows["login"]);
	$password=addslashes($rows["password"]);

	$sql0="SELECT template FROM templates_email WHERE nome='Agente'";
	$res0=mysql_query($sql0);
	$rows0=mysql_fetch_array($res0, MYSQL_ASSOC);

	$messaggio=$rows0["template"];
	

	$campi=array("{AGENTE}","{LINK}","{USERNAME}","{PASSWORD}");
	
		$link="https://www.salvassistance.it/gestionale";

		$valori=array($nome, $link, $login, $password);

	
				
		$messaggio=str_replace($campi,$valori,$messaggio);
		$mail=new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPAuth = true; // turn on SMTP authentication
		$mail->Username = $p_smtp_user; // SMTP username
		$mail->Password = $p_smtp_password; // SMTP password
		$mail->Host="ssl0.ovh.net";
	    $mail->Port=465;
	    $mail->SMTPSecure="ssl";
		$mail->From=$p_smtp_mittente_email;
		$mail->FromName=$p_smtp_mittente;
		$mail->MsgHTML($messaggio);
		$mail->AltBody=strip_tags(html_entity_decode($messaggio));
		$mail->Subject="Il tuo account Salva Assistance";
		$mail->AddAddress($email, stripslashes($nome." ".$cognome));

		
		if ($mail->Send()) {
			$mail->ClearAddresses();
		
		}


}

if($_POST["action"]=="modifica"){
	
	$id_utente=$_POST["id_utente"];
	
	$sql="UPDATE utenti  SET nome='$nome', login='$login', password='$password', email='$email', telefono='$telefono', ragionesociale='$ragionesociale', indirizzo='$indirizzo', citta='$citta', partitaiva='$partitaiva', cf='$cf', id_ruolo='$ruolo', agente_superiore='$agente_superiore', vendita='$vendita',percentuale='$percentuale', stampa_prodotto='$stampa_prodotto', aliquota='$aliquota', id_convenzione='$id_convenzione' WHERE id_utente='$id_utente'";
	$res=mysql_query($sql);
	exit;

}




?>
