<?php 
include("../includes/mysql.inc.php");
include("../includes/mysqli.inc.php");
include("../includes/functions.php");
require("../PHPMailer/class.phpmailer.php"); // Gestione email 
require("../PHPMailer/class.smtp.php"); // Gestione email 
require("../includes/parameters.php");
require("../libraries/func.getinclude.php"); // Gestione inclusione file 


	$sql="SELECT * FROM elenchi_cherry";
	$res=mysql_query($sql);
	$oggetto="Errata corrige - Novità per i clienti CherryBox";
	while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){
		$messaggio=utf8_decode(get_include_contents("../templates/migliorsalutesorriso_finecherrybox.html"));
	
		$nominativo=$rows["nome"]." ".$rows["cognome"];
		$email=$rows["email"];
		
		$campi=array("{CLIENTE}");
	
		$valori=array(stripslashes($rows["nome"]." ".$rows["cognome"]));
				
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

		$mail->AltBody=strip_tags(html_entity_decode($messaggio));
		$mail->Subject=utf8_decode($oggetto);
		$mail->AddAddress($email, stripslashes($nominativo));
		//$mail->AddAddress("luca.merli84@gmail.com", stripslashes($nominativo));
		
		
		if ($mail->Send()) {
			$mail->ClearAddresses();
		}
	}

?>
