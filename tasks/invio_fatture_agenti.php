<?php include("../includes/parameters.php");?>
<?php include("../includes/functions.php");?>
<?php include("../includes/getinclude.php");?>
<?php include("../includes/mysql.inc.php");?>
<?php require("../PHPMailer/class.phpmailer.php"); // Gestione email ?>
<?php require("../PHPMailer/class.smtp.php"); // Gestione email ?>
<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>

<?php $sql="SELECT * FROM pratiche LEFT JOIN convenzioni_prodotti ON pratiche.id_prodotto_convenzione=convenzioni_prodotti.id_convenzione_prodotto LEFT JOIN convenzioni ON convenzioni.id_convenzione = convenzioni_prodotti.id_convenzione WHERE pagato AND pratiche.attivo='1' AND pratiche.id_cliente<>'0' AND fattura='0' AND fatturazione = 'AI' ";
	  $res=mysql_query($sql);
	  while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){

	  	$sql1="SELECT MAX(fattura) AS max FROM pratiche WHERE data_fattura LIKE '".date("Y", strtotime("now"))."%'";
	  	$res1=mysql_query($sql1);
	  	$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
	  	if($rows1["max"]==NULL) $rows1["max"]='0';
	  	echo $sql1;
	  	
	  	$numero_fattura=$rows1["max"]+1;

	  	$sql2="UPDATE pratiche SET fattura ='$numero_fattura', data_fattura = '".date("Y-m-d H:i", strtotime("now"))."' WHERE id_pratica = '$rows[id_pratica]'";
	  	$res2=mysql_query($sql2);

	  	include("../pdf/fattura_agente.php?action=genera&codice_attivazione="+$rows["codice_attivazione"]);

	  	$messaggio=get_include_contents("../templates/migliorsalute_inviofatturaagente.html");
		

		$campi=array("{CLIENTE}","{ACQUISTO}","{LINK}");

		$sql0="SELECT *, prodotti_categorie.categoria AS categoria FROM convenzioni_prodotti LEFT JOIN prodotti ON prodotti.id_prodotto = convenzioni_prodotti.id_prodotto LEFT JOIN prodotti_categorie ON prodotti.categoria = prodotti_categorie.id_categoria WHERE id_convenzione_prodotto = '$rows[id_prodotto_convenzione]'";
		$res0=mysql_query($sql0);
		$rows0=mysql_fetch_array($res0, MYSQL_ASSOC);

		$acquisto = $rows0["prodotto"]." ".$rows0["categoria"]." ".$rows["codice_attivazione"];
	
		$link="http://www.migliorsalute.it/download_fattura_agente.php?codice_attivazione=".$rows["codice_attivazione"];

		$sqla="SELECT * FROM utenti WHERE id_utente = '$rows[id_utente]'";
		$resa=mysql_query($sqla);

		$rowsa=mysql_fetch_array($resa, MYSQL_ASSOC);

		
		$valori=array(stripslashes($rowsa["nome"]),$acquisto, $link);
				
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
			$mail->Subject="La tua fattura Miglior Salute";
			$mail->AddAddress($rowsa["email"], stripslashes($rowsa["nome"]));
			$mail->AddBCC("amministrazione@migliorsalute.it", stripslashes($rowsa["nome"]));
			if ($mail->Send()) {
				$mail->ClearAddresses();
				$sql3="UPDATE pratiche SET invio_fattura='1' WHERE id_pratica='$rows[id_pratica]'";
				$res3=mysql_query($sql3);
			}
	  }
?>