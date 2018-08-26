<?php 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

require("../includes/auth.inc.php");
require("../includes/mysql.inc.php");
require("../includes/parameters.php");
require("../PHPMailer/class.phpmailer.php"); // Gestione email 
require("../PHPMailer/class.smtp.php"); // Gestione email 


if($_POST["action"]=="controlla_esportazioni"){
	$sql0="SELECT * FROM pratiche LEFT JOIN convenzioni_prodotti ON pratiche.id_prodotto_convenzione = convenzioni_prodotti.id_convenzione_prodotto WHERE pagato AND attivo AND id_cliente<>'0' AND esportazione_pagamento='0' AND salute_semplice='0'";
	$res0=mysql_query($sql0);
	echo mysql_num_rows($res0);
	exit;
}
if($_POST["action"]=="token"){

    $sql1="SELECT * FROM pratiche_meta WHERE id_pratica = '$_POST[id_pratica]' AND chiave = 'Token'";
    $res1=mysql_query($sql1);
    $rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
    echo $rows1["valore"];
    exit;
}


if($_POST["action"]=="pagato"){

		$sql0="SELECT *, clienti.cognome AS cognome, clienti.nome AS nome, clienti.telefono AS telefono, utenti.nome AS agente, clienti.email AS email, convenzioni_prodotti.id_prodotto AS idProdotto FROM pratiche LEFT JOIN clienti ON pratiche.id_cliente = clienti.id_cliente LEFT JOIN convenzioni_prodotti ON pratiche.id_prodotto_convenzione = convenzioni_prodotti.id_convenzione_prodotto LEFT JOIN convenzioni ON convenzioni.id_convenzione = convenzioni_prodotti.id_convenzione LEFT JOIN utenti ON convenzioni.id_utente = utenti.id_utente WHERE id_pratica='$_POST[id_pratica]'";

		$res0=mysql_query($sql0);
		$rows0=mysql_fetch_array($res0, MYSQL_ASSOC);

		$sqlp="SELECT *, prodotti_categorie.categoria AS categoriaProdotto FROM prodotti LEFT JOIN prodotti_categorie ON prodotti_categorie.id_categoria = prodotti.categoria WHERE id_prodotto = '$rows0[idProdotto]'";
		$resp=mysql_query($sqlp);
		$rowsp=mysql_fetch_array($resp, MYSQL_ASSOC);

		$prodotto = utf8_encode($rowsp["prodotto"]." ".$rowsp["categoriaProdotto"]);

		$sql2="SELECT * FROM prodotti_convenzione_meta WHERE id_prodotto_convenzione='$rows0[id_convenzione_prodotto]' AND chiave='BCC'";
		$res2=mysql_query($sql2);
		$rows2=mysql_fetch_array($res2, MYSQL_ASSOC);
		$bcc=$rows2["valore"];

		$sql2="SELECT * FROM prodotti_convenzione_meta WHERE id_prodotto_convenzione='$rows0[id_convenzione_prodotto]' AND chiave='Validita'";
		$res2=mysql_query($sql2);
		$rows2=mysql_fetch_array($res2, MYSQL_ASSOC);

		$data_scadenza=date("Y-m-d H:i", strtotime("now +".$rows2["valore"]." months"));


        //SELEZIONE AMBULATORIO 

		if($rows0["ambulatorio"]!=""){
			$sqla="SELECT * FROM anagraficastruttura WHERE IdAnagraficaStruttura = '$rows0[ambulatorio]'";
			$resa=mysql_query($sqla);
			$rowsa=mysql_fetch_array($resa, MYSQL_ASSOC);
			$ambulatorio = utf8_encode($rowsa["RagioneSocialeStruttura"]." ".$rowsa["IndirizzoOperativaStruttura"]." ".$rowsa["CittaOperativaStruttura"]);

		}

		//SELEZIONE AGENTE 

		$sqlagente="SELECT nome FROM utenti  WHERE id_utente = '$rows0[id_utente]'";
		$resagente=mysql_query($sqlagente);
		$rowsagente=mysql_fetch_array($resagente, MYSQL_ASSOC);

		$agente=$rowsagente["nome"];

				$sql="UPDATE pratiche SET pagato='1', data_pagamento='".date("Y-m-d H:i", strtotime("now"))."',data_attivazione='".date("Y-m-d H:i", strtotime("now"))."', data_scadenza='$data_scadenza' WHERE id_pratica='$rows0[id_pratica]'";
				$res=mysql_query($sql);
		$messaggio=utf8_decode($rows0["testo_mail_prodotto"]);
		
		if($rows0["indirizzo_mittente"]!="") $p_smtp_mittente_email=$rows0["indirizzo_mittente"];
		if($rows0["nome_mittente"]!="") $p_smtp_mittente_email=$rows0["nome_mittente"];
		
		
		$campi=array("{CLIENTE}","{PRODOTTO}","{LINK}","{CODICEATTIVAZIONE}","{EMAIL}","{TELEFONO}","{LABORATORIOSYNLAB}","{AGENTE}");
	
		$link="https://www.salute-semplice.it/gestionale/pdf/download.php?codice_attivazione=".$rows0["codice_attivazione"];

		$valori=array(stripslashes($rows0["cognome"]." ".$rows0["nome"]),$prodotto, $link,$rows0["codice_attivazione"],$rows0["email"],$rows0["telefono"],$ambulatorio,$agente);
				
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
		$mail->Subject="Il tuo acquisto Salute Semplice";
		$mail->AddAddress($rows0["email"], stripslashes($rows0["nome"]." ".$rows0["cognome"]));

		if($bcc!="") $mail->AddBCC($bcc);

		 if($rows0["ambulatorio"]!=""){
		 		$mail->AddAddress("marianna.maida@synlab.it");
				$mail->AddAddress("igor.schiavon@synlab.it");
				$mail->AddAddress("info@migliorsalute.it");
			}

		
		if ($mail->Send()) {
			$mail->ClearAddresses();
			echo "OK";	
			}
		exit;
}


if($_POST["action"]=="invia_card"){
	$sql0="SELECT *, clienti.cognome AS cognome, clienti.nome AS nome, clienti.telefono AS telefono, utenti.nome AS agente, clienti.email AS email, convenzioni_prodotti.id_prodotto AS idProdotto FROM pratiche LEFT JOIN clienti ON pratiche.id_cliente = clienti.id_cliente LEFT JOIN convenzioni_prodotti ON pratiche.id_prodotto_convenzione = convenzioni_prodotti.id_convenzione_prodotto LEFT JOIN convenzioni ON convenzioni.id_convenzione = convenzioni_prodotti.id_convenzione LEFT JOIN utenti ON convenzioni.id_utente = utenti.id_utente WHERE id_pratica='$_POST[id_pratica]'";

		$res0=mysql_query($sql0);
		$rows0=mysql_fetch_array($res0, MYSQL_ASSOC);

		$sql2="SELECT * FROM prodotti_convenzione_meta WHERE id_prodotto_convenzione='$rows0[id_convenzione_prodotto]' AND chiave='BCC'";
		$res2=mysql_query($sql2);
		$rows2=mysql_fetch_array($res2, MYSQL_ASSOC);
		$bcc=$rows2["valore"];

		$sqlp="SELECT *, prodotti_categorie.categoria AS categoriaProdotto FROM prodotti LEFT JOIN prodotti_categorie ON prodotti_categorie.id_categoria = prodotti.categoria WHERE id_prodotto = '$rows0[idProdotto]'";
		$resp=mysql_query($sqlp);
		$rowsp=mysql_fetch_array($resp, MYSQL_ASSOC);

		$prodotto = utf8_encode($rowsp["prodotto"]." ".$rowsp["categoriaProdotto"]);
		$messaggio=utf8_decode($rows0["testo_mail_prodotto"]);

		if($rows0["indirizzo_mittente"]!="") $p_smtp_mittente_email=$rows0["indirizzo_mittente"];
		if($rows0["nome_mittente"]!="") $p_smtp_mittente_email=$rows0["nome_mittente"];

		 //SELEZIONE AMBULATORIO 

		if($rows0["ambulatorio"]!=""){
			$sqla="SELECT * FROM anagraficastruttura WHERE IdAnagraficaStruttura = '$rows0[ambulatorio]'";
			$resa=mysql_query($sqla);
			$rowsa=mysql_fetch_array($resa, MYSQL_ASSOC);
			$ambulatorio = utf8_encode($rowsa["RagioneSocialeStruttura"]." ".$rowsa["IndirizzoOperativaStruttura"]." ".$rowsa["CittaOperativaStruttura"]);

		}

		//SELEZIONE AGENTE 

		$sqlagente="SELECT nome FROM utenti  WHERE id_utente = '$rows0[id_utente]'";
		$resagente=mysql_query($sqlagente);
		$rowsagente=mysql_fetch_array($resagente, MYSQL_ASSOC);

		$agente=$rowsagente["nome"];

		
		$campi=array("{CLIENTE}","{PRODOTTO}","{LINK}","{CODICEATTIVAZIONE}","{EMAIL}","{TELEFONO}","{LABORATORIOSYNLAB}","{AGENTE}");
	
		$link="https://www.salute-semplice.it/gestionale/pdf/download.php?codice_attivazione=".$rows0["codice_attivazione"];

		$valori=array(stripslashes($rows0["cognome"]." ".$rows0["nome"]),$prodotto, $link,$rows0["codice_attivazione"],$rows0["email"],$rows0["telefono"],$ambulatorio,$agente);
				
		$messaggio=str_replace($campi,$valori,$messaggio);
		//echo $messaggio;		
			$mail=new PHPMailer();
			$mail->IsSMTP();
			$mail->SMTPAuth = true; // turn on SMTP authentication
			$mail->Username = $p_smtp_user; // SMTP username
			$mail->Password = $p_smtp_password; // SMTP password
			$mail->Host=$p_smtp_server;
			$mail->From=$p_smtp_mittente_email;
			$mail->FromName=$p_smtp_mittente;
			$mail->Port=465;
		$mail->SMTPSecure="ssl";
			$mail->MsgHTML($messaggio);

			$mail->AltBody=strip_tags(html_entity_decode($messaggio));
			$mail->Subject="Il tuo acquisto Salute Semplice";
			$mail->AddAddress($rows0["email"], stripslashes($rows0["nome"]." ".$rows0["cognome"]));
			if($bcc!="") $mail->AddBCC($bcc);


		 if($rows0["ambulatorio"]!=""){
		 		$mail->AddAddress("marianna.maida@synlab.it");
				$mail->AddAddress("igor.schiavon@synlab.it");
				$mail->AddAddress("info@migliorsalute.it");
			}

			if ($mail->Send()) {
				$mail->ClearAddresses();
				echo "OK";	
			}
		exit;

}
if($_POST["action"]=="esportazione"){
	$sql="SELECT *, clienti.cognome AS cognome, clienti.nome AS nome, utenti.nome AS agente, clienti.email AS email FROM pratiche LEFT JOIN clienti ON pratiche.id_cliente = clienti.id_cliente LEFT JOIN convenzioni_prodotti ON pratiche.id_prodotto_convenzione = convenzioni_prodotti.id_convenzione_prodotto LEFT JOIN convenzioni ON convenzioni.id_convenzione = convenzioni_prodotti.id_convenzione LEFT JOIN utenti ON convenzioni.id_utente = utenti.id_utente WHERE utenti.id_utente='$_SESSION[id_utente]' AND pratiche.pagato AND pratiche.attivo AND pratiche.fatturato='0'";
	$res=mysql_query($sql);

	if($num=mysql_num_rows($res)>0) echo "OK";
	exit;
}


if($_POST["action"]=="esporta_pagamenti"){



	$sql0="SELECT * FROM pratiche LEFT JOIN convenzioni_prodotti ON pratiche.id_prodotto_convenzione = convenzioni_prodotti.id_convenzione_prodotto WHERE pagato AND attivo AND id_cliente<>'0' AND salute_semplice='0' AND esportazione_pagamento='0'";
	$res0=mysql_query($sql0);
	if(mysql_num_rows($res0)>0):

	$sql="INSERT INTO esportazioni (esportazione, processato) VALUES ('".date("Y-m-d H:i:s", strtotime("now"))."','0')";
	$res=mysql_query($sql);
	
	$id=mysql_insert_id();

	//Cerco tutte le pratiche pagate non esportate fino al timestamp di questa azione


	$sql1="UPDATE pratiche SET esportazione_pagamento='$id' WHERE pagato AND attivo AND id_cliente <> '0' AND esportazione_pagamento='0'";
	$res1=mysql_query($sql1);

	echo $id;

	endif;
	
	exit;
}
?>